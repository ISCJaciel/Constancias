<?php
session_start();

// Incluir librerías necesarias
require_once '../fpdf/fpdf.php';
require_once '../fpdi/src/autoload.php';
require_once '../phpqrcode/qrlib.php';

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "plataformaconstancias";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos del usuario desde la sesión
$usuarioid = $_SESSION['usuarioid'];
$id_inscripcion = isset($_GET['id_inscripcion']) ? intval($_GET['id_inscripcion']) : 0;
$cursoid = isset($_GET['curso_id']) ? intval($_GET['curso_id']) : 0;

// Obtener los datos del usuario y curso
$sql = "SELECT u.nombre, u.apellido_paterno, u.apellido_materno, c.nombre_curso, c.cursoid, i.estado_inscripcion 
        FROM usuarios u 
        JOIN inscripcion i ON u.usuarioid = i.usuario 
        JOIN cursos c ON i.curso = c.cursoid 
        WHERE i.id_inscripcion = ? AND c.cursoid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_inscripcion, $cursoid);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$nombreCompleto = $usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno'];
$curso = $usuario['nombre_curso'];
$estado_inscripcion = $usuario['estado_inscripcion'];

// Crear un registro en la tabla juridico con el nombre de la constancia
$sqlJuridico = "INSERT INTO juridico (nombre_cosntancia) VALUES (?)";
$stmtJuridico = $conn->prepare($sqlJuridico);
$stmtJuridico->bind_param("s", $curso);
$stmtJuridico->execute();
$id_juridico = $conn->insert_id;  // Obtener el id_juridico recién creado

// Ruta al archivo PDF base
$pdfBase = 'CONSTANCIA_PDF PLATAFORMA DIGITAL.pdf';

// Crear instancia de FPDI
$pdf = new \setasign\Fpdi\Fpdi();
$pageCount = $pdf->setSourceFile($pdfBase);
$tplIdx = $pdf->importPage(1);
$pdf->AddPage();
$pdf->useTemplate($tplIdx);

// Configuración de la fuente y color del texto
$pdf->SetFont('Arial', 'B', 24);
$pdf->SetTextColor(0, 0, 0);

// Obtener el ancho de la página
$pageWidth = $pdf->GetPageWidth();

// Calcular las posiciones X para centrar el texto
$nombreWidth = $pdf->GetStringWidth(utf8_decode($nombreCompleto));
$nombreX = ($pageWidth - $nombreWidth) / 2;

$textoCurso = 'Por haber concluido satisfactoriamente el curso:';
$textoCursoWidth = $pdf->GetStringWidth(utf8_decode($textoCurso));
$textoCursoX = ($pageWidth - $textoCursoWidth) / 2;

$cursoWidth = $pdf->GetStringWidth(utf8_decode($curso));
$cursoX = ($pageWidth - $cursoWidth) / 2;

// Ajuste de las coordenadas y agregar los textos centrados
$pdf->SetXY($nombreX, 110);
$pdf->Write(10, utf8_decode($nombreCompleto));

$pdf->SetFont('Arial', 'B', 18);
$pdf->SetXY($textoCursoX, 160); // Ajuste de la posición Y para un mejor alineamiento
$pdf->MultiCell(0, 10, utf8_decode($textoCurso), 0, 'C');

$pdf->SetFont('Arial', 'B', 28);
$pdf->SetXY($cursoX, 200);
$pdf->Write(10, utf8_decode($curso));

// Generar el código QR, incluyendo el usuarioid, cursoid y constanciaid en la URL
$qrData = "http://192.168.1.31/PlataformaConstancias/Constancias/Views/home/verificar_constancia.php?constanciaid=" . $id_juridico . "&usuarioid=" . $usuarioid . "&cursoid=" . $cursoid;
$qrFile = 'images/qrcode.png';
QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, 10);

// Colocar el código QR
$pdf->Image($qrFile, ($pageWidth - 25) / 2, 210, 30, 30);

// Configuración de la fuente y color del texto
$pdf->SetFont('Arial', 'B', 9.5);
$pdf->SetTextColor(0, 0, 0);

// Coordenadas para cubrir la fecha antigua
$pdf->SetFillColor(255, 255, 255); // Color blanco
$pdf->Rect(57, 262.5, 90, 10, 'F'); // Rectángulo blanco para cubrir la fecha antigua

// Array con los meses en español
$meses = array(
    'January' => 'enero',
    'February' => 'febrero',
    'March' => 'marzo',
    'April' => 'abril',
    'May' => 'mayo',
    'June' => 'junio',
    'July' => 'julio',
    'August' => 'agosto',
    'September' => 'septiembre',
    'October' => 'octubre',
    'November' => 'noviembre',
    'December' => 'diciembre'
);

// Obtener el mes actual en inglés y traducirlo al español
$mesIngles = date('F');
$mesEspanol = $meses[$mesIngles];

// Obtener la fecha actual con el mes en español
$nuevaFecha = "Chimalhuacán, Estado de México, a " . date('d') . " de " . $mesEspanol . " de " . date('Y');

// Posición de la nueva fecha
$pdf->SetXY(57, 262.5);
$pdf->Write(10, utf8_decode($nuevaFecha));

// Insertar datos en la tabla constancia
$fecha_emision = date('Y-m-d');  // Fecha actual
$estado = $estado_inscripcion;  // Estado de inscripción
$codigo_enlace = $qrData;  // El enlace generado para el QR

$sqlInsert = "INSERT INTO constancia (fecha_emision, estado, codigo_enlace, usuarioid, cursoid, id_juridico) 
              VALUES (?, ?, ?, ?, ?, ?)";
$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->bind_param("sssiii", $fecha_emision, $estado, $codigo_enlace, $usuarioid, $cursoid, $id_juridico);
$stmtInsert->execute();

// Actualizar id_juridico en la tabla inscripcion utilizando id_inscripcion
$sqlUpdate = "UPDATE inscripcion SET id_juridico = ? WHERE id_inscripcion = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bind_param("ii", $id_juridico, $id_inscripcion);
$stmtUpdate->execute();

// Enviar el PDF al navegador para su descarga
$pdf->Output('D', 'Constancia.pdf');

// Cerrar la conexión a la base de datos
$conn->close();
?>
