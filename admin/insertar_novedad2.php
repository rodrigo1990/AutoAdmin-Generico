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
    <form action="landing_insertar_novedad.php" class="some_form" id="my-dropzone-element-id"enctype="multipart/form-data" method="POST"> 
     <div class="row">

        <div class="col-lg-6 col-sm-6 margin">
          <div class="form-group">
            <label for="titulo">Ingrese un titulo</label><br>
            <input type="text" name="titulo" class="form-control" id="titulo"> 
          </div>
        </div>


        <div class="col-lg-6 col-sm-6 margin">
          <div class="form-group">
            <label for="descripcion">Descripcion</label><br>
            <input type="text" name="descripcion" id="descripcion" class="form-control"> 
          </div>
        </div>

      
      <div class="col-lg-6 col-sm-6 margin">
         <label for="">Imagen 1 </label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Buscar&hellip; <input type="file" style="display: none;" name="imagen1">
                    </span>
                </label>
                <input type="text" class="form-control" style="color:black !important;" readonly>
            </div>
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
        </div>
          
        <div class="row">
          <div class="container">
            <div class="col-lg-6 col-sm-6">

              <a type="submit" class="btn btn-primary left submit-btn" href="home.php">Regresar a home</a>
               
            </div>
            <div class="col-lg-6 col-sm-6">
              <button type="submit" class="btn btn-primary right submit-btn">Ingresar novedades</button>
            </div>
          </div>
        </div>
  
      <div id="imgContainer"></div>
      <div class="col-lg-4 ">
        <h4 class="centered"> MODAL </h4>
        <p class="centered">( open in modal window )</p>
        <div id="cropContainerModal"></div>
      </div>
    </form>

  </div>
</div>

<script src="../js/jquery.min.js"></script>
<?php require("inc/jquery-bootstrap-scripts.php") ?>


<script src=" https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="js/jquery.mousewheel.min.js"></script>
<script src="js/croppic.min.js"></script>
<script src="js/main.js"></script>


 <script>
    var croppicHeaderOptions = {
        //uploadUrl:'img_save_to_file.php',
        cropData:{
          "dummyData":1,
          "dummyData2":"asdas"
        },
        cropUrl:'img_crop_to_file.php',
        customUploadButtonId:'cropContainerHeaderButton',
        modal:false,
        processInline:true,
        loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
        onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
        onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
        onImgDrag: function(){ console.log('onImgDrag') },
        onImgZoom: function(){ console.log('onImgZoom') },
        onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
        onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
        onReset:function(){ console.log('onReset') },
        onError:function(errormessage){ console.log('onError:'+errormessage) }
    } 
    var croppic = new Croppic('croppic', croppicHeaderOptions);
    
    
    var croppicContainerModalOptions = {
        uploadUrl:'img_save_to_file.php',
        cropUrl:'img_crop_to_file.php',
        modal:true,
        imgEyecandyOpacity:0.4,
        loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
        onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
        onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
        onImgDrag: function(){ console.log('onImgDrag') },
        onImgZoom: function(){ console.log('onImgZoom') },
        onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
        onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
        onReset:function(){ console.log('onReset') },
        onError:function(errormessage){ console.log('onError:'+errormessage) }
    }
    var cropContainerModal = new Croppic('cropContainerModal', croppicContainerModalOptions);
    
    
    var croppicContaineroutputOptions = {
        uploadUrl:'img_save_to_file.php',
        cropUrl:'img_crop_to_file.php', 
        outputUrlId:'cropOutput',
        modal:false,
        loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
        onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
        onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
        onImgDrag: function(){ console.log('onImgDrag') },
        onImgZoom: function(){ console.log('onImgZoom') },
        onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
        onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
        onReset:function(){ console.log('onReset') },
        onError:function(errormessage){ console.log('onError:'+errormessage) }
    }
    
    var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);
    
    var croppicContainerEyecandyOptions = {
        uploadUrl:'img_save_to_file.php',
        cropUrl:'img_crop_to_file.php',
        imgEyecandy:false,        
        loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
        onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
        onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
        onImgDrag: function(){ console.log('onImgDrag') },
        onImgZoom: function(){ console.log('onImgZoom') },
        onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
        onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
        onReset:function(){ console.log('onReset') },
        onError:function(errormessage){ console.log('onError:'+errormessage) }
    }
    
    var cropContainerEyecandy = new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);
    
    var croppicContaineroutputMinimal = {
        uploadUrl:'img_save_to_file.php',
        cropUrl:'img_crop_to_file.php', 
        modal:false,
        doubleZoomControls:false,
          rotateControls: false,
        loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
        onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
        onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
        onImgDrag: function(){ console.log('onImgDrag') },
        onImgZoom: function(){ console.log('onImgZoom') },
        onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
        onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
        onReset:function(){ console.log('onReset') },
        onError:function(errormessage){ console.log('onError:'+errormessage) }
    }
    var cropContaineroutput = new Croppic('cropContainerMinimal', croppicContaineroutputMinimal);
    
    var croppicContainerPreloadOptions = {
        uploadUrl:'img_save_to_file.php',
        cropUrl:'img_crop_to_file.php',
        loadPicture:'assets/img/night.jpg',
        enableMousescroll:true,
        loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
        onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
        onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
        onImgDrag: function(){ console.log('onImgDrag') },
        onImgZoom: function(){ console.log('onImgZoom') },
        onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
        onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
        onReset:function(){ console.log('onReset') },
        onError:function(errormessage){ console.log('onError:'+errormessage) }
    }
    var cropContainerPreload = new Croppic('cropContainerPreload', croppicContainerPreloadOptions);
    
    
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



</body>
</html>