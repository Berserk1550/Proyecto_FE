<?php
require_once '../conexion.php';

class Orientadores {

    private $db;

    public function __construct($conn){
        $this->db = $conn;
    }

    public function listarOrientadores()
    {
        try {
            $sql = "SELECT numero_id, nombres, apellidos
                    FROM orientadores
                    WHERE rol = 'orientador'
                    ORDER BY nombres ASC";

            $resultado = $this->db->query($sql);

            // Si todo va bien, retornamos los datos
            return $resultado->fetch_all(MYSQLI_ASSOC);

        } catch (Exception $e) {
            // Capturamos el tipo de error
            $mensaje = $e->getMessage();

            // Si el error viene de la conexión
            if ($this->db->connect_errno) {
                return "no_conexion";
            }

            // Si fue un error de consulta
            if ($mensaje === "error_consulta") {
                return "error_consulta";
            }

            // Cualquier otro error
            return "error_desconocido";
        }
    }

    public function buscarCorreoOrientador(string $orientadorId): ?string {
        try {
            // 1. Preparar consulta SQL
            $sql = "SELECT correo FROM orientadores WHERE numero_id = ? LIMIT 1";

            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->db->error);
            }

            // 2. Vincular parámetros
            $stmt->bind_param("s", $orientadorId);

            // 3. Ejecutar consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }

            // 4. Obtener resultado
            $resultado = $stmt->get_result();
            if ($resultado && $resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
                return $fila['correo']; // Devuelve el correo electrónico
            } else {
                return null; // No se encontró orientador
            }

        } catch (Exception $e) {
            // Captura cualquier error y lo registra
            error_log("Error en buscarCorreoOrientador: " . $e->getMessage());
            return null;
        }
    }


}