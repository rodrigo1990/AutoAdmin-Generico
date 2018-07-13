<?php include('header.php'); ?>
<?php 
require_once('clases/Novedad.php'); 

$nov  = new Novedad();


?>
<!-- FANCYBOX -->
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.4/jquery.fancybox.min.js"></script>
<!-- FANCY BOX -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.4/jquery.fancybox.min.css" />
<script type="text/javascript">
  $(document).ready(function() {
    $('.fancybox').fancybox();
  });
</script>
<section id="club_argenpesos">

  <?php 

    $nov->listarNovedadesUser();

   ?>





</section>

<br /><br /><br />
<?php include('footer.php'); ?>