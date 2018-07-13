<?php
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Email.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
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

	$question = ( strlen( $requestinfo["question"] ) > 100 ) ? substr( $requestinfo["question"], 0, 100 ) . "..." : $requestinfo["question"] ;
	$question = preg_replace( "/<br>/", " ", $question ) ;
	Util_Email_SendEmail( $opinfo_next["name"], $opinfo_next["email"], $requestinfo["vname"], base64_decode( $opinfo_next["smsnum"] ), "Chat Request", $question, "sms" ) ;
?>