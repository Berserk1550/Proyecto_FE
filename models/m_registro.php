<?php

    class Emprendedor {
        private $db;

        public function __construct($conn){
            $this->db = $conn;
        }


        public function buscarDocumento($documento) {
            $sql = "SELECT numero_id FROM orientacion_rcde2025_valle WHERE numero_id = ? LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $documento);
            $stmt->execute();

            return $stmt->get_result()->num_rows > 0;
        }

        
        public function insertar($data) {
        // 1. Sanitizar: quitar espacios y validar que sea numérico
            $numero_id = trim($data['numero_id']);
            if (!ctype_digit($numero_id)) {
                echo "Error: El documento debe contener solo números.";
                return false;
            }

            $check = $this->db->prepare("SELECT COUNT(*) FROM orientacion_rcde2025_valle WHERE numero_id = ?");
            $check->bind_param("s", $numero_id);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();

            if ($count > 0) {
                echo "Error: El documento ya está registrado.";
                return false;
            }

            $sql = "INSERT INTO orientacion_rcde2025_valle (
            nombres, apellidos, tipo_id, numero_id,
            correo, celular, pais, nacionalidad,
            departamento, municipio, fecha_nacimiento,
            sexo, clasificacion, discapacidad,
            tipo_emprendedor, nivel_formacion,
            ficha, carrera, programa, situacion_negocio,
            centro_orientacion, orientador,
            ejercer_actividad_proyecto, empresa_formalizada,
            rol, estado_proceso)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";


            $stmt = $this->db->prepare($sql);
            if (!$stmt){
                die("Error en prepare: " . $this->db->error);
            }

            $stmt->bind_param(
                "ssssssssssssssssssssssssss",
                $data['nombres'],
                $data['apellidos'],
                $data['tipo_id'],
                $data['numero_id'],
                $data['correo'],
                $data['celular'],
                $data['pais'],
                $data['nacionalidad'],
                $data['departamento'],
                $data['municipio'],
                $data['fecha_nacimiento'],
                $data['sexo'],
                $data['clasificacion'],
                $data['discapacidad'],
                $data['tipo_emprendedor'],
                $data['nivel_formacion'],
                $data['ficha'],
                $data['carrera'],
                $data['programa'],
                $data['situacion_negocio'],
                $data['centro_orientacion'],
                $data['orientador'],
                $data['ejercer_actividad_proyecto'],
                $data['empresa_formalizada'],
                $data['rol'],
                $data['estado_proceso']
            );



            if (!$stmt->execute()){
                echo "Error en INSERT: " . $stmt->error;
                return false;
            }
            return true;
        }
    }
?>