<?php

require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../models/usuario.php';

header('Content-Type: application/json; charset=utf-8');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(['exito' => false, 'mensaje' => 'Método no permitido.']);
    exit;
}

// Nombres enviados por el formulario actual; no transformar las credenciales.
$numero_id = $_POST['numero_documento'] ?? '';
$contrasena = $_POST['contraseña'] ?? '';

if (!is_string($numero_id) || !is_string($contrasena)
    || $numero_id === '' || $contrasena === '') {
    http_response_code(400);
    echo json_encode(['exito' => false, 'mensaje' => 'Ingrese documento y contraseña válidos.']);
    exit;
}

try {
    $usuario = validarCredenciales($conn, $numero_id, $contrasena);
    if ($usuario === false) {
        http_response_code(401);
        echo json_encode(['exito' => false, 'mensaje' => 'Documento o contraseña incorrectos.']);
        exit;
    }

    if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) {
        throw new RuntimeException('No fue posible iniciar la sesión.');
    }
    if (!session_regenerate_id(true)) {
        throw new RuntimeException('No fue posible renovar la sesión.');
    }

    $_SESSION['login'] = true;
    $_SESSION['documento'] = $usuario['numero_id'];
    $_SESSION['nombres'] = $usuario['nombres'];
    $_SESSION['apellidos'] = $usuario['apellidos'];
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['origen'] = $usuario['origen'];
    $_SESSION['rol'] = $usuario['rol'];

    echo json_encode(['exito' => true, 'mensaje' => 'Inicio de sesión exitoso.']);
} catch (RuntimeException $e) {
    //no registrar contraseñas ni datos personales contenidos en consultas fallidas.
    error_log('login.php: fallo al iniciar sesión; código ' . $e->getCode());
    http_response_code(500);
    echo json_encode(['exito' => false, 'mensaje' => 'No fue posible iniciar sesión. Intente nuevamente.']);
}
