<?php
	//header("HTTP/1.0 400 Bad Request") ; exit ;
	$NO_CACHE = 1 ; include_once( "../inc_cache.php" ) ;
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;
	$isop = Util_Format_Sanatize( Util_Format_GetVar( "isop" ), "ln" ) ;
	$isop_ = Util_Format_Sanatize( Util_Format_GetVar( "isop_" ), "ln" ) ;
	$isop__ = Util_Format_Sanatize( Util_Format_GetVar( "isop__" ), "ln" ) ;
	$status = Util_Format_Sanatize( Util_Format_GetVar( "status" ), "ln" ) ;
	$c_chatting = Util_Format_Sanatize( Util_Format_GetVar( "c_chatting" ), "ln" ) ;
	$q_ces = Util_Format_Sanatize( Util_Format_GetVar( "q_ces" ), "a" ) ;
	$q_chattings = Util_Format_Sanatize( Util_Format_GetVar( "q_chattings" ), "a" ) ;
	$q_cids = Util_Format_Sanatize( Util_Format_GetVar( "q_cids" ), "a" ) ;
	$q_isop_ = Util_Format_Sanatize( Util_Format_GetVar( "q_isop_" ), "a" ) ;
	$q_isop__ = Util_Format_Sanatize( Util_Format_GetVar( "q_isop__" ), "a" ) ;
	$realtime = Util_Format_Sanatize( Util_Format_GetVar( "realtime" ), "ln" ) ;
	$fline = Util_Format_Sanatize( Util_Format_GetVar( "fline" ), "ln" ) ;
	$t_vses = Util_Format_Sanatize( Util_Format_GetVar( "t_vses" ), "n" ) ;

	if ( ( $isop && $isop_ ) && ( $isop == $isop_ ) ) { $iid = $isop__ ; }
	else if ( $isop && $isop_ ) { $iid = $isop_ ; }
	else { $iid = $isop_ ; }
	$filename = $ces.$iid ;
	$istyping = ( is_file( "$CONF[TYPE_IO_DIR]/$filename.txt" ) && !$realtime ) ? 1 : 0 ;
	$json_data = "json_data = { \"status\": 1, \"ces\": \"$ces\", \"istyping\": $istyping, \"chats\": [  " ;
	for ( $c = 0; $c < count( $q_ces ); ++$c )
	{
		$ces = Util_Format_Sanatize( $q_ces[$c], "lns" ) ;
		$chatting = Util_Format_Sanatize( $q_chattings[$c], "ln" ) ;
		$cid = Util_Format_Sanatize( $q_cids[$c], "ln" ) ;

		if ( ( $isop && $q_isop_[$c] ) && ( $isop == $q_isop_[$c] ) ) { $rid = $q_isop__[$c] ; }
		else if ( $isop && $q_isop_[$c] ) { $rid = $q_isop_[$c] ; }
		else
		{
			if ( $isop ) { $rid = $isop ; }
			else { $rid = $isop."_".$t_vses ; }
		}
		$filename = $ces."-".$rid ;
		if ( !$chatting )
			$chat_file = "$CONF[CHAT_IO_DIR]/$ces.txt" ;
		else
			$chat_file = "$CONF[CHAT_IO_DIR]/$filename.text" ;

		if ( is_file( $chat_file ) )
		{
			$trans_raw = file( $chat_file ) ;
			$trans = explode( "<>", implode( "", $trans_raw ) ) ;
			$file_lines = count( $trans ) - 1 ;
			if ( $realtime )
				$text = preg_replace( "/\"/", "&quot;", implode( "<>", array_slice( $trans, $fline, $file_lines-$fline ) ) ) ;
			else
				$text = addslashes( preg_replace( "/\"/", "&quot;", implode( "<>", $trans ) ) ) ;
			$text = preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", $text ) ;

			$json_data .= "{ \"ces\": \"$ces\", \"fline\": $file_lines, \"text\": \"$text\" }," ;

			if ( is_file( "$CONF[CHAT_IO_DIR]/$filename.text" ) )
				unlink( "$CONF[CHAT_IO_DIR]/$filename.text" ) ;
		}
		else if ( !is_file( "$CONF[CHAT_IO_DIR]/$ces.txt" ) )
		{
			$json_data .= "{ \"ces\": \"$ces\", \"text\": \"<div class='cl'><disconnected><d5>".$LANG["CHAT_NOTIFY_DISCONNECT"]."</div>\" }," ;
		}

		if ( !$isop && ( $c_chatting % $VARS_CYCLE_VUPDATE ) && !$realtime )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;
			$requestid = Util_Format_Sanatize( Util_Format_GetVar( "requestid" ), "n" ) ;
			$mobile = Util_Format_Sanatize( Util_Format_GetVar( "m" ), "n" ) ;

			$vupdated = ( $mobile ) ? time() + $VARS_MOBILE_CHAT_BUFFER : time() ;
			Chat_update_RequestValue( $dbh, $requestid, "vupdated", $vupdated ) ;
		}
		else if ( !$isop && ( $c_chatting % $VARS_CYCLE_CLEAN == 0 ) && !$realtime )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;

			$now = time() ; $vars = Util_Format_Get_Vars( $dbh ) ;
			if ( $vars["ts_clean"] <= ( $now - $VARS_CYCLE_CLEAN ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove_itr.php" ) ;

				Util_Format_Update_TimeStamp( $dbh, "clean", $now ) ;
				Chat_remove_itr_OldRequests( $dbh ) ;
			}
		}
	}
	$json_data = substr_replace( $json_data, "", -1 ) ;
	$json_data .= "	] };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print "$json_data" ;
	exit ;
?>