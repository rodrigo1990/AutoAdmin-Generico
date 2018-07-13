<?php 
require("inc/verificarSession.php");
require("inc/head.php");
 ?>
<body>
<?php require("inc/header.php") ?>
	<div class="row">
		<div class="container text-center">
				<h1>Panel de administracion</h1>
		</div>	
	</div>

	<div class="row text-center">
		<div class="container">
			<div class="col-lg-6 col-sm-6">
				<a href="insertar_novedad.php" class="home-btn"><h2>INSERTAR NOVEDAD</h2></a>
			</div>
			<div class="col-lg-6 col-sm-6">
				<a href="mis_novedades.php" class="home-btn"><h2>MIS NOVEDADES</h2></a>
			</div>
		</div>
	</div>
	
<?php require("inc/jquery-bootstrap-scripts.php") ?>
</body>
</html>