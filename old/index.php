<?php
error_reporting(0);

$__SECCIONES = array(
	"home"						=> "Home",
	"productos"					=> "Productos",
	"planahorro"				=> "Plan de Ahorro",
	"como_funciona"				=> "Como funciona",
	"preguntas_frecuentes"		=> "Preguntas Frecuentes",
	"sucursales"				=> "Sucursales",
	"contacto"					=> "Contacto",
	"contacto3"					=> "Contacto",
	"sumate"					=> "Sumate",
	"clientes"					=> "Clientes",
	"solicitud_credito"			=> "Solicitud de crédito",
	"solicitud_credito_vale"			=> "Solicitud de crédito",
	"solicitud_credito_prestamos"		=> "Solicitud de crédito",
	"solicitud_credito_monotributista"	=> "Solicitud de crédito",
	"solicitud_credito_mujer"			=> "Solicitud de crédito",
	"solicitud_credito_tarjeta"			=> "Solicitud de crédito",
	"solicitud_credito_cuota"			=> "Solicitud de crédito",
	"solicitud_credito_jubilados"		=> "Solicitud de crédito",
);

if(!$__SECCIONES[$_GET['s']])
{
	$__SEC = "home";
}
else
{
	$__SEC = $_GET['s'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Language" content="es-cl" />
	<title>Argenpesos - <?php echo $__SECCIONES[$__SEC]; ?></title>

	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="content-language" content="es" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="window-target" content="_top" />

<meta name="keywords" content="ARGENPESOS prestamos ONLINE, ARGENPESOS préstamos personales, prestamos, préstamos, prestamos personales, préstamos personales, creditos personales, créditos personales, prestamos personales por internet, préstamos personales por internet, creditos personales por internet, créditos personales por internet, prestamos sin prenda, préstamos sin prenda, crédito, credito, dinero, efectivo, bancos, solicitud crédito on line, solicitud crédito on line, creditos prestamos, prestamos, prestamos personales, prestamos efectivo, prestamos dinero, prestamos rapidos, prestamos bancarios, prestamos financieros, prestamos bancarios, prestamos online, prestamos bbva, prestamos BBVA frances" />

<meta name="description"content="Argenpesos te ofrece el mejor préstamo personal por Internet de la manera más rápida, fácil y segura. En sólo 3 pasos obtenés tu crédito en el acto!"/>

<meta name="distribution" content="global" />
<meta name="robots" content="index,follow" />
<meta name="copyright" content="(c) 2012" />
<meta http-equiv="content-language" content="ES">
<meta name="author" content="Legión Creativa,(c) 2012" />
<meta name="geo.region" content="AR-C" />
<meta name="geo.placename" content="Buenos Aires" />
<meta name="geo.position" content="-34.608417;-58.373161" />



	<link rel="stylesheet" media="screen" type="text/css" href="css/general.css" />
	
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
	<script src="js/jquery.ui.widget.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function()
		{
			var id = location.search.substring(3);
			$('#'+id).css('color', '#F7EC35');
		});
	</script>
	
    
    
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/smoothDivScroll.css" type="text/css" media="screen" />

	
	<script src="js/jquery.smoothDivScroll-1.1-min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			$("div#makeMeScrollable").smoothDivScroll({ autoScroll: "onstart", 
														autoScrollDirection: "backandforth",
														autoScrollStep: 1,
														autoScrollInterval: 15,
														startAtElementId: "startAtMe",
														visibleHotSpots: "always" });

		});
		
		$(function() 
		{
			$(".latest_img").css("opacity","0.5");

			// ON MOUSE OVER
			$(".latest_img").hover(function () 
			{
				// SET OPACITY TO 100%
				$(this).stop().animate({
				opacity: 1.0
				}, "fast");
			},

			// ON MOUSE OUT
			function () 
			{
				// SET OPACITY BACK TO 50%
				$(this).stop().animate({
				opacity: 0.5
				}, "fast");
			});
		});
		
	</script>

<!-- Anura-->

	<script type="text/javascript" 
    src="https://webrtc.anura.com.ar/click2call/js/jquery-2.1.1.min.js">
</script>
<script type="text/javascript" 
    src="https://webrtc.anura.com.ar/click2call/js/jquery.json-2.4.min.js">
</script>
<script type="text/javascript" 
    src="https://webrtc.anura.com.ar/click2call/js/jquery.cookie.js">
</script>
<script type="text/javascript" 
    src="https://webrtc.anura.com.ar/click2call/js/verto-min.js">
</script>
<script type="text/javascript" 
    src="https://webrtc.anura.com.ar/click2call/click2call.js">
</script>

<!-- Anura-->

	<style type="text/css">
		#makeMeScrollable
		{
			width:100%;
			height: 126px;
			position: relative;
			padding-top: 10px;
		}
		
		#makeMeScrollable div.scrollableArea *
		{
			position: relative;
			float: left;
			margin: 0;
			padding: 0;
		}
		.latest_img {
			cursor: pointer;
		}
	</style>
	<!--[if lt IE 8]>
   <style type="text/css">
   li a {display:inline-block;}
   li a {display:block;}
   </style>
   <![endif]-->
   
   
	<link rel="stylesheet" href="css/slider/responsiveslides.css">
	<link rel="stylesheet" href="css/slider/demo.css">

	<script src="js/responsiveslides.min.js"></script>
	<script>
	    // You can also use "$(window).load(function() {"
	    $(function () {
	      // Slideshow 4
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
	</script>

	
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99131822-3', 'auto');
  ga('send', 'pageview');

</script>



</head>
<body ondragstart = "return false">

<div id="data_fiscal" style="z-index: 999;"><a href="https://servicios1.afip.gov.ar/clavefiscal/qr/mobilePublicInfo.aspx?req=e1ttZXRob2Q9Z2V0UHVibGljSW5mb11bcGVyc29uYT0zMDcwOTEwMDQxMl1bdGlwb2RvbWljaWxpbz0wXVtzZWN1ZW5jaWE9MF1bdXJsPWh0dHA6Ly93d3cuYXJnZW5wZXNvcy5jb20uYXJdfQ==" target="_blank" ><img src="imagenes/data_fiscal.jpg" alt="" /></a></div>
<div class="centra_web">
		<div id="cabecera">
			<div id="logo"><a href="?s=home"><img src="imagenes/logo.png" alt="" /></a></div>
			<div id="derecha_cabecera">
				<div id="izquierda_derecha_cabecera">
					<div id="clientes_cabecera"><a href="?s=clientes"><img src="imagenes/sos_cliente.png" alt="" /></a></div>
					<a href="/solicitarprestamo"><img src="imagenes/pedi_credito.png" style="margin-top: 10px;" /></a>
				</div>
				<div id="derecha_derecha_cabecera">
					<a href="https://www.facebook.com/argenpesos" target="_blank"><img src="imagenes/facebook.png" alt="Facebook" /></a><br />
					<a href="https://twitter.com/@argenpesos" target="_blank"><img src="imagenes/twitter.png" alt="Twitter" /></a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="menu">
			<div id="centra_menu">
				<a href="?s=home" id="home" >HOME</a>
				| 
				<a href="?s=productos" id="productos" >PRODUCTOS</a>
				|
				<a href="?s=planahorro" id="planahorro" >PLAN DE AHORRO</a>
				|
				<a href="?s=como_funciona" id="como_funciona" >CÓMO FUNCIONA</a>
				|
				<a href="?s=preguntas_frecuentes" id="preguntas_frecuentes" >FAQ'S</a>
				|
				<a href="?s=sucursales" id="sucursales" >SUCURSALES</a>
				|
				<a href="?s=contacto" id="contacto" >CONTACTO</a>
				|
				<a href="?s=sumate" id="sumate" >SUMATE</a>
			</div>
		</div>
		<div class="contenedor_web">
			<div class="callbacks_container">
			    <ul class="rslides" id="slider4">
			        <li>
			        	<img src="imagenes/slider/16.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/1.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/2.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/3.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/4.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/5.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/6.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/7.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/8.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/9.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/10.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/11.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/13.jpg" alt="" />
			        </li>
			        <li>
			        	<img src="imagenes/slider/14.jpg" alt="" />
			        </li>
			    </ul>
			</div>
		</div>
		<?php if($__SEC == "preguntas_frecuentes")
		{
			?>
			<div class="titulos_secciones"><img src="imagenes/titulos/preguntas_frecuentes.png" alt="PREGUNTAS FRECUENTES" /></div>
			<?php
		}
		else if($__SEC == "como_funciona")
		{
			?>
			<div class="titulos_secciones"><img src="imagenes/titulos/como_funciona.png" alt="COMO FUNCIONA" /></div>
			<?php
		}
		else if($__SEC == "clientes")
		{
			?>
			<div class="titulos_secciones"><img src="imagenes/titulos/clientes.png" alt="CLIENTES" /></div>
			<?php
		}
		else if($__SEC == "sucursales")
		{
			?>
			<div class="titulos_secciones"><img src="imagenes/titulos/sucursales.png" alt="SUCURSALES" /></div>
			<?php
		}
		else if($__SEC == "contacto")
		{
			?>
			<div class="titulos_secciones"><img src="imagenes/titulos/contacto.png" alt="CONTACTO" /></div>
			<?php
		}
		else if($__SEC == "sumate")
		{
			?>
			<div class="titulos_secciones"><img src="imagenes/titulos/sumate.png" alt="SUMATE" /></div>
			<?php
		}
		else if($__SEC == "solicitud_credito")
		{
			?>
			<div class="titulos_secciones"><img src="imagenes/titulos/solicitud_credito.png" alt="SUMATE" /></div>
			<?php
		}
		else if($__SEC == "productos")
		{
			
		}
		?>
		<div class="contenedor_web">
			<?php @require_once("secciones/$__SEC.php"); ?>
		</div>
		<?php
		if(($__SEC == "home") || ($__SEC == ""))
		{
		?>
			<div id="logos_rotativos">
				<div id="makeMeScrollable">
					<?php
					include("secciones/script_opacidad.php");
					?>
					<div class="scrollWrapper">
						<div class="scrollableArea">
							<a href="?s=solicitud_credito_vale"><img src="imagenes/logos_slider/1.png" alt="" class="latest_img" width="201" height="112" /></a>
							<a href="?s=solicitud_credito_prestamos"><img src="imagenes/logos_slider/2.png" alt="" class="latest_img" width="241" height="112" /></a>
							<a href="?s=solicitud_credito_cuota"><img src="imagenes/logos_slider/3.png" alt="" class="latest_img" width="171" height="112" /></a>
							<a href="?s=solicitud_credito_jubilados"><img src="imagenes/logos_slider/4.png" alt="" class="latest_img" width="210" height="112" /></a>
							<a href="?s=solicitud_credito_tarjeta"><img src="imagenes/logos_slider/5.png" alt="" class="latest_img" width="203" height="112" /></a>
							<a href="?s=solicitud_credito_mujer"><img src="imagenes/logos_slider/6.png" alt="" class="latest_img" width="207" height="112" /></a>
							<a href="?s=solicitud_credito_monotributista"><img src="imagenes/logos_slider/7.png" alt="" class="latest_img" width="251" height="112" /></a>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>
		<div id="menu_pie">
			<a href="?s=home">HOME</a>
			| 
			<a href="?s=productos">PRODUCTOS</a>
			|
			<a href="?s=como_funciona">CÓMO FUNCIONA</a>
			|
			<a href="?s=preguntas_frecuentes">PREGUNTAS FRECUENTES</a>
			|
			<a href="?s=sucursales">SUCURSALES</a>
			|
			<a href="?s=contacto">CONTACTO</a>
			|
			<a href="?s=sumate">SUMATE</a>
		</div>
	</div>
	<br />
    
  <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M6SCS6"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M6SCS6');</script>
<!-- End Google Tag Manager -->
 

</body>
</html>