<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	if ( !is_file( "./web/VERSION.php" ) ) { touch( "./web/VERSION.php" ) ; }
	if ( !is_file( "./web/config.php" ) ){ HEADER("location: ./setup/install.php") ; exit ; }
	include_once( "./web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ; 
	/* AUTO PATCH */
	$query = ( isset( $_SERVER["QUERY_STRING"] ) ) ? $_SERVER["QUERY_STRING"] : "" ;
	if ( !is_file( "$CONF[CONF_ROOT]/patches/$patch_v" ) )
	{
		HEADER( "location: patch.php?from=index&".$query ) ;
		exit ;
	}
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ;
	/////////////////////////////////////////////
	if ( defined( "LANG_CHAT_WELCOME" ) || !isset( $LANG["CHAT_JS_CUSTOM_BLANK"] ) )
		ErrorHandler( 611, "Update to your custom language file is required ($CONF[lang]).  Copy an existing language file and create a new custom language file.", $PHPLIVE_FULLURL, 0, Array() ) ;
	/////////////////////////////////////////////
	// Proto redirect
	$https = 0 ;
	if ( isset( $_SERVER["HTTP_CF_VISITOR"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_CF_VISITOR"] ) ) { $https = 1 ; }
	else if ( isset( $_SERVER["HTTP_X_FORWARDED_PROTO"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_X_FORWARDED_PROTO"] ) ) { $https = 1 ; }
	else if ( isset( $_SERVER["HTTPS"] ) && preg_match( "/(on)/i", $_SERVER["HTTPS"] ) ) { $https = 1 ; }

	$vars = Util_Format_Get_Vars( $dbh ) ; $proto_set = $vars["code"] ;
	$base_url = $CONF["BASE_URL"] ; $proto_redirect = 0 ;

	if ( ( $proto_set == 1 ) && $https )
	{
		$proto_redirect = 1 ; $base_url = preg_replace( "/^(https:)/i", "http:", $base_url ) ;
	}
	else if ( ( $proto_set == 2 ) && !$https )
	{
		$proto_redirect = 1 ; $base_url = preg_replace( "/^(http:)/i", "https:", $base_url ) ;
	}
	else if ( $https && preg_match( "/^(http:)/i", $base_url ) )
	{
		$base_url = preg_replace( "/^(https:\/\/)|(http:\/\/)|(\/\/)/i", "https://", $base_url ) ;
		Util_Vals_WriteToConfFile( "BASE_URL", $base_url ) ;
		if ( $proto_set == 1 )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Vars/update.php" ) ;
			Vars_update_Var( $dbh, "code", 2 ) ;
		}
	}
	if ( $proto_redirect ){
		database_mysql_close( $dbh ) ; $base_url = ( $query ) ? "$base_url?$query" : $base_url ; HEADER( "location: $base_url" ) ; exit ; }
	$https = ( $https ) ? "s" : "" ;
	/////////////////////////////////////////////

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$login = Util_Format_Sanatize( Util_Format_GetVar( "phplive_login" ), "ln" ) ;
	$password = Util_Format_Sanatize( Util_Format_GetVar( "phplive_password" ), "ln" ) ;
	$from = Util_Format_Sanatize( Util_Format_GetVar( "from" ), "ln" ) ;
	$wp = ( Util_Format_Sanatize( Util_Format_GetVar( "wp" ), "n" ) ) ? Util_Format_Sanatize( Util_Format_GetVar( "wp" ), "n" ) : 0 ;
	$auto = Util_Format_Sanatize( Util_Format_GetVar( "auto" ), "n" ) ; if ( !$auto && $wp ) { $auto = 1 ; }
	$menu = ( Util_Format_Sanatize( Util_Format_GetVar( "menu" ), "ln" ) == "sa" ) ? "sa" : "operator" ;
	$wpress = Util_Format_Sanatize( Util_Format_GetVar( "wpress" ), "n" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	$remember = Util_Format_Sanatize( Util_Format_GetVar( "remember" ), "ln" ) ;
	$v = Util_Format_Sanatize( Util_Format_GetVar( "v" ), "ln" ) ;
	LIST( $ip, $vis_token ) = Util_IP_GetIP( "" ) ; $now = time() ;

	$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
	LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
	$mobile = ( $os == 5 ) ? 1 : 0 ;

	$error = $reload = $password_new = $auto_login_token = ""  ;
	$auto_login_token_ses = ( $ses ) ? $ses : "" ;
	if ( !isset( $CONF["screen"] ) ) { $CONF["screen"] = "same" ; }
	if ( $auto || $wp || $wpress || ( $query == "op" ) ) { $CONF["screen"] = "separate" ; }

	if ( isset( $_COOKIE["phplive_token"] ) && $_COOKIE["phplive_token"] ) { $token = Util_Format_Sanatize( $_COOKIE["phplive_token"], "ln" ) ; }
	else
	{
		$token = Util_Format_RandomString( 10 ) ;
		setcookie( "phplive_token", $token, 0 ) ;
	}
	if ( isset( $_COOKIE["phplive_auto_login_token"] ) && preg_match( "/\.\./", $_COOKIE["phplive_auto_login_token"] ) )
	{
		$auto_login_token_temp = Util_Format_Sanatize( $_COOKIE["phplive_auto_login_token"], "ln" ) ;
		LIST( $auto_login_token, $auto_login_token_ses ) = explode( "..", $auto_login_token_temp ) ;
	}

	if ( $action == "reset_auto_login" )
	{
		database_mysql_close( $dbh ) ;
		setcookie( "phplive_auto_login_token", FALSE ) ;
		$json_data = "json_data = { \"status\": 1 };" ;
		print $json_data ; exit ;
	}
	else if ( $action == "submit" )
	{
		$menu = Util_Format_Sanatize( Util_Format_GetVar( "menu" ), "ln" ) ;

		if ( $menu == "sa" )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_ext.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_ext.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_ext.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Setup/get.php" ) ;

			$admininfo = Setup_get_InfoByLogin( $dbh, $login ) ;
			if ( isset( $admininfo["adminID"] ) && ( $password == md5($admininfo["password"].$token) ) )
			{
				$ses = md5( $now.$ip ) ;
				Ops_update_ext_AdminValue( $dbh, $admininfo["adminID"], "lastactive", $now ) ;
				Ops_update_ext_AdminValue( $dbh, $admininfo["adminID"], "ses", $ses ) ;
				setcookie( "phplive_adminID", $admininfo['adminID'], -1 ) ;

				$sdate = mktime( 0, 0, 1, date( "m", $now ), date( "j", $now )-1, date( "Y", $now ) ) ;
				database_mysql_close( $dbh ) ;
				HEADER( "location: $base_url/setup/?ses=$ses&$now" ) ;
				exit ;
			} else { $error = "Invalid login or password." ; }
		}
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_ext.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;

			$opinfo = Ops_get_ext_OpInfoByLogin( $dbh, $login ) ;
			if ( isset( $opinfo["opID"] ) && ( $password == md5($opinfo["password"].$token) ) )
			{
				// only one instance of console window per browser type since system uses cookies
				if ( isset( $_COOKIE["phplive_opID"] ) && ( $_COOKIE["phplive_opID"] != $opinfo['opID'] ) )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

					$opid_ = Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ) ;
					$opinfo_ = Ops_get_OpInfoByID( $dbh, $opid_ ) ;
					if ( $opinfo_["lastactive"] > $now-25 )
					{
						Ops_update_OpValue( $dbh, $opid_, "status", 0 ) ;
						Ops_update_OpValue( $dbh, $opid_, "ses", "expired" ) ;
						$reload = 1 ;
					}
				}
				else
				{
					if ( $auto_login_token_ses )
					{
						if ( $opinfo["ses"] != $auto_login_token_ses )
						{
							setcookie( "phplive_auto_login_token", FALSE ) ;
							database_mysql_close( $dbh ) ;
							HEADER( "location: $base_url/logout.php?action=logout&dup=1&wp=$wp&auto=$auto&menu=operator&wpress=$wpress&$now" ) ;
						}
						$remember = 1 ;
					}
					$ses = md5( $now.$ip ) ; Ops_update_OpValue( $dbh, $opinfo["opID"], "ses", $ses ) ;
					Ops_update_OpValue( $dbh, $opinfo["opID"], "lastactive", $now ) ;
				}

				if ( $remember )
				{
					$auto_login_token = md5( "$opinfo[login]$opinfo[password]" )."..".$ses ;
					setcookie( "phplive_auto_login_token", $auto_login_token, $now+(60*60*24*1095) ) ;
				} else { setcookie( "phplive_auto_login_token", FALSE ) ; }

				setcookie( "phplive_opID", $opinfo['opID'], -1 ) ;
			} else { $error = "Invalid login or password." ; }
		}
	}
	else if ( $action == "reset_password" )
	{
		if ( $ip && preg_match( "/$ip/", $VALS["CHAT_SPAM_IPS"] ) )
			$json_data = "json_data = { \"status\": 0, \"error\": \"Could not process request at this time.\" };" ;
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Email.php" ) ;
	
			if ( $menu == "sa" )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Setup/get.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/API/Setup/update.php" ) ;

				$admininfo = Setup_get_InfoByLogin( $dbh, $login ) ;
				if ( isset( $admininfo["adminID"] ) )
				{
					if ( $admininfo["lastactive"] > ( $now-60 ) )
					{
						$time_left = $admininfo["lastactive"] - ( $now-60 ) ;
						$json_data = "json_data = { \"status\": 0, \"error\": \"Please try again in $time_left seconds.\" };" ;
					}
					else if ( $admininfo["status"] == -1 )
						$json_data = "json_data = { \"status\": 0, \"error\": \"Password reset is not available for this account.\" };" ;
					else
					{
						include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
						$departments = Depts_get_AllDepts( $dbh ) ;

						for ( $c = 0; $c < count( $departments ); ++$c )
						{
							$deptinfo = $departments[$c] ;
							if ( $deptinfo["smtp"] )
							{
								$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;

								$CONF["SMTP_HOST"] = $smtp_array["host"] ;
								$CONF["SMTP_LOGIN"] = $smtp_array["login"] ;
								$CONF["SMTP_PASS"] = $smtp_array["pass"] ;
								$CONF["SMTP_PORT"] = $smtp_array["port"] ;
								$CONF["SMTP_API"] = isset( $smtp_array["api"] ) ? $smtp_array["api"] : "" ;
								$CONF["SMTP_DOMAIN"] = isset( $smtp_array["domain"] ) ? $smtp_array["domain"] : "" ;
								break 1 ;
							}
						}

						$base_url = ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$CONF[BASE_URL]" : $CONF["BASE_URL"] ;
						$url = "$base_url/?adminid=$admininfo[adminID]&v=".md5( $now.$admininfo["password"] ) ;
						$message = "To reset the setup admin account password, visit the following URL:\r\n==\r\n\r\n$url\r\n\r\n==\r\nIP: $ip\r\n" ;
						$error = Util_Email_SendEmail( "Setup Admin", $admininfo["email"], "Setup Admin", $admininfo["email"], "Setup Area Password Reset URL", $message, "" ) ;

						$email_partial = string_mask( $admininfo["email"], 4, strlen( $admininfo["email"] ) ) ;
						if ( !$error )
						{
							Setup_update_SetupValue( $dbh, $admininfo["adminID"], "lastactive", $now ) ;
							$json_data = "json_data = { \"status\": 1, \"message\": \"Email sent! Check your setup admin email address ($email_partial).\" };" ;
						}
						else
							$json_data = "json_data = { \"status\": 0, \"error\": \"$error\" };" ;
					}
				} else { $json_data = "json_data = { \"status\": 0, \"error\": \"Could not locate setup admin account ($login).\" };" ; }
			}
			else
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_ext.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;

				$opinfo = Ops_get_ext_OpInfoByLogin( $dbh, $login ) ;
				if ( isset( $opinfo["opID"] ) )
				{
					if ( $opinfo["lastactive"] > ( $now-60 ) )
					{
						$time_left = $opinfo["lastactive"] - ( $now-60 ) ;
						$json_data = "json_data = { \"status\": 0, \"error\": \"Please try again in $time_left seconds.\" };" ;
					}
					else
					{
						include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
						$departments = Depts_get_OpDepts( $dbh, $opinfo["opID"] ) ;

						for ( $c = 0; $c < count( $departments ); ++$c )
						{
							$deptinfo = $departments[$c] ;
							if ( $deptinfo["smtp"] )
							{
								$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;

								$CONF["SMTP_HOST"] = $smtp_array["host"] ;
								$CONF["SMTP_LOGIN"] = $smtp_array["login"] ;
								$CONF["SMTP_PASS"] = $smtp_array["pass"] ;
								$CONF["SMTP_PORT"] = $smtp_array["port"] ;
								$CONF["SMTP_API"] = isset( $smtp_array["api"] ) ? $smtp_array["api"] : "" ;
								$CONF["SMTP_DOMAIN"] = isset( $smtp_array["domain"] ) ? $smtp_array["domain"] : "" ;
								break 1 ;
							}
						}

						$base_url = ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$CONF[BASE_URL]" : $CONF["BASE_URL"] ;
						$url = "$base_url/?opid=$opinfo[opID]&v=".md5( $now.$opinfo["password"] ) ;
						$message = "To reset your operator account password, visit the following URL:\r\n==\r\n\r\n$url\r\n\r\n==\r\nIP: $ip\r\n" ;
						$error = Util_Email_SendEmail( $opinfo["name"], $opinfo["email"], $opinfo["name"], $opinfo["email"], "Operator Password Reset URL", $message, "" ) ;

						$email_partial = string_mask( $opinfo["email"], 4, strlen( $opinfo["email"] ) ) ;
						if ( !$error )
						{
							Ops_update_OpValue( $dbh, $opinfo["opID"], "lastactive", $now ) ;
							$json_data = "json_data = { \"status\": 1, \"message\": \"Email sent! Check your operator account email address ($email_partial).\" };" ;
						} else { $json_data = "json_data = { \"status\": 0, \"error\": \"$error\" };" ; }
					}
				}
				else { $json_data = "json_data = { \"status\": 0, \"error\": \"Could not locate operator account ($login).\" };" ; }
			}
		}
		database_mysql_close( $dbh ) ; print $json_data ;
		exit ;
	}
	else if ( $v )
	{
		$adminid = Util_Format_Sanatize( Util_Format_GetVar( "adminid" ), "ln" ) ;
		$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "ln" ) ;

		if ( $adminid )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Setup/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Setup/update.php" ) ;

			$menu = "sa" ;
			$admininfo = Setup_get_InfoByID( $dbh, $adminid ) ;
			if ( isset( $admininfo["lastactive"] ) && ( $v == md5( $admininfo["lastactive"].$admininfo["password"] ) ) )
			{
				$login = $admininfo["login"] ;
				$password_new = Util_Format_RandomString( 6 ) ;
				Setup_update_SetupValue( $dbh, $admininfo["adminID"], "password", md5( $password_new ) ) ;
			} else { $error = "Password reset URL is invalid or has expired." ; }
		}
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;

			$menu = "operator" ;
			$opinfo = Ops_get_OpInfoByID( $dbh, $opid ) ;
			if ( isset( $opinfo["lastactive"] ) && ( $v == md5( $opinfo["lastactive"].$opinfo["password"] ) ) )
			{
				$login = $opinfo["login"] ;
				$password_new = Util_Format_RandomString( 6 ) ;
				Ops_update_OpValue( $dbh, $opinfo["opID"], "password", md5( $password_new ) ) ;
			} else { $error = "Password reset URL is invalid or has expired." ; }
		}
	}

	if ( !$login && $auto_login_token && $auto_login_token_ses && ( $menu != "sa" ) )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

		$opinfo_ = Ops_get_OpInfoByToken( $dbh, $auto_login_token ) ;

		if ( isset( $opinfo_["opID"] ) )
		{
			database_mysql_close( $dbh ) ;
			$md5_password = md5( $opinfo_["password"].$token ) ;
			HEADER( "location: $base_url/index.php?action=submit&phplive_password=$md5_password&phplive_login=$opinfo_[login]&remember=1&auto=$auto&wp=$wp&menu=operator&wpress=$wpress&ses=$auto_login_token_ses&$now" ) ;
		} else { setcookie( "phplive_auto_login_token", FALSE ) ; }
	}
	// main one included at chat_actions_op_status.php
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;
	if ( !Ops_get_itr_AnyOpsOnline( $dbh, 0 ) )
	{
		$dir_files = glob( $CONF["TYPE_IO_DIR"]."/*", GLOB_NOSORT ) ;
		$total_files = count( $dir_files ) ;
		if ( $total_files )
		{
			for ( $c = 0; $c < $total_files; ++$c )
				unlink( $dir_files[$c] ) ;
		}
	}

	function string_mask( $string, $start, $end, $char_replace = '.' )
	{
		$middle = '' ;
		for ( $c = $start; $c < strlen( $string ); $c++ )
		{
			if ( $string[$c] == "@" ) { $middle .= "@" ; }
			else { $middle .= $char_replace ; }
		}
		return substr( $string, 0, $start ).$middle ;
	}

?>
<?php include_once( "./inc_doctype.php" ) ?>
<?php include_once( "./inc_doctype.php" ) ?>
<?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>
<!--
********************************************************************
* PHP Live! (c) OSI Codes Inc.
* www.phplivesupport.com
********************************************************************
-->
<?php endif ; ?>
<head>
<title> <?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?>Live Chat Solution<?php else: ?>PHP Live! Support<?php endif ; ?> v.<?php echo $VERSION ?> </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8">
<?php include_once( "./inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="./css/setup.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="./js/global.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/global_chat.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/setup.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/jquery.tools.min.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/jquery_md5.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/js_cookie.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/winapp.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/modernizr.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	var loaded = 1 ;
	var base_url = "." ;
	var widget = 0 ; var embed = 0 ;
	var screen_ = ( typeof( phplive_wp ) != "undefined" ) ? "separate" : "<?php echo $CONF["screen"] ?>" ;
	var global_menu ;

	var audio_supported = HTML5_audio_support() ;
	var mp3_support = ( typeof( audio_supported["mp3"] ) != "undefined" ) ? 1 : 0 ;

	$(document).ready(function()
	{
		$("body").css({'background': '#F2F2F2'}) ;
		$("body").show() ;
		init_menu() ;

		<?php if ( $error ): ?>do_alert( 0, '<?php echo $error ?>' ) ;<?php endif ; ?>

		toggle_menu( "<?php echo $menu ?>" ) ;

		<?php
			if ( ( $action == "submit" ) && ( $menu == "operator" ) && !$error )
			{
				if ( $reload )
				{
					print "$('#div_reload').show() ;" ;
					print "setTimeout( function(){ $('#theform').submit() ; }, 15000 ) ;" ;
				}
				else
				{
					print "input_disable() ; $('#btn_login').attr('disabled', true).html('Logging in... <img src=\"pics/loading_fb.gif\" width=\"16\" height=\"11\" border=\"0\" alt=\"\"> ') ; play_sound( 0, \"login_op\", \"new_request_$opinfo[sound1]\" ) ;" ;
					if ( $wp || $auto )
						print "setTimeout( function(){ location.href='$base_url/ops/operator.php?ses=$ses&auto=$auto&wp=$wp' ; }, 4000 ) ;" ;
					else
						print "setTimeout( function(){ location.href='$base_url/ops/?ses=$ses&auto=$auto&wp=$wp' ; }, 4000 ) ;" ;
				}
			}
			else if ( $password_new ) { print "$('#div_password').show() ;" ; }

			if ( $CONF["screen"] == "same" ) { print "$('#div_menus').show() ;" ; }
		?>

		wp_total_visitors(0) ;

		$("#login_remember_text").click(function() {
			$( "input[name=remember]" ).prop( "checked", !$( "input[name=remember]" ).prop( "checked" ) ) ;
		});
	});

	function toggle_menu( themenu )
	{
		$('#popout').hide() ;
		toggle_forgot(0) ;

		if ( !themenu )
		{
			if ( $('#btn_login').html() == "Login as Setup Admin" ) { themenu = "operator" ; }
			else { themenu = "sa" ; }
		}
		global_menu = themenu ;

		if ( themenu == "sa" )
		{
			$('#login_remember').hide() ;
			$('#btn_login_forgot').html( "Reset Setup Admin Password" ) ;
			$('#btn_login').html( "<img src=\"pics/icons/settings.png\" width=\"14\" height=\"14\" border=\"0\" alt=\"\"> Login as Setup Admin" ) ;
			$('#href_forgot').html( "forgot setup admin password" ) ;
			$('#menu_operator').removeClass('info_menu').addClass('info_info') ;
			$('#menu_sa').removeClass('info_info').addClass('info_menu') ;
			$('#radio_login_sa').prop('checked', true) ;

			$('#phplive_login').val( "" ) ;
			if ( screen_ == "same" ) { }
			$('#copyright').show() ;

			if ( typeof( phplive_wp ) != "undefined" )
				$('#popout').show() ;
		}
		else
		{
			if ( screen_ == "separate" ) { $('#login_remember').show() ; }
			else { $('#login_remember').prop('checked', false) ; }
			$('#btn_login_forgot').html( "Reset Operator Password" ) ;
			$('#btn_login').html( "<img src=\"pics/icons/agent.png\" width=\"14\" height=\"14\" border=\"0\" alt=\"\"> Login as Operator" ) ;
			$('#href_forgot').html( "forgot operator password" ) ;
			$('#menu_sa').removeClass('info_menu').addClass('info_info') ;
			$('#menu_operator').removeClass('info_info').addClass('info_menu') ;
			$('#radio_login_operator').prop('checked', true) ;

			$('#phplive_login').val( "<?php echo ( $login ) ? $login : "" ?>" ) ;
			if ( screen_ == "same" ) { $('#copyright').show() ; }
		}

		$('#phplive_login').focus() ;
		$('#menu').val( themenu ) ;
	}

	function do_login()
	{
		if ( $('#phplive_login').val() == "" )
			do_alert( 0, "Blank login is invalid." ) ;
		else if ( $('#phplive_password_temp').val() == "" )
			do_alert( 0, "Blank password is invalid." ) ;
		else
		{
			var md5_password = phplive_md5( phplive_md5($('#phplive_password_temp').val())+Cookies.get("phplive_token") ) ;
			$('#phplive_password').val( md5_password ) ;
			$('#theform').submit() ;
		}
	}

	function do_forgot()
	{
		var json_data = new Object ;
		var unique = unixtime() ;
		var login = $('#phplive_login').val() ;

		if ( !login )
			do_alert( 0, "Please provide the Login." ) ;
		else
		{
			$('#btn_login_forgot').attr("disabled", true) ;

			$.ajax({
			type: "POST",
			url: "./index.php",
			data: "action=reset_password&menu="+global_menu+"&phplive_login="+login+"&unique="+unique,
			success: function(data){
				eval( data ) ;

				if ( json_data.status )
				{
					$('#email_partial').html( json_data.email_partial ) ;
					do_alert_div( ".", 1, json_data.message ) ;
				}
				else
				{
					setTimeout( function(){ $('#btn_login_forgot').attr("disabled", false) ; }, 5000 ) ;
					do_alert( 0, json_data.error ) ;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				do_alert( 0, "Error processing reset password.  Please reload the page and try again." ) ;
			} });
		}
	}

	function input_disable()
	{
		$("#theform :input").attr("disabled", true) ;
	}

	function input_text_listen( e )
	{
		var key = -1 ;
		var shift ;

		key = e.keyCode ;
		shift = e.shiftKey ;

		if ( !shift && ( ( key == 13 ) || ( key == 10 ) ) )
			do_login() ;
	}

	function toggle_forgot( theflag )
	{
		$('#btn_login_forgot').attr("disabled", false) ;
		$('#div_alert').hide() ;
		$('#phplive_login').focus() ;
		
		if ( theflag )
		{
			$('#div_btn_submit').hide() ;
			$('#div_btn_forgot').show() ;
		}
		else
		{
			$('#div_btn_forgot').hide() ;
			$('#div_btn_submit').show() ;
		}
	}
//-->
</script>
</head>
<body style="display: none; overflow: hidden;">

<div id="body" style="padding-bottom: 60px;">
	<div style="width: 100%; padding-top: 30px;">
		<div style="width: 480px; margin: 0 auto;">
			<div style="font-size: 14px; color: #C4C4C3; text-shadow: 1px 1px #FFFFFF;"><?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?>Live Chat Solution<?php else: ?>PHP Live! Support<?php endif ; ?> v.<?php echo $VERSION ?></div>

			<div style="display: none; margin-top: 15px;" id="div_menus">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="info_neutral" id="menu_operator" onClick="toggle_menu('operator')" style="padding: 10px; cursor: pointer;"><input type="radio" name="radio_login" id="radio_login_operator"> Operator Login</div></td>
					<td style="padding-left: 15px;"><div class="info_neutral" id="menu_sa" onClick="toggle_menu('sa')" style="padding: 10px; cursor: pointer;"><input type="radio" name="radio_login" id="radio_login_sa"> Setup Admin Login</div></td>
				</tr>
				</table>
			</div>
		</div>
		<div class="info_neutral" style="width: 480px; height: 300px; margin: 0 auto; margin-top: 15px; padding: 10px; text-shadow: 1px 1px #FFFFFF;">

			<form method="POST" action="<?php echo $base_url ?>/index.php?submit" id="theform">
			<input type="hidden" name="action" value="submit">
			<input type="hidden" name="auto" value="<?php echo $auto ?>">
			<input type="hidden" name="wp" value="<?php echo $wp ?>">
			<input type="hidden" name="menu" id="menu" value="">
			<input type="hidden" name="wpress" id="wpress" value="<?php echo $wpress ?>">
			<input type="hidden" name="phplive_password" id="phplive_password" value="">
			<table cellspacing=0 cellpadding=5 border=0 style="margin-top: 15px; width: 100%;">
			<tr>
				<td>Login</td>
				<td> <input type="text" class="input" name="phplive_login" id="phplive_login" size="15" maxlength="15" value="<?php echo ( $login ) ? $login : "" ?>" onKeyPress="return nospecials(event)" onKeyup="input_text_listen(event);"></td>
				<td>Password</td>
				<td width="100%"> <input type="password" class="input" name="phplive_password_temp" id="phplive_password_temp" size="15" maxlength="35" value="<?php echo ( isset( $password ) && $reload ) ? $password : "" ; ?>" onKeyPress="return noquotes(event)" onKeyup="input_text_listen(event);"></td>
			</tr>
			<tr>
				<td></td>
				<td colspan=3>
					<table cellspacing=0 cellpadding=0 border=0>
					<tr>
						<td><div id="login_remember" style="display: none; padding-top: 15px;"><input type="checkbox" name="remember" id="remember" value=1 <?php echo ( isset( $remember ) && $remember ) ? "checked" :  "" ; ?>> <span id="login_remember_text"> automatically login for future sessions</span></div></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan=3>
					<div id="div_btn_submit" style="margin-top: 10px;">
						<button type="button" id="btn_login" onClick="do_login()" class="btn"></button>
						<div style="margin-top: 35px;">&bull; <a href="JavaScript:void(0)" onClick="toggle_forgot(1)" id="href_forgot"></a></div>
					</div>
					<div id="div_btn_forgot" style="display: none; margin-top: 10px;">
						<div class="info_box">Password reset link will be sent to your account email address.</div>
						<div id="div_alert" style="margin-top: 5px; text-shadow: none;"></div>
						<div style="margin-top: 15px;">
							<button type="button" id="btn_login_forgot" onClick="do_forgot()" class="btn"></button> &nbsp; <a href="JavaScript:void(0)" onClick="toggle_forgot(0)">back to login</a>
						</div>
					</div>
				</td>
			</tr>
			<tr><td></td><td colspan=3><div id="popout" style="margin-top: 35px; display: none;">&bull; access the setup in a <a href="./setup/" target="snew">new window</a></div></td></tr>
			</table>
			</form>

			<div id="div_sounds_login_op" style="width: 1px; height: 1px; overflow: hidden; opacity:0.0; filter: alpha(opacity=0);"></div>

		</div>
		<div style="background: url( ./pics/bg_fade_lite.png ) no-repeat; background-position: top center; width: 500px; height: 13px; margin: 0 auto; opacity:0.3; filter: alpha(opacity=30)" class="round_top">&nbsp;</div>
		<div style="padding: 5px;">
			<div style="width: 480px; margin: 0 auto; font-size: 10px; text-shadow: 1px 1px #FFFFFF;">
				<?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>&copy; OSI Codes Inc. - powered by <a href="http://www.phplivesupport.com/?plk=osicodes-5-ykq-m" target="new">PHP Live! Support</a><?php endif ; ?>
			</div>
		</div>

	</div>
</div>

<div id="div_reload" style="display: none; position: absolute; top: 0px; left: 0px; width: 100%; height: 2000px; background: url( ./pics/bg_trans_white.png ) repeat; overflow: hidden; z-index: 20;">
	<div style="padding: 15px;">loading... <img src="pics/loading_fb.gif" width="16" height="11" border="0" alt=""></div>
</div>
<div style="display: none;"><!-- preload of image --><img src="pics/bg_btn_focus.gif" width="9" height="47" border="0" alt=""></div>

<div id="div_password" style="display: none; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; padding-top: 80px; z-index: 50; background: url(./pics/bg_trans_white.png) repeat;">
	<div class="info_info" style="width: 480px; height: 250px; margin: 0 auto; padding: 10px; text-shadow: 1px 1px #FFFFFF;">
		<div class="edit_title">Your new password for account <span style="color: #ED933F;"><?php echo $login ?></span> is:</div>
		<div class="edit_title" style="margin-top:5px; color: #53BA4B;"><?php echo $password_new ?></div>
		<div style="margin-top: 15px;">Write the password down.  It will not be visible again once this window is closed.  After logging in, be sure to update your password.</div>
		<div style="margin-top: 25px;"><button type="button" onClick="$('#div_password').hide();" class="btn">Close Window and Login</button></div>
	</div>
</div>

</body>
</html>
<?php
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
?>
