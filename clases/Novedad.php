<?php 
require_once("BaseDatos.php");
class Novedad{

	public $baseDatos;

	public function _construct(){

		


	}

	public function listarNovedadesUser(){
		$bd = new BaseDatos();
		$i = 0;//contador de grupos
		//try{
			$sql="SELECT *
				 FROM novedad";



			$consulta=mysqli_query($bd->conexion,$sql);
			
		while($fila=mysqli_fetch_assoc($consulta)){
			$i++;
		  echo '<div class="row">
				    <div class="container">
				      <div class="col-lg-6 col-sm-6">
				        <h2 class="titulos ">'.$fila['titulo'].'</h2>
				        <h3 class="subtitulos"><i>'.$fila['subtitulo'].'</i></h3>
				        <br>
				        <p>'.$fila['descripcion'].'</p>
				      </div>
				        <div class="col-lg-6 col-sm-6 img-section">
				          <div class="overlay">

				            <a class="content" data-fancybox="gallery'.$i.'" href="imagenes/club_argenpesos/'.$fila["img1"].'" data-caption="'.$fila["descripcion"].'" >
				              <div class="link-cont text-center">
				                <a class="lightbox a-button"><i class="fa fa-search"></i></a>
				              </div>
				              <h5 class="text-center">Ver Mas</h5>
				            </a>

				          </div>
				          <div class="img-portada" style="background-image:url(imagenes/club_argenpesos/'.$fila["img1"].');"></div>
				          
				        </div>
				    </div>';

		if($fila["img2"]!=""){

			echo "<a  style='display:none'data-fancybox='gallery".$i."' href='imagenes/club_argenpesos//".$fila['img2']."' data-caption='".$fila['descripcion']."'>
								</a>";

		}

		if($fila["img3"]!=""){
			echo "<a  style='display:none'data-fancybox='gallery".$i."' href='imagenes/club_argenpesos/".$fila['img3']."' data-caption='".$fila['descripcion']."' >
								</a>";
		}

		if($fila["img4"]!=""){
			echo "<a  style='display:none'data-fancybox='gallery".$i."' href='imagenes/club_argenpesos/".$fila['img4']."' data-caption='".$fila['descripcion']."'>
								</a>";
		}

		if($fila["img5"]!=""){
			echo "<a  style='display:none'data-fancybox='gallery".$i."' href='imagenes/club_argenpesos/".$fila['img5']."' data-caption='".$fila['descripcion']."'>
								</a>";
		}

		if($fila["img6"]!=""){
			echo "<a  style='display:none'data-fancybox='gallery".$i."' href='imagenes/club_argenpesos/".$fila['img6']."' data-caption='".$fila['descripcion']."'>
								</a>";
		}

		if($fila["img7"]!=""){
			echo "<a  style='display:none'data-fancybox='gallery".$i."' href='imagenes/club_argenpesos/".$fila['img7']."' data-caption='".$fila['descripcion']."'>
								</a>";
		}

		if($fila["img8"]!=""){
			echo "<a  style='display:none'data-fancybox='gallery".$i."' href='imagenes/club_argenpesos/".$fila['img8']."' data-caption='".$fila['descripcion']."'>
								</a>";
		}

		if($fila["img9"]!=""){
			echo "<a  style='display:none'data-fancybox='gallery".$i."' href='imagenes/club_argenpesos/".$fila['img9']."' data-caption='".$fila['descripcion']."'>
								</a>";
		}

		if($fila["img10"]!=""){
			echo "<a  style='display:none'data-fancybox='gallery".$i."' href='imagenes/club_argenpesos/".$fila['img10']."' data-caption='".$fila['descripcion']."'>
								</a>";
		}


		echo "</div>";
            
		}//while
		
	}



	public function insertarNovedad($titulo,$subtitulo,$descripcion,$imagen1,$imagen2,$imagen3,$imagen4,$imagen5,
									$imagen6,$imagen7,$imagen8,$imagen9,$imagen10){

		$bd  = new BaseDatos();
		$extension="";

		try{
			//Renombrar archivos/campos
			if($imagen1 != ""){

				$extension=pathinfo($imagen1,PATHINFO_EXTENSION);

				$imagen1=rand(100000000,999999999).".".$extension;

			}else{
				$imagen1="";
			}

			if($imagen2 != ""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen2,PATHINFO_EXTENSION);

				$imagen2=rand(100000000,999999999).".".$extension;
			}else{
				$imagen2 = "";
			}

			if($imagen3 != ""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen3,PATHINFO_EXTENSION);

				$imagen3=rand(100000000,999999999).".".$extension;
			}else{
				$imagen3="";	
			}

			if($imagen4 !=""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen4,PATHINFO_EXTENSION);

				$imagen4=rand(100000000,999999999).".".$extension;
			}else{
				$imagen4="";
			}

			if($imagen5!=""){
			//Renombrar archivos/campos
				$extension=pathinfo($imagen5,PATHINFO_EXTENSION);

				$imagen5=rand(100000000,999999999).".".$extension;
			}else{
				$imagen5="";
			}

			if($imagen6 != ""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen6,PATHINFO_EXTENSION);

				$imagen6=rand(100000000,999999999).".".$extension;
			}else{
				$imagen6 = "";
			}

			if($imagen7 != ""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen7,PATHINFO_EXTENSION);

				$imagen7=rand(100000000,999999999).".".$extension;
			}else{
				$imagen7="";
			}

			if($imagen8!=""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen8,PATHINFO_EXTENSION);

				$imagen8=rand(100000000,999999999).".".$extension;
			}else{
				$imagen8="";
			}

			if($imagen9!=""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen9,PATHINFO_EXTENSION);

				$imagen9=rand(100000000,999999999).".".$extension;
			}else{
				$imagen9="";
			}

			if($imagen10!=""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen10,PATHINFO_EXTENSION);

				$imagen10=rand(100000000,999999999).".".$extension;

			}else{
				$imagen10 = "";
			}
			//INSERCION EN BD
			$stmt=$bd->mysqli->prepare("INSERT INTO novedad(titulo,subtitulo,descripcion,img1,img2,img3,img4,img5,img6,img7,img8,img9,img10)
		  		  						VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

			$stmt->bind_param("sssssssssssss",$titulo,$subtitulo,$descripcion,$imagen1,$imagen2,$imagen3,$imagen4,$imagen5,$imagen6,$imagen7,$imagen8,$imagen9,$imagen10);
			$stmt->execute();

			echo "<h1 class='white-text'>El item ha <br> sido subido correctamente</h1>";


			try{

				//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen1;

				move_uploaded_file($_FILES['imagen1']['tmp_name'],$target_path);

								//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen2;

				move_uploaded_file($_FILES['imagen2']['tmp_name'],$target_path);


								//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen3;

				move_uploaded_file($_FILES['imagen3']['tmp_name'],$target_path);


								//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen4;

				move_uploaded_file($_FILES['imagen4']['tmp_name'],$target_path);

								//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen5;

				move_uploaded_file($_FILES['imagen5']['tmp_name'],$target_path);

								//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen6;

				move_uploaded_file($_FILES['imagen6']['tmp_name'],$target_path);

								//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen7;

				move_uploaded_file($_FILES['imagen7']['tmp_name'],$target_path);

								//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen8;

				move_uploaded_file($_FILES['imagen8']['tmp_name'],$target_path);

								//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen9;

				move_uploaded_file($_FILES['imagen9']['tmp_name'],$target_path);

								//CARGA DE IMAGENES EN CARPETA
		
				//carga imagenes Big
				$target_path="../imagenes/club_argenpesos/";
				$target_path=$target_path.$imagen10;

				move_uploaded_file($_FILES['imagen10']['tmp_name'],$target_path);
			}catch(Exception $e){

				echo "<h1 class='white-text'>¡Ups! Ha ocurrido un error mientras copiabamos los archivos a su carpeta : ",$e->getMessage(),"</h1>";
			
			}


			

		}catch(Exception $e){


			echo "<h1 class='white-text'>¡Ups! Ha ocurrido un error: ",$e->getMessage(),"</h1>";
		}



		$stmt->close();



	}//insertarAcademica



	public function listarNovedades(){

		$bd=new BaseDatos();


			$sql="SELECT ID,titulo,descripcion
					FROM novedad 
					ORDER BY ID ASC";



			$consulta=mysqli_query($bd->conexion,$sql);


			while($fila=mysqli_fetch_assoc($consulta)){

				echo "<tr>
						<td>".$fila['ID']."</td>
						<td>".$fila['titulo']."</td>
						<td>".$fila['descripcion']."</td>						
						<td>
							<a href='eliminar_novedad.php?ID=".$fila['ID']."'>Eliminar</a>
						</td>
						<td>
							<a href='actualizar_novedad.php?ID=".$fila['ID']."'>Actualizar</a>
						</td>


				</tr>";


					}

				
	}//function


	public function eliminarNovedad($id){
		$bd=new BaseDatos();

		$stmt=$bd->mysqli->prepare("DELETE 
									FROM novedad
									WHERE ID=(?)");

			$stmt->bind_param("i",$id);
			$stmt->execute();

			echo "<h1 class='white-text'>El item ha <br> sido eliminado correctamente</h1>";
	}


	public function actualizarNovedad($id,$titulo,$subtitulo,$descripcion,$imagen1,$imagen2,$imagen3,$imagen4,$imagen5,$imagen6,$imagen7,$imagen8,$imagen9,$imagen10){
		$bd=new BaseDatos();

		try{


			//Renombrar archivos/campos
			if($imagen1 != ""){

				$extension=pathinfo($imagen1,PATHINFO_EXTENSION);

				$imagen1=rand(100000000,999999999).".".$extension;

			}else{
				$imagen1="";
			}

			if($imagen2 != ""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen2,PATHINFO_EXTENSION);

				$imagen2=rand(100000000,999999999).".".$extension;
			}else{
				$imagen2 = "";
			}

			if($imagen3 != ""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen3,PATHINFO_EXTENSION);

				$imagen3=rand(100000000,999999999).".".$extension;
			}else{
				$imagen3="";	
			}

			if($imagen4 !=""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen4,PATHINFO_EXTENSION);

				$imagen4=rand(100000000,999999999).".".$extension;
			}else{
				$imagen4="";
			}

			if($imagen5!=""){
			//Renombrar archivos/campos
				$extension=pathinfo($imagen5,PATHINFO_EXTENSION);

				$imagen5=rand(100000000,999999999).".".$extension;
			}else{
				$imagen5="";
			}

			if($imagen6 != ""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen6,PATHINFO_EXTENSION);

				$imagen6=rand(100000000,999999999).".".$extension;
			}else{
				$imagen6 = "";
			}

			if($imagen7 != ""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen7,PATHINFO_EXTENSION);

				$imagen7=rand(100000000,999999999).".".$extension;
			}else{
				$imagen7="";
			}

			if($imagen8!=""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen8,PATHINFO_EXTENSION);

				$imagen8=rand(100000000,999999999).".".$extension;
			}else{
				$imagen8="";
			}

			if($imagen9!=""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen9,PATHINFO_EXTENSION);

				$imagen9=rand(100000000,999999999).".".$extension;
			}else{
				$imagen9="";
			}

			if($imagen10!=""){
				//Renombrar archivos/campos
				$extension=pathinfo($imagen10,PATHINFO_EXTENSION);

				$imagen10=rand(100000000,999999999).".".$extension;

			}else{
				$imagen10 = "";
			}

			//ACTUALIZACION EN BD
			$stmt=$bd->mysqli->prepare("UPDATE novedad
										  SET titulo=(?),subtitulo=(?),descripcion=(?)
										  WHERE ID=(?)");

			$stmt->bind_param("sssi",$titulo,$subtitulo,$descripcion,$id);
			$stmt->execute();

			
			echo "<h1 class='white-text'>La historia ha sido actualizado correctamente</h1>";


		}catch(Exception $e){

				echo "¡Ups! Ha ocurrido un error, intentelo nuevamente";

		}
		try{

				if($imagen1!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img1
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();

					if($fila['img1']!=""){
					//Elimino el archivo fisico
					unlink("../imagenes/club_argenpesos/".$fila['img1']."");

					}

					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen1;

					move_uploaded_file($_FILES['imagen1']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img1=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen1,$id);

					$stmt->execute();


				}
				if($imagen2!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img2
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();

					if($fila['img2']!=""){

					//Elimino el archivo fisico
					unlink("../imagenes/club_argenpesos/".$fila['img2']."");

					}

					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen2;

					move_uploaded_file($_FILES['imagen2']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img2=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen2,$id);

					$stmt->execute();


				}

				if($imagen3!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img3
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();

					if($fila['img3']!=""){

						//Elimino el archivo fisico
						unlink("../imagenes/club_argenpesos/".$fila['img3']."");

					}

					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen3;

					move_uploaded_file($_FILES['imagen3']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img3=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen3,$id);

					$stmt->execute();


				}

				if($imagen4!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img4
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();

					if($fila['img4']!=""){

					//Elimino el archivo fisico
					unlink("../imagenes/club_argenpesos/".$fila['img4']."");

					}

					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen4;

					move_uploaded_file($_FILES['imagen4']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img4=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen4,$id);

					$stmt->execute();


				}

				if($imagen5!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img5
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();


					if($fila['img5']!=""){
					//Elimino el archivo fisico
					unlink("../imagenes/club_argenpesos/".$fila['img5']."");
					}


					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen5;

					move_uploaded_file($_FILES['imagen5']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img5=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen5,$id);

					$stmt->execute();


				}

				if($imagen6!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img6
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();


					if($fila['img6']!=""){
					//Elimino el archivo fisico
					unlink("../imagenes/club_argenpesos/".$fila['img6']."");

					}

					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen6;

					move_uploaded_file($_FILES['imagen6']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img6=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen6,$id);

					$stmt->execute();


				}

				if($imagen7!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img7
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();


					if($fila['img7']!=""){
					//Elimino el archivo fisico
					unlink("../imagenes/club_argenpesos/".$fila['img7']."");
					}


					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen7;

					move_uploaded_file($_FILES['imagen7']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img7=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen7,$id);

					$stmt->execute();


				}

				if($imagen8!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img8
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();


					if($fila['img8']!=""){
					//Elimino el archivo fisico
					unlink("../imagenes/club_argenpesos/".$fila['img8']."");
					}


					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen8;

					move_uploaded_file($_FILES['imagen8']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img8=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen8,$id);

					$stmt->execute();


				}

				if($imagen9!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img9
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();

					if($fila['img9']!=""){
					//Elimino el archivo fisico
					unlink("../imagenes/club_argenpesos/".$fila['img9']."");
					}


					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen9;

					move_uploaded_file($_FILES['imagen9']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img9=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen9,$id);

					$stmt->execute();


				}

				if($imagen10!=''){


					//Eliminar Imagen anterior

					//SELECCIONO NOMBRE DE IMAGEN
					$stmt=$bd->mysqli->prepare("SELECT img10
													FROM novedad
													WHERE ID=(?)");

					$stmt->bind_param("i",$id);

					$stmt->execute();

					$resultado=$stmt->get_result();

					$fila=$resultado->fetch_assoc();

					if($fila['img10']!=""){
					//Elimino el archivo fisico
					unlink("../imagenes/club_argenpesos/".$fila['img10']."");
					}


					//CARGA DE IMAGENES EN CARPETA
					//carga imagenes Big
					$target_path="../imagenes/club_argenpesos/";
					$target_path = $target_path . $imagen10;

					move_uploaded_file($_FILES['imagen10']['tmp_name'], $target_path);


					//actualizamos la base de datos
					$stmt=$bd->mysqli->prepare("UPDATE novedad
													SET img10=(?)
													WHERE ID=(?)");

					$stmt->bind_param("si",$imagen10,$id);

					$stmt->execute();


				}







			}catch(Exception $e){

				echo "¡Ups! Ha ocurrido un error, intentelo nuevamente";

			}
			




	}//function

	public function listarTitulo($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT titulo
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['titulo'];

	}



	public function listarSubtitulo($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT subtitulo
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['subtitulo'];

	}

	public function listarDescripcion($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT descripcion
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['descripcion'];

	}


	public function imagen1Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img1
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img1'];




	}


		public function imagen2Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img2
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img2'];




	}


	public function imagen3Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img3
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img3'];




	}


	public function imagen4Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img4
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img4'];




	}


	public function imagen5Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img5
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img5'];




	}


	public function imagen6Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img6
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img6'];




	}


	public function imagen7Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img7
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img7'];




	}


	public function imagen8Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img8
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img8'];




	}


	public function imagen9Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img9
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img9'];




	}


	public function imagen10Actual($id){

		$bd = new BaseDatos();

		$stmt=$bd->mysqli->prepare("SELECT img10
									  FROM novedad
									  WHERE ID=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();

		echo  $fila['img10'];




	}







}//class


 ?>