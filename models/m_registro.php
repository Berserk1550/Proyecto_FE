<?php
require_once "../conexion.php";
require_once "../models/limpiador.php";
require_once "../models/m_orientadores.php";

class Emprendedor {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    //Validamos si el documento existe
    public function buscarDocumento($documento) {
        $sql = "SELECT numero_id 
                FROM orientacion_rcde2025_valle 
                WHERE numero_id = ? 
                LIMIT 1";

        $stmt = $this->db->prepare($sql); 
        if (!$stmt) {
            die("Error prepare: " . $this->db->error);
        }

        $stmt->bind_param("s", $documento);
        $stmt->execute();

        $result = $stmt->get_result();
        $existe = $result->num_rows > 0;

        $stmt->close();
        return $existe;
    }

    
    public function insertar($data) {
        $sql = "INSERT INTO orientacion_rcde2025_valle 
            (nombres, apellidos, tipo_id, numero_id, correo, celular, fecha_nacimiento, sexo, pais, nacionalidad, 
            departamento, municipio, clasificacion, discapacidad, tipo_emprendedor, nivel_formacion, carrera, ficha, 
            situacion_negocio, programa, ejercer_actividad_proyecto, empresa_formalizada, centro_orientacion, orientador, orientador_id, 
            fecha_registro, rol, estado_proceso) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'emprendedor', 'pendiente')";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error en prepare: " . $this->db->error);
        }

        $data = array_map(function($valor) {

            return mb_strtolower(trim($valor), 'UTF-8');

        }, $data);

        $stmt->bind_param(
            "sssssssssssssssssssssssss",
            $data['nombre_emprendedor'],
            $data['apellido_emprendedor'],
            $data['tipo_documento_emprendedor'],
            $data['documento_emprendedor'],
            $data['correo_emprendedor'],
            $data['telefono_emprendedor'],
            $data['fecha_nacimiento_emprendedor'],
            $data['sexo_emprendedor'],
            $data['paises'],
            $data['nacionalidad'],
            $data['departamento'],
            $data['municipio'],
            $data['clasificacion'],
            $data['discapacidad'],
            $data['tipo_emprendedor'],
            $data['nivel_formacion'],
            $data['carrera'],
            $data['numero_ficha'],
            $data['situacion_negocio'],
            $data['programa'],
            $data['ejercer_actividad_proyecto'],
            $data['empresa_formalizada'],
            $data['centro_orientacion'],
            $data['orientador'],
            $data['orientador_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al insertar: " . $stmt->error);
        }

        return true;
    }

}
?>