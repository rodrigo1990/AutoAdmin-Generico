<?php 

require_once("clases/BaseDatos.php");

$baseDatos = new BaseDatos();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ARGENPESOS</title>
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="fuentes/fuentes.css">
	<link rel="stylesheet" href="css/estilos.css">
	<link rel="stylesheet" href="makeItRain-master/makeItRain.css">
	<link rel="stylesheet" href="rangeslider.js-2.3.0/rangeslider.css">
</head>
<body>
	<section id="main">
	<div class="row" style="margin-right: 0 !important;">
                <div class="container-fluid">
                	
                	<img src="imagenes/separados-07.png" style="float:right;position:absolute;right:0;" alt="">
                </div>



<div class="col-lg-5 col-md-6 col sm-8" style="text-align:center">
<div style="text-align: left;">
		<a href="../index.php"><img src="../imagenes/logo.png" id="logo" class=""  alt=""></a>
		<img src="imagenes/separados-09.png" id="nubeSuperior"  class="decoracion"  alt="">
</div>
	<img src="imagenes/separados-08.png" class="" style="width: 73%;margin-left:5%" alt="">
	<img src="imagenes/billete-08.png" style="float:right" class="billete" style="float:left;margin-top:-15%" alt="">

	<div class="yellow-padding">
		<h3 >¡SUPER SIMPLE! <br>¡ÚNICO REQUISITO!</h3>
	</div>
	<img src="imagenes/billete-06.png" class="billete" style="float:left;margin-top:-15%" alt="">

	<div id="cobrarPorCuenta">
		<img src="imagenes/tilde.png" style="vertical-align:baseline" class="inline-block" alt="">
		<h3 class="inline-block">Cobrar por cuenta bancaria</h3>
		<p>Sueldo/Jubilaciones/Pensiones</p>	
	</div>
	<img src="imagenes/billete-05.png" class="billete" alt="">

	<img src="imagenes/billete-06.png" style="margin-left:40%" class="billete" alt="">

        <img src="imagenes/separados-05.png" id="mano" class="decoracion" style="float:left;position:absolute;left:0;" alt="">


	
	

</div><!-- col-lg-7 col-md-7 col sm-8 -->

<div class="col-lg-6 col-md-6 col-sm-12">
<form action="solicitud.php" method="POST" name="myForm" id="myForm">
	<div class="row no-margin">
		<h3 class="form-titles"><img src="imagenes/icono.png" alt="">¿Cuanto necesitas?</h3>
		<div><p style="float:left">$3.000</p><p style="float:right">$60.000</p></div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

				
		 		<input step="1.0" type="range" name="valor_monto" id="dinero" min="3000" max="60000" data-rangeslider>
		         <output></output>

		         <p class="text-center" style="font-size:2rem;">Tu ingreso neto en mano debe ser de $10.000</p>

		</div>
	</div>
		
		<div class="row no-margin">
			<h3 class="form-titles " style="margin-top: 0;"><img src="imagenes/icono.png" alt="">Datos personales:</h3>
			<div class="col-lg-6 col-md-6 col-sm-12  col-xs-12">

					<label for="nombre">Nombre</label><br>
					<input type="text" placeholder="Ej:Juan" name="nombre" class="form-control" id="nombre" style="">
	              <div class="error" id="nombre-error">*Ingrese un nombre valido</div>

			</div>
			<div class="col-lg-6 col-md-6 col-xs-12">
					<label for="apellido">Apellido</label><br>
					<input type="text" placeholder="Ej:Gomez" name="apellido" class="form-control" id="apellido">
					<div class="error" id="apellido-error">*Ingrese un apellido valido</div>
			</div>
		</div>
		<div class="row no-margin">
			<div class="col-lg-6 col-md-6 col-xs-12">
				<label for="dni">DNI (sin puntos)</label>
				<input type="text" name="dni" id="dni" class="form-control">
				<div class="error" id="dni-error">*Ingrese un dni valido</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12">
				<label for="sexo">Sexo</label><br>
				
				<input type="radio" value="Masculino" name="sexo" class="inline-block" checked>
				<p class="inline-block">Masculino</p>
				
				<input type="radio" value="Femenino" name="sexo" class="inline-block">
				<p class="inline-block">Femenino</p>
			</div>
		</div>
		<div class="row no-margin">
			<div class="col-lg-6 col-md-6 col-xs-12">
				<label for="codigo_area">Código de área </label>
				<select  name="codigo_area"  class="form-control">
					 <option>011</option>
                <option>220</option>
                <option>221</option>
                <option>223</option>
                <option>230</option>
                <option>236</option>
                <option>237</option>
                <option>249</option>
                <option>260</option>
                <option>261</option>
                <option>263</option>
                <option>264</option>
                <option>266</option>
                <option>280</option>
                <option>291</option>
                <option>294</option>
                <option>297</option>
                <option>298</option>
                <option>299</option>
                <option>336</option>
                <option>341</option>
                <option>342</option>
                <option>343</option>
                <option>345</option>
                <option>348</option>
                <option>351</option>
                <option>353</option>
                <option>358</option>
                <option>362</option>
                <option>364</option>
                <option>370</option>
                <option>376</option>
                <option>379</option>
                <option>380</option>
                <option>381</option>
                <option>383</option>
                <option>385</option>
                <option>387</option>
                <option>388</option>
                <option>2202</option>
                <option>2221</option>
                <option>2223</option>
                <option>2224</option>
                <option>2225</option>
                <option>2226</option>
                <option>2227</option>
                <option>2229</option>
                <option>2241</option>
                <option>2242</option>
                <option>2243</option>
                <option>2244</option>
                <option>2245</option>
                <option>2246</option>
                <option>2252</option>
                <option>2254</option>
                <option>2255</option>
                <option>2257</option>
                <option>2261</option>
                <option>2262</option>
                <option>2264</option>
                <option>2265</option>
                <option>2266</option>
                <option>2267</option>
                <option>2268</option>
                <option>2271</option>
                <option>2272</option>
                <option>2273</option>
                <option>2274</option>
                <option>2281</option>
                <option>2283</option>
                <option>2284</option>
                <option>2285</option>
                <option>2286</option>
                <option>2291</option>
                <option>2292</option>
                <option>2296</option>
                <option>2297</option>
                <option>2302</option>
                <option>2314</option>
                <option>2316</option>
                <option>2317</option>
                <option>2320</option>
                <option>2323</option>
                <option>2324</option>
                <option>2325</option>
                <option>2326</option>
                <option>2331</option>
                <option>2333</option>
                <option>2334</option>
                <option>2335</option>
                <option>2336</option>
                <option>2337</option>
                <option>2338</option>
                <option>2342</option>
                <option>2343</option>
                <option>2344</option>
                <option>2345</option>
                <option>2346</option>
                <option>2352</option>
                <option>2353</option>
                <option>2354</option>
                <option>2355</option>
                <option>2356</option>
                <option>2357</option>
                <option>2358</option>
                <option>2392</option>
                <option>2393</option>
                <option>2394</option>
                <option>2395</option>
                <option>2396</option>
                <option>2473</option>
                <option>2474</option>
                <option>2475</option>
                <option>2477</option>
                <option>2478</option>
                <option>2622</option>
                <option>2624</option>
                <option>2625</option>
                <option>2626</option>
                <option>2646</option>
                <option>2647</option>
                <option>2648</option>
                <option>2651</option>
                <option>2652</option>
                <option>2655</option>
                <option>2656</option>
                <option>2657</option>
                <option>2658</option>
                <option>2901</option>
                <option>2902</option>
                <option>2903</option>
                <option>2920</option>
                <option>2921</option>
                <option>2922</option>
                <option>2923</option>
                <option>2924</option>
                <option>2925</option>
                <option>2926</option>
                <option>2927</option>
                <option>2928</option>
                <option>2929</option>
                <option>2931</option>
                <option>2932</option>
                <option>2933</option>
                <option>2934</option>
                <option>2935</option>
                <option>2936</option>
                <option>2940</option>
                <option>2942</option>
                <option>2945</option>
                <option>2946</option>
                <option>2948</option>
                <option>2952</option>
                <option>2953</option>
                <option>2954</option>
                <option>2962</option>
                <option>2963</option>
                <option>2964</option>
                <option>2966</option>
                <option>2972</option>
                <option>2982</option>
                <option>2983</option>
                <option>3327</option>
                <option>3329</option>
                <option>3382</option>
                <option>3385</option>
                <option>3387</option>
                <option>3388</option>
                <option>3400</option>
                <option>3401</option>
                <option>3402</option>
                <option>3404</option>
                <option>3405</option>
                <option>3406</option>
                <option>3407</option>
                <option>3408</option>
                <option>3409</option>
                <option>3435</option>
                <option>3436</option>
                <option>3437</option>
                <option>3438</option>
                <option>3442</option>
                <option>3444</option>
                <option>3445</option>
                <option>3446</option>
                <option>3447</option>
                <option>3454</option>
                <option>3455</option>
                <option>3456</option>
                <option>3458</option>
                <option>3460</option>
                <option>3462</option>
                <option>3463</option>
                <option>3464</option>
                <option>3465</option>
                <option>3466</option>
                <option>3467</option>
                <option>3468</option>
                <option>3469</option>
                <option>3471</option>
                <option>3472</option>
                <option>3476</option>
                <option>3482</option>
                <option>3483</option>
                <option>3487</option>
                <option>3489</option>
                <option>3491</option>
                <option>3492</option>
                <option>3493</option>
                <option>3496</option>
                <option>3497</option>
                <option>3498</option>
                <option>3521</option>
                <option>3522</option>
                <option>3524</option>
                <option>3525</option>
                <option>3532</option>
                <option>3533</option>
                <option>3537</option>
                <option>3541</option>
                <option>3542</option>
                <option>3543</option>
                <option>3544</option>
                <option>3546</option>
                <option>3547</option>
                <option>3548</option>
                <option>3549</option>
                <option>3562</option>
                <option>3563</option>
                <option>3564</option>
                <option>3571</option>
                <option>3572</option>
                <option>3573</option>
                <option>3574</option>
                <option>3575</option>
                <option>3576</option>
                <option>3582</option>
                <option>3583</option>
                <option>3584</option>
                <option>3585</option>
                <option>3711</option>
                <option>3715</option>
                <option>3716</option>
                <option>3718</option>
                <option>3721</option>
                <option>3725</option>
                <option>3731</option>
                <option>3734</option>
                <option>3735</option>
                <option>3741</option>
                <option>3743</option>
                <option>3751</option>
                <option>3754</option>
                <option>3755</option>
                <option>3756</option>
                <option>3757</option>
                <option>3758</option>
                <option>3772</option>
                <option>3773</option>
                <option>3774</option>
                <option>3775</option>
                <option>3777</option>
                <option>3781</option>
                <option>3782</option>
                <option>3786</option>
                <option>3821</option>
                <option>3825</option>
                <option>3826</option>
                <option>3827</option>
                <option>3832</option>
                <option>3835</option>
                <option>3837</option>
                <option>3838</option>
                <option>3841</option>
                <option>3843</option>
                <option>3844</option>
                <option>3845</option>
                <option>3846</option>
                <option>3854</option>
                <option>3855</option>
                <option>3856</option>
                <option>3857</option>
                <option>3858</option>
                <option>3861</option>
                <option>3862</option>
                <option>3863</option>
                <option>3865</option>
                <option>3867</option>
                <option>3868</option>
                <option>3869</option>
                <option>3873</option>
                <option>3876</option>
                <option>3877</option>
                <option>3878</option>
                <option>3885</option>
                <option>3886</option>
                <option>3887</option>
                <option>3888</option>
                <option>3891</option>
                <option>3892</option>
                <option>3894</option>
					</select>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-12">
					<label for="dni">Teléfono celular </label>
					<input type="text" name="celular" id="celular" placeholder="Ej:46587925" class="form-control">
					<div class="error" id="celular-error">*Ingrese un celular valido</div>
				</div>
			</div>
			<div class="row no-margin">
				<div class="col-lg-12 col-md-12 col-xs-12">
					<label for="email">Email</label>
					<input type="text" name="mail" id="email" placeholder="Ej:Juangomez@gmail.com" class="form-control">
					<div class="error" id="mail-error">*Ingrese un email valido</div>
				</div>
			</div>
			<div class="row no-margin">
				<div class="col-lg-6 col-md-6 col-xs-12">
					<label for="provincia">Provincia </label>
					<select  name="provincia" id="provincia"  class="form-control">
						<option value="0">Seleccione</option>
						 <?php $baseDatos->listarProvincias(); ?>
					</select>
					<div class="error" id="provincia-error">*Ingrese una provincia</div>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-12">
					<label for="localidad">Localidad </label>
					<select  name="localidad" id="localidad"  class="form-control">
						<option value="0">Seleccione</option>
					</select>
					<div class="error" id="localidad-error">*Ingrese una localidad valida</div>
				</div>
			</div>
			<div class="row no-margin">
				<div class="col-lg-6 col-md-6 col-xs-12">
					<label for="banco">Banco donde depositan tu sueldo </label>
					<select  name="banco"  class="form-control">
						 <option value="no_poseo">No poseo cuenta bancaria</option>
		                <option value="nacion">Banco Naci&oacute;n</option>
		                <option value="patagonia">Banco Patagonia</option>
		                <option value="santander">Banco Santander R&iacute;o</option>
		                <option>Banco Ciudad</option>
		                <option>Banco Columbia</option>
		                <option>Banco Comafi</option>
		                <option>Banco Corrientes</option>
		                <option>Banco Credicoop</option>
		                <option>Banco de Formosa</option>
		                <option>Banco de La Pampa</option>
		                <option>Banco Provincia de Buenos Aires</option>
		                <option value="chubut">Banco Provincia de Chubut</option>
		                <option>Banco Provincia de C&oacute;rdoba</option>
		                <option>Banco Provincia de Neuqu&eacute;n</option>
		                <option>Banco de Tierra del Fuego</option>
		                <option>Banco Finansur</option>
		                <option>Banco Franc&eacute;s</option>
		                <option>Banco Galicia</option>
		                <option>Banco Hipotecario</option>
		                <option>Banco Ita&uacute;</option>
		                <option>Banco Industrial</option>
		                <option>Banco Macro</option>
		                <option>Banco Municipal de Rosario</option>
		                <option>Banco Piano</option>
		                <option>Banco Regional de Cuyo</option>
		                <option>Banco San Juan</option>
		                <option>Banco Santa Cruz</option>
		                <option>Banco Santa Fe</option>
		                <option>Banco de Santiago del Estero</option>
		                <option>Banco Supervielle</option>
		                <option>Banco Tucum&aacute;n</option>
		                <option>Banco Citibank</option>
		                <option>Banco HSBC</option>
		                <option>Nuevo Banco de Entre R&iacute;os</option>
		                <option>Nuevo Banco de la Rioja</option>
		                <option>Nuevo Banco del Chaco</option>
		                <option>Standard Bank /ICBC</option>
		                <option>OTRO</option>
					</select>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-12">
					<label for="empleador">Empleador </label>
					<select  name="empleador"  class="form-control">
						 <option>Asig. Universal por hijo</option>
		                <option>Cooperativa</option>
		                <option>Empleado Sector Público</option>
		                <option>Empleado Sector Privado</option>
		                <option>Autónomo/Monotributista</option>
		                <option>Jubilado/Pensionado</option>
		                <option>Sin Empleo</option>
					</select>
				</div>
			</div>
			<div class="row no-margin">
				<div class="col-lg-6 col-md-6 col-xs-12">

					<input type="radio" value="aceptado" id="terminos" name="terminos" class="inline-block">
					<p class="inline-block">Aceptos los terminos y condiciones</p>
					<div class="error" id="terminos-error">*Acepte los terminos</div>
				</div>
				
				<div class="col-lg-6 col-md-6 col-xs-12">
					
					<a value="ENVIAR SOLICITUD" id="btn_enviar" style="cursor:pointer" onClick="myFunction();">ENVIAR SOLICITUD </a>
					
				</div>
			</div>	
			<div class="row no-margin">
			
				<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
			<div class="error" id="captcha-error">*Valide el captcha</div>
				</div>
			</div>
	</form>



</div>
</div>

</section>

<section id="pasos">

<div class="row pasos" style="padding-bottom: 5%;">
	
<!--  <img src="imagenes/separados-05.png" id="mano" class="decoracion" style="float:left;position:absolute;left:0;    top: 70%;" alt="">-->
<h2 class="text-center">En sólo 4 pasos</h2>
<div class="container">
	<div class="col-lg-3 col-md-3 col-sm-6">
		<div class="img-cont text-center">
			<h3>1.</h3>
			<img src="imagenes/paso-01.png" alt="">
			<h5>Completá el formulario</h5>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6">
		<div class="img-cont text-center">
			<h3>2.</h3>
			<img src="imagenes/paso-02.png" alt="">
			<h5>Te contactamos en el dia para que nos envies la documentacion online</h5>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6">
		<div class="img-cont text-center">
			<h3>3.</h3>
			<img src="imagenes/paso-03.png" alt="">
			<h5>Una vez analizada la solicitud te envíamos donde desees el legajo para firmar</h5>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6">
		<div class="img-cont text-center">
			<h3>4.</h3>
			<img src="imagenes/paso-04.png" alt="">
			<h5>Te depositamos el dinero en el día</h5>
		</div>
	</div>
</div>
<img src="imagenes/separados.png" style="float:right;position:absolute;right:0;    margin-top: -11%;" id="nube-down" class="decoracion" alt="">

</div>
<div class="container">
<div class="row credito-ahora">

	<div class="col-lg-12 text-center">
		<h1 class="red-border">PRE-APROBÁ TU CRÉDITO AHORA</h1>
	</div>
</div>
</div>



	</section>

	<footer>
		<div class="row" style="margin-top: 2%;">
			<div class="container-fluid">
				<div class="col-lg-12">
				<p>Préstamos personales con cuotas ﬁjas y en pesos. Otorgamos máximo $60.000 y mínimo $3.000 en un plazo máximo de 24 meses y un mínimo de 6 meses. El efectivo otorgamiento del préstamo y sus condiciones se encuentran sujetos a veriﬁcación del departamento o de análisis de riesgo crediticio. Tasa nominal anual (TNA): mínima 163,59%, máxima 235,41%. Ejemplo de préstamo: Te damos ·10.000 en 12 cuotas y nos devolvés $1.830 por mes. Tasa efectiva anual (TEA) : mínima: 411,53%, máxima: 503,55%.</p> <br>
				<h4>CFTNA: 198,59%.</h4>
				</div>
			</div>
		</div>

	</footer>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src=makeItRain-master/makeItRain.js></script>
<script  src="rangeslider.js-2.3.0/rangeslider.js"></script>
<script src="rangeslider.js-2.3.0/rangesliderFunctions.js"></script>
<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
<script>
    $("#provincia").change(function(){

             var provincia = $("#provincia option:selected").val();

            $.ajax({
            data:"provincia="+ provincia,
            url:'ajax/buscarCiudadSegunProvincia.php',
            type:'post',
            success:function(response){
            $("#localidad").html(response);


            }
            });
    });

</script>
<script>
function myFunction() {

                var emailValido=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var soloLetrasSinEspacios=/^[a-zA-Z]*$/;
                var soloNumeros=/^[0-9]*$/;
                var soloLetrasEspaciosYNumeros=/^[a-zA-Z0-9\s]+$/;

                var nombre_esta_validado=false;
                var apellido_esta_validado=false;
                var dni_esta_validado=false;
                var celular_esta_validado=false;
                var email_esta_validado=false;
                var provincia_esta_validado=false;
                var localidad_esta_validado=false;
                var terminos_esta_validado=false;
                var captcha_esta_validado=false;

                var nombre=$("#nombre").val();
                var apellido=$("#apellido").val();
                var dni=$("#dni").val();
                var celular=$("#celular").val();
                var email=$("#email").val();
                var localidad=$("#localidad").val();
                var provincia=$("#provincia").val();
                var terminos=$("#terminos").val();

                if(nombre.length<4||nombre.search(soloLetrasSinEspacios)){

                    $("#nombre-error").css("display","block ");
                    nombre_esta_validado=false;

                }else{

                    $("#nombre-error").css("display","none");
                    nombre_esta_validado=true;

                }
                 if(apellido.length<3||nombre.search(soloLetrasSinEspacios)){

                    $("#apellido-error").css("display","block");
                    apellido_esta_validado=false;

                }else{

                    $("#apellido-error").css("display","none");
                    apellido_esta_validado=true;

                }
                 if(dni.length<3||dni.search(soloNumeros)){

                    $("#dni-error").css("display","block");
                    dni_esta_validado=false;

                }else{

                    $("#dni-error").css("display","none");
                    dni_esta_validado=true;

                }
                if(celular.length<3||celular.search(soloNumeros)){

                    $("#celular-error").css("display","block");
                    celular_esta_validado=false;


                }else{

                    $("#celular-error").css("display","none");
                    celular_esta_validado=true;

                }
                 if(email.length<3||email.search(emailValido)){

                    $("#mail-error").css("display","block");
                    email_esta_validado=false;                    

                }else{
                    $("#mail-error").css("display","none");
                    email_esta_validado=true;

                }

                if(provincia==0){

                    $("#provincia-error").css("display","block");
                    provincia_esta_validado=false;

                }else{

                    $("#provincia-error").css("display","none");
                    provincia_esta_validado=true;
                }

                 if(localidad==0){

                    $("#localidad-error").css("display","block");
                    localidad_esta_validado=false;

                }else{

                    $("#localidad-error").css("display","none");
                    localidad_esta_validado=true;
                }

                if(!$('input[name=terminos]:checked').val() ){
                	$("#terminos-error").css("display","block");
                    terminos_esta_validado=false;
                }else{
                	$("#terminos-error").css("display","none");
                    terminos_esta_validado=true;
                }


                if (grecaptcha.getResponse() == ""){
                    $("#captcha-error").css("display","block");
                    captcha_esta_validado=false;
                } else {
                    $("#captcha-error").css("display","none");
                    captcha_esta_validado=true;
                    
                }

                if(nombre_esta_validado==true && apellido_esta_validado==true &&
                    dni_esta_validado==true && celular_esta_validado==true && email_esta_validado==true && provincia_esta_validado==true && localidad_esta_validado==true && terminos_esta_validado==true && captcha_esta_validado==true ){

                    	document.getElementById("myForm").submit();

                }

                

        
        
    }
    </script>
</body>
</html>