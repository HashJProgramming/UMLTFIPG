import datetime
import pandas as pd
import numpy as np
from sklearn.linear_model import LinearRegression
import io
import os
import json
from flask import Flask, request, jsonify, render_template, Response, send_file
import matplotlib.pyplot as plt

my_path = os.path.abspath(os.path.dirname(__file__))
budget_path = pd.read_excel(f'{my_path}/data/budget.xlsx')
population_path = pd.read_excel(f'{my_path}/data/population.xlsx')
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

def selecting_project(df, project):
    df = df.loc[df['Project'] == project].copy()
    df.drop(['Project'], axis=1, inplace=True)
    df = df.T
    df.dropna(inplace=True)
    df = df.reset_index()
    return df

def project_list_gen(df):
    df.rename(columns={'Project Name':'Project'},inplace=True)
    df['Project'] = df['Project'].apply(lambda row: row.lower())
    lists = df['Project'].unique().tolist()
    with open(f'{my_path}/project_list.json','w', encoding='utf-8') as f:
        json.dump(lists, f, ensure_ascii=False,indent=4)
    return lists, df

def get_budget_prediction(start_year, end_year):
    df = budget_path
    lists, df = project_list_gen(df)
    all_year_results = []

    for prediction_year in range(start_year, end_year + 1):
        year_result = {
            "Year": prediction_year,
            "ProjectResult": []
        }
        for project in lists:
            df_purok = selecting_project(df, project)
            model = prediction_model(df_purok)
            result = prediction(model, prediction_year)
            year_result["ProjectResult"].append({'Project': project, 'Fund': result})

        all_year_results.append(year_result)
    return all_year_results

def selecting_purok(df, purok):
    df = df.loc[df['Purok'] == purok].copy()
    df.drop(['Purok'], axis=1, inplace=True)
    df = df.T
    df.dropna(inplace=True)
    df = df.reset_index()
    return df

def purok_list_gen(df):
    df.rename(columns={'Purok Name':'Purok'},inplace=True)
    df['Purok'] = df['Purok'].apply(lambda row: row.lower())
    lists = df['Purok'].unique().tolist()
    with open(f'{my_path}/purok_list.json','w', encoding='utf-8') as f:
        json.dump(lists, f, ensure_ascii=False,indent=4)
    return lists, df

def get_population_prediction(start_year, end_year):
    df = population_path
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

def generate_population_bar_plot(start_year, end_year):
    purok_populations = {}
    prediction_results = get_population_prediction(start_year, end_year)
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

def generate_budget_bar_plot(start_year, end_year):
    project_fund = {}
    prediction_results = get_budget_prediction(start_year, end_year)
    for year_result in prediction_results:
        for project_result in year_result["ProjectResult"]:
            project_name = project_result["Project"]
            fund = project_result["Fund"]
            project_fund.setdefault(project_name, []).append(fund)
    
    df = pd.DataFrame(project_fund, index=range(start_year, end_year + 1))
    
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
    prediction_results = get_population_prediction(start_year, end_year)
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
    
@app.route('/population', methods=['GET']) 
def population():
    start_year = 2028
    end_year = 2028
    results = get_population_prediction(start_year, end_year)
    return render_template('population.html', results=results)

@app.route('/budget', methods=['GET']) 
def budget():
    start_year = 2028
    end_year = 2028
    results = get_budget_prediction(start_year, end_year)
    return render_template('budget.html', results=results)

@app.route('/population-predict', methods=['POST'])
def predict_population():
    start_year = int(request.form['start_year'])
    end_year = int(request.form['end_year'])
    return render_template('population-datatable.html', results=get_population_prediction(start_year, end_year))

@app.route('/budget-predict', methods=['POST'])
def predict_budget():
    start_year = int(request.form['start_year'])
    end_year = int(request.form['end_year'])
    return render_template('budget-datatable.html', results=get_budget_prediction(start_year, end_year))

@app.route('/population-histogram', methods=['POST'])
def graph_population():
    start_year = int(request.form['start_year'])
    end_year = int(request.form['end_year'])
    buf = generate_population_bar_plot(start_year, end_year)
    return Response(buf.getvalue(), mimetype='image/png')

@app.route('/budget-histogram', methods=['POST'])
def graph_budget():
    start_year = int(request.form['start_year'])
    end_year = int(request.form['end_year'])
    buf = generate_budget_bar_plot(start_year, end_year)
    return Response(buf.getvalue(), mimetype='image/png')

@app.route('/population-bar_chart_image')
def bar_chart_population():
    start_year = 2023
    end_year = 2024
    image = generate_bar_year(start_year, end_year)
    return send_file(image, mimetype='image/png')

@app.route('/budget-print', methods=['GET'])
def budget_print():
    current_year = datetime.datetime.now().year
    return render_template('budget-print.html', results=get_budget_prediction(current_year, current_year + 10))

@app.route('/population-print', methods=['GET'])
def population_print():
    current_year = datetime.datetime.now().year
    return render_template('population-print.html', results=get_population_prediction(current_year, current_year + 10))

if __name__ =='__main__':  
  app.run(debug=True, host='0.0.0.0')