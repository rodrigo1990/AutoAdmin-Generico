<?php
require("inc/verificarSession.php");
 require("inc/head.php"); ?>
<body>
<?php require("inc/header.php") ?>
<div class="row">
  <div class="container">
    <h1>INGRESAR NOVEDADES</h1>
  </div>
</div><br>
<div class="row">
  <div class="container">
  	<form action="landing_insertar_novedad.php" class="some_form" name="formulario" id="formulario"enctype="multipart/form-data" method="POST">	
  	 <div class="row">

        <div class="col-lg-6 col-sm-6 margin">
          <div class="form-group">
          	<label for="titulo">Ingrese un titulo</label><br>
            <input type="text" name="titulo" class="form-control" id="titulo"> 
          </div>
        </div>

        <div class="col-lg-6 col-sm-6 margin">
          <div class="form-group">
            <label for="fecha">Ingrese una subtitulo</label><br>
            <input type="text" name="subtitulo" class="form-control" id="subtitulo"> 
          </div>
        </div>


        <div class="col-lg-12 col-sm-12 margin">
          <div class="form-group">
            <label for="descripcion">Descripcion</label><br>
        		<textarea  name="descripcion" maxlength ="" minlength="10" id="descripcion" class="form-control" rows="7" ></textarea>
          </div>
        </div>

      
      <div class="col-lg-6 col-sm-6 margin">
            <label for="" class="yellow-text">Imagen de portada</label>

            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" id="img-portada"  style="display: none;" name="imagen1" >
                    </span>
                </label>
                <input type="text" class="form-control" id="img-1"  style="color:black !important;" readonly  >
            </div>
            <div id="imagen1-cont" class="image-preview"></div>
        </div>

       <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 2 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen2">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div id="imagen2-cont" class="image-preview"></div>
        </div>


      <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 3 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen3">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div id="imagen3-cont" class="image-preview"></div>
        </div>



      <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 4 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen4">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div id="imagen4-cont" class="image-preview"></div>
        </div>



      <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 5 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen5">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div id="imagen5-cont" class="image-preview"></div>
        </div>


       <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 6 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen6">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div id="imagen6-cont" class="image-preview"></div>
        </div>



      <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 7 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen7">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div id="imagen7-cont" class="image-preview"></div>
        </div>





      <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 8 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen8">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div id="imagen8-cont" class="image-preview"></div>
        </div>



      <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 9 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen9">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div id="imagen9-cont" class="image-preview"></div>
        </div>


      <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 10 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen10">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
            <div id="imagen10-cont" class="image-preview"></div>
        </div>
          
        <div class="row padding-bottom">
          <div class="container">
            <div class="col-lg-6 col-sm-6">

              <a type="submit" class="btn btn-primary left submit-btn" href="home.php">Regresar a home</a>
    	         
            </div>
            <div class="col-lg-6 col-sm-6">
              <a class="btn btn-primary right submit-btn" onclick="validarCampos()">Ingresar novedades</a>
            </div>
          </div>
        </div>
  
      <div id="imgContainer"></div>

  	</form>

  </div>
</div>

<script src="js/jquery.min.js"></script>
<?php require("inc/jquery-bootstrap-scripts.php") ?>
<script>
    function validarCampos(){

          var _URL = window.URL || window.webkitURL;
          var file = $("#img-portada")[0].files[0];

          alert(file.name);



        }
</script>

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
<script>
  function readURL(input) {

  var DOMId = "#"+input.name+"-cont";


  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {

      if($(DOMId).css("display")=="block"){
        $(DOMId).fadeOut();
      }

      $(DOMId).css('background-image', 'url(' + e.target.result+ ')');
      $(DOMId).fadeIn();

    }

    reader.readAsDataURL(input.files[0]);
  }

  
}

$("input[type=file]").change(function() {
  readURL(this);
});
</script>



</body>
</html>