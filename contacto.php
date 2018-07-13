<?php include('header.php'); ?>

<script language="JavaScript" type="text/javascript" src="contacto.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<div id="header_contacto">
  <div id="titulo_header_contacto">
    <div class="titulos_contacto">CONTACTO</div>
    <div class="linea_titulos_contacto"></div>
  </div>
  <div id="map"></div>
</div>

<div class="container" id="datos_contacto">
  <div class="col-sm-4">
    <div id="izquierda_contacto">
      <div class="titulos_contacto">ESCRÍBENOS</div>
      <div class="linea_titulos_contacto"></div>
      <br />
      Tu opinión es muy importante para nosotros, mándanos un mensaje y con gusto te atenderemos.
    </div>
  </div>
  <div class="col-sm-8" id="derecha_contacto">
      <form name="form_contacto" onsubmit="enviarFormulario(); return false">
        <div class="col-sm-12 padding_0">Nombre<br /><input class="campo_contacto" type="text" name="nombre" /></div>
        <div class="col-sm-6 padding_l_0">
          Teléfono<br />
          <input class="campo_contacto" type="number" name="telefono" />
        </div>
        <div class="col-sm-6 padding_r_0">
          Correo<br />
          <input class="campo_contacto" type="email" name="mail" />
        </div>
        <div class="col-sm-12 padding_0">Mensaje<br /><textarea class="campo_contacto" name="mensaje" style="height:130px;" ></textarea></div>
        <div id="cont_botones">
          <div id="captcha_contacto"><div class="g-recaptcha" data-sitekey="6LdSDAkUAAAAAJ4uEelrDBdkPnRRhncZGUq4RnQ-"></div></div>
          <div id="btn_contacto_p"><button id="btn_contacto" type="submit" name="submit">ENVIAR</button></div>
        </div>
      </form>
      <div class="clear"></div>
      <div class="col-sm-12 padding_0">
        <div class="msg-error"></div>
        <div id="resultado"></div>
      </div>
      <div class="clear"></div>
  </div>
</div>


<script type="text/javascript">
  google.maps.event.addDomListener(window, 'load', init);
        
  function init() {
      var mapOptions = {
          zoom: 15,
          scrollwheel: false,
          center: new google.maps.LatLng(29.07100600999999, -110.93809610000003),
           styles: [{"featureType":"administrative.country","elementType":"geometry","stylers":[{"visibility":"simplified"},{"hue":"#ff0000"}]}]
      };

      var mapElement = document.getElementById('map');

      var map = new google.maps.Map(mapElement, mapOptions);

      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(29.07160679999999, -110.95809610000003),
          map: map,
          title: 'INPROMINE'
      });
  }
</script>

<div class="clear"></div>

<?php include('footer.php'); ?>