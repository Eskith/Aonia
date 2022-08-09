<?php

require_once 'app/dependencies/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    static $mail = null;
    private function __construct() {
        
    }

    private static function getMail():PHPMailer
    {   
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        //$mail->SMTPDebug = DIRECTORY_SEPARATOR == "\\" ? 1 : 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->CharSet = 'UTF-8';
        $mail->Host = Config::getValue('email_host');
        $mail->Port = Config::getValue('email_port'); // or 587
        $mail->Username = Config::getValue('email_username');
        $mail->Password = Config::getValue('email_password');
        $mail->SetFrom(Config::getValue('email_username'));
        $mail->IsHTML(true);
        
        return $mail; 
    }

    public static function sendEmail($to, string $subject, string $body, array $options = []):bool
    {
        if($to){
            $mail = self::getMail(); 
            $mail->Subject = $subject;
            $mail->Body = $body;

            if(is_string($to)){
                $mail->AddAddress($to); 
            }else if(is_array($to)){
                foreach ($to as $email) {$mail->AddAddress($email);} // Añadimos todos los emails a enviar
            }else{
                return false; 
            }

            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
                return true;
            } else {
                return false; 
            }
        }else{
            return false; 
        }
        
    }

    private static function genericEmail(string $email, string $asunto, array $opciones):bool
    {

        $html = isset($opciones['html']) ? $opciones['html'] : file_get_contents('app/html/email/'.$opciones['htmlName'].'.html');

        if(isset($opciones['replaces'])){
            $html = str_replace(array_keys($opciones['replaces']),array_values($opciones['replaces']), $html); 
        }
        return self::sendEmail($email, $asunto, $html);
    }

    public static function resetPassEmail(string $email, string $peticionId):bool
    {   


        $asunto = 'Recuperar contraseña de TestCdd';
        $opciones['htmlName'] = 'resetpass';
        $opciones['replaces'] = [
            '{{hostname}}' => Config::getValue('hostname'),
            '{{action_url}}' => Config::getValue('hostname')."resetPass/$peticionId",
        ];

        
        return self::genericEmail($email, $asunto, $opciones);

        /*$html = file_get_contents('app/html/email/resetpass.html');

        $replaces = [
            '{{hostname}}' => Config::getValue('hostname'),
            '{{action_url}}' => Config::getValue('hostname')."resetPass/$peticionId",
        ];

        $html = str_replace(array_keys($replaces),array_values($replaces), $html); 

        return self::sendEmail($email, $asunto, $html);*/

    }

    public static function emailBienvenida(string $email, string $pass):bool
    {   

        $asunto = 'Bienvenido/a a Aonia';
        $opciones['htmlName'] = 'bienvenida';
        $opciones['replaces'] = [
            '{{hostname}}' => Config::getValue('hostname'),
            '{{email}}' => $email,
            '{{pass}}' => $pass,
        ];

        return self::genericEmail($email, $asunto, $opciones);
    }


}
