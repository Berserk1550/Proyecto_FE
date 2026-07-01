<?php

require_once '../conexion.php';
require '../models/m_orientadores.php';
require '../models/m_registro.php';
require '../models/limpiador.php';
require '../models/cartero.php';

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
            $this->redirigirError();
        }
    }

    public function mostrarFormulario()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $orientadores = $this->orientadorModel->listarOrientadores();

            // Si el modulo devuelve un codigo de error en lugar de un array
            if (!is_array($orientadores)) {
                $respuesta = match($orientadores) {
                    'no_conexion'   => ['status' => 'error', 'mensaje' => 'Sin conexión a la base de datos'],
                    'error_consulta'=> ['status' => 'error', 'mensaje' => 'Error al consultar orientadores'],
                    default         => ['status' => 'error', 'mensaje' => 'Error desconocido']
                };
                var_dump($respuesta);
                echo json_encode($respuesta);
                return;
            }

            // devolver el arreglo de orientadores
            echo json_encode([
                'status' => 'exitoso',
                'orientadores' => $orientadores
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode([
                'status' => 'error',
                'mensaje' => 'Ocurrió un error al cargar el formulario'
            ]);
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

        $documento = trim((string)($datos['documento_emprendedor'] ?? ''));

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
            
            'nacionalidad' => ($datos['nacionalidad'] ?? ''),
            
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
            
            'orientador' => Vigilante::sanitizarTexto($datos['nombre_orientador'] ?? ''),
            
            'orientador_id' => Vigilante::sanitizarDocumento($datos['id_orientador'] ?? ''),
            
            'ejercer_actividad_proyecto' => Vigilante::sanitizarTexto($datos['ejercer_actividad_proyecto'] ?? 'NO'),
            
            'empresa_formalizada' => Vigilante::sanitizarTexto($datos['empresa_formalizada'] ?? 'NO'),
        ];
    

        if(empty(trim($paqueteEmprendedor['carrera']))){
            $paqueteEmprendedor['carrera'] = 'No tiene';
        }

        $resultado = $this->emprendedorModel->insertar($paqueteEmprendedor);

        if ($resultado == "ok") {
            $paqueteCorreo = [
                'nombre'     => $paqueteEmprendedor['nombre_emprendedor'],
                'usuario'    => $paqueteEmprendedor['documento_emprendedor'],
                'correo'     => $paqueteEmprendedor['correo_emprendedor'],
                'orientador' => $paqueteEmprendedor['orientador_id'],
                'telefono' => $paqueteEmprendedor['telefono_emprendedor']
            ];

            $cartero = new Mensajero();
            $resultado_correo = $cartero->enviarCorreoConfirmacion($paqueteCorreo);

            if ($resultado_correo == "SI") {
                $respuesta = ['status'=> 'exitoso','mensaje'=> 'Registro exitoso por favor consulta tu correo'];
            } else {
                $respuesta = ['status'=> 'alerta','mensaje'=> 'Registro exitoso pero error al enviar correo'];
            }

        } else {
            $respuesta = ['status'=> 'error','mensaje'=> 'Error al guardar el formulario'];
        }

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
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && ($_GET['action']) == 'listar_orientadores'){
    $controller->mostrarFormulario();
}


