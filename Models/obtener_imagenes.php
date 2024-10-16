<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "plataformaconstancias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

$action = $_GET['action'] ?? ''; // Utilizando el operador de fusión null para manejar valores no establecidos

if ($action == 'informacion') {
    $celda = $_GET['celda'];
    $grupo = $_GET['grupo'];


    $sql = "SELECT c.Celda, cu.nombre_curso, cu.descripcion, cu.costo, cu.nombre_imagen, cu.ruta, i.nombre_instructor 
            FROM Celdas c
            LEFT JOIN Cursos cu ON c.Curso = cu.cursoid
            LEFT JOIN Instructor i ON cu.instructor = i.idprofesor
            WHERE c.Celda = ? AND cu.id_grupo = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("ss", $celda, $grupo);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    echo json_encode($data ? $data : ['error' => 'No se encontró el curso']);
    $stmt->close();
} elseif ($action == 'eliminar') {
    $celda = $_POST['celda'];
    $grupo = $_POST['grupo'];
    $sql = "DELETE FROM Celdas WHERE Celda = ? AND Grupo_Curso = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo 'error';
        exit;
    }
    $stmt->bind_param("si", $celda, $grupo);
    $success = $stmt->execute();
    echo $success ? 'success' : 'error';
    $stmt->close();
}

$conn->close();
?>
