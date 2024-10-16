<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "plataformaconstancias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Identificar la página actual
$current_page = basename($_SERVER['SCRIPT_NAME']);

// Obtener los datos de las celdas para mostrar en la página
$id_grupo = isset($_GET['id_grupo']) ? $_GET['id_grupo'] : 1; // Por defecto, mostrar Nuevos Cursos
$sql = "SELECT c.Celda, cu.nombre_curso, cu.descripcion, cu.costo, cu.nombre_imagen, cu.ruta, i.nombre_instructor 
        FROM Celdas c
        LEFT JOIN Cursos cu ON c.Curso = cu.cursoid
        LEFT JOIN instructor i ON cu.instructor = i.idprofesor
        WHERE c.Grupo_Curso = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_grupo);
$stmt->execute();
$result = $stmt->get_result();

$celdas = [];
while ($row = $result->fetch_assoc()) {
    $celdas[$row['Celda']] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Subir Imágenes</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        .select-carpeta {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }
        .select-carpeta .cuadro-carpeta {
            border: 2px solid #ccc;
            padding: 20px;
            margin: 0 30px;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(105, 105, 105, 0.7);
        }
        .celdas-imagenes {
            margin-top: 30px;
        }
        .celdas-imagenes .col {
            margin-bottom: 20px;
            text-align: center;
        }
        .celdas-imagenes .card {
            margin-top: 50px;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
            box-shadow: 0 0 15px rgba(105, 105, 105, 0.7);
        }
        .celdas-imagenes .card:hover {
            transform: translateY(-5px);
        }
        .container.mt-3 {
            text-align: center;
        }
        .celdas-imagenes .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .celdas-imagenes .col {
            flex: 0 0 30%;
            max-width: 30%;
        }
        .btn-container {
            display: flex;
            justify-content: center;
        }
        .btn-primary, .btn-info {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .btn-primary:hover, .btn-info:hover {
            background-color: #218838;
            border-color: #1e7e34;
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
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
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
            <!-- Selección de carpeta -->
            <div class="select-carpeta">
                <div class="cuadro-carpeta" onclick="seleccionarCarpeta('Nuevos Cursos')">
                    <h5>Nuevos Cursos</h5>
                </div>
                <div class="cuadro-carpeta" onclick="seleccionarCarpeta('Próximas Ofertas')">
                    <h5>Próximas Ofertas</h5>
                </div>
            </div>

            <!-- Celdas para subir imágenes -->
            <div class="container celdas-imagenes">
                <div class="row" id="celdas-imagenes">
                    <?php
                    for ($i = 1; $i <= 9; $i++) {
                        $celda_id = "Celda $i";
                        $curso = isset($celdas[$celda_id]) ? $celdas[$celda_id] : null;
                        echo '<div class="col">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo "<h5 class='card-title'>Celda $i</h5>";
                        if ($curso) {
                            echo "<p class='card-text'>Imagen cargada</p>";
                            echo "<button class='btn btn-info' onclick=\"verInformacion('$celda_id')\">Ver Información</button>";
                            echo "<button class='btn btn-danger' onclick=\"quitarImagen('$celda_id', $id_grupo)\">Quitar Imagen</button>";
                        } else {
                            echo "<p class='card-text'>No hay imagen cargada</p>";
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Información del Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="infoModalBody">
                    <!-- Aquí se cargará la información del curso -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

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
        function seleccionarCarpeta(carpeta) {
            const id_grupo = carpeta === 'Nuevos Cursos' ? 1 : 2;
            window.location.href = `subir_img.php?id_grupo=${id_grupo}`;
        }

        function verInformacion(celda , grupo = <?php echo $id_grupo; ?>) {
            $.ajax({
                url: '../../Models/obtener_imagenes.php?action=informacion',
                type: 'GET',
                data: { celda: celda, grupo: grupo},
                success: function(response) {
                    const data = JSON.parse(response);
                    let infoHtml = `<p><strong>Nombre del curso:</strong> ${data.nombre_curso}</p>`;
                    infoHtml += `<p><strong>Descripción:</strong> ${data.descripcion}</p>`;
                    infoHtml += `<p><strong>Costo:</strong> ${data.costo}</p>`;
                    infoHtml += `<p><strong>Instructor:</strong> ${data.nombre_instructor}</p>`;
                    infoHtml += `<img src='../../Models/cursos/${data.ruta}' alt='${data.nombre_curso}' style='width: 100%;'>`;
                    $('#infoModalBody').html(infoHtml);
                    $('#infoModal').modal('show');
                }
            });
        }

        function quitarImagen(celda, grupo) {
            $.ajax({
                url: '../../Models/obtener_imagenes.php?action=eliminar',
                type: 'POST',
                data: { celda: celda, grupo: grupo },
                success: function(response) {
                    if (response.trim() === 'success') {
                        alert('Imagen eliminada exitosamente');
                        location.reload();
                    } else {
                        alert('Error al eliminar la imagen');
                    }
                }
            });
        }
    </script>
</body>
</html>
