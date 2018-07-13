<?php 
require("inc/verificarSession.php");
require_once("../clases/novedad.php");

$novedad = new Novedad();

 ?>
<?php 

require("inc/head.php");
 ?>
<body>
<?php require("inc/header.php") ?>
	<div class="row">
		<div class="container text-center">
				<h1>Mis Novedades</h1>
		</div>	
	</div>
	<div class="row">
		<div class="container ">
			<table class="table">
				<thead>
					<tr>
						<th>
							ID
						</th>
						<th>
							Titulo
						</th>
						<th>
							Descripcion
						</th>
						<th>
							Actualizar
						</th>
						<th>
							Eliminar
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 

						$novedad->listarNovedades();
					 ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row padding-bottom" style="margin-top:5%;">
		<div class="container">
			<div class="col-lg-6 col-sm-6">
              <a type="submit" class="btn btn-primary left submit-btn" href="home.php">Regresar a home</a>

			</div>
			<div class="col-lg-6 col-sm-6">
				
			</div>
		</div>
	</div>

<?php require("inc/jquery-bootstrap-scripts.php") ?>
</body>
</html>