<?php
require_once '../conexion.php';


class Emprendedor {
    private $db;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    public function buscarDocumento($documento)
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $sql = 'SELECT numero_id FROM orientacion_rcde2025_valle WHERE numero_id = ? LIMIT 1';

            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $documento);
            $stmt->execute();

            $stmt->store_result(); 
            $total = $stmt->num_rows;

            $stmt->close();

            if ($total == 0) {
                return 'disponible';
            } else {
                return 'no_disponible';
            }

        } catch (mysqli_sql_exception $e) {
            if ($this->db->connect_errno) {
                return 'sin_conexion';
            } else {
                error_log("Error en buscarDocumento: " . $e->getMessage());
                return 'error_busqueda';
            }
        }
    }


    public function insertar($data) {
        $ok = "ok"; // Estado inicial

        try {
            //Preparamos la consulta SQL
            $sql = "INSERT INTO orientacion_rcde2025_valle 
        (nombres, apellidos, tipo_id, numero_id, correo, celular, fecha_nacimiento, sexo, pais, nacionalidad, 
        departamento, municipio, clasificacion, discapacidad, tipo_emprendedor, nivel_formacion, carrera, ficha, 
        situacion_negocio, programa, ejercer_actividad_proyecto, empresa_formalizada, centro_orientacion, orientador, orientador_id, 
        fecha_registro, rol, contrasena, estado_proceso) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'emprendedor', ?, 'pendiente')";


            $stmt = $this->db->prepare($sql);

            if (!$stmt) {

                throw new Exception("sin_conexion");
            }

            //limpieza de datos masiva (convertir a minusculas y quitar espacios)
            $data = array_map(function($valor) {
                return mb_strtolower(trim((string)$valor), 'UTF-8');
            }, $data);

            $num = $data['telefono_emprendedor'];
            $contra = hash('sha256', $num);

            $stmt->bind_param(
                "ssssssssssssssssssssssssss",
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
                $data['orientador_id'],
                $contra
            );


            // ejecutamos
            if (!$stmt->execute()) {
                // Si el execute falla
                throw new Exception("no_guardo");
            }

            $stmt->close();

        } catch (Exception $e) {
            //capturamos el mensaje de la excepción
            $ok = $e->getMessage();
            
            //si el error no es un mensaje definido, se trata como error de guardado
            if ($ok !== "sin_conexion" && $ok !== "no_guardo") {
                $ok = "no_guardo";
            }
        }

        return $ok;
    }

    public function cambiarEstado(string $cedula, string $respuesta): string {
        try {
            //definir valores segun la respuesta
            if ($respuesta === 'interesado') {
                $proceso = 'interesado';
                $panel   = 'si';
            } elseif ($respuesta == 'no_interesado') {
                $proceso = 'no_interesado';
                $panel   = 'no';
            } else {
                throw new Exception("Respuesta inválida: {$respuesta}");
            }

            //preparar consulta SQL
            $sql = "UPDATE orientacion_rcde2025_valle 
                    SET estado_proceso = ?, acceso_panel = ? 
                    WHERE numero_id = ?";

            $stmt = $this->db->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->db->error);
            }

            // vincular parametros
            $stmt->bind_param("sss", $proceso, $panel, $cedula);

            //ejecutar consulta
            if ($stmt->execute()) {
                return "OK";
            } else {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }

        } catch (Exception $e) {
            //captura cualquier error y lo registra
            error_log("Error en cambiarEstado: " . $e->getMessage());
            return "no se pudo enviar";
        }
    }


}
