<?php
class Conexion {
    private $conn;

    public function __construct() {
        $host = "localhost";   
        $user = "root";        
        $pass = "";            
        $db   = "arcanoposada_fondo"; 

        // Crear conexión
        $this->conn = new mysqli($host, $user, $pass, $db);

        // Verificar conexión
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        // Configurar charset
        $this->conn->set_charset("utf8mb4");
    }

    // Método para obtener el objeto mysqli
    public function getConn() {
        return $this->conn;
    }
}
?>