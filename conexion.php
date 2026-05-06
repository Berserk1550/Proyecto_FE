<?php
class Conexion {
    public $conn;

    public function __construct() {
        $host = "localhost";   
        $user = "root";        
        $pass = "";            
        $db   = "arcanoposada_fondo"; 

        // Crea conexion
        $this->conn = new mysqli($host, $user, $pass, $db);

        // Verifica conexion
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }


        $this->conn->set_charset("utf8mb4");
    }
}
?>