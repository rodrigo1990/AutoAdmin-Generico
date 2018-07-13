<?php
$server="localhost";
$usuariodb="argenpes_lus";
$clave_db="argenpesosLD2017";
$base="argenpes_landing";

$id_con=mysql_connect($server, $usuariodb, $clave_db);
mysql_select_db($base, $id_con);

?>