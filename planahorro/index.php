<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>
<?php
  error_reporting(0);

	if (isset($_POST["enviarcontacto"])) {
		$nombrecontacto = $_POST['nombrecontacto'];
		$telefonocontacto = $_POST['telefonocontacto'];
		$emailcontacto = $_POST['emailcontacto'];
		$grupoyordencontacto = $_POST['grupoyordencontacto'];
		$mensajecontacto = $_POST['mensajecontacto'];
		$from = $_POST["nombrecontacto"]; 
		$to = 'dmd.nnn@gmail.com'; 
		$subject = 'Contacto Web Argenpesos';
		
		$body ="De: $nombrecontacto\n Tel&eacute;fono: $telefonocontacto\n E-Mail: $emailcontacto\n Grupo y &oacute;rden: $grupoyordencontacto\n Mensaje:\n $mensajecontacto";

		if (!$_POST['nombrecontacto']) {
			$errNombreContacto= 'Por favor ingrese su nombre';
		}
		
		if (!$_POST['emailcontacto'] || !filter_var($_POST['emailcontacto'], FILTER_VALIDATE_EMAIL)) {
			$errEmailContacto = 'Por favor ingrese su email';
		}
		
		if (!$_POST['mensajecontacto']) {
			$errMensajeContacto = 'Por favor ingrese su mensaje';
		}


if (!$errNombreContacto && !$errEmailContacto && !$errMensajeContacto) {
	if (mail ($to, $subject, $body, $from)) {
		$result='<div class="alert alert-success">Su mensaje se ha enviado correctamente.</div>';
	} else {
		$result='<div class="alert alert-danger">Lo sentimos su mensaje no ha sido enviado, por favor intete otra vez.</div>';
	}
}
	}


	if (isset($_POST["enviar"])) {
		$nombre = $_POST['nombre'];
		$email = $_POST['email'];
		$localidad = $_POST['localidad'];
		$telefono = $_POST['telefono'];
		$radiosb1 = $_POST['radiosb1'];
		$comentarios = $_POST['comentarios'];
		$from = $_POST["nombre"]; 
		$to = 'dmd.nnn@gmail.com'; 
		$subject = 'Contacto Web A Argenpesos';
		
		$body ="De: $nombre\n E-Mail: $email\n Localidad: $localidad\n Tel&eacute;fono: $telefono\n Radios: $radiosb1\n Comentarios:\n $comentarios";

		if (!$_POST['nombre']) {
			$errNombre= 'Por favor ingrese su nombre';
		}
		
		if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errEmail = 'Por favor ingrese su email';
		}
		
		if (!$_POST['comentarios']) {
			$errComentarios = 'Por favor ingrese su mensaje';
		}

if (!$errNombre && !$errEmail && !$errComentarios) {
	if (mail ($to, $subject, $body, $from)) {
		$result='<div class="alert alert-success">Su mensaje se ha enviado correctamente.</div>';
	} else {
		$result='<div class="alert alert-danger">Lo sentimos su mensaje no ha sido enviado, por favor intete otra vez.</div>';
	}
}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>ArgenPe$os</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/custom.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700,300' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Dosis:400,500,600,700' rel='stylesheet' type='text/css'>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
       <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
       <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
  <div class="container-fluid topnav"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      <a class="navbar-brand topnav" href="#inicio"><img src="img/logo_argenpesos.png" height="50px" ></a></div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="padding-right: 20px;">
      <div class="redes-sociales"><a href="https://www.facebook.com/argenpesos/" target="_blank"><img src="img/facebook.png"></a><a href="https://twitter.com/argenpesos" target="_blank"><img src="img/twitter.png"></a></div>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#quienes-somos">Qui&eacute;nes Somos</a></li>
        <li><a href="#como-funciona">&iquest;C&oacute;mo funciona?</a></li>
        <li><a href="faq.php">Preguntas Frecuentes</a></li>
        <li><a href="#contacto">Contacto</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
</nav>
<a name="inicio"></a>
<div class="intro-header">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="intro-message">
          <h1 class="text-left">&iquest;NECESIT&Aacute;S EFECTIVO?</h1>
          <h2 class="text-left">VEND&Eacute; HOY TU PLAN DE AHORRO</h2>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-banner" id="form_home" style="padding: 0px 30px 15px 30px;">
          <h3>&iexcl;CONTACTANOS!</h3>
          <form class="form-horizontal" role="form" method="post" action="index.php">
            <div class="form-group">
              <div class="col-md-12">
                <input id="nombre" name="nombre" placeholder="Nombre y Apellido" class="form-control input-md" type="text">
                <?php echo "<p class='text-danger'>$errNombre</p>";?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <input id="email" name="email" placeholder="Email" class="form-control input-md" type="text">
                <?php echo "<p class='text-danger'>$errEmail</p>";?>
              </div>
            </div>
            <div class="form-group" style="margin-bottom: 9px !important;">
              <div class="col-md-12">
                <input id="localidad" name="localidad" placeholder="Localidad, Provincia" class="form-control input-md" type="text">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <input id="telefono" name="telefono" placeholder="Tel&eacute;fono" class="form-control input-md" type="text">
              </div>
            </div>
            <div class="form-group" style="margin-bottom: 9px !important; text-align: left !important;">
              <div class="col-md-12">
                <label class="radio-inline" for="radiosb1-0">
                  <input name="radiosb1" id="radiosb1-0" value="100/100" checked="checked" type="radio">
                  100/100</label>
                <label class="radio-inline" for="radiosb1-1">
                  <input name="radiosb1" id="radiosb1-1" value="70/30" type="radio">
                  70/30</label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <textarea class="form-control" id="comentarios" name="comentarios" placeholder="Comentarios"></textarea>
                <?php echo "<p class='text-danger'>$errComentarios</p>";?>
              </div>
            </div>
            <div class="form-group">
            	<div class="col-sm-12">
                	<?php echo $result; ?>	
				</div>
			</div>
            <div class="form-group">
              <div class="col-md-12 text-right">
                <input id="enviar" name="enviar" type="submit" value="ENVIAR" class="btn btn-primary enviar-banner">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<a name="quienes-somos"></a>
<div class="content-section-a">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="section-heading">&iquest;Qui&eacute;nes somos?</h2>
        <p class="lead text-center">Somos una financiera con diez a&ntilde;os de trayectoria en el mercado de cr&eacute;ditos para el trabajador.<br>
          <br>
          Gracias a nuestros pr&eacute;stamos de hasta $30.000 en efectivo - de aprobaci&oacute;n inmediata y devoluci&oacute;n en cuotas - ya no necesit&aacute;s esperar para renovar la casa, arreglar el auto, hacer un viaje en familia o afrontar gastos extraordinarios.<br>
          <br>
          Con Argenpesos cont&aacute;s con ese dinero extra que siempre te viene bien y que te prestamos a cambio de una sola cosa: la confianza.<br>
          Confiamos en tu trabajo, en tus ideas y en tu vocaci&oacute;n de salir adelante.<br>
          <br>
          &iquest;Necesit&aacute;s efectivo? Acercate: estamos en el coraz&oacute;n tu barrio, a la vuelta de casa, esper&aacute;ndote cada d&iacute;a para escuchar tus inquietudes y ofrecer una soluci&oacute;n a tu medida.<br>
          <br>
          <b>Tenemos un sue&ntilde;o: que puedas cumplir el tuyo.</b></p>
          </div>
      </div>
    </div>
  </div>
</div>
<a name="como-funciona"></a>
<div class="content-section-b">
  <div class="container">
    <div class="row como-funciona">
      <div class="col-md-12">
        <h2 class="section-heading titulos_dosis" style="color:#6d6e70;">Pasos a seguir</h2>
        <p class="lead text-center">Argenpesos compra tu plan de ahorro de forma f&aacute;cil y r&aacute;pida.<br>
          &iexcl;No dudes en consultarnos!</p>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-3">
            <div class="icon-paso1"><img src="img/paso1.png" class="img-responsive center-block"></div>
          </div>
          <div class="col-md-9">
            <div class="paso-titulo">PASO UNO</div>
          </div>
          <div class="col-md-12">
            <div class="paso-separador"></div>
          </div>
        </div>
        <p>&iquest;Pasaste la cuota n&deg;15 de tu plan de ahorro y quer&eacute;s venderlo?<br>
          <br>
          <b>Averigu&aacute; tu grupo y &oacute;rden.</b></p>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-3">
            <div class="icon-paso2"><img src="img/paso2.png" class="img-responsive center-block"></div>
          </div>
          <div class="col-md-9">
            <div class="paso-titulo">PASO DOS</div>
          </div>
          <div class="col-md-12">
            <div class="paso-separador"></div>
          </div>
        </div>
        <p>Necesit&aacute;s <b>tu DNI y la &uacute;tlima cuota</b> de tu plan al d&iacute;a.</p>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-3">
            <div class="icon-paso3"><img src="img/paso3.png" class="img-responsive center-block"></div>
          </div>
          <div class="col-md-9">
            <div class="paso-titulo">PASO TRES</div>
          </div>
          <div class="col-md-12">
            <div class="paso-separador"></div>
          </div>
        </div>
        <p>Comunic&aacute;te por tel&eacute;fono con nosotros <b>para cobrar el efectivo</b>.</p>
      </div>
    </div>
  </div>
</div>
<a  name="contacto"></a>
<div class="content-section-c">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="section-heading">CONTACTO</h2>
        <div class="formulario-contacto">
          <form class="form-horizontal" role="form" method="post" action="index.php#contacto">
            <div class="form-group">
              <div class="col-md-6">
                <input id="nombrecontacto" name="nombrecontacto" placeholder="Nombre" class="form-control input-md" type="text">
                <?php echo "<p class='text-danger'>$errNombreContacto</p>";?>
              </div>
              <div class="col-md-6">
                <input id="telefonocontacto" name="telefonocontacto" placeholder="Tel&eacute;fono" class="form-control input-md" type="text">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6">
                <input id="emailcontacto" name="emailcontacto" placeholder="Email" class="form-control input-md" type="text">
                <?php echo "<p class='text-danger'>$errEmailContacto</p>";?>
              </div>
              <div class="col-md-6">
                <input id="grupoyordencontacto" name="grupoyordencontacto" placeholder="Grupo y Orden" class="form-control input-md" type="text">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <textarea class="form-control" id="mensajecontacto" name="mensajecontacto" placeholder="Mensaje"></textarea>
                <?php echo "<p class='text-danger'>$errMensajeContacto</p>";?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 text-right">
                <input id="enviarcontacto" name="enviarcontacto" type="submit" value="Enviar" class="btn btn-primary enviar-contacto">
              </div>
            </div>
            <div class="form-group">
            	<div class="col-sm-12">
                	<?php echo $result; ?>	
				</div>
			</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery --> 
<script src="js/jquery.js"></script>
<script src="js/effects.js"></script> 

<!-- Bootstrap Core JavaScript --> 
<script src="js/bootstrap.min.js"></script>

</body>
</html>
