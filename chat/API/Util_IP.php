<?php
	if ( defined( 'API_Util_IP' ) ) { return ; }	
	define( 'API_Util_IP', true ) ;

	function Util_IP_GetIP( $token )
	{
		global $UTIL_IP ;
		if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && $_SERVER['HTTP_X_FORWARDED_FOR'] )
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ;
			if ( preg_match( "/,/", $ip ) ) { LIST( $ip, $ip_ ) = explode( ",", preg_replace( "/ +/", "", $ip ) ) ; }
		}
		else if ( isset( $_SERVER['REMOTE_ADDR'] ) && $_SERVER['REMOTE_ADDR'] ) { $ip = $_SERVER['REMOTE_ADDR'] ; }
		else { $ip = "0.0.0.0" ; } if ( !$token ) { $token = $ip ; }
		$http_agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : $ip ;
		$http_lang = isset( $_SERVER["HTTP_ACCEPT_LANGUAGE"] ) ? $_SERVER["HTTP_ACCEPT_LANGUAGE"] : $ip ;
		$http_token = ( isset( $UTIL_IP ) && $UTIL_IP ) ? "$ip$token$http_agent$http_lang" : "$token$http_agent$http_lang" ;
		$ip_output = Array( $ip, md5($http_token) ) ; return $ip_output ;
	}
?>
