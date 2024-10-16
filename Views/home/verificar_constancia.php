<?php
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "plataformaconstancias";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener el ID del usuario desde la URL
$usuarioid = $_GET['usuarioid'];
$sql = "SELECT u.nombre, u.apellido_paterno, u.apellido_materno, u.matricula, c.nombre_curso, i.estado_inscripcion, co.fecha_emision, co.id_juridico
        FROM usuarios u 
        JOIN inscripcion i ON u.usuarioid = i.usuario 
        JOIN cursos c ON i.curso = c.cursoid 
        LEFT JOIN constancia co ON i.id_inscripcion = co.constanciaid
        WHERE u.usuarioid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuarioid);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$nombreCompleto = $usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno'];
$matricula = $usuario['matricula'];
$curso = $usuario['nombre_curso'];
$estadoInscripcion = $usuario['estado_inscripcion'];
$fechaEmision = $usuario['fecha_emision'];
$idJuridico = $usuario['id_juridico'];

// Verificar si el estado es "terminado" y mostrar la fecha de emisión
if ($estadoInscripcion == 'terminado' && $fechaEmision) {
    $estadoInscripcion = $fechaEmision;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Constancia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('images/EDIFICIO_TESCHI.jpg'); /* Imagen de fondo de la página */
            background-size: cover; /* Ajustar el tamaño de la imagen */
            background-position: center; /* Centrar la imagen */
            background-attachment: fixed; /* Fijar la imagen de fondo */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5); /* Fondo blanco muy transparente */
            border-radius: 10px;
            border: 2px solid rgba(0, 0, 0, 0.1); /* Borde sutil */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: none; /* Sin sombra en la tarjeta */
        }
        .card-body {
            padding: 30px;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: #343a40;
        }
        .card-text {
            font-size: 1rem;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center mb-4">Tecnológico de Estudios Superiores de Chimalhuacán hacen constar que:</h3>
        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>El alumno:</strong> <?php echo $nombreCompleto; ?></p>
                <h5 class="card-title">Termino el curso: <?php echo $curso; ?></h5>
                <p class="card-text"><strong>Con la matrícula:</strong> <?php echo $matricula; ?></p>
                <p class="card-text"><strong>Fecha de término:</strong> <?php echo htmlspecialchars($estadoInscripcion, ENT_QUOTES, 'UTF-8'); ?></p> 
                <?php if (!empty($idJuridico)): ?>
                <p class="card-text"><strong>Folio jurídico:</strong> <?php echo htmlspecialchars($idJuridico, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>
                <p class="card-text">Esta constancia verifica que el usuario ha concluido satisfactoriamente el curso.</p>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
