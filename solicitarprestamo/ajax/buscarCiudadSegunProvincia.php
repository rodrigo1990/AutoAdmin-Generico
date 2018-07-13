<?php 
require_once("../clases/BaseDatos.php");

$provincia=$_POST['provincia'];

$bd=new BaseDatos();

	
$bd->buscarCiudadSegunProvincia($provincia);


 ?>