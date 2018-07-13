<?php
require("inc/verificarSession.php");
  require_once("../clases/Novedad.php");
 require("inc/head.php");

$nov = new Novedad();

 ?>
<body>
<?php require("inc/header.php") ?>
  <div class="row">
  <div class="container">
    <h1>ACTUALIZAR NOVEDADES</h1>
  </div>
</div><br>
	<form action="landing_actualizar_novedad.php" class="some_form" id="my-dropzone-element-id"enctype="multipart/form-data" method="POST">
  <div class="row">
    <div class="container">	

      <div class="col-lg-6 col-sm-6">
        <div class="form-group">
      		<label for="titulo">Ingrese un titulo</label><br>
          <input type="text" name="titulo" id="titulo" class="form-control" value="<?php $nov->listarTitulo($_GET['ID']) ?>" required> <br><br>
        </div>
      </div>

      <div class="col-lg-6 col-sm-6 margin">
          <div class="form-group">
            <label for="fecha">Ingrese una subtitulo</label><br>
            <input type="text" name="subtitulo" class="form-control" id="subtitulo" value="<?php $nov->listarSubtitulo($_GET['ID']) ?>" required> 
          </div>
        </div>

      <div class="col-lg-12 col-sm-12">
        <div class="form-group">
          <label for="descripcion">Descripcion</label><br>
      		<textarea name="descripcion" maxlength ="351" minlength="10" id="descripcion" rows="9" class="form-control" value="" required title="De 1 a 563 caracteres"><?php  $nov->listarDescripcion($_GET['ID']) ?></textarea> <br><br>
        </div>
      </div>
 


  	
      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="" class="yellow-text">Imagen de portada</label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen1">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen1Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen1Actual($_GET['ID']) ?>);"></div>

            </div>
        </div>

  
      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="">Imagen 2 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen2">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen2Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen2Actual($_GET['ID']) ?>);"></div>
            </div>
        </div>
      
      

      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="">Imagen 3 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen3">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen3Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen3Actual($_GET['ID']) ?>);"></div>
            </div>
        </div>

      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="">Imagen 4 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen4">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen4Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen4Actual($_GET['ID']) ?>);"></div>
            </div>
        </div>

      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="">Imagen 5 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen5">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen5Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen5Actual($_GET['ID']) ?>);"></div>
            </div>
        </div>

      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="">Imagen 6 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen6">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen6Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen6Actual($_GET['ID']) ?>);"></div>
            </div>
        </div>

        








      
      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="">Imagen 7 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen7">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen7Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen7Actual($_GET['ID']) ?>);"></div>
            </div>
        </div>
      

      
      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="">Imagen 8 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen8">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen8Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen8Actual($_GET['ID']) ?>);"></div>
            </div>
        </div>

      
      

      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="">Imagen 9 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen9">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen9Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen9Actual($_GET['ID']) ?>);"></div>
            </div>
        </div>

      
      

      <div class="col-lg-6 col-sm-6 margin fix-height">
         <label for="">Imagen 10 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen10">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div class="actual-img-cont">
                  <span class="center-block">
                    <h3>IMAGEN ACTUAL:</h3><?php $nov->imagen10Actual($_GET['ID']) ?>
                  </span><br>
                                <div class="center-block img-actual" style="background-image:url(../imagenes/club_argenpesos/<?php  $nov->imagen10Actual($_GET['ID']) ?>);"></div>
            </div>
        </div>
      
    <input type="hidden" value="<?php echo  $_GET['ID']?>" name="id">


         <div class="row margin padding-bottom">
          <div class="container">
            <div class="col-lg-6 col-sm-6">

              <a type="submit" class="btn btn-primary left submit-btn" href="home.php">Regresar a home</a>
               
            </div>
            <div class="col-lg-6 col-sm-6">
              <button type="submit" class="btn btn-primary right submit-btn">Actualizar novedades</button>
            </div>
          </div>
        </div>
   </div>
  </div>
	</form>




<script src="../js/jquery.min.js"></script>
<?php require("inc/jquery-bootstrap-scripts.php") ?>
<script>
  $(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});
</script>




</body>
</html>