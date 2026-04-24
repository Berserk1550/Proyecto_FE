<?php

    class Emprendedor {
        private $db;

        public function __construct($conn){
            $this->db = $conn;
        }
        
        public function insertar($data) {

            $sql = "INSERT INTO registro_emprendedor (
                nombres, apellidos, tipo_id, numero_id, celular, fecha_nacimiento, sexo, correo,
                pais, nacionalidad, departamento, municipio, clasificacion, discapacidad,
                tipo_emprendedor, nivel_formacion, ficha, carrera, programa, situacion_negocio,
                centro_orientacion, orientador, ejercer_actividad_proyecto, empresa_formalizada,
                rol, estado_proceso, contrasena
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $this->db->prepare($sql);
            if (!$stmt){
                die("Error en prepare: " . $this->db->error);
            }

            $stmt->bind_param(
                "sssssssssssssssssssssssssss", // 27 parámetros
                $data['nombres'],
                $data['apellidos'],
                $data['tipo_id'],
                $data['numero_id'],
                $data['celular'],
                $data['fecha_nacimiento'],
                $data['sexo'],
                $data['correo'],
                $data['pais'],
                $data['nacionalidad'],
                $data['departamento'],
                $data['municipio'],
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
                $data['estado_proceso'],
                $data['contrasena']
            );


            if (!$stmt->execute()){
                echo "Error en INSERT: " . $stmt->error;
                return false;
            }
            return true;
        }
    }
?>