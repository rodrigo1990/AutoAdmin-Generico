<?php
error_reporting(0);

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

    <meta charset="utf-8">
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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99131822-4', 'auto');
  ga('send', 'pageview');

</script>
  </head>
  
  <body>


  <div id="contanedor">

    <div class="col-sm-6" id="izquierda_form">
      <div id="logo"><img src="imagenes/logo2.png" alt="" /></div>
      <img src="imagenes/globo1.png" alt="" id="globo2" />
      <div class="row">
       
     
      </div>

    </div>
    <div class="col-sm-6" id="derecha_form">
      <form action="solicitud.php" method="post">
     
      <div class="titulos"><i class="fa fa-chevron-right" aria-hidden="true"></i> DATOS DEL PARTICIPANTE:</div>

      <div id="form">
          <div class="row">
            <div class="col-sm-12">
              <label>Nombre y Apellido</label><br />
              <input type="text" name="nombre" class="input_form" placeholder="Ej: Juan Pérez" required />
            </div>
          </div>




          <div class="row">
            <div class="col-sm-6">
              <label>C&oacute;digo de &aacute;rea</label><br />
              <select name="codigo_area" class="input_form">
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
              <input type="text" name="celular" class="input_form" placeholder="Ej. 36969898" required />
            </div>
          </div>

    <div class="row">
            <div class="col-sm-12">
              <label>DNI</label><br />
              <input type="number" name="dni" class="input_form" placeholder="Ej: 33952789" required />
            </div>
          
          </div>


          <div class="row">
            <div class="col-sm-12">
              <label>Email</label><br />
              <input type="email" name="mail" class="input_form" placeholder="Ej. juangomez@gmail.com"  />
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <label>Localidad</label><br />
              <input type="text" name="localidad" class="input_form"  required />
            </div>
          </div>

        <hr/>

        <div class="row">
          <div class="col-sm-12 text-right">
            <input type="submit" name="submit" value="ENVIAR SOLICITUD" id="btn_enviar" />
          </div>
        </div>

      </form>
      </div>

    </div>

    <div class="clearfix"></div>
  </div>


  </div>


    

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