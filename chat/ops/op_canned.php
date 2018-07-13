<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	if ( !$opinfo = Util_Security_AuthOp( $dbh, $ses ) ){ ErrorHandler( 602, "Invalid operator session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; }
	// STANDARD header end
	/****************************************/

	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/get.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$flag = Util_Format_Sanatize( Util_Format_GetVar( "flag" ), "ln" ) ;

	$error = "" ;

	if ( $action == "submit" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/put.php" ) ;

		$canid = Util_Format_Sanatize( Util_Format_GetVar( "canid" ), "ln" ) ;
		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;
		$title = Util_Format_Sanatize( Util_Format_GetVar( "title" ), "ln" ) ;
		$message = Util_Format_Sanatize( Util_Format_GetVar( "message" ), "" ) ;

		$caninfo = Canned_get_CanInfo( $dbh, $canid ) ;
		if ( isset( $caninfo["opID"] ) )
			$opid = $caninfo["opID"] ;
		else
			$opid = $opinfo["opID"] ;

		if ( !Canned_put_Canned( $dbh, $canid, $opinfo["opID"], $deptid, $title, $message ) )
			$error = "Error processing canned message." ;
	}
	else if ( $action == "delete" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/remove.php" ) ;

		$canid = Util_Format_Sanatize( Util_Format_GetVar( "canid" ), "ln" ) ;

		$caninfo = Canned_get_CanInfo( $dbh, $canid ) ;
		if ( $caninfo["opID"] == $opinfo["opID"] )
			Canned_remove_Canned( $dbh, $opinfo["opID"], $canid ) ;
	}

	$departments = Depts_get_OpDepts( $dbh, $opinfo["opID"] ) ;
	$cans = Canned_get_OpCanned( $dbh, $opinfo["opID"], 0 ) ;

	// make hash for quick refrence
	$dept_hash = Array() ;
	$dept_hash[1111111111] = "All Departments" ;
	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		$dept_hash[$department["deptID"]] = $department["name"] ;
	}
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> canned responses </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8">
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../themes/<?php echo $opinfo["theme"] ?>/style.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	$(document).ready(function()
	{
		if ( ( "<?php echo $action ?>" == "submit" ) && ( "<?php echo $error ?>" == "" ) )
		{
			if ( typeof( parent.isop ) != "undefined" )
				parent.populate_cans(0) ;
		}
		else if ( "<?php echo $action ?>" == "delete" )
		{
			if ( typeof( parent.isop ) != "undefined" )
				parent.populate_cans(0) ;
		}

		if ( "<?php echo $flag ?>" == "new_canned" )
			toggle_new(1) ;

		init_trs() ;
		if ( !parent.mobile ) { }
		
		$('#canned_wrapper').fadeIn() ;

		<?php if ( ( $action == "submit" ) && !$error ): ?>parent.do_alert( 1, "Success" ) ;<?php endif ; ?>

		//$(document).dblclick(function() {
		//	parent.close_extra( "canned" ) ;
		//});
	});

	function init_trs()
	{
		$('#table_trs tr:nth-child(2n+3)').addClass('chat_info_tr_traffic_row') ;
	}

	function toggle_new( theflag )
	{
		// theflag = 1 means force show, not toggle
		if ( $('#canned_box_new').is(':visible') && !theflag )
		{
			$( "input#canid" ).val( "" ) ;
			$( "input#title" ).val( "" ) ;
			$( "#deptid" ).val( 1111111111 ) ;
			$( "#message" ).val( "" ) ;

			$('#canned_wrapper').show() ;
			$('#canned_box_new').hide() ;
			toggle_menu_info( "list" ) ;
		}
		else
		{
			$('#canned_box_new').show() ;
			$('#canned_wrapper').hide() ;
		}
	}

	function do_edit( thecanid, thetitle, thedeptid, themessage )
	{
		$( "input#canid" ).val( thecanid ) ;
		$( "input#title" ).val( thetitle.replace( /&-#39;/g, "'" ) ) ;
		$( "#deptid" ).val( thedeptid ) ;
		$( "#message" ).val( themessage.replace(/<br>/g, "\r\n").replace( /&-#39;/g, "'" ) ) ;
		
		toggle_new(0) ;
	}

	function do_delete( thiscanid )
	{
		if ( confirm( "Really delete this canned response?" ) )
			location.href = "op_canned.php?ses=<?php echo $ses ?>&action=delete&canid="+thiscanid ;
	}

	function do_submit()
	{
		var canid = $('#canid').val() ;
		var title = $('#title').val() ;
		var deptid = $('#deptid').val() ;
		var message = $('#message').val() ;

		if ( title == "" )
			do_alert( 0, "Please provide a title." ) ;
		else if ( message == "" )
			do_alert( 0, "Please provide a message." ) ;
		else
			$('#theform').submit() ;
	}

	function toggle_menu_info( themenu )
	{
		var divs = Array( "list", "settings" ) ;

		for ( c = 0; c < divs.length; ++c )
		{
			$('#canned_'+divs[c]).hide() ;
			$('#menu_canned_'+divs[c]).removeClass('menu_traffic_info_focus').addClass('menu_traffic_info') ;
		}

		$('#canned_'+themenu).show() ;
		$('#menu_canned_'+themenu).removeClass('menu_traffic_info').addClass('menu_traffic_info_focus') ;
	}
//-->
</script>
</head>
<body>

<div id="canned_wrapper" style="display: none; height: 100%; overflow: auto;">
	<table cellspacing=0 cellpadding=0 border=0 width="100%"><tr><td class="t_tl"></td><td class="t_tm"></td><td class="t_tr"></td></tr>
	<tr>
		<td class="t_ml"></td><td class="t_mm">
			<div style="padding-bottom: 15px;">
				<div class="menu_traffic_info_focus" style="border: 0px; cursor: pointer;" onClick="toggle_new(1)"><img src="../themes/<?php echo $opinfo["theme"] ?>/add.png" width="12" height="12" border="0" alt=""> Add New</div>
				<!-- <div id="menu_canned_list" class="menu_traffic_info_focus" onClick="toggle_menu_info('list')">Canned Responses</div>
				<div id="menu_canned_settings" class="menu_traffic_info" onClick="toggle_menu_info('settings')">Settings</div> -->
				<div style="clear: both;"></div>
			</div>
			<div id="canned_list">
				<table cellspacing=0 cellpadding=0 border=0 width="100%" id="table_trs">
				<tr>
					<td width="60" nowrap><div class="chat_info_td_t">&nbsp;</div></td>
					<td width="180" nowrap><div class="chat_info_td_t">Title</div></td>
					<td width="180"><div class="chat_info_td_t">Department</div></td>
					<td width="100%"><div class="chat_info_td_t">Message</div></td>
				</tr>
				<?php
					for ( $c = 0; $c < count( $cans ); ++$c )
					{
						$can = $cans[$c] ;
						$title = preg_replace( "/\"/", "&quot;", preg_replace( "/'/", "&-#39;", $can["title"] ) ) ;
						$title_display = Util_Format_ConvertQuotes( $can["title"] ) ;

						$dept_name = $dept_hash[$can["deptID"]] ;
						$message = preg_replace( "/\"/", "&quot;", preg_replace( "/'/", "&-#39;", preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", $can["message"] ) ) ) ;
						$message_display = preg_replace( "/\"/", "&quot;", preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", Util_Format_ConvertTags( $can["message"] ) ) ) ;

						$delete_image = ( $can["opID"] == $opinfo["opID"] ) ? "<img src=\"../themes/$opinfo[theme]/delete.png\" style=\"cursor: pointer;\" onClick=\"do_delete($can[canID])\" title=\"delete\" alt=\"delete\" width=\"14\" height=\"14\" border=0>" : "<img src=\"../pics/space.gif\" width=\"14\" height=\"14\" border=0>" ;
						$edit_image = ( $can["opID"] == $opinfo["opID"] ) ? "<img src=\"../themes/$opinfo[theme]/edit.png\" style=\"cursor: pointer;\" onClick=\"do_edit($can[canID], '$title', '$can[deptID]', '$message')\" title=\"edit canned\"  alt=\"edit canned\" width=\"14\" height=\"14\" border=0>" : "<img src=\"../themes/$opinfo[theme]/lock.png\" width=\"14\" height=\"14\" border=0 title=\"created by setup admin\" alt=\"created by setup admin\">" ;

						print "<tr><td class=\"chat_info_td_traffic\" nowrap>$delete_image &nbsp; $edit_image</td><td class=\"chat_info_td_traffic\" nowrap><button type=\"button\" style=\"font-size: 10px;\" onClick=\"parent.select_canned_pre('$title_display')\">select</button> <b>$title_display</b></td><td class=\"chat_info_td_traffic\" nowrap>$dept_name</td><td class=\"chat_info_td_traffic\">$message_display</td></tr>" ;
					}
				?>
				</table>
				<div class="chat_info_end"></div>
			</div>
			<div id="canned_settings" style="display: none;">
			</div>
		</td><td class="t_mr"></td>
	</tr>
	<tr><td class="t_bl"></td><td class="t_bm"></td><td class="t_br"></td></tr>
	</table>
</div>

<div id="canned_box_new" style="display: none; height: 100%; overflow: auto;">
	<table cellspacing=0 cellpadding=0 border=0 width="100%"><tr><td class="t_tl"></td><td class="t_tm"></td><td class="t_tr"></td></tr>
	<tr>
		<td class="t_ml"></td><td class="t_mm">
			<table cellspacing=0 cellpadding=0 border=0 width="100%">
			<tr>
				<td valign="top" nowrap width="100%">
					<form method="POST" action="op_canned.php?<?php echo time() ?>" id="theform">
					<input type="hidden" name="ses" value="<?php echo $ses ?>">
					<input type="hidden" name="action" value="submit">
					<input type="hidden" name="canid" id="canid" value="0">
					<div>
						Reference (example: "Greeting", "Just a moment")
						<div><input type="text" name="title" id="title" class="input_text" style="width: 98%; margin-bottom: 10px;" maxlength="25"></div>
						<div>Department</div>
						<div><select name="deptid" id="deptid" style="width: 99%; margin-bottom: 10px;">
							<option value="1111111111">All Departments</option>
							<?php
								for ( $c = 0; $c < count( $departments ); ++$c )
								{
									$department = $departments[$c] ;

									print "<option value=\"$department[deptID]\">$department[name]</option>" ;
								}
							?>
						</select></div>
						<div>Canned Message</div>
						<div><textarea name="message" id="message" class="input_text" rows="7" style="min-width: 98%; margin-bottom: 10px;" wrap="virtual"></textarea></div>

						<div><button type="button" onClick="do_submit()" class="input_button">Submit</button> &nbsp; <span style="text-decoration: underline; cursor: pointer;" onClick="toggle_new(0)">cancel</span></div>
						</form>
					</div>
				</td>
				<td valign="center" nowrap style="padding-left: 25px;">
					<ul>
						<li> HTML will be converted to raw code.</li>
						<li style="margin-top: 5px;"> Your created canned messages are private and are not shared.</li>

						<li style="margin-top: 5px;"> Following variables will dynamically populate various information:</li>
							<ul style="margin-top: 10px;">
								<li> <b>%%visitor%%</b> = visitor's name</li>
								<li> <b>%%operator%%</b> = your name</li>
								<li> <b>%%op_email%%</b> = your email</li>

								<li style="padding-top: 10px;"> to link an email use the command <b>email:</b></li>
									<ul>
										<li> <i>example</i> - <b>email:</b><i>someone@somewhere.com</i></li>
									</ul>
								<li style="padding-top: 10px;"> to display an image use the command <b>image:</b></li>
									<ul>
										<li> <i>example</i> - <b>image:</b><i>http://www.someurl.com/image.gif</i></li>
									</ul>
							</ul>
					</ul>
				</td>
			</tr>
			</table>
		</td><td class="t_mr"></td>
	</tr>
	<tr><td class="t_bl"></td><td class="t_bm"></td><td class="t_br"></td></tr>
	</table>
</div>

</body>
</html>
<?php database_mysql_close( $dbh ) ; ?>