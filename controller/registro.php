<?php
require '../conexion.php';
require '../models/m_orientadores.php';
require '../models/m_registro.php';

class RegistroController
{

    private $emprendedorModel;
    private $orientadoresModel;

    public function __construct($conn)
    {
        $this->emprendedorModel   = new Emprendedor($conn);
        $this->orientadoresModel  = new Orientadores($conn);
    }

    public function validarDocumento()
    {
        header('Content-Type: application/json; charset=utf-8');
        $recibido = file_get_contents('php://input');

        if (!$recibido) {
            http_response_code(400);
            echo json_encode(['error' => true, 'message' => 'No se recibió ningún dato']);
            exit;
        }

        $data = json_decode($recibido, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => true, 'message' => 'JSON invalido']);
            exit;
        }

        $documento = trim($data["emprendedor"] ?? "");
        $documento = str_replace(" ", "", $documento);
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

    public function mostrarFormulario($get)
    {
        try {
            $orientadores = $this->orientadoresModel->listarOrientadores();

            if ($orientadores === false) {
                throw new Exception("Error al consultar Orientadores");
            }
            require '../vista/registro_emprendedores_vista.php';
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Ocurrió un error al cargar el formulario.";
        }
    }


    public function procesarFormulario($post) {

        $data = [
            'nombre_emprendedor' => Vigilante::sanitizarTexto($post['nombre_emprendedor'] ?? ''),
            
            'apellido_emprendedor' => Vigilante::sanitizarTexto($post['apellido_emprendedor'] ?? ''),
            
            'tipo_documento_emprendedor' => Vigilante::sanitizarTexto($post['tipo_documento_emprendedor'] ?? ''),
            
            'documento_emprendedor' => Vigilante::sanitizarDocumento($post['documento_emprendedor'] ?? ''),
            
            'telefono_emprendedor' => Vigilante::sanitizarTelefono($post['telefono_emprendedor'] ?? ''),
            
            'fecha_nacimiento_emprendedor' => Vigilante::sanitizarTexto($post['fecha_nacimiento_emprendedor'] ?? ''),
            
            'sexo_emprendedor' => Vigilante::sanitizarTexto($post['sexo_emprendedor'] ?? ''),
            
            'correo_emprendedor' => Vigilante::sanitizarCorreo($post['correo_emprendedor'] ?? ''),
            
            'paises' => Vigilante::sanitizarTexto($post['paises'] ?? ''),
            
            'nacionalidad' => Vigilante::sanitizarTexto($post['nacionalidad'] ?? ''),
            
            'departamento' => Vigilante::sanitizarTexto($post['departamento'] ?? ''),
            
            'municipio' => Vigilante::sanitizarTexto($post['municipio'] ?? ''),
            
            'clasificacion' => Vigilante::sanitizarTexto($post['clasificacion'] ?? ''),
            
            'discapacidad' => Vigilante::sanitizarTexto($post['discapacidad'] ?? ''),
            
            'tipo_emprendedor' => Vigilante::sanitizarTexto($post['tipo_emprendedor'] ?? ''),
            
            'nivel_formacion' => Vigilante::sanitizarTexto($post['nivel_formacion'] ?? ''),
            
            'numero_ficha' => Vigilante::sanitizarFicha($post['numero_ficha'] ?? ''),
            
            'carrera' => Vigilante::sanitizarTexto($post['carrera'] ?? ''),
            
            'programa' => Vigilante::sanitizarTexto($post['programa'] ?? ''),
            
            'situacion_negocio' => Vigilante::sanitizarTexto($post['situacion_negocio'] ?? ''),
            
            'centro_orientacion' => Vigilante::sanitizarTexto($post['centro_orientacion'] ?? ''),
            
            'orientador' => Vigilante::sanitizarTexto($post['orientador_nombre'] ?? ''),
            
            'orientador_id' => Vigilante::sanitizarDocumento($post['orientador'] ?? ''),
            
            'ejercer_actividad_proyecto' => Vigilante::sanitizarTexto($post['ejercer_actividad_proyecto'] ?? 'NO'),
            
            'empresa_formalizada' => Vigilante::sanitizarTexto($post['empresa_formalizada'] ?? 'NO'),
        ];

        if (empty(trim($data['numero_ficha']))) {

            $data['numero_ficha'] = 'No aplica';
        }

        $this->emprendedorModel->insertar($data);
    }
}



$con = new Conexion();
$controller = new RegistroController($con->conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recibido = file_get_contents('php://input');
    $data = json_decode($recibido, true);

    if ($data && isset($data['emprendedor'])) {
        
        $controller->validarDocumento();
    } else {

        $controller->procesarFormulario($_POST);
        echo "Formulario guardado correctamente";
    }
} else {
    $controller->mostrarFormulario($_GET);
}

