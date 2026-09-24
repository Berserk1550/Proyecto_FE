<?php
declare(strict_types=1);

/** Firma un payload JSON con expiración. TOKEN_SECRET se configura en el servidor. */
function generarTokenSeguro(array $payload, int $ttl_segundos = 172800): string
{
    $secreto = getenv('TOKEN_SECRET');
    if ($secreto === false || $secreto === '') {
        throw new RuntimeException('TOKEN_SECRET no está configurado.');
    }

    $payload['exp'] = time() + $ttl_segundos;
    if (!is_int($payload['exp'])) {
        throw new InvalidArgumentException('El tiempo de expiración está fuera de rango.');
    }

    $json = json_encode($payload, JSON_THROW_ON_ERROR);
    $payload_codificado = rtrim(strtr(base64_encode($json), '+/', '-_'), '=');
    $firma = hash_hmac('sha256', $payload_codificado, $secreto, true);
    $firma_codificada = rtrim(strtr(base64_encode($firma), '+/', '-_'), '=');

    return $payload_codificado . '.' . $firma_codificada;
}

/** Retorna el payload autenticado o false. La falta de secreto es un error de configuración. */
function verificarTokenSeguro(string $token): array|false
{
    $partes = explode('.', $token);
    if (count($partes) !== 2) {
        return false;
    }

    [$payload_codificado, $firma_recibida] = $partes;
    if (preg_match('/\A[A-Za-z0-9_-]+\z/', $payload_codificado) !== 1
        || preg_match('/\A[A-Za-z0-9_-]+\z/', $firma_recibida) !== 1) {
        return false;
    }

    $secreto = getenv('TOKEN_SECRET');
    if ($secreto === false || $secreto === '') {
        throw new RuntimeException('TOKEN_SECRET no está configurado.');
    }

    $firma = hash_hmac('sha256', $payload_codificado, $secreto, true);
    $firma_esperada = rtrim(strtr(base64_encode($firma), '+/', '-_'), '=');
    if (!hash_equals($firma_esperada, $firma_recibida)) {
        return false;
    }

    $relleno = str_repeat('=', (4 - strlen($payload_codificado) % 4) % 4);
    $json = base64_decode(strtr($payload_codificado, '-_', '+/') . $relleno, true);
    if ($json === false
        || rtrim(strtr(base64_encode($json), '+/', '-_'), '=') !== $payload_codificado) {
        return false;
    }

    $payload = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($payload)
        || !isset($payload['exp']) || !is_int($payload['exp'])
        || time() > $payload['exp']) {
        return false;
    }

    return $payload;
}
