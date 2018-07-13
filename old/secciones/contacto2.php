<div id="contiene_contacto">
	<div id="selector_argenpesos_contacto"><img src="imagenes/selector.png" alt="" /></div>
	<div id="izquierda_contacto">
		<?php
        if  (($_POST['nombre']) && ($_POST['mail']) && ($_POST['telefono']))
        {
            require("class.phpmailer.php");
            $mail = new PHPMailer();
            $mail->IsSMTP();
			
			$mail->SMTPAuth = FALSE;
			$mail->Host = "localhost";
			$mail->Port = 25;
			
			/*
			$mail->SMTPAuth = true;
			$mail->Host = "mx1.epb.com.ar"; 
			$mail->Username = "webserver@epb.com.ar"; 
			$mail->Password = "12345678";
			$mail->Port = 25;
			
			$mail->SMTPAuth = true;
			$mail->Host = "mx1.epb.com.ar"; 
			$mail->Username = "epbcentral\webserver"; 
			$mail->Password = "12345678";
			$mail->Port = 25;
			*/
			
			$bdnombreyapellido = $_POST['nombre'];
			$bdmail = $_POST['mail'];
			$bdtelefono = $_POST['telefono'];
			$bdcoment = $_POST['coment'];
			$bddia = date("d");
			$bdmes = date("n");
			$bdanio = date("Y");
			$bdfecha = date("Y-n-d");
			
			include ("panel/conexion.php");
			$bdconsulta = "INSERT INTO `formularios` VALUES (null,'$bdnombreyapellido','$bdmail','$bdtelefono','$bdcoment','$bddia','$bdmes','$bdanio','$bdfecha')";
			mysql_query($bdconsulta);
            
            $cuerpo .= "<b>Nombre:</b> " . $_POST["nombre"] . "<br>";
            $cuerpo .= "<b>E-mail:</b> " . $_POST["mail"] . "<br>";
            $cuerpo .= "<b>Teléfono:</b> " . $_POST["telefono"] . "<br>";
            $cuerpo .= "<b>Comnsulta:</b> " . $_POST["coment"] . "<br>";
                    
            $mail->From = "info@argenpesos.com.ar";
            $mail->FromName = "Argenpesos";
            $mail->Subject = "Formulario de contacto (WEB Argenpesos)";
            $mail->AddAddress("info@argenpesos.com.ar","Argenpesos");
            $mail->AddBCC("dmd.nnn@gmail.com");
            $mail->Body = $cuerpo;
            $mail->AltBody = "prueba";
            $mail->Send();
          
            
             echo "<div style=\"clear:both; color: #F9EC35; line-height:200px; text-align:center; \">El  formulario se ha enviado correctamente.</div>";
        }
        else 
        {
            if($_POST['submit'])
            {
                echo "<div style=\"position: absolute; margin: 212px 0px 0px 10px; width: 280px; color: #F9EC35; line-height:10px; font-size: 14px;\">Por favor, completá todos los campos.</div>";
            }
            ?>
			<a id="titulo_contacto">ENVIANOS TU CONSULTA</a>
			<br /><br />
            <form action="?s=contacto" method=post>
                <table id="tabla_contacto" >
                    <tr> 
                        <td><input type=text name="nombre" class="campo_contacto" value="Nombre y Apellido" onfocus="if(this.value=='Nombre y Apellido')this.value='<?php echo $_POST['nombre']; ?>'" ></td>
                    </tr>
					<tr> 
                        <td><input type=text name="mail" class="campo_contacto" value="E-Mail" onfocus="if(this.value=='E-Mail')this.value='<?php echo $_POST['mail']; ?>'" ></td>
                    </tr>
					<tr> 
                        <td><input type=text name="telefono" class="campo_contacto" value="Teléfono" onfocus="if(this.value=='Teléfono')this.value='<?php echo $_POST['telefono']; ?>'" ></td>
                    </tr>
					<tr> 
                        <td><textarea name=coment cols=57 rows=5 style="border:0px; background: #ffffff; color: #005AA4; font-family: Trebuchet MS; font-size: 14px;" >Consulta</textarea></td>
                    </tr>
					<tr>
                        <td align=right><input id="boton_enviar_contacto" type=submit value="ENVIAR" name="submit"></td>
                    </tr>
                </table>
            </form>
			<?php
        }
		?>
	</div>
	<div id="derecha_contacto">
		<div class="punto_contacto">
			<a>Capital Federal</a><br />
			Reconquista 660 - Tel: 4510-6594 / 71
		</div>
		<div class="punto_contacto">
			<a>Varela</a><br />
			Monteagudo 345 - Tel: 4287-8544 /8567
		</div>
		<div class="punto_contacto">
			<a>San Miguel</a><br />
			Av. Mitre 1302 - Tel: 4451-5925 / 5787
		</div>
		<div class="punto_contacto">
			<a>Berazategui</a><br />
			Av. 14 Nº5022 - Tel: 4356-0717 / 0911
		</div>
		<div class="punto_contacto">
			<a>San Fernando</a><br />
			Las Heras 1210 - Tel: 4506-3730 / 3732
		</div>
		<div class="punto_contacto">
			<a>San Justo</a><br />
			Dr. Ignacio Arieta 3496 - Tel: 4651-0046
		</div>
		<div class="punto_contacto">
			<a>Solano</a><br />
			Calle 845 Nº2590 - Tel: 4212-6770 / 7174
		</div>
	</div>
	<div class="clear"></div>
	<br />
</div>
<?php include('secciones/pedilo_ahora.php'); ?>