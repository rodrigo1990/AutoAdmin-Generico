<?php error_reporting(0); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ArgenPesos</title>
    <meta name="Keywords" content="">
    <meta name="Description" content=""/>

    <link rel="icon" type="image/png" href="imagenes/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="imagenes/favicon-16x16.png" sizes="16x16" />

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/queries.css" rel="stylesheet">
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">

    
  </head>
  
  <body>
  <div id="contanedor">
    
    <div class="col-sm-12" id="izquierda_form">
      <div id="logo"><img src="imagenes/logo.png" alt="" /><?php echo $_POST['localidad']; ?></div> 
      
      <?php
      if(($_POST['nombre']) && ($_POST['dni']))
      {
        $valor_monto = $_POST['valor_monto'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $sexo = $_POST['sexo'];
        $codigo_area = $_POST['codigo_area'];
        $celular = $_POST['celular'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $mail_usuario = $_POST['mail'];
        $banco = $_POST['banco'];
        $localidad= $_POST['localidad'];
        $provincia=$_POST['provincia'];

        require("class.phpmailer.php");
        $mail_administrador = new PHPMailer();
        $mail_administrador->Host = "localhost";
        $mail_administrador->IsHTML(true);

        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = "mcd77.1990@gmail.com";
        $mail->Password = "Javierjavier1990";
        $mail->Port = "465";
      
        $cuerpo_admin .= "<b>Monto Solicitado:</b> $" . $_POST["valor_monto"] . "<br>";
        $cuerpo_admin .= "<b>Nombre:</b> " . $_POST["nombre"] . "<br>";
        $cuerpo_admin .= "<b>Apellido:</b> " . $_POST["apellido"] . "<br>";
        $cuerpo_admin .= "<b>DNI:</b> " . $_POST["dni"] . "<br>";
        $cuerpo_admin .= "<b>Sexo:</b> " . $_POST["sexo"] . "<br>";
        $cuerpo_admin .= "<b>Código de Área:</b> " . $_POST["codigo_area"] . "<br>";
        $cuerpo_admin .= "<b>Celular:</b> " . $_POST["celular"] . "<br>";
        $cuerpo_admin .= "<b>Fecha de Nacimiento:</b> " . $_POST["fecha_nacimiento"] . "<br>";
        $cuerpo_admin .= "<b>Mail:</b> " . $_POST["mail"] . "<br>";
        $cuerpo_admin .= "<b>Localidad:</b> " . $_POST["localidad"] . "<br>";
        $cuerpo_admin .= "<b>Empleador:</b> " . $_POST["empleador"] . "<br>";
        $cuerpo_admin .= "<b>Banco:</b> " . $_POST["banco"] . "<br>";
                    
        $mail_administrador->From = "info@argenpesosonline.com.ar";
        $mail_administrador->FromName = "ArgenPesos";
        $mail_administrador->Subject = "Solicitud de Préstamo";

        $mail_val = rand(0, 1);
        if($mail_val == 0)
        {
          $mail_administrador->AddAddress("mcd77.1990@gmail.com","ArgenPesos");
        }
        else
        {
          $mail_administrador->AddAddress("mcd77.1990@gmail.com","ArgenPesos");
        }

        $mail_administrador->Body = $cuerpo_admin;
        $mail_administrador->AltBody = "";
        $mail_administrador->CharSet = 'UTF-8';
        $mail_administrador->Send();





        //16509=san justo, 16525=san miguel, 16439==san fernando, 16450=lomas de zamora
        //16381=lanus,//16588=berazategui, 16553=solano,2458=avellandera,16551=quilmes
        if($localidad==16509 OR $localidad==16525 OR $localidad==16450 OR $localidad==16381
          OR $localidad==16588 OR $localidad==16553 OR $localidad==2458 OR $localidad==16551 OR $provincia==22)
        {
          $mail_admin = $mail_usuario;

          $mail = new PHPMailer();
          $mail->Host = "localhost";
          $mail->IsHTML(true);
      
          $cuerpo .= "<table style='color: #1da3dd; font-size: 17px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;'>";
          $cuerpo .= "<tr><td><img src='http://legionvps.com/trabajos/argenpesos/imagenes/logo_mail.png' style='width: 100%; max-width: 240px;' /></td></tr>";
          $cuerpo .= "<tr><td style='text-transform:uppercase;'><br />¡ESTIMADO/A $nombre $apellido TU CRÉDITO HA SIDO PREAPROBADO!<br /><br /></td></tr>";
          $cuerpo .= "<tr><td style='font-size: 13px; color: #88898d; font-weight: normal;'><b>Para acceder al préstamo necesitamos que nos envíes la siguiente documentación a <a style='color: #88898d; text-decoration: none;' href='mailto:info@argenpesos.com.ar'>info@argenpesos.com.ar</a>: </b><br />
          - Ultimo recibo de sueldo<br />
          - DNI<br />
          - Movimientos bancarios del último mes de la cuenta sueldo con los saldos parciales. (Podés extraerlos del home banking)<br /><br />
          Cuanto más rápido nos envíes la documentación, más rápido vas a tener tu préstamo.<br /></td></tr>";
          $cuerpo .= "<tr><td>Por cualquier consulta comunicate al 0800-345-2733 o mail a <a style='color: #1da3dd; text-decoration: none;' href='mailto:info@argenpesos.com.ar'>info@argenpesos.com.ar</a><br /><br /></td></tr>";
          $cuerpo .= "<tr><td style='font-size: 13px; color: #88898d; font-weight: normal;'>¡Saludos!<br /><br /><br /></td></tr>";
          $cuerpo .= "</table>";
                    
          $mail->From = "infoargenpesos@gmail.com";
          $mail->FromName = "ArgenPesos";
          $mail->Subject = "Solicitud de Préstamo";
          $mail->AddAddress($mail_admin,"Usuario");
          $mail->Body = $cuerpo;
          $mail->AltBody = "";
          $mail->CharSet = 'UTF-8';
          $mail->Send();

          ?>
          <div class="row" style="max-width: 1100px;">
            <div class="col-sm-5"><img src="imagenes/globo_aprobado.png" alt="" id="globos_solicitud" /></div>
            <div class="col-sm-7 text-left" id="texto_aprobado">
              <span>PARA ACCEDER AL PR&Eacute;STAMO NECESITAMOS QUE NOS ENV&Iacute;ES LA SIGUIENTE DOCUMENTACI&Oacute;N A <a href="mailto:INFO@ARGENPESOS.COM.AR" class="c_amarillo">INFO@ARGENPESOS.COM.AR:</a></span>
              <br /><br />
              - &Uacute;ltimo recibo de sueldo<br />
              - DNI<br />
              - Movimientos bancarios del &uacute;ltimo mes de la cuenta sueldo con los saldos parciales. (Pod&eacute;s extraerlos del home banking)
              <br /><br />
              <span style="color: #f6ec3c !important;">Cuanto m&aacute;s r&aacute;pido nos env&iacute;es la documentaci&oacute;n, m&aacute;s r&aacute;pido vas a tener tu pr&eacute;stamo.</span><br />
              Por cualquier consulta comunicate al 0800-345-2733 o mail a info@argenpesos.com.ar
            </div>
          </div>
  



          <?php
        }else if( ($banco == "nacion") || ($banco == "patagonia" )|| ($banco == "santander" )|| ($banco=="chubut") ){

          $mail_admin = $mail_usuario;

          $mail = new PHPMailer();
          $mail->Host = "localhost";
          $mail->IsHTML(true);
      
          $cuerpo .= "<table style='color: #1da3dd; font-size: 17px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;'>";
          $cuerpo .= "<tr><td><img src='http://legionvps.com/trabajos/argenpesos/imagenes/logo_mail.png' style='width: 100%; max-width: 240px;' /></td></tr>";
          $cuerpo .= "<tr><td style='text-transform:uppercase;'><br />¡ESTIMADO/A $nombre $apellido TU CRÉDITO HA SIDO PREAPROBADO!<br /><br /></td></tr>";
          $cuerpo .= "<tr><td style='font-size: 13px; color: #88898d; font-weight: normal;'><b>Para acceder al préstamo necesitamos que nos envíes la siguiente documentación a <a style='color: #88898d; text-decoration: none;' href='mailto:info@argenpesos.com.ar'>info@argenpesos.com.ar</a>: </b><br />
          - Ultimo recibo de sueldo<br />
          - DNI<br />
          - Movimientos bancarios del último mes de la cuenta sueldo con los saldos parciales. (Podés extraerlos del home banking)<br /><br />
          Cuanto más rápido nos envíes la documentación, más rápido vas a tener tu préstamo.<br /></td></tr>";
          $cuerpo .= "<tr><td>Por cualquier consulta comunicate al 0800-345-2733 o mail a <a style='color: #1da3dd; text-decoration: none;' href='mailto:info@argenpesos.com.ar'>info@argenpesos.com.ar</a><br /><br /></td></tr>";
          $cuerpo .= "<tr><td style='font-size: 13px; color: #88898d; font-weight: normal;'>¡Saludos!<br /><br /><br /></td></tr>";
          $cuerpo .= "</table>";
                    
          $mail->From = "infoargenpesos@gmail.com";
          $mail->FromName = "ArgenPesos";
          $mail->Subject = "Solicitud de Préstamo";
          $mail->AddAddress($mail_admin,"Usuario");
          $mail->Body = $cuerpo;
          $mail->AltBody = "";
          $mail->CharSet = 'UTF-8';
          $mail->Send();






     


        ?>
           <div class="row" style="max-width: 1100px;">
            <div class="col-sm-5"><img src="imagenes/globo_aprobado.png" alt="" id="globos_solicitud" /></div>
            <div class="col-sm-7 text-left" id="texto_aprobado">
              <span>PARA ACCEDER AL PR&Eacute;STAMO NECESITAMOS QUE NOS ENV&Iacute;ES LA SIGUIENTE DOCUMENTACI&Oacute;N A <a href="mailto:INFO@ARGENPESOS.COM.AR" class="c_amarillo">INFO@ARGENPESOS.COM.AR:</a></span>
              <br /><br />
              - &Uacute;ltimo recibo de sueldo<br />
              - DNI<br />
              - Movimientos bancarios del &uacute;ltimo mes de la cuenta sueldo con los saldos parciales. (Pod&eacute;s extraerlos del home banking)
              <br /><br />
              <span style="color: #f6ec3c !important;">Cuanto m&aacute;s r&aacute;pido nos env&iacute;es la documentaci&oacute;n, m&aacute;s r&aacute;pido vas a tener tu pr&eacute;stamo.</span><br />
              Por cualquier consulta comunicate al 0800-345-2733 o mail a info@argenpesos.com.ar
            </div>
          </div>
        
        <?php
        }else 
        {
                $mail_admin = $mail_usuario;

          $mail = new PHPMailer();
          $mail->Host = "localhost";
          $mail->IsHTML(true);
      
          $cuerpo .= "<table style='color: #1da3dd; font-size: 17px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;'>";
          $cuerpo .= "<tr><td><img src='http://legionvps.com/trabajos/argenpesos/imagenes/logo_mail.png' style='width: 100%; max-width: 240px;' /></td></tr>";
          $cuerpo .= "<tr><td><br />LAMENTAMOS INFORMARTE QUE POR EL MOMENTO NO TENEMOS UN PRÉSTAMO PARA VOS<br /><br /></td></tr>";
          $cuerpo .= "<tr><td style='font-size: 13px; color: #88898d; font-weight: normal;'>¡Saludos!<br /><br /><br /></td></tr>";
          $cuerpo .= "</table>";
                    
          $mail->From = "infoargenpesos@gmail.com";
          $mail->FromName = "ArgenPesos";
          $mail->Subject = "Solicitud de Préstamo";
          $mail->AddAddress($mail_admin,"Usuario");
          $mail->Body = $cuerpo;
          $mail->AltBody = "";
          $mail->CharSet = 'UTF-8';
          $mail->Send();

          ?>
          <img src="imagenes/globo_no.png" alt="" id="globos_solicitud" />
          <?php
          }
        }//if principal
          ?>
    
      
    </div>

    <div class="clearfix"></div>
  </div>

  </body>
</html>

  <script src='js/jquery.min.js'></script>
  <script src='js/jquery.inputmask.bundle.min.js'></script>
  <script src="js/slider.js"></script>
  <script src="js/bootstrap.min.js"></script>