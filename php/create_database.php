<?php
require 'utils.php';

$conn = new mysqli($db_host, $db_user, $db_pass);

$sql = "CREATE DATABASE $db_name";


if ($conn->query($sql) === TRUE) {
    echo "Database $db_name created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->close();

$conn = connectTODatabase();

$sql = "CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    phone_number VARCHAR(30) NOT NULL,
    pin VARCHAR (255) NOT NULL,
    reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS phone_numbers (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    phone_number VARCHAR(30) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table phone_numbers created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS messages (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    message VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table messages created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>