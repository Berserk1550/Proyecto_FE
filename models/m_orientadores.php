<?php
class Orientadores {

    private $db;

    public function __construct($conn){
        $this->db = $conn;
    }

    public function listarOrientadores(){

        $sql = "SELECT id_orientador, nombres, apellidos
                FROM orientadores
                WHERE rol = 'orientador'
                ORDER BY nombres ASC";

        $resultado = $this->db->query($sql);

        // DEPURACIÓN
        if(!$resultado){
            die("Error SQL: " . $this->db->error);
        }

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}