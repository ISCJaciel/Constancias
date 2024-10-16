<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "plataformaconstancias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener la opción seleccionada (con validación básica)
$selectedOption = isset($_GET['option']) ? $_GET['option'] : "";
if (!in_array($selectedOption, ["instructor", "cursos", "usuarios", "encuesta"])) {
    die("Opción no válida");
}

// Consulta SQL según la opción seleccionada
$sql = "";
switch ($selectedOption) {
    case "instructor":
        $sql = "SELECT idprofesor, nombre_instructor FROM instructor";
        break;
    case "cursos":
        $sql = "SELECT cursoid, nombre_curso, descripcion, costo, instructor FROM Cursos";
        break;
    case "usuarios":
        $sql = "SELECT usuarioid, nombre, apellido_paterno, apellido_materno, correo FROM Usuarios";
        break;
    case "encuesta":
        // Contar respuestas agrupadas por valor para cada pregunta
        $sql = "SELECT 
                    pregunta1, COUNT(*) AS count1,
                    pregunta2, COUNT(*) AS count2,
                    pregunta3, COUNT(*) AS count3,
                    pregunta4, COUNT(*) AS count4,
                    pregunta5, COUNT(*) AS count5,
                    pregunta6, COUNT(*) AS count6,
                    pregunta7, COUNT(*) AS count7,
                    pregunta8, COUNT(*) AS count8,
                    pregunta9, COUNT(*) AS count9
                FROM encuesta
                GROUP BY 
                    pregunta1, pregunta2, pregunta3, pregunta4, 
                    pregunta5, pregunta6, pregunta7, pregunta8, pregunta9";
        break;
}

// Ejecutar consulta
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if ($result) {
    if ($selectedOption === "encuesta") {
        // Agrupar los resultados por categoría de respuesta para la gráfica
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'pregunta1' => $row['pregunta1'],
                'count1' => $row['count1'],
                'pregunta2' => $row['pregunta2'],
                'count2' => $row['count2'],
                'pregunta3' => $row['pregunta3'],
                'count3' => $row['count3'],
                'pregunta4' => $row['pregunta4'],
                'count4' => $row['count4'],
                'pregunta5' => $row['pregunta5'],
                'count5' => $row['count5'],
                'pregunta6' => $row['pregunta6'],
                'count6' => $row['count6'],
                'pregunta7' => $row['pregunta7'],
                'count7' => $row['count7'],
                'pregunta8' => $row['pregunta8'],
                'count8' => $row['count8'],
                'pregunta9' => $row['pregunta9'],
                'count9' => $row['count9']
            ];
        }
        echo json_encode($data);
    } else {
        if ($result->num_rows > 0) {
            // Imprimir los datos en una tabla HTML
            echo "<table border='1'>";
            // Imprimir encabezados de columna dependiendo de la opción seleccionada
            switch ($selectedOption) {
                case "instructor":
                    echo "<tr><th>ID</th><th>Nombre</th></tr>";
                    break;
                case "cursos":
                    echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Costo</th><th>Instructor</th></tr>";
                    break;
                case "usuarios":
                    echo "<tr><th>ID</th><th>Nombre</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Correo</th></tr>";
                    break;
            }
            while ($row = $result->fetch_assoc()) {
                // Imprimir datos de fila dependiendo de la opción seleccionada
                switch ($selectedOption) {
                    case "instructor":
                        echo "<tr><td>" . $row["idprofesor"] . "</td><td>" . $row["nombre_instructor"] . "</td></tr>";
                        break;
                    case "cursos":
                        echo "<tr><td>" . $row["cursoid"] . "</td><td>" . $row["nombre_curso"] . "</td><td>" . $row["descripcion"] . "</td><td>" . $row["costo"] . "</td><td>" . $row["instructor"] . "</td></tr>";
                        break;
                    case "usuarios":
                        echo "<tr><td>" . $row["usuarioid"] . "</td><td>" . $row["nombre"] . "</td><td>" . $row["apellido_paterno"] . "</td><td>" . $row["apellido_materno"] . "</td><td>" . $row["correo"] . "</td></tr>";
                        break;
                }
            }
            echo "</table>";
        } else {
            echo "No se encontraron datos para la opción seleccionada.";
        }
    }
} else {
    echo "Error en la consulta: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
