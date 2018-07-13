<?php
error_reporting(0);
/*$url_actual = basename($_SERVER['SCRIPT_NAME']);
$url_actual = str_replace('.php', '', $url_actual);
$base_url = "https://www.argenpesos.com.ar/";
//$base_url = "http://localhost/legion/argenpesos2017/";

if($_SERVER["HTTPS"] != "on")
{
  header("Location: https://www.argenpesos.com.ar/"); 
  exit();
}*/
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARGENPESOS</title>
    <meta name="Keywords" content="">
    <meta name="Description" content=""/>

    <link rel="icon" type="image/png" href="imagenes/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="imagenes/favicon-16x16.png" sizes="16x16" />

    <!-- CSS -->
    <link href="<?php echo $base_url ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>css/styles.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>css/queries.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url ?>css/font-awesome/css/font-awesome.min.css">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|Oswald:300,400,500,600,700|Ubuntu:300,400,500,700" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="https://s3.amazonaws.com/menumaker/menumaker.min.js" type="text/javascript"></script>
    <script src="<?php echo $base_url ?>js/bootstrap.min.js"></script>

    <script src="<?php echo $base_url ?>js/menu.js"></script>
    <link rel="stylesheet" href="<?php echo $base_url ?>css/menu.css">
  </head>
  
<body>
  <header>
    <div class="row">
      <div class="col-sm-3 col-xs-12">
        <a href="<?php echo $base_url ?>index"><img src="<?php echo $base_url ?>imagenes/logo.png" alt="ARGENPESOS" id="logo" /></a>
      </div>
      <div class="col-sm-9">
        <div id="redes_header">
          <a href="https://www.facebook.com/argenpesos" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          <a href="https://twitter.com/@argenpesos" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
        </div>

        <div id="cssmenu">
          <ul>
             <li <?php if($url_actual == "index") { ?>class="current"<?php } ?>><a href="<?php echo $base_url ?>index.php">HOME</a></li>
             <li <?php if($url_actual == "institucional") { ?>class="current"<?php } ?>><a href="<?php echo $base_url ?>institucional.php">INSTITUCIONAL</a></li>
             <li <?php if($url_actual == "como_funciona") { ?>class="current"<?php } ?>><a href="<?php echo $base_url ?>como_funciona.php">¿CÓMO FUNCIONA?</a></li>
             <li <?php if($url_actual == "como_funciona") { ?>class="current"<?php } ?>><a href="<?php echo $base_url ?>club_argenpesos.php">CLUB ARGENPESOS</a></li>
             <li <?php if($url_actual == "preguntas_frecuentes") { ?>class="current"<?php } ?>><a href="<?php echo $base_url ?>preguntas_frecuentes.php">PREGUNTAS FRECUENTES</a></li>
             <li <?php if($url_actual == "sucursales") { ?>class="current"<?php } ?>><a href="<?php echo $base_url ?>sucursales.php">SUCURSALES</a></li>
             <li <?php if($url_actual == "sumate") { ?>class="current"<?php } ?>><a href="<?php echo $base_url ?>sumate.php">SUMATE</a></li>
             <li <?php if($url_actual == "sumate") { ?>class="current"<?php } ?>><a href="<?php echo $base_url ?>responsabilidad_social.php">RESP. SOCIAL</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <div id="franja_header">
    <div class="row">
      <div class="col-sm-6 text_center_mobile" id="izquierda_header">
        <div id="click2call">
        <a id="click2call_callbtn" style="color:#fff000; font-size: 24px; font-weight: 700;"><img src="imagenes/tel_header.png" alt="" /> 0800 345 2733</a>
         
        <a id="click2call_hupbtn" style="color:#fff000; font-size: 24px; font-weight: 700;"><img src="imagenes/tel_header_colgar.png" alt="" /> 0800 345 2733</a>
        
        <div id="click2call_msgdiv" style="display: none;"></div>
         
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
      </div>
      <div class="col-sm-6 text-right text_center_mobile" id="derecha_header">
          <a href="solicitarprestamo/" class="btn btn-primary" style="	background: #fff000;
	color: #eb5838;
	font-family: 'Ubuntu', sans-serif;
	border: 0px;
	font-weight: 600;
	letter-spacing: 0px;
	border-radius: 8px;
	font-size: 16px;">SOLICITAR PRÉSTAMO</a>
        <img src="imagenes/campana_header.png" alt="" /> <a href="consulta_cuenta">Consulta tu cuenta</a>
      </div>
    </div>
  </div>