<?php include('header.php'); ?>

<img src="imagenes/cuenta/cabecera.jpg" alt="" class="img_full" />
<br /><br /><br />

<div class="container">
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3">

      <?php
      if(($_POST['submit']) && ($_POST['nombre']) && ($_POST['apellido']))
      {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $tipo_documento = $_POST['tipo_documento'];
        $documento_numero = $_POST['documento_numero'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $check_horario_contacto = $_POST['check_horario_contacto'];
        $consulta = $_POST['consulta'];
        $horario_contacto = $_POST['horario_contacto'];

        require("class.phpmailer.php");

        $mail = new PHPMailer();
        $mail->Host = "localhost";
        $mail->IsHTML(true);
      
        $cuerpo .= "<b>Nombre:</b> " . $nombre . "<br>";
        $cuerpo .= "<b>Apellido:</b> " . $apellido . "<br>";
        $cuerpo .= "<b>Tipo de documento:</b> " . $tipo_documento . "<br>";
        $cuerpo .= "<b>Documento Número:</b> " . $documento_numero . "<br>";
        $cuerpo .= "<b>Teléfono:</b> " . $telefono . "<br>";
        $cuerpo .= "<b>Mail:</b> " . $email . "<br>";
        if($check_horario_contacto == "otro")
        {
          $cuerpo .= "<b>Contactarlo en el horario:</b> " . $horario_contacto . "<br>";
        }
        else
        {
          $cuerpo .= "<b>Contactarlo en el horario:</b> " . $check_horario_contacto . "<br>";
        }
        $cuerpo .= "<b>Consulta:</b> " . $consulta . "<br>";
                    
        $mail->From = "info@argenpesos.com.ar";
        $mail->FromName = "ArgenPesos";
        $mail->Subject = "Form: CONSULTA TU CUENTA";
        $mail->AddAddress("cobranzasargenpesos@argenpesos.com.ar","Argenpesos");
        $mail->Body = $cuerpo;
        $mail->AltBody = "";
        $mail->CharSet = 'UTF-8';
        $mail->Send();

        ?>
        <div style="color:#eb5838; text-align: center; font-weight: bold; font-size: 19px; padding: 100px 0px;">Formulario enviado correctamente.</div>
        <?php
      }
      else
      {
      ?>
      <form action="consulta_cuenta.php" method="post">
        <div class="row">
          <div class="col-sm-3 izquierda_cuenta">Nombre</div>
          <div class="col-sm-9"><input type="text" name="nombre" class="input_cuenta" required /></div>
        </div>
        <div class="row">
          <div class="col-sm-3 izquierda_cuenta">Apellido</div>
          <div class="col-sm-9"><input type="text" name="apellido" class="input_cuenta" required /></div>
        </div>
        <div class="row">
          <div class="col-sm-3 izquierda_cuenta">Tipo de documento</div>
          <div class="col-sm-9"><input type="text" name="tipo_documento" class="input_cuenta" required /></div>
        </div>
        <div class="row">
          <div class="col-sm-3 izquierda_cuenta">Documento Número</div>
          <div class="col-sm-9"><input type="text" name="documento_numero" class="input_cuenta" required /></div>
        </div>
        <div class="row">
          <div class="col-sm-3 izquierda_cuenta">Teléfono de línea</div>
          <div class="col-sm-9"><input type="text" name="telefono" class="input_cuenta" required /></div>
        </div>
        <div class="row">
          <div class="col-sm-3 izquierda_cuenta">Email</div>
          <div class="col-sm-9"><input type="email" name="email" class="input_cuenta" required /></div>
        </div>
        <div class="row">
          <div class="col-sm-3 izquierda_cuenta">Contactarlo en el horario</div>
          <div class="col-sm-9" style="padding-top: 10px;">
            <input type="radio" name="check_horario_contacto" style="margin: 0px 5px 15px 0px" value="9.00 a 14.30" /> <span style="color: #eb5838; font-size: 13px;">9.00 a 14.30</span><br />
            <input type="radio" name="check_horario_contacto" style="margin: 0px 5px 15px 0px" value="14.30 a 20.00" /> <span style="color: #eb5838; font-size: 13px;">14.30 a 20.00</span><br />
            <input type="radio" name="check_horario_contacto" style="margin: 0px 5px 15px 0px" value="9.00 a 20.00" /> <span style="color: #eb5838; font-size: 13px;">9.00 a 20.00</span><br />
            <input type="radio" name="check_horario_contacto" style="margin: 0px 5px 15px 0px" value="otro" /> <input type="text" name="horario_contacto" class="input_cuenta" placeholder="especificar" style="max-width: 387px;" />
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3 izquierda_cuenta">Comentarios</div>
          <div class="col-sm-9"><textarea name="consulta" class="input_cuenta" required></textarea></div>
        </div>
        <div class="row">
          <div class="col-sm-12 text-right"><input type="submit" name="submit" value="ENVIAR" class="btn_naranja_form" /></div>
        </div>
      </form>
      <?php
      }
      ?>

    </div>
  </div>
</div>

<br /><br />
<?php include('footer.php'); ?>