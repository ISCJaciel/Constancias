<?php
// Definir las variables de conexión
$servername = "localhost"; // Cambia esto si tu servidor MySQL está en otro lugar
$username = "root"; // Cambia esto por tu nombre de usuario de MySQL
$password = "1234"; // Cambia esto por tu contraseña de MySQL
$database = "plataformaconstancias"; // Nombre de tu base de datos

// Verificar si se recibió el ID del instructor a eliminar
if(isset($_POST['eliminar']) && isset($_POST['id'])) {
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
                echo "<script>alert('Los datos del instructor se cargaron correctamente.'); window.location.href='../Views/dashboard/instructor.php';</script>";
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
    echo "<table class='table'>
            <thead>
                <tr>
                    <th scope='col'>ID</th>
                    <th scope='col'>Nombre del Instructor</th>
                </tr>
            </thead>
            <tbody>";

    // Mostrar los datos en la tabla
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["idprofesor"] . "</td>
                <td>" . $row["nombre_instructor"] . "</td>
                <td>";
        echo "<form action='".$_SERVER['PHP_SELF']."' method='post' style='display: inline;'>";
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
