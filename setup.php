<?php

$host = 'localhost';
$username = 'root'; 
$password = ''; 
$dbname = 'sea_logistics_dev';

try {
    $db = new PDO("mysql:host=$host", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("DROP DATABASE IF EXISTS $dbname;");
    $db->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    $db->exec("USE $dbname;");

    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    );");

    $db->exec("CREATE TABLE IF NOT EXISTS ships (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL UNIQUE,
        status VARCHAR(50) NOT NULL
    );");

    $db->exec("CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        file_path VARCHAR(255) DEFAULT NULL,
        ship_id INT,
        FOREIGN KEY (ship_id) REFERENCES ships(id)
    );");

    $db->exec("INSERT IGNORE INTO users (username, password) VALUES
        ('test', '" . password_hash('test', PASSWORD_BCRYPT) . "')");

    $db->exec("INSERT IGNORE INTO ships (name, status) VALUES
        ('Poseidon', 'Dostępny'),
        ('Neptun', 'W naprawie'),
        ('Oceanic', 'W trakcie transportu');");

    $db->exec("INSERT IGNORE INTO orders (title, description, ship_id) VALUES
        ('Transport kontenera', 'Przewóz kontenera z Gdyni do Rotterdamu', 1),
        ('Transport ładunku masowego', 'Ładunek masowy z Singapuru do Gdańska', 2),
        ('Transport samochodów', 'Transport samochodów z Hamburga do Szczecina', 3);");

    echo "Baza danych, tabele i przykładowe dane zostały utworzone pomyślnie!";
} catch (PDOException $e) {
    die("Błąd: " . $e->getMessage());
}
?>