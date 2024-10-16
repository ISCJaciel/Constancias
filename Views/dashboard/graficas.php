<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "plataformaconstancias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Identificar la página actual
$current_page = basename($_SERVER['SCRIPT_NAME']);

// Consulta para obtener la cantidad de inscripciones por curso
$sqlInscripcionesPorCurso = "
    SELECT c.nombre_curso AS curso, COUNT(i.curso) AS cantidad 
    FROM inscripcion i
    JOIN Cursos c ON i.curso = c.cursoid
    GROUP BY c.nombre_curso";
$resultInscripcionesPorCurso = $conn->query($sqlInscripcionesPorCurso);
$inscripcionesPorCurso = $resultInscripcionesPorCurso->fetch_all(MYSQLI_ASSOC);

// Consulta para obtener la cantidad de alumnos por carrera
$sqlCantidadPorCarrera = "
    SELECT carrera, COUNT(*) AS cantidad 
    FROM Usuarios 
    GROUP BY carrera";
$resultCantidadPorCarrera = $conn->query($sqlCantidadPorCarrera);
$cantidadPorCarrera = $resultCantidadPorCarrera->fetch_all(MYSQLI_ASSOC);

// Consulta para obtener la cantidad de hombres y mujeres
$sqlHombresMujeres = "
    SELECT 
        SUM(CASE WHEN u.id_genero = 1 THEN 1 ELSE 0 END) AS hombres,
        SUM(CASE WHEN u.id_genero = 2 THEN 1 ELSE 0 END) AS mujeres
    FROM 
        Usuarios u";
$resultHombresMujeres = $conn->query($sqlHombresMujeres);
$rowHombresMujeres = $resultHombresMujeres->fetch_assoc();

// Consulta para obtener la cantidad de alumnos por tipo
$sqlTipoAlumno = "
    SELECT 
        SUM(CASE WHEN u.matricula LIKE 'DIP2024%' THEN 1 ELSE 0 END) AS externo,
        SUM(CASE WHEN u.matricula REGEXP '^[0-9]{10}$' THEN 1 ELSE 0 END) AS interno,
        SUM(CASE WHEN u.matricula REGEXP '^[A-Za-z]+$' THEN 1 ELSE 0 END) AS docente
    FROM 
        Usuarios u";
$resultTipoAlumno = $conn->query($sqlTipoAlumno);
$rowTipoAlumno = $resultTipoAlumno->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashs EDUCONT</title>
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
            left: -250px; /* Oculta la barra lateral completamente */
            background-color: #f8f9fa; /* Manten el fondo igual */
            color: #333; /* Color del texto */
            border: none; /* Elimina el borde si es necesario */
        }

        /* Asegúrate de que el texto en el estado colapsado no desaparezca */
        .sidebar.collapsed a {
            color: #333; /* Color del texto en estado colapsado */
        }

        /* Ajuste para pantallas pequeñas */
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
                left: -250px; /* Ocultar menú en pantallas pequeñas por defecto */
                position: fixed;
                top: 0;
                transition: left 0.8s ease-in-out;
            }

            .sidebar.collapsed {
                left: 0; /* Mostrar el menú cuando esté colapsado */
            }

            .content {
                margin-left: 0;
                transition: margin-left 0.8s ease-in-out;
            }

            .content.sidebar-collapsed {
                margin-left: 250px; /* Desplazar contenido cuando el menú está visible */
            }

            .navbar-custom {
                width: 100%; /* Ancho completo del encabezado */
                left: 0;
                transition: left 0.8s ease-in-out;
            }

            .navbar-custom.sidebar-collapsed {
                left: 250px; /* Desplazar el encabezado cuando el menú está visible */
            }
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
            padding-top: 70px; /* Ajusta este valor según la altura de tu encabezado */
            min-height: 100vh;
            transition: 0.5s;
        }

        /* Ajuste para el encabezado */
        .navbar-custom {
            background-color: #f5f7f6 !important; /* Color de fondo del encabezado */
            width: calc(100% - 250px); /* El ancho debe ser el 100% menos el ancho de la barra lateral */
            position: fixed; /* Mantiene el navbar en la parte superior */
            top: 0; /* Coloca el navbar en la parte superior */
            left: 250px; /* Ajusta para que inicie justo después del sidebar */
            z-index: 999; /* Asegura que el encabezado esté por encima de otros elementos */
            transition: left 0.5s, width 0.5s;
        }

        #descargarWordForm {
            position: fixed;
            bottom: 20px;
            left: 270px; /* Posición del botón cuando el menú está visible */
            z-index: 1000;
            transition: left 0.5s; /* Transición suave del movimiento */
        }

        .sidebar.collapsed + .content #descargarWordForm {
            left: 20px; /* Posición del botón cuando el menú está oculto */
        }

        .content #descargarWordForm {
            left: 270px; /* Cuando el menú esté desplegado, ajusta el botón a la derecha del menú */
        }

        /* Estilos para la tarjeta (card) */
        .card {
            max-width: 450px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(105, 105, 105, 0.7);
            background-color: #fff;
            text-align: center;
        }

        /* Estilos para el título y el selector dentro de la tarjeta */
        .card h2 {
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: #333;
        }

        .card select {
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        /* Estilo para el canvas de la gráfica */
        .card canvas {
            max-width: 100%;
            max-height: 300px;
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
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- CONTROL DE PAGINAS -->
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
                        <div
                            class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
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
                </div>
            </nav>
        </div>
        <!-- FIN DE CONTROL -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0 navbar-custom">
                <a href="#" class="sidebar-toggler">
                    <img src="../home/images/Menu_hamb.png" alt="Logo" style="width: 40px; height: 40px;">
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/Usuario.png" alt=""
                                        style="width: 30px; height: 30px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/USER.png" alt=""
                                        style="width: 30px; height: 30px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/USER.png" alt=""
                                        style="width: 30px; height: 30px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">Ver todas las Notificaciones</a>
                        </div>
                    </div>
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

            <div class="card" id="encuestaCard">
                <h2>Selecciona una pregunta para ver la gráfica</h2>
                <select id="preguntaSelect">
                    <option value="pregunta1">Pregunta 1</option>
                    <option value="pregunta2">Pregunta 2</option>
                    <option value="pregunta3">Pregunta 3</option>
                    <option value="pregunta4">Pregunta 4</option>
                    <option value="pregunta5">Pregunta 5</option>
                    <option value="pregunta6">Pregunta 6</option>
                    <option value="pregunta7">Pregunta 7</option>
                    <option value="pregunta8">Pregunta 8</option>
                    <option value="pregunta9">Pregunta 9</option>
                </select>
                <canvas id="encuestaChart"></canvas>
            </div>
        </div>
        <!-- Content End -->


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
    <script src="js/grafica.js"></script>

    <script>
        function logout() {
            // Cambiar la ubicación actual del navegador a la página principal
            window.location.href = "../home/index.php"; // Cambia "index.php" por la URL de tu página principal
        }
        document.querySelector('.sidebar-toggler').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            const navbar = document.querySelector('.navbar-custom');

            // Alternar la clase collapsed para el menú, contenido y encabezado
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('sidebar-collapsed');
            navbar.classList.toggle('sidebar-collapsed');
        });
    </script>

</body>

</html>