<div id="cuerpo_index_panel">
	<div class="titulos_panel">Formularios</div>
	<h3>Enero 2014</h3>
	<table id="tabla_formularios" style="width: 960px;">
		<tr style="background: #ccc; text-align: center; font-size: 12px;">
			<td>Nombre y Apellido</td>
			<td>E-mail</td>
			<td>Tel&eacute;fono</td>
			<td>Consulta</td>
			<td>Fecha</td>
		</tr>
		<?php
		include ("conexion.php");
		$consulta = "SELECT * FROM formularios WHERE mes = '1' and anio='2014' order by id DESC";
		$resultado = mysql_query($consulta);
		$cant = mysql_num_rows($resultado);
				
		while($fila = mysql_fetch_array($resultado))
		{
			?>
				<tr>
					<td><?php echo($fila['nombre']); ?></td>
					<td><?php echo($fila['mail']); ?></td>
					<td><?php echo($fila['telefono']); ?></td>
					<td><?php echo($fila['consulta']); ?></td>
					<td><?php echo($fila['dia']); ?>/<?php echo($fila['mes']); ?>/<?php echo($fila['anio']); ?></td>
				</tr>
			<?php
		}
		mysql_close();
		?>
	</table>
	<br />
	<div class="clear"></div>
	<br />
	<h3>Diciembre 2013</h3>
	<table id="tabla_formularios" style="width: 960px;">
		<tr style="background: #ccc; text-align: center; font-size: 12px;">
			<td>Nombre y Apellido</td>
			<td>E-mail</td>
			<td>Tel&eacute;fono</td>
			<td>Consulta</td>
			<td>Fecha</td>
		</tr>
		<?php
		include ("conexion.php");
		$consulta = "SELECT * FROM formularios WHERE mes = '12' and anio='2013' order by id DESC";
		$resultado = mysql_query($consulta);
		$cant = mysql_num_rows($resultado);
				
		while($fila = mysql_fetch_array($resultado))
		{
			?>
				<tr>
					<td><?php echo($fila['nombre']); ?></td>
					<td><?php echo($fila['mail']); ?></td>
					<td><?php echo($fila['telefono']); ?></td>
					<td><?php echo($fila['consulta']); ?></td>
					<td><?php echo($fila['dia']); ?>/<?php echo($fila['mes']); ?>/<?php echo($fila['anio']); ?></td>
				</tr>
			<?php
		}
		mysql_close();
		?>
	</table>
	<br />
	<div class="clear"></div>
	<br />
	<h3>Noviembre 2013</h3>
	<table id="tabla_formularios" style="width: 960px;">
		<tr style="background: #ccc; text-align: center; font-size: 12px;">
			<td>Nombre y Apellido</td>
			<td>E-mail</td>
			<td>Tel&eacute;fono</td>
			<td>Consulta</td>
			<td>Fecha</td>
		</tr>
		<?php
		include ("conexion.php");
		$consulta = "SELECT * FROM formularios WHERE mes = '11' and anio='2013' order by id DESC";
		$resultado = mysql_query($consulta);
		$cant = mysql_num_rows($resultado);
				
		while($fila = mysql_fetch_array($resultado))
		{
			?>
				<tr>
					<td><?php echo($fila['nombre']); ?></td>
					<td><?php echo($fila['mail']); ?></td>
					<td><?php echo($fila['telefono']); ?></td>
					<td><?php echo($fila['consulta']); ?></td>
					<td><?php echo($fila['dia']); ?>/<?php echo($fila['mes']); ?>/<?php echo($fila['anio']); ?></td>
				</tr>
			<?php
		}
		mysql_close();
		?>
	</table>
	<div class="clear"></div>
	<br />
	<h3>Octubre 2013</h3>
	<table id="tabla_formularios" style="width: 960px;" >
		<tr style="background: #ccc; text-align: center; font-size: 12px;">
			<td>Nombre y Apellido</td>
			<td>E-mail</td>
			<td>Tel&eacute;fono</td>
			<td>Consulta</td>
			<td>Fecha</td>
		</tr>
		<?php
		include ("conexion.php");
		$consulta = "SELECT * FROM formularios WHERE mes = '10' and anio='2013' order by id DESC";
		$resultado = mysql_query($consulta);
		$cant = mysql_num_rows($resultado);
				
		while($fila = mysql_fetch_array($resultado))
		{
			?>
				<tr>
					<td><?php echo($fila['nombre']); ?></td>
					<td><?php echo($fila['mail']); ?></td>
					<td><?php echo($fila['telefono']); ?></td>
					<td><?php echo($fila['consulta']); ?></td>
					<td><?php echo($fila['dia']); ?>/<?php echo($fila['mes']); ?>/<?php echo($fila['anio']); ?></td>
				</tr>
			<?php
		}
		mysql_close();
		?>
	</table>
</div>