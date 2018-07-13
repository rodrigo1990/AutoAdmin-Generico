<?php
$server="localhost";
$usuariodb="argenpes_us";
$clave_db="argenpesosBD2017";
$base="argenpes_bd";

$id_con=mysql_connect($server, $usuariodb, $clave_db);
mysql_select_db($base, $id_con);

?>