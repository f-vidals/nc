<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    function enviacorreo($correo,$contraseña)
    {
        $mail = new PHPMailer(true);
        try
        {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->CharSet = "utf-8";
            $mail->Host = '10.191.143.164';
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;
            $mail->Port = 25;
            $mail->setFrom('conciliacion@mail.telcel.com');
            $mail->addAddress($correo);
            $mail->addReplyTo('no-replay@mail.telcel.com');
            $mail->isHTML(true);
            $mail->Subject = 'Conciliación Notas de Crédito Contraseña';
            $mail->Body='<b>'.$contraseña.'</b>';
            $mail->send();
            sleep(2);
            echo 'Message has been sent';
        }
        catch (Exception $e)
        {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    enviacorreo('fernando.vidals@americamovil.com','test');
?>
