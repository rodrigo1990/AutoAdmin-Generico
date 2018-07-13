<?php
	/************** DO NOT MODIFY BELOW */
	if ( defined( 'API_Util_Vars' ) ) { return ; }	
	define( 'API_Util_Vars', true ) ;
	$PHPLIVE_HOST = isset( $_SERVER["HTTP_HOST"] ) ? $_SERVER["HTTP_HOST"] : "unknown_host" ;
	$PHPLIVE_URI = isset( $_SERVER["REQUEST_URI"] ) ? $_SERVER["REQUEST_URI"] : "unknown uri" ;
	$PHPLIVE_FULLURL = "$PHPLIVE_HOST/$PHPLIVE_URI" ;
	if ( isset( $CONF_EXTEND ) ) { $CONF['CONF_ROOT'] = "$CONF[DOCUMENT_ROOT]/web/$CONF_EXTEND" ; }
	else { $CONF['CONF_ROOT'] = "$CONF[DOCUMENT_ROOT]/web" ; }
	$CONF["UPLOAD_HTTP"] = "$CONF[BASE_URL]/web" ;
	$CONF["UPLOAD_DIR"] = $CONF['CONF_ROOT'] ;
	include_once( "$CONF[CONF_ROOT]/vals.php" ) ; include_once( "$CONF[DOCUMENT_ROOT]/setup/KEY.php" ) ;
	if ( preg_match( "/patch\.php/", $PHPLIVE_URI ) ) { $VERSION = "PATCH_".time() ; }
	else { include_once( "$CONF[CONF_ROOT]/VERSION.php" ) ; } $patch_v = 92 ; 
	$VARS_BROWSER = Array( 1=>"IE", 2=>"Firefox", 3=>"Chrome", 4=>"Safari", 5=>"Opera", 6=>"Other" ) ;
	$VARS_OS = Array( 1=>"Windows", 2=>"Mac", 3=>"Unix", 4=>"Other", 5=>"Mobile" ) ;
	$geoip = ( isset( $CONF["geo"] ) && $CONF["geo"] ) ? 1 : 0 ; $geomap = ( isset( $CONF["geo"] ) && ( strlen( $CONF["geo"] ) == 39 ) ) ? $CONF["geo"] : 0 ; $geokey = ( $geomap ) ? $CONF["geo"] : "" ; $UTIL_IP = 1 ;
	/************** DO NOT MODIFY ABOVE */
	// To change any of the variables, create a new file API/Util_Extra.php (description detailed at bottom of this file)
	// For detailed descriptions of the variables, access the file README/VARS.txt
	$CONF["CHAT_IO_DIR"] = "$CONF[CONF_ROOT]/chat_sessions" ;
	$CONF["TYPE_IO_DIR"] = "$CONF[CONF_ROOT]/chat_initiate" ;

	$VARS_JS_ROUTING = 3 ;
	$VARS_JS_REQUESTING = 3 ;
	$VARS_JS_FOOTPRINT_CHECK = 25 ;
	$VARS_JS_INVITE_CHECK = 13 ;
	$VARS_JS_FOOTPRINT_MAX_CYCLE = 100 ;
	$VARS_JS_RATING_FETCH = 25 ;
	$VARS_FOOTPRINT_U_EXPIRE = $VARS_JS_FOOTPRINT_CHECK * 2 ;
	$VARS_IP_LOG_EXPIRE = 45 ;
	$VARS_FOOTPRINT_STATS_EXPIRE = 90 ;
	$VARS_JS_OP_CONSOLE_TIMEOUT = 15 ;
	$VARS_CYCLE_VUPDATE = 4 ; // cycle mod
	$VARS_CYCLE_CLEAN = $VARS_JS_REQUESTING + 6 ;
	$VARS_EXPIRED_OPS = $VARS_CYCLE_CLEAN * 8 ;
	$VARS_EXPIRED_REQS = $VARS_EXPIRED_OPS * 3 ;
	$VARS_EXPIRED_OP2OP = $VARS_CYCLE_CLEAN * 3 ;
	$VARS_TRANSFER_BACK = 45 ;
	$VARS_SMS_BUFFER = 20 ;
	$VARS_MOBILE_CHAT_BUFFER = 120 ;
	$VARS_MAX_EMBED_SESSIONS = 3 ;
	$VARS_CHAT_WIDTH = 600 ;
	$VARS_CHAT_HEIGHT = 560 ;
	$VARS_CHAT_WIDTH_WIDGET = 490 ;
	$VARS_CHAT_HEIGHT_WIDGET = 510 ;

	/*****************************************************************************/
	/* To change a variable, create a new file API/Util_Extra.php and place
	// the variable changes there as this file will be overridden with each update
	// example:
	//	to change the variable $VARS_TRANSFER_BACK, place the same variable in the API/Util_Extra.php
	//	with your new value.  if we introduce a new variable in future versions, your changes
	//	will not be replace to the default values. */
	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Extra.php" ) ; }
?>