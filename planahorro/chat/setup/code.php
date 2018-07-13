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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_File.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Vars/get.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = ( Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ) ? Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) : "main" ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;
	$proto = Util_Format_Sanatize( Util_Format_GetVar( "proto" ), "ln" ) ;
	$update = Util_Format_Sanatize( Util_Format_GetVar( "update" ), "ln" ) ;
	$position = Util_Format_Sanatize( Util_Format_GetVar( "position" ), "ln" ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$ops_assigned = 0 ;
	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		$ops = Depts_get_DeptOps( $dbh, $department["deptID"] ) ;
		if ( count( $ops ) )
			$ops_assigned = 1 ;
	}
	$deptinfo = Array() ;
	if ( $deptid )
		$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;

	$total_ops = Ops_get_TotalOps( $dbh ) ;
	$total_ops_online = Ops_get_itr_AnyOpsOnline( $dbh, $deptid ) ;

	$dept_query = $deptid ;
	if ( $update )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Vars/update.php" ) ;

		$vars = Util_Format_Get_Vars( $dbh ) ;
		if ( $proto != $vars["code"] )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

			$error = "" ;
			if ( !$proto )
				$error = ( Util_Vals_WriteToConfFile( "BASE_URL", preg_replace( "/^(http:\/\/)|(https:\/\/)/i", "//", $CONF["BASE_URL"] ) ) ) ? "" : "Could not write to config file." ;
			else if ( $proto == 1 )
				$error = ( Util_Vals_WriteToConfFile( "BASE_URL", preg_replace( "/^(https:\/\/)|(http:\/\/)|(\/\/)/i", "http://", $CONF["BASE_URL"] ) ) ) ? "" : "Could not write to config file." ;
			else if ( $proto == 2 )
			{
				$error = ( Util_Vals_WriteToConfFile( "BASE_URL", preg_replace( "/^(https:\/\/)|(http:\/\/)|(\/\/)/i", "https://", $CONF["BASE_URL"] ) ) ) ? "" : "Could not write to config file." ;
			}

			if ( !$error ) { Vars_update_Var( $dbh, "code", $proto ) ; }
		}
		Vars_update_Var( $dbh, "position", $position ) ;
	}
	else if ( $action == "add_extra_departments" )
	{
		$deptids = Util_Format_Sanatize( Util_Format_GetVar( "deptids" ), "a" ) ;

		$dept_query = "" ;
		for ( $c = 0; $c < count( $deptids ); ++$c )
			$dept_query .= $deptids[$c]."010" ;
		$update = 1 ;
	}
	else if ( $action == "proto_error" )
	{
		$error = "Could not detect HTTPS (SSL) support on this server." ;
	}

	$now = time() ;
	$position_css = "" ;
	$vars = Util_Format_Get_Vars( $dbh ) ;
	if ( isset( $vars["code"] ) )
	{
		$proto = $vars["code"] ;
		// perhaps use CSS to rotate but best to have it so it is by image to limit confusion
		// http://www.w3schools.com/cssref/css3_pr_transform-origin.asp
		switch ( $vars["position"] )
		{
			case 2:
				$position_css = " position: fixed; bottom: 0px; right: 0px; z-index: 1000;" ;
				break ;
			case 3:
				$position_css = " position: fixed; bottom: 0px; left: 0px; z-index: 1000;" ;
				break ;
			case 4:
				$position_css = " position: fixed; top: 0px; right: 0px; z-index: 1000;" ;
				break ;
			case 5:
				$position_css = " position: fixed; top: 0px; left: 0px; z-index: 1000;" ;
				break ;
			case 6:
				$position_css = " position: fixed; top: 50%; left: 0px; z-index: 1000;" ;
				break ;
			case 7:
				$position_css = " position: fixed; top: 50%; right: 0px; z-index: 1000;" ;
				break ;
			default:
				$position_css = "" ;
		}

		// automatic fix for toggle
		if ( !$proto && preg_match( "/^http:/", $CONF["BASE_URL"] ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Vars/update.php" ) ;
			$error = ( Util_Vals_WriteToConfFile( "BASE_URL", preg_replace( "/^(http:)/i", "", $CONF["BASE_URL"] ) ) ) ? "" : "Could not write to config file." ;
		}
	}

	$base_url = $CONF["BASE_URL"] ;
	$code = "&lt;span id=\"phplive_btn_$now\" onclick=\"phplive_launch_chat_$deptid(0)\" style=\"color: #0000FF; text-decoration: underline; cursor: pointer;$position_css\"&gt;&lt;/span&gt;-nl-&lt;script type=\"text/javascript\"&gt;-nl--nl-(function() {-nl-var phplive_e_$now = document.createElement(\"script\") ;-nl-phplive_e_$now.type = \"text/javascript\" ;-nl-phplive_e_$now.async = true ;-nl-phplive_e_$now.src = \"%%base_url%%/js/phplive_v2.js.php?v=$deptid|$now|$proto|%%text_string%%\" ;-nl-document.getElementById(\"phplive_btn_$now\").appendChild( phplive_e_$now ) ;-nl-})() ;-nl--nl-&lt;/script&gt;" ;
	$temp = $now+1 ;

	if ( $proto == 1 ) { $base_url = preg_replace( "/(http:)|(https:)/", "http:", $base_url ) ; }
	else if ( $proto == 2 ) { $base_url = preg_replace( "/(http:)|(https:)/", "https:", $base_url ) ; }
	else { $base_url = preg_replace( "/(http:)|(https:)/", "", $base_url ) ; }

	$thecode = preg_replace( "/%%base_url%%/", $base_url, $code ) ;
	$code_html = preg_replace( "/&lt;/", "<", $thecode ) ;
	$code_html = preg_replace( "/&gt;/", ">", $code_html ) ;
	$code_html = preg_replace( "/-nl-/", "\r\n", $code_html ) ;

	/*** Automatic Chat Invite ***/
	if ( ( $action == "update" ) && isset( $_FILES['icon_initiate']['name'] ) && $_FILES['icon_initiate']['name'] )
	{
		$error = Util_Upload_File( "icon_initiate", 0 ) ;
		if ( !$error )
		{
			database_mysql_close( $dbh ) ;
			HEADER( "location: code.php?ses=$ses&action=update&jump=auto" ) ;
			exit ;
		}
	}
	else if ( $action == "update" )
	{
		$duration = Util_Format_Sanatize( Util_Format_GetVar( "duration" ), "ln" ) ;
		$andor = Util_Format_Sanatize( Util_Format_GetVar( "andor" ), "ln" ) ;
		$footprints = Util_Format_Sanatize( Util_Format_GetVar( "footprints" ), "ln" ) ;
		$reset = Util_Format_Sanatize( Util_Format_GetVar( "reset" ), "ln" ) ;
		$pos = Util_Format_Sanatize( Util_Format_GetVar( "pos" ), "ln" ) ;
		$exin = Util_Format_Sanatize( Util_Format_GetVar( "exin" ), "ln" ) ;
		$exclude = preg_replace( "/[;*\/:\[\]\"\']/", "", stripslashes( Util_Format_Sanatize( Util_Format_GetVar( "exclude" ), "ln" ) ) ) ;

		$exclude_array = explode( ",", $exclude ) ;
		$exclude_string = "" ;
		for ( $c = 0; $c < count( $exclude_array ); ++$c )
		{
			$temp = preg_replace( "/ +/", "", $exclude_array[$c] ) ;
			if ( $temp )
				$exclude_string .= "$temp," ;
		}

		if ( $exclude_string ) { $exclude_string = substr_replace( $exclude_string, "", -1 ) ; }

		$initiate = Array() ;
		$initiate["duration"] = $duration ;
		$initiate["andor"] = $andor ;
		$initiate["footprints"] = $footprints ;
		$initiate["reset"] = $reset ;
		$initiate["exclude"] = $exclude_string ;
		$initiate["pos"] = $pos ;
		$initiate["exin"] = $exin ;

		$initiate_serialize = serialize( $initiate ) ;
		$admininfo["initiate"] = $initiate_serialize ;

		if ( $andor )
		{
			$error = ( Util_Vals_WriteToFile( "auto_initiate", htmlentities( $initiate_serialize ) ) ) ? "" : "Could not write to config file." ;
			if ( !$error )
			{
				database_mysql_close( $dbh ) ;
				HEADER( "location: code.php?ses=$ses&action=update&jump=auto" ) ;
				exit ;
			}
		}
	}

	$initiate = ( isset( $VALS["auto_initiate"] ) && $VALS["auto_initiate"] ) ? unserialize( html_entity_decode( $VALS["auto_initiate"] ) ) : Array() ;
	
	$online = ( isset( $VALS['ONLINE'] ) && $VALS['ONLINE'] ) ? unserialize( $VALS['ONLINE'] ) : Array( ) ;
	$offline = ( isset( $VALS['OFFLINE'] ) ) ? unserialize( $VALS['OFFLINE'] ) : Array() ;
	$offline_option = "icon" ;
	if ( isset( $offline[$deptid] ) )
	{
		if ( !preg_match( "/^(icon|hide)$/", $offline[$deptid] ) ) { $offline_option = "redirect" ; }
		else{ $offline_option = $offline[$deptid] ; }
	}
	else
	{
		if ( isset( $offline[0] ) )
		{
			if ( !preg_match( "/^(icon|hide)$/", $offline[0] ) ) { $offline_option = "redirect" ; }
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
<script type="text/javascript" src="../js/jquery_md5.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	var st_proto_verify ;
	var global_pos = <?php echo ( isset( $initiate["pos"] ) ) ? $initiate["pos"] : 1 ; ?> ;
	var thecode = '<?php echo $thecode ?>' ;
	thecode = thecode.replace( /-nl-/g, "\r\n" ) ;
	thecode = thecode.replace( /&lt;/g, "<" ) ;
	thecode = thecode.replace( /&gt;/g, ">" ) ;
	var phplive_browser = navigator.appVersion ; var phplive_mime_types = "" ;
	var phplive_display_width = screen.availWidth ; var phplive_display_height = screen.availHeight ; var phplive_display_color = screen.colorDepth ; var phplive_timezone = new Date().getTimezoneOffset() ;
	if ( navigator.mimeTypes.length > 0 ) { for (var x=0; x < navigator.mimeTypes.length; x++) { phplive_mime_types += navigator.mimeTypes[x].description ; } }
	var phplive_browser_token = phplive_md5( phplive_display_width+phplive_display_height+phplive_display_color+phplive_timezone+phplive_browser+phplive_mime_types ) ;

	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		init_menu() ;
		toggle_menu_setup( "html" ) ;

		populate_code( "standard" ) ;
		show_div( "<?php echo $jump ?>" ) ;

		<?php if ( isset( $initiate["andor"] ) && $initiate["andor"] ): ?>toggle_select_footprints( <?php echo $initiate["andor"] ?> ) ;<?php endif ; ?>

		<?php if ( $update && !$error ): ?>do_alert(1, "New HTML Code Generated") ;
		<?php elseif ( $update && $error ): ?>do_alert(0, "<?php echo $error ?>") ;
		<?php elseif ( $action && !$error ): ?>do_alert( 1, "Success" ) ;
		<?php elseif ( ( $action == "proto_error" ) && $error ): ?>do_alert( 0, "<?php echo $error ?>" ) ;
		<?php elseif ( $action && $error ): ?>do_alert_div( "..", 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>
	});

	function switch_dept( theobject )
	{
		location.href = "code.php?ses=<?php echo $ses ?>&deptid="+theobject.value+"&proto=<?php echo $proto ?>&"+unixtime() ;
	}

	function populate_code( thetextarea )
	{
		if ( thetextarea == "standard" )
		{
			var code = thecode.replace( /%%text_string%%/g, "" ) ;
			$('#textarea_code_'+thetextarea).val( code ) ;
		}
		else if ( thetextarea == "text" )
		{
			var text = encodeURI( $('#code_text').val() ) ;
			var code = thecode.replace( /%%text_string%%/g, text ) ;

			if ( text == "" )
				do_alert( 0, "Please provide the text." ) ;
			else
			{
				$('#code_text_code').show() ;
				$('#html_code_text_output').html("<span onClick=\"phplive_launch_chat_<?php echo $deptid ?>(0)\" style=\"cursor: pointer;\">"+$('#code_text').val()+"</span>") ;
				$('#textarea_code_'+thetextarea).val( code ) ;
				$('#html_code_text_output_tip').show() ;
			}
		}
	}

	function input_text_listen_text( e )
	{
		var key = -1 ;
		var shift ;

		key = e.keyCode ;
		shift = e.shiftKey ;

		if ( !shift && ( ( key == 13 ) || ( key == 10 ) ) )
			$('#btn_generate').click() ;
	}

	function toggle_code( theproto )
	{
		var unique = unixtime() ;
		var proto = $('input[name=proto]:checked', '#form_proto').val() ;

		var url = "<?php echo $CONF["BASE_URL"] ?>" ;
		var url_https = ( proto == 2 ) ? url.replace( /^(http:\/\/)|(\/\/)/i, "https://" ) : url ;

		$('#proto_verify').show() ;
		$('#iframe_proto_verify').attr('src', url_https+"/blank.php").ready(function() {
			toggle_code_doit() ;
		});
		if ( typeof( st_proto_verify ) != "undefined" ) { clearTimeout( st_proto_verify ) ; }
		st_proto_verify = setTimeout( function(){ location.href = "./code.php?ses=<?php echo $ses ?>&action=proto_error" }, 10000 ) ;
	}

	function toggle_code_doit()
	{
		var unique = unixtime() ;
		var proto = $('input[name=proto]:checked', '#form_proto').val() ;
		var position = $('#position').val() ;

		var url = "<?php echo $CONF["BASE_URL"] ?>" ;
		var url_https = ( proto == 2 ) ? url.replace( /^((http:\/\/)|(\/\/))/i, "https://" ) : url ;

		location.href = url_https+"/setup/code.php?ses=<?php echo $ses ?>&deptid=<?php echo $deptid ?>&proto="+proto+"&position="+position+"&update=1&"+unique ;
	}

	function show_div( thediv )
	{
		var divs = Array( "main", "auto", "settings" ) ;
		for ( c = 0; c < divs.length; ++c )
		{
			$('#code_'+divs[c]).hide() ;
			$('#menu_code_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('#code_'+thediv).show() ;
		$('#menu_code_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function show_html_code()
	{
		$('#btn_show').hide() ;
		$('#div_html_code').show() ;
	}

	function toggle_select_footprints( thevalue )
	{
		return true ;

		if( thevalue > 0 )
			$('#div_footprints').show() ;
		else
			$('#div_footprints').hide() ;
	}

	function view_invite()
	{
		if ( global_pos && ( global_pos != $('#pos').val() ) )
			alert( "Please save changes before viewing." ) ;
		else
		{
			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=view_invite&token="+phplive_browser_token+"&"+unixtime(),
				success: function(data){
					eval( data ) ;

					if ( json_data.status )
					{
						if ( typeof( phplive_interval_initiate_<?php echo $deptid ?> ) != "undefined" )
							clearInterval( phplive_interval_initiate_<?php echo $deptid ?> ) ;
						do_alert( 1, "Just a moment.  Launching..." ) ;
					}
					else
						do_alert( 0, "Error: Could not create initiate file." ) ;
				}
			});
		}
	}

	function open_departments( thedeptid )
	{
		var pos = $('#department_add_btn').position() ;
		var top = pos.top - 45 ;
		var left = pos.left + $('#department_add_btn').outerWidth() + 25 ;

		$('#div_departments').css({'top': top, 'left': left}).fadeIn("fast") ;
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<?php if ( !count( $departments ) ): $display = 0 ; ?>
		<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Create a <a href="depts.php?ses=<?php echo $ses ?>" style="color: #FFFFFF;">Department</a> to continue.</span>
		<?php elseif ( !$total_ops ): $display = 0 ; ?>
		<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Create an <a href="ops.php?ses=<?php echo $ses ?>" style="color: #FFFFFF;">Operator</a> to continue.</span>
		<?php elseif ( !$ops_assigned ): $display = 0 ; ?>
		<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> <a href="ops.php?ses=<?php echo $ses ?>&jump=assign" style="color: #FFFFFF;">Assign an operator to a department</a> to continue.</span>
		<?php
			else:
			$display = 1 ;
			$select_depts = 1 ;

			if ( count( $departments ) == 1 )
			{
				$department = $departments[0] ;
				if ( $department["visible"] )
					$select_depts = 0 ;
			}
		?>
		<?php endif ; ?>

		<?php if ( $display ): ?>
		<div class="op_submenu_wrapper">
			<div class="op_submenu" onClick="show_div('main')" id="menu_code_main">HTML Code</div>
			<div class="op_submenu" onClick="show_div('auto')" id="menu_code_auto">Automatic Chat Invitation</div>
			<!-- <div class="op_submenu" onClick="show_div('settings')" id="menu_code_settings">Settings</div> -->
			<div style="clear: both"></div>
		</div>

		<div id="code_main" style="display: none; margin-top: 25px;">
			<div id="code_main_info">
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td valign="top" style="padding-right: 25px; text-align: justify;" width="50%">
						<div>
							<div style="">"All Departments" HTML Code will allow the visitor to select from a department dropdown menu (if more then one <a href="depts.php?ses=<?php echo $ses ?>">department</a> have been created).  For the department specific HTML Code, the department selection is not available because the visitor is automatically routed to that specific department.</div>
							<div style="margin-top: 25px;">
								<form method="POST" action="manager_canned.php?submit" id="form_theform">
								<select name="deptid" id="deptid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this )">
								<option value="0">ALL Departments</option>
								<?php
									if ( $select_depts )
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

							<div style="margin-top: 35px; font-size: 14px;" class="info_box">HTML Code for <span id="span_dept_name" style="font-size: 18px; font-weight: bold;"></span></div>
							<script type="text/javascript">
								var dept_name = $("#deptid option:selected").text() ;
								$('#span_dept_name').html( dept_name ) ;
							</script>
						</div>
					</td>
					<td valign="top" style="padding-left: 25px; text-align: justify;" width="50%">
						<form id="form_proto">
						<div style=""><img src="../pics/icons/lock.png" width="16" height="16" border="0" alt=""> HTTPS or HTTP</div>
						<div style="margin-top: 5px;" class="info_neutral">
							<div style=""><input type="radio" name="proto" value="0" <?php echo ( !isset( $vars["code"] ) || !$vars["code"] ) ? "checked" : "" ?> onClick="toggle_code()"> Toggle <b><i>HTTP and HTTPS</i></b> based on the URL</div>
							<div style="margin-top: 5px;"><input type="radio" name="proto" value="1" <?php echo ( $vars["code"] == 1 ) ? "checked" : "" ?> onClick="toggle_code()"> Always <b><i>HTTP</i></b></div>
							<div style="margin-top: 5px;"><input type="radio" name="proto" value="2" <?php echo ( $vars["code"] == 2 ) ? "checked" : "" ?> onClick="toggle_code()"> Always <b><i>HTTPS</i></b> <img src="../pics/icons/lock.png" width="16" height="16" border="0" alt=""> secure chat image and secure chats (SSL enabled servers)</div>
						</div>
						</form>
						<div id="proto_verify" style="display: none; margin-top: 15px;" class="info_neutral">&bull; just a moment while verifying... <img src="../pics/loading_ci.gif" width="14" height="14" border="0" alt=""></div>

						<div style="margin-top: 25px;"><img src="../pics/icons/flag_blue.png" width="16" height="16" border="0" alt=""> Chat Icon Position</div>
						<div style="margin-top: 5px;" class="info_neutral">
							<form id="proto_pos">
							<div style="">
								<select name="position" id="position" onChange="toggle_code()" style="background: #D5E6FD;">
									<option value="1" <?php echo ( $vars["position"] == 1 ) ? "selected" : "" ; ?>>Display the chat icon where the HTML code is placed. (default)</option>
									<option value="2" <?php echo ( $vars["position"] == 2 ) ? "selected" : "" ; ?>>Bottom Right</option>
									<option value="3" <?php echo ( $vars["position"] == 3 ) ? "selected" : "" ; ?>>Bottom Left</option>
									<option value="4" <?php echo ( $vars["position"] == 4 ) ? "selected" : "" ; ?>>Top Right</option>
									<option value="5" <?php echo ( $vars["position"] == 5 ) ? "selected" : "" ; ?>>Top Left</option>
									<option value="6" <?php echo ( $vars["position"] == 6 ) ? "selected" : "" ; ?>>Center Left</option>
									<option value="7" <?php echo ( $vars["position"] == 7 ) ? "selected" : "" ; ?>>Center Right</option>
								</select>
							</div>
							</form>
						</div>
					</td>
				</tr>
				</table>
			</div>

			<?php if ( isset( $deptinfo["deptID"] ) && !$deptinfo["visible"] ): ?>
			<div class="info_error" style="margin-top: 15px;"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Although this department is <a href="depts.php?ses=<?php echo $ses ?>" style="color: #FFFFFF;">not visible for selection</a>, visitors can still reach this department with the department specific HTML Code below.</div>
			<?php endif ; ?>

			<div id="div_html_code" style="margin-top: 25px;">
				
				<div style="margin-bottom: 25px;">
					<div class="edit_title"><img src="../pics/icons/code.png" width="16" height="16" border="0" alt=""> Standard HTML Code (recommended)</div>

					<!-- <div style="margin-top: 15px; font-size: 10px;"><span id="department_add_btn" class="info_box" style="cursor: pointer;" onClick="open_departments(<?php echo $deptid ?>)"><img src="../pics/icons/add.png" width="12" height="12" border="0" alt=""> customize department selection</span></div> -->

					<div style="margin-top: 15px;"><textarea wrap="virtual" id="textarea_code_standard" style="font-size: 10px; padding: 20px; width: 930px; height: 160px; resize: none;" onMouseDown="setTimeout(function(){ $('#textarea_code_standard').select(); }, 200);" readonly></textarea></div>

					<div style="margin-top: 10px;">Copy/paste the above HTML Code onto your webpages.  For best results, paste the HTML Code onto all of your webpages.  For multiple live chat icons on the same page, please refer to the <a href="http://www.phplivesupport.com/r.php?r=multi" target="new">multiple chat icons documentation</a>.</div>
					<div style="margin-top: 10px; font-size: 10px;">The above HTML Code will produce the following status icon. <b>Note:</b> If the chat icon is not displaying, try switching Off the <a href="./icons.php?ses=<?php echo $ses ?>&action=ob">Image Output OB Clean Setting</a>.</div>
					<?php if ( !$total_ops_online && ( $offline_option == "hide" ) ): ?>
					<div class="info_box" style="margin-top: 5px;">Reminder: Offline chat icon is not displayed based on the current <a href="icons.php?ses=<?php echo $ses ?>&deptid=<?php echo $deptid ?>&jump=options">offline setting</a>.</div>
					<?php else: ?>
					<div style="margin-top: 5px;" id="output_code"><?php echo preg_replace( "/%%text_string%%/", "", $code_html ) ?></div>
					<?php endif; ?><p>
				</div>
				<div style="margin-bottom: 25px;">
					<div style="font-size: 14px; font-weight: bold;"><img src="../pics/icons/code.png" width="14" height="14" border="0" alt=""> Text Link HTML Code &nbsp; <span style="font-size: 12px; font-weight: normal;"><a href="JavaScript:void(0)" onClick="$('#div_code_text').toggle()">[+] expand</a></span></div>
					<div id="div_code_text" style="display: none; margin-top: 15px;">
					<?php if ( $offline_option == "hide" ): ?>
						Not available for current <a href="icons.php?ses=<?php echo $ses ?>&deptid=<?php echo $deptid ?>&jump=options">offline setting</a>.
					<?php else: ?>
						<div style="margin-top: 15px;"><textarea wrap="virtual" id="textarea_code_text" style="font-size: 10px; padding: 20px; width: 930px; height: 160px; resize: none;" onMouseDown="setTimeout(function(){ $('#textarea_code_text').select(); }, 200);" readonly></textarea></div>

						<div style="margin-top: 10px;"><input type="text" class="input" size="25" maxlength="155" id="code_text" onKeydown="input_text_listen_text(event);" value="Click for Live Support"> <input type="button" value="Generate" onClick="populate_code('text')" id="btn_generate"></div>
						<div style="margin-top: 10px;">Example: <i>"Click for Live Support"</i></div>
						<div id="code_text_code" style="display: none; margin-top: 10px; font-size: 10px;">The above code will produce the following text link.</div>
						<div id="html_code_text_output" style="margin-top: 5px; color: #0000FF; text-decoration: underline;"></div>
						<div class="info_box" style="display: none; margin-top: 15px;" id="html_code_text_output_tip">
							To achieve design consistency of your website, modify the &lt;span&gt; style portion of the above code.
						</div>
					<?php endif ; ?>
					</div>
				</div>
				<div style="margin-bottom: 25px;">
					<div style="font-size: 14px; font-weight: bold;"><img src="../pics/icons/code.png" width="14" height="14" border="0" alt=""> Plain HTML Code (no JavaScript) &nbsp; <span style="font-size: 12px; font-weight: normal;"><a href="JavaScript:void(0)" onClick="$('#div_plain_text').toggle()">[+] expand</a></span></div>
					<div id="div_plain_text" style="display: none; margin-top: 15px;">
						<textarea wrap="virtual" id="textarea_code_plain" style="padding: 20px; width: 930px; height: 50px; resize: none;" onMouseDown="setTimeout(function(){ $('#textarea_code_plain').select(); }, 200);" readonly><a href="<?php echo $base_url ?>/phplive.php?d=<?php echo $dept_query ?>&onpage=livechatimagelink&title=Live+Chat+Image+Link" target="new"><img src="<?php echo $base_url ?>/ajax/image.php?d=<?php echo $dept_query ?>" border=0></a></textarea>

						<div style="margin-top: 10px;">
							<img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Plain HTML is for publishing software with strict HTML guidelines.  The above code will work for most publishing software by inserting the code as HTML.
						</div>
						<div style="margin-top: 10px;">
							<img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Due to the lack of javascript, automatic chat invite, initiate chat and real-time visitor footprint tracking will not be available for this code option.
						</div>
						<div style="margin-top: 10px;">
							<img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Due to the lack of javascript, the traffic monitor will not display visitors arriving from this code option.  Also, the visitor footprints will not be tracked or stored.
						</div>
						<div style="margin-top: 10px; font-size: 10px;">The above code will produce the below status icon.</div>
						<div style="margin-top: 5px;"><a href="<?php echo $base_url ?>/phplive.php?d=<?php echo $dept_query ?>&onpage=livechatimagelink&title=Live+Chat+Image+Link" target="new"><img src="<?php echo $base_url ?>/ajax/image.php?d=<?php echo $dept_query ?>" border=0></a></div>
					</div>
				</div>
				<div style="margin-bottom: 25px;">
					<div style="font-size: 14px; font-weight: bold;"><img src="../pics/icons/code.png" width="14" height="14" border="0" alt=""> Direct Link &nbsp; <span style="font-size: 12px; font-weight: normal;"><a href="JavaScript:void(0)" onClick="$('#div_direct_link').toggle()">[+] expand</a></span></div>
					<div id="div_direct_link" style="display: none; margin-top: 10px;">
						<div style="">Direct link URL to the chat request window.</div>
						<div style="margin-top: 15px;"><textarea wrap="virtual" id="textarea_code_direct" style="padding: 20px; width: 930px; height: 25px; resize: none;" onMouseDown="setTimeout(function(){ $('#textarea_code_direct').select(); }, 200);" readonly><?php echo $base_url ?>/phplive.php?d=<?php echo $dept_query ?>&onpage=livechatimagelink&title=Live+Chat+Direct+Link</textarea></div>
					</div>
				</div>
			</div>
		</div>

		<div id="code_auto" style="display: none; margin-top: 25px;">

			<form method="POST" action="code.php?submit" enctype="multipart/form-data">
			<input type="hidden" name="action" value="update">
			<input type="hidden" name="jump" value="auto">
			<input type="hidden" name="ses" value="<?php echo $ses ?>">
			<input type="hidden" name="MAX_FILE_SIZE" value="200000">
			<div style="margin-top: 25px;">
				
				<div id="div_alert" style="display: none;"></div>

				<table cellspacing=0 cellpadding=2 border=0 style="margin-top: 25px;">
				<tr>
					<td valign="top">
						<div>Current chat invitation image:</div>
						<div style="margin-top: 5px;"><img src="<?php echo Util_Upload_GetInitiate( 0 ) ; ?>" width="250" height="160" border="0" alt="" class="round"></div>
						<div class="home_box_header" style="margin-top: 15px;">Upload New Chat Invitation Image</div>
						<div class="info_neutral" style="font-size: 10px;"><img src="../pics/icons/info.png" width="10" height="10" border="0" alt=""> image should be 250x160 pixels</div>
						<div style="margin-top: 10px;">
							<input type="file" name="icon_initiate" size="30"><p>
							<input type="submit" value="Upload Image" style="margin-top: 10px;" class="btn">
						</div>
					</td>
					<td valign="top" style="padding-left: 30px;">
						<div>On webpages that have the chat icon <a href="JavaScript:void(0)" onClick="show_div('main')">HTML Code</a>, automatically display a chat invitation to the visitor when certain criterias are met and when live chat is available.</div>

						<div class="info_info" style="margin-top: 15px;">
							<div style="">Set a criteria to BLANK to inactivate. Set both criterias to BLANK to switch off the automatic chat invitation.</div>
							<div class="info_neutral" style="margin-top: 15px; text-shadow: none;">
								Display the initiate chat when the visitor remains on the same page for
								<select name="duration">
								<?php
									$options = Array( "", 15, 30, 60, 90, 120, 150, 180 ) ;
									for( $c = 0; $c < count( $options ); ++$c )
									{
										$selected = "" ;
										if ( isset( $initiate["duration"] ) && ( $initiate["duration"] == $options[$c] ) )
											$selected = "selected" ;

										print "<option value='$options[$c]' $selected>$options[$c]</option>" ;
									}
								?></select> seconds <select name="andor" onChange="toggle_select_footprints(this.value)"><option value="1" <?php echo ( isset( $initiate["andor"] ) && ( $initiate["andor"] == 1 ) ) ? "selected" : "" ?> >or</option><option value="2" <?php echo ( isset( $initiate["andor"] ) && ( $initiate["andor"] == 2 ) ) ? "selected" : "" ?> >and</option></select> <span id="div_footprints">has viewed at least
								<select name="footprints"><option value="0"></option>
								<?php
									for( $c = 2; $c <= 25; ++$c )
									{
										$selected = "" ;
										if ( isset( $initiate["footprints"] ) && ( $initiate["footprints"] == $c ) )
											$selected = "selected" ;

										print "<option value=\"$c\" $selected>$c</option>" ;
									}
								?></select> pages (NOTE: viewing the same page 2 times would count as 2 pages).</span>
							</div>

							<div class="info_neutral" style="margin-top: 15px; text-shadow: none;">
								After the automatic chat invitation image has been displayed, reset the invite settings and display the invitation to the visitor again after
								<select name="reset">
								<?php
									for( $c = 1; $c <= 48; ++$c )
									{
										$selected = "" ;
										if ( isset( $initiate["reset"] ) && ( $initiate["reset"] == $c ) )
											$selected = "selected" ;
										print "<option value=\"$c\" $selected>$c</option>" ;
									}
								?></select> hours.
								<div style="margin-top: 10px;" class="info_box">
									<table cellspacing=0 cellpadding=2 border=0>
									<tr><td><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""></td><td><b>NOTE:</b> Anytime the chat request window is loaded, the automatic chat invitation timer will be reset to display the invite after the above x hours.</td></tr>
									</table>
								</div>
							</div>

							<div class="info_neutral" style="margin-top: 15px; text-shadow: none;">
								<div>
									<img src="../pics/icons/flag_blue.png" width="16" height="16" border="0" alt=""> Chat Invitation Image Position:
									<select name="pos" id="pos" style="background: #D5E6FD;">
										<option value="1" <?php echo ( !isset( $initiate["pos"] ) || ( $initiate["pos"] == 1 ) ) ? "selected" : "" ; ?> >Slide in from the Left (default)</option>
										<option value="2" <?php echo ( isset( $initiate["pos"] ) && ( $initiate["pos"] == 2 ) ) ? "selected" : "" ; ?> >Slide in from the Right</option>
										<option value="3" <?php echo ( isset( $initiate["pos"] ) && ( $initiate["pos"] == 3 ) ) ? "selected" : "" ; ?> >Slide in from the Bottom Left</option>
										<option value="4" <?php echo ( isset( $initiate["pos"] ) && ( $initiate["pos"] == 4 ) ) ? "selected" : "" ; ?> >Slide in from the Bottom Right</option>
										<option value="100" <?php echo ( isset( $initiate["pos"] ) && ( $initiate["pos"] == 100 ) ) ? "selected" : "" ; ?> >Display at the Center of the page</option>
									</select>

									&bull; <a href="JavaScript:void(0)" onClick="view_invite()">view how it looks</a>
								</div>
							</div>

							<div class="info_neutral" style="margin-top: 15px; text-shadow: none;">

								<table cellspacing=0 cellpadding=0 border=0>
								<tr>
									<td nowrap><img src="../pics/icons/reset.png" width="16" height="16" border="0" alt=""> Exclude or Include:&nbsp</td>
									<td>
										<select name="exin" id="exin" style="width: 100%;">
											<option value="exclude" <?php echo ( isset( $initiate["exin"] ) && ( $initiate["exin"] == "exclude" ) ) ? "selected" : "" ; ?> >EXCLUDE automatic chat invitation for URLs that contain:</option>
											<option value="include" <?php echo ( isset( $initiate["exin"] ) && ( $initiate["exin"] == "include" ) ) ? "selected" : "" ; ?>>INCLUDE automatic chat invitation for only the URLs that contain:</option>
										</select>
									</td>
								</tr>
								<tr>
									<td></td>
									<td style="padding-top: 15px;"><input type="text" class="input" size="65" name="exclude" id="exclude" onKeyPress="return noquotes(event)" value="<?php echo ( isset( $initiate["exclude"] ) && $initiate["exclude"] ) ? $initiate["exclude"] : "" ; ?>"></td>
								</tr>
								<tr>
									<td></td>
									<td style="padding-top: 5px;">
										<ul>
											<li> Separate the values with a comma (,) without spaces</li>
											<li> Provide the page itself and not the full URL. Example: <code>purchase.php, checkout.html, trial.asp</code></li>
											<li> Full domain name can be provided.  Example: <code>mysite1.com, mysite3.com</code></li>
											<li> Quotes ("), forward slash (/), back slash (\) and other special characters will be omitted.</li>
										</ul>
									</td>
								</tr>
								</table>

							</div>

							<div style="margin-top: 15px;"><input type="submit" value="Update" class="btn"></div>
						</div>
					</td>
				</tr>
				</table>

			</div>
			</form>
		</div>

		<div id="code_settings" style="display: none; margin-top: 25px;">
			settings
		</div>
		<?php endif ; ?>

		<div id="div_departments" style="display: none; position: absolute; top: 0px; left: 0px; z-index: 1001;" class="info_box round">
			<form method="GET" action="code.php" id="form_add_extra_departments">
			<input type="hidden" name="ses" value="<?php echo $ses ?>">
			<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
			<input type="hidden" name="deptids[]" value="<?php echo $deptid ?>">
			<input type="hidden" name="action" value="add_extra_departments">
			<div style="max-height: 150px; min-width: 200px; overflow: auto;">
				<table cellspacing=0 cellpadding=2 border=0>
				<?php
					for ( $c = 0; $c < count( $departments ); ++$c )
					{
						$department = $departments[$c] ;
						if ( $department["visible"] )
						{
							$checked = ( $deptid == $department["deptID"] ) ? "checked" : "" ;
							$disabled = ( $deptid == $department["deptID"] ) ? "disabled" : "" ;
							print "<tr><td><input type=\"checkbox\" name=\"deptids[]\" value=\"$department[deptID]\" $checked $disabled></td><td>$department[name]</td></tr>" ;
						}
					}
				?>
				</table>
			</div>
			<div style="margin-top: 15px;"><button type="button" onClick="$('#form_add_extra_departments').submit()">Add</button> &nbsp; <a href="JavaScript:void(0)" onClick="$('#div_departments').fadeOut('fast');">close</a></div>
			</form>
		</div>

		<div style="display: none;"><iframe id='iframe_proto_verify' src='about:blank' scrolling='no' border=0 frameborder=0></iframe></div>
<?php include_once( "./inc_footer.php" ) ?>