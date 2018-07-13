<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../web/config.php" ) ){ HEADER("location: ../setup/install.php") ; exit ; }
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	if ( !$opinfo = Util_Security_AuthOp( $dbh, $ses ) ){ ErrorHandler( 602, "Invalid operator session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; }
	// STANDARD header end
	/****************************************/

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$console = Util_Format_Sanatize( Util_Format_GetVar( "console" ), "ln" ) ; $body_width = ( $console ) ? 800 : 900 ;
	$wp = Util_Format_Sanatize( Util_Format_GetVar( "wp" ), "n" ) ;
	$auto = Util_Format_Sanatize( Util_Format_GetVar( "auto" ), "n" ) ;
	$menu = "settings" ;
	$error = "" ;

	if ( $action == "update_password" )
	{
		$cpass = Util_Format_Sanatize( Util_Format_GetVar( "cpass" ), "ln" ) ;
		$npass = Util_Format_Sanatize( Util_Format_GetVar( "npass" ), "ln" ) ;
		$vnpass = Util_Format_Sanatize( Util_Format_GetVar( "vnpass" ), "ln" ) ;

		if ( $cpass != md5( $opinfo["password"].$_COOKIE["phplive_token"] ) )
			$error = "Current password is invalid." ;
		else if ( $vnpass != md5( $npass.$_COOKIE["phplive_token"] ) )
			$error = "Verify password does not match." ;
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;

			Ops_update_OpValue( $dbh, $opinfo["opID"], "password", $npass ) ;
		}
	}
	else if ( $action == "success" )
	{
		// sucess action is an indicator to show the success alert as well
		// as bypass the reloading of the operator console
	}
	else
		$error = "invalid action" ;

	$auto_login_enabled = ( isset( $_COOKIE["phplive_auto_login_token"] ) && $_COOKIE["phplive_auto_login_token"] ) ? 1 : 0 ;
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> Operator </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../css/setup.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/jquery_md5.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/js_cookie.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/dn.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	var opwin ;
	var menu ;
	var dn = dn_check() ; var dn_enabled = <?php echo $opinfo["dn"] ?> ;
	var embed = 0 ;

	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		init_menu_op() ;
		toggle_menu_op( "<?php echo $menu ?>" ) ;

		<?php if ( $action && !$error ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
		if ( <?php echo $auto_login_enabled ?> ) { $('#div_auto_login_enabled').show() ; }
	});

	function update_password()
	{
		if ( $('#cpass_temp').val() == "" )
			do_alert( 0, "Please provide the current password." ) ;
		else if ( $('#npass_temp').val() == "" )
			do_alert( 0, "Please provide the new password." ) ;
		else if ( $('#npass_temp').val() != $('#vnpass_temp').val() )
			do_alert( 0, "New password does not match." ) ;
		else
		{
			$('#cpass').val( phplive_md5( phplive_md5( $('#cpass_temp').val() )+Cookies.get("phplive_token") ) ) ;
			$('#npass').val( phplive_md5( $('#npass_temp').val() ) ) ;
			$('#vnpass').val( phplive_md5( phplive_md5( $('#npass_temp').val() )+Cookies.get("phplive_token") ) ) ;
			$('#theform').submit() ;
		}
	}

	function reset_auto_login()
	{
		if ( confirm( "Reset the automatic login?  Are you sure?" ) )
		{
			$.ajax({
				type: "POST",
				url: "../index.php",
				data: "action=reset_auto_login&"+unixtime(),
				success: function(data){
					eval(data) ;

					if ( json_data.status )
						location.href = "./settings.php?action=success&wp=<?php echo $wp ?>&auto=<?php echo $auto ?>&console=<?php echo $console ?>&ses=<?php echo $ses ?>&"+unixtime() ;
					else
						do_alert( 0, "Error processing request.  Please try again." ) ;
				}
			});
		}
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ); ?>

		<div id="op_title" class="edit_title" style="margin-bottom: 15px;"></div>

		<div id="op_settings" style="display: none; margin: 0 auto;">
			<?php if ( $action && $error ): ?>
				<div id="div_error" class="info_error" style="margin-bottom: 10px;"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt="">  <?php echo $error ?></div>
			<?php endif; ?>

			<div style="">
			<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td valign="top">
					<div id="div_password_update">
						<form method="POST" action="settings.php?submit" id="theform">
						<input type="hidden" name="action" value="update_password">
						<input type="hidden" name="console" value="<?php echo $console ?>">
						<input type="hidden" name="auto" value="<?php echo $auto ?>">
						<input type="hidden" name="wp" value="<?php echo $wp ?>">
						<input type="hidden" name="ses" value="<?php echo $ses ?>">
						<input type="hidden" name="cpass" id="cpass" value="">
						<input type="hidden" name="npass" id="npass" value="">
						<input type="hidden" name="vnpass" id="vnpass" value="">
						<img src="../pics/icons/key.png" width="16" height="16" border="0" alt=""> Update Your Operator Account Password

						<div style="margin-top: 15px;">Current Password</div>
						<input type="password" class="input" name="cpass_temp" id="cpass_temp" size="30" maxlength="50" value="">

						<div style="margin-top: 15px;">New Password</div>
						<input type="password" class="input" name="npass_temp" id="npass_temp" size="30" maxlength="50" value=""><div style="font-size: 10px;">* letters and numbers</div>

						<div style="margin-top: 15px;">Verify New Password</div>
						<input type="password" class="input" name="vnpass_temp" id="vnpass_temp" size="30" maxlength="50" value=""><div style="font-size: 10px;">* letters and numbers</div>

						<div style="margin-top: 10px;"><input type="button" value="Update Password" onClick="update_password()" class="btn"></div>
						</form>
					</div>
				</td>
				<td valign="top" style="padding-left: 50px; width: 200px;">
					<div id="div_auto_login_enabled" style="display: none; height: 250px;" class="info_info">
						<img src="../pics/icons/vcard.png" width="16" height="16" border="0" alt=""> Reset Automatic Login

						<div style="margin-top: 15px;" class="info_good">Automatic login is active.</div>
						<div style="margin-top: 15px;">
							Reset the automatic login and enter the login credentials next time you sign on.
							<div style="margin-top: 15px;"><input type="button" value="Reset Automatic Login" onClick="reset_auto_login()" class="btn"></div>
						</div>
					</div>
				</td>
			</tr>
			</table>
			</div>
		</div>

		<?php if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/inc_lang.php" ) ): ?>
		<div id="op_language" style="display: none; margin: 0 auto;">
			<iframe src="../addons/inc_lang.php" style="width:100%; height: 120px; border: 0px;" scrolling="no" frameBorder="0"></iframe>
		</div>
		<?php endif ; ?>

<?php include_once( "./inc_footer.php" ); ?>
