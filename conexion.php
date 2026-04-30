<?php
// Datos de conexión
$host = "localhost";   // IP servidor
$user = "root";  // usuario MySQL
$pass = ""; // contraseña MySQL
$db   = "arcanoposada_fondo";       // BD

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Opcional: configurar charset
$conn->set_charset("utf8");
?>