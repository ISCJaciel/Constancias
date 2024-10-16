<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "1234";
$database = "plataformaconstancias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "La conexión falló: " . $conn->connect_error]));
}

$sql = "SELECT c.Celda, cu.nombre_curso, cu.descripcion, cu.costo, cu.ruta, cu.id_grupo, i.nombre_instructor 
        FROM Celdas c
        JOIN Cursos cu ON c.Curso = cu.cursoid
        JOIN Instructor i ON cu.instructor = i.idprofesor";
$result = $conn->query($sql);

$cursos = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cursos[] = $row;
    }
}

echo json_encode($cursos);

$conn->close();
?>
