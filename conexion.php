<?php
class Conexion {
    private $conn;

    public function __construct() {
        $host = "localhost";   
        $user = "root";        
        $pass = "";            
        $db   = "arcanoposada_fondo"; 

        //crear conexion
        $this->conn = new mysqli($host, $user, $pass, $db);

        //verificar conexion
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8mb4");
    }

    //metodo para obtener el objeto mysqli
    public function getConn() {
        return $this->conn;
    }
}
?>