<?php
require_once '../../Models/conexion.php'; // Ruta corregida para incluir el archivo de conexión

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuarioid'])) {
    header('Location: signin.php'); // Asegúrate de que la ruta al archivo de inicio de sesión es correcta
    exit();
}

// Conectar a la base de datos
$conn = conectarBaseDeDatos();

// Verificar que $conn está definida y no es null
if (!$conn) {
    die("Error en la conexión: Por favor verifica la configuración");
}

// Obtener el ID del usuario desde la sesión
$usuarioid = $_SESSION['usuarioid'];

// Procesar la actualización de la contraseña si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cambiar_contraseña'])) {
    $contraseña_actual = $_POST['contraseña_actual'];
    $nueva_contraseña = $_POST['nueva_contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    // Verificar la contraseña actual
    $query = "SELECT contraseña FROM usuarios WHERE usuarioid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $usuarioid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (password_verify($contraseña_actual, $row['contraseña'])) {
        if ($nueva_contraseña === $confirmar_contraseña) {
            $hash_nueva_contraseña = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
            $update_query = "UPDATE usuarios SET contraseña = ? WHERE usuarioid = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $hash_nueva_contraseña, $usuarioid);

            if ($update_stmt->execute()) {
                echo "<script>alert('Contraseña actualizada exitosamente');</script>";
            } else {
                echo "Error al actualizar la contraseña: " . $conn->error;
            }

            $update_stmt->close();
        } else {
            echo "<script>alert('Las nuevas contraseñas no coinciden');</script>";
        }
    } else {
        echo "<script>alert('La contraseña actual es incorrecta');</script>";
    }

    $stmt->close();
}

// Consultar los datos del usuario en la base de datos
$query = "SELECT nombre, apellido_paterno, apellido_materno, correo, matricula, carrera FROM usuarios WHERE usuarioid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuarioid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $nombre = $row['nombre'];
    $apellido_paterno = $row['apellido_paterno'];
    $apellido_materno = $row['apellido_materno'];
    $correo = $row['correo'];
    $matricula = $row['matricula'];
    $carrera = $row['carrera'];
} else {
    echo "No se encontraron datos del usuario.";
    exit();
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('images/EDIFICIO_TESCHI.jpg'); /* Asegúrate de poner la ruta correcta */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .btn-rounded {
            border-radius: 50px;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
        }
        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .title-container h2 {
            margin: 0;
        }
        .title-container .btn {
            position: absolute;
            left: 0;
        }
        .form-label[title]:hover::after {
            content: attr(title);
            position: absolute;
            background: rgba(0, 0, 0, 0.75);
            color: #fff;
            padding: 5px;
            border-radius: 5px;
            top: 100%;
            left: 0;
            white-space: nowrap;
            z-index: 1;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="title-container mb-4">
        <a href="index.php" class="btn btn-success btn-rounded">Regresar</a>
        <h2>Perfil del Usuario</h2>
    </div>
    <div class="form-container">
        <form method="POST" action="perfil.php">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="nombre" class="form-label" title="Si quieres cambiar tu nombre, acércate a Educación Continua."><strong>Nombre:</strong></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="apellido_paterno" class="form-label" title="Si quieres cambiar tu nombre, acércate a Educación Continua."><strong>Apellido Paterno:</strong></label>
                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="<?php echo htmlspecialchars($apellido_paterno); ?>" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="apellido_materno" class="form-label" title="Si quieres cambiar tu nombre, acércate a Educación Continua."><strong>Apellido Materno:</strong></label>
                    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="<?php echo htmlspecialchars($apellido_materno); ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="correo" class="form-label"><strong>Correo:</strong></label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="matricula" class="form-label"><strong>Matrícula:</strong></label>
                    <input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo htmlspecialchars($matricula); ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="carrera" class="form-label"><strong>Carrera:</strong></label>
                    <input type="text" class="form-control" id="carrera" name="carrera" value="<?php echo htmlspecialchars($carrera); ?>" readonly>
                </div>
            </div>
            <p class="text-muted">Si quieres cambiar tu nombre, acércate a Educación Continua.</p>
        </form>

        <h2 class="mt-5 mb-4">Cambiar Contraseña</h2>
        <form method="POST" action="perfil.php">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="contraseña_actual" class="form-label"><strong>Contraseña Actual:</strong></label>
                    <input type="password" class="form-control" id="contraseña_actual" name="contraseña_actual" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nueva_contraseña" class="form-label"><strong>Nueva Contraseña:</strong></label>
                    <input type="password" class="form-control" id="nueva_contraseña" name="nueva_contraseña" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="confirmar_contraseña" class="form-label"><strong>Confirmar Nueva Contraseña:</strong></label>
                    <input type="password" class="form-control" id="confirmar_contraseña" name="confirmar_contraseña" required>
                </div>
            </div>
            <button type="submit" name="cambiar_contraseña" class="btn btn-success btn-rounded">Cambiar Contraseña</button>
        </form>
    </div>
</div>
</body>
</html>
