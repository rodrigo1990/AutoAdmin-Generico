<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../web/config.php" ) ){ HEADER("location: install.php") ; exit ; }
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh, $ses ) ){ ErrorHandler( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; }
	// STANDARD header end
	/****************************************/

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Hash.php" ) ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_File.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$https = "" ;
	if ( isset( $_SERVER["HTTP_CF_VISITOR"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_CF_VISITOR"] ) ) { $https = "s" ; }
	else if ( isset( $_SERVER["HTTP_X_FORWARDED_PROTO"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_X_FORWARDED_PROTO"] ) ) { $https = "s" ; }
	else if ( isset( $_SERVER["HTTPS"] ) && preg_match( "/(on)/i", $_SERVER["HTTPS"] ) ) { $https = "s" ; }

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = ( Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ) ? Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) : "logo" ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;
	$lang = Util_Format_Sanatize( Util_Format_GetVar( "lang" ), "ln" ) ;

	if ( !isset( $CONF["screen"] ) ) { $CONF["screen"] = "same" ; }
	if ( !isset( $CONF["THEME"] ) ) { $CONF["THEME"] = "default" ; }
	if ( !isset( $VALS["POPOUT"] ) ) { $VALS["POPOUT"] = "on" ; }
	if ( !isset( $VALS["DEPT_NAME_VIS"] ) ) { $VALS["DEPT_NAME_VIS"] = "off" ; }
	if ( !isset( $CONF["lang"] ) ) { $CONF["lang"] = "english" ; } if ( !$lang ) { $lang = $CONF["lang"] ; }

	$error = "" ;

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	LIST( $your_ip, $null ) = Util_IP_GetIP( "" ) ;

	if ( $action == "update" )
	{
		if ( $jump == "logo" )
			$error = Util_Upload_File( "logo", $deptid ) ;
		else if ( $jump == "time" )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove.php" ) ;

			$timezone = Util_Format_Sanatize( Util_Format_GetVar( "timezone" ), "timezone" ) ;

			if ( $timezone != $CONF["TIMEZONE"] )
				Chat_remove_ResetReports( $dbh ) ;

			$error = ( Util_Vals_WriteToConfFile( "TIMEZONE", $timezone ) ) ? "" : "Could not write to config file." ;
			if ( phpversion() >= "5.1.0" ){ date_default_timezone_set( $timezone ) ; }
		}
	}
	else if ( $action == "screen" )
	{
		$screen = Util_Format_Sanatize( Util_Format_GetVar( "screen" ), "ln" ) ;
		$error = ( Util_Vals_WriteToConfFile( "screen", $screen ) ) ? "" : "Could not write to config file." ;
		$CONF["screen"] = $screen ;

		$jump = "screen" ;
	}

	$screen_same = ( $CONF["screen"] == "same" ) ? "checked" : "" ;
	$screen_separate = ( $screen_same == "checked" ) ? "" : "checked" ;

	// auto write conf file if variables do not exist
	if ( !isset( $CONF["API_KEY"] ) )
	{
		$CONF["API_KEY"] = Util_Format_RandomString( 10 ) ;
		$error = ( Util_Vals_WriteToConfFile( "API_KEY", $CONF["API_KEY"] ) ) ? "" : "Could not write to config file." ;
	}

	$departments = Depts_get_AllDepts( $dbh ) ;
	$timezones = Util_Hash_Timezones() ;
	$vars = Util_Format_Get_Vars( $dbh ) ;
	$charset = ( isset( $vars["char_set"] ) && $vars["char_set"] ) ? unserialize( $vars["char_set"] ) : Array(0=>"UTF-8") ;
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> PHP Live! Support <?php echo $VERSION ?> </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
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

<script type="text/javascript">
<!--
	var theme = "<?php echo $CONF["THEME"] ?>" ;
	var global_div ;
	var global_charset = "<?php echo $charset[0] ?>" ;
	var global_popout = "<?php echo ( isset( $VALS["POPOUT"] ) && $VALS["POPOUT"] ) ? $VALS["POPOUT"] : "on" ; ?>" ;
	var global_dept_name_vis = "<?php echo $VALS["DEPT_NAME_VIS"] ?>" ;

	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		init_menu() ;
		toggle_menu_setup( "interface" ) ;

		show_div( "<?php echo $jump ?>" ) ;

		<?php if ( $action && !$error ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
		<?php if ( $action && $error ): ?>do_alert_div( "..", 0, "<?php echo $error ?>" ) ;<?php endif ; ?>

		$('#urls_<?php echo $CONF["screen"] ?>').show() ;

		check_logo_dim() ;
	});

	function show_div( thediv )
	{
		$('#div_alert').hide() ;
	
		var divs = Array( "logo", "themes", "charset", "time", "screen", "misc_settings", "lang" ) ;
		for ( c = 0; c < divs.length; ++c )
		{
			$('#settings_'+divs[c]).hide() ;
			$('#menu_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('input#jump').val( thediv ) ;
		$('#settings_'+thediv).show() ;
		$('#menu_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function switch_dept( theobject )
	{
		location.href = "interface.php?ses=<?php echo $ses ?>&deptid="+theobject.value ;
	}

	function update_timezone()
	{
		var timezone = $('#timezone').val() ;

		if ( confirm( "This action will reset the chat reports data.  Are you sure?" ) )
			location.href = "interface.php?ses=<?php echo $ses ?>&action=update&jump=time&timezone="+timezone ;
	}

	function confirm_charset( thecharset )
	{
		if ( global_charset != thecharset )
		{
			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=update_vars&varname=char_set&value="+thecharset+"&"+unixtime(),
				success: function(data){
					global_charset = thecharset ;
					do_alert( 1, "Success!" ) ;
				}
			});
		}
	}

	function check_logo_dim()
	{
		var img = new Image() ;
		img.onload = get_img_dim ;
		img.src = '<?php print Util_Upload_GetLogo( $deptid ) ?>' ;
	}

	function get_img_dim()
	{
		var img_width = this.width ;
		var img_height = this.height ;

		$('#div_logo').css({'width': img_width, 'height': img_height}) ;
	}

	function confirm_popout( thepopout )
	{
		if ( global_popout != thepopout )
		{
			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=update_popout&value="+thepopout+"&"+unixtime(),
				success: function(data){
					global_popout = thepopout ;
					do_alert( 1, "Success!" ) ;
				}
			});
		}
	}

	function confirm_dept_name_vis( the_dept_name_vis )
	{
		if ( global_dept_name_vis != the_dept_name_vis )
		{
			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=update_dept_name_vis&value="+the_dept_name_vis+"&"+unixtime(),
				success: function(data){
					global_dept_name_vis = the_dept_name_vis ;
					do_alert( 1, "Success!" ) ;
				}
			});
		}
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" onClick="show_div('logo')" id="menu_logo">Logo</div>
			<div class="op_submenu" onClick="show_div('themes')" id="menu_themes">Themes</div>
			<div class="op_submenu" onClick="show_div('charset')" id="menu_charset">Character Set</div>
			<?php if ( phpversion() >= "5.1.0" ): ?><div class="op_submenu" onClick="show_div('time')" id="menu_time">Time Zone</div><?php endif; ?>
			<!-- <div class="op_submenu" onClick="show_div('lang')" id="menu_lang">Language Text</div> -->
			<div class="op_submenu" onClick="show_div('misc_settings')" id="menu_misc_settings">Settings</div>
			<div class="op_submenu" onClick="show_div('screen')" id="menu_screen">Login Screen</div>
			<div style="clear: both"></div>
		</div>

		<form method="POST" action="interface.php?submit" enctype="multipart/form-data">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="jump" id="jump" value="">
		<input type="hidden" name="ses" value="<?php echo $ses ?>">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $VARS_MAX_CHAT_FILESIZE ?>">

		<div style="display: none; margin-top: 25px;" id="settings_logo">
			<div style="">
				<select name="deptid" id="deptid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this )">
					<option value="0">Global Default</option>
					<?php
						if ( count( $departments ) > 1 )
						{
							for ( $c = 0; $c < count( $departments ); ++$c )
							{
								$department = $departments[$c] ;
								if ( $department["name"] != "Archive" )
								{
									$selected = ( $deptid == $department["deptID"] ) ? "selected" : "" ;
									print "<option value=\"$department[deptID]\" $selected>$department[name]</option>" ;
								}
							}
						}
					?>
				</select>
			</div>
			<div style="margin-top: 15px;">If more then one <a href="depts.php?ses=<?php echo $ses ?>">department</a> have been created, the "Global Default" logo will be displayed until a new logo has been uploaded for that department.  Keep in mind, the department logo will go into affect for the department specific <a href="code.php?ses=<?php echo $ses ?>">HTML Code</a> option only.</div>

			<div style="margin-top: 15px;" class="info_box"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> To maximize the visible chat space, the logo is not displayed with the <a href="icons.php?ses=<?php echo $ses ?>&jump=settings">embed chat setting</a>.</div>

			<table cellspacing=0 cellpadding=0 border=0 width="100%" class="edit_wrapper" style="margin-top: 15px;">
			<tr>
				<td valign="top">
					<?php if ( isset( $deptinfo["deptID"] ) && !$deptinfo["visible"] ): ?>
					<div class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> <?php echo $deptinfo["name"] ?> Department is <a href="depts.php?ses=<?php echo $ses ?>">not visible</a> to the public.  Department Logo not available.</div>

					<?php else: ?>

						<div id="div_alert" style="display: none; margin-bottom: 25px;"></div>

						<?php if ( ( count( $departments ) == 1 ) && isset( $deptinfo["deptID"] ) ): ?>
						<div class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Because only one department is available, choose the "Global Default" to upload your logo.</div>

						<?php else: ?>
						<div class="edit_title"><?php echo ( isset( $deptinfo["name"] ) ) ? $deptinfo["name"] : "Global Default" ; ?> LOGO</div>
						<div style="margin-top: 10px;">
							<input type="file" name="logo" size="30"><p>
							<input type="submit" value="Upload Image" style="margin-top: 10px;" class="btn">
						</div>

						<div style="margin-top: 15px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> Recommended maximum logo size is 520 pixels width and 55 pixels height.</div>
						<div id="div_logo" style="border: 1px solid #DFDFDF; margin-top: 25px; background: url( <?php print Util_Upload_GetLogo( $deptid ) ?> ) no-repeat;">&nbsp;</div>

						<div style="margin-top: 15px;"><img src="../pics/icons/bullet.png" width="16" height="16" border="0" alt=""> <a href="JavaScript:void(0)" onClick="preview_theme('<?php echo $CONF["THEME"] ?>', <?php echo $VARS_CHAT_WIDTH ?>, <?php echo $VARS_CHAT_HEIGHT ?>, <?php echo $deptid ?> )">view how it looks</a></div>
						<?php endif ; ?>

					<?php endif; ?>
				</td>
			</tr>
			</table>
		</div>

		<div style="display: none; margin-top: 25px; text-align: justify;" id="settings_themes">
			<div>Visitor chat window theme.  Operators will be able to set their own theme by logging into the <a href="ops.php?ses=<?php echo $ses ?>&jump=online">Operator area</a>.</div>
			<div style="margin-top: 25px;"><img src="../pics/icons/arrow_right.png" width="16" height="15" border="0" alt=""> Visitor chat window theme can be set for each department at the <a href="depts.php?ses=<?php echo $ses ?>">Departments area.</a></div>
		</div>

		<div style="display: none; margin-top: 25px;" id="settings_charset">
			If multi-language characters are not rendering properly on the operator chat window or while viewing transcripts, try updating the character set value.  UTF-8 is suggested.

			<div style="margin-top: 25px;">
				<div class="li_op round"><input type="radio" name="charset" id="charset_UTF-8" value="UTF-8" onClick="confirm_charset(this.value)" <?php echo ( $charset[0] == "UTF-8" ) ? "checked" : "" ?>> UTF-8</div>
				<div class="li_op round"><input type="radio" name="charset" id="charset_ISO-8859-1" value="ISO-8859-1" onClick="confirm_charset(this.value)" <?php echo ( $charset[0] == "ISO-8859-1" ) ? "checked" : "" ?>> ISO-8859-1</div>
				<div style="clear: both;"></div>
			</div>
		</div>

		<?php if ( phpversion() >= "5.1.0" ): ?>
		<div style="display: none; margin-top: 25px;" id="settings_time">
			<div>Current system time based on timezone: <b><?php echo $CONF['TIMEZONE'] ?></b></div>
			<div style="margin-top: 15px; font-size: 32px; font-weight: bold; color: #79C2EB; font-family: sans-serif;"><?php echo date( "M j, Y (g:i a)", time() ) ; ?></div>

			<div style="margin-top: 15px;">Updating the timezone will clear the <a href="reports_chat.php?ses=<?php echo $ses ?>">chat reports data</a>.  The chat report reset is necessary because the past data timezone will conflict with the new timezone.  Be sure to print out the report as backup before continuing.  The chat <a href="transcripts.php?ses=<?php echo $ses ?>">transcripts</a> will not be affected but the creation timestamp may be different from the original due to the timezone change.</div>

			<div style="margin-top: 15px;">
				<select id="timezone">
				<?php
					for ( $c = 0; $c < count( $timezones ); ++$c )
					{
						$selected = "" ;
						if ( $timezones[$c] == date_default_timezone_get() )
							$selected = "selected" ;

						print "<option value=\"$timezones[$c]\" $selected>$timezones[$c]</option>" ;
					}
				?>
				</select>
			</div>
			
			<div style="margin-top: 25px;"><button type="button" onClick="update_timezone()" class="btn">Update</button></div>
		</div>
		<?php endif; ?>

		<div style="display: none; margin-top: 25px;" id="settings_screen">
			Choose whether to display the operator login and the setup login screens on the same URL or separate URLs.
			<div style="margin-top: 15px;" class="info_box"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> To enable the <span style="font-weight: bold;"><a href="http://www.phplivesupport.com/r.php?r=autologin" target="new">operator automatic login</a></span> feature, the setting should be set to Separate URLs.</div>
		
			<div style="margin-top: 25px;">
				<div class="li_op round"><input type="radio" name="screen" id="screen_one" value="same" onClick="location.href='interface.php?ses=<?php echo $ses ?>&action=screen&screen=same'" <?php echo $screen_same ?>> Same URL</div>
				<div class="li_op round"><input type="radio" name="screen" id="screen_two" value="separate" onClick="location.href='interface.php?ses=<?php echo $ses ?>&action=screen&screen=separate'" <?php echo $screen_separate ?>> Separate URLs</div>
				<div style="clear: both;"></div>
			</div>

			<div style="margin-top: 25px;">
				<div id="urls_same" style="display: none;" class="info_info">
					<div style=""><img src="../pics/icons/key.png" width="16" height="16" border="0" alt=""> <img src="../pics/icons/bulb.png" width="16" height="16" border="0" alt="">Operator and Setup Login URL</div>
					<div style="margin-top: 5px; font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$CONF[BASE_URL]" : $CONF["BASE_URL"] ; ?>" target="new" style="color: #8DB173;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$CONF[BASE_URL]" : $CONF["BASE_URL"] ; ?></a></div>
				</div>
				<div id="urls_separate" style="display: none;">
					<div class="info_info">
						<div style="font-size: 14px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><img src="../pics/icons/bulb.png" width="16" height="16" border="0" alt=""> Operator Login URL</div>
						<div style="margin-top: 5px; font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$CONF[BASE_URL]" : $CONF["BASE_URL"] ; ?>" target="new" style="color: #8DB173;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$CONF[BASE_URL]" : $CONF["BASE_URL"] ; ?></a></div>
					</div>

					<div class="info_info" style="margin-top: 25px;">
						<div style="font-size: 14px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><img src="../pics/icons/key.png" width="16" height="16" border="0" alt=""> Setup Login URL</div>
						<div style="margin-top: 5px; font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$CONF[BASE_URL]" : $CONF["BASE_URL"] ; ?>/setup" target="new" style="color: #8DB173;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$CONF[BASE_URL]" : $CONF["BASE_URL"] ; ?>/setup</a></div>
					</div>
				</div>
			</div>
		</div>

		<div style="display: none; margin-top: 25px;" id="settings_misc_settings">
			<div style="" class="info_info">
				<div style="font-size: 14px; font-weight: bold;">Embed Chat Popout</div>
				
				<div style="margin-top: 15px;">(default is On) If <a href="icons.php?ses=<?php echo $ses ?>&jump=settings">embed chat</a> is enabled, switch on/off the embed chat "popout" feature.  The "popout" feature enables the visitor to open the embed chat in a new window when clicking the "popout" icon <img src="../pics/icons/win_pop.png" width="16" height="16" border="0" alt="">.  By switching off the embed chat "popout", the chat "popout" icon <img src="../themes/default/win_pop.png" width="16" height="16" border="0" alt=""> will not be visible.  Switching off the "popout" feature will also remove the print icon <img src="../themes/default/printer.png" width="16" height="16" border="0" alt=""> during a chat session (visitor chat).</div>
				<div style="margin-top: 15px;">
					<div class="info_good" style="float: left; width: 60px; padding: 3px;"><input type="radio" name="popout" id="popout_on" value="on" onClick="confirm_popout(this.value)" <?php echo ( $VALS["POPOUT"] != "off" ) ? "checked" : "" ?>> On</div>
					<div class="info_error" style="float: left; margin-left: 10px; width: 60px; padding: 3px;"><input type="radio" name="popout" id="popout_off" value="off" onClick="confirm_popout(this.value)" <?php echo ( $VALS["POPOUT"] == "off" ) ? "checked" : "" ?>> Off</div>
					<div style="clear: both;"></div>
				</div>
			</div>

			<div style="margin-top: 15px;" class="info_info">
				<div style="font-size: 14px; font-weight: bold;">Department Name Visible for One Department</div>
				
				<div style="margin-top: 15px;">(default is Off) Set the system to display or not to display the department name for the <a href="./code.php?ses=<?php echo $ses ?>">Department Specific HTML Code</a> or if only one department has been created.</div>
				<div style="margin-top: 15px;">
					<div class="info_good" style="float: left; width: 60px; padding: 3px;"><input type="radio" name="dept_name_vis" id="dept_name_vis_on" value="on" onClick="confirm_dept_name_vis(this.value)" <?php echo ( $VALS["DEPT_NAME_VIS"] != "off" ) ? "checked" : "" ?>> On</div>
					<div class="info_error" style="float: left; margin-left: 10px; width: 60px; padding: 3px;"><input type="radio" name="dept_name_vis" id="dept_name_vis_off" value="off" onClick="confirm_dept_name_vis(this.value)" <?php echo ( $VALS["DEPT_NAME_VIS"] == "off" ) ? "checked" : "" ?>> Off</div>
					<div style="clear: both;"></div>
				</div>
			</div>
		</div>

		</form>

		<form method="POST" action="interface.php?submit" enctype="multipart/form-data">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="jump" id="jump" value="lang">
		<input type="hidden" name="ses" value="<?php echo $ses ?>">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $VARS_MAX_CHAT_FILESIZE ?>">
		<div style="display: none; margin-top: 25px;" id="settings_lang">
			<div>
			<select name="lang" id="lang" style="width: 130px;" onChange="select_lang(this.value)">
				<?php
					$dir_langs = opendir( "$CONF[DOCUMENT_ROOT]/lang_packs/" ) ;

					$langs = Array() ;
					while ( $lang_ = readdir( $dir_langs ) )
						$langs[] = $lang_ ;
					closedir( $dir_langs ) ;
					
					sort( $langs, SORT_STRING ) ;
					for ( $c = 0; $c < count( $langs ); ++$c )
					{
						$lang_ = $langs[$c] ;

						if ( preg_match( "/[a-z]/i", $lang_ ) )
						{
							$lang_temp = preg_replace( "/(.php)/", "", $lang_ ) ;
							$lang_display = ucwords( $lang_temp ) ;
							$selected = "" ;
							if ( $lang == $lang_temp ) { $selected = "selected" ; }

							print "<option value=\"$lang_temp\" $selected>$lang_display</option>" ;
						}
					}
				?>
				</select>
			</div>

			<table cellspacing=0 cellpadding=2 border=0 width="100%" style="margin-top: 15px;">
			<tr>
				<td valign="top" width="50%">
					<div>
						<div>Welcome to our Live Chat</div>
						<div class="info_neutral">* chat request introduction title</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_1" name="CHAT_WELCOME"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div>
						<div>To better assist you, please provide the following information.</div>
						<div class="info_neutral">* chat request introduction sub title</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_2" name="CHAT_WELCOME_SUBTEXT"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>--- select department ---</div>
						<div class="info_neutral">* chat request select department</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_3" name="CHAT_SELECT_DEPT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Start Chat</div>
						<div class="info_neutral">* button text</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_4" name="CHAT_BTN_START_CHAT"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Send Email</div>
						<div class="info_neutral">* button text</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_BTN_EMAIL"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Send Transcript</div>
						<div class="info_neutral">* button text</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_BTN_EMAIL_TRANS"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Print Transcript</div>
						<div class="info_neutral">* chat options text</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_PRINT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Chat session with</div>
						<div class="info_neutral">* example: Chat session with Operator1</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_CHAT_WITH"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Your rating has been submitted.  Thank you.</div>
						<div class="info_neutral">* JavaScript alert of chat rating submit confirmation</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_SURVEY_THANK"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Close window</div>
						<div class="info_neutral">* button text</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_CLOSE"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Toggle Sound</div>
						<div class="info_neutral">* chat options text</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_SOUND"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Transferring chat to</div>
						<div class="info_neutral">* example: Transferring chat to Operator1</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_TRANSFER"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Transfer chat not available at this time.  Connecting to the previous operator...</div>
						<div class="info_neutral">* during a chat transfer if the operator is not avaible or declines the transfer</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_TRANSFER_TIMEOUT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Please leave a message.</div>
						<div class="info_neutral">* leave a message title</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="MSG_LEAVE_MESSAGE"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Message sent via Live Chat leave a message.</div>
						<div class="info_neutral">* leave a message email footer indicating message sent by the live chat system</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="MSG_EMAIL_FOOTER"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Previous message is still being processed.  Please try again shortly.</div>
						<div class="info_neutral">* JavaScript alert of previous leave a message is still being processed</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="MSG_PROCESSING"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Chat Transcript with</div>
						<div class="info_neutral">* chat transcript email subject (example: Chat Transcript with Operator1)</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="TRANSCRIPT_SUBJECT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>has joined the chat.</div>
						<div class="info_neutral">* example: Operator1 has joined the chat</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_NOTIFY_JOINED"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>How would you rate this support session?</div>
						<div class="info_neutral">* chat rating text</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_NOTIFY_RATE"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>The party has left or disconnected.  Chat session has ended.</div>
						<div class="info_neutral">* chat alert general message indicating session has ended due to timeout</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_NOTIFY_DISCONNECT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Disconnected by the visitor. Chat session has ended.</div>
						<div class="info_neutral">* chat alert message indicating session has ended due to visitor disconnecting</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_NOTIFY_VDISCONNECT"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Disconnected by the operator. Chat session has ended.</div>
						<div class="info_neutral">* chat alert message indicating session has ended due to operator disconnecting</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_NOTIFY_ODISCONNECT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>An agent will be with you shortly. Thank you for your patience.</div>
						<div class="info_neutral">* message displayed while the visitor is being connected to an operator</div>
						<div style="margin-top: 5px;">This value can be customized for each department from the <a href="depts.php?ses=<?php echo $ses ?>">Departments</a> sub menu "Chatting" area.</div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Agents are not available at this time. Please leave a message. Thank you.</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_NOTIFY_OP_NOT_FOUND"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Chat is idle. Please send a response.</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_NOTIFY_IDLE_TITLE"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Automatically disconnecting the chat</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_NOTIFY_IDLE_AUTO_DISCONNECT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Please select a department.</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_JS_BLANK_DEPT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Please provide your name.</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_JS_BLANK_NAME"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Please provide your email.</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_JS_BLANK_EMAIL"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Email format is invalid.  (example: someone@somewhere.com)</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_JS_INVALID_EMAIL"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Please provide a subject.</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_JS_BLANK_SUBJECT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Please provide a question.</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_JS_BLANK_QUESTION"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Live Chat: Leave a Message</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_JS_LEAVE_MSG"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Email Sent</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_JS_EMAIL_SENT"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Thank you for chatting with us.</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="CHAT_JS_CHAT_EXIT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Please provide your</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="CHAT_JS_CUSTOM_BLANK"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Department</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="TXT_DEPARTMENT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Online</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="TXT_ONLINE"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Offline</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="TXT_OFFLINE"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Name</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="TXT_NAME"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Email</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="TXT_EMAIL"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Question</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="TXT_QUESTION"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Connect</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="TXT_CONNECT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Connecting...</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="TXT_CONNECTING"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Submit</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="TXT_SUBMIT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>disconnect</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="TXT_DISCONNECT"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Subject</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="TXT_SUBJECT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Message</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="TXT_MESSAGE"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Live Chat</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="TXT_LIVECHAT"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>Optional</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="TXT_OPTIONAL"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>is typing...</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_5" name="TXT_TYPING"></div>
					</div>
				</td>
				<td valign="top" width="50%">
					<div style="padding-top: 15px;">
						<div>seconds</div>
						<div style=""><input type="text" class="input" style="width: 95%;" maxlength="255" id="lang_6" name="TXT_SECONDS"></div>
					</div>
				</td>
			</tr>
			</table>
		</div>

<?php include_once( "./inc_footer.php" ) ?>

