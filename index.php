<?php include('header.php'); ?>

<link rel="stylesheet" href="css/responsiveslides/responsiveslides.css">
<link rel="stylesheet" href="css/responsiveslides/demo.css">
<script src="js/responsiveslides.min.js"></script>
<script>
    $(function () {

      $("#slider4").responsiveSlides({
        auto: true,
        pager: false,
        nav: true,
        speed: 500,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>");
        }
      });

    });

    $(document).on('keyup.callbacks_container', function(evt) {
      if (evt.keyCode == 37) { // LEFT
          $('.callbacks_container .prev').trigger('click');
      } else if (evt.keyCode == 39) { // RIGHT
          $('.callbacks_container .next').trigger('click');
      }
  });
</script>

<!-- FANCYBOX -->
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
  $(document).ready(function() {
    $('.fancybox').fancybox();
  });
</script>

<a class="fancybox" href="#inline1" id="hidden_link" ></a>
<div id="inline1" style="width:100%; max-width: 650px; margin: auto; display: none;">
  <a href="http://www.argenpesos.com.ar/solicitarprestamo/"><img src="imagenes/home/popup.jpg" alt="" class="img_full" /></a>
</div>

<div id="wrapper">
  <div class="callbacks_container">
    <ul class="rslides" id="slider4">
      <li><img src="imagenes/home/slider/1.jpg" alt=""></li>
      <li><img src="imagenes/home/slider/2.jpg" alt=""></li>
      <li><img src="imagenes/home/slider/3.jpg" alt=""></li>
      <li><img src="imagenes/home/slider/4.jpg" alt=""></li>
      <li><a href="http://www.argenpesos.com.ar/solicitarprestamo/"><img src="imagenes/home/slider/5.jpg" alt=""></a></li>
    </ul>
  </div>
</div>
<div class="clear"></div>

<div id="local_home"></div>

<div id="franja_naranja">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        ¡TENEMOS UN PRÉSTAMO PERSONAL PARA VOS!<br />
        <span style="color:#fff000;">CON O SIN VERAZ</span><br />
        <a href="http://www.argenpesos.com.ar/solicitarprestamo/" class="btn btn-primary">SOLICITAR PRÉSTAMO</a>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    $("#hidden_link").trigger('click');
  });
</script>

<?php include('footer.php'); ?>