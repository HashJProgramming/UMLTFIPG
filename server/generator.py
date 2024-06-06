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
    'Beti', 'Lecuna', 'Macrina', 'Durias',
    'Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6', 'Purok 7',
    'Paghimakas', 'Pagbangon', 'Pag-asa', 'Pagkakaisa', 'Pagpupunyagi', 'Pagmamahal', 'Paglinang', 
    'Paglingap', 'Pagdiriwang', 'Pagkakaisa', 'Masipag', 'Masagana', 'Mataas', 'Matatag', 
    'Maunlad', 'Magalang', 'Magiliw', 'Makisig', 'Malakas', 'Malusog', 'Katapatan', 'Karangalan', 
    'Kagitingan', 'Kalayaan', 'Kabayanihan', 'Kasipagan', 'Kaalaman', 'Kabaitan', 'Kasaysayan', 
    'Katotohanan', 'Dalandan', 'Kalabasa', 'Pakwan', 'Melon', 'Pinya', 'Saging', 'Lanzones', 
    'Mangosteen', 'Chico', 'Bayabas', 'Kalapati', 'Maya', 'Lawin', 'Agila', 'Tagak', 'Ibon', 
    'Pugo', 'Kuwago', 'Itik', 'Bibe', 'Alitaptap', 'Paruparo', 'Tutubi', 'Gagamba', 'Salagubang', 
    'Lamok', 'Bubuyog', 'Tipaklong', 'Langgam', 'Uod', 'Talon', 'Batis', 'Ilog', 'Lawa', 'Sapa', 
    'Bukal', 'Baybay', 'Dalampasigan', 'Tubig', 'Buruwisan', 'Tala', 'Bituin', 'Araw', 'Buwan', 
    'Sinag', 'Kalangitan', 'Alapaap', 'Ulap', 'Silahis', 'Hatinggabi', 'Dagohoy', 'Silang', 'Luna', 
    'Mabini', 'Rizal', 'Bonifacio', 'Sakay', 'Kudarat', 'Tamblot', 'Sulayman', 'Buhay', 'Liwanag', 
    'Tahimik', 'Kapayapaan', 'Pagkakaisa', 'Matatag', 'Malaya', 'Sipag', 'Tiwala', 'Pag-ibig', 
    'Banaba', 'Kamagong', 'Narra', 'Molave', 'Yakal', 'Tindalo', 'Mahogany', 'Gmelina', 'Mangga', 
    'Santol', 'Ilang-ilang', 'Rosas', 'Dama de Noche', 'Rosal', 'Magnolia', 'Camia', 'Santan', 
    'Gumamela', 'Sampaguita', 'Kalachuchi', 'Silangan', 'Kanluran', 'Sikatuna', 'Caraballo', 
    'Pinatubo', 'Apo', 'Sierra Madre', 'Banahaw', 'Makiling', 'Halcon', 'Magsaysay', 'Rizal', 
    'Quezon', 'Mabini', 'Bonifacio', 'Jacinto', 'Luna', 'Burgos', 'Gomburza', 'Del Pilar', 
    'Bulaklak', 'Kaunlaran', 'Kabataan', 'Mayon', 'Waling-waling', 'Sinagtala', 'Lakambini', 
    'Haribon', 'Sampaguita', 'Salamat', 'Maligaya', 'Pag-asa', 'Maharlika', 'Masagana', 'Kalikasan', 
    'Mabuhay', 'Bayanihan', 'Katipunan', 'Luntian', 'Bagong Silang'
]


barangay_list = [
    'Nilo', 'Longmot', 'Caluma', 'Mate', 'Timolan', 'Libayoy', 'Guinlin',
    'Limas', 'Maragang', 'Busol', 'Diana Countryside', 'Lacupayan',
    'Upper Nilo', 'Lacarayan', 'Nangan-Nangan', 'New Tuboran', 'Tigbao'
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
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    middlename VARCHAR(255),
    suffix VARCHAR(255),
    purok VARCHAR(255),
    address VARCHAR(255),
    phone VARCHAR(255),
    sex VARCHAR(255),
    birthdate DATE,
    barangay VARCHAR(255),
    status BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
''')

# Function to generate a random 11-digit phone number
def generate_phone_number():
    return ''.join([str(random.randint(0, 9)) for _ in range(11)])

for _ in range(50000):
    firstname = fake.first_name()
    lastname = fake.last_name()
    middlename = f"generated {random.randint(1, 1000)}"
    purok = random.choice(purok_list)
    barangay = random.choice(barangay_list)
    address = fake.address().replace('\n', ', ')
    phone = generate_phone_number()
    sex = random.choice(['Male', 'Female'])
    birthdate = fake.date_of_birth(minimum_age=18, maximum_age=90).strftime('%Y-%m-%d')
    created_at = fake.date_time_between(start_date=datetime(1990, 1, 1), end_date=datetime(2024, 12, 31)).strftime('%Y-%m-%d %H:%M:%S')
    cursor.execute('''
    INSERT INTO residents (firstname, lastname, middlename, purok, address, phone, sex, birthdate, barangay, created_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    ''', (firstname, lastname, middlename, purok, address, phone, sex, birthdate, barangay, created_at))

# Commit the transaction and close the connection
conn.commit()
conn.close()
