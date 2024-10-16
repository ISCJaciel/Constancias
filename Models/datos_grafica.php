<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "plataformaconstancias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el parámetro de la pregunta del GET
$pregunta = isset($_GET['pregunta']) ? $_GET['pregunta'] : 'pregunta2';

// Consulta SQL para obtener los conteos de respuestas para la pregunta seleccionada
$sql = "SELECT
            SUM(CASE WHEN $pregunta = 'malo' THEN 1 ELSE 0 END) AS Malo,
            SUM(CASE WHEN $pregunta = 'regular' THEN 1 ELSE 0 END) AS Regular,
            SUM(CASE WHEN $pregunta = 'bueno' THEN 1 ELSE 0 END) AS Bueno,
            SUM(CASE WHEN $pregunta = 'excelente' THEN 1 ELSE 0 END) AS Excelente
        FROM encuesta";
        
$result = $conn->query($sql);

$data = array(
    'malo' => 0,
    'regular' => 0,
    'bueno' => 0,
    'excelente' => 0
);

// Procesar resultados
if ($row = $result->fetch_assoc()) {
    $data['malo'] = $row['Malo'];
    $data['regular'] = $row['Regular'];
    $data['bueno'] = $row['Bueno'];
    $data['excelente'] = $row['Excelente'];
}

// Cerrar conexión
$conn->close();

// Enviar datos en formato JSON
echo json_encode($data);
?>
