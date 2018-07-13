<?php 
	error_reporting(0);

	//variables POST
    $nombre_recibido = $_POST['nombre'];
  	$telefono_recibido = $_POST['telefono'];
  	$mail_recibido = $_POST['mail'];
  	$mensaje_recibido = $_POST['mensaje'];
 
	require("class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->Host = "localhost";
    $mail->IsHTML(true);
			
    $cuerpo .= "<b>Nombre:</b> " . $nombre_recibido . "<br>";
    $cuerpo .= "<b>Teléfono:</b> " . $telefono_recibido . "<br>";
    $cuerpo .= "<b>Correo:</b> " . $mail_recibido . "<br>";
    $cuerpo .= "<b>Mensaje:</b> " . $mensaje_recibido . "<br>";
                    
    $mail->From = " " . $mail_recibido;
    $mail->FromName = "" . $nombre_recibido;
    $mail->Subject = "Formulario de contacto";
    $mail->AddAddress("elizabeth@smarketing.mx","INPROMINE");
    $mail->AddBCC("smarketingmx@gmail.com");
    $mail->AddBCC("sixrogs@hotmail.com");
    $mail->Body = $cuerpo;
    $mail->AltBody = "";
    $mail->Send();
 	
 	echo "Formulario enviado correctamente.";
?>