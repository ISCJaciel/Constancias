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

// Definir la página actual
$current_page = basename($_SERVER['SCRIPT_NAME']);  // Obtiene el nombre del archivo actual


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../pruebas.css" rel="stylesheet">
    <link href="../pruebas.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../pruebas.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../pruebas.css" rel="stylesheet">
    
</head>

<style>
    body {
        background-color: #ffffff !important; /* Verde Pistache */
    }

    /* Mantén la barra lateral en toda la altura de la ventana */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 250px;
        height: 100vh;
        overflow-y: auto;
        background-color: #ffffff;
        transition: 0.5s;
        z-index: 999;
    }

    /* Ajusta el contenido para que comience después de la barra lateral */
    .content {
        margin-left: 250px;
        min-height: 100vh;
        background: #ffffff !important;
        transition: 0.5s;
    }

    /* Ajustar la barra de navegación para que se recorra cuando la barra lateral esté visible */
    .sidebar-active .navbar-custom {
        left: 250px; /* Ajusta el valor según el ancho de tu barra lateral */
        width: calc(100% - 250px); /* Resta el ancho de la barra lateral al 100% */
        transition: left 0.5s, width 0.5s;
    }

    /* Por defecto, la barra lateral y encabezado */
    .navbar-custom {
        left: 0;
        width: 100%;
        transition: left 0.5s, width 0.5s;
    }

    .bg-white {
        --bs-bg-opacity: 1;
        background-color: #ffffff !important;
    }

    .bg-light {
        background-color: #ffffff !important;
    }

    /* Para el canvas */
    .card-body canvas {
        background-color: transparent !important;
        width: 100% !important;
        height: auto !important;
        border: none !important; /* Elimina cualquier borde */
        box-shadow: none !important; /* Elimina cualquier sombra */
    }

    /* Asegúrate de que el contenedor de la gráfica también no tenga bordes */
    .chart-container, .card-body {
        border: none !important;  /* Elimina cualquier borde del contenedor */
        box-shadow: none !important; /* Elimina cualquier sombra del contenedor */
        background-color: transparent !important; /* Asegúrate de que no haya color de fondo */
    }

    

    /* Elimina el ancho reducido de las gráficas */
    .card {
        max-width: 300px; /* Tamaño máximo de la tarjeta */
    }

    .chart-container {
        height: 200px; /* Tamaño de la gráfica */
    }


    .col-md-4 {
        margin-bottom: 20px; /* Espaciado entre las gráficas */
    }

    @media (max-width: 768px) {
        .col-md-4 {
            width: 100%; /* En pantallas pequeñas, apila las gráficas verticalmente */
            margin-bottom: 20px;
        }
    }

    .navbar-custom {
        background-color: #f5f7f6 !important; /* Verde Lima */
        width: 100vw; /* Asegura que el ancho sea del 100% de la ventana */
        position: fixed; /* Mantiene el navbar en la parte superior */
        top: 0; /* Coloca el navbar en la parte superior */
        left: 0; /* Asegura que comience desde el lado izquierdo */
        z-index: 999; /* Asegura que esté por encima de otros elementos */
    }

    .margin-top-custom {
        margin-top: 20px; /* Ajusta el valor según el espaciado que desees */
    }


    .container-fluid {
        margin-top: 70px; /* Ajusta este valor según la altura de tu encabezado */
    }

    .sidebar {
        margin-top: 70px; /* Ajusta este valor según la altura de tu encabezado */
    }

    /* Estilo general para pantallas grandes */
    .row {
        display: flex;
        flex-wrap: wrap;
        --bs-gutter-x: 1.5rem;
        --bs-gutter-y: 0;
        margin-top: calc(-1 * var(--bs-gutter-y));
        margin-right: calc(-.5 * var(--bs-gutter-x));
        margin-left: calc(-.5 * var(--bs-gutter-x));
        justify-content: space-around; /* Distribuye espacio de manera uniforme entre los elementos */
    }

    .row>* {
        flex-shrink: 0;
        width: 100%;
        max-width: 100%;
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
        margin-top: var(--bs-gutter-y);
    }

    /* Media queries para pantallas pequeñas */
    @media (max-width: 768px) {
        .row {
            --bs-gutter-x: 0.5rem; /* Reduce el espacio entre columnas */
            flex-direction: column; /* Apila los elementos verticalmente */
        }

        .row>* {
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x) * .25);
            padding-left: calc(var(--bs-gutter-x) * .25);
        }
    }

    /* Ajustes adicionales para pantallas más pequeñas (como móviles) */
    @media (max-width: 480px) {
        .row {
            --bs-gutter-x: 0.25rem;
        }

        .row>* {
            padding-right: calc(var(--bs-gutter-x) * .1);
            padding-left: calc(var(--bs-gutter-x) * .1);
        }
    }

    #contenedor-graficas {
        display: flex;
        justify-content: space-between; /* Espaciado entre las dos gráficas */
        align-items: center;
    }

    #contenedor-graficas > div {
        flex-basis: 45%; /* Asigna un ancho del 45% para cada gráfica */
    }

    #contenedor-graficas canvas {
        max-width: 100%; /* Ajusta el tamaño máximo del canvas */
        height: 250px;   /* Ajusta la altura según sea necesario */
    }

    #contenedor-graficas-1 {
        display: flex;
        justify-content: space-between; /* Espaciado entre las dos gráficas */
        align-items: center;
    }

    #contenedor-graficas-1 > div {
        flex-basis: 45%; /* Asigna un ancho del 45% para cada gráfica */
    }

    #contenedor-graficas-1 canvas {
        max-width: 100%; /* Mantén el ancho ajustado */
        height: 600px;   /* Incrementa la altura según lo que necesites */
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

    /* Asegura que el contenedor de la gráfica sea un cuadrado perfecto */
    .chart-container {
        width: 100%;
        max-width: 300px; /* Limita el tamaño máximo del gráfico */
        height: 0;
        padding-bottom: 100%; /* Relación de aspecto 1:1 para mantener el gráfico circular */
        position: relative;
        display: flex;
        justify-content: center;
    }

    .chart-container .apexcharts-canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    h6.text-center {
        text-align: center;
        width: 100%;
    }

    /* Ajustes para pantallas pequeñas */
    @media (max-width: 768px) {
        .chart-container {
            max-width: 100%; /* En pantallas pequeñas, las gráficas ocupan todo el ancho disponible */
        }

        .col-md-6 {
            width: 100%; /* Las gráficas se apilan una sobre la otra en pantallas pequeñas */
        }
    }

    #hombres-mujeres {
        max-width: 200px; /* Cambia el tamaño máximo a 200px para hacerlo más pequeño */
        height: auto; /* Permite que la altura sea proporcional */
        margin: 0 auto; /* Centra la gráfica */
    }


</style>


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
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">
                        <img src="../dashboard/img/LOGO_EDUCACION_CONTINUA_icon.png" alt="Icono" style="width: 200px; height: 180px; margin-right: 20px;">
                    </h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/Usuario.png" alt="" style="width: 30px; height: 30px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
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
        <!-- FIN DE CONTROL -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0 navbar-custom">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" id="toggle-sidebar" class="sidebar-toggler flex-shrink-0">
                    <img src="../home/images/Menu_hamb.png" alt="Logo" style="width: 40px; height: 40px;">
                </a>
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
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
            <div class="container-fluid pt-4 px-4 mt-custom">
                <div class="row d-flex justify-content-center">
                    <!-- Gráfica de Cantidad de Alumnos por Carrera (Ancha) -->
                    <div class="col-12 mb-4">
                        <h6 class="mb-0">Cantidad de Alumnos por Carrera</h6>
                        <div id="cantidad-por-carrera"></div> <!-- Div para ApexCharts -->
                    </div>
                </div>

                <div class="row d-flex justify-content-between">
                    <!-- Gráfica de Inscripciones por Curso -->
                    <div class="card" style="max-width: 320px;"> <!-- Define el tamaño máximo de la tarjeta -->
                        <div class="card-body">
                            <h6 class="text-center mb-4">Inscripciones por Curso</h6>
                            <div id="inscripciones-por-curso" class="chart-container" style="height: 200px;"></div> <!-- Ajusta la altura de la gráfica -->
                        </div>
                    </div>
                    <!-- Gráfica de Cantidad de Hombres y Mujeres -->
                    <div class="card" style="max-width: 320px;"> <!-- Define el tamaño máximo de la tarjeta -->
                        <div class="card-body">
                            <h6 class="text-center mb-4">Cantidad de Hombres y Mujeres</h6>
                            <div id="hombres-mujeres" class="chart-container" style="height: 200px;"></div> <!-- Ajusta la altura de la gráfica -->
                        </div>
                    </div>

                    <!-- Gráfica de Cantidad de Alumnos por Tipo -->
                    <div class="card" style="max-width: 320px;"> <!-- Define el tamaño máximo de la tarjeta -->
                        <div class="card-body">
                            <h6 class="text-center mb-4">Cantidad de Alumnos por Tipo</h6>
                            <div id="cantidad-por-tipo" class="chart-container" style="height: 200px;"></div> <!-- Ajusta la altura de la gráfica -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets Start -->
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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        function logout() {
            // Cambiar la ubicación actual del navegador a la página principal
            window.location.href = "../home/index.php"; // Cambia "index.php" por la URL de tu página principal
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Datos de PHP
            var inscripcionesPorCurso = <?php echo json_encode($inscripcionesPorCurso); ?>;
            var cantidadPorCarrera = <?php echo json_encode($cantidadPorCarrera); ?>;
            var tipoAlumno = <?php echo json_encode($rowTipoAlumno); ?>;
            var hombresMujeres = <?php echo json_encode($rowHombresMujeres); ?>;

            // Inscripciones por Curso
            var optionsInscripciones = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    width: 3,
                    curve: 'smooth'
                },
                markers: {
                    size: 4
                },
                series: [{
                    name: 'Inscripciones',
                    data: <?php echo json_encode(array_column($inscripcionesPorCurso, 'cantidad')); ?>
                }],
                xaxis: {
                    categories: <?php echo json_encode(array_column($inscripcionesPorCurso, 'curso')); ?>,
                    labels: {
                        rotate: -45
                    }
                }
            };
            var chartInscripciones = new ApexCharts(document.querySelector("#inscripciones-por-curso"), optionsInscripciones);
            chartInscripciones.render();

            // Cantidad de Alumnos por Carrera
            var optionsCantidadPorCarrera = {
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Cantidad',
                    data: cantidadPorCarrera.map(item => item.cantidad)
                }],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                    }
                },
                xaxis: {
                    categories: cantidadPorCarrera.map(item => item.carrera),
                    labels: {
                        rotate: -45
                    }
                }
            };
            var chartCantidadPorCarrera = new ApexCharts(document.querySelector("#cantidad-por-carrera"), optionsCantidadPorCarrera);
            chartCantidadPorCarrera.render();

            // Cantidad de Hombres y Mujeres (Gráfica de Pastel)
            var totalUsuarios = hombresMujeres.hombres + hombresMujeres.mujeres; // Sumar el total de usuarios
            var optionsHombresMujeres = {
                chart: {
                    type: 'pie',
                    height: 200,  // Ajusta la altura de la gráfica a 200px
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    (hombresMujeres.hombres / totalUsuarios) * 100,  // Proporción de hombres
                    (hombresMujeres.mujeres / totalUsuarios) * 100   // Proporción de mujeres
                ],
                labels: ['Hombres', 'Mujeres'],
                colors: ['#FFC107', '#007BFF'],
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        chart: {
                            width: '100%',
                            height: 'auto'
                        }
                    }
                }],
                legend: {
                    position: 'bottom'
                }
            };

            var chartHombresMujeres = new ApexCharts(document.querySelector("#hombres-mujeres"), optionsHombresMujeres);
            chartHombresMujeres.render();

            // Cantidad de Alumnos por Tipo (Gráfica de Dona)
            var totalAlumnos = tipoAlumno.externo + tipoAlumno.interno + tipoAlumno.docente;  // Sumar el total de alumnos

            var optionsTipoAlumno = {
                chart: {
                    type: 'donut',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    (tipoAlumno.externo / totalAlumnos) * 100,  // Proporción de alumnos externos
                    (tipoAlumno.interno / totalAlumnos) * 100,  // Proporción de alumnos internos
                    (tipoAlumno.docente / totalAlumnos) * 100   // Proporción de docentes
                ],
                labels: ['Externo', 'Interno', 'Docente'],
                colors: ['#FF6384', '#4BC0C0', '#9966FF'],
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        chart: {
                            width: '100%',
                            height: 'auto'
                        }
                    }
                }],
                legend: {
                    position: 'bottom'
                }
            };
            var chartTipoAlumno = new ApexCharts(document.querySelector("#cantidad-por-tipo"), optionsTipoAlumno);
            chartTipoAlumno.render();
        });
    </script>
</body>
</html>
