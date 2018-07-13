<?php 
require("inc/verificarSession.php");
require_once("../clases/Novedad.php");

$nov = new Novedad();

$nov->eliminarNovedad($_GET['ID']);

header("Location:mis_novedades.php");

 ?>