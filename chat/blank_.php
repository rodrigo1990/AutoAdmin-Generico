<?php
	include_once( "./web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$theme = Util_Format_Sanatize( Util_Format_GetVar( "theme" ), "ln" ) ;
?>
<?php include_once( "./inc_doctype.php" ) ?>
<html><head>
<title> blank page </title>
<meta name="description" content="phplive_c615">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<?php include_once( "./inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="./themes/<?php echo $theme ?>/style.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script language="JavaScript">
<!--
	function display_error( theerror, theextra )
	{
		if ( theerror = "XFrame" )
		{
			setTimeout( function(){ display_error_XFrame( theextra ) ; }, 3000 ) ;
		}
	}

	function display_error_XFrame( theurl )
	{
		$('#error_X-Frame-Options_url_txt').html( theurl ) ;
		$('#error_X-Frame-Options_url_href').html( "<a href=\""+theurl+"\" target=\""+theurl+"\" style=\"color: #FFFFFF;\">"+theurl+"</a>" ) ;
		$('#error_X-Frame-Options').show() ;
	}
//-->
</script>
</head>
<body style="background: transparent;">
<!-- blank page for loading in various areas for iframe notices and errors -->
<div id="error_X-Frame-Options" style="display: none;" class="info_error">

	Could not display <span id="error_X-Frame-Options_url_txt" style="font-weight: bold;"></span> because it can only be viewed from a new window.  This is due to the content restriction set at their website.  Click the link to access the page in a new window.
	<div style="margin-top: 15px; font-size: 14px; font-weight: bold;"><span id="error_X-Frame-Options_url_href" style="font-weight: bold;"></span></div>

</div>
</body>
</html>