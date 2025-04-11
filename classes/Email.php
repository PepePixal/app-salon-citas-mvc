<?php
// pronombre auto, único para nuestra class
// agregarlo a composer.json y actualizar con: composer update
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    //método constructor que recibe: email, nombre y token. Retorna objeto.
    public function __construct($email, $nombre, $token) {
        
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    //Metodo para enviar correo de confirmación al usuario
    //y token único en la url del enlace
    public function enviarConfirmacion() {
        // nueva instancia de la clase PHPMailer().Requiere instal del paquete.
        $mail = new PHPMailer();
        
        //Configuración del servidor de envio de correos, de www.mailtrap.io
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        //Recipients:
        $mail->setFrom('cuentas@appsalon.com'); //quien envia al usuario
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com'); //Add a recipient
        //Content
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $mail->Subject = 'Confirma tu cuenta AppSalon.com';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . " </strong> Has creado tu cuenta en App Salón, solo falta confirmarla en el siguiete enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, ignora el correo";
        $contenido .= "</html>";
        $mail->Body = $contenido;
        // Enviar el mail
        $mail->send();
    }

    //Metodo para enviar email con las instrucciones para crear un nuevo password
    // y nuevo token único en la url del enlace
    public function enviarInstrucciones() {
        // nueva instancia de la clase PHPMailer().Requiere instal del paquete.
        $mail = new PHPMailer();

        //Configuración del servidor de envio de correos, de www.mailtrap.io
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
       
        //Recipients:
        $mail->setFrom('cuentas@appsalon.com'); //quien envia al usuario
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com'); //Add a recipient
        //Content
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $mail->Subject = 'Restablece tu password de AppSalon.com';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . " </strong>, has solicitado restablecer tu password, para hacerlo pulsa en el siguiete enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Restablecer Password</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, ignora el correo";
        $contenido .= "</html>";
        $mail->Body = $contenido;
        // Enviar el mail
        $mail->send();
    }


}

?>