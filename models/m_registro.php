<?php

    class Emprendedor {
        private $db;

        public function __construct($conn){
            $this->db = $conn;
        }
        
        public function insertar($data) {

            $sql = "INSERT INTO registro_emprendedor (
            nombres, apellidos, tipo_id, numero_id,
            celular, fecha_nacimiento, sexo, correo,
            pais, departamento, municipio,
            clasificacion, discapacidad,
            tipo_emprendedor, nivel_formacion,
            situacion_negocio, programa,
            centro_orientacion, orientador,
            ejercer_actividad_proyecto, empresa_formalizada,
            rol, estado_proceso, contrasena
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                $data['nombre_emprendedor'],
                $data['apellido_emprendedor'],
                $data['tipo_documento_emprendedor'],
                $data['documento_emprendedor'],
                $data['telefono_emprendedor'],
                $data['fecha_nacimiento_emprendedor'],
                $data['sexo_emprendedor'],
                $data['correo_emprendedor'],
                $data['paises'],
                $data['departamento'],
                $data['municipio'],
                $data['clasificacion'],
                $data['discapacidad'],
                $data['tipo_emprendedor'],
                $data['nivel_formacion'],
                $data['situacion_negocio'],
                $data['programa'],
                $data['centro_orientacion'],
                $data['orientador'],
                $data['ejercer_actividad_proyecto'],
                $data['empresa_formalizada'],
                $data['rol'],
                $data['estado_proceso'],
                $data['contrasena']
            ]);
        }
    }
?>