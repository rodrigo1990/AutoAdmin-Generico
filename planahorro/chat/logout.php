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

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$ao = Util_Format_Sanatize( Util_Format_GetVar( "ao" ), "n" ) ;
	$rd = Util_Format_Sanatize( Util_Format_GetVar( "rd" ), "n" ) ;
	$dup = Util_Format_Sanatize( Util_Format_GetVar( "dup" ), "n" ) ;
	$auto = Util_Format_Sanatize( Util_Format_GetVar( "auto" ), "n" ) ;
	$pop = Util_Format_Sanatize( Util_Format_GetVar( "pop" ), "n" ) ;
	$wp = ( Util_Format_Sanatize( Util_Format_GetVar( "wp" ), "ln" ) ) ? Util_Format_Sanatize( Util_Format_GetVar( "wp" ), "ln" ) : 0 ;
	$menu = ( Util_Format_Sanatize( Util_Format_GetVar( "menu" ), "ln" ) == "sa" ) ? "sa" : "operator" ;
	$wpress = Util_Format_Sanatize( Util_Format_GetVar( "wpress" ), "ln" ) ;
	$now = time() ;

	$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
	LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
	$mobile = ( $os == 5 ) ? 1 : 0 ;

	if ( $action == "logout" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;

		if ( $menu == "sa" )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_ext.php" ) ;

			if ( isset( $_COOKIE["phplive_adminID"] ) && $_COOKIE["phplive_adminID"] ) { Ops_update_ext_AdminValue( $dbh, Util_Format_Sanatize( $_COOKIE["phplive_adminID"], "n" ), "ses", "" ) ; setcookie( "phplive_adminID", FALSE ) ; }
			else
			{
				HEADER( "location: ./?menu=sa&$now" ) ;
				exit ;
			}
		}
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;

			if ( isset( $_COOKIE["phplive_opID"] ) )
			{
				if ( !$dup )
				{
					Ops_update_putOpStatus( $dbh, Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ), 0 ) ;
					Ops_update_OpValue( $dbh, Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ), "status", 0 ) ;
				}

				if ( $rd ) { Ops_update_OpValue( $dbh, Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ), "ses", "" ) ; }
				if ( $dup || $rd ) { setcookie( "phplive_auto_login_token", FALSE ) ; }
				setcookie( "phplive_opID", FALSE ) ;
			}
		}

		// main one included at chat_actions_op_status.php
		if ( !Ops_get_itr_AnyOpsOnline( $dbh, 0 ) )
		{
			$initiate_dir = $CONF["TYPE_IO_DIR"] ; 
			$dh = dir( $initiate_dir ) ; 
			while( $file = $dh->read() ) { 
				if ( ( $file != "." ) && ( $file != ".." ) && is_file( $file ) ) { unlink( "$initiate_dir/$file" ) ; }
			} $dh->close() ;
		}
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
<title> <?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?>Live Chat Solution<?php else: ?>PHP Live! Support<?php endif ; ?> v.<?php echo $VERSION ?> [Logout] </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8">
<?php include_once( "./inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="./css/setup.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="./js/global.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/winapp.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	var loaded = 1 ;
	var base_url = "." ;

	$(document).ready(function()
	{
		$("body").css({'background': '#F2F2F2'}) ;
		$("body").show() ;

		<?php if ( $ao ): ?>$('#div_automatic_offline').show() ;
		<?php elseif ( $rd ): ?>$('#div_remote_disconnect').show() ;
		<?php elseif ( $dup ): ?>$('#div_duplicate_login').show() ;
		<?php endif ; ?>

		wp_total_visitors(0) ;
	});
//-->
</script>
</head>
<body style="display: none; overflow: hidden;">

<div id="body" style="padding-bottom: 60px;">
	<div style="width: 100%; padding-top: 30px;">
		<div style="width: 480px; margin: 0 auto;">
			<div style="font-size: 14px; color: #C4C4C3; text-shadow: 1px 1px #FFFFFF;"><?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?>Live Chat Solution<?php else: ?>PHP Live! Support<?php endif ; ?> v.<?php echo $VERSION ?></div>
		</div>
		<div class="info_neutral" style="width: 480px; margin: 0 auto; margin-top: 15px; padding: 10px; text-shadow: 1px 1px #FFFFFF;">

			<div style="display: none; text-shadow: none; margin-bottom: 15px;" class="info_error" id="div_automatic_offline">
				<img src="pics/icons/alert.png" width="16" height="16" border="0" alt=""> <span style='font-size: 14px; font-weight: bold;'>Automatic Offline</span>
				<div style="margin-top: 10px;">You have been automatically logged out because it is past regular chat support hours.</div>
			</div>
			<div style="display: none; text-shadow: none; margin-bottom: 15px;" class="info_error" id="div_remote_disconnect">
				<img src="pics/icons/alert.png" width="16" height="16" border="0" alt=""> <span style='font-size: 14px; font-weight: bold;'>Remote Disconnect</span>
				<div style="margin-top: 10px;">The Setup Admin has remotely disconnected the operator console.</div>
			</div>
			<div style="display: none; text-shadow: none; margin-bottom: 15px;" class="info_error" id="div_duplicate_login">
				<img src="pics/icons/alert.png" width="16" height="16" border="0" alt=""> <span style='font-size: 14px; font-weight: bold;'>Duplicate Login</span>
				<div style="margin-top: 10px;">Operator account logged in at another location.  This session has expired.</div>
			</div>

			<div style="font-size: 14px;" class="info_box">You have been successfully logged out.</div>

			<div id="div_back" style="margin-top: 15px; margin-bottom: 15px;"><img src="pics/icons/arrow_left.png" width="14" height="13" border="0" alt=""> <a href="./?wp=<?php echo $wp ?>&auto=<?php echo $auto ?>&menu=<?php echo $menu ?>&<?php echo $now ?>">back to login</a></div>

		</div>
		<div style="background: url( ./pics/bg_fade_lite.png ) no-repeat; background-position: top center; width: 500px; height: 13px; margin: 0 auto; opacity:0.3; filter: alpha(opacity=30)" class="round_top">&nbsp;</div>
		<div style="padding: 5px;">
			<div style="width: 480px; margin: 0 auto; font-size: 10px; text-shadow: 1px 1px #FFFFFF;">
				<?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>&copy; OSI Codes Inc. - powered by <a href="http://www.phplivesupport.com/?plk=osicodes-5-ykq-m" target="new">PHP Live! Support</a><?php endif ; ?>
			</div>
		</div>

	</div>
</div>

</body>
</html>
<?php
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
?>
