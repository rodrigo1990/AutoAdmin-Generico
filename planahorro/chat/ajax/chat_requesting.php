<?php
	$NO_CACHE = 1 ; include_once( "../inc_cache.php" ) ;
	/*
	// status DB request: -1 ended by action taken, 0 waiting pick-up, 1 picked up, 2 transfer
	*/
	$microtime = ( function_exists( "gettimeofday" ) ) ? 1 : 0 ;
	$process_start = ( $microtime ) ? microtime(true) : time() ;
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	if ( !isset( $CONF['foot_log'] ) ) { $CONF['foot_log'] = "on" ; }
	if ( !isset( $CONF['icon_check'] ) ) { $CONF['icon_check'] = "on" ; }
	if ( $action == "requests" )
	{
		if ( !isset( $_COOKIE["phplive_opID"] ) || !$_COOKIE["phplive_opID"] )
			$json_data = "json_data = { \"status\": -1 };" ;
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_itr.php" ) ;

			$now = time() ;
			$opid = Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ) ;
			$prev_status = Util_Format_Sanatize( Util_Format_GetVar( "prev_status" ), "ln" ) ;
			$c_requesting = Util_Format_Sanatize( Util_Format_GetVar( "c_requesting" ), "ln" ) ;
			$traffic = Util_Format_Sanatize( Util_Format_GetVar( "traffic" ), "ln" ) ;
			$q_ces = Util_Format_Sanatize( Util_Format_GetVar( "q_ces" ), "a" ) ;
			$q_ces_hash = Array() ;

			for ( $c = 0; $c < count( $q_ces ); ++$c )
			{
				$ces = $q_ces[$c] ; $q_ces_hash[$ces] = 1 ;
			}
			if ( $c_requesting % $VARS_CYCLE_CLEAN == 0 )
			{
				$vars = Util_Format_Get_Vars( $dbh ) ;
				if ( $vars["ts_clean"] <= ( $now - $VARS_CYCLE_CLEAN ) )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove_itr.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/remove_itr.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_itr.php" ) ;

					Util_Format_Update_TimeStamp( $dbh, "clean", $now ) ;
					Footprints_remove_itr_Expired_U( $dbh ) ;
					Chat_remove_itr_ExpiredOp2OpRequests( $dbh ) ;
					Chat_remove_itr_OldRequests( $dbh ) ;
					Ops_update_itr_IdleOps( $dbh ) ;
				}
			}
			else if ( $c_requesting % 2 )
			{
				$query = "UPDATE p_operators SET lastactive = $now WHERE opID = $opid" ;
				database_mysql_query( $dbh, $query ) ;
				$query = "UPDATE p_requests SET updated = $now WHERE ( opID = $opid OR op2op = $opid OR opID = 1111111111 ) AND ( status >= 0 AND status <= 2 )" ;
				database_mysql_query( $dbh, $query ) ;
			}

			$total_traffics = ( $traffic && ( $CONF['icon_check'] == "on" ) ) ? Footprints_get_itr_TotalFootprints_U( $dbh ) : 0 ;
			$query = "SELECT * FROM p_requests WHERE ( opID = $opid OR op2op = $opid OR opID = 1111111111 ) AND ( status >= 0 AND status <= 2 ) ORDER BY created ASC" ;
			database_mysql_query( $dbh, $query ) ;

			$requests_temp = Array() ;
			if ( $dbh[ 'ok' ] )
			{
				while ( $data = database_mysql_fetchrow( $dbh ) ) { $requests_temp[] = $data ; }
			}
			$requests = Array() ;
			for ( $c = 0; $c < count( $requests_temp ); ++$c )
			{
				$data = $requests_temp[$c] ;
				if ( ( $data["status"] == 2 ) && ( $data["op2op"] == $opid ) )
				{
					if ( $data["tupdated"] < ( time() - $VARS_TRANSFER_BACK ) )
						include_once( "$CONF[DOCUMENT_ROOT]/ops/inc_chat_transfer.php" ) ;
				}
				else
				{
					// sim ops filter for declined
					if ( !preg_match( "/(^|-)($opid-)/", $data["sim_ops_"] ) ) { $requests[] = $data ; }
				}
			}

			$json_data = "json_data = { \"status\": 1, \"traffics\": $total_traffics, \"requests\": [  " ;
			for ( $c = 0; $c < count( $requests ); ++$c )
			{
				$request = $requests[$c] ;

				$os = $VARS_OS[$request["os"]] ;
				$browser = $VARS_BROWSER[$request["browser"]] ;
				$title = preg_replace( "/\"/", "&quot;", $request["title"] ) ;
				$question = preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", preg_replace( "/\"/", "&quot;", $request["question"] ) ) ;
				$onpage = preg_replace( "/hphp/i", "http", $request["onpage"] ) ;
				$refer_raw = preg_replace( "/hphp/i", "http", $request["refer"] ) ;
				$refer_snap = ( strlen( $refer_raw ) > 50 ) ? substr( $refer_raw, 0, 45 ) . "..." : $refer_raw ;
				$custom = $request["custom"] ;

				// if status is 2 then it's a transfer call... keep original visitor name
				if ( ( $request["status"] != 2 ) && $request["op2op"] )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

					if ( $opid == $request["op2op"] ) { $opinfo = Ops_get_OpInfoByID( $dbh, $request["opID"] ) ; }
					else { $opinfo = Ops_get_OpInfoByID( $dbh, $request["op2op"] ) ; }
					$vname = $opinfo["name"] ; $vemail = $opinfo["email"] ;
				}
				else { $vname = $request["vname"] ; $vemail = $request["vemail"] ; }

				if ( ( $request["status"] == 1 ) && ( $request["opID"] == 1111111111 ) )
				{
					$request["status"] = 0 ;
					$query = "UPDATE p_requests SET status = 0 WHERE requestID = $request[requestID]" ;
					database_mysql_query( $dbh, $query ) ;
				}

				if ( isset( $q_ces_hash[$request["ces"]] ) )
					$json_data .= "{ \"requestid\": $request[requestID], \"ces\": \"$request[ces]\", \"deptid\": $request[deptID], \"t_vses\": $request[t_vses], \"status\": $request[status] }," ;
				else
					$json_data .= "{ \"requestid\": $request[requestID], \"ces\": \"$request[ces]\", \"created\": \"$request[created]\", \"deptid\": $request[deptID], \"opid\": $request[opID], \"op2op\": $request[op2op], \"t_vses\": $request[t_vses], \"vname\": \"$vname\", \"status\": $request[status], \"auto_pop\": $request[auto_pop], \"initiated\": $request[initiated], \"os\": \"$os\", \"browser\": \"$browser\", \"requests\": \"$request[requests]\", \"resolution\": \"$request[resolution]\", \"vemail\": \"$vemail\", \"ip\": \"$request[ip]\", \"vis_token\": \"$request[md5_vis_]\", \"onpage\": \"$onpage\", \"title\": \"$title\", \"question\": \"$question\", \"marketid\": \"$request[marketID]\", \"refer_raw\": \"$refer_raw\", \"refer_snap\": \"$refer_snap\", \"custom\": \"$custom\", \"vupdated\": \"$request[vupdated]\" }," ;
			}
			$json_data = substr_replace( $json_data, "", -1 ) ;

			$process_end = ( $microtime ) ? microtime(true) : time() ;
			$process_duration = $process_end - $process_start ; if ( !$process_duration ) { $process_duration = 0.001 ; }
			$process_duration = str_replace( ",", ".", $process_duration ) ;
			$json_data .= "	], process_duration: $process_duration };" ;
		}
	}

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print "$json_data" ;
	exit ;
?>