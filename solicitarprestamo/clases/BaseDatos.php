<?php 
class BaseDatos{

	public $base='argenpesos';
	public $servidor='localhost';
	public $conexion;
	public $mysqli;


	public function __construct(){
		
		$this->conexion=mysqli_connect($this->servidor,'root','',$this->base) or die ("No se ha podido establecer conexion con la base de datos");
	

		$this->mysqli=new mysqli($this->servidor, 'root','', $this->base);

		$this->mysqli->set_charset("utf8");
	}


	public function listarProvincias(){

	
		$sql="SELECT id,provincia_nombre
			  FROM provincia
			  WHERE id!=0";

		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){

			echo "<option value='".$fila['provincia_nombre']."'>".$fila['provincia_nombre']."</option>";
		
			
		}
	}//function

	public function buscarCiudadSegunProvincia($provincia){

		if($provincia!='0'){

			//$likeVar = "%" . $provincia . "%";

			$stmt=$this->mysqli->prepare("SELECT CIU.id, CIU.ciudad_nombre	
			  FROM ciudad CIU JOIN provincia PRO ON CIU.provincia_id=PRO.id  
			  WHERE PRO.provincia_nombre = (?) AND CIU.id!=0
			  ORDER BY CIU.ciudad_nombre ASC");

			$stmt->bind_param("s",$provincia);

			$stmt->execute();

			

			$resultado=$stmt->get_result();

			while($fila=$resultado->fetch_assoc()){
				echo "<option value='".$fila['ciudad_nombre']."'>".$fila['ciudad_nombre']."</option>";
			}


			$stmt->close();
		}else{
			echo "<option value='0'>Ingrese una localidad</option>";

		}
	}

}//class
 ?>