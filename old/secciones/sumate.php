<script type="text/javascript" src="js/si.files.js"></script>
<style type="text/css" title="text/css">
/* <![CDATA[ */

.SI-FILES-STYLIZED label.cabinet
{
	width: 162px;
	height: 34px;
	background: url(imagenes/sumate/adjuntar_cv.png) 0 0 no-repeat;

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

<div id="contiene_sumate">
	<img src="imagenes/sumate/sumate_equipo.png" alt="SUMATE A NUESTRO EQUIPO DE TRABAJO" />
	<div class="titulo_formulario_sumate">COMPLETÁ EL FORMULARIO</div>
	<div class="contiene_formulario_sumate">
		<?php
        if  (($_POST['nombre']) && ($_POST['mail']) && ($_POST['telefono']))
        {
            require("class.phpmailer.php");
            $mail = new PHPMailer();
            $mail->Host = "localhost";
            
            $cuerpo .= "<b>Nombre:</b> " . $_POST["nombre"] . "<br>";
            $cuerpo .= "<b>Puesto:</b> " . $_POST["puesto"] . "<br>";
            $cuerpo .= "<b>Fecha de nacimiento:</b> " . $_POST["fechanac"] . "<br>";
            $cuerpo .= "<b>Calle:</b> " . $_POST["calle"] . "<br>";
            $cuerpo .= "<b>DNI:</b> " . $_POST["dni"] . "<br>";
            $cuerpo .= "<b>Número:</b> " . $_POST["numero"] . "<br>";
            $cuerpo .= "<b>Teléfono:</b> " . $_POST["telefono"] . "<br>";
            $cuerpo .= "<b>Localidad:</b> " . $_POST["localidad"] . "<br>";
            $cuerpo .= "<b>E-Mail:</b> " . $_POST["mail"] . "<br>";
            $cuerpo .= "<b>Provincia:</b> " . $_POST["provincia"] . "<br>";
            $cuerpo .= "<b>Comentarios:</b> " . $_POST["comment"] . "<br>";
                    
            $mail->From = "info@argenpesos.com.ar";
            $mail->FromName = "Argenpesos";
            $mail->Subject = "Formulario de contacto";
            $mail->AddAddress("info@argenpesos.com.ar","Argenpesos");
            //$mail->AddBCC("formularios@legioncreativa.com.ar");
            $mail->Body = $cuerpo;
            $mail->AltBody = "prueba";
            $mail->Send();
          
            
             echo "<div style=\"clear:both; color: #F9EC35; line-height:200px; text-align:center; \">El  formulario se ha enviado correctamente.</div>";
        }
        else 
        {
            if($_POST['submit'])
            {
                echo "<div style=\"position: absolute; margin: 310px 0px 0px 616px; width: 280px; color: #ED0000; line-height:10px; font-size: 14px;\">Por favor, completá todos los campos</div>";
            }
            ?>
			<form action="?s=sumate" method=post enctype="multipart/form-data">
				<table style="width: 890px; padding: 10px 0px 20px 10px;">
					<tr>
						<td>Nombre y Apellido</td>
						<td>Puesto</td>
						<td>Comentarios</td>
					</tr>
					<tr>
						<td><input type=text name="nombre" class="campo_sumate" value="<?php echo $_POST['nombre']; ?>" ></td>
						<td><input type=text name="puesto" class="campo_sumate" value="<?php echo $_POST['puesto']; ?>" ></td>
						<td rowspan="9" valign="top" ><textarea name=coment cols=35 rows=14 ></textarea></td>
					</tr>
					<tr>
						<td>Fecha de Nacimiento</td>
						<td>Dirección</td>
						<td></td>
					</tr>
					<tr>
						<td><input type=text name="fechanac" class="campo_sumate" value="<?php echo $_POST['fechanac']; ?>" ></td>
						<td><input type=text name="calle" class="campo_sumate" value="Calle" onfocus="if(this.value=='Calle')this.value='<?php echo $_POST['calle']; ?>'" ></td>
						<td></td>
					</tr>
					<tr>
						<td>DNI</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><input type=text name="dni" class="campo_sumate" value="<?php echo $_POST['dni']; ?>" ></td>
						<td><input type=text name="numero" class="campo_sumate" value="Número" onfocus="if(this.value=='Número')this.value='<?php echo $_POST['numero']; ?>'" ></td>
						<td></td>
					</tr>
					<tr>
						<td>Teléfono</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><input type=text name="telefono" class="campo_sumate" value="<?php echo $_POST['telefono']; ?>" ></td>
						<td><input type=text name="localidad" class="campo_sumate" value="Localidad" onfocus="if(this.value=='Localidad')this.value='<?php echo $_POST['localidad']; ?>'" ></td>
						<td></td>
					</tr>
					<tr>
						<td>E-Mail</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><input type=text name="mail" class="campo_sumate" value="<?php echo $_POST['mail']; ?>" ></td>
						<td><input type=text name="provincia" class="campo_sumate" value="Provincia" onfocus="if(this.value=='Provincia')this.value='<?php echo $_POST['provincia']; ?>'" ></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<label class="cabinet"> 
								<input type="file" class="file" name="archivo1"/>
							</label>
						</td>
						<td align="right" style="padding-right: 25px;"><input id="boton_enviar_sumate" type=submit value="ENVIAR" name="submit"></td>
						<input type="hidden" name="MAX_FILE_SIZE" value="10485760"> 
					</tr>
				</table>
			</form>
			<?php
        }
		?>
	</div>
	<br />
	
</div>