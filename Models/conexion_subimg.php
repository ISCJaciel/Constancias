<?php
$servername = "localhost"; // Cambia esto si tu servidor no es localhost
$username = "root";
$password = "1234";
$dbname = "plataformaconstancias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $target_dir = "subir_img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image"]["tmp_name"]);

    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_name = basename($_FILES["image"]["name"]);
            $image_path = $target_file;

            // Insertar información de la imagen en la base de datos
            $sql = "INSERT INTO imagenes (nombre, ruta) VALUES ('$image_name', '$image_path')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "name" => $image_name, "path" => $image_path]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al guardar la información en la base de datos."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error al subir la imagen."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "El archivo no es una imagen."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No se recibió ningún archivo."]);
}
$conn->close();
?>
