<div id="fondo_celeste">
	<div class="centra_contenido_clientes">
		<a class="titulos_clientes">PROMOCIONES ESPECIALES</a><br/ ><br/ >
		Acá vas a encontrar promociones especiales que otorgaremos exclusivamente a nuestros clientes.
		<br /><br /><br />
		<img src="imagenes/clientes/banner.jpg" alt="BANNER" />
	</div>
</div>

<div id="fondo_verde">
	<div class="centra_contenido_clientes">
		<a class="titulos_clientes">CONSULTAS PERSONALES</a><br/ ><br/ >
		También tenemos una atención a especial. Por eso brindamos un espacio de comunicación directa. Dejanos tus inquietudes.
		<br /><br />
		<?php
        if  (($_POST['nombre']) && ($_POST['mail']) && ($_POST['telefono']))
        {
            require("class.phpmailer.php");
            $mail = new PHPMailer();
            $mail->Host = "localhost";
            
            $cuerpo .= "<b>Nombre:</b> " . $_POST["nombre"] . "<br>";
                    
            $mail->From = "info@argenpesos.com.ar";
            $mail->FromName = "Argenpesos";
            $mail->Subject = "Formulario de contacto";
            $mail->AddAddress("info@argenpesos.com.ar","Argenpesos");
           // $mail->AddBCC("formularios@legioncreativa.com.ar");
            $mail->Body = $cuerpo;
            $mail->AltBody = "prueba";
            $mail->Send();
          
            
             echo "<div style=\"clear:both; margin: -30px 0px 0px 0px; width: 640px; height: 300px; background-color:#ffffff; color: #58ABDF;   font-family:Calibri;line-height:300px;font-size:16px;text-align:center;\">El  formulario se ha enviado correctamente.</div>";
        }
        else 
        {
            if($_POST['submit'])
            {
                echo "<div style=\"position: absolute; margin: 255px 0px 0px 10px; width: 280px; color: #FF2B00; line-height:10px; font-size: 16px;\">Por favor, completá todos los campos.</div>";
            }
            ?>
            <form action="?s=contacto" method=post>
                <table id="tabla_contacto" >
                    <tr> 
                        <td><textarea name=coment cols=102 rows=5 style="border:0px; background: #ffffff;"></textarea></td>
                    </tr>
					<tr>
                        <td align=right><input id="boton_enviar_verde" type=submit value="ENVIAR" name="submit"></td>
                    </tr>
                </table>
            </form>
			<?php
        }
		?>
	</div>
</div>

<div id="fondo_naranja">
	<div class="centra_contenido_clientes">
		<a class="titulos_clientes">DEUDAS O SITUACIONES ESPECIALES</a><br/ ><br/ >
		Si estás teniendo dificultades para cumplir con los pagos NO TE PREOCUPES! Podemos darte una ayuda inmediata. Dejanos tus datos y nos contactamos.
		<br /><br />
		
		<?php
        if  (($_POST['nombre']) && ($_POST['mail']) && ($_POST['telefono']))
        {
            require("class.phpmailer.php");
            $mail = new PHPMailer();
            $mail->Host = "localhost";
            
            $cuerpo .= "<b>Nombre:</b> " . $_POST["nombre"] . "<br>";
            $cuerpo .= "<b>E-mail:</b> " . $_POST["mail"] . "<br>";
            $cuerpo .= "<b>Teléfono:</b> " . $_POST["telefono"] . "<br>";
                    
            $mail->From = "remite@email.com";
            $mail->FromName = "Argenpesos";
            $mail->Subject = "Formulario de contacto";
            $mail->AddAddress("info@argenpesos.com.ar","Argenpesos");
            $mail->AddBCC("formularios@legioncreativa.com.ar");
            $mail->Body = $cuerpo;
            $mail->AltBody = "prueba";
            $mail->Send();
          
            
             echo "<div style=\"clear:both; margin: -30px 0px 0px 0px; width: 640px; height: 300px; background-color:#ffffff; color: #58ABDF;   font-family:Calibri;line-height:300px;font-size:16px;text-align:center;\">El  formulario se ha enviado correctamente.</div>";
        }
        else 
        {
            if($_POST['submit'])
            {
                echo "<div style=\"position: absolute; margin: 255px 0px 0px 10px; width: 280px; color: #FF2B00; line-height:10px; font-size: 16px;\">Por favor, completá todos los campos.</div>";
            }
            ?>
            <form action="?s=contacto" method=post>
                <table id="tabla_contacto" >
                    <tr> 
                        <td><input type=text name="nombre" class="campo_naranja_clientes" value="Nombre y Apellido" onfocus="if(this.value=='Nombre y Apellido')this.value='<?php echo $_POST['nombre']; ?>'" ></td>
                    </tr>
					<tr> 
                        <td><input type=text name="mail" class="campo_naranja_clientes" value="E-Mail" onfocus="if(this.value=='E-Mail')this.value='<?php echo $_POST['mail']; ?>'" ></td>
                    </tr>
					<tr> 
                        <td><input type=text name="telefono" class="campo_naranja_clientes" value="Teléfono" onfocus="if(this.value=='Teléfono')this.value='<?php echo $_POST['telefono']; ?>'" ></td>
                    </tr>
					<tr>
                        <td align=right><input id="boton_enviar_naranja" type=submit value="ENVIAR" name="submit"></td>
                    </tr>
                </table>
            </form>
			<?php
        }
		?>
	</div>
</div>