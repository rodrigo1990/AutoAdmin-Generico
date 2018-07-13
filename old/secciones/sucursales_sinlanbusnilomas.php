<script>
	$(function()
	{
		$("#capital_federal").click(function() 
		{
			$('#capital_federal_sec').css('display', 'inline');
			//$('#capital_federal').css('color', '#FF2B00');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#varela").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'inline');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#solano").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'inline');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#berazategui").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'inline');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#sanmiguel").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'inline');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#sanjusto").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'inline');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'none');
		})
		$("#sanfernando").click(function() 
		{
			$('#capital_federal_sec').css('display', 'none');
			$('#varela_sec').css('display', 'none');
			$('#solano_sec').css('display', 'none');
			$('#berazategui_sec').css('display', 'none');
			$('#sanmiguel_sec').css('display', 'none');
			$('#sanjusto_sec').css('display', 'none');
			$('#sanfernando_sec').css('display', 'inline');
		})
	});
	
	$(function(){
		$("#lista_produccion_capital a").mouseover(function()
		{
			$("#foto_derecha_capital img").attr('src', 'imagenes/sucursales/capital/'+$(this).attr('id')+'.jpg');
		})  
		$("#lista_produccion_varela a").mouseover(function()
		{
			$("#foto_derecha_varela img").attr('src', 'imagenes/sucursales/varela/'+$(this).attr('id')+'.jpg');
		})  
		$("#lista_produccion_solano a").mouseover(function()
		{
			$("#foto_derecha_solano img").attr('src', 'imagenes/sucursales/solano/'+$(this).attr('id')+'.jpg');
		})  
		$("#lista_produccion_berazategui a").mouseover(function()
		{
			$("#foto_derecha_berazategui img").attr('src', 'imagenes/sucursales/berazategui/'+$(this).attr('id')+'.jpg');
		})  
		$("#lista_produccion_sanjusto a").mouseover(function()
		{
			$("#foto_derecha_sanjusto img").attr('src', 'imagenes/sucursales/sanjusto/'+$(this).attr('id')+'.jpg');
		})  
		$("#lista_produccion_sanmiguel a").mouseover(function()
		{
			$("#foto_derecha_sanmiguel img").attr('src', 'imagenes/sucursales/san_miguel/'+$(this).attr('id')+'.jpg');
		})  
		$("#lista_produccion_sanfernando a").mouseover(function()
		{
			$("#foto_derecha_sanfernando img").attr('src', 'imagenes/sucursales/san_fernando/'+$(this).attr('id')+'.jpg');
		})  
	});

	$(function() 
	{
		$(".latest_img2").css("opacity","1.0");

		// ON MOUSE OVER
		$(".latest_img2").hover(function () 
		{
			$(this).stop().animate({
			opacity: 0.7
			}, "fast");
		},
		// ON MOUSE OUT
		function () 
		{
			$(this).stop().animate({
			opacity: 1.0
			}, "fast");
		});
	});
</script>

<br /><br />
<div class="contiene_sucursal">
<div id="menu_puntos_de_venta">
	<div class="item_menu"><a id="capital_federal">CAPITAL FEDERAL</a></div>
	<div class="item_menu" style="width: 100px;"><a id="varela">VARELA</a></div>
	<div class="item_menu" style="width: 100px;"><a id="solano">SOLANO</a></div>
	<div class="item_menu" style="width: 140px;"><a id="berazategui">BERAZATEGUI</a></div>
	<div class="item_menu"><a id="sanjusto">SAN JUSTO</a></div>
	<div class="item_menu" style="width: 130px;"><a id="sanmiguel">SAN MIGUEL</a></div>
	<div class="item_menu" style="border-right: 0px;"><a id="sanfernando">SAN FERNANDO</a></div>
</div>

<div id="capital_federal_sec">
	<div class="titulos_puntos_de_venta">CAPITAL FEDERAL <a>Reconquista 660 / Tel: 4510-6554 / 71</a></div>
	<div class="izquierda_puntos_de_venta">
		<iframe width="419" height="233" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Reconquista+660+capital+federal&amp;aq=&amp;sll=-34.578528,-58.419735&amp;sspn=0.010194,0.022724&amp;ie=UTF8&amp;hq=&amp;hnear=Reconquista+660,+San+Nicol%C3%A1s,+Ciudad+Aut%C3%B3noma+de+Buenos+Aires,+Argentina&amp;ll=-34.600174,-58.372654&amp;spn=0.005096,0.011362&amp;z=15&amp;output=embed"></iframe><br /><small>Ver <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=Reconquista+660+capital+federal&amp;aq=&amp;sll=-34.578528,-58.419735&amp;sspn=0.010194,0.022724&amp;ie=UTF8&amp;hq=&amp;hnear=Reconquista+660,+San+Nicol%C3%A1s,+Ciudad+Aut%C3%B3noma+de+Buenos+Aires,+Argentina&amp;ll=-34.600174,-58.372654&amp;spn=0.005096,0.011362&amp;z=14" target="_blank" style="color:#0000FF;text-align:left">Av Santa Fe 4386</a> en un mapa más grande</small>
	</div>
	<div class="derecha_puntos_de_venta">
		<div class="miniaturas_puntos_de_venta" id="lista_produccion_capital" style="float: left;">
			<a id="capital_2" ><img src="imagenes/sucursales/capital/2.jpg" alt="2" class="latest_img2" /></a>
			<a id="capital_3" ><img src="imagenes/sucursales/capital/3.jpg" alt="3" class="latest_img2" /></a>
		</div>
		<div style="float: right;" id="foto_derecha_capital">
			<img src="imagenes/sucursales/capital/capital_2.jpg" alt="foto grande" />
		</div>
	</div>
</div>

<div id="varela_sec" style="display: none;">
	<div class="titulos_puntos_de_venta">VARELA <a>Monteagudo 345 / Tel: 4287-8567</a></div>
	<div class="izquierda_puntos_de_venta">
		<iframe width="419" height="233" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es&amp;q=Bernardo+de+Monteagudo,+Florencio+Varela,+Buenos+Aires,+Argentina&amp;aq=&amp;sll=-34.600989,-58.372325&amp;sspn=0.005096,0.011362&amp;ie=UTF8&amp;geocode=FcTv7P0d_suG_A&amp;split=0&amp;hq=&amp;hnear=Bernardo+de+Monteagudo,+Florencio+Varela,+Buenos+Aires,+Argentina&amp;z=15&amp;ll=-34.803772,-58.274818&amp;output=embed"></iframe><br /><small>Ver <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=es&amp;q=Bernardo+de+Monteagudo,+Florencio+Varela,+Buenos+Aires,+Argentina&amp;aq=&amp;sll=-34.600989,-58.372325&amp;sspn=0.005096,0.011362&amp;ie=UTF8&amp;geocode=FcTv7P0d_suG_A&amp;split=0&amp;hq=&amp;hnear=Bernardo+de+Monteagudo,+Florencio+Varela,+Buenos+Aires,+Argentina&amp;z=14&amp;ll=-34.803772,-58.274818" style="color:#0000FF;text-align:left" target="_blank">Av Santa Fe 4386</a> en un mapa más grande</small>
	</div>
	<div class="derecha_puntos_de_venta">
		<div class="miniaturas_puntos_de_venta" id="lista_produccion_varela" style="float: left;">
			<a id="varela_1" ><img src="imagenes/sucursales/varela/1.jpg" alt="1" class="latest_img2" /></a>
			<a id="varela_2" ><img src="imagenes/sucursales/varela/2.jpg" alt="2" class="latest_img2" /></a>
		</div>
		<div style="float: right;" id="foto_derecha_varela">
			<img src="imagenes/sucursales/varela/varela_1.jpg" alt="foto grande" />
		</div>
	</div>
</div>

<div id="solano_sec" style="display: none;">
	<div class="titulos_puntos_de_venta">SOLANO <a>Av. 845 Nº 2590 / Tel: 4212-6770 / 7174</a></div>
	<div class="izquierda_puntos_de_venta">
		<iframe width="419" height="233" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com.ar/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=m+palanca+845+solano&amp;aq=&amp;sll=-34.769485,-58.297405&amp;sspn=0.011581,0.026329&amp;ie=UTF8&amp;hq=&amp;hnear=M.+Palanca+845,+Villa+La+Florida,+Buenos+Aires&amp;ll=-34.769485,-58.297405&amp;spn=0.011581,0.026329&amp;z=15&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com.ar/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=m+palanca+845+solano&amp;aq=&amp;sll=-34.769485,-58.297405&amp;sspn=0.011581,0.026329&amp;ie=UTF8&amp;hq=&amp;hnear=M.+Palanca+845,+Villa+La+Florida,+Buenos+Aires&amp;ll=-34.769485,-58.297405&amp;spn=0.011581,0.026329&amp;z=14" style="color:#0000FF;text-align:left">Ver mapa más grande</a></small>
	</div>
	<div class="derecha_puntos_de_venta">
		<div class="miniaturas_puntos_de_venta" id="lista_produccion_solano" style="float: left;">
			<a id="solano_1" ><img src="imagenes/sucursales/solano/1.jpg" alt="1" class="latest_img2" /></a>
			<a id="solano_2" ><img src="imagenes/sucursales/solano/2.jpg" alt="2" class="latest_img2" /></a>
			<a id="solano_3" ><img src="imagenes/sucursales/solano/3.jpg" alt="3" class="latest_img2" /></a>
		</div>
		<div style="float: right;" id="foto_derecha_solano">
			<img src="imagenes/sucursales/solano/solano_1.jpg" alt="foto grande" />
		</div>
	</div>
</div>

<div id="berazategui_sec" style="display: none;">
	<div class="titulos_puntos_de_venta">BERAZATEGUI <a>Av. 14 nº5022 / Tel: 4356-0717 / 0911</a></div>
	<div class="izquierda_puntos_de_venta">
		<iframe width="419" height="233" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Av.+14+5022+berazategui&amp;aq=&amp;sll=-34.813923,-58.243725&amp;sspn=0.010165,0.022724&amp;ie=UTF8&amp;hq=&amp;hnear=Calle+14+5022,+Berazategui,+Buenos+Aires,+Argentina&amp;z=15&amp;ll=-34.760521,-58.20679&amp;output=embed"></iframe><br /><small>Ver <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=Av.+14+5022+berazategui&amp;aq=&amp;sll=-34.813923,-58.243725&amp;sspn=0.010165,0.022724&amp;ie=UTF8&amp;hq=&amp;hnear=Calle+14+5022,+Berazategui,+Buenos+Aires,+Argentina&amp;z=14&amp;ll=-34.760521,-58.20679" style="color:#0000FF;text-align:left" target="_blank">Av Santa Fe 4386</a> en un mapa más grande</small>
	</div>
	<div class="derecha_puntos_de_venta">
		<div class="miniaturas_puntos_de_venta" id="lista_produccion_berazategui" style="float: left;">
			<a id="berazategui_1" ><img src="imagenes/sucursales/berazategui/1.jpg" alt="1" class="latest_img2" /></a>
			<a id="berazategui_3" ><img src="imagenes/sucursales/berazategui/3.jpg" alt="3" class="latest_img2" /></a>
		</div>
		<div style="float: right;" id="foto_derecha_berazategui">
			<img src="imagenes/sucursales/berazategui/berazategui_1.jpg" alt="foto grande" />
		</div>
	</div>
</div>

<div id="sanjusto_sec" style="display: none;">
	<div class="titulos_puntos_de_venta">SAN JUSTO <a>Dr. Ignacio Arieta 3496 / Tel: 4651-0046</a></div>
	<div class="izquierda_puntos_de_venta">
		<iframe width="419" height="233" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.ar/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Dr.+Ignacio+Arieta+3496,+san+justo&amp;aq=&amp;sll=-37.151895,-60.029182&amp;sspn=16.246122,38.737793&amp;ie=UTF8&amp;hq=&amp;hnear=Av+Dr.+Ignacio+Arieta+3496,+San+Justo,+Buenos+Aires&amp;t=m&amp;z=14&amp;ll=-34.68176,-58.556452&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com.ar/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=Dr.+Ignacio+Arieta+3496,+san+justo&amp;aq=&amp;sll=-37.151895,-60.029182&amp;sspn=16.246122,38.737793&amp;ie=UTF8&amp;hq=&amp;hnear=Av+Dr.+Ignacio+Arieta+3496,+San+Justo,+Buenos+Aires&amp;t=m&amp;z=14&amp;ll=-34.68176,-58.556452" style="color:#0000FF;text-align:left">Ver mapa más grande</a></small>
	</div>
	<div class="derecha_puntos_de_venta">
		<div class="miniaturas_puntos_de_venta" id="lista_produccion_sanjusto" style="float: left;">
			<a id="sanjusto_1" ><img src="imagenes/sucursales/sanjusto/1.jpg" alt="1" class="latest_img2" /></a>
			<a id="sanjusto_2" ><img src="imagenes/sucursales/sanjusto/2.jpg" alt="1" class="latest_img2" /></a>
		</div>
		<div style="float: right;" id="foto_derecha_sanjusto">
			<img src="imagenes/sucursales/sanjusto/sanjusto_1.jpg" alt="foto grande" />
		</div>
	</div>
</div>

<div id="sanmiguel_sec" style="display: none;">
	<div class="titulos_puntos_de_venta">SAN MIGUEL <a>Av. Mitre Nº 1302 / Tel: 4451-5925 / 5787</a></div>
	<div class="izquierda_puntos_de_venta">
		<iframe width="419" height="233" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Av++Mitre+1302+san+miguel&amp;aq=&amp;sll=-34.543113,-58.71283&amp;sspn=0.010198,0.022724&amp;ie=UTF8&amp;hq=&amp;hnear=Av+Ricardo+Balb%C3%ADn+1302,+San+Miguel,+Buenos+Aires,+Argentina&amp;z=15&amp;ll=-34.543113,-58.71283&amp;output=embed"></iframe><br /><small>Ver <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=Av++Mitre+1302+san+miguel&amp;aq=&amp;sll=-34.543113,-58.71283&amp;sspn=0.010198,0.022724&amp;ie=UTF8&amp;hq=&amp;hnear=Av+Ricardo+Balb%C3%ADn+1302,+San+Miguel,+Buenos+Aires,+Argentina&amp;z=14&amp;ll=-34.543113,-58.71283" style="color:#0000FF;text-align:left" target="_blank">Av Santa Fe 4386</a> en un mapa más grande</small>
	</div>
	<div class="derecha_puntos_de_venta">
		<div class="miniaturas_puntos_de_venta" id="lista_produccion_sanmiguel" style="float: left;">
			<a id="san_miguel_1" ><img src="imagenes/sucursales/san_miguel/1.jpg" alt="1" class="latest_img2" /></a>
		</div>
		<div style="float: right;" id="foto_derecha_sanmiguel">
			<img src="imagenes/sucursales/san_miguel/san_miguel_1.jpg" alt="foto grande" />
		</div>
	</div>
</div>

<div id="sanfernando_sec" style="display: none;">
	<div class="titulos_puntos_de_venta">SAN FERNANDO <a>Las Heras 1210 / Tel: 4506-3730 / 3732</a></div>
	<div class="izquierda_puntos_de_venta">
		<iframe width="419" height="233" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Las+Heras+1210+san+fernando&amp;aq=&amp;sll=-34.543113,-58.71283&amp;sspn=0.010198,0.022724&amp;ie=UTF8&amp;hq=&amp;hnear=Las+Heras+1210,+San+Fernando,+Buenos+Aires,+Argentina&amp;z=15&amp;ll=-34.435115,-58.564409&amp;output=embed"></iframe><br /><small>Ver <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=Las+Heras+1210+san+fernando&amp;aq=&amp;sll=-34.543113,-58.71283&amp;sspn=0.010198,0.022724&amp;ie=UTF8&amp;hq=&amp;hnear=Las+Heras+1210,+San+Fernando,+Buenos+Aires,+Argentina&amp;z=14&amp;ll=-34.435115,-58.564409" style="color:#0000FF;text-align:left" target="_blank">Av Santa Fe 4386</a> en un mapa más grande</small>
	</div>
	<div class="derecha_puntos_de_venta">
		<div class="miniaturas_puntos_de_venta" id="lista_produccion_sanfernando" style="float: left;">
			<a id="san_fernando_1" ><img src="imagenes/sucursales/san_fernando/1.jpg" alt="1" class="latest_img2" /></a>
		</div>
		<div style="float: right;" id="foto_derecha_sanfernando">
			<img src="imagenes/sucursales/san_fernando/san_fernando_1.jpg" alt="foto grande" />
		</div>
	</div>
</div>

<div class="clear"></div>
</div>
<br /><br />
<?php include('secciones/pedilo_ahora.php'); ?>