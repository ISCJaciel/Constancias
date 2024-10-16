<?php
// Identificar la página actual
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/../pruebas.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/../pruebas.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../pruebas.css" rel="stylesheet">

    <!-- Estilos personalizados para las tablas -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(105, 105, 105, 0.7);
            margin-bottom: 20px;
            border: none;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #4CAF50; /* Color verde similar al botón */
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #eafaf1; /* Un tono más claro de verde para las filas pares */
        }

        tbody tr:hover {
            background-color: #c8e6c9; /* Un tono verde claro para el hover */
        }

        .btn-search {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-search:hover {
            background-color: #45a049;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-input {
            width: 50%;
            padding: 10px;
            border-radius: 4px 0 0 4px;
            border: 1px solid #ccc;
        }

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

        /* Para pantallas más pequeñas */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                display: none; /* Ocultar barra lateral por completo */
            }

            .sidebar.collapsed {
                width: 250px; /* Mostrar la barra lateral solo cuando está desplegada */
                display: block; /* Asegurarse de que se vea cuando se expanda */
            }

            .content {
                margin-left: 0; /* El contenido debe ocupar todo el ancho cuando la barra lateral está oculta */
            }

            .navbar-custom {
                left: 0;
                width: 100%; /* Asegurar que el navbar ocupe todo el ancho */
            }

            /* Ajuste para el ícono de menú */
            #toggle-sidebar {
                position: fixed;
                left: 15px;
                top: 15px;
                z-index: 1000; /* Siempre visible en la parte superior */
            }
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
            </nav>
        </div>

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
                <!-- Navbar Content -->
            </nav>
            <!-- Navbar End -->

            <div class="container">

                <h1 class="text-center display-4 fw-bold">"Datos"</h1>

                <div class="search-container">
                    <input type="text" id="searchInput" class="search-input" placeholder="Buscar datos...">
                    <button class="btn-search" onclick="searchData()">Buscar</button>
                </div>

                <!-- Menú desplegable para seleccionar qué datos quieres ver -->
                <div class="form-group mt-3">
                    <label for="selectData">Selecciona qué datos quieres ver:</label>
                    <select class="form-control" id="selectData">
                        <option value="instructor">Instructores</option>
                        <option value="cursos">Cursos</option>
                        <option value="usuarios">Usuarios</option>
                        
                        <!-- Agrega más opciones según los datos disponibles en la base de datos -->
                    </select>
                </div>

                <!-- Botón para mostrar las tablas de la base de datos -->
                <button class="btn btn-success mb-3" onclick="showData()">Mostrar</button>

                <!-- Contenedor donde se mostrarán los datos -->
                <div id="dataContainer" class="pt-4 px-4">
                    <!-- Aquí se mostrarán los datos seleccionados -->
                </div>

                <!-- Contenedores para las gráficas de pastel -->
                <div class="row">
                    <div class="col-md-4"><canvas id="encuestaChart1" style="display: none; max-width: 100%; height: 200px;"></canvas></div>
                    <div class="col-md-4"><canvas id="encuestaChart2" style="display: none; max-width: 100%; height: 200px;"></canvas></div>
                    <div class="col-md-4"><canvas id="encuestaChart3" style="display: none; max-width: 100%; height: 200px;"></canvas></div>
                    <div class="col-md-4"><canvas id="encuestaChart4" style="display: none; max-width: 100%; height: 200px;"></canvas></div>
                    <div class="col-md-4"><canvas id="encuestaChart5" style="display: none; max-width: 100%; height: 200px;"></canvas></div>
                    <div class="col-md-4"><canvas id="encuestaChart6" style="display: none; max-width: 100%; height: 200px;"></canvas></div>
                    <div class="col-md-4"><canvas id="encuestaChart7" style="display: none; max-width: 100%; height: 200px;"></canvas></div>
                    <div class="col-md-4"><canvas id="encuestaChart8" style="display: none; max-width: 100%; height: 200px;"></canvas></div>
                    <div class="col-md-4"><canvas id="encuestaChart9" style="display: none; max-width: 100%; height: 200px;"></canvas></div>
                </div>

            </div>
        </div>


    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
        
    <script>
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            const navbar = document.querySelector('.navbar-custom');
            
            sidebar.classList.toggle('collapsed');
            
            // Ajuste de la visibilidad del contenido en pantallas pequeñas
            if (window.innerWidth <= 768) {
                content.classList.toggle('sidebar-collapsed');
                navbar.classList.toggle('sidebar-collapsed');
            }
        });

    </script>

    <script>
        function logout() {
            // Cambiar la ubicación actual del navegador a la página principal
            window.location.href = "../home/index.php"; // Cambia "index.php" por la URL de tu página principal
        }
        
        // Función para mostrar los datos según la opción seleccionada en el menú desplegable
        function showData() {
            var selectedOption = document.getElementById("selectData").value;
            var dataContainer = document.getElementById("dataContainer");
            var encuestaCharts = document.querySelectorAll('canvas[id^="encuestaChart"]');
            dataContainer.innerHTML = ""; // Limpiar el contenedor

            if (selectedOption === "encuesta") {
                // Ocultar el contenedor de datos y mostrar las gráficas de pastel
                dataContainer.style.display = "none";
                encuestaCharts.forEach(chart => chart.style.display = "block");

                // Llamar al servidor para obtener los datos de la encuesta
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        var encuestaData = JSON.parse(this.responseText);
                        renderCharts(encuestaData);
                    }
                };
                xhttp.open("GET", "../../Models/conexion_datos.php?option=" + selectedOption, true);
                xhttp.send();

            } else {
                // Mostrar los datos de la tabla como antes
                dataContainer.style.display = "block";
                encuestaCharts.forEach(chart => chart.style.display = "none");

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        dataContainer.innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "../../Models/conexion_datos.php?option=" + selectedOption, true);
                xhttp.send();
            }
        }

        // Función para renderizar las gráficas de pastel de la encuesta
        function renderCharts(data) {
            for (let i = 1; i <= 9; i++) {
                let chartId = `encuestaChart${i}`;
                let ctx = document.getElementById(chartId).getContext('2d');
                let labels = [];
                let counts = [];

                data.forEach(item => {
                    labels.push(item[`pregunta${i}`]);
                    counts.push(item[`count${i}`]);
                });

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: `Pregunta ${i}`,
                            data: counts,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        }

        // Función para buscar datos en la tabla
        function searchData() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("dataContainer").getElementsByTagName('table')[0];
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }

        // Función para descargar archivo PDF con los datos de la base de datos
        function downloadPDF() {
            var selectedOption = document.getElementById("selectData").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    var doc = new jsPDF();
                    doc.autoTable({ html: '#dataContainer' });
                    doc.save("data_pdf.pdf");
                }
            };
            xhttp.open("GET", "../../Models/conexion_datos.php?option=" + selectedOption + "&format=pdf", true);
            xhttp.send();
        }
    </script>

    <!-- Inclusión de la biblioteca jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</body>

</html>
