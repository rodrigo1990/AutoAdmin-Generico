<?php
	$CONF = Array() ;
$CONF['DOCUMENT_ROOT'] = addslashes( '/www/argenpesosonline/htdocs/chat' ) ;
$CONF['BASE_URL'] = 'http://www.argenpesosonline.com.ar/chat' ;
$CONF['SQLTYPE'] = 'SQL.php' ;
$CONF['SQLHOST'] = '192.168.0.66' ;
$CONF['SQLLOGIN'] = 'chat_us' ;
$CONF['SQLPASS'] = '12953416As' ;
$CONF['DATABASE'] = 'chat_bd' ;
$CONF['THEME'] = 'default' ;
$CONF['TIMEZONE'] = 'America/Argentina/Buenos_Aires' ;
$CONF['icon_online'] = 'icon_online_0.PNG' ;
$CONF['icon_offline'] = 'icon_offline_0.PNG' ;
$CONF['lang'] = 'spanish' ;
$CONF['logo'] = '' ;
$CONF['CONF_ROOT'] = '/www/argenpesosonline/htdocs/chat/web' ;
$CONF['UPLOAD_HTTP'] = 'http://www.argenpesosonline.com.ar/chat/web' ;
$CONF['UPLOAD_DIR'] = '/www/argenpesosonline/htdocs/chat/web' ;
$CONF['geo'] = '' ;
$CONF['SALT'] = 'f8rwas45eb' ;
$CONF['API_KEY'] = 'fzqszpmppj' ;
	if ( phpversion() >= '5.1.0' ){ date_default_timezone_set( $CONF['TIMEZONE'] ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vars.php" ) ;
?>