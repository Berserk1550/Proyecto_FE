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
            echo json_encode(['error' => true, 'message' => 'JSON inválido']);
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
            require '../views/registro.php';
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Ocurrió un error al cargar el formulario.";
        }
    }


    public function procesarFormulario($post)
    {
        $data = [
            'nombre_emprendedor' => $post['nombre_emprendedor'] ?? '',
            'apellido_emprendedor' => $post['apellido_emprendedor'] ?? '',
            'tipo_documento_emprendedor' => $post['tipo_documento_emprendedor'] ?? '',
            'documento_emprendedor' => $post['documento_emprendedor'] ?? '',
            'telefono_emprendedor' => $post['telefono_emprendedor'] ?? '',
            'fecha_nacimiento_emprendedor' => $post['fecha_nacimiento_emprendedor'] ?? '',
            'sexo_emprendedor' => $post['sexo_emprendedor'] ?? '',
            'correo_emprendedor' => $post['correo_emprendedor'] ?? '',
            'paises' => $post['paises'] ?? '',
            'nacionalidad' => $post['nacionalidad'] ?? '',
            'departamento' => $post['departamento'] ?? '',
            'municipio' => $post['municipio'] ?? '',
            'clasificacion' => $post['clasificacion'] ?? '',
            'discapacidad' => $post['discapacidad'] ?? '',
            'tipo_emprendedor' => $post['tipo_emprendedor'] ?? '',
            'nivel_formacion' => $post['nivel_formacion'] ?? '',
            'numero_ficha' => $post['numero_ficha'] ?? '',
            'carrera' => $post['carrera'] ?? '',
            'programa' => $post['programa'] ?? '',
            'situacion_negocio' => $post['situacion_negocio'] ?? '',
            'centro_orientacion' => $post['centro_orientacion'] ?? '',
            'orientador' => $post['orientador'] ?? '',
            'ejercer_actividad_proyecto' => $post['ejercer_actividad_proyecto'] ?? 'NO',
            'empresa_formalizada' => $post['empresa_formalizada'] ?? 'NO',
        ];

        $this->emprendedorModel->insertar($data);
    }
}



$con = new Conexion();

$controller = new RegistroController($con->conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->validarDocumento();
} else {
    $controller->mostrarFormulario($_GET);
}

