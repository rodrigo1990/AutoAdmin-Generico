<?php include('header.php'); ?>

<!-- FANCYBOX -->
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
  $(document).ready(function() {
    $('.fancybox').fancybox();
  });
</script>

<br /><br />

<div class="container">
	<div class="row">
		<div class="col-sm-5"><a class="fancybox" href="imagenes/sumate/popup.jpg" data-fancybox-group="gallery"><img src="imagenes/sumate/izquierda.png" alt="" class="img_full" /></a></div>
		<div class="col-sm-7">
      <h1 id="titulo_sumate">SI QUERÉS FORMAR PARTE DE NUESTRO EQUIPO DE TRABAJO, COMPLETÁ EL FORMULARIO</h1>

      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Nombre y Apellido</div>
        <div class="col-sm-9"><input type="text" name="nombre" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Fecha de Nacimiento</div>
        <div class="col-sm-9"><input type="date" name="fecha_nacimiento" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Dni</div>
        <div class="col-sm-9"><input type="number" name="dni" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Teléfono</div>
        <div class="col-sm-9"><input type="text" name="telefono" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Email</div>
        <div class="col-sm-9"><input type="email" name="mail" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Puesto</div>
        <div class="col-sm-9"><input type="text" name="puesto" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Dirección</div>
        <div class="col-sm-9"><input type="text" name="direccion" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Localidad</div>
        <div class="col-sm-9"><input type="text" name="localidad" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Provincia</div>
        <div class="col-sm-9"><input type="text" name="provincia" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Consulta</div>
        <div class="col-sm-9"><textarea name="consulta" class="input_sumate"></textarea></div>
      </div>

      <div class="titulos_sumate">ESTUDIOS</div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Nivel de estudios</div>
        <div class="col-sm-9"><input type="text" name="nivel_estudios" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Título</div>
        <div class="col-sm-9"><input type="text" name="titulo" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Manejo de Office</div>
        <div class="col-sm-9"><input type="text" name="manejo_office" class="input_sumate" /></div>
      </div>

      <div class="titulos_sumate">EXPERIENCIA LABORAL</div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Última empresa</div>
        <div class="col-sm-9"><input type="text" name="ultima_empresa" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Área</div>
        <div class="col-sm-9"><input type="text" name="area" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Fecha de inicio</div>
        <div class="col-sm-9"><input type="text" name="fecha_inicio" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Fecha de finalización</div>
        <div class="col-sm-9"><input type="text" name="fecha_finalizacion" class="input_sumate" /></div>
      </div>
      <div class="row">
        <div class="col-sm-9 col-sm-offset-3"><input type="checkbox" name="sigue_trabajando" style="margin: 0px 5px 15px 0px" /> <span style="color: #00a5e7; font-size: 13px;">Sigue trabajando</span></div>
      </div>
      <div class="row">
        <div class="col-sm-3 izquierda_sumate">Describe tus responsabilidades</div>
        <div class="col-sm-9"><textarea name="responsabilidades" class="input_sumate"></textarea></div>
      </div>
      <div class="row">
        <div class="col-sm-9 col-sm-offset-3">
          <div class="row">
            <div class="col-sm-8">
              <label for="upload-cv" id="custom_file">ADJUNTAR CV</label>
              <input type="file" name="cv" id="upload-cv" />
            </div>
            <div class="col-sm-4 text-right"><input type="submit" name="submit" value="ENVIAR" class="btn_naranja_form" /></div>
          </div>
        </div>
      </div>

		</div>
	</div>
</div>

<br /><br /><br />
<?php include('footer.php'); ?>