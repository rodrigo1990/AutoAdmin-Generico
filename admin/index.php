<?php 
session_start();
session_destroy();
require("inc/head.php");
 ?>
<body class="">
<div class="overlap"></div>
<section id="acceso">
	<div class="row">
		<div class="container">
			<div class="col-lg-12 col-sm-12 panel">
				<div class="row ">
					<div class="container">
						<img src="../imagenes/logo.png" class="logo" alt="">
					</div>
				</div>
				<div class="row margin">
						<div class="form-group text-center">
							<label for="usuario">Ingrese usuario</label>
							<input type="text" name="usuario" id="usuario" class="form-control text-center" placeholder="administracion@randlab.com.ar">
						</div>
						<div class="form-group text-center">
							<label for="pass">Ingrese password</label>
							<input type="password" name="pass" id="pass" class="form-control text-center">
						</div>
		              <a  class="btn btn-primary center-block fix-btn-width submit-access-btn" onClick="validarUsuario()">Ingresar</a>

				</div>
			</div>
		</div>
	</div>
</section>
<?php require("inc/jquery-bootstrap-scripts.php") ?>
<script>
	function validarUsuario(){

		var email=$("#usuario").val();
		var pass=$("#pass").val();
	
			$.ajax({

				data:{email:email,pass:pass},
				url:'ajax/validarUsuario.php',
				type:'post',
				success:function(response){

					if(response=='TRUE'){
						window.location ="home.php?email="+email+"";
					}else{
						alert("Contraseña invalida");
					}
					},
				error:function(response){
					alert(response);
				}
				});			
	}
</script>
</body>
</html>