<?php 



function sendEmail(string $to, string $subject, string $body)
{
    $para      = 'nobody@example.com';
    $titulo    = 'El título';
    $mensaje   = 'Hola';
    $cabeceras = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $body, $cabeceras);
}