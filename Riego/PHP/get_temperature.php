<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webfresas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT temperatura FROM temperatura ORDER BY id_temp DESC LIMIT 1";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data['temperature'] = floatval($row['temperatura']);
} else {
    $data['temperature'] = null;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>