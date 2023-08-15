import pandas as pd
import numpy as np
from sklearn.linear_model import LinearRegression
import io
import json
from flask import Flask, request, jsonify, render_template, Response, send_file
import matplotlib.pyplot as plt
app = Flask(__name__)

def selecting_purok(df, purok):
    df = df.loc[df['Purok'] == purok].copy()
    df.drop(['Purok'], axis=1, inplace=True)
    df = df.T
    df.dropna(inplace=True)
    df = df.reset_index()
    return df

def prediction_model(df):
    x = df.iloc[:, 0].values.reshape(-1,1)
    y = df.iloc[:, 1].values.reshape(-1,1)
    model = LinearRegression().fit(x,y)
    return model

def prediction(model, year):
    return int(model.coef_[0][0] * year + model.intercept_[0])

def purok_list_gen(df):
    df.rename(columns={'Purok Name':'Purok'},inplace=True)
    df['Purok'] = df['Purok'].apply(lambda row: row.lower())
    lists = df['Purok'].unique().tolist()
    with open('purok_list.json','w', encoding='utf-8') as f:
        json.dump(lists, f, ensure_ascii=False,indent=4)
    return lists, df

def get_prediction(start_year, end_year):
    df = pd.read_excel('data/pop.xlsx')
    lists, df = purok_list_gen(df)
    all_year_results = []

    for prediction_year in range(start_year, end_year + 1):
        year_result = {
            "Year": prediction_year,
            "PurokResults": []
        }
        for purok in lists:
            df_purok = selecting_purok(df, purok)
            model = prediction_model(df_purok)
            result = prediction(model, prediction_year)
            year_result["PurokResults"].append({'Purok': purok, 'Population': result})

        all_year_results.append(year_result)
    return all_year_results

def generate_bar_plot(start_year, end_year):
    purok_populations = {}
    prediction_results = get_prediction(start_year, end_year)
    for year_result in prediction_results:
        for purok_result in year_result["PurokResults"]:
            purok = purok_result["Purok"]
            population = purok_result["Population"]
            purok_populations.setdefault(purok, []).append(population)
    
    df = pd.DataFrame(purok_populations, index=range(start_year, end_year + 1))
    
    plt.figure(figsize=(16, 12))
    df.plot(kind='bar', figsize=(16, 12))
    plt.title('Population Prediction')
    plt.xlabel('Year')
    plt.ylabel('Population')
    plt.legend()
    
    buf = io.BytesIO()
    plt.savefig(buf, format='png')
    plt.close()
    buf.seek(0)
    return buf

def generate_bar_year(start_year, end_year):
    purok_populations = {}
    prediction_results = get_prediction(start_year, end_year)
    for year_result in prediction_results:
        year = year_result["Year"]
        total_population = sum(purok_result["Population"] for purok_result in year_result["PurokResults"])
        purok_populations[year] = total_population
    
    df = pd.DataFrame(purok_populations.items(), columns=['Year', 'TotalPopulation'])
    
    plt.figure(figsize=(16, 12))
    ax = df.plot(kind='bar', x='Year', y='TotalPopulation', figsize=(16, 12))
    plt.title('Total Population Prediction by Year')
    plt.xlabel('Year')
    plt.ylabel('Total Population')
    plt.legend()
    
    # Annotate each bar with the total population value
    for index, value in enumerate(df['TotalPopulation']):
        ax.annotate(f'Population {value:,}', (index, value), textcoords="offset points", xytext=(0,5), ha='center')
    
    buf = io.BytesIO()
    plt.savefig(buf, format='png')
    plt.close()
    buf.seek(0)
    return buf
    
@app.route('/', methods=['GET']) 
def home():
    start_year = 2028
    end_year = 2028
    results = get_prediction(start_year, end_year)
    return render_template('index.html', results=results)

@app.route('/predict', methods=['POST'])
def predict():
    start_year = int(request.form['start_year'])
    end_year = int(request.form['end_year'])
    return get_prediction(start_year, end_year)

@app.route('/histogram', methods=['POST'])
def graph():
    start_year = int(request.form['start_year'])
    end_year = int(request.form['end_year'])
    buf = generate_bar_plot(start_year, end_year)
    return Response(buf.getvalue(), mimetype='image/png')


@app.route('/bar_chart_image')
def bar_chart():
    start_year = 2023
    end_year = 2024
    image = generate_bar_year(start_year, end_year)
    return send_file(image, mimetype='image/png')


if __name__ =='__main__':  
  app.run(debug=True, host='0.0.0.0')