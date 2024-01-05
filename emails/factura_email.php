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
    $mail->Username   = 'programadorphp2017@gmail.com';
    $mail->Password   = 'vfnzebeyquznyyhp';
    $mail->SMTPSecure = 'tls';
    //$mail->SMTPSecure = "ssl";      
    $mail->Port       = 587; // o 465
    $mail->CharSet = 'UTF-8';


    // Quien envía este mensaje
    $mail->setFrom('programadorphp2017@gmail.com', 'ALC Valet Parking Alicante');
    // Destinatario
    $emailUser = trim($_REQUEST['emailUser']);
    $IdReserva = trim($_REQUEST['IdReserva']);
    $email_info = "info@alcvaletparking.com";

    $mail->addAddress($emailUser, '');
    //$mail->addAddress('urian1213viera@gmail.com', 'Joe User');

    //Copia de envio del email
    $mail->addReplyTo($email_info, 'Information');
    $mail->addCC('urian1213viera@gmail.com'); //Copia


    //Content
    $mail->isHTML(true);
    //Asunto                             
    $mail->Subject = 'ALC Valet Parking Alicante';
    $mail->Body .= "<section style='margin-top: 10px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>En <strong style='color:#ff6d0c;'>ALC Valet Parking Alicante</strong> le damos la bienvenida y estamos encantados de tenerte como nuestro cliente.</p>";
    $mail->Body .= "<p>Para descargar tu factura solo debes hacer clic en el siguiente enlace:</p><br><br>";
    $mail->Body .= "<a href='https://alcvaletparking.com/app/dashboard/FacturaClientePDF.php?idReserva=" . $IdReserva . " ' style='background: #ff6d0c; font-size:15px; padding: 10px 20px; border-radius: 25px;text-decoration: unset; color:#fff;'>Descargar Factura</a> <br><br><br>";
    $mail->Body .= "</section>";


    $mail->Body .= "<section style='margin-top: 50px; margin-bottom: 70px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>Gracias de nuevo por elegir <strong style='color:#ff6d0c;'>ALC Valet Parking Alicante</strong>.</p>";
    $mail->Body .= "<p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>";
    $mail->Body .= "<a href='https://alcvaletparking.com'><img src='https://alcvaletparking.com/app/assets/custom/imgs/logo_naranja.png' alt='ALC Valet Parking Alicante' style='width: 100%; max-width: 100px; height: auto; display: block; float: left; margin-top: 40px; border-radius: 5px;' /></a>";
    $mail->AltBody = '<p>¡Esperamos que tengas una experiencia increíble!</p>';
    $mail->Body .= "</section>";

    #Mensaje en englesh
    $mail->Body .= "<section style='margin-top: 10px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>At <strong style='color:#ff6d0c;'>ALC Valet Parking Alicante</strong>, we welcome you and are delighted to have you as our customer.</p>";
    $mail->Body .= "<p>To download your invoice, simply click on the following link:</p><br><br>";
    $mail->Body .= "<a href='https://alcvaletparking.com/app/dashboard/FacturaClientePDF.php?idReserva=" . $IdReserva . " ' style='background: #ff6d0c; font-size:15px; padding: 10px 20px; border-radius: 25px;text-decoration: unset; color:#fff;'>Download Invoice</a> <br><br><br>";
    $mail->Body .= "</section>";

    $mail->Body .= "<section style='margin-top: 50px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>Thank you again for choosing <strong style='color:#ff6d0c;'>ALC Valet Parking Alicante</strong>.</p>";
    $mail->Body .= "<p>If you have any questions or need assistance, feel free to contact us.</p>";
    $mail->Body .= "<a href='https://alcvaletparking.com'><img src='https://alcvaletparking.com/app/assets/custom/imgs/logo_naranja.png' alt='ALC Valet Parking Alicante' style='width: 100%; max-width: 100px; height: auto; display: block; float: left; margin-top: 40px; border-radius: 5px;' /></a>";
    $mail->AltBody = '<p>We hope you have an incredible experience!</p>';
    $mail->Body .= "</section>";




    //Copia de envio del email
    $headers = 'From: ALC Valet Parking Alicante ' . $email_info . "\r\n";
    $headers .= 'Cc: urianwebdeveloper@gmail.com' . "\r\n";
    //$headers .= 'Cc: ' . $email_info . "\r\n";

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        header("location:../dashboard/Agenda.php?facturaR=1");
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
