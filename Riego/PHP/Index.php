<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="website icon" type="png" href="../IMG/logo_pagina.png">
</head>
<body>
    <header class="text-white d-flex align-items-center justify-content-between p-3">
        <div class="d-flex align-items-center">
            <a class="nav-link text-white ms-2" href="#">SRA</a>
        </div>
        <nav class="d-none d-md-flex">
            <a href="#inicio" class="nav-link text-white">Inicio</a>
            <a href="#quienes-somos" class="nav-link text-white">Quiénes Somos</a>
            <a href="#contacto" class="nav-link text-white">Contáctanos</a>
        </nav>
        <div class="d-md-none dropdown">
            <button class="btn dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #27ae60;">
                Menú
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#inicio">Inicio</a>
                <a class="dropdown-item" href="#quienes-somos">Quiénes Somos</a>
                <a class="dropdown-item" href="#contacto">Contáctanos</a>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card bg-light h-100">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="container">
                            <div class="clock">
                                <div class="time" id="time">12:25</div>
                                <div class="weather">
                                    <i class="weather-icon">🌧️</i>
                                    <span class="temperature" id="temperature">
                                        <?php
                                     $host = 'bfhcqaz7dcnefult7yo9-mysql.services.clever-cloud.com';
$dbname = 'bfhcqaz7dcnefult7yo9';
$user = 'uhougzfja5rrs8sh';
$password = 'Ma0TA9vRq0YG3hEd7aZE';

// Crear conexión con las credenciales antes configuradas
$conn = new mysqli($host, $user, $password, $dbname);
                                        if ($conn->connect_error) {
                                            die("Conexión fallida: " . $conn->connect_error);
                                        }

                                        $sql = "SELECT temperatura FROM web_riego ORDER BY id DESC LIMIT 1";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            echo $row["temperatura"] . "°C";
                                        } else {
                                            echo "No hay datos";
                                        }

                                        $conn->close();
                                        ?>
                                    </span>
                                </div>
                                <div class="real-feel" id="fecha__completa">29 de septiembre del 2023</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card bg-light h-100">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <main class="container">
                            <h1 class="sr-only">Gráfica de Clima en Tiempo Real</h1>
                            <div id="climate-chart" aria-label="Gráfica interactiva de clima">
                                <svg></svg>
                            </div>
                            <div id="real-time-clock" class="text-center mt-2"></div>
                            <div class="legend" role="list" aria-label="Leyenda de la gráfica">
                                <div class="legend-item" role="listitem" data-line="temperature">
                                    <div class="legend-color temperature-color"></div>
                                    <span class="legend-label" data-type="temperature">Temperatura (°C)</span>
                                </div>
                                <div class="legend-item" role="listitem" data-line="humidity">
                                    <div class="legend-color humidity-color"></div>
                                    <span class="legend-label" data-type="humidity">Interior (%)</span>
                                </div>
                                <div class="legend-item" role="listitem" data-line="ambiente">
                                    <div class="legend-color ambiente-color"></div>
                                    <span class="legend-label" data-type="ambiente">Ambiente (°C)</span>
                                </div>
                            </div>
                            <div id="selected-value" role="status" aria-live="polite">Elija una línea y mire su valor actual</div>
                            <div id="tooltip" class="tooltip" role="tooltip"></div>
                        </main>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button id="toggleButton" style="background: rgba(39, 174, 96, 1); color: white; font-weight: bolder;" onmouseover="this.style.background='#2c3e50'" onmouseout="this.style.background='rgba(39, 174, 96, 1)'" class="btn mb-3">Ver tabla</button>
        </div>

        <h2 class="mt-4" id="tablaTitulo" style="display: none;">Tabla de Datos</h2>

        <div class="table-responsive" id="dataTable" style="display: none;">
            <table class="table border-0">
                <thead>
                    <tr style="color: white; text-align: center; background: rgba(39, 174, 96, 1);">
                        <th>Temperatura</th>
                        <th>Humedad Externa</th>
                        <th>Humedad Tierra</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody class="table-light" style="color: #444; text-align: center;">
                    <?php
                    $host = 'bfhcqaz7dcnefult7yo9-mysql.services.clever-cloud.com';
$dbname = 'bfhcqaz7dcnefult7yo9';
$user = 'uhougzfja5rrs8sh';
$password = 'Ma0TA9vRq0YG3hEd7aZE';

// Crear conexión con las credenciales antes configuradas
$conn = new mysqli($host, $user, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    $sql = "SELECT temperatura, humedad_externa, humedad_tierra, fecha_hora FROM web_riego";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["temperatura"] . "</td>";
                            echo "<td>" . $row["humedad_externa"] . "</td>";
                            echo "<td>" . $row["humedad_tierra"] . "</td>";
                            echo "<td>" . $row["fecha_hora"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No se encontraron resultados</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <h3>Información General</h3>
            <p>Las fresas son una de las frutas más populares y delicadas en el mundo. Requieren condiciones específicas para crecer y prosperar. A continuación, te presento algunos aspectos clave sobre las fresas y su implementación en un sistema de riego automatizado:</p>

            <h4>Requisitos de las fresas</h4>
            <ul>
                <li><strong>Agua:</strong> Las fresas necesitan un suministro constante de agua, pero sin exceso.</li>
                <li><strong>Temperatura:</strong> Temperaturas entre 15°C y 25°C.</li>
                <li><strong>Luz:</strong> Necesitan luz solar moderada.</li>
                <li><strong>Suelo:</strong> Suelos bien drenados y ricos en nutrientes.</li>
            </ul>

            <h4>Sistema de riego automatizado para fresas</h4>
            <ul>
                <li><strong>Sensores de humedad:</strong> Monitorean la humedad del suelo y ajustan el riego según sea necesario.</li>
                <li><strong>Bombas de agua:</strong> Proporcionan agua a las plantas de manera eficiente.</li>
                <li><strong>Electroválvulas:</strong> Controlan el flujo de agua hacia las plantas.</li>
                <li><strong>Programador:</strong> Permite ajustar horarios y cantidad de agua según las necesidades de las plantas.</li>
            </ul>

            <h4>Beneficios del riego automatizado para fresas</h4>
            <ul>
                <li><strong>Ahorro de agua:</strong> Evita el desperdicio de agua.</li>
                <li><strong>Incremento de producción:</strong> Las plantas reciben el agua necesario para crecer.</li>
                <li><strong>Reducción de mano de obra:</strong> El sistema se encarga de regar automáticamente.</li>
                <li><strong>Mejora de la calidad:</strong> Las fresas crecen en condiciones óptimas.</li>
            </ul>

            <h4>Tecnologías utilizadas</h4>
            <ul>
                <li><strong>IoT (Internet de las cosas):</strong> Conecta sensores y electroválvulas para una monitorización remota.</li>
                <li><strong>Sistemas de control:</strong> Software y hardware que regulan el riego.</li>
                <li><strong>Sensores de temperatura y humedad:</strong> Monitorean las condiciones ambientales.</li>
            </ul>

            <h4>Desafíos y consideraciones</h4>
            <ul>
                <li><strong>Calibración:</strong> Ajustar el sistema para las necesidades específicas de las plantas.</li>
                <li><strong>Mantenimiento:</strong> Revisar y reparar el sistema regularmente.</li>
                <li><strong>Costo:</strong> Inversión inicial en equipo y tecnología.</li>
            </ul>

            <p>En resumen, un sistema de riego automatizado para fresas puede mejorar significativamente la producción y calidad de la fruta, siempre y cuando se ajuste a las necesidades específicas de las plantas y se mantenga adecuadamente.</p>
        </div>
    </div>

    <footer class="text-white text-center py-3">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="mb-0">&copy; 2024 CECyGROW. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../JS/index.js"></script>
</body>
</html>