<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Registro</title>
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
        body {
            background: #ffffff;
            margin: 0; /* Elimina el margen por defecto del body */
        }

        .container-xxl {
            padding: 20px; /* Añade un padding general a la vista */
        }

        .container-fluid {
            padding: 5px; /* Agrega espacio entre el borde de la ventana y el contenido */
        }

        .form-container {
            max-width: 500px;
            margin: 20px auto;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 0 15px 4px rgba(0, 128, 0, 0.7);
        }

        .form-control {
            border-radius: 10px; /* Ajusta este valor para modificar la curvatura */
        }

        /* Añadir padding en pantallas más pequeñas */
        @media (max-width: 384px) {
            .form-container {
                margin: 50px;
            }
        }

        .position-relative {
            position: relative;
        }

        .icono-correo {
            position: absolute;
            right: 10px; /* Ajusta la distancia del borde derecho */
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none; /* Evita que el ícono interfiera con el clic en el input */
        }

        .icono-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer; /* Hace que el icono sea clicable */
        }

        .form-select {
            border-radius: 10px !important;
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

        .btn-register {
            background-color: #28a745; /* Color de fondo igual al del footer */
            color: white; /* Color del texto del botón */
            border: none; /* Elimina el borde del botón */
        }

        .btn-register:hover {
            background-color: #218838; /* Color de fondo al pasar el ratón sobre el botón */
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner de carga -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Fin del Spinner -->

        <!-- Formulario de registro -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="form-container">
                    <!-- Agrega la clase "card" aquí -->
                    <div class="card">
                        <div class="card-body">
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
                            <form method="post" action="../../Models/conexion.php">
                                <div class="form-row d-flex justify-content-between">
                                    <div class="form-group flex-grow-1 me-2">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingNombre" name="nombre" placeholder="Nombre" required>
                                            <label for="floatingNombre">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="form-group flex-grow-1">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingAPaterno" name="apellido_paterno" placeholder="Apellido Paterno" required>
                                            <label for="floatingAPaterno">Apellido Paterno</label>
                                        </div>
                                    </div>
                                </div>
                            <div class="form-row d-flex justify-content-between">
                                <div class="form-group flex-grow-1 me-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingAMaterno" name="apellido_materno"
                                            placeholder="Apellido Materno" required>
                                        <label for="floatingAMaterno">Apellido Materno</label>
                                    </div>
                                </div>
                                <div class="form-group flex-grow-1">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingMatricula" name="matricula"
                                            placeholder="Matrícula" required>
                                        <label for="floatingMatricula">Matrícula</label>
                                    </div>
                                </div>
                            </div>
                                <!-- Fila para Correo Electrónico y Contraseña -->
                                <div class="form-row d-flex justify-content-between">
                                    <div class="form-group flex-grow-1 me-2">
                                        <div class="form-floating mb-3 position-relative">
                                            <input type="email" class="form-control" id="floatingInput" name="correo"
                                                placeholder="correo@ejemplo.com" required>
                                            <label for="floatingInput">Correo Electrónico</label>
                                            <span class="icono-correo">
                                                <img src="../home/images/Correo_icon.png" alt="Icono de correo" style="max-width: 20px; height: auto;">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group flex-grow-1">
                                    <div class="form-floating mb-3 position-relative">
                                        <input type="password" class="form-control" id="floatingPassword" name="contraseña"
                                            placeholder="Contraseña" required>
                                        <label for="floatingPassword">Contraseña</label>
                                        <span class="icono-password" id="togglePassword" onclick="togglePasswordVisibility()">
                                            <img src="../home/images/Contra_icon.png" alt="Icono de contraseña" style="max-width: 20px; height: auto;" id="passwordIcon">
                                        </span>
                                    </div>
                                    </div>
                                </div>
                                <!-- Fila para Carrera y Género -->
                                <div class="form-row d-flex justify-content-between">
                                    <div class="form-group col-6 me-2">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="floatingCarrera" name="carrera" required>
                                                <option value="" selected>-----</option>
                                                <option value="Ing. Industrial">Ing. Industrial</option>
                                                <option value="Ing. en Sistemas Computacionales">Ing. en Sistemas Computacionales</option>
                                                <option value="Ing. Química">Ing. Química</option>
                                                <option value="Ing. Mecatrónica">Ing. Mecatrónica</option>
                                                <option value="Ing. en Animación y Efectos Visuales">Ing. en Animación y Efectos Visuales</option>
                                                <option value="Lic. en Administración">Lic. en Administración</option>
                                                <option value="Lic. en Gastronomía">Lic. en Gastronomía</option>
                                                <option value="Docente">Docente</option>
                                                <option value="Estudiante foráneo">Estudiante foráneo</option>
                                            </select>
                                            <label for="floatingCarrera">Carrera</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="floatingGenero" name="genero" required>
                                                <option value="" selected>-----</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                            <label for="floatingGenero">Género</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success py-2 btn-register d-block mx-auto" name="registrar">Registrarse</button>
                            </form>
                            <p class="text-center mb-0 login-link">¿Ya tienes una cuenta? <a href="signin.php">Iniciar Sesión</a></p>
                            <p class="text-center mb-0 privacy-link" data-bs-toggle="modal" data-bs-target="#privacyModal">¿Te preocupa la privacidad? <a href="#">Política de Privacidad</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Política de Privacidad -->
        <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="privacyModalLabel">Política de Privacidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="../home/images/teschi_logo.gif" alt="Imagen TESCHI" style="max-width: 200px; max-height: 175px;">
                        <h6>Técnologico de Estudios Superiores de Chimalhuacán</h6>
                        <h6>Política de Privacidad</h6>
                        <p><strong>ISO/IEC 27000: Gestión de la Seguridad de la Información - Resumen</strong></p>
                        <p><strong>1. Introducción</strong></p>
                        <p>
                            La norma ISO/IEC 27000 proporciona una introducción a la serie de normas ISO/IEC 27000 sobre la gestión de la seguridad de la información. Define los términos y conceptos fundamentales relacionados con el Sistema de Gestión de Seguridad de la Información (SGSI).
                        </p>
                        <p><strong>2. Alcance</strong></p>
                        <p>
                            Esta norma es aplicable a todas las organizaciones que buscan entender y aplicar conceptos de gestión de seguridad de la información. La implementación de un SGSI basado en esta norma ayuda a proteger la confidencialidad, integridad y disponibilidad de la información.
                        </p>
                        <p><strong>3. Objetivos de la Seguridad de la Información</strong></p>
                        <ul>
                            <li>Confidencialidad: Asegurar que la información esté disponible solo para aquellos autorizados a acceder a ella.</li>
                            <li>Integridad: Asegurar la precisión y completitud de la información y los métodos de procesamiento.</li>
                            <li>Disponibilidad: Asegurar que los usuarios autorizados tengan acceso a la información y a los activos asociados cuando lo requieran.</li>
                        </ul>
                        <p><strong>4. Principios de la Seguridad de la Información</strong></p>
                        <p>
                            La seguridad de la información se basa en tres principios fundamentales:
                        </p>
                        <ul>
                            <li>Confidencialidad: Protege la información de accesos no autorizados.</li>
                            <li>Integridad: Garantiza que la información y los métodos de procesamiento permanezcan intactos y sin alteraciones no autorizadas.</li>
                            <li>Disponibilidad: Asegura que los recursos de información estén disponibles cuando sean necesarios.</li>
                        </ul>
                        <p><strong>5. Objetivos de un Sistema de Gestión de Seguridad de la Información (SGSI)</strong></p>
                        <ul>
                            <li>Establecer un marco de gestión para identificar y gestionar los riesgos de seguridad de la información.</li>
                            <li>Proteger la información contra amenazas y vulnerabilidades que podrían comprometer la seguridad.</li>
                            <li>Mejorar continuamente la eficacia del SGSI.</li>
                        </ul>
                        <p><strong>6. Implementación de la Seguridad de la Información</strong></p>
                        <ul>
                            <li>Política de Seguridad: Desarrollar una política que defina los objetivos y la dirección en relación con la seguridad de la información.</li>
                            <li>Evaluación de Riesgos: Realizar una evaluación de riesgos para identificar y valorar los riesgos a la seguridad de la información.</li>
                            <li>Controles de Seguridad: Implementar controles de seguridad para mitigar los riesgos identificados y proteger la información.</li>
                        </ul>
                        <p><strong>7. Cumplimiento y Auditoría</strong></p>
                        <ul>
                            <li>Cumplimiento: Asegurar que las prácticas de seguridad de la información cumplan con los requisitos legales, reglamentarios y contractuales.</li>
                            <li>Auditoría: Realizar auditorías periódicas para verificar la conformidad con la política de seguridad y los procedimientos establecidos.</li>
                        </ul>
                        <p><strong>8. Mejora Continua</strong></p>
                        <p>
                            Revisar regularmente el SGSI y realizar ajustes según sea necesario para abordar nuevos riesgos y cambios en el entorno.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <!-- Contenedor para la imagen y el texto -->
            <div style="display: flex; align-items: center; justify-content: center;">
                <!-- Texto -->
                <p>Técnologico de Estudios Superiores de Chimalhuacán</p>
                <!-- Imagen -->
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
            
            // Cambia el tipo de input entre 'password' y 'text'
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.src = '../home/images/Contra_open.png'; // Cambia al ícono para mostrar contraseña
            } else {
                passwordInput.type = 'password';
                passwordIcon.src = '../home/images/Contra_icon.png'; // Cambia de vuelta al ícono original
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const carreraSelect = document.getElementById('floatingCarrera');
            const matriculaInput = document.getElementById('floatingMatricula');
            let ultimoNumeroMatricula = 1;

            carreraSelect.addEventListener('change', function () {
                if (carreraSelect.value === 'Estudiante foraneo') {
                    const year = new Date().getFullYear();
                    const matricula = `DPI${year}${ultimoNumeroMatricula.toString().padStart(3, '0')}`;
                    ultimoNumeroMatricula++;
                    matriculaInput.value = matricula;
                    matriculaInput.setAttribute('readonly', true);
                } else {
                    matriculaInput.value = '';
                    matriculaInput.removeAttribute('readonly');
                }
            });
        });
    </script>
</body>

</html>
