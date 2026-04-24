<?php
require '../conexion.php';
require '../models/m_registro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre_emprendedor'       => $_POST['nombre_emprendedor'] ?? '',
        'apellido_emprendedor'     => $_POST['apellido_emprendedor'] ?? '',
        'tipo_documento_emprendedor' => $_POST['tipo_documento_emprendedor'] ?? '',
        'documento_emprendedor'    => $_POST['documento_emprendedor'] ?? '',
        'telefono_emprendedor'     => $_POST['telefono_emprendedor'] ?? '',
        'fecha_nacimiento_emprendedor' => $_POST['fecha_nacimiento_emprendedor'] ?? '',
        'sexo_emprendedor'         => $_POST['sexo_emprendedor'] ?? '',
        'correo_emprendedor'       => $_POST['correo_emprendedor'] ?? '',
        'paises'                   => $_POST['paises'] ?? '',
        'nacionalidad'             => $_POST['nacionalidad'] ?? '',
        'departamento'             => $_POST['departamento'] ?? '',
        'municipio'                => $_POST['municipio'] ?? '',
        'clasificacion'            => $_POST['clasificacion'] ?? '',
        'discapacidad'             => $_POST['discapacidad'] ?? '',
        'tipo_emprendedor'         => $_POST['tipo_emprendedor'] ?? '',
        'nivel_formacion'          => $_POST['nivel_formacion'] ?? '',
        'carrera'                  => $_POST['carrera_tecnologo'] 
                                      ?? $_POST['carrera_tecnico'] 
                                      ?? $_POST['carrera_operario'] 
                                      ?? $_POST['carrera_auxiliar'] 
                                      ?? $_POST['carrera_profesional'] 
                                      ?? $_POST['posgrado_especializacion'] 
                                      ?? $_POST['posgrado_maestria'] 
                                      ?? $_POST['posgrado_doctorado'] 
                                      ?? '',
        'numero_ficha'             => $_POST['numero_ficha'] ?? '',
        'situacion_negocio'        => $_POST['situacion_negocio'] ?? '',
        'programa'                 => $_POST['programa'] ?? '',
        'ejercer_actividad_proyecto' => $_POST['ejercer_actividad_proyecto'] ?? 'NO',
        'empresa_formalizada'        => $_POST['empresa_formalizada'] ?? 'NO',
        'centro_orientacion'       => $_POST['centro_orientacion'] ?? '',
        'orientador'               => $_POST['orientador'] ?? '',
        // Campos de back
        'rol'             => 'emprendedor',
        'estado_proceso'  => 'activo',
        'contrasena'      => password_hash('default123', PASSWORD_DEFAULT)
    ];

    $emprendedor = new Emprendedor($conn);

    if ($emprendedor->insertar($data)) {
        echo "Registro exitoso";
        // header("Location: confirmacion.php");
    } else {
        echo "Error al registrar";
    }
}
?>
