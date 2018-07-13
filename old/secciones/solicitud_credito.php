<script type="text/javascript" src="js/si.files.js"></script>

<style type="text/css" title="text/css">
/* <![CDATA[ */

.SI-FILES-STYLIZED label.cabinet
{
	width: 93px;
	height: 25px;
	background: url(imagenes/sumate/adjuntar.png) 0 0 no-repeat;

	display: block;
	overflow: hidden;
	cursor: pointer;
}

.SI-FILES-STYLIZED label.cabinet input.file
{
	position: relative;
	height: 100%;
	width: auto;
	opacity: 0;
	-moz-opacity: 0;
	filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
}

/* ]]> */
</style>
<script type="text/javascript" language="javascript">
// <![CDATA[

SI.Files.stylizeAll();

/*
--------------------------------
Known to work in:
--------------------------------
- IE 5.5+
- Firefox 1.5+
- Safari 2+
                          
--------------------------------
Known to degrade gracefully in:
--------------------------------
- Opera
- IE 5.01

--------------------------------
Optional configuration:

Change before making method calls.
--------------------------------
SI.Files.htmlClass = 'SI-FILES-STYLIZED';
SI.Files.fileClass = 'file';
SI.Files.wrapClass = 'cabinet';

--------------------------------
Alternate methods:
--------------------------------
SI.Files.stylizeById('input-id');
SI.Files.stylize(HTMLInputNode);

--------------------------------
*/

// ]]>
</script>

<br />
<div style="text-align: center;">
	<?php
				if(($_POST['cobra_banco_nacion']) &&($_POST['prestamo']) && ($_POST['nombre']) && ($_POST['dni']) && ($_POST['telefono']) && ($_POST['email']))
				{
					require("class.phpmailer.php");
					$mail = new PHPMailer();
					
					$mail->IsSMTP();
					$mail->SMTPAuth = FALSE;
					$mail->Host = "localhost";
					$mail->Port = 25;

					$mail2 = new PHPMailer();
		            $mail2->IsSMTP();
					$mail2->SMTPAuth = FALSE;
					$mail2->Host = "localhost";
					$mail2->Port = 25;
					
					$cuerpo .= "<b>Préstamo:</b> " . $_POST["prestamo"] . "<br>";
					$cuerpo .= "<b>Nombre y Apellido:</b> " . $_POST["nombre"] . "<br>";
					$cuerpo .= "<b>DNI:</b> " . $_POST["dni"] . "<br>";
					$cuerpo .= "<b>Teléfono:</b> " . $_POST["telefono"] . "<br>";
					$cuerpo .= "<b>Celular:</b> " . $_POST["celular"] . "<br>";
					$cuerpo .= "<b>E-mail:</b> " . $_POST["email"] . "<br>";
					$cuerpo .= "<b>Ciudad/Localidad:</b> " . $_POST["ciudad"] . "<br>";
					$cuerpo .= "<b>Provincia:</b> " . $_POST["provincia"] . "<br>";
					$cuerpo .= "<b>Ingreso mensual:</b> " . $_POST["ingreso"] . "<br>";
					$cuerpo .= "<b>Cobra por Banco Nación:</b> " . $_POST["cobra_banco_nacion"] . "<br>";
					$cuerpo .= "<b>Propietario/Alquila:</b> " . $_POST["propietario"] . "<br>";
					$cuerpo .= "<b>Consulta:</b> " . $_POST["coment"] . "<br>";
					
					$cuerpo2 = "GRACIAS POR ELEGIRNOS, ESTAMOS PROCESANDO SU SOLICITUD. NOS PONDREMOS EN CONTACTO DENTRO DE LAS 24 HORAS.<br>ARGENPESOS";
					$mail2->From = "info@argenpesos.com.ar";
		            $mail2->FromName = "Argenpesos";
		            $mail2->Subject = "Solicitud crédito";
		            $mail2->AddAddress($_POST["email"],"Argenpesos");
		            $mail2->Body = $cuerpo2;
		            $mail2->AltBody = "prueba";
		            $mail2->Send();
					
					$mail->From = "info@argenpesos.com.ar";
					$mail->FromName = "" . $_POST["nombre"];
					$mail->Subject = "Solicitud crédito";
					$mail->AddAddress("info@argenpesos.com.ar","Argenpesos");
					//$mail->AddBCC("formularios@legioncreativa.com.ar");
					$mail->Body = $cuerpo;
					$mail->AltBody = "prueba";
					$mail->Send();
								
					echo "<div style=\"clear:both; margin: 30px 0px 0px 0px;\"><img src='imagenes/form_ok.png' alt='' /><br /><a href='https://www.facebook.com/argenpesos' target='_blank' ><img src='imagenes/seguinos.png' alt='' /></a></div>";
				}
				else 
				{
					echo "<div style=\"position: absolute; margin: 930px 0px 0px 375px; color: #FF2B00; font-size: 12px; \"></div>";
							
					?>
					<form action="?s=solicitud_credito" method=post>
					<table id="tabla_contacto_nuevo" >
						<tr> 
							<td>
								<br /><br />
								Necesito un Préstamo de:<br />
								<input type=text name="prestamo" class="campo_contacto_nuevo" value="<?php echo $_POST['prestamo']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Nombre  y Apellido:<br />
								<input type=text name="nombre" class="campo_contacto_nuevo" value="<?php echo $_POST['nombre']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								DNI:<br />
								<input type=text name="dni" class="campo_contacto_nuevo" value="<?php echo $_POST['dni']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Teléfono:<br />
								<input type=text name="telefono" class="campo_contacto_nuevo" value="<?php echo $_POST['telefono']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Celular:<br />
								<input type=text name="celular" class="campo_contacto_nuevo" value="<?php echo $_POST['celular']; ?>" >
							</td>
						</tr>						
						<tr> 
							<td>
								E-mail:<br />
								<input type=text name="email" class="campo_contacto_nuevo" value="<?php echo $_POST['email']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Ciudad/Localidad:<br />
								<input type=text name="ciudad" class="campo_contacto_nuevo" value="<?php echo $_POST['ciudad']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Provincia:<br />
								<input type=text name="provincia" class="campo_contacto_nuevo" value="<?php echo $_POST['provincia']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Ingreso mensual:<br />
								<input type=text name="ingreso" class="campo_contacto_nuevo" value="<?php echo $_POST['ingreso']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Cobra por banco nación?:<br />
								Si <input type="radio" name="cobra_banco_nacion" value="si" style="margin-right: 20px;">
								No <input type="radio" name="cobra_banco_nacion" value="no" >
							</td>
						</tr>
						<tr> 
							<td>
								Propietario/Alquila:<br />
								<input type=text name="propietario" class="campo_contacto_nuevo" value="<?php echo $_POST['propietario']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Consulta:<br />
								<textarea name=coment cols=57 rows=5 class="campo_contacto_nuevo" style="background: #ffffff; height: 150px; color: #000000; font-family: Trebuchet MS; font-size: 14px;" ></textarea>
							</td>
						</tr>
						<tr>
							<td align=right><button type="submit" class="boton_enviar_personalizado_nuevo" name="submit"><br /><br /><br /><br /></td>
						</tr>
					</table>
					</form>
					<?php
				}
				?>

<!-- Anura -->
				<div id="click2call" align="center">
<a id="click2call_callbtn">
<img src="https://www.anura.com.ar/wp-content/uploads/2015/12/btn-llama-ahora.svg">
</a>

<a id="click2call_hupbtn">
<img src="https://webrtc.anura.com.ar/click2call/img/phone_hang.png">
</a>
<div id="click2call_msgdiv"></div>


<div style="visibility: hidden; display: none;">
<input id="click2call_user" value="163">
<input id="click2call_domain" value="argen.grancentral.com.ar">
<input id="click2call_password" value="163@119d">
<input id="click2call_number" value="202">
<input id="click2call_host" value="wss://webrtc.anura.com.ar:9084">
</div>
<div id="media" style="visibility: hidden; display: none;">
<video width=800 id="webcam" autoplay="autoplay" hidden="true"></video>
</div>
</div>
<!-- Anura -->

</div>
<br />