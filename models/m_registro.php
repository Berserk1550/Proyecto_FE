<?php

    class Emprendedor {
        
        public function insertar($data) {

            $sql = "INSERT INTO usuarios (
                nombre, apellido, tipo_documento, documento,
                telefono, fecha_nacimiento, sexo, correo,
                pais, departamento, municipio,
                clasificacion, discapacidad,
                tipo_emprendedor, nivel_formacion,
                situacion_negocio, programa,
                centro_orientacion, orientador
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
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
                $data['orientador']
            ]);
        }
    }
?>