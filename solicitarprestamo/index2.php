<?php
//error_reporting(0);
require_once("clases/BaseDatos.php");

$baseDatos = new BaseDatos();

/*
if($_SERVER["HTTPS"] != "on")
{
  header("Location: https://www.argenpesos.com.ar/solicitarprestamo/index.php"); 
  exit();
}
*/
?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ArgenPesos</title>
    <meta name="Keywords" content="">
    <meta name="Description" content=""/>

    <link rel="icon" type="image/png" href="imagenes/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="imagenes/favicon-16x16.png" sizes="16x16" />

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/queries.css" rel="stylesheet">
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">

    <script src="js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js?hl=es'></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99131822-4', 'auto');
  ga('send', 'pageview');

</script>
<style>
    .error{
        color:red;
        display:none;
    }
</style>
  </head>
  
  <body>


  <div id="contanedor">

    <div class="col-sm-6" id="izquierda_form">
      <div id="logo"><img src="imagenes/logo.png" alt="" /></div>
      <img src="imagenes/globo1.png" alt="" id="globo1" />
      <div class="row">
        <div class="col-sm-7"><span>&iexcl;REQUISITO &Uacute;NICO! <i class="fa fa-check" aria-hidden="true"></i></span></div>
        <div class="col-sm-5">
          Cobrar por cuenta bancaria<br />
          <i>Sueldo / Jubilaciones / Pensiones</i>
        </div>
      </div>

    </div>
    <div class="col-sm-6" id="derecha_form">
      <form action="solicitud.php" method="post" name="myForm" id="myForm" >
      <div class="titulos"><i class="fa fa-chevron-right" aria-hidden="true"></i> MONTO SOLICITADO:</div>

      <input type="number" name="valor_monto" class="input_form" id="monto" min="0" placeholder="Ingrese el monto:" id="monto"  />
      <div class="error" id="monto-error">Ingrese un monto</div>


      <hr />
      <div class="titulos"><i class="fa fa-chevron-right" aria-hidden="true"></i> DATOS PERSONALES:</div>

      <div id="form">
          <div class="row">
            <div class="col-sm-6">
              <label>Nombre</label><br />
              <input type="text" name="nombre" class="input_form" id="nombre" placeholder="Ej: Juan"  />
              <div class="error" id="nombre-error">Ingrese un nombre valido</div>
            </div>
            <div class="col-sm-6">
              <label>Apellido</label><br />
              <input type="text" name="apellido" class="input_form" id="apellido" placeholder="Ej. Gomez"  />
              <div class="error" id="apellido-error">Ingrese un apellido valido</div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <label>DNI</label><br />
              <input type="number" name="dni" class="input_form" id="dni" placeholder="Ej: 33952789"  />
              <div class="error" id="dni-error">Ingrese un dni valido</div>
            </div>
            <div class="col-sm-6">
              <label>Sexo</label><br />
              <input type="radio" name="sexo" value="Masculino"  class="sexo" checked /> Masculino <input type="radio" name="sexo"  class="sexo" value="Femenino" style="margin-left: 20px;" /> Femenino
              <div class="error" id="sexo-error"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <label>C&oacute;digo de &aacute;rea</label><br />
              <select name="codigo_area" id="codigo_area" class="input_form">
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
            <div class="col-sm-6">
              <label>Tel&eacute;fono celular</label><br />
              <input type="text" name="celular" class="input_form" id="celular" placeholder="Ej. 36969898"  />
              <div class="error" id="celular-error">Ingrese un celular valido</div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <label>Email</label><br />
              <input type="email" name="mail" class="input_form" id="email" placeholder="Ej. juangomez@gmail.com"  />
              <div class="error" id="mail-error">Ingrese un email valido</div>
            </div>
          </div>
            <div class="row">
                    
              <div class="col-sm-6">
                
                  <label>Provincia</label><br />

                  <select  name="provincia" class="input_form" id="provincia" >
                    <option value="0">Seleccione una provincia</option>
                        <?php $baseDatos->listarProvincias(); ?>

                  </select>

                  <div class="error" id="provincia-error">Ingrese una provincia</div>

            </div>

             <div class="col-sm-6">

              <label>Localidad</label><br />

              <select name="localidad" class="input_form" id="localidad">
                <option value="0">Seleccione una localidad</option>
              </select>

              <div class="error" id="localidad-error">Ingrese una localidad valida</div>

            </div>

            </div>
          <div class="row">
           
            <div class="col-sm-12">
              <label>Empleador</label><br />
              <select name="empleador" class="input_form">
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

          <div class="row">
            <div class="col-sm-12">
              <label>Banco donde depositan tu sueldo</label><br />
              <select name="banco" class="input_form">
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
        </div>

        <hr/>

        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                <div class="error" id="captcha-error">Valide el captcha</div>

            </div>
          <div class="col-lg-6 col-sm-12 text-right">
            <a value="ENVIAR SOLICITUD" id="btn_enviar" style="cursor:pointer" onClick="myFunction();">ENVIAR SOLICITUD </a>
          </div>
        </div>

      </form>
      </div>

    </div>

    <div class="clearfix"></div>
  </div>

  <div id="pasos">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>PRÉSTAMOS<br /><span>EN 4 SIMPLES PASOS</span></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <img src="imagenes/pasos/1.png" alt="" class="iconos_pasos" /><br />
                Completa el formulario online
            </div>
            <div class="col-sm-3">
                <img src="imagenes/pasos/2.png" alt="" class="iconos_pasos" /><br />
                Te contactamos en el mismo día para que nos envíes la documentación online
            </div>
            <div class="col-sm-3">
                <img src="imagenes/pasos/3.png" alt="" class="iconos_pasos" /><br />
                Una vez analizada la solicitud te enviamos a donde desees el legajo para firmar
            </div>
            <div class="col-sm-3">
                <img src="imagenes/pasos/4.png" alt="" class="iconos_pasos" /><br />
                Te depositamos el dinero en el día
            </div>
        </div>
    </div>

  </div>
  <div id="franja_preaproba">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 linea_pasos"></div>
            <div class="col-sm-6">PRE-APROBÁ TU CRÉDITO AHORA!</div>
            <div class="col-sm-3 linea_pasos"></div>
        </div>
    </div>
  </div>


  <div id="legales">
    Pr&eacute;stamos personales con cuotas fijas y en pesos. Otorgamos m&aacute;ximo $100.000 y m&iacute;nimo $3.000 en un plazo m&aacute;ximo de 24 meses y un m&iacute;nimo de 6 meses. El efectivo otorgamiento del pr&eacute;stamo y sus condiciones se encuentran sujetos a verificaci&oacute;n del departamento de an&aacute;lisis de riesgo crediticio. Tasa nominal anual (TNA): m&iacute;nima 163,59%, m&aacute;xima 235,41%. Ejemplo de pr&eacute;stamo: Te damos $10.000 en 12 cuotas y nos devolv&eacute;s $1.830 por mes. Tasa efectiva anual (TEA): m&iacute;nima: 411,53 %, m&aacute;xima: 503,55%. <br />
    <font style="font-size: 18px;">CFTNA: 198,59%.</font>
    </div>

    <div id="terminos_condiciones" style="width:100%; max-width: 800px; display: none;">
        <h3>Condiciones Generales</h3>
        <p>
            1- Incurrir&eacute; en mora si no abono cualquiera de las cuotas en el tiempo y forma acordado. El lugar de pago de las cuotas ser&aacute; el domicilio del acreedor (Argencred S.A.) Reconquista 660, PB CABA, cualquiera de sus sucursales o entidades habilitadas para tal fin, seg&uacute;n me fueron  informadas oportunamente, junto con todas las condiciones de esta operaci&oacute;n.<br />
            2- En virtud de la fecha cierta de vencimiento de cada obligaci&oacute;n bajo el cr&eacute;dito que declaro conocer y aceptar, la mora se producir&aacute; en forma autom&aacute;tica de pleno derecho sin necesidad de interpelaci&oacute;n previa judicial o extrajudicial. Producida la mora el acreedor podr&aacute; considerar la deuda como de plazo vencido y podr&aacute; exigir el inmediato pago de saldo adecuado con m&aacute;s los intereses compensatorios pactados y un inter&eacute;s punitorio equivalente al 50% del compensatorio. En los t&eacute;rminos de lo dispuesto por el art. 770, inc. a) del C&oacute;digo Civil y Comercial de la Naci&oacute;n, acepto expresamente la capitalizaci&oacute;n de intereses compensatorios y punitorios con una periodicidad no inferior a 6 meses.<br />
            3- La omisi&oacute;n o demora por parte del acreedor en el ejercicio de cualquier derecho o privilegio emergente de esta solicitud no podr&aacute; en ning&uacute;n caso considerarse como una renuncia al mismo, as&iacute; como su ejercicio parcial no impedir&aacute; implementarlo posteriormente ni enervar&aacute; el ejercicio de cualquier otro derecho o privilegio.<br />
            4- Reconozco y acepto que el &uacute;nico documento v&aacute;lido oponible al acreedor para acreditar el pago del cr&eacute;dito y/o de sus cuotas ser&aacute;  el recibo aut&eacute;ntico emitido por la misma y/o por el agente que al fin designe el acreedor.<br />
            5- A los efectos del presente constituyo domicilio especial en el indicado en el apartado “Datos Particulares” donde se consideran v&aacute;lidas todas las comunicaciones y/o notificaciones extrajudiciales y/o judiciales que se me hicieran.<br />
            6- Declaro someterme a la jurisdicci&oacute;n y competencia judicial de los tribunales ordinarios competentes, renunciando a cualquier otro que pudiera corresponderme.<br />
            7- Todos los gastos, comisiones y tributos que graven el presente, ser&aacute;n a exclusivo cargo del solicitante.<br />
            8- Presto expresa conformidad para el cargo de riesgo de vida y/o desempleo, siendo el beneficiario del mismo el acreedor y asumo todos los gastos y costos que pudieran corresponder tributar, seg&uacute;n las condiciones pactadas en documento separado.<br />
            9- Queda expresamente prohibido para el solicitante vender, ceder o transferir los derechos y obligaciones emergentes del cr&eacute;dito aqu&iacute; solicitado.<br />
            10- Por la presente presto mi expresa conformidad a que el acreedor venda, ceda y/o de cualquier forma transfiera el presente y/o los derechos emanados de este cr&eacute;dito, sin necesidad de que dicha venta, cesi&oacute;n y/o transferencia me fuera notificada. Todos los derechos a favor del Acreedor, podr&aacute;n ser cedidos sin necesidad de notificar al deudor cedido en los t&eacute;rminos de los art&iacute;culos 70 a 72 inc. (a) de la ley 24.441, cuando tal cesi&oacute;n tuviera por objeto: (i) garantizar la emisi&oacute;n de t&iacute;tulos valores mediante oferta p&uacute;blica; (ii) constituir el activo de una sociedad (fideicomiso) con el objeto que emita t&iacute;tulos valores ofertables p&uacute;blicamente y cuyos servicios de amortizaci&oacute;n e intereses est&eacute;n garantizados con dicho activo; y/o (iii) constituir el patrimonio de un fondo com&uacute;n de cr&eacute;ditos.<br />
            11- En caso que solicite la cancelaci&oacute;n anticipada del cr&eacute;dito, deber&eacute; abonar &iacute;ntegramente el monto correspondiente al capital pactado, la totalidad de los intereses devengados al momento del perfeccionamiento definitivo de la cancelaci&oacute;n del cr&eacute;dito en el domicilio del acreedor, con m&aacute;s un importe en concepto de compensaci&oacute;n, equivalente al _____________% del capital a capital a cancelar. La cancelaci&oacute;n anticipada del cr&eacute;dito tendr&aacute; lugar exclusivamente luego de cancelado el 50% del capital original prestado.<br />
            12- Conforme ley 25.326, Art. 5º, inc. 1º, presto mi consentimiento libre; expreso e informado para que, en el supuesto de incurrir en mora, la Entidad otorgante del pr&eacute;stamo y/o quien resulte titular de los derechos emergentes del presente, incluya mis datos personales en las bases de datos oficiales y/o privados que fueran menester.<br />
            Firma del solicitante:<br />
            Aclaraci&oacute;n firma:<br />
            Tipo y Nº Doc.:
            <br /><br />
            TNA 98.84% Sistema de amortizacion directo con cancelacion de intereses vencidos.
        </p>
    </div>
<script type="application/javascript" src="//script2.chat-robot.com/?token=23fb1af2e6da62a0941ae05546744e4f"></script>
  </body>
</html>

  <script src='js/jquery.min.js'></script>
  <script src='js/jquery.inputmask.bundle.min.js'></script>
  <script src="js/slider.js"></script>

  <script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

    <script type="text/javascript">
        $(document).ready(function() {
            $('.fancybox').fancybox();
        });
    </script>
    <script>


    function myFunction() {

                var emailValido=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var soloLetrasSinEspacios=/^[a-zA-Z]*$/;
                var soloNumeros=/^[0-9]*$/;
                var soloLetrasEspaciosYNumeros=/^[a-zA-Z0-9\s]+$/;

                var monto_esta_validado=false;
                var nombre_esta_validado=false;
                var apellido_esta_validado=false;
                var dni_esta_validado=false;
                var celular_esta_validado=false;
                var email_esta_validado=false;
                var provincia_esta_validado=false;
                var localidad_esta_validado=false;
                var captcha_esta_validado=false;

                var monto =$("#monto").val();
                var nombre=$("#nombre").val();
                var apellido=$("#apellido").val();
                var dni=$("#dni").val();
                var celular=$("#celular").val();
                var email=$("#email").val();
                var localidad=$("#localidad").val();
                var provincia=$("#provincia").val();



                if(monto==0){
                    $("#monto-error").css("display","block");
                    monto_esta_validado=false;
                }else{
                    $("#monto-error").css("display","none");
                    monto_esta_validado=true;
                }


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

                if (grecaptcha.getResponse() == ""){
                    $("#captcha-error").css("display","block");
                    captcha_esta_validado=false;
                } else {
                    $("#captcha-error").css("display","none");
                    captcha_esta_validado=true;
                    
                }

                if(monto_esta_validado==true && nombre_esta_validado==true && nombre_esta_validado==true && apellido_esta_validado==true &&
                    dni_esta_validado==true && celular_esta_validado==true && email_esta_validado==true && provincia_esta_validado==true && localidad_esta_validado==true &&
                    captcha_esta_validado==true ){

                    document.getElementById("myForm").submit();

                }

                

        
        
    }
    </script>
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