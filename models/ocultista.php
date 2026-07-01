<?php
class Cifradora {

    public static function cifrar(string|array $dato): string {
        $texto = is_array($dato) ? $dato : trim((string)$dato);
        return base64_encode(serialize($texto));
    }


    public static function descifrar(string $token): mixed {
        return unserialize(base64_decode($token));
    }

    public static function limpiarToken(string $token): string {
        return preg_replace('/=/', '', $token);
    }
}
