<?php

require_once '../conexion.php';
require '../models/m_orientadores.php';
require '../models/m_registro.php';

class RegistroController {

    //declaro variables
    private $emprendedorModel;
    private $orientadorModel;

    public function __construct($conn)
    {
        $this->emprendedorModel= new Emprendedor($conn);
        $this->orientadorModel= new Orientadores($conn);
    }

    function redirigirError(): never
    {
        header('location: http://localhost/fecab/PruebasFeCab/vista/registro_emprendedores_vista.php', true, 301);
        exit;
    }

    function validarPeticion() 
    {
        if ($_SERVER['REQUEST_METHOD'] !== "POST" && $_SERVER['REQUEST_METHOD'] !== "GET")
        {
            redirigirError();
        }
    }

    public function validarDocumento(array $data)
    {
        header('Content-Type: application/json; charset=utf-8');

        $documento = trim($data["emprendedor"] ?? "");
        $documento = preg_replace('/[^a-zA-Z0-9]/', '', $documento);
        $documento = strtoupper($documento);

        if ($documento === "") {
            echo json_encode(['existe' => false, 'documento' => $documento]);
            exit;
        }

        $existe = $this->emprendedorModel->buscarDocumento($documento);

        echo json_encode([
            'existe' => $existe,
            'documento' => $documento
        ]);
        exit;
    }

    public function recogerRegistro(array $datos)
    {
        $documento = trim((string)($datos['documento'] ?? ''));

        if (empty($documento)) {
            echo json_encode([
                'estado'=> 'error',
                'mensaje'=> 'formulario no se envió correctamente'
            ]);
            return;
        }

        $paqueteEmprendedor = [
            'nombre_emprendedor' => Vigilante::sanitizarTexto($datos['nombre_emprendedor'] ?? ''),
            
            'apellido_emprendedor' => Vigilante::sanitizarTexto($datos['apellido_emprendedor'] ?? ''),
            
            'tipo_documento_emprendedor' => Vigilante::sanitizarTexto($datos['tipo_documento_emprendedor'] ?? ''),
            
            'documento_emprendedor' => Vigilante::sanitizarDocumento($datos['documento_emprendedor'] ?? ''),
            
            'telefono_emprendedor' => Vigilante::sanitizarTelefono($datos['telefono_emprendedor'] ?? ''),
            
            'fecha_nacimiento_emprendedor' => Vigilante::sanitizarTexto($datos['fecha_nacimiento_emprendedor'] ?? ''),
            
            'sexo_emprendedor' => Vigilante::sanitizarTexto($datos['sexo_emprendedor'] ?? ''),
            
            'correo_emprendedor' => Vigilante::sanitizarCorreo($datos['correo_emprendedor'] ?? ''),
            
            'paises' => Vigilante::sanitizarTexto($datos['paises'] ?? ''),
            
            'nacionalidad' => Vigilante::sanitizarTexto($datos['nacionalidad'] ?? ''),
            
            'departamento' => Vigilante::sanitizarTexto($datos['departamento'] ?? ''),
            
            'municipio' => Vigilante::sanitizarTexto($datos['municipio'] ?? ''),
            
            'clasificacion' => Vigilante::sanitizarTexto($datos['clasificacion'] ?? ''),
            
            'discapacidad' => Vigilante::sanitizarTexto($datos['discapacidad'] ?? ''),
            
            'tipo_emprendedor' => Vigilante::sanitizarTexto($datos['tipo_emprendedor'] ?? ''),
            
            'nivel_formacion' => Vigilante::sanitizarTexto($datos['nivel_formacion'] ?? ''),
            
            'numero_ficha' => Vigilante::sanitizarFicha($datos['numero_ficha'] ?? ''),
            
            'carrera' => Vigilante::sanitizarTexto($datos['carrera'] ?? ''),
            
            'programa' => Vigilante::sanitizarTexto($datos['programa'] ?? ''),
            
            'situacion_negocio' => Vigilante::sanitizarTexto($datos['situacion_negocio'] ?? ''),
            
            'centro_orientacion' => Vigilante::sanitizarTexto($datos['centro_orientacion'] ?? ''),
            
            'orientador' => Vigilante::sanitizarTexto($datos['orientador_nombre'] ?? ''),
            
            'orientador_id' => Vigilante::sanitizarDocumento($datos['orientador'] ?? ''),
            
            'ejercer_actividad_proyecto' => Vigilante::sanitizarTexto($datos['ejercer_actividad_proyecto'] ?? 'NO'),
            
            'empresa_formalizada' => Vigilante::sanitizarTexto($datos['empresa_formalizada'] ?? 'NO'),
        ];

        if (empty(trim($paqueteEmprendedor['numero_ficha']))) {

            $paqueteEmprendedor['numero_ficha'] = 'No aplica';
        }

    $resultado = $this->emprendedorModel->insertar($paqueteEmprendedor);

    $respuesta = match($resultado) {
        'ok' => ['status'=> 'exitoso','mensaje'=> 'registro exitoso'],
        'no_guardo' => ['status'=> 'error','mensaje'=> 'error de guardado'],
        'sin_conexion' => ['status'=> 'error','mensaje'=> 'sin conexion con la base de datos'],
        default => ['status'=> 'error','mensaje'=> 'error desconocido']
    };

    echo json_encode($respuesta);
    }
}

// registro.php (router)
$conexion = new Conexion();
$conn = $conexion->getConn();
$controller = new RegistroController($conn);

$controller->validarPeticion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recibido = file_get_contents('php://input');
    $data = json_decode($recibido, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => true, 'message' => 'JSON inválido']);
        exit;
    }

    $action = $data['action'] ?? '';

    if ($action === 'validar') {
        $controller->validarDocumento($data);
    } elseif ($action === 'guardar') {
        $controller->recogerRegistro($data);
    } else {
        http_response_code(400);
        echo json_encode(['error' => true, 'message' => 'Acción desconocida']);
    }
}


