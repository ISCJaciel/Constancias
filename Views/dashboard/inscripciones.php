<?php

// inscripciones.php

// Función para conectar a la base de datos
function conectarBaseDeDatos() {
    $servidor = "localhost";
    $usuario = "root";
    $contraseña = "1234";
    $basededatos = "plataformaconstancias";

    $conexion = new mysqli($servidor, $usuario, $contraseña, $basededatos);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    return $conexion;
}

// Conectar a la base de datos
$conn = conectarBaseDeDatos();

// Identificar la página actual
$current_page = basename($_SERVER['SCRIPT_NAME']);

// Manejar la actualización del estado de la inscripción
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['actualizar_estado'])) {
        $inscripcionId = $_POST['inscripcion_id'];
        $usuarioId = $_POST['usuario_id'];
        $nuevoEstado = $_POST['nuevo_estado'] ?? '';

        if ($nuevoEstado === 'eliminar') {
            // Mostrar el modal de confirmación
            echo "<script>
                    if (confirm('¿Estás seguro de que deseas eliminar esta inscripción?')) {
                        window.location.href = 'inscripciones.php?eliminar=1&inscripcion_id={$inscripcionId}&usuario_id={$usuarioId}';
                    }
                  </script>";
        } else {
            $sqlActualizarEstado = "UPDATE inscripcion SET estado_inscripcion = ? WHERE curso = ? AND usuario = ?";
            $stmt = $conn->prepare($sqlActualizarEstado);
            $stmt->bind_param("sii", $nuevoEstado, $inscripcionId, $usuarioId);
            $stmt->execute();
            $stmt->close();
        }
    }

    if (isset($_POST['terminar_curso'])) {
        $inscripcionId = $_POST['inscripcion_id'];
        $usuarioId = $_POST['usuario_id'];
        $nombre = $_POST['nombre'];
        $apellidoPaterno = $_POST['apellido_paterno'];
        $apellidoMaterno = $_POST['apellido_materno'];

        echo "<script>
                const modalHtml = `
                    <div class='modal fade' id='confirmModal' tabindex='-1' aria-labelledby='confirmModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='confirmModalLabel'>Confirmación</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-body'>
                                    ¿Estás seguro que el alumno {$nombre} {$apellidoPaterno} {$apellidoMaterno} terminó el curso?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                    <form method='post' action='inscripciones.php'>
                                        <input type='hidden' name='inscripcion_id' value='{$inscripcionId}'>
                                        <input type='hidden' name='usuario_id' value='{$usuarioId}'>
                                        <input type='hidden' name='confirm_terminado' value='1'>
                                        <button type='submit' class='btn btn-primary'>Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();
              </script>";
    }
}
// Manejar la actualización de nombre y apellidos del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_datos'])) {
    $usuarioId = $_POST['usuario_id'];
    $nuevoNombre = $_POST['nuevo_nombre'];
    $nuevoApellidoPaterno = $_POST['nuevo_apellido_paterno'];
    $nuevoApellidoMaterno = $_POST['nuevo_apellido_materno'];

    $sqlActualizarDatos = "UPDATE usuarios SET nombre = ?, apellido_paterno = ?, apellido_materno = ? WHERE usuarioid = ?";
    $stmt = $conn->prepare($sqlActualizarDatos);
    $stmt->bind_param("ssss", $nuevoNombre, $nuevoApellidoPaterno, $nuevoApellidoMaterno, $usuarioId);
    $stmt->execute();
    $stmt->close();

    // Recargar la página para reflejar los cambios
    echo "<script>window.location.href='inscripciones.php';</script>";
    exit();
}
// Manejar la confirmación de "terminado"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_terminado']) && $_POST['confirm_terminado'] == '1') {
    $inscripcionId = $_POST['inscripcion_id'];
    $usuarioId = $_POST['usuario_id'];
    $sqlActualizarEstado = "UPDATE inscripcion SET estado_inscripcion = 'terminado' WHERE curso = ? AND usuario = ?";
    $stmt = $conn->prepare($sqlActualizarEstado);
    $stmt->bind_param("ii", $inscripcionId, $usuarioId);
    $stmt->execute();
    $stmt->close();

    // Recargar la página para reflejar los cambios
    echo "<script>window.location.href='inscripciones.php';</script>";
    exit();
}

// Manejar la eliminación de la inscripción
if (isset($_GET['eliminar']) && $_GET['eliminar'] == 1) {
    $inscripcionId = $_GET['inscripcion_id'];
    $usuarioId = $_GET['usuario_id'];
    $sqlEliminar = "DELETE FROM inscripcion WHERE curso = ? AND usuario = ?";
    $stmt = $conn->prepare($sqlEliminar);
    $stmt->bind_param("ii", $inscripcionId, $usuarioId);
    $stmt->execute();
    $stmt->close();
    // Recargar la página para reflejar los cambios
    echo "<script>window.location.href='inscripciones.php';</script>";
    exit();
}

// Obtener lista de cursos
$cursos = [];
$sqlCursos = "SELECT cursoid, nombre_curso FROM cursos";
$resultCursos = $conn->query($sqlCursos);
if ($resultCursos->num_rows > 0) {
    while ($row = $resultCursos->fetch_assoc()) {
        $cursos[] = $row;
    }
}

// Obtener lista de inscripciones si se ha seleccionado un curso
$inscripciones = [];
$cursoId = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['curso'])) {
    $cursoId = $_POST['curso'];
    $sqlInscripciones = "SELECT i.curso, i.usuario, u.nombre, u.apellido_paterno, u.apellido_materno, i.archivo_pago, i.estado_inscripcion
                         FROM inscripcion i
                         JOIN usuarios u ON i.usuario = u.usuarioid
                         WHERE i.curso = ?";
    $stmt = $conn->prepare($sqlInscripciones);
    $stmt->bind_param("i", $cursoId);
    $stmt->execute();
    $resultInscripciones = $stmt->get_result();
    if ($resultInscripciones->num_rows > 0) {
        while ($row = $resultInscripciones->fetch_assoc()) {
            $inscripciones[] = $row;
        }
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
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
        width: 0;
        overflow: hidden;
        transition: 0.5s;
        position: absolute;
        left: -250px;
        /* Ajusta este valor si tu barra lateral tiene un ancho diferente */
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
        /* Ajusta este valor según la altura de tu encabezado */
        min-height: 100vh;
        transition: 0.5s;
    }

    /* Ajuste para el encabezado */
    .navbar-custom {
        background-color: #f5f7f6 !important;
        /* Color de fondo del encabezado */
        width: calc(100% - 250px);
        /* El ancho debe ser el 100% menos el ancho de la barra lateral */
        position: fixed;
        /* Mantiene el navbar en la parte superior */
        top: 0;
        /* Coloca el navbar en la parte superior */
        left: 250px;
        /* Ajusta para que inicie justo después del sidebar */
        z-index: 999;
        /* Asegura que el encabezado esté por encima de otros elementos */
        transition: left 0.5s, width 0.5s;
    }

    #descargarWordForm {
        position: fixed;
        bottom: 20px;
        left: 270px;
        /* Posición del botón cuando el menú está visible */
        z-index: 1000;
        transition: left 0.5s;
        /* Transición suave del movimiento */
    }

    .sidebar.collapsed+.content #descargarWordForm {
        left: 20px;
        /* Posición del botón cuando el menú está oculto */
    }

    .content #descargarWordForm {
        left: 270px;
        /* Cuando el menú esté desplegado, ajusta el botón a la derecha del menú */
    }

    /* Tabla de inscripciones */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table td,
    .table th {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        color: #212529;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-success {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-warning {
        color: #212529;
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 1rem 1rem;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: 0.3rem;
        border-top-right-radius: 0.3rem;
    }

    .modal-body {
        position: relative;
        flex: 1 1 auto;
        padding: 1rem;
    }

    .modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 1rem;
        border-top: 1px solid #dee2e6;
    }

    .btn-close {
        padding: 0.75rem;
        border: none;
        background-color: transparent;
        cursor: pointer;
    }

    .modal.fade .modal-dialog {
        -webkit-transform: translate(0, -25%);
        transform: translate(0, -25%);
        transition: -webkit-transform 0.3s ease-out;
        transition: transform 0.3s ease-out;
        transition: transform 0.3s ease-out, -webkit-transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        -webkit-transform: none;
        transform: none;
    }

    .nav-item.nav-link.active {
        background-color: #e9ecef;
        /* Cambia el fondo de la opción activa */
        color: #007bff;
        /* Cambia el color del texto en la opción activa */
        font-weight: bold;
        /* Hace el texto más destacado */
        border-left: 4px solid #007bff;
        /* Añade una barra de color para mayor visibilidad */
    }

    .nav-item.nav-link.active img {
        filter: brightness(0) saturate(100%) invert(42%) sepia(92%) saturate(2974%) hue-rotate(199deg) brightness(95%) contrast(101%);
        /* Cambia el color del icono cuando está activo */
    }
    </style>
</head>

<body>

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
                <a href="index.php"
                    class="nav-item nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <i class="fa fa-tachometer-alt me-2"><img src="img/datos.png" width="40" height="40"></i>Visualizar
                    Datos
                </a>
                <a href="instructor.php"
                    class="nav-item nav-link <?php echo ($current_page == 'instructor.php') ? 'active' : ''; ?>">
                    <i class="fa fa-th me-2"><img src="img/instructor.png" width="40" height="40"></i>Instructor
                </a>
                <a href="cargar_imagenes.php"
                    class="nav-item nav-link <?php echo ($current_page == 'cargar_imagenes.php') ? 'active' : ''; ?>">
                    <i class="fa fa-th me-2"><img src="img/Cargar_icon.png" width="40" height="40"></i>Cargar Imágenes
                </a>
                <a href="subir_img.php"
                    class="nav-item nav-link <?php echo ($current_page == 'subir_img.php') ? 'active' : ''; ?>">
                    <i class="fa fa-th me-2"><img src="img/Subir_icon.png" width="40" height="40"></i>Subir Imágenes
                </a>
                <a href="datos.php"
                    class="nav-item nav-link <?php echo ($current_page == 'datos.php') ? 'active' : ''; ?>">
                    <i class="fa fa-th me-2"><img src="img/archivos.png" width="40" height="40"></i>Datos
                </a>
                <a href="graficas.php"
                    class="nav-item nav-link <?php echo ($current_page == 'graficas.php') ? 'active' : ''; ?>">
                    <i class="fa fa-th me-2"><img src="img/archivos.png" width="40" height="40"></i>Encuestas
                </a>
                <a href="inscripciones.php"
                    class="nav-item nav-link <?php echo ($current_page == 'inscripciones.php') ? 'active' : ''; ?>">
                    <i class="fa fa-th me-2"><img src="img/inscrip_icon.png" width="40" height="40"></i>Inscripciones
                </a>
                <div class="nav-item dropdown">
                </div>
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

        <div class="content">
            <h1>Gestión de Inscripciones</h1>
            <form method="post" action="inscripciones.php">
                <div class="mb-3">
                    <label for="cursoSelect" class="form-label">Selecciona un curso:</label>
                    <select id="cursoSelect" name="curso" class="form-control">
                        <option value="" disabled selected>Selecciona un curso</option>
                        <?php foreach ($cursos as $curso): ?>
                        <option value="<?php echo $curso['cursoid']; ?>"
                            <?php if ($cursoId == $curso['cursoid']) echo 'selected'; ?>>
                            <?php echo $curso['nombre_curso']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ver Inscripciones</button>
            </form>

            <div id="inscripcionesContainer" class="mt-4">
                <?php if (!empty($inscripciones)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre(s)</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>PDF de Pago</th>
                            <th>Estado</th>
                            <th>Actualizar Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inscripciones as $inscripcion): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($inscripcion['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion['apellido_paterno'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td><?php echo htmlspecialchars($inscripcion['apellido_materno'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td>
                                <?php if (!empty($inscripcion['archivo_pago'])): ?>
                                <a href="<?php echo htmlspecialchars($inscripcion['archivo_pago'], ENT_QUOTES, 'UTF-8'); ?>"
                                    target="_blank">Ver PDF</a>
                                <?php else: ?>
                                Pago no subido
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($inscripcion['estado_inscripcion'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td>
                                <form method="post" action="inscripciones.php" class="d-inline">
                                    <input type="hidden" name="inscripcion_id"
                                        value="<?php echo $inscripcion['curso']; ?>">
                                    <input type="hidden" name="usuario_id"
                                        value="<?php echo $inscripcion['usuario']; ?>">
                                    <input type="hidden" name="nombre"
                                        value="<?php echo htmlspecialchars($inscripcion['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="apellido_paterno"
                                        value="<?php echo htmlspecialchars($inscripcion['apellido_paterno'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="apellido_materno"
                                        value="<?php echo htmlspecialchars($inscripcion['apellido_materno'], ENT_QUOTES, 'UTF-8'); ?>">

                                    <select name="nuevo_estado" class="form-control mb-2">
                                        <option value="pendiente"
                                            <?php if ($inscripcion['estado_inscripcion'] == 'pendiente') echo 'selected'; ?>>
                                            Pendiente</option>
                                        <option value="inscrito"
                                            <?php if ($inscripcion['estado_inscripcion'] == 'inscrito') echo 'selected'; ?>>
                                            Inscrito a Curso</option>
                                        <option value="eliminar">Eliminar</option>
                                    </select>
                                    <button type="submit" name="actualizar_estado"
                                        class="btn btn-primary">Actualizar</button>
                                    <button type="button" class="btn btn-success"
                                        onclick="confirmTerminado('<?php echo $inscripcion['curso']; ?>', '<?php echo $inscripcion['usuario']; ?>', '<?php echo htmlspecialchars($inscripcion['nombre'], ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars($inscripcion['apellido_paterno'], ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars($inscripcion['apellido_materno'], ENT_QUOTES, 'UTF-8'); ?>')">Terminado</button>
                                    <button type="button" class="btn btn-warning"
                                        onclick="openEditModal('<?php echo $inscripcion['usuario']; ?>', '<?php echo htmlspecialchars($inscripcion['nombre'], ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars($inscripcion['apellido_paterno'], ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars($inscripcion['apellido_materno'], ENT_QUOTES, 'UTF-8'); ?>')">Editar
                                        Nombre</button>

                                </form>

                                <!-- Botón para generar el PDF -->
                                <form method="post" action="generar_word.php" id="descargarWordForm">
                                    <input type="hidden" name="curso" value="<?php echo $cursoId; ?>">
                                    <button type="submit" class="btn btn-info">Descargar Word</button>
                                </form>


                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>


            </div>
        </div>

        <!-- Modal de edición de nombre y apellidos -->
        <div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="editNameModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editNameModalLabel">Editar Datos de Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editNameForm" method="post" action="inscripciones.php">
                            <input type="hidden" name="usuario_id" id="editUsuarioId">
                            <div class="mb-3">
                                <label for="nuevoNombre" class="form-label">Nuevo Nombre</label>
                                <input type="text" class="form-control" id="nuevoNombre" name="nuevo_nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="nuevoApellidoPaterno" class="form-label">Nuevo Apellido Paterno</label>
                                <input type="text" class="form-control" id="nuevoApellidoPaterno"
                                    name="nuevo_apellido_paterno" required>
                            </div>
                            <div class="mb-3">
                                <label for="nuevoApellidoMaterno" class="form-label">Nuevo Apellido Materno</label>
                                <input type="text" class="form-control" id="nuevoApellidoMaterno"
                                    name="nuevo_apellido_materno" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="actualizar_datos">Guardar
                                Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        function logout() {
            // Cambiar la ubicación actual del navegador a la página principal
            window.location.href = "../home/index.php"; // Cambia "index.php" por la URL de tu página principal
        }

        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            const navbar = document.querySelector('.navbar-custom');
            const descargarWordForm = document.querySelector('#descargarWordForm');

            sidebar.classList.toggle('collapsed');
            content.classList.toggle('sidebar-collapsed');
            navbar.classList.toggle('sidebar-collapsed');

            // Ajustar la posición del botón conforme el menú se colapsa o expande
            if (sidebar.classList.contains('collapsed')) {
                descargarWordForm.style.left =
                '20px'; // Mueve el botón hacia la izquierda cuando el menú se oculta
            } else {
                descargarWordForm.style.left =
                '270px'; // Mueve el botón hacia la derecha cuando el menú está visible
            }
        });
        </script>

        <script>
        function confirmTerminado(curso, usuario, nombre, apellidoPaterno, apellidoMaterno) {
            const modalHtml = `
            <div class='modal fade' id='confirmModal' tabindex='-1' aria-labelledby='confirmModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='confirmModalLabel'>Confirmación</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            ¿Estás seguro que el alumno ${nombre} ${apellidoPaterno} ${apellidoMaterno} terminó el curso?
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                            <form method='post' action='inscripciones.php'>
                                <input type='hidden' name='inscripcion_id' value='${curso}'>
                                <input type='hidden' name='usuario_id' value='${usuario}'>
                                <input type='hidden' name='confirm_terminado' value='1'>
                                <button type='submit' class='btn btn-primary'>Confirmar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();
        }
        </script>
        <script src="js/modal.js"></script>
</body>

</html>