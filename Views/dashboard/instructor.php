<?php
// Identificar la página actual
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/../pruebas.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/../pruebas.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../pruebas.css" rel="stylesheet">
    <link href="../pruebas.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../pruebas.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../pruebas.css" rel="stylesheet">
    
    <style>
        /* Ajuste para la barra lateral */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #f8f9fa;
            transition: 0.5s;
            z-index: 999;
        }

        .sidebar a.nav-item {
            display: flex;
            align-items: center;
            padding: 10px;
            font-size: 18px;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background 0.3s;
        }

        .sidebar a.nav-item:hover {
            background: #e9ecef;
        }

        .sidebar a.nav-item.active {
            background: #e9ecef;
            font-weight: bold;
        }

        .sidebar i {
            margin-right: 10px;
        }

        /* Clase que colapsa la barra lateral */
        .sidebar.collapsed {
            /* Asegúrate de que el fondo y el color del texto se mantengan */
            background-color: #f8f9fa; /* Manten el fondo igual */
            color: #333; /* Color del texto */
            border: none; /* Elimina el borde si es necesario */
        }

        /* Asegúrate de que el texto en el estado colapsado no desaparezca */
        .sidebar.collapsed a {
            color: #333; /* Color del texto en estado colapsado */
        }

        .content.sidebar-collapsed {
            margin-left: 0;
            transition: 0.5s;
        }

        .navbar-custom.sidebar-collapsed {
            width: 100%;
            left: 0;
            transition: 0.5s;
        }

        .content {
            margin-left: 250px;
            padding-top: 70px;
            min-height: 100vh;
            transition: 0.5s;
        }

        /* Ajuste para el encabezado */
        .navbar-custom {
            background-color: #f5f7f6 !important;
            width: calc(100% - 250px);
            position: fixed;
            top: 0;
            left: 250px;
            z-index: 999;
            transition: left 0.5s, width 0.5s;
        }

        #descargarWordForm {
            position: fixed;
            bottom: 20px;
            left: 270px;
            z-index: 1000;
            transition: left 0.5s;
        }

        .sidebar.collapsed + .content #descargarWordForm {
            left: 20px;
        }

        .content #descargarWordForm {
            left: 270px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(105, 105, 105, 0.7);
            background-color: #ffffff;
        }

        .form-container .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            width: 100%;
        }

        .form-container .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container select {
            border-radius: 20px;
            padding-right: 40px;
        }

        .form-container .input-group-text {
            background: none;
            border: none;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            cursor: pointer;
        }

        .form-container .input-group {
            position: relative;
        }

        .btn-back {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            border-radius: 12px;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #218838;
        }

        /* Tabla */
        .table-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(105, 105, 105, 0.7);
            background-color: #ffffff;
        }

        .table thead th {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .table tbody tr {
            transition: background-color 0.3s;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .btn-danger, .btn-warning {
            margin-right: 5px;
        }

        .title-centered {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .edit-title-centered {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .footer {
            background-color: #28a745;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px 0;
            text-align: center;
        }

        .footer p {
            color: white;
            font-size: 16px;
            margin: 0;
        }

        .footer img {
            max-height: 60px;
            margin-left: 10px;
        }

        .table-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(105, 105, 105, 0.7);
            background-color: #ffffff;
        }

        .table thead th {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .table tbody tr {
            transition: background-color 0.3s;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .btn-danger, .btn-warning {
            margin-right: 5px;
        }

        .title-centered {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .edit-title-centered {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .nav-item.nav-link.active {
            background-color: #e9ecef; /* Cambia el fondo de la opción activa */
            color: #007bff; /* Cambia el color del texto en la opción activa */
            font-weight: bold; /* Hace el texto más destacado */
            border-left: 4px solid #007bff; /* Añade una barra de color para mayor visibilidad */
        }

        .nav-item.nav-link.active img {
            filter: brightness(0) saturate(100%) invert(42%) sepia(92%) saturate(2974%) hue-rotate(199deg) brightness(95%) contrast(101%);
            /* Cambia el color del icono cuando está activo */
        }

    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">
                        <img src="../dashboard/img/LOGO_EDUCACION_CONTINUA_icon.png" alt="Icono"
                            style="width: 200px; height: 180px; margin-right: 20px;">
                    </h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/Usuario.png" alt="" style="width: 30px; height: 30px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">Leticia Rosas</h6>
                        <span>Administrador</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                        <i class="fa fa-tachometer-alt me-2"><img src="img/datos.png" width="40" height="40"></i>Visualizar Datos
                    </a>
                    <a href="instructor.php" class="nav-item nav-link <?php echo ($current_page == 'instructor.php') ? 'active' : ''; ?>">
                        <i class="fa fa-th me-2"><img src="img/instructor.png" width="40" height="40"></i>Instructor
                    </a>
                    <a href="cargar_imagenes.php" class="nav-item nav-link <?php echo ($current_page == 'cargar_imagenes.php') ? 'active' : ''; ?>">
                        <i class="fa fa-th me-2"><img src="img/Cargar_icon.png" width="40" height="40"></i>Cargar Imágenes
                    </a>
                    <a href="subir_img.php" class="nav-item nav-link <?php echo ($current_page == 'subir_img.php') ? 'active' : ''; ?>">
                        <i class="fa fa-th me-2"><img src="img/Subir_icon.png" width="40" height="40"></i>Subir Imágenes
                    </a>
                    <a href="datos.php" class="nav-item nav-link <?php echo ($current_page == 'datos.php') ? 'active' : ''; ?>">
                        <i class="fa fa-th me-2"><img src="img/archivos.png" width="40" height="40"></i>Datos
                    </a>
                    <a href="graficas.php" class="nav-item nav-link <?php echo ($current_page == 'graficas.php') ? 'active' : ''; ?>">
                        <i class="fa fa-th me-2"><img src="img/archivos.png" width="40" height="40"></i>Encuestas
                    </a>
                    <a href="inscripciones.php" class="nav-item nav-link <?php echo ($current_page == 'inscripciones.php') ? 'active' : ''; ?>">
                        <i class="fa fa-th me-2"><img src="img/inscrip_icon.png" width="40" height="40"></i>Inscripciones
                    </a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0 navbar-custom">
                <a href="#" id="toggle-sidebar" class="sidebar-toggler flex-shrink-0">
                    <img src="../home/images/Menu_hamb.png" alt="Logo" style="width: 40px; height: 40px;">
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/Usuario.png" alt=""
                                style="width: 30px; height: 30px;">
                            <span class="d-none d-lg-inline-flex">Ing. Leticia Rosas Garcia</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">Configuracion</a>
                            <a href="#" class="dropdown-item" onclick="logout()">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Formulario para agregar instructores -->
            <div class="container pt-4 px-4">
            <h6 class="text-center mb-4 display-6 fw-bold">"Agregar Instructor"</h6>
                <form action="" method="post" class="form-container">
                    <div class="mb-3">
                        <label for="nombre_instructor" class="form-label">Nombre del Instructor:</label>
                        <input type="text" class="form-control" id="nombre_instructor" name="nombre_instructor">
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Instructor</button>
                </form>
            </div>

            <!-- Tabla de instructores -->
            <div class="container pt-4 px-4">
                <h2 class="title-centered">Instructores Registrados</h2>
                <div class="table-container">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <?php
                            // Definir las variables de conexión
                            $servername = "localhost"; // Cambia esto si tu servidor MySQL está en otro lugar
                            $username = "root"; // Cambia esto por tu nombre de usuario de MySQL
                            $password = "1234"; // Cambia esto por tu contraseña de MySQL
                            $database = "plataformaconstancias"; // Nombre de tu base de datos
                            
                            // Verificar si se recibió el ID del instructor a eliminar
                            if (isset($_POST['eliminar']) && isset($_POST['id'])) {
                                // Crear conexión
                                $conn = new mysqli($servername, $username, $password, $database);

                                // Verificar la conexión
                                if ($conn->connect_error) {
                                    die("La conexión falló: " . $conn->connect_error);
                                }

                                // Iniciar una transacción
                                $conn->begin_transaction();

                                try {
                                    // Eliminar primero los cursos asociados al instructor
                                    $sql_delete_courses = "DELETE FROM cursos WHERE instructor = ?";
                                    $stmt_delete_courses = $conn->prepare($sql_delete_courses);
                                    if ($stmt_delete_courses) {
                                        $stmt_delete_courses->bind_param("i", $_POST['id']);
                                        $stmt_delete_courses->execute();
                                        $stmt_delete_courses->close();
                                    } else {
                                        throw new Exception("Error al preparar la consulta para eliminar los cursos asociados al instructor.");
                                    }

                                    // Luego eliminar el instructor
                                    $sql_delete_instructor = "DELETE FROM instructor WHERE idprofesor = ?";
                                    $stmt_delete_instructor = $conn->prepare($sql_delete_instructor);
                                    if ($stmt_delete_instructor) {
                                        $stmt_delete_instructor->bind_param("i", $_POST['id']);
                                        $stmt_delete_instructor->execute();
                                        $stmt_delete_instructor->close();
                                    } else {
                                        throw new Exception("Error al preparar la consulta para eliminar el instructor.");
                                    }

                                    // Confirmar la transacción
                                    $conn->commit();

                                    // Redireccionar a la página actual para actualizar la tabla de instructores
                                    header("Location: " . $_SERVER['PHP_SELF']);
                                    exit;
                                } catch (Exception $e) {
                                    // Revertir la transacción en caso de error
                                    $conn->rollback();
                                    echo "Error: " . $e->getMessage();
                                }

                                // Cerrar la conexión
                                $conn->close();
                            }

                            // Procesamiento del formulario de carga de instructor
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre_instructor"])) {
                                // Crear conexión
                                $conn = new mysqli($servername, $username, $password, $database);

                                // Verificar la conexión
                                if ($conn->connect_error) {
                                    die("La conexión falló: " . $conn->connect_error);
                                }

                                // Verificar si se enviaron los datos del instructor correctamente
                                if (!empty($_POST["nombre_instructor"])) {
                                    $nombre_instructor = $_POST["nombre_instructor"];

                                    // Query de inserción
                                    $sql = "INSERT INTO instructor (nombre_instructor) VALUES (?)";

                                    // Preparar la declaración
                                    $stmt = $conn->prepare($sql);
                                    if ($stmt) {
                                        // Vincular parámetros e insertar el instructor
                                        $stmt->bind_param("s", $nombre_instructor);
                                        if ($stmt->execute()) {
                                            // Los datos del instructor se cargaron correctamente
                                            echo "<script>alert('Los datos del instructor se cargaron correctamente.'); window.location.href='../../Views/dashboard/instructor.php';</script>";
                                            exit;
                                        } else {
                                            // Error al ejecutar la consulta
                                            echo "<script>alert('Error al cargar los datos del instructor en la base de datos.');</script>";
                                        }
                                        // Cerrar la declaración
                                        $stmt->close();
                                    } else {
                                        // Error al preparar la consulta
                                        echo "<script>alert('Error al preparar la consulta para cargar los datos del instructor en la base de datos.');</script>";
                                    }
                                } else {
                                    // Datos del formulario incompletos
                                    echo "<script>alert('Por favor, complete todos los campos del formulario para cargar al instructor.');</script>";
                                }

                                // Cerrar la conexión
                                $conn->close();
                            }

                            // Procesamiento de la acción de editar
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar"]) && isset($_POST['id'])) {
                                // Verificar si se enviaron los datos del instructor correctamente
                                if (!empty($_POST["nombre_instructor_editar"])) {
                                    // Crear conexión
                                    $conn = new mysqli($servername, $username, $password, $database);

                                    // Verificar la conexión
                                    if ($conn->connect_error) {
                                        die("La conexión falló: " . $conn->connect_error);
                                    }

                                    $nombre_instructor_editar = $_POST["nombre_instructor_editar"];
                                    $id_instructor = $_POST['id'];

                                    // Query de actualización
                                    $sql = "UPDATE instructor SET nombre_instructor = ? WHERE idprofesor = ?";

                                    // Preparar la declaración
                                    $stmt = $conn->prepare($sql);
                                    if ($stmt) {
                                        // Vincular parámetros e insertar el instructor
                                        $stmt->bind_param("si", $nombre_instructor_editar, $id_instructor);
                                        if ($stmt->execute()) {
                                            // Los datos del instructor se editaron correctamente
                                            echo "<script>alert('Los datos del instructor se editaron correctamente.'); window.location.href='../Views/dashboard/instructor.php';</script>";
                                            exit;
                                        } else {
                                            // Error al ejecutar la consulta
                                            echo "<script>alert('Error al editar los datos del instructor en la base de datos.');</script>";
                                        }
                                        // Cerrar la declaración
                                        $stmt->close();
                                    } else {
                                        // Error al preparar la consulta
                                        echo "<script>alert('Error al preparar la consulta para editar los datos del instructor en la base de datos.');</script>";
                                    }

                                    // Cerrar la conexión
                                    $conn->close();
                                } else {
                                    // Datos del formulario incompletos
                                    echo "<script>alert('Por favor, complete todos los campos del formulario para editar al instructor.');</script>";
                                }
                            }

                            // Crear conexión
                            $conn = new mysqli($servername, $username, $password, $database);

                            // Verificar la conexión
                            if ($conn->connect_error) {
                                die("La conexión falló: " . $conn->connect_error);
                            }

                            // Consulta SQL para obtener los instructores
                            $sql = "SELECT * FROM instructor";
                            $result = $conn->query($sql);

                            // Comprobar si hay resultados
                            if ($result->num_rows > 0) {
                                // Mostrar la tabla HTML
                                echo "<table class='table table-striped table-hover'>
                                            <thead>
                                                <tr>
                                                    <th scope='col'>ID</th>
                                                    <th scope='col'>Nombre del Instructor</th>
                                                    <th scope='col'>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>";

                                // Mostrar los datos en la tabla
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                                <td>" . $row["idprofesor"] . "</td>
                                                <td>" . $row["nombre_instructor"] . "</td>
                                                <td>";
                                    echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' style='display: inline;'>";
                                    echo "<input type='hidden' name='id' value='" . $row["idprofesor"] . "'>";
                                    echo "<button type='submit' name='eliminar' class='btn btn-danger'>Eliminar</button>";
                                    echo "<button type='button' name='editar' class='btn btn-warning' onclick='editarInstructor(" . $row["idprofesor"] . ", \"" . $row["nombre_instructor"] . "\")'>Editar</button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "<p>No se encontraron instructores.</p>";
                            }

                            // Cerrar la conexión
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulario para editar instructores -->
            <div id="editarForm" class="container pt-4 px-4" style="display: none;">
                <h6 class="edit-title-centered">Editar Instructor</h6>
                <form id="editarInstructorForm" method="post" class="form-container">
                    <div class="mb-3">
                        <label for="nombre_instructor_editar" class="form-label">Nombre del Instructor:</label>
                        <input type="text" class="form-control" id="nombre_instructor_editar"
                            name="nombre_instructor_editar">
                    </div>
                    <input type="hidden" id="instructorId" name="id">
                    <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar Cambios</button>
                </form>
            </div>
        </div>

    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        function logout() {
            // Cambiar la ubicación actual del navegador a la página principal
            window.location.href = "../home/index.php"; // Cambia "index.php" por la URL de tu página principal
        }
        
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            const navbar = document.querySelector('.navbar-custom');
            
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('sidebar-collapsed');
            navbar.classList.toggle('sidebar-collapsed');
        });
    </script>

    <script>

        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este instructor?')) {
                // Realizar una solicitud AJAX para eliminar el instructor
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // Recargar la página para mostrar los datos actualizados
                        location.reload();
                    }
                };
                xhttp.open("POST", "../../Models/conexion_instruc.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("eliminar&id=" + id);
            }
        }

        function editarInstructor(id, nombre) {
            document.getElementById("instructorId").value = id;
            document.getElementById("nombre_instructor_editar").value = nombre;
            document.getElementById("editarForm").style.display = "block";
        }

        function guardarCambios() {
            var instructorId = document.getElementById("instructorId").value;
            var nombreInstructor = document.getElementById("nombre_instructor_editar").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // Recargar la página para mostrar los datos actualizados
                    location.reload();
                }
            };
            xhttp.open("POST", "../../Models/conexion_instruc.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("editar&id=" + instructorId + "&nombre_instructor_editar=" + nombreInstructor);
        }
    </script>
</body>

</html>
