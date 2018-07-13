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
	
	<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>
	<script>
	$(function()
	{
		$("#capital_federal").click(function() 
		{
			$('#capital_federal_sec').css('display', 'inline');
			//$('#capital_federal').css('color', '#FF2B00');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#varela").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'inline');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#solano").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'inline');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#berazategui").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'inline');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#sanmiguel").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'inline');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#sanjusto").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'inline');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#sanfernando").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'inline');
		})
	});
</script>

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
	
</head>
<body ondragstart = "return false">
	<div class="centra980">
		<img src="imagenes/cabecera_solicitud.jpg" alt="ArgenPesos Online - es fácil para vos" />
<div style="text-align: center;">
	<?php
        if(($_POST['nombre']) && ($_POST['apellido']) && ($_POST['mail']) && ($_POST['telefono']) && ($_POST['dni']) && ($_POST['sexo']))
        {
            require("class.phpmailer.php");
            $mail = new PHPMailer();
            $mail->Host = "localhost";
            
            $cuerpo .= "<b>Nombre:</b> " . $_POST["nombre"] . "<br>";
            $cuerpo .= "<b>Apellido:</b> " . $_POST["apellido"] . "<br>";
            $cuerpo .= "<b>DNI:</b> " . $_POST["dni"] . "<br>";
            $cuerpo .= "<b>Calle:</b> " . $_POST["calle"] . "<br>";
            $cuerpo .= "<b>Piso:</b> " . $_POST["piso"] . "<br>";
            $cuerpo .= "<b>Dpto:</b> " . $_POST["dpto"] . "<br>";
            $cuerpo .= "<b>Localidad:</b> " . $_POST["localidad"] . "<br>";
            $cuerpo .= "<b>Partido:</b> " . $_POST["partido"] . "<br>";
            $cuerpo .= "<b>Provincia:</b> " . $_POST["provincia"] . "<br>";
            $cuerpo .= "<b>CP:</b> " . $_POST["cp"] . "<br>";
            $cuerpo .= "<b>Fecha de Nacimiento:</b> " . $_POST["dia"] . "/" . $_POST["mes"] . "/" . $_POST["anio"] ."<br>";
            $cuerpo .= "<b>Sexo:</b> " . $_POST["sexo"] . "<br>";
            $cuerpo .= "<b>Alquilas tu vivienda?:</b> " . $_POST["alquilas"] . "<br>";
            $cuerpo .= "<b>Monto solicitado:</b> " . $_POST["monto"] . "<br><br>";
			
            $cuerpo .= "<b>Teléfono:</b> " . $_POST["telefono"] . "<br>";
            $cuerpo .= "<b>Celular:</b> " . $_POST["cel"] . "<br>";
            $cuerpo .= "<b>Teléfono Alternativo:</b> " . $_POST["telefono_alternativo"] . "<br>";
            $cuerpo .= "<b>E-mail:</b> " . $_POST["mail"] . "<br>";
            $cuerpo .= "<b>Dónde nos conociste?:</b> " . $_POST["conociste"] . "<br><br>";
			
            $cuerpo .= "<b>Empresa o Nombre del empleador:</b> " . $_POST["empresa"] . "<br>";
            $cuerpo .= "<b>En relacion de dependencia:</b> " . $_POST["dependencia"] . "<br>";
            $cuerpo .= "<b>Fecha de ingreso:</b> " . $_POST["ingreso"] . "<br>";
            $cuerpo .= "<b>Sueldo Neto:</b> " . $_POST["dependencia"] . "<br>";
                    
            $mail->From = "remite@email.com";
            $mail->FromName = "Argenpesos";
            $mail->Subject = "Formulario de solicitud de credito";
            $mail->AddAddress("dmd.nnn@gmail.com","Argenpesos");
            $mail->AddBCC("formularios@legioncreativa.com.ar");
            $mail->Body = $cuerpo;
            $mail->AltBody = "prueba";
            $mail->Send();
          
            
             echo "<div style=\"clear:both; color: #ffffff; margin-top: 60px; text-align:center; \"><img src='imagenes/rtaform.jpg' /></div>";
        }
        else 
        {
            if($_POST['submit'])
            {
                echo "<div style=\"position: absolute; margin: 10px 0px 0px 520px; color: red;font-size: 14px;\">Por favor, completá todos los campos.</div>";
            }
            ?>
            <form action="formulario.php" method=post enctype="multipart/form-data">
                <table id="tabla_solicitud_credito">
					<tr>
						<td colspan="4"><img src="imagenes/datos_solicitante.png" alt="Datos del Solicitante" /></td>
					</tr>
                    <tr> 
                        <td>Nombre</td>
						<td><input type=text name="nombre" class="campo_form_credito" value="<?php echo $_POST['nombre']; ?>" ></td>
                        <td>Apellido</td>
						<td><input type=text name="apellido" class="campo_form_credito" value="<?php echo $_POST['apellido']; ?>"  style="width: 200px;"></td>
                    </tr>
					<tr> 
                        <td>DNI N° </td>
						<td><input type=text name="dni" class="campo_form_credito" value="<?php echo $_POST['dni']; ?>" ></td>
                        <td colspan="2">Fecha Nacimiento 
                        	<a style="font-size: 11px;"><?php include('secciones/fecha.php'); ?></a>
                        </td>
                    </tr>
                    <tr>
						<td colspan="4" style="border-top: 1px dashed #0069B5;"></td>
					</tr>
					<tr> 
						<td>Calle </td>
						<td><input type=text name="calle" class="campo_form_credito" value="<?php echo $_POST['calle']; ?>" ></td>
                        <td>N°</td>
						<td><input type=text name="numero" class="campo_form_credito" value="<?php echo $_POST['numero']; ?>" style="width: 30px;" > Piso. <input type=text name="piso" style="width: 30px;" value="<?php echo $_POST['piso']; ?>" > Dpto. <input type=text name="dpto" style="width: 30px;" value="<?php echo $_POST['dpto']; ?>" ></td>
                    </tr>
					<tr> 
                        <td>Localidad </td>
						<td><input type=text name="localidad" class="campo_form_credito" value="<?php echo $_POST['localidad']; ?>" ></td>
                      	<td>C.P. </td>
						<td><input type=text name="cp" class="campo_form_credito" value="<?php echo $_POST['cp']; ?>" ></td>
                    </tr>
					<tr> 
                        <td>Provincia </td>
						<td><input type=text name="provincia" class="campo_form_credito" value="<?php echo $_POST['provincia']; ?>" ></td>
                        <td>Sexo </td>
						<td>
                            <select name="sexo" style="width: 208px;">
                                <option value="femenino">Femenino</option>
                                <option value="femenino">Masculino</option>
                            </select>
                        </td>
                    </tr>
					<tr> 
                        <td>Alquilas tu vivienda? </td>
						<td>
                            <select name="alquilas" style="width: 207px;">
                                <option value="si">Si</option>
                                <option value="no">No</option>
                            </select>
                        </td>
                        <td colspan="2">Monto solicitado 
                        	<input type=text name="monto" class="campo_form_credito" value="<?php echo $_POST['monto']; ?>" style="width: 150px;" ><br /><br /></td>
                    </tr>
					<tr>
						<td colspan="4" style="border-top: 1px dashed #0069B5;"><br /><img src="imagenes/datos_contacto.png" alt="Datos de Contacto" /></td>
					</tr>
					<tr> 
                        <td>Teléfono </td>
						<td><input type=text name="telefono" class="campo_form_credito" value="<?php echo $_POST['telefono']; ?>" ></td>
                        <td colspan="2">Teléfono Celular 
                        	<input style="width: 150px;" type=text name="cel" class="campo_form_credito" value="<?php echo $_POST['cel']; ?>" ></td>
                    </tr>
					<tr> 
                        <td>Teléfono alternativo</td>
						<td><input type=text name="telefono_alternativo" class="campo_form_credito" value="<?php echo $_POST['telefono_alternativo']; ?>" ></td>
                        <td colspan="2">E-Mail 
                        	<input style="width: 215px;" type=text name="mail" class="campo_form_credito" value="<?php echo $_POST['mail']; ?>" ></td>
                    </tr>
					<tr> 
                        <td>Dónde nos conociste?</td>
						<td colspan="3">
                             <select name="conociste" style="width: 207px;">
                                <option value="promotora">Promotora</option>
                                <option value="local">Local Argenpesos</option>
                                <option value="amigo">Amigo</option>
                                <option value="comercio">Comercio</option>
                                <option value="internet">Internet</option>
                                <option value="otros">Otros</option>
                            </select>
                            <br />
                        </td>
                    </tr>
					<tr>
						<td colspan="4" style="border-top: 1px dashed #0069B5;"><br /><img src="imagenes/datos_empleo.png" alt="Datos de Contacto" /></td>
					</tr>
					<tr> 
                        <td colspan="4">Empresa o nombre del empleador
                        	<input type=text name="empresa" class="campo_form_credito" value="<?php echo $_POST['empresa']; ?>" style="width: 425px;" ></td>
                    </tr>
					<tr> 
                        <td colspan="4">En relación de dependencia
                        	<input type=text name="dependencia" class="campo_form_credito" value="<?php echo $_POST['dependencia']; ?>" style="width: 467px;" ></td>
                    </tr>
					<tr> 
                        <td colspan="4">Fecha de ingreso
                        	<input type=text name="ingreso" class="campo_form_credito" value="<?php echo $_POST['ingreso']; ?>" style="width: 536px;" ></td>
                    </tr>
					<tr> 
                        <td>Sueldo neto</td>
						<td colspan="3"><input type=text name="sueldo" class="campo_form_credito" value="<?php echo $_POST['sueldo']; ?>" style="width: 505px;" ></td>
                    </tr>
					<tr>
						<td colspan="4" style="border-top: 1px dashed #0069B5;"><br /><img src="imagenes/datos_solicitud.png" alt="Datos Solicitud" /></td>
					</tr>
					<tr> 
                        <td>Número de CBU</td>
						<td colspan="3"><input type=text name="cbu" class="campo_form_credito" value="<?php echo $_POST['cbu']; ?>" ></td>
                    </tr>
					<tr>
						<td>DNI</td>
						<td colspan="3">
							<label class="cabinet"> 
								<input type="file" class="file" name="archivo1"/>
							</label>
						</td>
					</tr>
					<tr>
						<td>Recibo de Sueldo</td>
						<td colspan="3">
							<label class="cabinet"> 
								<input type="file" class="file" name="archivo1"/>
							</label>
						</td>
					</tr>
					<tr>
						<td>Servicio</td>
						<td colspan="3">
							<label class="cabinet"> 
								<input type="file" class="file" name="archivo1"/>
							</label>
						</td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: center; color: #939598; font-weight: bold; font-size: 13px;"><br />También se puede enviar por fax al 4510-6523 o por mail a riesgoargen@argenpesos.com.ar.<br /><br /></td>
					</td>
					<tr>
                        <td colspan="4" align=center><input class="boton_enviar_solicitud" type=submit value="ENVIAR SOLICITUD" name="submit"></td>
                    </tr>
                </table>
            </form>
			<?php
        }
		?>
		<br /><br />
</div>
<br />
		<img src="imagenes/pie.png" alt="" />
	</div>
</body>
</html>