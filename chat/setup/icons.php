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
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh, $ses ) ){ ErrorHandler( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; }
	// STANDARD header end
	/****************************************/

	$error = "" ;

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$deptinfo = Array() ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;
	$option = Util_Format_Sanatize( Util_Format_GetVar( "option" ), "ln" ) ;
	$jump = Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ;

	$upload_dir = $CONF['CONF_ROOT'] ;
	$online = ( isset( $VALS['ONLINE'] ) && $VALS['ONLINE'] ) ? unserialize( $VALS['ONLINE'] ) : Array() ;
	$offline = ( isset( $VALS['OFFLINE'] ) && $VALS['OFFLINE'] ) ? unserialize( $VALS['OFFLINE'] ) : Array() ;

	if ( $action == "upload" )
	{
		$icon = isset( $_FILES['icon_online']['name'] ) ? "icon_online" : "icon_offline" ;
		$error = Util_Upload_File( $icon, $deptid ) ;
	}
	else if ( $action == "update_offline" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
		$url = Util_Format_Sanatize( Util_Format_GetVar( "url" ), "url" ) ;

		$dept_hash = Array() ; $departments = Depts_get_AllDepts( $dbh ) ;
		for ( $c = 0; $c < count( $departments ); ++$c )
		{
			$department = $departments[$c] ;
			$dept_hash[$department["deptID"]] = 1 ; 
		}

		foreach( $offline as $key => $value )
		{
			if ( $key && !isset( $dept_hash[$key] ) )
				unset( $offline[$key] ) ;
		}
		$offline[$deptid] = ( $option == "redirect" ) ? "$url" : $option ;
		Util_Vals_WriteToFile( "OFFLINE", serialize( $offline ) ) ;
	}
	else if ( $action == "update_online" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

		$dept_hash = Array() ; $departments = Depts_get_AllDepts( $dbh ) ;
		for ( $c = 0; $c < count( $departments ); ++$c )
		{
			$department = $departments[$c] ;
			$dept_hash[$department["deptID"]] = 1 ; 
		}

		foreach( $online as $key => $value )
		{
			if ( $key && !isset( $dept_hash[$key] ) )
				unset( $online[$key] ) ;
		}
		$online[$deptid] = $option ;
		Util_Vals_WriteToFile( "ONLINE", serialize( $online ) ) ;
	}
	else if ( $action == "reset" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

		if ( $option == "online" )
		{
			foreach( $online as $key => $value )
			{
				if ( $key && ( $key == $deptid ) )
					unset( $online[$key] ) ;
			}
			Util_Vals_WriteToFile( "ONLINE", serialize( $online ) ) ;
		}
		else
		{
			foreach( $offline as $key => $value )
			{
				if ( $key && ( $key == $deptid ) )
					unset( $offline[$key] ) ;
			}
			Util_Vals_WriteToFile( "OFFLINE", serialize( $offline ) ) ;
		}
	}

	if ( !isset( $departments ) ) { $departments = Depts_get_AllDepts( $dbh ) ; }
	if ( $deptid ) { $deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ; }

	$online_option = "embed" ;
	if ( isset( $online[$deptid] ) ) { $online_option = $online[$deptid] ; }
	else
	{
		if ( isset( $online[0] ) ) { $online_option = $online[0] ; }
	}

	$offline_option = "embed" ; $redirect_url = "" ;
	if ( isset( $offline[$deptid] ) )
	{
		if ( !preg_match( "/^(icon|hide|embed)$/", $offline[$deptid] ) ) { $offline_option = "redirect" ; $redirect_url = $offline[$deptid] ; }
		else{ $offline_option = $offline[$deptid] ; }
	}
	else
	{
		if ( isset( $offline[0] ) )
		{
			if ( !preg_match( "/^(icon|hide|embed)$/", $offline[0] ) ) { $offline_option = "redirect" ; $redirect_url = $offline[0] ; }
			else{ $offline_option = $offline[0] ; }
		}
	}
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

<script type="text/javascript">
<!--
	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		init_menu() ;
		toggle_menu_setup( "icons" ) ;
		
		<?php if ( $jump == "settings" ): ?>
		show_div( 'online', 'options' ) ; show_div( 'offline', 'options' ) ;
		<?php else: ?>
		show_div( 'online', 'icon' ) ; show_div( 'offline', 'icon' ) ;
		<?php endif ; ?>

		<?php if ( $action && !$error ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
		<?php if ( $action && $error ): ?>do_alert_div( "..", 0, "<?php echo $error ?>" ) ;<?php endif ; ?>
	});

	function switch_dept( theobject )
	{
		location.href = "icons.php?ses=<?php echo $ses ?>&deptid="+theobject.value+"&"+unixtime() ;
	}

	function show_div( theicon, thediv )
	{
		$('#div_alert').hide() ;

		var divs = Array( "icon", "options" ) ;
		for ( c = 0; c < divs.length; ++c )
		{
			$('#'+theicon+'_'+divs[c]).hide() ;
			$('#menu_'+theicon+'_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('#'+theicon+'_'+thediv).show() ;
		$('#menu_'+theicon+'_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function check_url()
	{
		var url = $('#offline_url').val() ;
		var url_ok = ( url.match( /(http:\/\/)|(https:\/\/)/i ) ) ? 1 : 0 ;

		if ( !url )
			return "Please provide the webpage URL." ;
		else if ( !url_ok )
			return "URL should begin with http:// or https:// for correct loading." ;
		else
			return false ;
	}

	function open_url()
	{
		var unique = unixtime() ;
		var url = $('#offline_url').val() ;
		var error = check_url() ;

		if ( error )
			do_alert( 0, error ) ;
		else
			window.open(url, unique, 'scrollbars=yes,menubar=yes,resizable=1,location=yes,toolbar=yes,status=1') ;
	}

	function update_online()
	{
		var unique = unixtime() ;
		var option = $("input[name='online_option']:checked").val() ;

		location.href = "./icons.php?action=update_online&ses=<?php echo $ses ?>&deptid=<?php echo $deptid ?>&option="+option+"&"+unique ;
	}

	function update_offline()
	{
		var unique = unixtime() ;
		var url = $('#offline_url').val().replace( /http/ig, "hphp" ) ;
		var option = $("input[name='offline_option']:checked").val() ;
		var error = check_url() ;

		if ( error && ( option == "redirect" ) )
			do_alert( 0, error ) ;
		else
			location.href = "./icons.php?action=update_offline&ses=<?php echo $ses ?>&deptid=<?php echo $deptid ?>&option="+option+"&url="+url+"&"+unique ;
	}

	function reset_doit( theicon, thedeptid )
	{
		if ( confirm( "Reset to Global Default settings?" ) )
			location.href = "./icons.php?ses=<?php echo $ses ?>&action=reset&option="+theicon+"&deptid="+thedeptid ;
	}

//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div style="">
			<div style="">The "Global Default" chat icons is displayed until new chat icons have been uploaded for that department. Browse available <a href="http://www.phplivesupport.com/r.php?r=icons" target="icons">chat icons</a>.</div>

			<div style="margin-top: 15px;">
				<form method="POST" action="manager_canned.php?submit" id="form_theform">
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
				</form>
			</div>
		</div>

		<div id="div_alert" style="margin-top: 25px; display: none;"></div>

		<div style="margin-top: 25px;">
		
			<table cellspacing=0 cellpadding=0 border=0 width="100%">
			<tr>
				<td>
					<div style="padding-bottom: 15px;">
						<div class="op_submenu" onClick="show_div('online', 'icon')" id="menu_online_icon">Online Icon</div>
						<div class="op_submenu" onClick="show_div('online', 'options')" id="menu_online_options">Settings</div>
						<div style="clear: both"></div>
					</div>
				</td>
				<td>
					<div style="padding-bottom: 15px;">
						<div class="op_submenu" onClick="show_div('offline', 'icon')" id="menu_offline_icon">Offline Icon</div>
						<div class="op_submenu" onClick="show_div('offline', 'options')" id="menu_offline_options">Settings</div>
						<div style="clear: both"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="50%" style="padding-right: 10px;">
					<form method="POST" action="icons.php?submit" enctype="multipart/form-data">
					<input type="hidden" name="ses" value="<?php echo $ses ?>">
					<input type="hidden" name="action" value="upload">
					<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
					<input type="hidden" name="MAX_FILE_SIZE" value="200000">
					<div class="edit_title"><?php echo ( isset( $deptinfo["name"] ) ) ? $deptinfo["name"] : "Global Default" ; ?> ONLINE</div>
					<div id="online_icon" style="display: none;">
						<div style="margin-top: 10px;">
							<input type="file" name="icon_online" size="30"><p>
							<input type="submit" value="Upload Image" style="margin-top: 10px;" class="btn">
						</div>
						
						<div style="margin-top: 15px;"><img src="<?php print Util_Upload_GetChatIcon( "$CONF[UPLOAD_HTTP]", "icon_online", $deptid ) ?>" border="0" alt=""></div>
					</div>
					<div id="online_options" style="display: none; margin-top: 10px;" class="info_info">
						<table cellspacing=1 cellpadding=5 border=0 width="100%">
						<tr>
							<td colspan=2><div style="font-size: 14px; font-weight: bold;">When live chat is <span class="info_good">ONLINE</span></div></td>
						</tr>
						<tr>
							<td width="25" align="center"><input type="radio" name="online_option" value="popup" <?php echo ( $online_option == "popup" ) ? "checked" : "" ; ?>></td>
							<td>Open the chat request in a new popup window when the online icon is clicked.</td>
						</tr>
						<tr>
							<td width="25" align="center"><input type="radio" name="online_option" value="embed" <?php echo ( $online_option == "embed" ) ? "checked" : "" ; ?>></td>
							<td><b>Embed</b> the chat request on the webpage when the online icon is clicked.</td>
						</tr>
						<tr>
							<td></td>
							<td><div style="padding-top: 5px;"><button type="button" onClick="update_online()" class="btn">Update</button>
							<?php
								if ( $deptid && !isset( $online[$deptid] ) ):
									print " currently using Global Default settings" ;
								elseif ( $deptid ):
									print " or reset to <a href=\"JavaScript:void(0)\" onClick=\"reset_doit( 'online', $deptid )\">Global Default</a>" ;
								endif ;
							?>
							</div></td>
						</tr>
						</table>
					</div>
					</form>
				</td>
				<td valign="top" width="50%" style="padding-left: 10px;">
					<form method="POST" action="icons.php?submit" enctype="multipart/form-data" id="form_offline" name="form_offline">
					<input type="hidden" name="ses" value="<?php echo $ses ?>">
					<input type="hidden" name="action" value="upload">
					<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
					<input type="hidden" name="MAX_FILE_SIZE" value="200000">
					<div class="edit_title"><?php echo ( isset( $deptinfo["name"] ) ) ? $deptinfo["name"] : "Global Default" ; ?> OFFLINE</div>
					<div id="offline_icon" style="display: none;">
						<div style="margin-top: 10px;">
							<input type="file" name="icon_offline" size="30"><p>
							<input type="submit" value="Upload Image" style="margin-top: 10px;" class="btn">
						</div>
						
						<div style="margin-top: 15px;"><img src="<?php print Util_Upload_GetChatIcon( "$CONF[UPLOAD_HTTP]", "icon_offline", $deptid ) ?>" border="0" alt=""></div>
					</div>
					<div id="offline_options" style="display: none; margin-top: 10px;" class="info_info">
						<table cellspacing=1 cellpadding=5 border=0 width="100%">
						<tr>
							<td colspan=2><div style="font-size: 14px; font-weight: bold;">When live chat is <span class="info_error">OFFLINE</span></div></td>
						</tr>
						<tr>
							<td width="25" align="center"><input type="radio" name="offline_option" value="icon" <?php echo ( $offline_option == "icon" ) ? "checked" : "" ; ?>></td>
							<td>Display the offline chat icon and open the leave a message in a new popup window when the offline icon is clicked.</td>
						</tr>
						<tr>
							<td width="25" align="center"><input type="radio" name="offline_option" value="embed" <?php echo ( $offline_option == "embed" ) ? "checked" : "" ; ?>></td>
							<td>Display the offline chat icon and <b>embed</b> the leave a message on the webpage when the offline icon is clicked.</td>
						</tr>
						<tr>
							<td width="25" align="center"><input type="radio" name="offline_option" id="option_redirect" value="redirect" <?php echo ( $offline_option == "redirect" ) ? "checked" : "" ; ?> onClick="$('#offline_url').focus()"></td>
							<td>Display the offline chat icon and redirect the visitor to a webpage when the offline icon is clicked. Provide the redirect URL below:<div style="margin-top: 5px;"><input type="text" class="input" style="width: 80%;" maxlength="255" name="offline_url" id="offline_url" value="<?php echo $redirect_url ?>" onFocus="$('#option_redirect').prop('checked', true)"> &nbsp; <span style="">&middot; <a href="JavaScript:void(0)" onClick="open_url()">visit</a></span></div></td>
						</tr>
						<tr>
							<td width="25" align="center"><input type="radio" name="offline_option" value="hide" <?php echo ( $offline_option == "hide" ) ? "checked" : "" ; ?>></td>
							<td>Do not display the offline chat icon.</td>
						</tr>
						<tr>
							<td></td>
							<td><div style="padding-top: 5px;"><button type="button" onClick="update_offline()" class="btn">Update</button>
							<?php
								if ( $deptid && !isset( $offline[$deptid] ) ):
									print " currently using Global Default settings" ;
								elseif ( $deptid ):
									print " or reset to <a href=\"JavaScript:void(0)\" onClick=\"reset_doit( 'offline', $deptid )\">Global Default</a>" ;
								endif ;
							?>
							</div></td>
						</tr>
						</table>
					</div>
					</form>
				</td>
			</tr>
			</table>

		</div>

<?php include_once( "./inc_footer.php" ) ?>

