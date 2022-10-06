<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);
try {
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username ='fs_isc@itsoeh.edu.mx';
        $mail->Password = 'Is#kmander21';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('fs_isc@itsoeh.edu.mx','Prueba Gmail');
        $mail->addAddress('jvaldez@itsoeh.edu.mx','COMPRAS PRUEBA');
        $mail->addCC('jvaldez@itsoeh.edu.mx');

        $mail->isHTML(true);
        $mail->Subject = "Prueba gamil";
        $mail->Body = "Hola Esto es una prueba del servidor no entregas tus trabajos.... ";
        $mail->send();
        echo 'Correo Enviado';
       

} catch (\Throwable $th) {
             echo $th;                 //throw $th;
}

?>
<script type='text/JavaScript'>
window.location.href = 'https://www.delftstack.com/howto/';
 </script>