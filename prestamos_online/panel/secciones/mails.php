<?php
	include("../validacion.php");
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

	<meta name="description" content="Estudio Darwin" />
	<meta name="keywords" content="estudio darwin, eventos" />

	<link rel="stylesheet" media="screen" type="text/css" href="../css/general.css" />
	<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
	<script language="javascript">
	$(document).ready(function() 
	{
		$(".botonExcel").click(function(event) 
		{
			$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
			$("#FormularioExportacion").submit();
		});
	});
	</script>
</head>
<body>
	<img src="../imagenes/logo.png" alt="logo" width="210px" height="100px"  />
	<br /><br /><br /><br /><br />
	<div style="width: 900px; background: #fff; border: 1px solid #ccc; height: 570px; margin: 0px auto 0px auto; overflow: auto;">
		<div style="float: right;"><a href="../index.php"><img src="../images/volver.jpg" style="border:0;"/></a></div>
		<table id="Exportar_a_Excel" style="width: 860px; margin-left: 20px; font-size: 13px;"  >
			<tr style="color: #000; background: #ccc;" >
					<td>Fecha</td>
					<td>Prestamo</td>
					<td>Nombre</td>
					<td>DNI</td>
					<td>Tel&eacute;fono</td>
					<td>E-Mail</td>
				</tr>
		<?php
			include ("../conexion.php");
			$consulta = "SELECT id, prestamo, nombre, dni, telefono, email, alta FROM mails ORDER BY id DESC";
			$resultado = mysql_query($consulta);
			$cant = mysql_num_rows($resultado); //Cuento registros
			
			//Muestreo
			while($fila = mysql_fetch_array($resultado))
			{
				?>
				<tr style="color: #000; font-size: 12px;" >
					<td style="border-bottom: 1px solid #ccc;" valign="top" ><?php echo($fila[alta]); ?></td>
					<td style="border-bottom: 1px solid #ccc;" valign="top" ><?php echo($fila[prestamo]); ?></td>
					<td style="border-bottom: 1px solid #ccc;" valign="top" ><?php echo($fila[nombre]); ?></td>
					<td style="border-bottom: 1px solid #ccc;" valign="top" ><?php echo($fila[dni]); ?></td>
					<td style="border-bottom: 1px solid #ccc;" valign="top" ><?php echo($fila[telefono]); ?></td>
					<td style="border-bottom: 1px solid #ccc;" valign="top" ><?php echo($fila[email]); ?></td>
				</tr>
			<?php
			}
			mysql_close();
		?>
	</div>	
	<div style="width: 100px; color: #000000; margin-left: 20px;">
		<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion" class="exportar_excel" >
			<p>Exportar<img src="export_to_excel.gif" class="botonExcel" /></p>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
		</form>
	</div>
</body>
</html>