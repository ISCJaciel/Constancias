<?php
// Incluir el autoload de Composer
require_once '../fpdf/fpdf.php';
require_once '../fpdi/src/autoload.php';
use setasign\Fpdi\Fpdi; // Importar la clase FPDI

// Función para conectar a la base de datos
function conectarBaseDeDatos() {
    $servidor = "localhost";
    $usuario = "root";
    $contraseña = "1234";
    $basededatos = "plataformaconstancias";

    $conexion = new mysqli($servidor, $usuario, $contraseña, $basededatos);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    return $conexion;
}

// Conectar a la base de datos
$conn = conectarBaseDeDatos();

if (isset($_POST['curso'])) {
    $cursoId = $_POST['curso'];

    // Obtener las inscripciones del curso
    $sqlInscripciones = "SELECT i.curso, i.usuario, u.nombre, u.apellido_paterno, u.apellido_materno, i.estado_inscripcion
                         FROM inscripcion i
                         JOIN usuarios u ON i.usuario = u.usuarioid
                         WHERE i.curso = ?";
    $stmt = $conn->prepare($sqlInscripciones);
    $stmt->bind_param("i", $cursoId);
    $stmt->execute();
    $resultInscripciones = $stmt->get_result();

    // Crear el PDF
    $pdf = new \setasign\Fpdi\Fpdi(); // Crear una instancia de FPDI
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Título
    $pdf->Cell(0, 10, 'Lista de Inscripciones', 0, 1, 'C');

    // Cabecera
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 10, 'Nombre', 1);
    $pdf->Cell(30, 10, 'Apellido Paterno', 1);
    $pdf->Cell(30, 10, 'Apellido Materno', 1);
    $pdf->Cell(30, 10, 'Estado', 1);
    $pdf->Ln();

    // Datos
    $pdf->SetFont('Arial', '', 10);
    while ($row = $resultInscripciones->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['nombre'], 1);
        $pdf->Cell(30, 10, $row['apellido_paterno'], 1);
        $pdf->Cell(30, 10, $row['apellido_materno'], 1);
        $pdf->Cell(30, 10, $row['estado_inscripcion'], 1);
        $pdf->Ln();
    }

    // Cerrar y enviar el PDF
    $pdf->Output('D', 'inscripciones_curso_'.$cursoId.'.pdf');
}

$conn->close();
?>
