<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "plataformaconstancias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Obtener parámetros
$celda = $_GET['celda'] ?? null;

if ($celda) {
    // Consulta para obtener la información del curso basada en la celda
    $sql = "SELECT cu.nombre_curso, cu.descripcion, cu.costo, cu.ruta, i.nombre_instructor 
            FROM Celdas c
            JOIN Cursos cu ON c.Curso = cu.cursoid
            JOIN instructor i ON cu.instructor = i.idprofesor
            WHERE c.Celda = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $celda);
    $stmt->execute();
    $result = $stmt->get_result();
    $curso = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
} else {
    die("Celda no especificada.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Curso</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .modal-content {
            max-width: 600px;
            margin: 30px auto;
        }
        .modal-body img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Información del Curso</h5>
                <button type="button" class="close" onclick="window.close();">&times;</button>
            </div>
            <div class="modal-body">
                <?php if ($curso): ?>
                    <img src="/PlataformaConstancias/Constancias/Models/cursos/<?php echo htmlspecialchars($curso['ruta']); ?>" alt="<?php echo htmlspecialchars($curso['nombre_curso']); ?>">
                    <h5><?php echo htmlspecialchars($curso['nombre_curso']); ?></h5>
                    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($curso['descripcion']); ?></p>
                    <p><strong>Costo:</strong> <?php echo htmlspecialchars($curso['costo']); ?></p>
                    <p><strong>Instructor:</strong> <?php echo htmlspecialchars($curso['nombre_instructor']); ?></p>
                <?php else: ?>
                    <p>No se encontró información del curso.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="window.close();">Cerrar</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
