<?php

class Vigilante {

    public static function sanitizarDocumento($valor) {

        return preg_replace('/[^a-zA-Z0-9]/', '', trim($valor));
    }

    public static function sanitizarCorreo($correo) {

        return filter_var(trim($correo), FILTER_SANITIZE_EMAIL);
    }

    public static function sanitizarTelefono($telefono) {

        return preg_replace('/[^0-9]/', '', trim($telefono));
    }

    public static function sanitizarFicha($ficha) {

        $ficha = trim($ficha);

        if ($ficha === '' || strtolower($ficha) === 'no aplica') {
            return 'No aplica';
        }

        return preg_replace('/[^0-9]/', '', $ficha);
    }

    public static function sanitizarTexto($texto) {

        return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
    }
}