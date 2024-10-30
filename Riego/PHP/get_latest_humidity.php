<?php
$host = 'bfhcqaz7dcnefult7yo9-mysql.services.clever-cloud.com';
$dbname = 'bfhcqaz7dcnefult7yo9';
$user = 'uhougzfja5rrs8sh';
$password = 'Ma0TA9vRq0YG3hEd7aZE';

// Crear conexión con las credenciales antes configuradas
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT humedad_externa, humedad_tierra FROM web_riego ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "humedad_externa" => floatval($row["humedad_externa"]),
        "humedad_tierra" => floatval($row["humedad_tierra"])
    ]);
} else {
    echo json_encode(["error" => "No data found"]);
}

$conn->close();
?>