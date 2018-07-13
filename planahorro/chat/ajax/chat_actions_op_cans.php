<?php
	$NO_CACHE = 1 ; include_once( "../inc_cache.php" ) ;
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;

	if ( !isset( $_COOKIE["phplive_opID"] ) )
		$json_data = "json_data = { \"status\": -1 };" ;
	else if ( $action == "cans" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/get.php" ) ;

		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;
		$opid_cookie = Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ) ;

		$cans = Canned_get_OpCanned( $dbh, $opid_cookie, $deptid ) ;
		$json_data = "json_data = { \"status\": 1, \"cans\": [  " ;
		for ( $c = 0; $c < count( $cans ); ++$c )
		{
			$can = $cans[$c] ;
			$title = Util_Format_ConvertQuotes( $can["title"] ) ;
			$message = Util_Format_ConvertQuotes( preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", $can["message"] ) ) ;

			$json_data .= "{ \"canid\": $can[canID], \"auto_select\": $can[auto_select], \"deptid\": $can[deptID], \"title\": \"$title\", \"message\": \"$message\" }," ;
		}
		$json_data = substr_replace( $json_data, "", -1 ) ;
		$json_data .= "	] };" ;
	}
	else if ( $action == "auto_canned" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/put.php" ) ;

		$canid = Util_Format_Sanatize( Util_Format_GetVar( "canid" ), "n" ) ;
		$value = Util_Format_Sanatize( Util_Format_GetVar( "value" ), "n" ) ;
		$opid_cookie = Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ) ;

		Canned_put_Auto_Canned( $dbh, $opid_cookie, $canid, $value ) ;
		$json_data = "json_data = { \"status\": 1 };" ;
	}
	else
		$json_data = "json_data = { \"status\": 0 };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print "$json_data" ;
	exit ;
?>