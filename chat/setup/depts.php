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
	$vars_rtype = Array( 1=>"Ordered", 2=>"Round-robin", 3=>"Simultaneous" ) ;

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$dept_themes = ( isset( $VALS["THEMES"] ) && $VALS["THEMES"] ) ? unserialize( $VALS["THEMES"] ) : Array() ;

	if ( $action == "submit" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/put.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;
		$name = Util_Format_ConvertQuotes( Util_Format_Sanatize( Util_Format_GetVar( "name" ), "ln" ) ) ;
		$email = Util_Format_Sanatize( Util_Format_GetVar( "email" ), "e" ) ;
		$visible = Util_Format_Sanatize( Util_Format_GetVar( "visible" ), "ln" ) ;
		$queue = Util_Format_Sanatize( Util_Format_GetVar( "queue" ), "ln" ) ;
		$rtype = Util_Format_Sanatize( Util_Format_GetVar( "rtype" ), "ln" ) ;
		$rtime = Util_Format_Sanatize( Util_Format_GetVar( "rtime" ), "ln" ) ;
		$rloop = Util_Format_Sanatize( Util_Format_GetVar( "rloop" ), "ln" ) ;
		$savem = Util_Format_Sanatize( Util_Format_GetVar( "savem" ), "ln" ) ;
		$smtp = Util_Format_Sanatize( Util_Format_GetVar( "smtp" ), "ln" ) ;
		$tshare = Util_Format_Sanatize( Util_Format_GetVar( "tshare" ), "ln" ) ;
		$traffic = Util_Format_Sanatize( Util_Format_GetVar( "traffic" ), "ln" ) ;
		$texpire = Util_Format_Sanatize( Util_Format_GetVar( "texpire" ), "ln" ) ;
		$lang = Util_Format_Sanatize( Util_Format_GetVar( "lang" ), "ln" ) ;
		$theme = Util_Format_Sanatize( Util_Format_GetVar( "theme" ), "ln" ) ;

		if ( is_file( "$CONF[DOCUMENT_ROOT]/lang_packs/$lang.php" ) )
			include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/$lang.php" ) ;
		else { $lang = "english" ; }

		$department_pre = Depts_get_DeptInfoByName( $dbh, $name ) ;
		if ( isset( $department_pre["deptID"] ) && !$deptid ) { $error = "$name is already in use." ; }
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

			if ( $smtp ) { $deptinfo = Depts_get_DeptInfo( $dbh, $smtp ) ; $smtp = $deptinfo["smtp"] ; }
			if ( $name != "Archive" )
			{
				if ( !$deptid = Depts_put_Department( $dbh, $deptid, $name, $email, $visible, $queue, $rtype, $rtime, $rloop, $savem, $smtp, $tshare, $texpire, $lang ) ) { $error = "DB Error: $dbh[error]" ; }
			}
			
			if ( !$error )
			{
				$departments = Depts_get_AllDepts( $dbh ) ;
				if ( count( $departments ) == 1 )
				{
					$error = ( Util_Vals_WriteToConfFile( "lang", $lang ) ) ? "" : "Could not write to config file. [e1]" ;
					if ( !$error ) { $error = ( Util_Vals_WriteToConfFile( "THEME", $theme ) ) ? "" : "Could not write to vals file. [e1]" ; }
				}
				if ( $theme )
				{
					if ( $deptid && isset( $dept_themes[$deptid] ) && ( $dept_themes[$deptid] == $theme ) ) { /* same theme */ }
					else
					{
						$dept_themes[$deptid] = $theme ;
						$error = ( Util_Vals_WriteToFile( "THEMES", serialize( $dept_themes ) ) ) ? "" : "Could not write to vals file. [e2]" ;
					}
				}
			}
		}
	}
	else if ( $action == "delete" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/remove.php" ) ;
		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;

		Depts_remove_Dept( $dbh, $deptid ) ;
		if ( $deptid )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

			unset( $dept_themes[$deptid] ) ;
			$error = ( Util_Vals_WriteToFile( "THEMES", serialize( $dept_themes ) ) ) ? "" : "Could not write to vals file. [e3]" ;

			$departments = Depts_get_AllDepts( $dbh ) ;
			if ( count( $departments ) == 1 )
			{
				$department = $departments[0] ;
				if ( isset( $department["lang"] ) && $department["lang"] && ( $CONF["lang"] != $department["lang"] ) )
				{
					$lang = $department["lang"] ;
					$error = ( Util_Vals_WriteToConfFile( "lang", $lang ) ) ? "" : "Could not write to config file. [e2]" ;
					$CONF["lang"] = $lang ;
				}
				if ( isset( $dept_themes[$department["deptID"]] ) && ( $dept_themes[$department["deptID"]] != $CONF["THEME"] ) )
				{
					$error = ( Util_Vals_WriteToConfFile( "THEME", $dept_themes[$department["deptID"]] ) ) ? "" : "Could not write to vals file. [e5]" ;
					$CONF["THEME"] = $dept_themes[$department["deptID"]] ;
				}
			}
		}
	}
	else if ( $action == "update_lang" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
		$lang = Util_Format_Sanatize( Util_Format_GetVar( "lang" ), "ln" ) ;

		$error = ( Util_Vals_WriteToConfFile( "lang", $lang ) ) ? "" : "Could not write to config file. [e3]" ;
		$CONF["lang"] = $lang ;
	}
	else if ( $action == "update_theme" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
		$theme = Util_Format_Sanatize( Util_Format_GetVar( "theme" ), "ln" ) ;

		$error = ( Util_Vals_WriteToConfFile( "THEME", $theme ) ) ? "" : "Could not write to config file. [e4]" ;
		$CONF["THEME"] = $theme ;
	}

	if ( !isset( $departments ) )
		$departments = Depts_get_AllDepts( $dbh ) ;

	// filter for departments with SMTP
	$departments_smtp = $smtp_temp = Array() ;
	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		if ( $department["smtp"] && !isset( $smtp_temp[$department["smtp"]] ) )
		{
			$departments_smtp[$department["deptID"]] = $department["smtp"] ;
			$smtp_temp[$department["smtp"]] = true ;
		}
	}

	$themes_js = "" ;
	foreach ( $dept_themes as $key => $value )
		$themes_js .= "themes[$key] = '$value' ; " ;
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
	var global_deptid ;
	var global_option ;
	var global_div_list_height ;
	var global_div_form_height ;
	var themes = new Object ;
	var max_menus = 7 ;

	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;
		init_menu() ;
		toggle_menu_setup( "depts" ) ;

		init_divs() ;

		<?php if ( $action && !$error ): ?>do_alert( 1, "Success" ) ;
		<?php elseif ( $action && $error ): ?>do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>

		eval( "<?php echo $themes_js ?>" ) ;
	});
	$(window).resize(function() { });

	function init_divs()
	{
		global_div_list_height = $('#div_list').outerHeight() ;
		global_div_form_height = $('#div_form').outerHeight() ;
	}

	function do_submit()
	{
		var name = $( "input#name" ).val() ;
		var email = $( "input#email" ).val() ;

		if ( name == "" )
			do_alert( 0, "Please provide the department name." ) ;
		else if ( !check_email( email ) )
			do_alert( 0, "Please provide a valid email address." ) ;
		else
			$('#theform').submit() ;
	}

	function do_options( theoption, thedeptid )
	{
		var unique = unixtime() ;
		global_option = theoption ;
		global_deptid = thedeptid ;

		for ( c = 1; c <= max_menus; ++c )
		{
			if ( c != theoption )
				$('#menu_'+c+"_"+thedeptid).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		if ( $('#iframe_edit_'+thedeptid).is(':visible') && ( document.getElementById('iframe_edit_'+thedeptid).contentWindow.option == theoption ) )
		{
			$('#iframe_'+thedeptid).fadeOut("fast") ;

			$('#menu_'+theoption+"_"+thedeptid).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}
		else
		{
			if ( theoption == 1 )
				$('#iframe_edit_'+thedeptid).attr('src', 'iframe_edit.php?ses=<?php echo $ses ?>&action=greeting&option='+theoption+'&deptid='+thedeptid+'&'+unique ) ;
			else if ( theoption == 2 )
				$('#iframe_edit_'+thedeptid).attr('src', 'iframe_edit.php?ses=<?php echo $ses ?>&action=offline&option='+theoption+'&deptid='+thedeptid+'&'+unique ) ;
			else if ( theoption == 3 )
			{
				$('#iframe_edit_'+thedeptid).attr('src', 'iframe_edit.php?ses=<?php echo $ses ?>&action=canned&option='+theoption+'&deptid='+thedeptid+'&'+unique ) ;
			}
			else if ( theoption == 4 )
				$('#iframe_edit_'+thedeptid).attr('src', 'iframe_edit.php?ses=<?php echo $ses ?>&action=temail&option='+theoption+'&deptid='+thedeptid+'&'+unique ) ;
			else if ( theoption == 5 )
				$('#iframe_edit_'+thedeptid).attr('src', 'iframe_edit.php?ses=<?php echo $ses ?>&action=settings&option='+theoption+'&deptid='+thedeptid+'&'+unique ) ;
			else if ( theoption == 6 )
				$('#iframe_edit_'+thedeptid).attr('src', 'iframe_edit.php?ses=<?php echo $ses ?>&action=custom&option='+theoption+'&deptid='+thedeptid+'&'+unique ) ;
			else if ( theoption == 7 )
				$('#iframe_edit_'+thedeptid).attr('src', 'iframe_edit.php?ses=<?php echo $ses ?>&action=smtp&option='+theoption+'&deptid='+thedeptid+'&'+unique ) ;
			else
				return false ;

			$('#iframe_'+thedeptid).fadeIn("fast") ;
			$('#menu_'+theoption+"_"+thedeptid).removeClass('op_submenu').addClass('op_submenu_focus') ;
		}
	}

	function do_edit( thedeptid, thename, theemail, thertype, thertime, therloop, thesavem, thetexpire, thevisible, thequeue, thetshare, thelang )
	{
		$( "input#deptid" ).val( thedeptid ) ;
		$( "input#name" ).val( thename ) ;
		$( "input#email" ).val( theemail ) ;
		$( "select#rtime" ).val( thertime ) ;
		$( "select#texpire" ).val( thetexpire ) ;
		$( "input#rtype_"+thertype ).prop( "checked", true ) ;
		$( "select#rloop" ).val( therloop ) ;
		$( '#savem_'+thesavem ).prop('checked', true) ;
		$( "input#visible_"+thevisible ).prop( "checked", true ) ;
		$( "input#queue_"+thequeue ).prop( "checked", true ) ;
		$( "input#tshare_"+thetshare ).prop( "checked", true ) ;
		if ( thelang ) { $( "select#lang" ).val( thelang ) ; }
		else { $( "select#lang" ).val( "<?php echo $CONF["lang"] ?>" ) ; }
		if ( typeof( themes[thedeptid] ) != "undefined" ) { $( "select#theme" ).val( themes[thedeptid] ) ; }

		$('#div_smtps').hide() ;
		show_form( thedeptid ) ;
	}

	function do_reset_()
	{
		$('html, body').animate({
			scrollTop: 0
		}, 500);
	}

	function do_delete( thedeptid )
	{
		var pos = $('#div_tr_'+thedeptid).position() ;
		var width = $('#div_tr_'+thedeptid).outerWidth() ;
		var height = $('#div_tr_'+thedeptid).outerHeight() + 45 ;

		global_deptid = thedeptid ;
		do_options( global_option, thedeptid ) ;

		if ( $('#div_notice_delete').is(':visible') )
			$('#div_notice_delete').fadeOut( "fast", function() { show_div_delete(pos, width, height) ; }) ;
		else
			show_div_delete(pos, width, height) ;
	}

	function do_delete_doit()
	{
		location.href = "depts.php?ses=<?php echo $ses ?>&action=delete&deptid="+global_deptid ;
	}

	function show_div_delete( thepos, thewidth, theheight )
	{
		$('#div_notice_delete').css({'top': thepos.top, 'left': thepos.left, 'width': thewidth, 'height': theheight}).fadeIn("fast") ;
	}

	function new_canned( thedeptid )
	{
		document.getElementById('iframe_edit_'+thedeptid).contentWindow.toggle_new(1) ;
	}

	function confirm_lang( thelang )
	{
		var thelang_ = thelang[0].toUpperCase() + thelang.substring(1) ;
		if ( thelang == "<?php echo $CONF["lang"] ?>" )
			do_alert( 1, "Success" ) ;
		else
		{
			if ( confirm( "Set primary language to "+thelang_+"?" ) )
				update_lang( thelang ) ;
		}
	}

	function update_lang( thelang )
	{
		location.href = 'depts.php?ses=<?php echo $ses ?>&action=update_lang&deptid=0&lang='+thelang ;
	}

	function confirm_theme( thetheme )
	{
		if ( thetheme == "<?php echo $CONF["THEME"] ?>" )
			do_alert( 1, "Success" ) ;
		else
		{
			if ( confirm( "Set primary theme to "+thetheme+"?" ) )
				update_theme( thetheme ) ;
		}
	}

	function update_theme( thetheme )
	{
		location.href = 'depts.php?ses=<?php echo $ses ?>&action=update_theme&theme='+thetheme ;
	}


	function show_form( thedeptid )
	{
		if ( typeof( global_option ) != "undefined" )
		{
			if ( $('#iframe_edit_'+global_deptid).is(':visible') && ( document.getElementById('iframe_edit_'+global_deptid).contentWindow.option == global_option ) )
			do_options( global_option, global_deptid ) ;
		}

		$(window).scrollTop(0) ;
		if ( !thedeptid ) { $('#div_smtps').show() ; }
		else{ $('#smtp').val(0) }
		$('#div_btn_add').hide() ;
		$('#div_list').hide() ;
		$('#div_form').show() ;
	}

	function do_reset()
	{
		$('#deptid').val(0);$('#lang').val('<?php echo $CONF["lang"] ?>') ;
		$('#theform').each(function(){
			this.reset();
		});

		$(window).scrollTop(0) ;
		$('#div_form').hide() ;
		$('#div_btn_add').show() ;
		$('#div_list').show() ;
		/*$('#div_form').animate({
			height: 0
		}, 500, function() {
			$('#div_form').hide() ;
			$('#div_list').css({'height': 0}).show() ;
			$('#div_list').animate({
				height: global_div_list_height
			}, 500, function() {
				//
			});
		});*/
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div id="div_btn_add" style="margin-top: 25px;">
			<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td><div class="edit_focus" onClick="show_form(0)">Add Department</div></td>
				<td style="padding-left: 15px;">
					<?php if ( count( $departments ) > 1 ): ?>
						<div style="margin-top: 25px; text-shadow: none;" class="info_info">
							<div class="edit_title">Primary Language</div>
							<div>Primary language for <a href="code.php?ses=<?php echo $ses ?>">All Departments HTML Code</a>:</div>
							<div style="margin-top: 5px;">
								<select name="lang_pr" id="lang_pr">
								<?php
									$dir_langs = opendir( "$CONF[DOCUMENT_ROOT]/lang_packs/" ) ;

									$langs = Array() ;
									while ( $this_lang = readdir( $dir_langs ) )
										$langs[] = $this_lang ;
									closedir( $dir_langs ) ;

									for ( $c = 0; $c < count( $langs ); ++$c )
									{
										$this_lang = preg_replace( "/.php/", "", $langs[$c] ) ;

										$selected = $selected_string = "" ;
										if ( $CONF["lang"] == $this_lang )
										{
											$selected = "selected" ;
											$selected_string = " ($selected)" ;
										}

										if ( preg_match( "/[a-z]/i", $this_lang ) )
											print "<option value=\"$this_lang\" $selected>".ucfirst( $this_lang )."$selected_string</option>" ;
									}
								?>
								</select> &nbsp;
								<button type="button" onClick="confirm_lang($('#lang_pr').val())" class="btn">Update</button>
							</div>
						</div>
					<?php endif; ?>
				</td>
				<td style="padding-left: 15px;">
					<?php if ( count( $departments ) > 1 ): ?>
						<div style="margin-top: 25px; text-shadow: none;" class="info_info">
							<div class="edit_title">Primary Theme</div>
							<div>Primary theme for <a href="code.php?ses=<?php echo $ses ?>">All Departments HTML Code</a>:</div>
							<div style="margin-top: 5px;">
								<select name="theme_pr" id="theme_pr">
								<?php
									$dir_themes = opendir( "$CONF[DOCUMENT_ROOT]/themes/" ) ;

									$themes = Array() ;
									while ( $this_theme = readdir( $dir_themes ) )
										$themes[] = $this_theme ;
									closedir( $dir_themes ) ;

									for ( $c = 0; $c < count( $themes ); ++$c )
									{
										$this_theme = $themes[$c] ;

										$selected = $selected_string = "" ;
										if ( $CONF["THEME"] == $this_theme )
										{
											$selected = "selected" ;
											$selected_string = " ($selected)" ;
										}

										if ( preg_match( "/[a-z]/i", $this_theme ) && ( $this_theme != "initiate" ) )
											print "<option value=\"$this_theme\" $selected>$this_theme$selected_string</option>" ;
									}
								?>
								</select> &bull; <a href="JavaScript:void(0)" onClick="preview_theme($('#theme_pr').val(), <?php echo $VARS_CHAT_WIDTH ?>, <?php echo $VARS_CHAT_HEIGHT ?>, 0 )">view</a> &nbsp;
								<button type="button" onClick="confirm_theme($('#theme_pr').val())" class="btn">Update</button>
							</div>
						</div>
					<?php endif; ?>
				</td>
			</tr>
			</table>
		</div>
		<div id="div_list" style="margin-top: 25px;">
			<table cellspacing=0 cellpadding=0 border=0 width="100%">
			<tr>
				<td width="40"><div class="td_dept_header">&nbsp;</div></td>
				<td><div class="td_dept_header">Department</div></td>
				<td width="200"><div class="td_dept_header">Email</div></td>
				<td width="90" nowrap><div class="td_dept_header" style="white-space: nowrap;">Routing Type</div></td>
				<td width="85" nowrap><div class="td_dept_header" style="white-space: nowrap;">Routing Time</div></td>
				<td width="45" nowrap><div class="td_dept_header" style="white-space: nowrap;">Loop</div></td>
				<td width="60" align="center"><div class="td_dept_header">Visible</div></td>
				<td width="80" nowrap><div class="td_dept_header">Language</div></td>
				<td width="80" nowrap><div class="td_dept_header">Theme</div></td>
			</tr>
			<?php
				$image_empty = "<img src=\"../pics/space.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"\">" ;
				$image_checked = "<img src=\"../pics/icons/check.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\">";
				for ( $c = 0; $c < count( $departments ); ++$c )
				{
					$department = $departments[$c] ;

					$name = $department["name"] ;
					$rtype = $vars_rtype[$department["rtype"]] ;
					$rtime = "$department[rtime] sec" ;
					$visible = ( $department["visible"] ) ? $image_checked : $image_empty ;
					$queue = ( $department["queue"] ) ? $image_checked : $image_empty ;
					$tshare = ( $department["tshare"] ) ? $image_checked : $image_empty ;
					$temail = ( $department["temail"] ) ? $image_checked : $image_empty ;
					$lang = ucfirst( $department["lang"] ) ;
					$theme = ( isset( $dept_themes[$department["deptID"]] ) ) ? $dept_themes[$department["deptID"]] : $CONF["THEME"] ;

					$edit_delete = "<div style=\"cursor: pointer;\" onClick=\"do_edit( $department[deptID], '$name', '$department[email]', '$department[rtype]', '$department[rtime]', '$department[rloop]', '$department[savem]', '$department[texpire]', '$department[visible]', '$department[queue]', '$department[tshare]', '$department[lang]' )\"><img src=\"../pics/btn_edit.png\" width=\"64\" height=\"23\" border=\"0\" alt=\"\"></div><div onClick=\"do_delete($department[deptID])\" style=\"margin-top: 10px; cursor: pointer;\"><img src=\"../pics/btn_delete.png\" width=\"64\" height=\"23\" border=\"0\" alt=\"\"></div>" ;
					$options = "
						<span class=\"op_submenu\" id=\"menu_6_$department[deptID]\" style=\"margin-left: 0px;\" onClick=\"do_options( 6, $department[deptID] );\">Chat Request Settings</span>
						<span class=\"op_submenu\" id=\"menu_1_$department[deptID]\" style=\"\" onClick=\"do_options( 1, $department[deptID] );\">Chat Greeting</span>
						<span class=\"op_submenu\" id=\"menu_2_$department[deptID]\" style=\"\" onClick=\"do_options( 2, $department[deptID] );\">Offline Message</span>
						<span class=\"op_submenu\" id=\"menu_4_$department[deptID]\" style=\"\" onClick=\"do_options( 4, $department[deptID] );\">Transcript Email</span>
						<span class=\"op_submenu\" id=\"menu_5_$department[deptID]\" style=\"\" onClick=\"do_options( 5, $department[deptID] );\">Email Settings</span>
						<span class=\"op_submenu\" id=\"menu_3_$department[deptID]\" style=\"\" onClick=\"do_options( 3, $department[deptID] );\">Canned Responses</span>
						<span class=\"op_submenu\" id=\"menu_7_$department[deptID]\" style=\"\" onClick=\"do_options( 7, $department[deptID] );\"><img src=\"../pics/icons/email.png\" width=\"12\" height=\"12\" border=\"0\" alt=\"\"> SMTP</span>
					" ;

					$td1 = "td_dept_td_blank" ; $td2 = "td_dept_td" ;

					print "
					<tr id=\"div_tr_$department[deptID]\">
						<td class=\"$td1\" nowrap>$edit_delete</td>
						<td class=\"$td1\">
							<div><b>$name</b></div>
						</td>
						<td class=\"$td1\">$department[email]</td>
						<td class=\"$td1\">$rtype</td>
						<td class=\"$td1\">$rtime</td>
						<td class=\"$td1\">$department[rloop]</td>
						<td class=\"$td1\" align=\"center\">$visible</td>
						<td class=\"$td1\">$lang</td>
						<td class=\"$td1\"><a href=\"JavaScript:void(0)\" onClick=\"preview_theme('$theme', $VARS_CHAT_WIDTH, $VARS_CHAT_HEIGHT, $department[deptID] )\">$theme</a></td>
					</tr>
					<tr>
						<td class=\"$td2\">&nbsp;</td>
						<td class=\"$td2\" colspan=\"8\" style=\"padding-bottom: 15px;\"><div style=\"\">$options</div><div id=\"iframe_$department[deptID]\" style=\"display: none; width: 100%\"><iframe id=\"iframe_edit_$department[deptID]\" name=\"iframe_edit_$department[deptID]\" style=\"width: 100%; height: 350px; border: 0px; margin-top: 25px;\" src=\"\" scrolling=\"auto\" frameBorder=\"0\"></iframe></div></td>
					</tr>
					" ;
				}
				if ( $c == 0 )
					print "<tr><td colspan=8 class=\"td_dept_td\">blank results</td></tr>" ;
			?>
			</table>
		</div>

		<div id="div_form" style="display: none;" id="a_edit">
			<form method="POST" action="depts.php?submit" id="theform">
			<input type="hidden" name="ses" value="<?php echo $ses ?>">
			<input type="hidden" name="action" value="submit">
			<input type="hidden" name="deptid" id="deptid" value="0">
			<input type="hidden" name="queue" value="0">
			<input type="hidden" name="tshare" value="">

			<div>
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td colspan=2 style="padding: 10px;" align="left"><img src="../pics/icons/arrow_left.png" width="16" height="15" border="0" alt=""> <a href="JavaScript:void(0)" onClick="do_reset()">back</a></td>
				</tr>
				<tr>
					<td nowrap><div class="tab_form_title">Department Name</div></td>
					<td width="100%" style="padding-left: 10px;"><input type="text" name="name" id="name" size="30" maxlength="40" value="" onKeyPress="return noquotes(event)"></td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">Department Email</div></td>
					<td style="padding-left: 10px;"><input type="text" name="email" id="email" size="30" maxlength="160" value="" onKeyPress="return justemails(event)"></td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">Chat Routing Type</div></td>
					<td style="padding-left: 10px;">
						<div><input type="radio" name="rtype" id="rtype_1" value="1"> <span style="font-weight: bold; color: #5D5D5D;">Defined Order:</span> Can be set at the "Defined Order" portion of <a href="ops.php?ses=<?php echo $ses ?>&jump=assign">Assign Operator to Department</a> area</div>
						<div style="margin-top: 3px;"><input type="radio" name="rtype" id="rtype_2" value="2" checked> <span style="font-weight: bold; color: #5D5D5D;">Round-Robin:</span> Operator who has not accpeted a chat the longest will receive the request first.</div>
						<div style="margin-top: 3px;"><input type="radio" name="rtype" id="rtype_3" value="3"> <span style="font-weight: bold; color: #5D5D5D;">Simultaneous:</span> All operators receive the chat request at the same time</div>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">Chat Routing Time</div></td>
					<td style="padding-left: 10px;">If the current operator does not accept the chat request within <select name="rtime" id="rtime" ><option value="5">5 seconds</option><option value="10">10 seconds</option><option value="15">15 seconds</option><option value="30">30 seconds</option><option value="45" selected>45 seconds</option><option value="60">1 minute</option></select>, route the chat to the next available operator.</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">Chat Routing Loop</div></td>
					<td style="padding-left: 10px;">Route the chat request to available operators <select name="rloop" id="rloop" ><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> times (does not apply to Simultaneous routing)</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">Visible for Selection</div></td>
					<td style="padding-left: 10px;">
						When a visitor requests live chat, choose whether to display this department on the selection list. <input type="radio" name="visible" id="visible_1" value="1" checked> Yes <input type="radio" name="visible" id="visible_0" value="0"> No<br>
						If selecting "No", the only method visitors can reach this department is by transfer chat or department specific <a href="code.php?ses=<?php echo $ses ?>">HTML Code</a>.
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">Share Transcripts</div></td>
					<td style="padding-left: 10px;">Select whether chat transcripts are shared between operators or have the records be private to the chat owner. <input type="radio" name="tshare" id="tshare_1" value="1" checked> Yes <input type="radio" name="tshare" id="tshare_0" value="0"> No</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">Offline Messages</div></td>
					<td style="padding-left: 10px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td>Automatically delete saved <a href="reports_chat_msg.php?ses=<?php echo $ses ?>">offline messages</a> greater then &nbsp;</td>
							<td>
								<div class="li_op round"><input type="radio" id="savem_1" name="savem" value=1> 1 month</div>
								<div class="li_op round"><input type="radio" id="savem_3" name="savem" value=3 checked> 3 months</div>
								<div class="li_op round"><input type="radio" id="savem_6" name="savem" value=6> 6 months</div>
								<div class="li_op round"><input type="radio" id="savem_12" name="savem" value=12> 1 year</div>
								<div class="li_op round"><input type="radio" id="savem_0" name="savem" value=0> do not delete</div>
								<div style="clear: both;"></div>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<?php if ( count( $departments_smtp ) > 0 ): ?>
			<div id="div_smtps" style="display: none; margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">SMTP Settings</div></td>
					<td style="padding-left: 10px;">
						Copy SMTP settings of: 
						<select name="smtp" id="smtp">
							<option value="0"></option>
							<?php
								foreach ( $departments_smtp as $deptid => $smtp )
								{
									$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $smtp ) ) ;
									if ( isset( $smtp_array["api"] ) && $smtp_array["api"] )
										print "<option value=\"$deptid\">API: $smtp_array[api] ($smtp_array[login]$smtp_array[domain])</option>" ;
									else
										print "<option value=\"$deptid\">$smtp_array[host] (login: $smtp_array[login])</option>" ;
								}
							?>
						</select>
					</td>
				</tr>
				</table>
			</div>
			<?php endif ; ?>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">Language</div></td>
					<td style="padding-left: 10px;">
						<select name="lang" id="lang">
						<?php
							$dir_langs = opendir( "$CONF[DOCUMENT_ROOT]/lang_packs/" ) ;

							$langs = Array() ;
							while ( $this_lang = readdir( $dir_langs ) )
								$langs[] = $this_lang ;
							closedir( $dir_langs ) ;

							for ( $c = 0; $c < count( $langs ); ++$c )
							{
								$this_lang = preg_replace( "/.php/", "", $langs[$c] ) ;

								$selected = "" ;
								if ( $CONF["lang"] == $this_lang )
									$selected = "selected" ;

								if ( preg_match( "/[a-z]/i", $this_lang ) )
									print "<option value=\"$this_lang\" $selected> ".ucfirst( $this_lang )."</option>" ;
							}
						?>
						</select>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title">Chat Theme</div></td>
					<td style="padding-left: 10px;">
						<select name="theme" id="theme">
						<?php
							$dir_themes = opendir( "$CONF[DOCUMENT_ROOT]/themes/" ) ;

							$themes = Array() ;
							while ( $this_theme = readdir( $dir_themes ) )
								$themes[] = $this_theme ;
							closedir( $dir_themes ) ;

							for ( $c = 0; $c < count( $themes ); ++$c )
							{
								$this_theme = $themes[$c] ;

								$selected = "" ;
								if ( $CONF["THEME"] == $this_theme )
									$selected = "selected" ;

								if ( preg_match( "/[a-z]/i", $this_theme ) && ( $this_theme != "initiate" ) )
									print "<option value=\"$this_theme\" $selected>$this_theme</option>" ;
							}
						?>
						</select> &bull; <a href="JavaScript:void(0)" onClick="preview_theme($('#theme').val(), <?php echo $VARS_CHAT_WIDTH ?>, <?php echo $VARS_CHAT_HEIGHT ?>, 0 )">view</a> &nbsp;
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 25px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title" style="background: #FFFFFF; border: 1px solid #FFFFFF; text-align: left; font-weight: normal;"><img src="../pics/icons/arrow_left.png" width="16" height="15" border="0" alt=""> <a href="JavaScript:void(0)" onClick="do_reset()">back</a></td>
					<td style="padding-left: 10px;"><button type="button" onClick="do_submit()" class="btn">Submit</button></td>
				</tr>
				</table>
			</div>

			</form>
		</div>

		<div id="div_notice_delete" style="display: none; position: absolute; text-align: justify;" class="info_error">
			<div style="padding: 10px;">
				<div class="edit_title">Really delete this department?</div>
				<div style="margin-top: 5px;">It is recommended to set the department to "not visible for selection" rather then delete to retain the department to operator <a href="reports_chat.php?ses=<?php echo $ses ?>" style="color: #FFFFFF;">chat stats</a>.</div>

				<div style="margin-top: 15px;"><button type="button" onClick="do_delete_doit()">Delete</button> &nbsp; <a href="JavaScript:void(0)" style="color: #FFFFFF" onClick="$('#div_notice_delete').fadeOut('fast')">cancel</a></div>
			</div>
		</div>
<?php include_once( "./inc_footer.php" ) ?>

