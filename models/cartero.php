<?php
require_once __DIR__ . '/../librerias/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../librerias/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../librerias/phpmailer/src/Exception.php';
require_once 'ocultista.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mensajero {

    private $servidorSMTP;
    private $puertoSMTP;
    private $usuarioSMTP;
    private $claveSMTP;
    private $remitenteCorreo;
    private $remitenteNombre;
    private $encriptacion;
    private $charset;

    public function __construct() {
        $this->servidorSMTP    = "smtp.gmail.com"; //mail.arcano.digital
        $this->puertoSMTP      = 465;
        $this->usuarioSMTP     = "luismiguelmuriel15@gmail.com"; //fondoemprender@arcano.digital
        $this->claveSMTP       = "wrdw cgal prsc kzal"; //F8nd83mpr3nd3r
        $this->remitenteCorreo = "luismiguelmuriel15@gmail.com"; 
        $this->remitenteNombre = "Fondo Emprender";//Fondo Emprender - SENA CAB
        $this->encriptacion    = "ssl";
        $this->charset         = "UTF-8";
    }

    public function enviarCorreoConfirmacion(array $emprendedor): string {
        $mail = new PHPMailer(true);
        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host       = $this->servidorSMTP;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->usuarioSMTP;
            $mail->Password   = $this->claveSMTP;
            $mail->SMTPSecure = $this->encriptacion;
            $mail->Port       = $this->puertoSMTP;
            $mail->CharSet    = $this->charset;

            // Remitente y destinatario
            $mail->setFrom($this->remitenteCorreo, $this->remitenteNombre);
            $mail->addAddress($emprendedor['correo']);

            // Construcción de datos cifrados
            $dato_seguir = [
                'accion'     => 'seguir',
                'nombre'     => $emprendedor['nombre'],
                'usuario'    => $emprendedor['usuario'],
                'correo'     => $emprendedor['correo'],
                'orientador' => $emprendedor['orientador'],
                'telefono'   => $emprendedor['telefono']
            ];

            $dato_desisto = [
                'accion' => 'desisto',
                'cedula' => $emprendedor['usuario']
            ];

            $tokenSeguir  = Cifradora::cifrar($dato_seguir);
            $tokenDesisto = Cifradora::cifrar($dato_desisto);

            $linkSeguir  = "http://localhost/borradorFECAB/controller/confirmar_decision.php?token={$tokenSeguir}";
            $linkDesisto = "http://localhost/borradorFECAB/controller/confirmar_decision.php?token={$tokenDesisto}";

            // Logo opcional
            //$logo_html = "<img src='https://tuservidor.com/logo.png' alt='Logo SENA' style='max-width:120px;margin-bottom:15px;'>";

            // Plantilla HTML
            $mail->isHTML(true);
            $mail->Subject = "Confirma tu registro";
            $mail->Body    = "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Bienvenido - SENA</title>
            </head>
            <body style='margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;background-color:#f4f7f5;'>
                <table cellpadding='0' cellspacing='0' border='0' width='100%' style='background-color:#f4f7f5;padding:30px 10px;'>
                    <tr>
                        <td align='center'>
                            <table cellpadding='0' cellspacing='0' border='0' width='600'
                                style='max-width:600px;background-color:#ffffff;border-radius:16px;overflow:hidden;'>
                                <tr>
                                    <td style='background:#ffffff;padding:40px 40px 35px;text-align:center;'>
                                        
                                        <h1 style='color:#39A900;margin:0 0 10px;font-size:28px;font-weight:700;'>¡Bienvenido!</h1>
                                        <p style='color:#32ab3b;margin:0;font-size:16px;'>Programa de Emprendimiento SENA (CAB)</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='padding:40px;'>
                                        <p style='color:#111827;font-size:17px;margin:0 0 8px;font-weight:600;'>Hola {$emprendedor['nombre']},</p>
                                        <p style='color:#374151;font-size:15px;line-height:1.7;margin:0 0 20px;'>Gracias por registrarte en nuestro programa de emprendimiento. Estamos emocionados de acompañarte en este viaje hacia el éxito empresarial.</p>
                                        <p style='color:#374151;font-size:15px;line-height:1.7;margin:0 0 25px;'>Para continuar con el proceso de orientación y recibir el acompañamiento personalizado de nuestro equipo, necesitamos que confirmes tu interés.</p>
                                        
                                        <table cellpadding='0' cellspacing='0' border='0' width='100%' style='margin:0 0 30px;'>
                                            <tr>
                                                <td style='background:#f0f9ff;border-left:4px solid #39A900;border-radius:8px;padding:20px;'>
                                                    <p style='color:#1f2937;font-size:17px;font-weight:700;margin:0 0 10px;'>¿Deseas continuar con el proceso de emprendimiento?</p>
                                                    <p style='color:#6b7280;font-size:14px;margin:0;'>Tu decisión nos ayudará a brindarte la mejor atención personalizada.</p>
                                                </td>
                                            </tr>
                                        </table>

                                        <table cellpadding='0' cellspacing='0' border='0' width='100%' style='margin-bottom:30px;'>
                                            <tr>
                                                <td width='48%' style='padding-right:2%;'>
                                                    <table cellpadding='0' cellspacing='0' border='0' width='100%'>
                                                        <tr>
                                                            <td style='background:#39A900;border-radius:8px;text-align:center;'>
                                                                <a href='{$linkSeguir}' style='display:block;color:#ffffff;text-decoration:none;padding:15px 20px;font-weight:700;font-size:15px;' target='_blank'>Sí, deseo continuar</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width='48%' style='padding-left:2%;'>
                                                    <table cellpadding='0' cellspacing='0' border='0' width='100%'>
                                                        <tr>
                                                            <td style='background:#e5e7eb;border-radius:8px;text-align:center;'>
                                                                <a href='{$linkDesisto}' style='display:block;color:#374151;text-decoration:none;padding:15px 20px;font-weight:700;font-size:15px;' target='_blank'>No deseo continuar</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='background-color:#f9fafb;padding:30px;text-align:center;'>
                                        <p style='color:#6b7280;font-size:13px;margin:0 0 8px;'><strong>Servicio Nacional de Aprendizaje - SENA</strong><br>Fondo Emprender</p>
                                        <p style='color:#9ca3af;font-size:12px;margin:0;'>Este es un correo automático, por favor no respondas.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>";

            $mail->send();
            return "SI";
        } catch (Exception $e) {
            error_log("Error al enviar correo de confirmación: " . $mail->ErrorInfo);
            return "NO";
        }
    }



    public function enviarCredenciales(array $credenciales): string {
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host       = $this->servidorSMTP;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->usuarioSMTP;
            $mail->Password   = $this->claveSMTP;
            $mail->SMTPSecure = $this->encriptacion;
            $mail->Port       = $this->puertoSMTP;
            $mail->CharSet    = $this->charset;

            // Remitente y destinatario
            $mail->setFrom($this->remitenteCorreo, $this->remitenteNombre);
            $mail->addAddress($credenciales['correo']); // correo del emprendedor

            // Plantilla HTML personalizada
            //$logo_html = "<img src='https://tuservidor.com/logo.png' alt='Logo SENA' style='max-width:120px;margin-bottom:15px;'>";

            $mail->isHTML(true);
            $mail->Subject = "Acceso Habilitado - Fondo Emprender SENA CAB";
            $mail->Body    = "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Acceso Habilitado - Fondo Emprender SENA CAB</title>

                <style>

                
                </style>
            </head>
            <body style='margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;background-color:#f4f7f5;'>
                <table cellpadding='0' cellspacing='0' border='0' width='100%' style='background-color:#f4f7f5;padding:30px 10px;'>
                    <tr>
                        <td align='center'>
                            <table cellpadding='0' cellspacing='0' border='0' width='600' style='max-width:600px;background-color:#ffffff;border-radius:16px;overflow:hidden;'>
                                <tr>
                                    <td style='background:#f9f9f9;padding:40px 40px 35px;text-align:center;'>
                                        
                                        <h1 style='color:#39A900;margin:0 0 10px;font-size:28px;font-weight:700;'>¡Acceso Habilitado!</h1>
                                        <p style='color:#32ab3b;margin:0;font-size:16px;'>Ya puedes ingresar al sistema</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='padding:40px;'>
                                        <p style='color:#111827;font-size:17px;margin:0 0 8px;font-weight:600;'>Hola {$credenciales['nombre']},</p>
                                        <p style='color:#374151;font-size:15px;line-height:1.7;margin:0 0 20px;'>¡Tenemos excelentes noticias!, Tu orientador ha habilitado tu acceso al sistema SENA Fondo Emprender.</p>
                                        <p style='color:#374151;font-size:15px;line-height:1.7;margin:0 0 25px;'>Ahora puedes ingresar al sistema y acceder a todas las herramientas y recursos disponibles para tu proyecto de emprendimiento.</p>
                                        <table cellpadding='0' cellspacing='0' border='0' width='100%' style='margin:0 0 30px;'>
                                            <tr>
                                                <td style='background:linear-gradient(135deg, rgba(57, 169, 0, 0.1) 0%, rgba(255, 255, 255, 0.5) 100%);border-left:4px solid #39A900;border-radius:8px;padding:20px;'>
                                                    <p style='color:#1f2937;font-size:17px;font-weight:700;margin:0 0 10px;'>Tus datos de acceso:</p>
                                                    <p style='color:#6b7280;font-size:14px;margin:0 0 8px;'><strong style='color:#374151;'>Usuario:</strong> {$credenciales['usuario']}</p>
                                                    <p style='color:#6b7280;font-size:14px;margin:0;'><strong style='color:#374151;'>Contraseña:</strong> Tu número de teléfono </p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table cellpadding='0' cellspacing='0' border='0' width='100%' style='margin-bottom:30px;'>
                                            <tr>
                                                <td style='background:#39A900;border-radius:10px;text-align:center;box-shadow:0 6px 20px rgba(57,169,0,0.3);'>
                                                    <a href='http://localhost/borradorFECAB/' style='display:block;color:#ffffff;text-decoration:none;padding:18px 30px;font-weight:700;font-size:16px;' target='_blank'>Iniciar sesión ahora</a>
                                                </td>
                                            </tr>
                                        </table>
                                        <table cellpadding='0' cellspacing='0' border='0' width='100%' style='border-top:2px solid #f3f4f6;padding-top:25px;'>
                                            <tr>
                                                <td>
                                                    <p style='color:#374151;font-size:15px;font-weight:600;margin:0 0 15px;'>Que encontrarás en el sistema:</p>
                                                    <p style='color:#6b7280;font-size:14px;line-height:1.7;margin:0 0 10px;'>- Panel de emprendedor personalizado</p>
                                                    <p style='color:#6b7280;font-size:14px;line-height:1.7;margin:0 0 10px;'>- Seguimiento de tu proyecto</p>
                                                    <p style='color:#6b7280;font-size:14px;line-height:1.7;margin:0 0 10px;'>- Recursos y materiales de apoyo</p>
                                                    <p style='color:#6b7280;font-size:14px;line-height:1.7;margin:0;'>- Comunicación directa con tu orientador</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='background-color:#f9fafb;padding:30px;text-align:center;'>
                                        <p style='color:#6b7280;font-size:13px;margin:0 0 8px;'><strong>Servicio Nacional de Aprendizaje - SENA</strong><br>Fondo Emprender</p>
                                        <p style='color:#9ca3af;font-size:12px;margin:0;'>Si tienes problemas para acceder, contacta a tu orientador.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>";

            // Enviar correo
            $mail->send();
            return "SI";

        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $mail->ErrorInfo);
            return "NO";
        }
    }


    public function enviarNotificacionOrientador(string $correoOrientador, array $paquete_dato): string {
        $mail = new PHPMailer(true);

        try {
            //configuración SMTP
            $mail->isSMTP();
            $mail->Host       = $this->servidorSMTP;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->usuarioSMTP;
            $mail->Password   = $this->claveSMTP;
            $mail->SMTPSecure = $this->encriptacion;
            $mail->Port       = $this->puertoSMTP;
            $mail->CharSet    = $this->charset;

            //remitente y destinatario
            $mail->setFrom($this->remitenteCorreo, $this->remitenteNombre);
            $mail->addAddress($correoOrientador);

            //cuerpo del correo
            $mail->isHTML(true);
            $mail->Subject = "Notificación de emprendedor interesado";
            $mail->Body    = "
                <p>Hola Orientador,</p>
                <p>El emprendedor <strong>{$paquete_dato['nombre']}</strong> está interesado en seguir con la ruta de Fondo Emprender.</p>
                <p>Su número de teléfono es <strong>{$paquete_dato['telefono']}</strong> y su correo es <strong>{$paquete_dato['correo']}</strong>.</p>
                <p>Por favor comunícate con él lo más pronto posible.</p>
            ";

            //enviar correo
            $mail->send();
            return "SI";

        } catch (Exception $e) {
            error_log("Error al enviar notificación al orientador: " . $mail->ErrorInfo);
            return "NO";
        }
    }

}