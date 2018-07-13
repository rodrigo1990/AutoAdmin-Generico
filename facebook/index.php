<?
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Language" content="es-cl" />
	<title>Argenpesos Sorteos</title>

	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="content-language" content="es" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="window-target" content="_top" />

	<meta name="description" content="" />
	<meta name="keywords" content="" />

	<link rel="stylesheet" media="screen" type="text/css" href="css/general.css" />
</head>
<body>
	<div id="contenedor">
		
		<img src="imagenes/quiero_premio3.png" alt="dia del niño" /><br />
		<div>
			<?php
			if  (($_POST['nombre']) && ($_POST['apellido']) && ($_POST['mail']))
			{
				require("class.phpmailer.php");
				$mail = new PHPMailer();
				$mail->Host = "localhost";
				
				$cuerpo .= "<b>Nombre:</b> " . $_POST["nombre"] . "<br>";
				$cuerpo .= "<b>Apellido:</b> " . $_POST["apellido"] . "<br>";
				$cuerpo .= "<b>Mail:</b> " . $_POST["mail"] . "<br>";
						
				$mail->From = "remite@email.com";
				$mail->FromName = "Argenpesos";
				$mail->Subject = "madre";
				$mail->AddAddress("matias@legioncreativa.com.ar","Argenpesos");
				$mail->Body = $cuerpo;
				$mail->AltBody = "participante";
				$mail->Send();
			  
				
				 echo "<div style=\"clear:both; color: #FFFF; line-height:200px; text-align:center; \">Gracias por Participar!! Ya estás concursando.</div>";
			}
			else 
			{
				if($_POST['submit'])
				{
					echo "<div style=\"position: absolute; margin: 205px 0px 0px 130px; width: 280px; color: red;font-size: 14px;\">Por favor, completá todos los campos.</div>";
				}
				?>
				<form action="index.php" method=post>
                <br />
					<table style="text-align: left; width: 245px; margin: auto;">
					  <tr> 
							<td>NOMBRE: </td>
							<td><input type=text name="nombre" class="campo_contacto"  value="<?php echo $_POST['nombre']; ?>" ></td>
						</tr>
						<tr> 
							<td>APELLIDO: </td>
							<td><input type=text name="apellido" class="campo_contacto" value="<?php echo $_POST['apellido']; ?>" ></td>
						</tr>
						<tr> 
							<td>E-MAIL: </td>
							<td><input type=text name="mail" class="campo_contacto" value="<?php echo $_POST['mail']; ?>" ></td>
						</tr>

						<tr>
							<td colspan="2" align=right><input id="boton_enviar_contacto" type=submit value="PARTICIPAR" name="submit"></td>
						</tr>
					</table>
				</form>
				<?php
			}
			?>
			<br />
		</div><img src="imagenes/franja.png" alt="" />
		
	</div>
</body>
</html>