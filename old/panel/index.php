<?php
	$_POST = evita_sqlinjection($_POST);
	$_GET = evita_sqlinjection($_GET);
	$_REQUEST = evita_sqlinjection($_REQUEST);
	$_SERVER = evita_sqlinjection($_SERVER);
	$_COOKIE = evita_sqlinjection($_COOKIE);

	function evita_sqlinjection($var)
	{
		if (!is_array($var))
		return addslashes($var);

		$new_var = array();
		foreach ($var as $k => $v)
		$new_var[addslashes($k)] = evita_sqlinjection($v);

		return $new_var;
	}
	$error2=$_GET[error2];
	
	include("validacion.php");

	$__SECCIONES = array(
		"home"							=> "Home",

		"agregar_noticia"				=> "Agregar noticia",
		"editar_noticia"				=> "Editar noticia",
		"listado_noticias"				=> "Listado de noticias",
	);

	if(!$__SECCIONES[$_GET['s']])
	{
		$__SEC = "home";
	}
	else
	{
		$__SEC = $_GET['s'];
	}

	?>
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
	<script type="text/javascript" src="../js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#<?php echo $__SEC; ?> > img').attr({'src' : 'imagenes/menu/<?php echo $__SEC; ?>_m.png', 'rel' : 'active'});
					
			$("#menu > a").mouseover(function() {
				$('img', this).attr('src', 'imagenes/menu/'+$(this).attr('id')+'_m.png');
			}).mouseout(function(){
				if($('img', this).attr('rel') != 'active')
				{
					$('img', this).attr('src', 'imagenes/menu/'+$(this).attr('id')+'.png');
				}
			});
		});
	</script>

	
</head>
<body>
	<div id="logo"><img src="../imagenes/logo.png" alt="" /></div>
	<br />
	<div id="contenedor_web">
		<?php  @require_once("secciones/$__SEC.php"); ?>
		<div id="logout"><a href="secciones/salir.php" onfocus = "this.blur()"><img border="0px" src="imagenes/salir.png"></a></div>
		<div class="clear"></div>
	</div>
</body>
</html>
