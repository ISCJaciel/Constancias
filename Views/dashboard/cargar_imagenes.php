<?php
// Aquí va la configuración de conexión a la base de datos
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

// Procesar solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $curso_id = $_POST['delete_id'];
    
    // Eliminar filas relacionadas en la tabla celdas
    $sql = "DELETE FROM celdas WHERE Curso = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $curso_id);
    $stmt->execute();
    $stmt->close();

    // Eliminar el curso de la tabla cursos
    $sql = "DELETE FROM cursos WHERE cursoid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $curso_id);
    if ($stmt->execute()) {
        echo "<script>alert('Curso eliminado exitosamente.');</script>";
    } else {
        echo "<script>alert('Error al eliminar el curso.');</script>";
    }
    $stmt->close();
}
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

        .form-horizontal .form-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 15px;
        }
        .form-horizontal .form-group label {
            width: 200px;
            margin-right: 20px;
            font-size: 16px; /* Aumentar el tamaño de la letra */
        }
        .form-horizontal .form-group .form-control {
            flex: 1;
            font-size: 16px; /* Aumentar el tamaño de la letra */
        }
        .btn-primary, .btn-warning, .btn-danger, .btn-secondary {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            font-size: 16px; /* Aumentar el tamaño de la letra */
        }
        .btn-primary:hover, .btn-warning:hover, .btn-danger:hover, .btn-secondary:hover {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
        }
        .navbar-nav .nav-link.active {
            background-color: #28a745;
            color: white;
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

            <!-- Formulario para cargar imágenes -->
            <div class="container pt-4 px-4">
                <h6 class="text-center mb-4 display-6 fw-bold">Cargar Imagen de Curso</h6>
                <form id="uploadForm" action="../../Models/conexion_img.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group">
                        <label for="imagen_curso">Imagen del Curso:</label>
                        <input type="file" class="form-control" id="imagen_curso" name="imagen_curso">
                        <div id="imagen_curso_help" class="form-text">Por favor, seleccione una imagen para el curso.</div>
                    </div>
                    <div class="form-group">
                        <label for="nombre_curso">Nombre del Curso:</label>
                        <input type="text" class="form-control" id="nombre_curso" name="nombre_curso">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción del Curso:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="costo">Costo del Curso:</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" id="costo" name="costo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_grupo">Grupo:</label>
                        <select class="form-select" id="id_grupo" name="id_grupo">
                            <?php
                            // Consulta para obtener los grupos de la base de datos
                            $sql = "SELECT id_grupo, nombre FROM grupo_curso";
                            $result = $conn->query($sql);

                            // Verificar si hay grupos
                            if ($result->num_rows > 0) {
                                // Iterar sobre los resultados y crear opciones para el menú desplegable
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id_grupo'] . "'>" . $row['nombre'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No hay grupos disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="celda">Celda:</label>
                        <select class="form-select" id="celda" name="celda">
                            <?php
                            for ($i = 1; $i <= 9; $i++) {
                                echo "<option value='Celda $i'>Celda $i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="instructor">Instructor:</label>
                        <select class="form-select" id="instructor" name="instructor">
                            <?php
                            // Consulta para obtener los instructores de la base de datos
                            $sql = "SELECT idprofesor, nombre_instructor FROM instructor";
                            $result = $conn->query($sql);

                            // Verificar si hay instructores
                            if ($result->num_rows > 0) {
                                // Iterar sobre los resultados y crear opciones para el menú desplegable
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['idprofesor'] . "'>" . $row['nombre_instructor'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No hay instructores disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir Imagen</button>
                </form>

                <!-- Botón para abrir el modal de cursos cargados -->
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cursosModal">
                        Mostrar Cursos
                    </button>
                </div>

                <!-- Modal para mostrar cursos cargados -->
                <div class="modal fade" id="cursosModal" tabindex="-1" aria-labelledby="cursosModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cursosModalLabel">Cursos Cargados</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Costo</th>
                                            <th>Grupo</th>
                                            <th>Instructor</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Consulta para obtener los cursos
                                        $sql = "SELECT c.cursoid, c.nombre_curso, c.descripcion, c.costo, g.nombre AS grupo_nombre, i.nombre_instructor
                                                FROM cursos c
                                                JOIN grupo_curso g ON c.id_grupo = g.id_grupo
                                                JOIN instructor i ON c.instructor = i.idprofesor";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $curso_id = $row['cursoid'];
                                                $nombre_curso = $row['nombre_curso'];
                                                $descripcion = $row['descripcion'];
                                                $costo = $row['costo'];
                                                $grupo_nombre = $row['grupo_nombre'];
                                                $nombre_instructor = $row['nombre_instructor'];
                                                echo "<tr>
                                                    <td>{$curso_id}</td>
                                                    <td>{$nombre_curso}</td>
                                                    <td>{$descripcion}</td>
                                                    <td>{$costo}</td>
                                                    <td>{$grupo_nombre}</td>
                                                    <td>{$nombre_instructor}</td>
                                                    <td>
                                                        <button class='btn btn-warning' onclick='editarCurso({$curso_id})'>Editar</button>
                                                        <button class='btn btn-danger' onclick='confirmarEliminar({$curso_id})'>Borrar</button>
                                                    </td>
                                                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7' class='text-center'>No hay cursos cargados</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario oculto para enviar solicitud de eliminación -->
                <form id="deleteForm" method="post" style="display:none;">
                    <input type="hidden" id="delete_id" name="delete_id">
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
        // Función para confirmar la eliminación del curso
        function confirmarEliminar(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este curso?")) {
                document.getElementById('delete_id').value = id;
                document.getElementById('deleteForm').submit();
            }
        }

        // Función para editar el curso
        function editarCurso(id) {
            window.location.href = 'editar_curso.php?id=' + id;
        }

        // Función para mostrar la notificación y recargar la página después de un tiempo
        function showNotificationAndReload() {
            // Mostrar notificación
            alert("La imagen se ha subido con éxito.");
            // Recargar la página después de aceptar la alerta
            location.reload();
        }

        // Agregar un evento de escucha para el envío del formulario
        document.getElementById("uploadForm").addEventListener("submit", function (event) {
            // Prevenir el envío del formulario por defecto
            event.preventDefault();
            // Enviar el formulario usando AJAX
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", this.action, true);
            xhr.onload = function () {
                // Verificar si la respuesta es satisfactoria
                if (xhr.status === 200) {
                    // Mostrar la notificación y recargar la página
                    showNotificationAndReload();
                } else {
                    // En caso de error, mostrar un mensaje de error
                    alert("Error al subir la imagen. Por favor, inténtalo de nuevo.");
                }
            };
            xhr.send(formData);
        });

        function logout() {
            // Cambiar la ubicación actual del navegador a la página principal
            window.location.href = "../home/index.php"; // Cambia "index.php" por la URL de tu página principal
        }
    </script>
</body>

</html>
