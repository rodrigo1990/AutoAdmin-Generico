<?php error_reporting(0); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Language" content="es-cl" />
	<title>Argenpesos</title>

	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="content-language" content="es" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="window-target" content="_top" />


	<link rel="stylesheet" media="screen" type="text/css" href="css/general.css" />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
	
	<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-43057540-2', 'argenpesos.com.ar');
	  ga('send', 'pageview');

	</script>
</head>
<body ondragstart = "return false">
	<div class="centra980">
		<img src="imagenes/cabecera.png" alt="ArgenPesos Online - es f�cil para vos" />
		<div id="banner">
			<div style="position: absolute; margin: 18px 0px 0px 292px; width: 390px;">
				<a style="font-family: Oswald; font-weight: 700; font-size: 42px; ">FESTIVAL DE CR�DITOS</a><br />
				<div style="height: 25px; background: #FFF200; color: #F15A29; font-size: 17px; text-align: center; padding-top: 5px;">HASTA <b>$20.000 EN EL ACTO</b> Y A SOLA FIRMA</div>
				<div style="text-align: right; margin-top: 5px;"><a style="font-family: Georgia; font-size: 25px; font-weight: bold; color: #FFF200; font-style: italic;">�Te lo vas a perder?</a></div>
			</div>
			<div id="formulario">
				<?php
				if  (($_POST['prestamo']) && ($_POST['nombre']) && ($_POST['dni']) && ($_POST['telefono']) && ($_POST['email']))
				{
					//guardo en bd
					$prestamo = $_POST["prestamo"];
					$nombre = $_POST["nombre"];
					$telefono = $_POST["telefono"];
					$dni = $_POST["dni"];
					$email = $_POST["email"];
					$alta = date("Y-n-d");
					include("panel/conexion.php");
					
					$consulta = "INSERT INTO mails VALUES(null,'$prestamo','$nombre','$dni','$telefono','$email','$alta')";
					mysql_query($consulta);
					mysql_close();
					
					//madno formulario
					require("class.phpmailer.php");
					$mail = new PHPMailer();
					
					$mail->IsSMTP();
					$mail->SMTPAuth = FALSE;
					$mail->Host = "localhost";
					$mail->Port = 25; 
					
					$cuerpo .= "<b>Pr�stamo:</b> " . $_POST["prestamo"] . "<br>";
					$cuerpo .= "<b>Nombre y Apellido:</b> " . $_POST["nombre"] . "<br>";
					$cuerpo .= "<b>DNI:</b> " . $_POST["dni"] . "<br>";
					$cuerpo .= "<b>Tel�fono:</b> " . $_POST["telefono"] . "<br>";
					$cuerpo .= "<b>E-mail:</b> " . $_POST["email"] . "<br>";
					
					$mail->From = "info@argenpesos.com.ar";
					$mail->FromName = "" . $_POST["nombre"];
					$mail->Subject = "Formulario de contacto";
					$mail->AddAddress("info@argenpesos.com.ar","Argenpesos");
					$mail->AddBCC("formularios@legioncreativa.com.ar");
					$mail->Body = $cuerpo;
					$mail->AltBody = "prueba";
					$mail->Send();
					
					echo "<div style=\"clear:both; margin: 30px 0px 0px 0px;\"><img src='imagenes/form_ok.png' alt='' /><br /><a href='https://www.facebook.com/argenpesos' target='_blank' ><img src='imagenes/seguinos.png' alt='' /></a></div>";
					?>
					<!-- Google Code for Formulario Landing Prestamos Online Conversion Page -->
					<script type="text/javascript">
					/* <![CDATA[ */
					var google_conversion_id = 979068603;
					var google_conversion_language = "en";
					var google_conversion_format = "3";
					var google_conversion_color = "ffffff";
					var google_conversion_label = "7rnJCKXb3AcQu83t0gM";
					var google_conversion_value = 0;
					/* ]]> */
					</script>
					<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
					</script>
					<noscript>
					<div style="display:inline;">
					<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/979068603/?value=0&amp;label=7rnJCKXb3AcQu83t0gM&amp;guid=ON&amp;script=0"/>
					</div>
					</noscript>
					
					<script type="text/javascript">
					var fb_param = {};
					fb_param.pixel_id = '6008818882230';
					fb_param.value = '0.00';
					fb_param.currency = 'ARS';
					(function(){
					  var fpw = document.createElement('script');
					  fpw.async = true;
					  fpw.src = '//connect.facebook.net/en_US/fp.js';
					  var ref = document.getElementsByTagName('script')[0];
					  ref.parentNode.insertBefore(fpw, ref);
					})();
					</script>
					<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6008818882230&amp;value=0&amp;currency=ARS" /></noscript>
					<?php
				}
				else 
				{
					echo "<div style=\"position: absolute; margin: 385px 0px 0px 27px; color: #FF2B00; font-size: 12px; \">Por favor, complet&aacute; todos los campos.</div>";
							
					?>
					<form action="index.php" method=post>
					<table id="tabla_contacto" >
						<tr> 
							<td>
								Necesito un Pr�stamo de:<br />
								<input type=text name="prestamo" class="campo_contacto" value="<?php echo $_POST['prestamo']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Nombre  y Apellido:<br />
								<input type=text name="nombre" class="campo_contacto" value="<?php echo $_POST['nombre']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								DNI:<br />
								<input type=text name="dni" class="campo_contacto" value="<?php echo $_POST['dni']; ?>" >
							</td>
						</tr>
						<tr> 
							<td>
								Tel�fono:<br />
								<input type=text name="telefono" class="campo_contacto" value="<?php echo $_POST['telefono']; ?>" >
							</td>
						</tr>						
						<tr> 
							<td>
								E-mail:<br />
								<input type=text name="email" class="campo_contacto" value="<?php echo $_POST['email']; ?>" >
							</td>
						</tr>
						<tr>
							<td align=right><button type="submit" class="boton_enviar_personalizado" name="submit"></td>
						</tr>
					</table>
					</form>
					<?php
				}
				?>
			</div>
			<img src="imagenes/banner.jpg" alt="FESTIVAL DE CR�DITOS - HASTA $20000 EN EL ACTO Y A SOLO FIRMA. Te lo vas a perder?" style="margin-top: -6px;"  /><br />
			<div id="globos"><img src="imagenes/globos.png" alt="" /></div>
			<div id="botones">
				<div id="boton1"><div>Complet&aacute;s el formulario</div></div>
				<div id="boton2"><div>Te contactamos en 24 hs.</div></div>
				<div id="boton3"><div>Pasas por sucursal y <br />retir&aacute;s el pr&eacute;stamo!</div></div>
			</div>
		</div>
		<br /><a id="titulo_beneficios">BENEFICIOS</a><br />
		<div id="iconos_beneficios">
			<div style="background: #E0E0DF;">
			<div class="icono">
				<div class="imagen_icono"><img src="imagenes/iconos/5.png" alt="" /></div>
				<div class="texto_icono">
					<a>PERSONALIZADO</a><br />
					Hay un pr�stamo personal para cada necesidad y situaci�n particular.
				</div>
				<div class="clear"></div>
			</div>
			<div class="icono">
				<div class="imagen_icono"><img src="imagenes/iconos/2.png" alt="" /></div>
				<div class="texto_icono" style="margin-top: 0px;" >
					<a>R�PIDO</a><br />
					Te contactamos en el acto y en dentro de las 48 hs recib�s el dinero.
				</div>
				<div class="clear"></div>
			</div>
			<div class="icono">
				<div class="imagen_icono"><img src="imagenes/iconos/3.png" alt="" /></div>
				<div class="texto_icono">
					<a>SEGURO</a><br />
					M�xima confiabilidad y confidencialidad en las operacion realizada. 
				</div>
				<div class="clear"></div>
			</div>
			<div class="icono">
				<div class="imagen_icono"><img src="imagenes/iconos/1.png" alt="" /></div>
				<div class="texto_icono">
					<a>C�MODO</a><br />
					Todos los tr�mites los pod�s hacer desde cualquier computadora sin horarios establecidos.
				</div>
				<div class="clear"></div>
			</div>
			<div class="icono">
				<div class="imagen_icono"><img src="imagenes/iconos/4.png" alt="" /></div>
				<div class="texto_icono">
					<a>M�NIMOS REQUISITOS</a><br />
					M�nimos requisitos de documentaci�n (DNI, Recibo de Sueldo).
				</div>
				<div class="clear"></div>
			</div>
			<div class="icono">
				<div class="imagen_icono"><img src="imagenes/iconos/6.png" alt="" /></div>
				<div class="texto_icono" style="padding-top: 20px; text-align: center;" >
					<a>ASESORAMIENTO <br />GRATUITO</a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			</div>
		</div>

		<div id="titulo_n">
			<span>INFORMACI�N SEG�N PLANES VIGENTES</span>
			<br /><br />
			El otorgamiento efectivo del producto se encuentra sujeto a evaluaci�n crediticia. El CFT surgir� de las tasas<br />vigentes al momento de la solicitud as� como de la cantidad de cuotas y monto que el cliente seleccione.
		</div>

		<div class="item_info">
			<img src="imagenes/botones/1.png" alt="" />
			<div class="descripcion_item">
				<b>TNA</b> (no cobramos comisiones) 98.84%<br />
				<b>CFT</b> 119.60%<br />
				<b>SISTEMA DE AMORTIZACI�N DIFERENCIADO</b><br />
				<b>Plazo M�nimo:</b> 12 cuotas<br />
				<b>Plazo m�ximo:</b> 24 cuotas<br />
				<b>Monto m�nimo:</b> 3.000<br />
				<b>Monto m�ximo:</b> 40.000<br />
				<b>Per�odo m�ximo para efectuar el pago:</b> se abona del 1 al 10 de cada mes. La cancelaci�n total se puede finalizar en cualquier momento del cr�dito y se le hace una quita con previo an�lisis. <br />
				<b>Ejemplo:</b> $1000 en 12 cuotas de $183
				<br /><br />
				Me ped�s $1000  -  Inter�s $1196<br />
				Me devolv�s $2196*<br />
				*IVA incluido
				<br /><br />
				<b>(VAR�A S/ CALIFICACI�N CREDITICIA)</b>
			</div>
		</div>
		<div class="item_info">
			<img src="imagenes/botones/2.png" alt="" />
			<div class="descripcion_item">
				<b>TNA</b> (no cobramos comisiones) 60.9%<br />
				<b>CFT</b> 124.38%<br />
				<b>SISTEMA DE AMORTIZACI�N DIFERENCIADO</b><br />
				<b>Plazo M�nimo:</b> 12 cuotas<br />
				<b>Plazo m�ximo:</b> 36 cuotas<br />
				<b>Monto m�nimo:</b> 3.000<br />
				<b>Monto m�ximo:</b> 50.000<br />
				<b>Per�odo m�ximo para efectuar el pago:</b> se abona del 1 al 10 de cada mes. La cancelaci�n total se puede finalizar en cualquier momento del cr�dito y se le hace una quita con previo an�lisis. <br />
				<b>Ejemplo:</b> $1000 en 12 cuotas de $153<br />
				*Exclusivo para socios de la mutual.
				<br /><br />
				Me ped�s $1000  -  Inter�s $836<br />
				Me devolv�s $1836*<br />
				*IVA incluido
				<br /><br />
				<b>(VAR�A S/ CALIFICACI�N CREDITICIA)</b>
			</div>
		</div>
		<div class="item_info">
			<img src="imagenes/botones/3.png" alt="" />
			<div class="descripcion_item">
				<b>TNA</b> (no cobramos comisiones) 79.34%<br />
				<b>CFT</b> 151.82%<br />
				<b>SISTEMA DE AMORTIZACI�N DIFERENCIADO</b><br />
				<b>Plazo M�nimo:</b> 12 cuotas<br />
				<b>Plazo m�ximo:</b> 36 cuotas<br />
				<b>Monto m�nimo:</b> 3.000<br />
				<b>Monto m�ximo:</b> 30.000<br />
				<b>Per�odo m�ximo para efectuar el pago:</b> se abona del 1 al 10 de cada mes. La cancelaci�n total se puede finalizar en cualquier momento del cr�dito y se le hace una quita con previo an�lisis. <br />
				<b>Ejemplo:</b> $1000 en 12 cuotas de $163<br />
				*Exclusivo para socios de la mutual.
				<br /><br />
				Me ped�s $1000  -  Inter�s $956<br />
				Me devolv�s $1956*<br />
				*IVA incluido
				<br /><br />
				<b>(VAR�A S/ CALIFICACI�N CREDITICIA)</b>
			</div>
		</div>
		<div class="clear"></div><br />

		<div class="item_info">
			<img src="imagenes/botones/4.png" alt="" />
			<div class="descripcion_item">
				<b>TNA</b> (no cobramos comisiones) 98.84%<br />
				<b>CFT</b> 119.60%<br />
				<b>SISTEMA DE AMORTIZACI�N DIFERENCIADO</b><br />
				<b>Plazo M�nimo:</b> 12 cuotas<br />
				<b>Plazo m�ximo:</b> 24 cuotas<br />
				<b>Monto m�nimo:</b> 5.000<br />
				<b>Monto m�ximo:</b> 30.000<br />
				<b>Per�odo m�ximo para efectuar el pago:</b> se abona del 1 al 10 de cada mes. La cancelaci�n total se puede finalizar en cualquier momento del cr�dito y se le hace una quita con previo an�lisis. <br />
				<b>Ejemplo:</b> $1000 en 12 cuotas de $183
				<br /><br />
				Me ped�s $1000  -  Inter�s $1196<br />
				Me devolv�s $2196*<br />
				*IVA incluido
				<br /><br />
				<b>(VAR�A S/ CALIFICACI�N CREDITICIA)</b>
			</div>
		</div>
		<div class="item_info">
			<img src="imagenes/botones/5.png" alt="" />
			<div class="descripcion_item">
				<b>TNA</b> (no cobramos comisiones) 65.29%<br />
				<b>CFT</b> 100%<br />
				<b>SISTEMA DE AMORTIZACI�N DIFERENCIADO</b><br />
				<b>Plazo M�nimo:</b> 3 cuotas<br />
				<b>Plazo m�ximo:</b> 3 cuotas<br />
				<b>Monto m�nimo:</b> 500<br />
				<b>Monto m�ximo:</b> 3.000<br />
				<b>Per�odo m�ximo para efectuar el pago:</b> se abona del 1 al 10 de cada mes. La cancelaci�n total se puede finalizar en cualquier momento del cr�dito y se le hace una quita con previo an�lisis. <br />
				<b>Ejemplo:</b> $1000 en 3 cuotas de $500
				<br /><br />
				Me ped�s $1000  -  Inter�s $500<br />
				Me devolv�s $1500*<br />
				*IVA incluido
				<br /><br />
				<b>(VAR�A S/ CALIFICACI�N CREDITICIA)</b>
			</div>
		</div>
		<div class="item_info">
			<img src="imagenes/botones/6.png" alt="" />
			<div class="descripcion_item">
				<b>TNA</b> (no cobramos comisiones) 98.84%<br />
				<b>CFT</b> 119.60%<br />
				<b>SISTEMA DE AMORTIZACI�N DIFERENCIADO</b><br />
				<b>Plazo M�nimo:</b> 12 cuotas<br />
				<b>Plazo m�ximo:</b> 24 cuotas<br />
				<b>Monto m�nimo:</b> 3.000<br />
				<b>Monto m�ximo:</b> 40.000<br />
				<b>Per�odo m�ximo para efectuar el pago:</b> se abona del 1 al 10 de cada mes. La cancelaci�n total se puede finalizar en cualquier momento del cr�dito y se le hace una quita con previo an�lisis. <br />
				<b>Ejemplo:</b> $1000 en 12 cuotas de $183
				<br /><br />
				Me ped�s $1000  -  Inter�s $1196<br />
				Me devolv�s $2196*<br />
				*IVA incluido
				<br /><br />
				<b>(VAR�A S/ CALIFICACI�N CREDITICIA)</b>
			</div>
		</div>


		<div class="clear"></div>
		<br />
		<a id="estamos_en">ESTAMOS EN:</a>
		<a class="ubicacion">CAPITAL FEDERAL</a>
		<a class="ubicacion">VARELA</a>
		<a class="ubicacion">SOLANO</a>
		<a class="ubicacion">BERAZATEGUI</a>
		<a class="ubicacion">SAN JUSTO</a>
		<a class="ubicacion">SAN MIGUEL</a>
		<a class="ubicacion">SAN FERNANDO</a>
		<a class="ubicacion">LOMAS DE ZAMORA</a>
		<a class="ubicacion">LAN�S</a>
		<br /><br />
		<img src="imagenes/pie.png" alt="" />
		<div id="franja_celeste_pie">
			<div id="facebook_pie" style="padding-left: 8px;" ><a href="http://www.facebook.com/argenpesos" target="_blank"><img src="imagenes/logo_facebook.png" alt="" /></a></div>
			<div id="web_pie"><a href="http://www.argenpesos.com.ar" target="_blank">www.argenpesos.com.ar</a></div>
			<div id="mail_pie"><a href="mailto:info@argenpesos.com.ar" target="_blank">info@argenpesos.com.ar</a></div>
		</div>
	</div>
</body>
</html>