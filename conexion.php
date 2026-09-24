<?php

mysqli_report(MYSQLI_REPORT_OFF);

// Configurar estas variables de entorno en el servidor antes de desplegar.
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$db = getenv('DB_NAME');

// Una contraseña vacía es válida si se configuró explícitamente.
if ($host === false || $host === '' || $user === false || $user === ''
    || $pass === false || $db === false || $db === '') {
    error_log('conexion.php: faltan variables de entorno de BD');
    die('No fue posible conectar con la base de datos.');
}

$conn = mysqli_init();
if ($conn === false) {
    error_log('conexion.php: no fue posible inicializar mysqli');
    die('No fue posible conectar con la base de datos.');
}

if (!mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
    error_log('conexion.php: no fue posible configurar el timeout');
    die('No fue posible conectar con la base de datos.');
}

// Suprimir el warning público: el detalle se registra únicamente en el servidor.
if (!@mysqli_real_connect($conn, $host, $user, $pass, $db)) {
    error_log('conexion.php: fallo de conexión - ' . mysqli_connect_error());
    die('No fue posible conectar con la base de datos.');
}

if (!$conn->set_charset('utf8mb4')) {
    error_log('conexion.php: fallo al configurar utf8mb4 - ' . mysqli_error($conn));
    die('No fue posible conectar con la base de datos.');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
