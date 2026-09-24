<?php

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
    if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) {
        throw new RuntimeException('No fue posible iniciar la sesión.');
    }

    $_SESSION = [];

    $parametros = session_get_cookie_params();
    $cookieEliminada = setcookie(session_name(), '', [
        'expires' => time() - 3600,
        'path' => $parametros['path'],
        'domain' => $parametros['domain'],
        'secure' => $parametros['secure'],
        'httponly' => $parametros['httponly'],
        'samesite' => $parametros['samesite'],
    ]);

    // Destruir los datos del servidor incluso si falla el envío de la cookie.
    $sesionDestruida = session_destroy();
    if (!$cookieEliminada || !$sesionDestruida) {
        throw new RuntimeException('No fue posible completar el cierre de sesión.');
    }

    echo json_encode(['exito' => true, 'mensaje' => 'Sesión cerrada correctamente.']);
} catch (RuntimeException $e) {
    error_log('logout.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['exito' => false, 'mensaje' => 'No fue posible cerrar la sesión. Intente nuevamente.']);
}
