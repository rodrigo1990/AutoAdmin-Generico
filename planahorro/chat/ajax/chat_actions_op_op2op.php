<?php
	$NO_CACHE = 1 ; include_once( "../inc_cache.php" ) ;
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;

	if ( !isset( $_COOKIE["phplive_opID"] ) )
		$json_data = "json_data = { \"status\": -1 };" ;
	else if ( $action == "op2op" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put.php" ) ;

		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
		$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
		$resolution = Util_Format_Sanatize( Util_Format_GetVar( "win_dim" ), "ln" ) ;
		$opid_cookie = Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ) ;

		$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
		LIST( $ip, $vis_token ) = Util_IP_GetIP( "" ) ;
		LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
		$mobile = ( $os == 5 ) ? 1 : 0 ;
		$ces = md5( time().$ip ) ;

		$opinfo = Ops_get_OpInfoByID( $dbh, $opid_cookie ) ;
		$opinfo_ = Ops_get_OpInfoByID( $dbh, $opid ) ;

		if ( isset( $opinfo["opID"] ) )
		{
			$opinfo_next = $opinfo_ ; // set it to a variable that is recognized for SMS buffer
			if ( $requestid = Chat_put_Request( $dbh, $deptid, $opid, 0, 0, $opid_cookie, 0, $os, $browser, $ces, $resolution, $opinfo["name"], $opinfo["email"], $ip, "", "op2op", "op2op", "", "Operator 2 Operator Chat", 0, "", "" ) )
			{
				// create empty file to signal a chat session
				touch( "$CONF[CHAT_IO_DIR]/$ces.txt" ) ;

				if ( $opinfo_["sms"] == 1 )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Email.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

					$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
					if ( $deptinfo["smtp"] )
					{
						$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;

						$CONF["SMTP_HOST"] = $smtp_array["host"] ;
						$CONF["SMTP_LOGIN"] = $smtp_array["login"] ;
						$CONF["SMTP_PASS"] = $smtp_array["pass"] ;
						$CONF["SMTP_PORT"] = $smtp_array["port"] ;
						$CONF["SMTP_API"] = isset( $smtp_array["api"] ) ? $smtp_array["api"] : "" ;
						$CONF["SMTP_DOMAIN"] = isset( $smtp_array["domain"] ) ? $smtp_array["domain"] : "" ;
					}

					$question = "Operator-to-operator chat request from $opinfo[name]" ;
					$error = Util_Email_SendEmail( $opinfo["name"], $opinfo["email"], $opinfo_["name"], base64_decode( $opinfo_["smsnum"] ), "Chat Request", $question, "sms" ) ;
				}

				Chat_put_ReqLog( $dbh, $requestid ) ;
				$json_data = "json_data = { \"status\": 1, \"ces\": \"$ces\" };" ;
			}
			else
				$json_data = "json_data = { \"status\": -1 };" ;
		}
		else
			$json_data = "json_data = { \"status\": 0 };" ;
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