<?php
	include("../validacion.php");
?>
<?php
	// Inicializa la sesión.
	session_start();
	 
	// Destruye todas las variables de la sesión
	$_SESSION = array();
	 
	//guardar el nombre de la sessión para luego borrar las cookies
	$session_name = session_name();
	 
	//Para destruir una variable en específico
	unset($_SESSION['username']);
	 
	// Finalmente, destruye la sesión
	session_destroy();
	 
	// Para borrar las cookies asociadas a la sesión
	// Es necesario hacer una petición http para que el navegador las elimine
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