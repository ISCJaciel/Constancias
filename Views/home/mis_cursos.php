<?php
session_start();

if (!isset($_SESSION['usuarioid'])) {
    header('Location: login.php');
    exit();
}

$usuarioid = $_SESSION['usuarioid'];

$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "plataformaconstancias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mensaje = "";

// Manejo de subida de PDF
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $curso_id = $_POST['curso_id'];
    $target_dir = "C:/xampp/htdocs/PlataformaConstancias/Constancias/Models/pdf/";
    $target_file = $target_dir . basename($_FILES["pdf"]["name"]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si es un archivo PDF
    if ($file_type !== 'pdf') {
        echo "<script>alert('Solo se permiten archivos PDF.');</script>";
        exit();
    }

    // Mover el archivo a la carpeta destino
    if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
        $ruta_pdf = '/PlataformaConstancias/Constancias/Models/pdf/' . basename($_FILES["pdf"]["name"]); // Ruta relativa para la URL
        $stmt = $conn->prepare("UPDATE inscripcion SET archivo_pago = ? WHERE curso = ? AND usuario = ?");
        $stmt->bind_param("sii", $ruta_pdf, $curso_id, $usuarioid);

        if ($stmt->execute()) {
            $mensaje = "Ruta del PDF guardada en la base de datos.";
        } else {
            $mensaje = "Error al guardar la ruta del PDF en la base de datos.";
        }

        $stmt->close();
    } else {
        $mensaje = "Hubo un error subiendo el archivo.";
    }
}

// Manejo de eliminación de curso
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_curso_id'])) {
    $id_inscripcion = $_POST['eliminar_curso_id'];

    $sql = "DELETE FROM inscripcion WHERE id_inscripcion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_inscripcion);

    if ($stmt->execute()) {
        $mensaje = "Curso eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar el curso.";
    }

    $stmt->close();
}

$sql = "SELECT ins.id_inscripcion, cu.cursoid, cu.nombre_curso, cu.descripcion, cu.costo, cu.ruta, ins.estado_inscripcion, ins.archivo_pago, ins.encuesta_completada
        FROM inscripcion ins
        JOIN cursos cu ON ins.curso = cu.cursoid
        WHERE ins.usuario = $usuarioid";
$result = $conn->query($sql);

$cursos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cursos[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .header,
    .footer {
        background-color: #b7b7b7;
        height: 50px;
        width: 100%;
    }

    .container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(105, 105, 105, 0.7);
        max-width: 900px;
        margin: 130px auto;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .btn-regresar {
        background-color: green;
        color: white;
        border-radius: 15px;
        margin-top: 10px;
        /* Reducir margen superior para ajustar la posición */
    }


    .footer {
        margin-top: auto;
    }

    .course-card {
        word-wrap: break-word;
        /* Para que las palabras largas se dividan en líneas si es necesario */
        width: 100%;
        /* Asegura que la tarjeta ocupe todo el ancho disponible */
        box-sizing: border-box;
        /* Incluye padding y borde en el ancho total */
        overflow: hidden;
        /* Evita que el contenido se desborde */
        display: flex;
        flex-direction: column;
        /* Asegura que los elementos dentro de la tarjeta se distribuyan verticalmente */
        justify-content: space-between;
        /* Distribuye el espacio de manera uniforme */
        margin-bottom: 10px;
    }

    .course-card h5,
    .course-card p {
        margin: 0;
        padding: 0;
        text-align: justify;
        /* Justifica el texto para una mejor distribución */
    }

    .course-card p {
        white-space: normal;
        /* Asegura que el texto largo se ajuste dentro de la tarjeta */
    }

    .course-card form,
    .course-card a {
        display: block;
        margin-top: auto;
        /* Mueve los botones al final de la tarjeta */
    }

    .course-card img,
    .course-card iframe {
        max-width: 100%;
        /* Asegura que las imágenes o iframes no excedan el ancho de la tarjeta */
        height: auto;
        /* Mantiene las proporciones */
    }

    .course-card .status {
        margin-top: 0.5rem;
        font-weight: bold;
    }

    /* Contenedor scrolleable para los cursos */
    .courses-wrapper {
        max-height: 500px;
        overflow-y: auto;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="header"></div> <!-- Encabezado verde -->
    <div class="container">
        <h2 class="mb-4">Mis Cursos</h2>
        <div class="courses-wrapper">
            <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>
            <?php if (count($cursos) > 0): ?>
            <?php foreach ($cursos as $curso): ?>
            <div class="course-card">
                <h5><?php echo htmlspecialchars($curso['nombre_curso'], ENT_QUOTES, 'UTF-8'); ?></h5>
                <p><?php echo htmlspecialchars($curso['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Costo: $<?php echo number_format($curso['costo'], 2); ?></p>
                <p class="status">Estado:
                    <?php echo htmlspecialchars($curso['estado_inscripcion'], ENT_QUOTES, 'UTF-8'); ?></p>

                <?php if ($curso['estado_inscripcion'] == 'terminado'): ?>
                <?php if ($curso['encuesta_completada'] == 0): ?>
                <p><a href="encuesta.php?id_inscripcion=<?php echo $curso['id_inscripcion']; ?>&curso_id=<?php echo $curso['cursoid']; ?>"
                        class="btn btn-success">Completar Encuesta</a></p>
                <?php else: ?>
                <p><a href="constancia.php?id_inscripcion=<?php echo $curso['id_inscripcion']; ?>&curso_id=<?php echo $curso['cursoid']; ?>"
                        class="btn btn-success">Descargar Constancia</a></p>
                <?php endif; ?>
                <?php else: ?>
                <?php if (empty($curso['archivo_pago'])): ?>
                <form action="mis_cursos.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="curso_id" value="<?php echo $curso['cursoid']; ?>">
                    <div class="mb-3">
                        <label for="pdf" class="form-label">Subir PDF:</label>
                        <input type="file" name="pdf" id="pdf" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir PDF</button>
                </form>
                <?php else: ?>
                <p>PDF Subido: <a href="<?php echo htmlspecialchars($curso['archivo_pago'], ENT_QUOTES, 'UTF-8'); ?>"
                        target="_blank">Ver PDF</a></p>
                <?php endif; ?>
                <form action="mis_cursos.php" method="post">
                    <input type="hidden" name="eliminar_curso_id" value="<?php echo $curso['id_inscripcion']; ?>">
                    <button type="submit" class="btn btn-danger mt-2">Eliminar Curso</button>
                </form>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No estás inscrito en ningún curso.</p>
            <?php endif; ?>
        </div>
        <a href="index.php" class="btn btn-regresar mt-4">Regresar</a>
    </div>
    <div class="footer"></div> <!-- Pie de página verde -->
</body>

</html>