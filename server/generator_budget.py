import mysql.connector
import random
from faker import Faker
from datetime import datetime, timedelta

# Initialize Faker
fake = Faker()

# List of project IDs
project_ids = [1, 2, 3, 4, 5]

# MySQL database connection configuration
config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'umltfipg'
}

# Connect to MySQL database
conn = mysql.connector.connect(**config)
cursor = conn.cursor()

# Create the project_fund table if it doesn't exist
cursor.execute('''
CREATE TABLE IF NOT EXISTS project_fund (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    fund DECIMAL(10,2),
    status VARCHAR(255),
    created_at DATE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
)
''')

# Function to generate a random date between start_date and end_date
def generate_random_date(start_date, end_date):
    return start_date + timedelta(days=random.randint(0, (end_date - start_date).days))

# Function to insert random budget data
def insert_random_budget_data(project_id, num_entries):
    for _ in range(num_entries):
        fund = round(random.uniform(1000, 100000), 2)  # Random fund amount between 1000 and 100000
        status = random.choice(['APPROVED', 'REJECTED', 'POSTPONE'])
        created_at = generate_random_date(datetime(2010, 1, 1), datetime(2023, 12, 31)).strftime('%Y-%m-%d')

        cursor.execute('''
        INSERT INTO project_fund (project_id, fund, status, created_at)
        VALUES (%s, %s, %s, %s)
        ''', (project_id, fund, status, created_at))

# Generate data for each project
for project_id in project_ids:
    insert_random_budget_data(project_id, 600)  # Generating 50 entries per project

# Commit the transaction and close the connection
conn.commit()
conn.close()
