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

$data = [
    "temperatura" => array_fill(0, 5, null),
    "humedadInterna" => array_fill(0, 5, null),
    "humedadExterna" => array_fill(0, 5, null)
];

$currentDay = date('N') - 1; // 0 for Monday, 6 for Sunday

for ($i = 0; $i < 5; $i++) {
    $dayOffset = $i - $currentDay;
    if ($dayOffset <= 0) {
        $sql = "SELECT AVG(temperatura) as temp_avg, AVG(humedad_tierra) as hum_int_avg, AVG(humedad_externa) as hum_ext_avg 
                FROM web_riego 
                WHERE DATE(fecha_hora) = DATE(NOW() + INTERVAL $dayOffset DAY)";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data["temperatura"][$i] = round($row["temp_avg"], 2);
            $data["humedadInterna"][$i] = round($row["hum_int_avg"], 2);
            $data["humedadExterna"][$i] = round($row["hum_ext_avg"], 2);
        }
    }
}

echo json_encode($data);

$conn->close();
?>