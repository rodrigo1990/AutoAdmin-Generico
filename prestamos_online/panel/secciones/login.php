<?php
	$error2=$_GET[error2];
	if($_POST['submit'])
	{
		$usu_login = $_POST['usu_login'];
		$usu_clave = $_POST['usu_clave'];
		include("../conexion.php");
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
			header("location:../index.php");
		}
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es"> 
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Language" content="es-cl">
	<title>.::COOK MASTERS::.</title>
	<link rel="stylesheet" media="screen" type="text/css" href="../css/style.css"/>
	<!--[if IE 7]>
	<link id="stylesheet" type="text/css" href="css/ie.css" rel="stylesheet" />  
	<![endif]-->
</head>
	<body>
		<div class="agarraTodo">
			<div class="head">
            	<div class="logo">
                	<img src="../../images/logo.png" alt="Cook Masters"  />
                </div>
			</div> 
			<?php
			/*$error = $_GET['error'];
			if($error == 1)
			{
			?>
			<div style="width:350px; height:25px; padding-top:5px; color:#fff; background-color:#faa; border:1px solid #f00; text-align:center;">
				Nombre de usuario y/o contraseña incorrectos
			</div>
			<?php
			}*/
			if($error==1 || $error2==1)
			{
		?>
				<div style="width:350px; height:45px; padding-top:5px; color:#fff; background-color:#faa; border:1px solid #f00; text-align:center; margin:auto; margin-bottom: 10px;">
					Nombre de usuario y/o contraseña incorrectos
				</div>
			<?php 
				}
			?>
			<div>
				<form action="login.php" method="post">
				<table align="center">
					<tr>
						<td class="text"><b>Usuario:</b></td>
						<td><input type="text" name="usu_login"/></td>
					</tr>
					<tr>
						<td><b>Contraseña:</b></td> 
						<td><input type="password" name="usu_clave"/></td>
					</tr>
					<tr>
						<td align="center" colspan="2"><input class="boton" type="submit" name="submit" value="Ingresar" /></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
	</body>
</html>
