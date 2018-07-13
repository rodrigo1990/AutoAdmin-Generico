<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;

	if ( !isset( $_COOKIE["phplive_opID"] ) )
		$json_data = "json_data = { \"status\": -1 };" ;
	else if ( $action == "fetch_ratings" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;

		$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
		$flag = Util_Format_Sanatize( Util_Format_GetVar( "flag" ), "ln" ) ;
		$opid_cookie = Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ) ;

		$opinfo = Ops_get_OpInfoByID( $dbh, $opid_cookie ) ;

		// auto logout if operator session does not exist
		if ( isset( $opinfo["ses"] ) && ( $opinfo["ses"] == $ses ) )
		{
			$m = date( "m", time() ) ;
			$d = date( "j", time() ) ;
			$y = date( "Y", time() ) ;
			$stat_start = mktime( 0, 0, 0, $m, $d, $y ) ;
			$stat_end = mktime( 23, 59, 59, $m, $d, $y ) ;

			$overall = Chat_get_OpOverallRatings( $dbh, $opid_cookie ) ;

			// only get new stats if active chats so not to use up resources if chat activity is idle
			if ( $flag )
			{
				$chats_overall = Chat_get_OpOverallChats( $dbh, $opid_cookie ) ;
				$chats_today = Chat_get_OpDayChats( $dbh, $opid_cookie, $stat_start, $stat_end ) ;
			}
			else { $chats_overall = $chats_today = 0 ; }

			$signal = $opinfo["signall"] ;
			if ( $signal )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
				Ops_update_OpValue( $dbh, $opinfo["opID"], "signall", 0 ) ;
			}

			$json_data = "json_data = { \"status\": 1, \"rating_overall\": \"$overall\", \"rating_recent\": \"$opinfo[rating]\", \"ces\": \"$opinfo[ces]\", \"chats_today\": $chats_today, \"chats_overall\": $chats_overall, \"status_op\": 1, \"op_status\": $opinfo[status], \"signal\": $signal }; " ;
		}
		else
			$json_data = "json_data = { \"status\": 0, \"rating_overall\": \"\", \"rating_recent\": \"\", \"ces\": \"\", \"status_op\": 0, \"signal\": -1 }; " ;
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
