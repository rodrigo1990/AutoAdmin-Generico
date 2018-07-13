<?php include('header.php'); ?>

<br />

<div class="container">
  <div class="row" id="sucursales_sec">
      <div class="cabecera_sucursales">
        <div class="active col-sm-3 col-xs-12">
          <a href="#casa_central" data-toggle="tab" class="titulo_cabecera_suc">CASA CENTRAL</a>
          <div class="listado_sucursales">
            <a href="sucursales.php">- Casa central</a><br />
            <a href="sucursales_caba.php">- CABA</a><br />
          </div>
        </div>
        <div class="col-sm-3 col-xs-12">
          <a href="#noroeste" data-toggle="tab" class="titulo_cabecera_suc">ZONA NOROESTE</a>
          <div class="listado_sucursales">
            <a href="sucursales_sanfernando.php">- San Fernando</a><br />
            <a href="sucursales_sanmiguel.php">- San Miguel</a><br />
            <a href="sucursales_sanmiguel2.php">- San Miguel 2</a><br />
            <a href="sucursales_sanjusto.php">- San Justo</a><br />
          </div>
        </div>
        <div class="col-sm-3 col-xs-12">
          <a href="#sur" data-toggle="tab" class="titulo_cabecera_suc">ZONA SUR</a>
          <div class="listado_sucursales">
            <a href="sucursales_avellaneda.php">- Avellaneda</a><br />
            <a href="sucursales_berazategui.php">- Berazategui</a><br />
            <a href="sucursales_lanus.php">- Lanus</a><br />
            <a href="sucursales_lomas.php">- Lomas De Zamora </a><br />
            <a href="sucursales_solano.php">- Solano</a><br />
            <a href="sucursales_varela.php">- Varela</a><br />
            <a href="sucursales_quilmes.php">- Quilmes</a><br />
          </div>
        </div>
        <div class="col-sm-3 col-xs-12">
          <a href="#otras_provincias" data-toggle="tab" class="titulo_cabecera_suc">OTRAS PROVINCIAS</a>
          <div class="listado_sucursales">
            <a href="sucursales_santiago.php">- Santiago Del Estero</a>
          </div>
        </div>
      </div>

      <div class="clearfix"></div><br /><br />

      <div id="map"></div>

      <div class="col-sm-3">
        <div class="item_sucursal">
          <img src="imagenes/sucursales/caba.jpg" alt="CABA" class="img_full" />
          <span>CABA</span><br />
          Reconquista 660 PB, CABA
          <br /><br />
          <b>TEL:</b> 4510-6594
        </div>
      </div>

  </div>
</div>
<div class="clearfix"></div>

<script>
  function initMap() {
    var uluru = {lat: -34.600088, lng: -58.372750};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      scrollwheel: false,
      draggable: false,
      center: uluru
    });
    var marker = new google.maps.Marker({
      position: uluru,
      map: map
    });
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDf3yUI-0pmTASp4gvMKLAr7rvnVdRpoCw &callback=initMap"></script>

<br /><br /><br />
<?php include('footer.php'); ?>