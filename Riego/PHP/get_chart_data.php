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

$sql = "SELECT temperatura, humedad_externa, humedad_tierra, DAYOFWEEK(fecha_hora) as dia_semana 
        FROM web_riego 
        WHERE fecha_hora >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        AND WEEKDAY(fecha_hora) BETWEEN 0 AND 4
        ORDER BY fecha_hora DESC 
        LIMIT 5";

$result = $conn->query($sql);

$data = [
    "labels" => [],
    "temperatura" => [],
    "humedadInterna" => [],
    "humedadExterna" => []
];

$dias = ['', 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_unshift($data["labels"], $dias[$row["dia_semana"]]);
        array_unshift($data["temperatura"], $row["temperatura"]);
        array_unshift($data["humedadInterna"], $row["humedad_tierra"]);
        array_unshift($data["humedadExterna"], $row["humedad_externa"]);
    }
}

// Ensure we always have 5 days of data
while (count($data["labels"]) < 5) {
    array_unshift($data["labels"], "");
    array_unshift($data["temperatura"], null);
    array_unshift($data["humedadInterna"], null);
    array_unshift($data["humedadExterna"], null);
}

// Limit to only the last 5 days
$data["labels"] = array_slice($data["labels"], 0, 5);
$data["temperatura"] = array_slice($data["temperatura"], 0, 5);
$data["humedadInterna"] = array_slice($data["humedadInterna"], 0, 5);
$data["humedadExterna"] = array_slice($data["humedadExterna"], 0, 5);

echo json_encode($data);

$conn->close();
?>