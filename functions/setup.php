<?php
    $database = 'umltfipg';
    $db = new PDO('mysql:host=localhost', 'root', '');
    $query = "CREATE DATABASE IF NOT EXISTS $database";

    try {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec($query);
        $db->exec("USE $database");

        $db->exec("
            CREATE TABLE IF NOT EXISTS users (
              id INT PRIMARY KEY AUTO_INCREMENT,
              username VARCHAR(255),
              password VARCHAR(255),
              type VARCHAR(255),
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $db->exec("
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
            )
        ");
        
        $db->exec("
              CREATE TABLE IF NOT EXISTS projects (
              id INT PRIMARY KEY AUTO_INCREMENT,
              name VARCHAR(255),
              description VARCHAR(255),
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $db->exec("
            CREATE TABLE IF NOT EXISTS project_fund (
              id INT PRIMARY KEY AUTO_INCREMENT,
              project_id int,
              fund DECIMAL(10,2),
              status VARCHAR(255),
              created_at DATE DEFAULT CURRENT_TIMESTAMP,
              FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
            )
        ");

        $db->exec("
          CREATE TABLE IF NOT EXISTS logs (
            id INT PRIMARY KEY AUTO_INCREMENT,
            logs TEXT,
            type TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
          );
        ");

        $db->exec("

          CREATE VIEW IF NOT EXISTS residents_view_female AS
            SELECT 
                id,
                firstname,
                lastname,
                middlename,
                suffix,
                sex,
                birthdate,
                TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age
            FROM residents
            WHERE sex = 'Female';

          CREATE VIEW IF NOT EXISTS residents_view_male AS
            SELECT 
                id,
                firstname,
                lastname,
                middlename,
                suffix,
                sex,
                birthdate,
                TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age
            FROM residents
            WHERE sex = 'Male';

          CREATE VIEW IF NOT EXISTS residents_view AS
            SELECT 
              `id`,
              `firstname`,
              `lastname`,
              `middlename`, 
              `suffix`, 
              `purok`,
              `barangay`,
              `address`, 
              `phone`, 
              `sex`, 
              `birthdate`,
                CASE WHEN `status` = 1 THEN 'Alive' ELSE 'Deceased' END AS status,
              TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age,
              `created_at`
            FROM `residents`;
            
        ");

        $db->beginTransaction();

        $stmt = $db->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = 'admin'");
        $stmt->execute();
        $userExists = $stmt->fetchColumn();
        
        if (!$userExists) {
            $stmt = $db->prepare("INSERT INTO `users` (`username`, `password`, `type`) VALUES (:username, :password, 'admin')");
            $stmt->bindValue(':username', 'admin');
            $stmt->bindValue(':password', '$2y$10$WgL2d2fzi6IiGiTfXvdBluTLlMroU8zBtIcRut7SzOB6j9i/LbA4K');
            $stmt->execute();
        }
        
        $db->commit();

    } catch(PDOException $e) {
        die("Error creating database: " . $e->getMessage());
    }
    $db = null;
?>