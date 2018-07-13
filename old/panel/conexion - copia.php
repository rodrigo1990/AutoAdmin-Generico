<?php
$server="192.168.0.192";
$usuariodb="argenpesos_us";
$clave_db="argenpesos2013";
$base="argenpesos_bd";

$id_con=mysql_connect($server, $usuariodb, $clave_db);
mysql_select_db($base, $id_con);

?>