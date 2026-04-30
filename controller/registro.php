<?php
    require '../conexion.php';
    require '../models/m_registro.php';

    class RegistroController {
        private $model;

        public function __construct($conn) {
            $this->model = new Emprendedor($conn);
        }

        require '../models/limpiador.php';

        public function procesarFormulario($post) {
            $data = [
                'nombres'       => Vigilante::sanitizarTexto($post['nombre_emprendedor'] ?? ''),
                'apellidos'     => Vigilante::sanitizarTexto($post['apellido_emprendedor'] ?? ''),
                'tipo_id'       => $post['tipo_documento_emprendedor'] ?? '',
                'numero_id'     => Vigilante::sanitizarDocumento($post['documento_emprendedor'] ?? ''),
                'celular'       => Vigilante::sanitizarTelefono($post['telefono_emprendedor'] ?? ''),
                'fecha_nacimiento' => $post['fecha_nacimiento_emprendedor'] ?? '',
                'sexo'          => $post['sexo_emprendedor'] ?? '',
                'correo'        => Vigilante::sanitizarCorreo($post['correo_emprendedor'] ?? ''),
                'pais'          => $post['paises'] ?? '',
                'nacionalidad'  => $post['nacionalidad'] ?? '',
                'departamento'  => $post['departamento'] ?? '',
                'municipio'     => Vigilante::sanitizarTexto($post['municipio'] ?? ''),
                'clasificacion' => $post['clasificacion'] ?? '',
                'discapacidad'  => $post['discapacidad'] ?? '',
                'tipo_emprendedor' => $post['tipo_emprendedor'] ?? '',
                'nivel_formacion'  => $post['nivel_formacion'] ?? '',
                'ficha'         => Vigilante::sanitizarFicha($post['numero_ficha'] ?? ''),
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