<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor MySQL está en otro lugar
$username = "root"; // Cambia esto por tu nombre de usuario de MySQL
$password = "1234"; // Cambia esto por tu contraseña de MySQL
$database = "plataformaconstancias"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Procesamiento del formulario de carga de imagen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se cargó correctamente la imagen
    if ($_FILES["imagen_curso"]["error"] == UPLOAD_ERR_OK) {
        $imagen_nombre = $_FILES["imagen_curso"]["name"]; // Nombre del archivo de imagen
        $imagen_temp = $_FILES["imagen_curso"]["tmp_name"]; // Nombre temporal del archivo

        // Definir la carpeta de destino donde se guardará la imagen
        $carpeta_destino = "cursos/"; // Cambia esto por la ruta donde quieras guardar las imágenes

        // Obtener la extensión del archivo de imagen
        $imagen_tipo = strtolower(pathinfo($imagen_nombre, PATHINFO_EXTENSION));

        // Verificar si la extensión es válida (solo JPG)
        if ($imagen_tipo == "jpg" || $imagen_tipo == "jpeg") {
            // Generar un nombre único para el archivo de imagen
            $nombre_unico = uniqid() . '.' . $imagen_tipo;

            // Mover el archivo de la ubicación temporal a la carpeta de destino con el nombre único
            $ruta_destino = $carpeta_destino . $nombre_unico;
            if (move_uploaded_file($imagen_temp, $ruta_destino)) {
                // Obtener otros datos del formulario
                $nombre_curso = $_POST["nombre_curso"];
                $descripcion = $_POST["descripcion"];
                $costo = $_POST["costo"];
                $nombre_imagen = $imagen_nombre;
                $tipo = "jpg"; // Tipo de imagen (solo se permite JPG)
                $ruta = $nombre_unico;
                $instructor = $_POST["instructor"];
                $id_grupo = $_POST["id_grupo"];
                $celda = $_POST["celda"];

                // Insertar la información en la base de datos utilizando consultas preparadas
                $sql = "INSERT INTO Cursos (nombre_curso, descripcion, costo, nombre_imagen, tipo, ruta, instructor, id_grupo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdsssii", $nombre_curso, $descripcion, $costo, $nombre_imagen, $tipo, $ruta, $instructor, $id_grupo);
                if ($stmt->execute()) {
                    $cursoid = $stmt->insert_id;
                    $sql_celda = "INSERT INTO Celdas (Celda, Grupo_Curso, Curso) VALUES (?, ?, ?)";
                    $stmt_celda = $conn->prepare($sql_celda);
                    $stmt_celda->bind_param("sii", $celda, $id_grupo, $cursoid);
                    if ($stmt_celda->execute()) {
                        echo "La imagen del curso se cargó correctamente.";
                    } else {
                        echo "Error al ejecutar la consulta para la celda: " . $stmt_celda->error;
                    }
                    $stmt_celda->close();
                } else {
                    echo "Error al ejecutar la consulta: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error al mover el archivo.";
            }
        } else {
            echo "Error: Solo se permiten archivos JPG.";
        }
    } else {
        echo "Error al cargar la imagen.";
    }
}

// Cerrar la conexión
$conn->close();
?>