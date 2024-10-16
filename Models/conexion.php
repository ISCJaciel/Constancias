<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Función para conectar a la base de datos
function conectarBaseDeDatos() {
    $servidor = "localhost"; // Dirección del servidor de la base de datos
    $usuario = "root"; // Nombre de usuario de la base de datos
    $contraseña = "1234"; // Contraseña de la base de datos
    $basededatos = "plataformaconstancias"; // Nombre de la base de datos

    // Crear conexión
    $conexion = new mysqli($servidor, $usuario, $contraseña, $basededatos);

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    return $conexion;
}

// Función para generar una matrícula única para estudiantes foráneos
function generarMatricula($conexion) {
    $year = date('Y');
    $prefix = "DPI" . $year;
    
    // Buscar la última matrícula generada que comience con el prefijo actual
    $sql = "SELECT matricula FROM usuarios WHERE matricula LIKE '$prefix%' ORDER BY matricula DESC LIMIT 1";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $ultimaMatricula = $row['matricula'];
        $numero = (int) substr($ultimaMatricula, -3);
        $nuevoNumero = $numero + 1;
        $nuevaMatricula = $prefix . str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT);
    } else {
        // Si no hay matrículas previas, empezar desde DPI2024001
        $nuevaMatricula = $prefix . "001";
    }

    return $nuevaMatricula;
}

// Procesar el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $conexion = conectarBaseDeDatos();

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE correo='$correo'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($contraseña, $usuario['contraseña'])) {
            // Verificar si el usuario es un administrador y su correo es el específico
            if ($usuario['correo'] == 'educacont@teschi.edu.mx') {
                // Iniciar sesión y redirigir al dashboard del administrador
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['usuarioid'] = $usuario['usuarioid'];
                setcookie("isLoggedIn", "true", time() + (86400 * 30), "/");
                setcookie("username", $usuario['nombre'], time() + (86400 * 30), "/");

                header("Location: ../dashboard/index.php");
                exit;
            } else {
                // Si no es el correo del administrador, se redirige a la página principal
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['usuarioid'] = $usuario['usuarioid'];
                setcookie("isLoggedIn", "true", time() + (86400 * 30), "/");
                setcookie("username", $usuario['nombre'], time() + (86400 * 30), "/");

                header("Location: ../home/index.php");
                exit;
            }
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $conexion->close();
}

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
    $conexion = conectarBaseDeDatos();

    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $carrera = $_POST['carrera'];
    $genero = $_POST['genero'];

    // Generar matrícula única para estudiantes foráneos
    if ($_POST['carrera'] == "Estudiante foraneo") {
        $matricula = generarMatricula($conexion);
    } else {
        $matricula = $_POST['matricula'];
    }

    // Verificar si el campo género está vacío y asignar un valor predeterminado
    if (empty($genero) || !in_array($genero, [1, 2, 3])) {
        $genero = 1; // Asigna un valor predeterminado, por ejemplo, "Masculino"
    }

    // Insertar nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, correo, contraseña, carrera, matricula, id_genero)
    VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$correo', '$contraseña', '$carrera', '$matricula', '$genero')";

    if ($conexion->query($sql) === TRUE) {
        // Usuario registrado exitosamente, mostrar notificación y redirigir al index
        echo "<script>alert('Usuario registrado exitosamente.'); window.location.href='../Views/home/index.php';</script>";
        exit;
    } else {
        echo "Error al registrar el usuario: " . $conexion->error;
    }

    $conexion->close();
}
?>
