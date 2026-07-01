<?php

require_once '../models/m_registro.php';
require_once '../models/m_orientadores.php';
require_once '../models/cartero.php';
require_once '../models/ocultista.php';

class ConfirmarController {

    private $emprendedorModel;
    private $orientadorModel;
    private $cartero;

    public function __construct(mixed $conn)
    {
        $this->emprendedorModel= new Emprendedor($conn);
        $this->orientadorModel= new Orientadores($conn);
        $this->cartero = new Mensajero();
    }

    public function procesarConfirmacion(string $token): void {
        try {
            // descifrar el token
            $datos = Cifradora::descifrar($token);

            if (!is_array($datos)) {
                throw new InvalidArgumentException("Token inválido o corrupto");
            }

            // extraer parametros
            $accion     = $datos['accion'] ?? '';
            $orientador = $datos['orientador'] ?? null;
            $nombre     = $datos['nombre'] ?? '';
            $usuario    = $datos['usuario'] ?? '';
            $correo     = $datos['correo'] ?? '';
            $telefono   = $datos['telefono'] ?? '';

            if (empty($accion) || empty($usuario)) {
                throw new InvalidArgumentException("Datos incompletos en el token");
            }

            // crear paquete de datos (sin la accion)
            $paquete_datos = [
                'nombre'     => $nombre,
                'usuario'    => $usuario,
                'correo'     => $correo,
                'orientador' => $orientador,
                'telefono'   => $telefono
            ];

            // Validar accion
            switch ($accion) {
                case 'seguir':
                    // enviar todo el paquete de datos
                    $this->confirmarInteres($paquete_datos);
                    break;

                case 'desisto':
                    // solo enviar la cedula
                    //$this->rechazarInteres($cedula);
                    break;

                default:
                    throw new InvalidArgumentException("Acción no válida: {$accion}");
            }

        } catch (InvalidArgumentException $e) {
            // Errores de validacion
            echo "Error de validación: " . $e->getMessage();
        } catch (Exception $e) {
            // Errores generales
            echo "Error inesperado: " . $e->getMessage();
        }
    }



    public function confirmarInteres(array $paquete_dato): void {
        try {
            //cambiar estado en la base de datos
            $resultado = $this->emprendedorModel->cambiarEstado($paquete_dato['usuario'], 'interesado');
            
            //validar respuesta del modelo
            if ($resultado !== "OK") {
                
                throw new Exception("Error al actualizar estado en BD");
            }

            //preparar credenciales para el emprendedor
            $credenciales = [
                'nombre'     => $paquete_dato['nombre'],
                'usuario'    => $paquete_dato['usuario'],
                'contrasena' => $paquete_dato['telefono'],
                'correo'     => $paquete_dato['correo']
            ];

            //enviar credenciales al emprendedor
            $this->cartero->enviarCredenciales($credenciales);

            //notificar al orientador (si existe)
            if (!empty($paquete_dato['orientador'])) {
                $correoOrientador = $this->orientadorModel->buscarCorreoOrientador($paquete_dato['orientador']);
                $this->cartero->enviarNotificacionOrientador($correoOrientador, $paquete_dato);
            }

            // confirmacion final
            header("Location: ../vista/confirmar_decision_vista.php");

            exit();

        } catch (Exception $e) {
            // Captura cualquier error (BD, correo, etc.)
            error_log("Error en confirmarInteres: " . $e->getMessage());
        }
    }
    
}

function iniciadora(): void {
    $token = $_GET['token'];

    $conexion = new Conexion();
    $conn = $conexion->getConn();

    $controlador = new ConfirmarController($conn);
    $controlador->procesarConfirmacion($token);
}

iniciadora();