<?php
session_start(); 
require_once("../../clases/Usuario.php");

$usuario=new Usuario();

$mensaje=$usuario->validarUsuario($_POST['email'],md5($_POST['pass']));



if($mensaje==TRUE){
$_SESSION['pass']=md5($_POST['pass']);
$_SESSION['email']=$_POST['email'];
echo "TRUE";
}else{
echo "FALSE";
}




 ?>