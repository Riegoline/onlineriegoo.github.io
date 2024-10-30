<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webfresas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT hum_int, hum_amb FROM humedad ORDER BY id_humedad DESC LIMIT 1";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data['hum_int'] = floatval($row['hum_int']);
    $data['hum_amb'] = floatval($row['hum_amb']);
} else {
    $data['hum_int'] = null;
    $data['hum_amb'] = null;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>