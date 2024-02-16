<?php

header("Content-Type: application/json");

function getPastWeatherData()
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
    speed FLOAT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
    $conn->query($sql);

    $query = "SELECT city, temperature, humidity, speed, timestamp FROM weather_data";
    $queryResult = mysqli_query($conn, $query);

    $weatherData = array();
    while ($row = mysqli_fetch_assoc($queryResult)) {
        $weatherData[] = $row;
    }

    return $weatherData;
}
echo json_encode(getPastWeatherData());