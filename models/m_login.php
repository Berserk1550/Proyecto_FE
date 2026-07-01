<?php

class Mlogin {
    private $db;

    public function __construct($conn) {
        $this->$db = $conn;
    }

    public function obtenerUsuario($documento){
        $sql = "SELEC documento, nombres, apellidos, contrasena_hash FROM usuarios  WHERE documento = ? LIMIT 1";
        $stmt = $this->$db->prepare($sql);
        $stmt->binnd_param("s", documento);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();

    }
}
?>