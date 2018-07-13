<?php 
require_once("BaseDatos.php");
class Usuario{

	public $baseDatos;

	public function _construct(){

		


	}


	public function validarUsuario($email,$contrasenia){

		$this->baseDatos = new BaseDatos();

		$stmt=$this->baseDatos->mysqli->prepare("SELECT usuario,pass
									  FROM admin
									  WHERE usuario=(?)");

		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		if($fila["usuario"]==$email AND $fila['pass']==$contrasenia){
			return TRUE;
			//header("Location: home.php");

		}else{
			return FALSE;
		}

		$stmt->close();

	}//function



	







}//class


 ?>