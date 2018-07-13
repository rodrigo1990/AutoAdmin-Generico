<?php
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$query = Util_Format_Sanatize( Util_Format_GetVar( "q" ), "" ) ;
	if ( !$query ) { $query = Util_Format_Sanatize( Util_Format_GetVar( "v" ), "" ) ; }

	$params = Array() ;
	$tok = strtok( $query, '|' ) ;
	while ( $tok !== false ) { $params[] = $tok ; $tok = strtok( '|' ) ; }

	$deptid = isset( $params[0] ) ? Util_Format_Sanatize( $params[0], "n" ) : 0 ;
	$btn = isset( $params[1] ) ? Util_Format_Sanatize( $params[1], "n" ) : 0 ;
	$proto = isset( $params[2] ) ? Util_Format_Sanatize( rawurldecode( $params[2] ), "n" ) : 0 ;
	$text = isset( $params[3] ) ? Util_Format_Sanatize( rawurldecode( $params[3] ), "ln" ) : "" ;

	$base_url = $CONF["BASE_URL"] ;
	if ( $proto == 1 ) { $base_url = preg_replace( "/(http:)|(https:)/", "http:", $base_url ) ; }
	else if ( $proto == 2 ) { $base_url = preg_replace( "/(http:)|(https:)/", "https:", $base_url ) ; }
	else { $base_url = preg_replace( "/(http:)|(https:)/", "", $base_url ) ; }

	$now = time() ;
	Header( "Content-Type: text/javascript" ) ;
?>
(function( ) {
	var phplive_e_<?php echo $btn ?> = document.createElement("script") ;
	phplive_e_<?php echo $btn ?>.type = "text/javascript" ;
	phplive_e_<?php echo $btn ?>.async = true ;
	phplive_e_<?php echo $btn ?>.src = "<?php echo $base_url ?>/js/phplive_v2.js.php?v=<?php echo $deptid ?>|<?php echo $btn ?>|<?php echo $proto ?>|<?php echo urlencode( $text ) ?>&<?php echo $now ?>" ;
	document.getElementById("phplive_btn_<?php echo $btn ?>").appendChild( phplive_e_<?php echo $btn ?> ) ;
})();