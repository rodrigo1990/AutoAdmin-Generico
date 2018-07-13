<?php
	include("../validacion.php");
	//if($_POST['enviado'] == "si")
	if($_POST['submit'])
	{
		$contrasenia = $_POST['contrasenia'];
			
		include("../conexion.php");
		$alta = "update usuarios set usu_clave='$contrasenia'";
		mysql_query($alta);
		mysql_close();
		}
		else if ($_POST['submit'])
		{
			echo("Faltan ingresar datos.");
		}
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Language" content="es-cl" />
	<title>cuatro elementos</title>

	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="content-language" content="es" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="window-target" content="_top" />

	<meta name="description" content="Anima: Pilates & SPA" />
	<meta name="keywords" content="pilates, anima, spa, centro de belleza, san isidro" />

	<link rel="stylesheet" media="screen" type="text/css" href="../css/general.css" />
</head>
<body>
	<div id="cabecera">
		<a href="../../index.php"><img src="../../imagenes/cabecera.png" alt="cabecera" style="border:0;"/></a>
	</div>
	<div id="cuerpo_index_novedades">
		<div style="float: right;"><a href="../index.php"><img src="../images/volver.jpg" style="border:0;"/></a></div>
		<?php
			include ("../conexion.php");
				
			$consulta_producto = "Select * from usuarios";
			$resultado_producto = mysql_query($consulta_producto);
			$fila_producto = mysql_fetch_array($resultado_producto);
		?>
		<form action="modificar_contrasenia.php?producto=<?php echo $fila_producto['id']; ?>" method="post" enctype="multipart/form-data" name=f1>
				<table border="0" style="color:#666; font-family: Arial; font-size: 13px; padding: 15px; width: 600px;">
					<tr>
						<td align="right"><b>Contraseña:</b></td>
						<td><input type="text" name="contrasenia" style="width:200px;" value="<?php echo($fila_producto[usu_clave]); ?>"/></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input class="boton_enviar" type="submit" name="submit" value="Modificar Contraseña" /></td>
						<td><input type="hidden" name="enviado" value="si" /></td>
						<input type="hidden" name="MAX_FILE_SIZE" value="100000">
					</tr>
				</table>
		</form>
	</div>	
</body>
</html>
