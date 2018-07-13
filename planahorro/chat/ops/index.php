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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$console = Util_Format_Sanatize( Util_Format_GetVar( "console" ), "ln" ) ; $body_width = ( $console ) ? 800 : 900 ;
	$menu = Util_Format_Sanatize( Util_Format_GetVar( "menu" ), "ln" ) ;
	$wp = Util_Format_Sanatize( Util_Format_GetVar( "wp" ), "n" ) ;
	$auto = Util_Format_Sanatize( Util_Format_GetVar( "auto" ), "n" ) ;
	$menu = ( $menu ) ? $menu : "go" ;
	$error = "" ;

	$op_depts = Ops_get_OpDepts( $dbh, $opinfo["opID"] ) ;

	if ( $action == "update_theme" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
		$theme = Util_Format_Sanatize( Util_Format_GetVar( "theme" ), "ln" ) ;

		if ( !Ops_update_OpValue( $dbh, $opinfo["opID"], "theme", $theme ) )
			$error = "Error in updating theme." ;
		else
			$opinfo["theme"] = $theme ;
		
		$menu = "themes" ;
	}
	else if ( $action == "success" )
	{
		// sucess action is an indicator to show the success alert as well
		// as bypass the reloading of the operator console
	}
	else
		$error = "invalid action" ;
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
<script type="text/javascript" src="../js/global_chat.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/jquery.tools.min.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/jquery_md5.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/js_cookie.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/dn.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/modernizr.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	var opwin ;
	var menu ;
	var theme = "<?php echo $opinfo["theme"] ?>" ;
	var base_url = ".." ; // needed for function play_sound()
	var embed = 0 ;

	var audio_supported = HTML5_audio_support() ;
	var mp3_support = ( typeof( audio_supported["mp3"] ) != "undefined" ) ? 1 : 0 ;

	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		$('#op_launch_btn').on('mouseover mouseout', function(event) {
			$('#op_launch_btn').toggleClass('op_launch_btn_focus') ;
		});

		init_menu_op() ;
		toggle_menu_op( "<?php echo $menu ?>" ) ;

		<?php if ( $action && !$error ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
		
		if ( ( typeof( parent.isop ) != "undefined" ) && ( "<?php echo $action ?>" == "update_theme" ) )
			parent.reload_console() ;
	});

	function launchit()
	{
		var open_status_offline = ( $('#open_status_offline').is(':checked') ) ? 1 : 0 ;
		var screen_width = screen.width ;
		var screen_height = screen.height ;
		var url = "operator.php?ses=<?php echo $ses ?>&wp=<?php echo $wp ?>&auto=<?php echo $auto ?>&console=<?php echo $console ?>&pop=1&open_status_offline="+open_status_offline+"&"+unixtime() ;

		var console_width = ( screen_width > 1200 ) ? 1100 : 940 ;
		var console_height = ( screen_height > 1000 ) ? 650 : 580 ;

		if ( !<?php echo count( $op_depts ) ?> )
			$('#no_dept').show() ;
		else
		{
			if ( typeof( opwin ) == "undefined" )
				opwin = window.open( url, "<?php echo $ses ?>", "scrollbars=yes,menubar=no,resizable=1,location=no,width="+console_width+",height="+console_height+",status=0" ) ;
			else if ( opwin.closed )
				opwin = window.open( url, "<?php echo $ses ?>", "scrollbars=yes,menubar=no,resizable=1,location=no,width="+console_width+",height="+console_height+",status=0" ) ;

			if ( opwin )
			{
				opwin.focus() ;
			}
		}

		return true ;
	}

	function confirm_theme( thetheme )
	{
		if ( theme != thetheme )
		{
			if ( confirm( "Select theme "+thetheme+"?" ) )
				update_theme( thetheme ) ;
			else
				$('#theme_<?php echo $opinfo["theme"] ?>').prop('checked', true) ;
		}
	}

	function update_theme( thetheme )
	{
		location.href = 'index.php?console=<?php echo $console ?>&ses=<?php echo $ses ?>&wp=<?php echo $wp ?>&auto=<?php echo $auto ?>&action=update_theme&theme='+thetheme ;
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ); ?>

		<div id="op_title" class="edit_title" style="margin-bottom: 15px;"></div>
		<div id="op_go" style="margin: 0 auto;">
			<div id="no_dept" class="info_error" style="display: none;"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Contact the Setup Admin to assign this account to a department.  Once assigned, <a href="./?ses=<?php echo $ses ?>&<?php echo time() ?>" style="color: #FFFFFF;">refresh</a> this page to continue.</div>

			<div style="margin-top: 10px;">
				<div class="info_good" style="float: left; width: 220px; padding: 3px;">
					<table cellspacing=0 cellpadding=2 border=0>
					<tr>
						<td><input type="radio" name="open_status" id="open_status_online" value=1 checked></td>
						<td>open console with status Online</td>
					</tr>
					</table>
				</div>
				<div class="info_error" style="float: left; margin-left: 10px; width: 220px; padding: 3px;">
					<table cellspacing=0 cellpadding=2 border=0>
					<tr>
						<td><input type="radio" name="open_status" id="open_status_offline" value=0></td>
						<td>open console with status Offline</td>
					</tr>
					</table>
				</div>
				<div style="clear: both;"></div>
			</div>
			<div id="op_launch_btn" style="margin-top: 25px; border: 1px solid #049BD8; padding: 10px; font-size: 18px; font-weight: bold; color: #FFFFFF; text-shadow: 1px 1px #049BD8; text-align: center; cursor: pointer;" onClick="launchit()" class="op_launch_btn round"><img src="../pics/icons/pointer.png" width="16" height="16" border="0" alt=""> Click to open operator console to accept visitor chat requests.</div>
		</div>

		<div id="op_themes" style="display: none; margin: 0 auto;">
			<img src="../pics/icons/themes.png" width="16" height="16" border="0" alt=""> Click the theme name to preview the theme.  If the operator console is open, reload the operator console for the new theme to take affect.

			<form>
			<table cellspacing=0 cellpadding=2 border=0 width="100%" style="margin-top: 25px;">
			<tr>
				<td>
					<?php
						$deptid = ( count( $op_depts ) ) ? $op_depts[0]["deptID"] : 0 ;
						$dir_themes = opendir( "$CONF[DOCUMENT_ROOT]/themes/" ) ;

						$themes = Array() ;
						while ( $theme = readdir( $dir_themes ) )
							$themes[] = $theme ;
						closedir( $dir_themes ) ;

						sort( $themes, SORT_STRING ) ;
						for ( $c = 0; $c < count( $themes ); ++$c )
						{
							$theme = $themes[$c] ;

							$checked = "" ;
							if ( $opinfo["theme"] == $theme )
								$checked = "checked" ;

							$path_thumb = ( is_file( "../themes/$theme/thumb.png" ) ) ? "../themes/$theme/thumb.png" : "../pics/screens/thumb_theme_blank.png" ;

							if ( preg_match( "/[a-z]/i", $theme ) && ( $theme != "initiate" ) )
								print "<div class=\"li_op round\" style=\"padding: 5px; width: 150px; margin-bottom: 15px;\"><div style=\"background: url( $path_thumb ); background-position: top left; height: 100px; -moz-border-radius: 5px; border-radius: 5px;\"><input type=\"radio\" name=\"theme\" id=\"theme_$theme\" value=\"$theme\" $checked onClick=\"confirm_theme('$theme')\"> <span class=\"info_neutral\" style=\"cursor: pointer;\" onClick=\"preview_theme('$theme', $VARS_CHAT_WIDTH, $VARS_CHAT_HEIGHT, $deptid)\">$theme</span></div></div>" ;
						}
					?>
					<div style="clear: both;"></div>
				</td>
			</tr>
			</table>
			</form>
		</div>

		<?php if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/inc_lang.php" ) ): ?>
		<div id="op_language" style="display: none; margin: 0 auto;">
			<iframe src="../addons/inc_lang.php" style="width:100%; height: 120px; border: 0px;" scrolling="no" frameBorder="0"></iframe>
		</div>
		<?php endif ; ?>

<?php include_once( "./inc_footer.php" ); ?>
