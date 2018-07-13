<?php
	include("../conexion.php");
	$resultado=mysql_query($consulta);
	$id = $_GET['id'];
	if (!empty($_FILES))
	{
		@require_once("../secciones/imagen.php");
		$imagen = new imagen();
		$imagen->abrir($_FILES['Filedata']['tmp_name']);
		$directorio = "../imagenes";
		$info = pathinfo($_FILES['foto']['name']);
		$nombre_imagen = date("H_i_s").basename($_FILES['foto']['name'],'.'.$info['extension']);
		$extension = $imagen->extension;
		$imagen->guardar($directorio, $nombre_imagen, 150, 130, false);
		$nombre_imagen_consulta = $nombre_imagen.".".$extension;
		
		$editar="UPDATE productos set foto='$nombre_imagen_consulta' WHERE id = $id;";
		mysql_query($editar);
	}
?>