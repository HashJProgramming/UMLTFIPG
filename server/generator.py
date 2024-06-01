import mysql.connector
from faker import Faker
import random
from datetime import datetime

# Initialize Faker
fake = Faker()

# List of purok values
purok_list = [
    'Acasia', 'Imelda I', 'Imelda II', 'Orchids', 'Mendoza', 'Alcantara',
    'Bougainvilla', 'Makugihon', 'Rose', 'Pelagio', 'Enriquez', 'Magsaysay',
    'Gawasnon', 'Boundary', 'Pechay', 'San Francisco', 'Cresencio Sajulga',
    'Beti', 'Lecuna', 'Macrina', 'Durias'
]

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

# Create the residents table if it doesn't exist
cursor.execute('''
CREATE TABLE IF NOT EXISTS residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    middlename VARCHAR(255),
    purok VARCHAR(255),
    address TEXT,
    phone VARCHAR(11),
    sex VARCHAR(6),
    birthdate DATE
)
''')

# Function to generate a random 11-digit phone number
def generate_phone_number():
    return ''.join([str(random.randint(0, 9)) for _ in range(11)])

for _ in range(400000):
    firstname = fake.first_name()
    lastname = fake.last_name()
    middlename = f"generated {random.randint(1, 1000)}"
    purok = random.choice(purok_list)
    address = fake.address().replace('\n', ', ')
    phone = generate_phone_number()
    sex = random.choice(['Male', 'Female'])
    birthdate = fake.date_of_birth(minimum_age=18, maximum_age=90).strftime('%Y-%m-%d')
    created_at = fake.date_time_between(start_date=datetime(1990, 1, 1), end_date=datetime(2024, 12, 31)).strftime('%Y-%m-%d %H:%M:%S')
    cursor.execute('''
    INSERT INTO residents (firstname, lastname, middlename, purok, address, phone, sex, birthdate, created_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
    ''', (firstname, lastname, middlename, purok, address, phone, sex, birthdate, created_at))

# Commit the transaction and close the connection
conn.commit()
conn.close()
