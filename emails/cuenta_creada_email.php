<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Intancia de PHPMailer
$mail = new PHPMailer(true);
$mail->setLanguage("es"); //stablecer el idioma Español


try {
    $mail->SMTPDebug = 0;
    // Es necesario para poder usar un servidor SMTP como gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    // Para activar la autenticación smtp del servidor
    $mail->SMTPAuth   = true;

    // Credenciales de la cuenta
    $mail->Username   = 'tucorreo@gmail.com';
    $mail->Password   = 'tuclavedeseguridad';
    $mail->SMTPSecure = 'tls';
    //$mail->SMTPSecure = "ssl";      
    $mail->Port       = 587; // o 465
    $mail->CharSet = 'UTF-8';


    $emailUser = trim($_REQUEST['emailUser']);

    $mail->setFrom('programadorphp2017@gmail.com', 'Parking');  // Quien envía este mensaje
    $mail->addAddress($emailUser, '');  // Destinatario
    //$mail->addAddress('urian1213viera@gmail.com', 'Joe User');

    //Copia de envio del email
    $mail->addReplyTo('info@alcvaletparking.com', 'Information');
    $mail->addCC('urian1213viera@gmail.com'); //Copia


    //Content
    $mail->isHTML(true);
    //Asunto                             
    $mail->Subject = 'Parking';
    $mail->Body .= "<section style='margin-top: 10px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>En <strong style='color:#ff6d0c;'>Parking</strong> le damos la bienvenida y estamos encantados de tenerte como nuestro cliente.</p>";
    $mail->Body .= "<p>Tu cuenta se ha creado exitosamente.</p>";
    $mail->Body .= "<p>Para acceder con tu cuenta a la plataforma, haga clic en el siguiente enlace:</p><br>";
    $mail->Body .= "<a href='https://alcvaletparking.com/app/' style='background: #ff6d0c; font-size:15px; padding: 10px 20px; border-radius: 25px;text-decoration: unset; color:#fff;'>Acceder Ahora</a>";
    $mail->Body .= "</section>";

    $mail->Body .= "<section style='margin-top: 50px; margin-bottom: 70px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>Gracias de nuevo por elegir <strong style='color:#ff6d0c;'>Parking</strong>.</p>";
    $mail->Body .= "<p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>";
    $mail->Body .= '<p>¡Esperamos que tengas una experiencia increíble!</p>';
    $mail->Body .= "</section>";

    $mail->Body .= "<a href='https://alcvaletparking.com'><img src='https://alcvaletparking.com/app/assets/custom/imgs/logo.png' alt='Parking' style='width: 100%; max-width: 100px; height: auto; display: block; float: left; margin-top: 40px; border-radius: 5px;' /></a>";


    //Copia de envio del email
    $headers = 'From: Parking <info@alcvaletparking.com>' . "\r\n";
    $headers .= 'Cc: urianwebdeveloper@gmail.com' . "\r\n";
    //$headers .= 'Cc: info@alcvaletparking.com' . "\r\n";


    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        header("location:../?successC=1");
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
