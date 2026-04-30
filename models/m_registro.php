<?php

    class Emprendedor {
        private $db;

        public function __construct($conn){
            $this->db = $conn;
        }
        
        public function insertar($data) {

            $tipo_id = strtoupper(trim($data['tipo_idi']));
            $numero_id = trim($data(['numero_id']));

            switch ($tipo_id) {
                case 'TI':
                    if (!ctype_digit($numero_id) || strlen($numero_id) !=10) {
                        echo "La tarjeta de identidad debe ser numérica y tener 10 dígitos.";
                        return false
                    }
                    break;

                case 'CC':
                    if (!ctype_digit($numero_id) || strlen($numero_id) <6 || strlen($numero_id) >10) {
                        echo "La Cédula debe ser numérica y tener entre 6 y 10 dígitos.";
                        return false;
                    }
                    break;

                case 'CE':
                    if (!ctype_digit($numero_id) || strlen($numero_id) <6 || strlen($numero_id) >10) {
                        echo "La Cédula de Extrangería debe ser numérica y tener entre 6 y 10 dígitos.";
                        return false;
                    }
                    break;

                case 'PEP':
                    if (!preg_match('/^[A-Za-z0-9]+$/', $numero_id)){
                        echo ("El PEP debe ser alfanumérico y tener de 6 a 9 dígitos.");
                        return false;
                    }
                    break;
                
                case 'PAS':
                    if (!preg_match('/^[A-Za-z0-9]+$/', $numero_id) || strlen($numero_id) < 6 || strlen($numero_id) > 9) {
                        echo "El Pasaporte debe ser alfanumérico y tener de 6 a 9 caracteres.";
                        return false;
                    break;

                case 'PPT':
                    if (!ctype_digit($numero_id) || strlen($numero_id) < 8 || strlen($numero_id) > 12) {
                        echo "Error: El PPT debe ser numérico y tener entre 8 y 12 dígitos.";
                        return false;
                    }
                    break;

                default:
                    echo("Tipo de documento no válido.");
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