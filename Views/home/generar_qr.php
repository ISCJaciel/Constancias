<?php
session_start();
require 'phpqrcode/qrlib.php';

// URL base de la aplicación
$baseURL = 'http://192.168.1.31/verificar_constancia.php?usuarioid='; // Reemplaza 192.168.1.69 con tu dirección IP local

// Usuario ID de la sesión (supongo que ya está definido)
$usuarioid = isset($_SESSION['usuarioid']) ? $_SESSION['usuarioid'] : 1; // Cambia 1 por un valor predeterminado si no hay sesión

// URL completa
$urlQR = $baseURL . $usuarioid;

// Ruta donde se guardará el QR
$qrPath = 'QR.png';

// Generar el QR
QRcode::png($urlQR, $qrPath);

echo "QR generado en: <a href='$qrPath'>$qrPath</a>";
?>
