<?php
	include("../validacion.php");
?>
<?php
	// Inicializa la sesi�n.
	session_start();
	 
	// Destruye todas las variables de la sesi�n
	$_SESSION = array();
	 
	//guardar el nombre de la sessi�n para luego borrar las cookies
	$session_name = session_name();
	 
	//Para destruir una variable en espec�fico
	unset($_SESSION['username']);
	 
	// Finalmente, destruye la sesi�n
	session_destroy();
	 
	// Para borrar las cookies asociadas a la sesi�n
	// Es necesario hacer una petici�n http para que el navegador las elimine
	if ( isset( $_COOKIE[ $session_name ] ) ) {
		if ( setcookie(session_name(), '', time()-3600, '/') ) {
			header("Location: ../login.php");
			exit();   
		}
	 
	}
?>

<html>
<head>
	<title><?php echo($titulo); ?></title>
	<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" /> <!--Es para los acentos-->
	<link href="general.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<h1><?php echo($titulo); ?></h1>
	
</body>
</html>	