<?php

/** Devuelve el usuario de la primera tabla coincidente, o null. */
function buscarUsuarioPorDocumento(mysqli $conn, string $numero_id)
{
    $consultas = [
        'emprendedor' => 'SELECT id, numero_id, nombres, apellidos, correo,
                                contrasena, rol
                         FROM orientacion_rcde2025_valle WHERE numero_id = ? LIMIT 1',
        'orientador' => 'SELECT id_orientador, numero_id, nombres, apellidos, correo,
                               contrasena, rol
                        FROM orientadores WHERE numero_id = ? LIMIT 1',
    ];

    foreach ($consultas as $origen => $sql) {
        $stmt = mysqli_prepare($conn, $sql);
        try {
            mysqli_stmt_bind_param($stmt, 's', $numero_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result(
                $stmt, $id, $documento, $nombres, $apellidos, $correo, $hash, $rol
            );

            if (mysqli_stmt_fetch($stmt)) {
                return [
                    'origen' => $origen,
                    'id' => (int) $id,
                    'numero_id' => (string) $documento,
                    'nombres' => (string) $nombres,
                    'apellidos' => (string) $apellidos,
                    'correo' => (string) $correo,
                    'contrasena_hash' => (string) $hash,
                    'rol' => (string) $rol,
                ];
            }
        } finally {
            mysqli_stmt_close($stmt);
        }
    }

    return null;
}

/** Devuelve datos sin contraseña o false; los errores de BD se propagan. */
function validarCredenciales(mysqli $conn, string $numero_id, string $contrasena)
{
    if (!validarFormatoDocumento($numero_id)) {
        return false;
    }

    $usuario = buscarUsuarioPorDocumento($conn, $numero_id);
    if ($usuario === null) {
        return false;
    }

    $hash = $usuario['contrasena_hash'];
    if (!password_verify($contrasena, $hash)) {
        if (preg_match('/\A[a-fA-F0-9]{64}\z/', $hash) !== 1
            || !hash_equals(strtolower($hash), hash('sha256', $contrasena))) {
            return false;
        }

        $nuevo_hash = password_hash($contrasena, PASSWORD_BCRYPT);
        // SQL fijo por origen. La condición del hash evita pisar cambios concurrentes.
        $sql = $usuario['origen'] === 'emprendedor'
            ? 'UPDATE orientacion_rcde2025_valle SET contrasena = ?
               WHERE id = ? AND BINARY contrasena = ?'
            : 'UPDATE orientadores SET contrasena = ?
               WHERE id_orientador = ? AND BINARY contrasena = ?';
        $stmt = mysqli_prepare($conn, $sql);
        try {
            mysqli_stmt_bind_param($stmt, 'sis', $nuevo_hash, $usuario['id'], $hash);
            mysqli_stmt_execute($stmt);
            $actualizados = mysqli_stmt_affected_rows($stmt);
        } finally {
            mysqli_stmt_close($stmt);
        }

        if ($actualizados !== 1) {
            // Aceptar otra migración simultánea, pero no una contraseña reemplazada.
            $actual = buscarUsuarioPorDocumento($conn, $numero_id);
            if ($actual === null || $actual['origen'] !== $usuario['origen']
                || $actual['id'] !== $usuario['id']
                || !password_verify($contrasena, $actual['contrasena_hash'])) {
                return false;
            }
            $usuario = $actual;
        }
    }

    unset($usuario['contrasena_hash']);
    return $usuario;
}

/** Solo dígitos: 6–15; con letras mayúsculas ASCII: 6–20. Sin espacios. */
function validarFormatoDocumento($numero_id)
{
    if (!is_string($numero_id) && !is_int($numero_id)) {
        return false;
    }

    return preg_match('/\A(?:[0-9]{6,15}|(?=[A-Z0-9]*[A-Z])[A-Z0-9]{6,20})\z/', (string) $numero_id) === 1;
}
