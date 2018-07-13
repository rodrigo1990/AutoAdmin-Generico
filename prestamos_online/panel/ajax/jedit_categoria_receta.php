<?php
	include("../conexion.php");
	$id = $_POST['id'];
	$campo = $_POST['campo'];
	$valor = $_POST['valor'];
	$editar="UPDATE categorias_recetas SET $campo = '$valor'WHERE id = $id;";
	if(mysql_query($editar))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>