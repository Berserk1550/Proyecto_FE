<?php
require '../conexion.php';
require '../models/m_registro.php';

class RegistroController {
    private $model;

    public function __construct($conn) {
        $this->model = new Emprendedor($conn);
    }

    public function procesarFormulario($post) {
        $data = [
            'nombre_emprendedor'       => $post['nombre_emprendedor'] ?? '',
            'apellido_emprendedor'     => $post['apellido_emprendedor'] ?? '',
            'tipo_documento_emprendedor' => $post['tipo_documento_emprendedor'] ?? '',
            'documento_emprendedor'    => $post['documento_emprendedor'] ?? '',
            'telefono_emprendedor'     => $post['telefono_emprendedor'] ?? '',
            'fecha_nacimiento_emprendedor' => $post['fecha_nacimiento_emprendedor'] ?? '',
            'sexo_emprendedor'         => $post['sexo_emprendedor'] ?? '',
            'correo_emprendedor'       => $post['correo_emprendedor'] ?? '',
            'paises'                   => $post['paises'] ?? '',
            'nacionalidad'             => $post['nacionalidad'] ?? '',
            'departamento'             => $post['departamento'] ?? '',
            'municipio'                => $post['municipio'] ?? '',
            'clasificacion'            => $post['clasificacion'] ?? '',
            'discapacidad'             => $post['discapacidad'] ?? '',
            'tipo_emprendedor'         => $post['tipo_emprendedor'] ?? '',
            'nivel_formacion'          => $post['nivel_formacion'] ?? '',
            'carrera'                  => $post['carrera_tecnologo'] 
                                          ?? $post['carrera_tecnico'] 
                                          ?? $post['carrera_operario'] 
                                          ?? $post['carrera_auxiliar'] 
                                          ?? $post['carrera_profesional'] 
                                          ?? $post['posgrado_especializacion'] 
                                          ?? $post['posgrado_maestria'] 
                                          ?? $post['posgrado_doctorado'] 
                                          ?? '',
            'numero_ficha'             => $post['numero_ficha'] ?? '',
            'situacion_negocio'        => $post['situacion_negocio'] ?? '',
            'programa'                 => $post['programa'] ?? '',
            'ejercer_actividad_proyecto' => $post['ejercer_actividad_proyecto'] ?? 'NO',
            'empresa_formalizada'        => $post['empresa_formalizada'] ?? 'NO',
            'centro_orientacion'       => $post['centro_orientacion'] ?? '',
            'orientador'               => $post['orientador'] ?? '',
            // Campos de back
            'rol'             => 'emprendedor',
            'estado_proceso'  => 'activo',
            'contrasena'      => password_hash('default123', PASSWORD_DEFAULT)
        ];

        return $this->model->insertar($data);
    }
}
