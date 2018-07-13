<?php
	$NO_CACHE = 1 ; include_once( "../inc_cache.php" ) ;
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$ip = Util_Format_Sanatize( Util_Format_GetVar( "ip" ), "ln" ) ;

	if ( $action == "rating" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;

		$requestid = Util_Format_Sanatize( Util_Format_GetVar( "requestid" ), "ln" ) ;
		$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;
		$rating = Util_Format_Sanatize( Util_Format_GetVar( "rating" ), "ln" ) ;
		$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "ln" ) ;
		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;

		if ( Chat_update_TranscriptValue( $dbh, $ces, "rating", $rating ) )
		{
			Chat_update_RecentChat( $dbh, $opid, $ces, $rating ) ;
			Ops_put_itr_OpReqStat( $dbh, $deptid, $opid, "rateit", 1 ) ;
			Ops_put_itr_OpReqStat( $dbh, $deptid, $opid, "ratings", $rating ) ;
		}
		
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