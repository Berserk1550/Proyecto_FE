<?php

session_start();
require_once '../conexion.php':
require_once '../models/m_login.php';
require_once '../models/limpiador.php';

class loginControlador {
    private $loginModel;

    public function __construct($conn) {
        $this->loginModel = new Mlogin($conn);
    }

    public function procesarLogin(array $data) {
        $documento = Vigilante::sanitizarDocumento($data["numero_dcumento"] ?? "");
        $password = $data["contraseña"] ?? "";

        if ($documento === "" || $password === "") {
            
            echo "Rellene todos los campos.";
            return;
            
        }

        $usuario = $this->loginModel->obtenerUsuario($documento);

        if (!usuario) {
            echo "Usuario no existente.";
            return;
        }

        if (password_verify($password, $usuario["contrasena_hash"])) {
            $_SESSION["login"] = true;
            $_SESSION["documento"] = $usuario["documento"];
            $_SESSION["nombres"] = $usuario["nombres"];
            $_SESSION["apellidos"] = $usuario["apellidos"];
            
            header("Location: ../index.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    }
}

$conexion = new Conexion();
$controller = new LoginController($conexion->getConn());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->procesarLogin($$_POST);
}

?>