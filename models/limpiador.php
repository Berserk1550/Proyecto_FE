<?php

class Vigilante {
    public static function sanitizarDocumento($valor) {

        return filter_var(trim($valor), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    }

    public static function sanitizarCorreo($correo) {

        return filter_var(trim($correo), FILTER_SANITIZE_EMAIL);

    }

    
    public static function sanitizarTelefono($telefono) {

        return filter_var(trim($telefono), FILTER_SANITIZE_NUMBER_INT);

    }

    public static function sanitizarFicha($ficha) {

        return filter_var(trim($ficha), FILTER_SANITIZE_NUMBER_INT);
    }

    public static function sanitizarTexto($texto) {

        return filter_var(trim($texto), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    }
}

?>