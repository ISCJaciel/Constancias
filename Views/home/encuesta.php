<?php
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

// Asegúrate de que la sesión esté iniciada y obtén el usuarioid
session_start();
if (!isset($_SESSION['usuarioid'])) {
    echo "Error: Usuario no ha iniciado sesión.";
    exit();
}
$usuarioid = $_SESSION['usuarioid'];

// Obtener el curso_id y id_inscripcion de la URL
if (!isset($_GET['curso_id']) || !isset($_GET['id_inscripcion'])) {
    echo "Error: No se han proporcionado los parámetros necesarios.";
    exit();
}
$curso_id = $_GET['curso_id'];
$id_inscripcion = $_GET['id_inscripcion'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pregunta1 = $_POST['pregunta1'];
    $pregunta2 = $_POST['pregunta2'];
    $pregunta3 = $_POST['pregunta3'];
    $pregunta4 = $_POST['pregunta4'];
    $pregunta5 = $_POST['pregunta5'];
    $pregunta6 = $_POST['pregunta6'];
    $pregunta7 = $_POST['pregunta7'];
    $pregunta8 = $_POST['pregunta8'];
    $pregunta9 = $_POST['pregunta9'];

    $stmt = $conn->prepare("INSERT INTO encuesta (usuario, pregunta1, pregunta2, pregunta3, pregunta4, pregunta5, pregunta6, pregunta7, pregunta8, pregunta9) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssss", $usuarioid, $pregunta1, $pregunta2, $pregunta3, $pregunta4, $pregunta5, $pregunta6, $pregunta7, $pregunta8, $pregunta9);

    if ($stmt->execute()) {
        // Actualizar la columna encuesta_completada en la tabla inscripcion
        $update_stmt = $conn->prepare("UPDATE inscripcion SET encuesta_completada = 1 WHERE curso = ? AND usuario = ?");
        $update_stmt->bind_param("ii", $curso_id, $usuarioid);
        if ($update_stmt->execute()) {
            // Redirigir automáticamente a la descarga de la constancia
            header("Location: constancia.php?id_inscripcion=" . urlencode($id_inscripcion) . "&curso_id=" . urlencode($curso_id));
            exit();
        } else {
            echo "Error al actualizar la inscripción: " . $update_stmt->error;
        }
        $update_stmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin-top: 20px;
        }

        .btn-regresar {
            background-color: green;
            color: white;
            border-radius: 15px;
        }

        .btn-descargar {
            background-color: green;
            color: white;
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="mis_cursos.php" class="btn btn-regresar mb-4">Regresar</a>
        <h2 class="mb-4">Encuesta de Satisfacción</h2>
        <p>Para descargar tu constancia, por favor contesta la siguiente encuesta de satisfacción.</p>
        <form method="post"
            action="encuesta.php?curso_id=<?php echo $curso_id; ?>&id_inscripcion=<?php echo $id_inscripcion; ?>">
            <div class="mb-3">
                <label for="pregunta1" class="form-label">1. ¿Cubrió mis expectativas?</label>
                <select id="pregunta1" name="pregunta1" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Excelente">Excelente</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pregunta2" class="form-label">2. ¿Consideras que el material de apoyo, equipo e
                    instalaciones es:</label>
                <select id="pregunta2" name="pregunta2" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Excelente">Excelente</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pregunta3" class="form-label">3. ¿La logística del servicio (convocatoria, informes e
                    inscripción) es:</label>
                <select id="pregunta3" name="pregunta3" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Excelente">Excelente</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pregunta4" class="form-label">4. ¿El número total de horas para impartir el curso
                    fue:</label>
                <select id="pregunta4" name="pregunta4" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Excelente">Excelente</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pregunta5" class="form-label">5. ¿La inducción al curso fue:</label>
                <select id="pregunta5" name="pregunta5" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Excelente">Excelente</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pregunta6" class="form-label">6. ¿El dominio del tema, las estrategias de aprendizaje y el
                    uso del material de apoyo fue:</label>
                <select id="pregunta6" name="pregunta6" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Excelente">Excelente</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pregunta7" class="form-label">7. ¿La comunicación del instructor con los participantes
                    (exposición del tema, aclaración de dudas) fue:</label>
                <select id="pregunta7" name="pregunta7" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Excelente">Excelente</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pregunta8" class="form-label">8. ¿Cómo calificaría la calidad del curso?</label>
                <select id="pregunta8" name="pregunta8" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Excelente">Excelente</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pregunta9" class="form-label">9. ¿Cuál de las siguientes áreas considera que necesita más
                    atención?</label>
                <select select id="pregunta9" name="pregunta9" class="form-select" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Material de apoyo">Material de apoyo</option>
                    <option value="Logística del curso">Logística del curso</option>
                    <option value="Inducción al curso">Inducción al curso</option>
                    <option value="Dominio del tema">Dominio del tema</option>
                    <option value="Comunicación del instructor">Comunicación del instructor</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>
            <button type="submit" class="btn btn-descargar">Enviar y Descargar Constancia</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>