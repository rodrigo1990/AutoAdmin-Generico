<script>
	$(document).ready(function ()
	{    
		$("#producto1").mouseover(function() 
		{
			$('#producto1').animate({ backgroundColor: "#37A8DB" }, 100).animate({ backgroundColor: "#137CA0" }, 100);
		}).mouseout(function(){
			$('#producto1').animate({ backgroundColor: "#137CA0" }, 100).animate({ backgroundColor: "#37A8DB" }, 100);
		});
		
		$("#producto2").mouseover(function() 
		{
			$('#producto2').animate({ backgroundColor: "#F6CE1C" }, 100).animate({ backgroundColor: "#EABD00" }, 100);
		}).mouseout(function(){
			$('#producto2').animate({ backgroundColor: "#EABD00" }, 100).animate({ backgroundColor: "#F6CE1C" }, 100);
		});
		
		$("#producto3").mouseover(function() 
		{
			$('#producto3').animate({ backgroundColor: "#E64E13" }, 100).animate({ backgroundColor: "#D63707" }, 100);
		}).mouseout(function(){
			$('#producto3').animate({ backgroundColor: "#D63707" }, 100).animate({ backgroundColor: "#E64E13" }, 100);
		});
		
		$("#producto4").mouseover(function() 
		{
			$('#producto4').animate({ backgroundColor: "#DF007A" }, 100).animate({ backgroundColor: "#C40276" }, 100);
		}).mouseout(function(){
			$('#producto4').animate({ backgroundColor: "#C40276" }, 100).animate({ backgroundColor: "#DF007A" }, 100);
		});
		
		$("#producto5").mouseover(function() 
		{
			$('#producto5').animate({ backgroundColor: "#0070B7" }, 100).animate({ backgroundColor: "#005B89" }, 100);
		}).mouseout(function(){
			$('#producto5').animate({ backgroundColor: "#005B89" }, 100).animate({ backgroundColor: "#0070B7" }, 100);
		});
		
		$("#producto6").mouseover(function() 
		{
			$('#producto6').animate({ backgroundColor: "#4D2581" }, 100).animate({ backgroundColor: "#2B0960" }, 100);
		}).mouseout(function(){
			$('#producto6').animate({ backgroundColor: "#2B0960" }, 100).animate({ backgroundColor: "#4D2581" }, 100);
		});
		
		$("#producto7").mouseover(function() 
		{
			$('#producto7').animate({ backgroundColor: "#75AB25" }, 100).animate({ backgroundColor: "#568700" }, 100);
		}).mouseout(function(){
			$('#producto7').animate({ backgroundColor: "#568700" }, 100).animate({ backgroundColor: "#75AB25" }, 100);
		});
	});
</script>
<div id="producto1">
	<a href="?s=solicitud_credito_vale"><img src="imagenes/productos/1.png" alt="" /></a>
</div>
<div id="producto2">
	<a href="?s=solicitud_credito_monotributista"><img src="imagenes/productos/2.png" alt="" /></a>
</div>
<div id="producto3">
	<a href="?s=solicitud_credito_prestamos"><img src="imagenes/productos/3.png" alt="" /></a>
</div>
<div id="producto4">
	<a href="?s=solicitud_credito_mujer"><img src="imagenes/productos/4.png" alt="" /></a>
</div>
<div id="producto5">
	<a href="?s=solicitud_credito_tarjeta"><img src="imagenes/productos/5.png" alt="" /></a>
</div>
<div id="producto6">
	<a href="?s=solicitud_credito_cuota"><img src="imagenes/productos/6.png" alt="" /></a>
</div>
<div id="producto7">
	<a href="?s=solicitud_credito_jubilados"><img src="imagenes/productos/7.png" alt="" /></a>
</div>
<div style="text-align: center;">
	<br />
	<img src="imagenes/productos/aprobacion.png" alt="" />
</div>
<br /><br /><br />
<?php include('secciones/pedilo_ahora.php'); ?>