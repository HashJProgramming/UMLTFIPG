import datetime
import pandas as pd
import numpy as np
from sklearn.linear_model import LinearRegression
from flask import Flask, request, jsonify, render_template, Response, send_file
import socket
from sklearn.model_selection import train_test_split
import json
import matplotlib.pyplot as plt
import mysql.connector
from flask_cors import CORS

app = Flask(__name__)

CORS(app)

def database_connect():
    db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="umltfipg")
    cursor = db.cursor()
    return db, cursor

# @app.route('/predicted_population/<int:year_to_predict>', methods=['GET'])
# def get_predicted_population(year_to_predict):
#     query = "SELECT purok, YEAR(created_at) AS year, COUNT(*) AS count FROM residents GROUP BY purok, YEAR(created_at)"
#     db, cursor = database_connect()
#     cursor.execute(query)
#     data = cursor.fetchall()
#     df = pd.DataFrame(data, columns=['purok', 'year', 'count'])
#     predicted_population_all_puroks = []
#     for purok in df['purok'].unique():
#         purok_df = df[df['purok'] == purok]
#         X_train, X_test, y_train, y_test = train_test_split(purok_df[['year']], purok_df['count'], test_size=0.2, random_state=42)
#         regression = LinearRegression()
#         regression.fit(X_train, y_train)
#         predicted_population_purok = regression.predict([[year_to_predict]])
#         predicted_population_all_puroks.append({
#             'purok': purok,
#             'predicted_population': int(purok_df['count'].sum() + predicted_population_purok[0]),
#             'population_count': int(purok_df['count'].sum())
#         })
#     print(f"Predicted population for year {year_to_predict}: {predicted_population_all_puroks}")
#     cursor.close()
#     db.close()
#     return jsonify({'predicted_population': predicted_population_all_puroks})









@app.route('/predicted_population/<int:year_to_predict>', methods=['GET'])
def get_predicted_population(year_to_predict):
    query = """
    SELECT 
        purok, 
        YEAR(created_at) AS year, 
        COUNT(*) AS count,
        SUM(CASE WHEN sex = 'male' THEN 1 ELSE 0 END) AS male_count,
        SUM(CASE WHEN sex = 'female' THEN 1 ELSE 0 END) AS female_count
    FROM residents 
    GROUP BY purok, YEAR(created_at)
    """
    db, cursor = database_connect()
    cursor.execute(query)
    data = cursor.fetchall()
    df = pd.DataFrame(data, columns=['purok', 'year', 'count', 'male_count', 'female_count'])

    predicted_population_all_puroks = []

    for purok in df['purok'].unique():
        purok_df = df[df['purok'] == purok]
        
        X_train, X_test, y_train, y_test = train_test_split(
            purok_df[['year']], 
            purok_df['count'], 
            test_size=0.2, 
            random_state=42
        )
        regression = LinearRegression()
        regression.fit(X_train, y_train)
        predicted_population_purok = regression.predict([[year_to_predict]])

        X_train_male, X_test_male, y_train_male, y_test_male = train_test_split(
            purok_df[['year']], 
            purok_df['male_count'], 
            test_size=0.2, 
            random_state=42
        )
        regression_male = LinearRegression()
        regression_male.fit(X_train_male, y_train_male)
        predicted_male_population = regression_male.predict([[year_to_predict]])

        X_train_female, X_test_female, y_train_female, y_test_female = train_test_split(
            purok_df[['year']], 
            purok_df['female_count'], 
            test_size=0.2, 
            random_state=42
        )
        regression_female = LinearRegression()
        regression_female.fit(X_train_female, y_train_female)
        predicted_female_population = regression_female.predict([[year_to_predict]])

        predicted_population_all_puroks.append({
            'purok': purok,
            'predicted_population': int(purok_df['count'].sum()) + int(predicted_population_purok[0]),
            'population_count': int(purok_df['count'].sum()),
            'growth_rate': regression.coef_[0],
            'total_male': int(purok_df['male_count'].sum()),
            'total_female': int(purok_df['female_count'].sum()),
            'predicted_male_population': int(purok_df['male_count'].sum()) + int(predicted_male_population[0]),
            'predicted_female_population': int(purok_df['female_count'].sum()) + int(predicted_female_population[0])
        })

    cursor.close()
    db.close()
    
    return jsonify({'predicted_population': predicted_population_all_puroks})














# @app.route('/predicted_population/<int:year_to_predict>', methods=['GET'])
# def get_predicted_population(year_to_predict):
#     query = """
#     SELECT 
#         purok, 
#         YEAR(created_at) AS year, 
#         COUNT(*) AS count,
#         SUM(CASE WHEN sex = 'male' THEN 1 ELSE 0 END) AS male_count,
#         SUM(CASE WHEN sex = 'female' THEN 1 ELSE 0 END) AS female_count
#     FROM residents 
#     GROUP BY purok, YEAR(created_at)
#     """
#     db, cursor = database_connect()
#     cursor.execute(query)
#     data = cursor.fetchall()
#     df = pd.DataFrame(data, columns=['purok', 'year', 'count', 'male_count', 'female_count'])

#     predicted_population_all_puroks = []

#     for purok in df['purok'].unique():
#         purok_df = df[df['purok'] == purok]
        
#         if len(purok_df) < 2:
#             # If there's not enough data to perform a train-test split, skip or handle differently
#             predicted_population_all_puroks.append({
#                 'purok': purok,
#                 'predicted_population': None,
#                 'population_count': int(purok_df['count'].sum()),
#                 'growth_rate': None,
#                 'total_male': int(purok_df['male_count'].sum()),
#                 'total_female': int(purok_df['female_count'].sum()),
#                 'predicted_male_population': None,
#                 'predicted_female_population': None
#             })
#             continue

#         X_train, X_test, y_train, y_test = train_test_split(
#             purok_df[['year']], 
#             purok_df['count'], 
#             test_size=0.2, 
#             random_state=42
#         )
#         regression = LinearRegression()
#         regression.fit(X_train, y_train)
#         predicted_population_purok = regression.predict([[year_to_predict]])

#         X_train_male, X_test_male, y_train_male, y_test_male = train_test_split(
#             purok_df[['year']], 
#             purok_df['male_count'], 
#             test_size=0.2, 
#             random_state=42
#         )
#         regression_male = LinearRegression()
#         regression_male.fit(X_train_male, y_train_male)
#         predicted_male_population = regression_male.predict([[year_to_predict]])

#         X_train_female, X_test_female, y_train_female, y_test_female = train_test_split(
#             purok_df[['year']], 
#             purok_df['female_count'], 
#             test_size=0.2, 
#             random_state=42
#         )
#         regression_female = LinearRegression()
#         regression_female.fit(X_train_female, y_train_female)
#         predicted_female_population = regression_female.predict([[year_to_predict]])

#         predicted_population_all_puroks.append({
#             'purok': purok,
#             'predicted_population': int(purok_df['count'].sum()) + int(predicted_population_purok[0]),
#             'population_count': int(purok_df['count'].sum()),
#             'growth_rate': regression.coef_[0],
#             'total_male': int(purok_df['male_count'].sum()),
#             'total_female': int(purok_df['female_count'].sum()),
#             'predicted_male_population': int(purok_df['male_count'].sum()) + int(predicted_male_population[0]),
#             'predicted_female_population': int(purok_df['female_count'].sum()) + int(predicted_female_population[0])
#         })

#     cursor.close()
#     db.close()
    
#     return jsonify({'predicted_population': predicted_population_all_puroks})







@app.route('/predicted_population_entire_purok/<int:year_to_predict>/', methods=['GET'])
def get_predicted_population_entire_purok(year_to_predict):
    query = "SELECT YEAR(created_at) AS year, COUNT(*) AS count FROM residents GROUP BY YEAR(created_at)"
    db, cursor = database_connect()
    cursor.execute(query)
    data = cursor.fetchall()
    df = pd.DataFrame(data, columns=['year', 'count'])
    X_train, X_test, y_train, y_test = train_test_split(df[['year']], df['count'], test_size=0.2, random_state=42)
    regression = LinearRegression()
    regression.fit(X_train, y_train)
    predicted_population = regression.predict([[year_to_predict]])
    growth_rate = regression.coef_[0]
    population_count = int(df['count'].sum())
    print(f"Predicted population for the entire purok in year {year_to_predict}: {predicted_population[0]}")
    print(f"Growth rate: {growth_rate}")
    cursor.close()
    db.close()
    return jsonify({
        'predicted_population_entire_purok': int(predicted_population[0]),
        'growth_rate': growth_rate,
        'population_count': population_count
    })

@app.route('/predicted_purok/<int:year_to_predict>/<purok_name>', methods=['GET'])
def get_predicted_purok_population(year_to_predict, purok_name):
    query = f"SELECT purok, YEAR(created_at) AS year, COUNT(*) AS count FROM residents WHERE purok = '{purok_name}' GROUP BY purok, YEAR(created_at)"
    db, cursor = database_connect()
    cursor.execute(query)
    data = cursor.fetchall()
    df = pd.DataFrame(data, columns=['purok', 'year', 'count'])
    predicted_population_all_puroks = []
    for purok in df['purok'].unique():
        purok_df = df[df['purok'] == purok]
        X_train, X_test, y_train, y_test = train_test_split(purok_df[['year']], purok_df['count'], test_size=0.2, random_state=42)
        regression = LinearRegression()
        regression.fit(X_train, y_train)
        predicted_population_purok = regression.predict([[year_to_predict]])
        predicted_population_all_puroks.append({
            'purok': purok,
            'predicted_population': int(predicted_population_purok[0]),
            'population_count': int(purok_df['count'].sum())
        })
    print(f"Predicted population for year {year_to_predict}: {predicted_population_all_puroks}")
    cursor.close()
    db.close()
    return jsonify({'predicted_population': predicted_population_all_puroks})




@app.route('/predicted_purok_sex', methods=['POST'])
def get_predicted_purok_population_sex():
    try:
        data = request.get_json()
        if not data or 'start_date' not in data or 'end_date' not in data or 'purok_name' not in data:
            return jsonify({'error': 'Invalid input'}), 400
        
        start_date = data['start_date']
        end_date = data['end_date']
        purok_name = data['purok_name']
        
        # Extract the year from end_date
        year_to_predict = datetime.datetime.strptime(end_date, "%Y-%m-%d").year + 1
        
        query = """
        SELECT purok, YEAR(created_at) AS year, sex, COUNT(*) AS count 
        FROM residents 
        WHERE purok = %s AND created_at BETWEEN %s AND %s
        GROUP BY purok, YEAR(created_at), sex
        """
        
        db, cursor = database_connect()
        cursor.execute(query, (purok_name, start_date, end_date))
        data = cursor.fetchall()
        df = pd.DataFrame(data, columns=['purok', 'year', 'sex', 'count'])
        
        predicted_population_all_puroks = []
        
        for purok in df['purok'].unique():
            for sex in df['sex'].unique():
                purok_sex_df = df[(df['purok'] == purok) & (df['sex'] == sex)]
                
                if len(purok_sex_df) < 2:
                    predicted_population_all_puroks.append({
                        'purok': purok,
                        'sex': sex,
                        'predicted_population': None,
                        'population_count': int(purok_sex_df['count'].sum())
                    })
                    continue

                X_train, X_test, y_train, y_test = train_test_split(
                    purok_sex_df[['year']], 
                    purok_sex_df['count'], 
                    test_size=0.2, 
                    random_state=42
                )
                regression = LinearRegression()
                regression.fit(X_train, y_train)
                predicted_population_purok_sex = regression.predict([[year_to_predict]])

                predicted_population_all_puroks.append({
                    'purok': purok,
                    'sex': sex,
                    'predicted_population': int(purok_sex_df['count'].sum() + predicted_population_purok_sex[0]),
                    'population_count': int(purok_sex_df['count'].sum())
                })
        
        cursor.close()
        db.close()
        
        return jsonify({'predicted_population': predicted_population_all_puroks})
    
    except Exception as ex:
        return jsonify({'error': str(ex)})


# @app.route('/predicted_purok_sex', methods=['POST'])
# def get_predicted_purok_population_sex():
#     try:
#         data = request.get_json()
#         if not data or 'start_date' not in data or 'end_date' not in data:
#             return jsonify({'error': 'Invalid input'}), 400
        
#         query = f"""
#         SELECT purok, YEAR(created_at) AS year, sex, COUNT(*) AS count 
#         FROM residents 
#         WHERE purok = '{data['purok_name']}' AND created_at BETWEEN '{data['start_date']}' AND '{data['end_date']}'
#         GROUP BY purok, YEAR(created_at), sex
#         """
#         db, cursor = database_connect()
#         cursor.execute(query)
#         data = cursor.fetchall()
#         df = pd.DataFrame(data, columns=['purok', 'year', 'sex', 'count'])
        
#         predicted_population_all_puroks = []
#         for purok in df['purok'].unique():
#             for sex in df['sex'].unique():
#                 purok_sex_df = df[(df['purok'] == purok) & (df['sex'] == sex)]
#                 if not purok_sex_df.empty:
#                     X_train, X_test, y_train, y_test = train_test_split(purok_sex_df[['year']], purok_sex_df['count'], test_size=0.2, random_state=42)
#                     regression = LinearRegression()
#                     regression.fit(X_train, y_train)
#                     predicted_population_purok_sex = regression.predict([data['year_to_predict']])
#                     predicted_population_all_puroks.append({
#                         'purok': purok,
#                         'sex': sex,
#                         'predicted_population': int(purok_sex_df['count'].sum() + predicted_population_purok_sex[0]),
#                         'population_count': int(purok_sex_df['count'].sum())
#                     })
        
#         cursor.close()
#         db.close()
#         return jsonify({'predicted_population': predicted_population_all_puroks})
#     except Exception as ex:
#         return jsonify({'error': str(ex)})
    
# @app.route('/test', methods=['POST'])
# def test():
#     return request.get_json()

# @app.route('/predicted_purok/<int:year_to_predict>/<purok_name>', methods=['GET'])
# def get_predicted_purok_population(year_to_predict, purok_name):
#     query = """
#     SELECT purok, YEAR(created_at) AS year, COUNT(*) AS count 
#     FROM residents 
#     WHERE purok = %s 
#     GROUP BY purok, YEAR(created_at)
#     """
#     db, cursor = database_connect()
#     cursor.execute(query, (purok_name,))
#     data = cursor.fetchall()
#     df = pd.DataFrame(data, columns=['purok', 'year', 'count'])
    
#     predicted_population_all_puroks = []

#     for purok in df['purok'].unique():
#         purok_df = df[df['purok'] == purok]
        
#         if len(purok_df) < 2:
#             predicted_population_all_puroks.append({
#                 'purok': purok,
#                 'predicted_population': None,
#                 'population_count': int(purok_df['count'].sum())
#             })
#             continue

#         X_train, X_test, y_train, y_test = train_test_split(
#             purok_df[['year']], 
#             purok_df['count'], 
#             test_size=0.2, 
#             random_state=42
#         )
#         regression = LinearRegression()
#         regression.fit(X_train, y_train)
#         predicted_population_purok = regression.predict([[year_to_predict]])

#         predicted_population_all_puroks.append({
#             'purok': purok,
#             'predicted_population': int(predicted_population_purok[0]),
#             'population_count': int(purok_df['count'].sum())
#         })
    
#     cursor.close()
#     db.close()
    
#     return jsonify({'predicted_population': predicted_population_all_puroks})

# @app.route('/predicted_purok_sex/<int:year_to_predict>/<purok_name>', methods=['GET'])
# def get_predicted_purok_population_sex(year_to_predict, purok_name):
#     query = """
#     SELECT purok, YEAR(created_at) AS year, sex, COUNT(*) AS count 
#     FROM residents 
#     WHERE purok = %s 
#     GROUP BY purok, YEAR(created_at), sex
#     """
#     db, cursor = database_connect()
#     cursor.execute(query, (purok_name,))
#     data = cursor.fetchall()
#     df = pd.DataFrame(data, columns=['purok', 'year', 'sex', 'count'])
    
#     predicted_population_all_puroks = []

#     for purok in df['purok'].unique():
#         for sex in df['sex'].unique():
#             purok_sex_df = df[(df['purok'] == purok) & (df['sex'] == sex)]
            
#             if len(purok_sex_df) < 2:
#                 predicted_population_all_puroks.append({
#                     'purok': purok,
#                     'sex': sex,
#                     'predicted_population': None,
#                     'population_count': int(purok_sex_df['count'].sum())
#                 })
#                 continue

#             X_train, X_test, y_train, y_test = train_test_split(
#                 purok_sex_df[['year']], 
#                 purok_sex_df['count'], 
#                 test_size=0.2, 
#                 random_state=42
#             )
#             regression = LinearRegression()
#             regression.fit(X_train, y_train)
#             predicted_population_purok_sex = regression.predict([[year_to_predict]])

#             predicted_population_all_puroks.append({
#                 'purok': purok,
#                 'sex': sex,
#                 'predicted_population': int(purok_sex_df['count'].sum() + predicted_population_purok_sex[0]),
#                 'population_count': int(purok_sex_df['count'].sum())
#             })
    
#     cursor.close()
#     db.close()
    
#     return jsonify({'predicted_population': predicted_population_all_puroks})


if __name__ == '__main__':
    computer_name = socket.gethostname()
    print(f"\nSERVER URL: http://{computer_name}.local/UMLTFIPG")
    print(f"LOCALHOST URL: http://localhost/UMLTFIPG")
    app.run(debug=True, host='0.0.0.0')
