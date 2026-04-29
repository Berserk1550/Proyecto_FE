<?php
    require '../conexion.php';
    require '../models/m_registro.php';

    class RegistroController {
        private $model;

        public function sanitizarEntrada($post) {
            
            if (is_null($post) || $post === '') {
                echo "Error: No se recibieron datos del formulario.";
                return false;
            }

            else{
        
                $nombre_emp = filter_var($post['nombre_emprendedor'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $apellido_emp = filter_var($post['apellido_emprendedor'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $num_id = filter_var($post['documento_emprendedor'], FILTER_SANITIZE_NUMBER_INT);
                $telefono_emp = filter_var($post['telefono_emprendedor'], FILTER_SANITIZE_NUMBER_INT);
                $correo_emp = filter_var($post['correo_emprendedor'], FILTER_SANITIZE_EMAIL);
                $municipio_emp = filter_var($post['municipio'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $ficha_emp = filter_var($post['numero_ficha'], FILTER_SANITIZE_NUMBER_INT);

                return [
                    'nombre_emp' => $nombre_emp,
                    'apellido_emp' => $apellido_emp,
                    'num_id' => $num_id,
                    'telefono_emp' => $telefono_emp,
                    'correo_emp' => $correo_emp,
                    'municipio_emp' => $municipio_emp,
                    'ficha_emp' => $ficha_emp
                ];
            }
            
        }

        public function __construct($conn) {
            $this->model = new Emprendedor($conn);
        }

        public function procesarFormulario($post) {
            $data = [
                'nombres'       => $post['nombre_emprendedor'] ?? '',
                'apellidos'     => $post['apellido_emprendedor'] ?? '',
                'tipo_id'       => $post['tipo_documento_emprendedor'] ?? '',
                'numero_id'     => $post['documento_emprendedor'] ?? '',
                'celular'       => $post['telefono_emprendedor'] ?? '',
                'fecha_nacimiento' => $post['fecha_nacimiento_emprendedor'] ?? '',
                'sexo'          => $post['sexo_emprendedor'] ?? '',
                'correo'        => $post['correo_emprendedor'] ?? '',
                'pais'          => $post['paises'] ?? '',
                'nacionalidad'  => $post['nacionalidad'] ?? '',
                'departamento'  => $post['departamento'] ?? '',
                'municipio'     => $post['municipio'] ?? '',
                'clasificacion' => $post['clasificacion'] ?? '',
                'discapacidad'  => $post['discapacidad'] ?? '',
                'tipo_emprendedor' => $post['tipo_emprendedor'] ?? '',
                'nivel_formacion'  => $post['nivel_formacion'] ?? '',
                'ficha'         => $post['numero_ficha'] ?? '',
                'carrera'       => $post['carrera'] ?? '',
                'programa'      => $post['programa'] ?? '',
                'situacion_negocio' => $post['situacion_negocio'] ?? '',
                'centro_orientacion' => $post['centro_orientacion'] ?? '',
                'orientador'    => $post['orientador'] ?? '',
                'ejercer_actividad_proyecto' => $post['ejercer_actividad_proyecto'] ?? 'NO',
                'empresa_formalizada' => $post['empresa_formalizada'] ?? 'NO',
                'rol'           => 'emprendedor',
                'estado_proceso'=> 'activo',
                'contrasena'    => password_hash('default123', PASSWORD_DEFAULT)
            ];


            // Depuración: ver qué datos llegan
            error_log(print_r($data, true));

            return $this->model->insertar($data);
        }
    }

    // Bloque que realmente ejecuta el controlador
    $controller = new RegistroController($conn);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $resultado = $controller->procesarFormulario($_POST);
        echo $resultado ? "OK" : "Error al guardar";
    }
?>