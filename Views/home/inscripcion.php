<?php
session_start();

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

$cursos = [];
$sql = "SELECT cursoid, nombre_curso FROM cursos WHERE id_grupo = 1"; // Filtra por grupo 1
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cursos[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreCurso = $_POST['nombreCurso'];
    $action = $_POST['action'];
    $estado_inscripcion = ($action == 'enviar') ? 'Pago subido' : 'Pago pendiente';
    $archivo_pago = null;

    if ($action == 'enviar' && isset($_FILES['archivoPago']) && $_FILES['archivoPago']['error'] == UPLOAD_ERR_OK) {
        $archivoPago = $_FILES['archivoPago'];
        $uploadDir = 'C:/xampp/htdocs/PlataformaConstancias/Constancias/Models/pdf/';
        $uploadFile = $uploadDir . basename($archivoPago['name']);

        // Validar que el archivo sea PDF
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        if ($fileType != 'pdf') {
            echo "Error: Solo se aceptan archivos PDF.";
            exit();
        }

        if (move_uploaded_file($archivoPago['tmp_name'], $uploadFile)) {
            $archivo_pago = '/PlataformaConstancias/Constancias/Models/pdf/' . basename($archivoPago['name']); // Guardar la ruta relativa para la URL
        } else {
            echo "Error uploading file.";
            exit();
        }
    }

    $curso_id_result = $conn->query("SELECT cursoid FROM cursos WHERE nombre_curso = '" . $conn->real_escape_string($nombreCurso) . "'");
    if ($curso_id_result->num_rows > 0) {
        $curso_id = $curso_id_result->fetch_assoc()['cursoid'];
    } else {
        echo "Error: Curso no encontrado.";
        exit();
    }

    $usuarioid = $_SESSION['usuarioid'];
    $sql = "INSERT INTO inscripcion (usuario, curso, estado_inscripcion, archivo_pago, id_juridico) VALUES ('$usuarioid', '$curso_id', '$estado_inscripcion', '$archivo_pago', 1)";

    if ($conn->query($sql) === TRUE) {
        if ($action == 'enviar') {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var modal = new bootstrap.Modal(document.getElementById('thanksModal'));
                        modal.show();
                    });
                  </script>";
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var modal = new bootstrap.Modal(document.getElementById('alertModal'));
                        modal.show();
                    });
                  </script>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} elseif (isset($_GET['action']) && $_GET['action'] == 'getDisponibilidad') {
    $nombreCurso = $_GET['curso'];
    $curso_id_result = $conn->query("SELECT cursoid FROM cursos WHERE nombre_curso = '" . $conn->real_escape_string($nombreCurso) . "'");
    if ($curso_id_result->num_rows > 0) {
        $curso_id = $curso_id_result->fetch_assoc()['cursoid'];
        $inscritos_result = $conn->query("SELECT COUNT(*) as count FROM inscripcion WHERE curso = '$curso_id'");
        $inscritos = $inscritos_result->fetch_assoc()['count'];
        $disponibilidad = 2 - $inscritos;
        echo json_encode(['disponibilidad' => $disponibilidad]);
    } else {
        echo json_encode(['error' => 'Curso no encontrado']);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados para un diseño más compacto y atractivo */
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .container {
            max-width: 650px;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .card {
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .modal-title {
            font-size: 1.5rem;
            color: #444;
            font-weight: 700;
        }
        .form-label {
            font-weight: 600;
            color: #555;
        }
        .form-control, .btn, select {
            border-radius: 10px;
            font-size: 0.95rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 18px;
            font-size: 0.95rem;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 10px 18px;
            font-size: 0.95rem;
            transition: background-color 0.3s;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .btn-warning {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
            padding: 10px 18px;
            font-size: 0.95rem;
            transition: background-color 0.3s;
        }
        .btn-warning:hover {
            background-color: #218838;
        }
        #disponibilidadContainer {
            display: none;
            margin-top: 10px;
            border-left: 4px solid #007bff;
            padding-left: 15px;
            font-weight: 600;
            color: #007bff;
            background-color: #e9f7ff;
            border-radius: 10px;
        }
        .alert-pdf {
            font-size: 0.85rem;
        }
        .mb-3 {
            margin-bottom: 20px;
        }
        .d-flex {
            gap: 10px;
        }
        .text-center a {
            display: block;
            margin-top: 20px;
        }
        /* Añadir transición a elementos */
        .form-control, select {
            transition: border-color 0.3s;
        }
        .form-control:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h5 class="modal-title mb-4 text-center">Inscripción al Curso</h5>
            <form id="inscripcionForm" action="inscripcion.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombreCurso" class="form-label">Curso</label>
                    <select class="form-control" id="nombreCurso" name="nombreCurso" required onchange="actualizarDisponibilidad(this.value)">
                        <option value="" disabled selected>Seleccione...</option>
                        <?php foreach ($cursos as $curso): ?>
                            <option value="<?php echo htmlspecialchars($curso['nombre_curso'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($curso['nombre_curso'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="disponibilidadContainer" class="alert"></div>
                <div class="mb-3" id="archivoPagoContainer">
                    <label for="archivoPago" class="form-label">PDF del pago</label>
                    <input type="file" class="form-control" id="archivoPago" name="archivoPago" accept=".pdf">
                    <p class="alert-pdf text-danger" style="display: none;">Solo se aceptan archivos PDF.</p>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" name="action" value="enviar" id="enviarButton" class="btn btn-primary">Enviar</button>
                    <button type="submit" name="action" value="subir" id="subirButton" class="btn btn-secondary">Subir después</button>
                </div>
            </form>
            <div class="text-center">
                <a href="index.php" class="btn btn-success btn-regresar mt-4">Regresar</a>
            </div>
        </div>
    </div>

    <!-- Modal de agradecimiento -->
    <div class="modal fade" id="thanksModal" tabindex="-1" aria-labelledby="thanksModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="thanksModalLabel">¡Gracias por tu inscripción!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tu inscripción ha sido recibida. Si has subido el archivo del pago, se procesará en breve.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de alerta -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Inscripción en espera</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    El curso ha sido registrado en la plataforma, pero no se ha subido el archivo del pago. Podrás hacerlo más tarde.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function actualizarDisponibilidad(curso) {
        if (!curso) return;
        fetch(`inscripcion.php?action=getDisponibilidad&curso=${encodeURIComponent(curso)}`)
            .then(response => response.json())
            .then(data => {
                const enviarButton = document.getElementById('enviarButton');
                const subirButton = document.getElementById('subirButton');
                const contenedor = document.getElementById('disponibilidadContainer');

                if (data.error) {
                    contenedor.style.display = 'none';
                    enviarButton.disabled = true;
                    subirButton.disabled = true;
                } else {
                    const disponibilidad = data.disponibilidad;
                    contenedor.style.display = 'block';
                    contenedor.textContent = `Quedan ${disponibilidad} plazas disponibles.`;
                    contenedor.className = disponibilidad > 0 ? 'alert alert-info' : 'alert alert-warning';

                    if (disponibilidad > 0) {
                        enviarButton.disabled = false;
                        subirButton.disabled = false;
                        document.getElementById('archivoPagoContainer').style.display = 'block';
                    } else {
                        enviarButton.disabled = true;
                        subirButton.disabled = true;
                        document.getElementById('archivoPagoContainer').style.display = 'none';
                    }
                }

                // Verificar si el archivo es válido después de cambiar de curso
                verificarArchivo();
            });
    }

    function verificarArchivo() {
        const fileInput = document.getElementById('archivoPago');
        const enviarButton = document.getElementById('enviarButton');
        const alertPdf = document.querySelector('.alert-pdf');

        if (fileInput.files.length > 0 && fileInput.files[0].type === 'application/pdf') {
            alertPdf.style.display = 'none';
            enviarButton.disabled = false;
        } else {
            alertPdf.style.display = 'block';
            enviarButton.disabled = true;
        }
    }

    document.getElementById('archivoPago').addEventListener('change', verificarArchivo);

    // Desactivar el botón "Enviar" por defecto hasta que se suba un archivo PDF válido
    document.addEventListener('DOMContentLoaded', function() {
        verificarArchivo();
    });
</script>

</body>
</html>
