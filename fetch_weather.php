<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

include_once('database.php');

$city = isset($_GET["city"]) ? $_GET['city'] : "Canberra";
$response = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=Canberra&units=metric&appid=cfeaf659bcb84af645946366b3b2938a");

echo $response;

$conn = create_db();

$result = $conn->query("SELECT timestamp FROM weather_data ORDER BY id DESC LIMIT 1");

if (!$result || $result->num_rows === 0) {
    insert_data($response);
} else {
    $row = $result->fetch_assoc();
    $lastTimestamp = strtotime($row['timestamp']);
    $currentTimestamp = time() + (4 * 60 * 60) + (45 * 60);

    // Check if 24 hours have passed
    if (($currentTimestamp - $lastTimestamp) >= (24 * 60 * 60)) {
        insert_data($response);
    }
}