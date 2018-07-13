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
	
	if($_POST['submit'])
	{
		$usu_login = $_POST['usu_login'];
		$usu_clave = $_POST['usu_clave'];
		include("conexion.php");
		$consulta = "Select usu_nombre from usuarios where usu_login='$usu_login' and usu_clave='$usu_clave' ";
		$resultado = mysql_query($consulta);
		$cant = mysql_num_rows($resultado);
		if($cant != 1)
		{
			//ERROR
			$error=1;
			//rutina de error
			//header("location:form_login.php?error=1");
		}
		else
		{	
			//creamos sesion de usuario
			session_start();
			$_SESSION[login] = "ok";
			header("location:index.php");
		}
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


</head>
<body>
	<div id="logo"><img src="../imagenes/logo.png" alt="" /></div>
	
	<div id="login">
		<form action="login.php" method="post" >
			<table align="center"> 
				<tr>
					<td class="text" style="text-align: right; color: #666;">Usuario:</td>
					<td><input type="text" name="usu_login"/></td>
				</tr>
				<tr>
					<td style="color: #666;">Contraseña:</td> 
					<td><input type="password" name="usu_clave"/></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><input class="boton_forml" style="font-size: 14px;" type="submit" name="submit" value="Ingresar" /></td>
				</tr>
			</table>
		</form>
	</div>

</body>
</html>
