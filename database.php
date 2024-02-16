<?php

include_once('fetch_weather.php');

function create_db()
{
    $host = "sql304.infinityfree.com";
    $username = "if0_35926284";
    $password = "GrhFpNnupwRcI";
    $dbname = "if0_35926284_WeatherApp";

    $conn = new mysqli($host, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $conn->query($sql);

    $conn->select_db($dbname);

    $sql = "CREATE TABLE IF NOT EXISTS weather_data (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(50) NOT NULL,
    temperature FLOAT NOT NULL,
    humidity INT NOT NULL,
    wind FLOAT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
    $conn->query($sql);

    return $conn;
}

function insert_data($response)
{
    $conn = create_db();
    $data = json_decode($response, true);

    $city = mysqli_real_escape_string($conn, $data['name']);
    $temperature = round($data['main']['temp']);
    $humidity = round($data['main']['humidity']);
    $wind = round($data['wind']['speed']);
    
    $sql = "INSERT INTO weather_data (city, temperature, humidity, speed)
                VALUES ('$city', $temperature, $humidity, $wind)";

    mysqli_query($conn, $sql);
}