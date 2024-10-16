<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    require_once '../../Models/conexion.php'; // Asegúrate de que la ruta es correcta

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    
    // Llamar a la función de inicio de sesión y manejar el mensaje de error
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>DASHMIN - Plantilla de Administración Bootstrap</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Hoja de estilos de la fuente de iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/../pruebas.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/../pruebas.css" rel="stylesheet">

    <!-- Hojas de estilos de las librerías -->
    <link href="../pruebas.css" rel="stylesheet">
    <link href="../pruebas.css" rel="stylesheet" />

    <!-- Hojas de estilos personalizadas de Bootstrap -->
    <link href="../pruebas.css" rel="stylesheet">

    <!-- Hojas de estilos de la plantilla -->
    <link href="../pruebas.css" rel="stylesheet">

    <style>
        /* Aplicar fondo blanco a la página */
        body {
            background: #ffffff;
        }

        .form-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 128, 0, 0.7); /* Sombra verde más oscura */
            background-color: #ffffff; /* Fondo blanco para la ventana de registro de datos */
        }

        .container-xxl {
            background: transparent; /* Fondo transparente para que se vea el fondo blanco de la página */
        }

        #spinner {
            background: transparent !important; /* Fondo transparente para que se vea el fondo blanco de la página */
        }

        .form-container .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            width: 100%;
            font-size: 1rem; /* Aumentar tamaño de fuente del botón */
            padding: 10px 15px; /* Ajuste de tamaño */
        }

        .form-container .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .form-container input[type="email"],
        .form-container input[type="password"] {
            border-radius: 20px;
            padding-right: 40px;
            border: 2px solid #ccc; /* Color de borde por defecto */
        }

        .form-container input[type="email"]:focus,
        .form-container input[type="password"]:focus {
            border-color: #28a745; /* Color verde cuando el campo está enfocado */
            outline: none; /* Elimina el contorno azul predeterminado del navegador */
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

        /* Estilo personalizado para el modal */
        .modal-dialog.custom-width {
            max-width: 90%; /* Ancho del modal como un porcentaje de la pantalla */
        }

        .modal-content {
            height: auto; /* Ajusta la altura automáticamente */
        }
    </style>
</head>
<body>
    <div class="container-xxl position-relative d-flex p-0">
        <!-- Spinner de carga -->
        <div id="spinner"
            class="show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Fin del Spinner -->

        <!-- Formulario de inicio de sesión -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="form-container">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <a href="../home/index.php" class="">
                            <img src="../home/images/logoTESCHI.jpg" alt="Imagen TESCHI" style="max-width: 200px; max-height: 150px;">
                        </a>
                    </div>
                    <h3 class="text-center mb-4"></h3>
                    <?php
                    if (isset($errorMessage) && $errorMessage) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($errorMessage) . '</div>';
                    }
                    ?>
                    <form method="post" action="signin.php<?php echo isset($_GET['curso']) ? '?curso=' . urlencode($_GET['curso']) : ''; ?>">
                        <div class="form-floating mb-3 input-group">
                            <input type="email" class="form-control" name="correo" id="floatingInput"
                                placeholder="correo@ejemplo.com" required>
                            <label for="floatingInput">Correo Electrónico</label>
                            <!-- Icono personalizado -->
                            <span class="input-group-text">
                                <img src="../home/images/Correo_icon.png" alt="Icono de correo" style="max-width: 20px; height: auto;">
                            </span>
                        </div>
                        <div class="form-floating mb-4 input-group">
                            <input type="password" class="form-control" name="contraseña" id="floatingPassword"
                                placeholder="Contraseña" required>
                            <label for="floatingPassword">Contraseña</label>
                            <!-- Icono personalizado para mostrar/ocultar la contraseña -->
                            <span class="input-group-text" id="togglePassword" onclick="togglePasswordVisibility()">
                                <img src="../home/images/Contra_icon.png" alt="Icono de contraseña" style="max-width: 20px; height: auto;" id="passwordIcon">
                            </span>
                        </div>
                        <button type="submit" class="btn btn-primary py-3" name="login">Iniciar Sesión</button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="mb-0">¿No tienes una cuenta? <a href="signup.php">Regístrate</a></p>
                        <p class="mb-0"> <a href="#" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal">Política de Privacidad</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div style="display: flex; align-items: center; justify-content: center;">
                <p>Técnologico de Estudios Superiores de Chimalhuacán</p>
            </div>
        </div>
    </div>

    <!-- Modal de Política de Privacidad -->
    <div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-labelledby="privacyPolicyModalLabel" aria-hidden="true">
        <div class="modal-dialog custom-width">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyPolicyModalLabel">Política de Privacidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <img src="../home/images/teschi_logo.gif" alt="Imagen TESCHI" style="max-width: 200px; max-height: 175px;">
                    <h6>ISO/IEC 27000: Gestión de la Seguridad de la Información - Resumen</h6>
                    <p><strong>1. Introducción</strong></p>
                    <p>La norma ISO/IEC 27000 proporciona una introducción a la serie de normas ISO/IEC 27000 sobre la gestión de la seguridad de la información. Define los términos y conceptos fundamentales relacionados con el Sistema de Gestión de Seguridad de la Información (SGSI).</p>

                    <p><strong>2. Alcance</strong></p>
                    <p>Esta norma es aplicable a todas las organizaciones que buscan entender y aplicar conceptos de gestión de seguridad de la información. La implementación de un SGSI basado en esta norma ayuda a proteger la confidencialidad, integridad y disponibilidad de la información.</p>

                    <p><strong>3. Objetivos de la Seguridad de la Información</strong></p>
                    <ul>
                        <li><strong>Confidencialidad:</strong> Asegurar que la información esté disponible solo para aquellos autorizados a acceder a ella.</li>
                        <li><strong>Integridad:</strong> Asegurar la precisión y completitud de la información y los métodos de procesamiento.</li>
                        <li><strong>Disponibilidad:</strong> Asegurar que los usuarios autorizados tengan acceso a la información y a los activos asociados cuando lo requieran.</li>
                    </ul>

                    <p><strong>4. Principios de la Seguridad de la Información</strong></p>
                    <p>La seguridad de la información se basa en tres principios fundamentales:</p>
                    <ul>
                        <li><strong>Confidencialidad:</strong> Protege la información de accesos no autorizados.</li>
                        <li><strong>Integridad:</strong> Garantiza que la información y los métodos de procesamiento permanezcan intactos y sin alteraciones no autorizadas.</li>
                        <li><strong>Disponibilidad:</strong> Asegura que los recursos de información estén disponibles cuando sean necesarios.</li>
                    </ul>

                    <p><strong>5. Objetivos de un Sistema de Gestión de Seguridad de la Información (SGSI)</strong></p>
                    <ul>
                        <li>Establecer un marco de gestión para identificar y gestionar los riesgos de seguridad de la información.</li>
                        <li>Proteger la información contra amenazas y vulnerabilidades que podrían comprometer la seguridad.</li>
                        <li>Mejorar continuamente la eficacia del SGSI.</li>
                    </ul>

                    <p><strong>6. Implementación de la Seguridad de la Información</strong></p>
                    <ul>
                        <li><strong>Política de Seguridad:</strong> Desarrollar una política que defina los objetivos y la dirección en relación con la seguridad de la información.</li>
                        <li><strong>Evaluación de Riesgos:</strong> Realizar una evaluación de riesgos para identificar y valorar los riesgos a la seguridad de la información.</li>
                        <li><strong>Controles de Seguridad:</strong> Implementar controles de seguridad para mitigar los riesgos identificados y proteger la información.</li>
                    </ul>

                    <p><strong>7. Cumplimiento y Auditoría</strong></p>
                    <ul>
                        <li><strong>Cumplimiento:</strong> Asegurar que las prácticas de seguridad de la información cumplan con los requisitos legales, reglamentarios y contractuales.</li>
                        <li><strong>Auditoría:</strong> Realizar auditorías periódicas para verificar la conformidad con la política de seguridad y los procedimientos establecidos.</li>
                    </ul>

                    <p><strong>8. Mejora Continua</strong></p>
                    <p>Revisar regularmente el SGSI y realizar ajustes según sea necesario para abordar nuevos riesgos y cambios en el entorno.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bibliotecas de JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- JavaScript de la plantilla -->
    <script src="js/main.js"></script>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('floatingPassword');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.src = '../home/images/Contra_open.png'; // Cambia al ícono para mostrar contraseña
            } else {
                passwordInput.type = 'password';
                passwordIcon.src = '../home/images/Contra_icon.png'; // Cambia al ícono original
            }
        }
    </script>
</body>
</html>