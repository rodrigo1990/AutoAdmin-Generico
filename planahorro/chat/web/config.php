<?php
	$CONF = Array() ;
$CONF['DOCUMENT_ROOT'] = addslashes( '/www/argenpesosonline/htdocs/planahorro/chat' ) ;
$CONF['BASE_URL'] = '//www.argenpesos.com.ar/planahorro/chat' ;
$CONF['SQLTYPE'] = 'SQL.php' ;
$CONF['SQLHOST'] = '192.168.0.192' ;
$CONF['SQLLOGIN'] = 'argenpesos_chat' ;
$CONF['SQLPASS'] = 'ch4tw3b' ;
$CONF['DATABASE'] = 'argenpesos_chat' ;
$CONF['THEME'] = 'default' ;
$CONF['TIMEZONE'] = 'America/Argentina/Buenos_Aires' ;
$CONF['icon_online'] = '' ;
$CONF['icon_offline'] = '' ;
$CONF['lang'] = 'english' ;
$CONF['logo'] = '' ;
$CONF['CONF_ROOT'] = '/www/argenpesosonline/htdocs/planahorro/chat/web' ;
$CONF['UPLOAD_HTTP'] = '//www.argenpesos.com.ar/planahorro/chat/web' ;
$CONF['UPLOAD_DIR'] = '/www/argenpesosonline/htdocs/planahorro/chat/web' ;
$CONF['geo'] = '' ;
$CONF['SALT'] = 'sg2zuu95kd' ;
$CONF['API_KEY'] = 'mepxrtxbfa' ;
	if ( phpversion() >= '5.1.0' ){ date_default_timezone_set( $CONF['TIMEZONE'] ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vars.php" ) ;
?>