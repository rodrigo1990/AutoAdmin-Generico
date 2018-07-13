<?php
require("inc/verificarSession.php");
require_once("../clases/Novedad.php");

$nov = new Novedad();


?>  
<?php require("inc/head.php") ?>

<body>
<?php require("inc/header.php") ?>
	<div class="row">
		<div class="container text-center" style="margin-top:5%;">
<?php $nov->actualizarNovedad(
					  $_POST['id'],	
					  $_POST['titulo'],
					  $_POST['subtitulo'],
					  $_POST['descripcion'],
					  $_FILES['imagen1']['name'],
					  $_FILES['imagen2']['name'],
					  $_FILES['imagen3']['name'],
					  $_FILES['imagen4']['name'],
					  $_FILES['imagen5']['name'],
					  $_FILES['imagen6']['name'],
					  $_FILES['imagen7']['name'],
					  $_FILES['imagen8']['name'],
					  $_FILES['imagen9']['name'],
					  $_FILES['imagen10']['name']);
 ?>

		</div>
	</div>
	 <div class="row">
          <div class="container">
              <a type="submit" class=" fix-btn-width btn btn-primary  submit-btn center-block" href="mis_novedades.php">Mis Novedades</a>
          </div>
        </div>  	
</body>
</html  

