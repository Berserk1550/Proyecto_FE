<?php
class Vigilante {
    //aqui sanitizamos el documento de identidad con el filtro de sanitizacion en la documentacion oficial de php
    public static function sanitizarDocumento($tipo, $numero){
        $tipo = strtoupper(trim($tipo));
        $numero = trim($numero);

        if (in_array($tipo, ['CC', 'TI', 'CE', 'PPT'])){
        return filter_var($numero, FILTER_SANITIZE_NUMBER_INT);
        }
        if (in_array($tipo, ['PAS', 'PEP'])) {
            $sanitizado = filter_var($numero, FILTER_SANITEZ_STRING, FILTER_FLAG_STRIP_HIGH);
        }
        return false
    }

    //aqui sanitizamos el correo electronico
    public static function sanitizarCorreo($correo){
        return filter_var(trim($correo), FILTER_SANITIZE_EMAIL);
    }

    //aqui sanitizamos Telefonos
    public static function sanitizarTelefono($telefono){
        return filter_var(trim($telefono), FILTER_SANITIZE_NUMBER_INT);
    }

    //aqui sanitizamos los demas campos de texto ej: nombres, apeliidos, municipio, etc
    public static function sanitizarTexto($texto){
        return filter_var(trim($texto), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    }

    //aqui sanitizamos N° ficha
    public static function sanitizarFicha($ficha){
        return filter_Var(trim($ficha), FILTER_SANITIZE_NUMBER_INT);
    }
}

?>