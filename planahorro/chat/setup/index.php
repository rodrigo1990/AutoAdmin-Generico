<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../web/config.php" ) ){ HEADER("location: install.php") ; exit ; }
	if ( !is_file( "../web/VERSION.php" ) ) { touch( "../web/VERSION.php" ) ; }  // patch 4.2.105 adjustment
	include_once( "../web/config.php" ) ;
	
	if ( !isset( $CONF['SQLTYPE'] ) ) { $CONF['SQLTYPE'] = "SQL.php" ; }
	else if ( $CONF['SQLTYPE'] == "mysql" ) { $CONF['SQLTYPE'] = "SQL.php" ; }

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh, $ses ) ){ ErrorHandler( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; }
	// STANDARD header end
	/****************************************/
	/* AUTO PATCH */
	if ( !is_file( "$CONF[CONF_ROOT]/patches/$patch_v" ) )
	{
		$query = ( isset( $_SERVER["QUERY_STRING"] ) ) ? $_SERVER["QUERY_STRING"] : "" ;
		database_mysql_close( $dbh ) ;
		HEADER( "location: ../patch.php?from=setup&".$query."&" ) ;
		exit ;
	}

	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/remove.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Messages/get.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$error = "" ;

	Ops_update_itr_IdleOps( $dbh ) ;
	//Chat_remove_CleanStats( $dbh ) ; // need to work out the bugs
	//Ops_remove_CleanStats( $dbh ) ; // need to work out the bugs

	$operators = Ops_get_AllOps( $dbh ) ;
	$operators_hash = Array() ;
	for ( $c = 0; $c < count( $operators ); ++$c )
	{
		$operator = $operators[$c] ;
		$operators_hash[$operator["opID"]] = $operator["name"] ;
	}

	$transcripts = Chat_ext_get_RefinedTranscripts( $dbh, "0", "0", "", 0, 15 ) ;
	$messages = Messages_get_TotalUnreadMessages( $dbh, 0 ) ;
	$auto_offline = ( isset( $VALS["AUTO_OFFLINE"] ) && $VALS["AUTO_OFFLINE"] ) ? unserialize( $VALS["AUTO_OFFLINE"] ) : Array() ;

	$ips = isset( $VALS['CHAT_SPAM_IPS'] ) ? explode( "-", $VALS['CHAT_SPAM_IPS'] ) : Array() ; $ips_spam = 0 ;
	for ( $c = 0; $c < count( $ips ); ++$c )
	{
		if ( $ips[$c] ) { ++$ips_spam ; }
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
	var st_rd ;

	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		init_menu() ;
		init_divs() ;
		toggle_menu_setup( "home" ) ;

		<?php if ( $action == "success" ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
	});

	function init_divs()
	{
		var ops_list_height = $('#home_main').outerHeight() - 20 ;

		$('#home_full_list').css({'height': ops_list_height}) ;
	}

	function launch_tools_op_status()
	{
		var url = "tools_op_status.php?ses=<?php echo $ses ?>&pop=1" ;

		if ( <?php echo count( $operators ) ?> > 0 )
			window.open( url, "Operators", "scrollbars=yes,menubar=no,resizable=1,location=no,width=300,height=400,status=0" ) ;
		else
		{
			if ( confirm( "Operator account does not exist.  Create an operator?" ) )
				location.href = "ops.php?ses=<?php echo $ses ?>" ;
		}
	}

	function remote_disconnect( theopid, thelogin )
	{
		if ( typeof( st_rd ) != "undefined" ) { do_alert( 0, "Another disconnect in progress." ) ; return false ; }

		if ( confirm( "Remote disconnect operator console ("+thelogin+")?" ) )
		{
			$('#op_login').html( thelogin ) ;
			$('#remote_disconnect_notice').center().show() ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=remote_disconnect&opid="+theopid+"&"+unixtime(),
				success: function(data){
					eval( data ) ;

					if ( json_data.status )
						check_op_status( theopid ) ;
					else
					{
						$('#remote_disconnect_notice').hide() ;
						do_alert( 0, "Could not remote disconnect console.  Please try again." ) ;
					}
				}
			});
		}
	}

	function check_op_status( theopid )
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		if ( typeof( st_rd ) != "undefined" ) { clearTimeout( st_rd ) ; }

		$.ajax({
		type: "POST",
		url: "../http/status_op.php",
		data: "opid="+theopid+"&jkey=<?php echo md5( $CONF['API_KEY'] ) ?>&"+unique,
		success: function(data){
			eval( data ) ;

			if ( !parseInt( json_data.status ) )
				location.href = 'index.php?ses=<?php echo $ses ?>&action=success&'+unique ;
			else
				st_rd = setTimeout( function(){ check_op_status( theopid ) ; }, 2000 ) ;
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Lost connection to server.  Please reload the page and try again." ) ;
		} });
	}

	function show_div( thediv )
	{
		var divs = Array( "operator", "setup" ) ;

		for ( c = 0; c < divs.length; ++c )
		{
			$('#login_'+divs[c]).hide() ;
			$('#menu_url_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('#login_'+thediv).show() ;
		$('#menu_url_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}
//-->
</script>
</head>

<?php include_once( "./inc_header.php" ) ; ?>

		<table cellspacing=0 cellpadding=0 border=0 width="100%">
		<tr>
			<td valign="top">
				<div class="home_box" id="home_full_list" style="margin-left: 0px; width: 280px;">
					<div class="edit_title td_dept_header" style="margin-right: 0px; padding: 12px; background: url( ../pics/bg_tab_blue.gif ) repeat-x; border: 1px solid #6EA6BF; color: #FFFFFF; text-shadow: none;">Complete List of Options</div>

					<div id="home_full_list_content" class="td_dept_td" style="height: 400px; overflow: auto; padding-left: 0px; padding-top: 0px;">
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_depts.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="depts.php?ses=<?php echo $ses ?>">Departments</a></div>
						</div>
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_ops.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="ops.php?ses=<?php echo $ses ?>">Operators</a></div>
							<div style="padding-left: 19px; margin-top: 5px; font-decoration: normal;">
								<div class="home_box_menu_li"> <a href="ops.php?ses=<?php echo $ses ?>">Create/Edit Operators</a></div>
								<div class="home_box_menu_li"> <a href="ops.php?ses=<?php echo $ses ?>&jump=assign">Assign Operator to Department</a></div>
								<div class="home_box_menu_li"> <a href="ops_reports.php?ses=<?php echo $ses ?>">Online/Offline Activity</a></div>
								<div class="home_box_menu_li"> <a href="ops.php?ses=<?php echo $ses ?>&jump=monitor">Status Widget</a></div>
								<div class="home_box_menu_li"><img src="../pics/icons/bulb.png" width="12" height="12" border="0" alt=""> <a href="ops.php?ses=<?php echo $ses ?>&jump=online">Go <span style="color: #3EB538; font-weight: bold;">ONLINE</span></a></div>
							</div>
						</div>
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_icons.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="icons.php?ses=<?php echo $ses ?>">Chat Icons</a></div>
						</div>
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_icons.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="interface.php?ses=<?php echo $ses ?>">Interface</a></div>
							<div style="padding-left: 19px; margin-top: 5px; font-decoration: normal;">
								<div class="home_box_menu_li"> <a href="interface.php?ses=<?php echo $ses ?>">Logo</a></div>
								<div class="home_box_menu_li"> <a href="interface.php?ses=<?php echo $ses ?>&jump=themes">Themes</a></div>
								<div class="home_box_menu_li"> <a href="interface.php?ses=<?php echo $ses ?>&jump=charset">Character Set</a></div>
								<div class="home_box_menu_li"> <a href="interface.php?ses=<?php echo $ses ?>&jump=time">Time Zone</a></div>
								<!-- <div class="home_box_menu_li"> <a href="interface.php?ses=<?php echo $ses ?>&jump=lang">Language Text</a></div> -->
								<div class="home_box_menu_li"> <a href="interface.php?ses=<?php echo $ses ?>&jump=misc_settings">Settings</a></div>
								<div class="home_box_menu_li"> <a href="interface.php?ses=<?php echo $ses ?>&jump=screen">Login Screen</a></div>
							</div>
						</div>
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_code.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="code.php?ses=<?php echo $ses ?>">HTML Code</a></div>
							<div style="padding-left: 19px; margin-top: 5px; font-decoration: normal;">
								<div class="home_box_menu_li"> <a href="code.php?ses=<?php echo $ses ?>&jump=auto">Automatic Chat Invite</a></div>
							</div>
						</div>
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_trans.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="transcripts.php?ses=<?php echo $ses ?>">Transcripts</a></div>
						</div>
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_chats.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="reports_chat.php?ses=<?php echo $ses ?>">Chats</a></div>
							<div style="padding-left: 19px; margin-top: 5px; font-decoration: normal;">
								<div class="home_box_menu_li"> <a href="reports_chat.php?ses=<?php echo $ses ?>">Chats</a></div>
								<div class="home_box_menu_li"> <a href="reports_chat_active.php?ses=<?php echo $ses ?>">Active Chats</a></div>
								<div class="home_box_menu_li"> <a href="reports_chat_missed.php?ses=<?php echo $ses ?>">Missed Chats</a></div>
								<div class="home_box_menu_li"> <a href="reports_chat_msg.php?ses=<?php echo $ses ?>">Offline Messages (<?php echo $messages ?>)</a></div>
							</div>
						</div>
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_traffic.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="reports_traffic.php?ses=<?php echo $ses ?>">Traffic</a></div>
							<div style="padding-left: 19px; margin-top: 5px; font-decoration: normal;">
								<div class="home_box_menu_li"> <a href="reports_traffic.php?ses=<?php echo $ses ?>">Website Footprints</a></div>
								<div class="home_box_menu_li"> <a href="reports_refer.php?ses=<?php echo $ses ?>">Refer URLs</a></div>
								<div class="home_box_menu_li"> <a href="reports_traffic.php?ses=<?php echo $ses ?>&jump=settings">Settings</a></div>
							</div>
						</div>
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_extras.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="extras.php?ses=<?php echo $ses ?>">Extras</a></div>
							<div style="padding-left: 19px; margin-top: 5px; font-decoration: normal;">
								<div class="home_box_menu_li"> <a href="extras.php?ses=<?php echo $ses ?>&jump=apis">Dev APIs</a></div>
								<div class="home_box_menu_li"> <a href="marketing.php?ses=<?php echo $ses ?>">Marketing</a></div>
								<div class="home_box_menu_li"> <a href="extras_geo.php?ses=<?php echo $ses ?>">GeoIP</a></div>
								<div class="home_box_menu_li"> <a href="extras_geo.php?ses=<?php echo $ses ?>&jump=geomap">Google Maps</a></div>
								<div class="home_box_menu_li"> <a href="extras.php?ses=<?php echo $ses ?>">External URLs</a></div>
								<?php if ( is_file( "../addons/smtp/smtp.php" ) ): ?><div class="home_box_menu_li"> <a href="../addons/smtp/smtp.php?ses=<?php echo $ses ?>">SMTP</a></div><?php endif ; ?>
								<?php if ( is_file( "../addons/emoticons/emo.php" ) ): ?><div class="home_box_menu_li"> <a href="../addons/emoticons/emo.php?ses=<?php echo $ses ?>">Emoticons</a></div><?php endif ; ?>
							</div>
						</div>
						<div class="home_box_li_blank" style="">
							<div><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_settings.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="settings.php?ses=<?php echo $ses ?>">Settings</a></div>
							<div style="padding-left: 19px; margin-top: 5px; font-decoration: normal;">
								<div class="home_box_menu_li"> <a href="settings.php?ses=<?php echo $ses ?>">Excluded IPs</a></div>
								<div class="home_box_menu_li"> <a href="settings.php?ses=<?php echo $ses ?>&jump=sips">Blocked IPs</a></div>
								<div class="home_box_menu_li"> <a href="settings.php?ses=<?php echo $ses ?>&jump=cookie">Cookies</a></div>
								<?php if ( $admininfo["adminID"] == 1 ): ?>
								<div class="home_box_menu_li"> <a href="settings.php?ses=<?php echo $ses ?>&jump=profile"><img src="../pics/icons/key.png" width="12" height="12" border="0" alt=""> Setup Profile</a></div>
								<?php endif ; ?>
								<div class="home_box_menu_li"> <a href="db.php?ses=<?php echo $ses ?>">System</a></div>
							</div>
						</div>
					</div>

				</div>
			</td>
			<td id="td_right" valign="top">

				<div id="home_main">
					<table cellspacing=0 cellpadding=0 border=0 width="100%">
					<tr>
						<td valign="top">
							<div id="home_box_start" class="home_box" style="width: 280px; padding-right: 0px; background: url( ../pics/intro.gif ) no-repeat; background-position: bottom right;">
								<div class="edit_title td_dept_header" style="margin-right: 0px; padding: 12px; background: url( ../pics/bg_tab_blue.gif ) repeat-x; border: 1px solid #6EA6BF; color: #FFFFFF; text-shadow: none;"><img src="../pics/icons/power_on.png" width="14" height="14" border="0" alt="" style="background: #FFFFFF; border: 2px solid #FFFFFF;" class="round"> Start here.  Things to do:</div>
								<div style="text-shadow: 1px 1px #FFFFFF; padding-top: 10px;">
									<div id="todo_1" class="home_box_li_blank" style="margin-top: 0px;"><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_depts.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="depts.php?ses=<?php echo $ses ?>">Create Department</a></div>
									<div class="home_box_li_blank" style="margin-top: 10px;"><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_ops.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="ops.php?ses=<?php echo $ses ?>">Create Operator</a></div>
									<div class="home_box_li_blank" style="margin-top: 10px;"><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_ops.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="ops.php?ses=<?php echo $ses ?>&jump=assign">Assign Operator to Department</a></div>
									<div class="home_box_li_blank" style="margin-top: 10px;"><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_code.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="code.php?ses=<?php echo $ses ?>">Generate HTML Code</a></div>
									<div class="home_box_li_blank" style="margin-top: 10px;"><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_ops.png" width="12" height="12" border="0" alt=""></span> &nbsp; <img src="../pics/icons/bulb.png" width="16" height="16" border="0" alt=""> <a href="ops.php?ses=<?php echo $ses ?>&jump=online">Go <span style="color: #3EB538; font-weight: bold;">ONLINE</span></a></div>
								</div>
							</div>
						</td>
						<td valign="top">
							<div id="home_ops_list" class="home_box" style="border: 0px solid transparent; margin-right: 0px;">
								<div style="height: 160px; overflow: auto; overflow-x: hidden;">
									<table cellspacing=0 cellpadding=0 border=0 width="100%">
									<tr>
										<td width="120"><div class="td_dept_header" style="">Operator</div></td>
										<td width="80"><div class="td_dept_header" style="">Status</div></td>
										<td><div class="td_dept_header" style="">Chats</div></td>
									</tr>
									<?php
										for ( $c = 0; $c < count( $operators ); ++$c )
										{
											$operator = $operators[$c] ;
											$status = ( $operator["status"] ) ? "<b>Online</b>" : "Offline" ;
											$status_img = ( $operator["status"] ) ? "<img src=\"../pics/icons/bulb.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"online\" title=\"online\">" : "<img src=\"../pics/icons/bulb_off.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"offline\" title=\"offline\">" ;
											$tr_style = ( $operator["status"] ) ? "background: #AFFF9F;" : "" ;
											$style = ( $operator["status"] ) ? "cursor: pointer" : "" ;
											$js = ( $operator["status"] ) ? "onClick=\"remote_disconnect($operator[opID], '$operator[login]')\"" : "" ;

											$requests = Chat_get_OpTotalRequests( $dbh, $operator["opID"] ) ;

											print "<tr style=\"$tr_style\"><td class=\"td_dept_td\">$operator[name]</td><td class=\"td_dept_td\" style=\"$style\" $js>$status_img</td><td class=\"td_dept_td\"><a href=\"JavaScript:void(0)\" onClick=\"location.href='reports_chat_active.php?ses=$ses'\">$requests</a></td></tr>" ;
										}
										if ( $c == 0 )
											print "<tr><td colspan=7 class=\"td_dept_td\">Blank results.</td></tr>" ;
									?>
									</table>
								</div>
								<div style="margin-top: 25px;" class="info_info">
									<table cellspacing=0 cellpadding=0 border=0 width="100%">
									<tr>
										<td align="center"><span style="padding: 5px; background: url( ../pics/bg_tab.gif ) repeat-x #3FBBCA; color: #FFFFFF; border: 1px solid #6EA6BF;" class="round"><img src="../pics/icons/menu_flag.png" width="12" height="12" border="0" alt=""></span> &nbsp; <a href="./reports_chat_msg.php?ses=<?php echo $ses ?>">Offline Messages (<?php echo $messages ?>)</a></td>
									</tr>
									</table>
								</div>

							</div>
						</td>
					</tr>
					<tr>
						<td colspan=2 style="padding-left: 50px;">
							<div style="height: 5px;" class="td_dept_td"></div>
							<div style="margin-top: 25px; background: url( ../pics/icons/bulb.png ) no-repeat; padding-left: 25px;">
								View operator online/offline status and chat activity within a tiny widget window. The widget window can be left open on the desktop for quick access to status information and real-time chat sessions.

								<div style="margin-top: 25px;">
									<button type="button" onClick="launch_tools_op_status()" class="btn">Launch Operator Status Widget Window</button>
								</div>
							</div>

							<?php if ( count( $auto_offline ) ): ?>
							<div style="height: 5px;" class="td_dept_td"></div>
							<div style="margin-top: 25px; background: url( ../pics/icons/bullet_red.png ) no-repeat; padding-left: 25px;"> <a href="depts.php?ses=<?php echo $ses ?>&ao=1">Automatic Offline</a> is currently active for one or more departments.</div>
							<?php endif ; ?>

							<?php if ( $ips_spam > 0 ): ?>
							<div style="height: 5px;" class="td_dept_td"></div>
							<div style="margin-top: 25px; background: url( ../pics/icons/bullet_red.png ) no-repeat; padding-left: 25px;"> Currently there are <a href="settings.php?ses=<?php echo $ses ?>&jump=sips"><?php echo $ips_spam ?> IPs blocked</a> from chat access.  Blocked IPs will always see an offline chat status.  It is suggested to periodically clear out the blocked IPs after few weeks.</div>
							<?php endif ; ?>

							<div style="height: 5px;" class="td_dept_td"></div>
							<div style="margin-top: 25px; text-align: right;">
								<span class="info_neutral" style="float: right;"><img src="../pics/icons/disc.png" width="16" height="16" border="0" alt=""> <a href="http://www.phplivesupport.com/r.php?r=vcheck&v=<?php echo base64_encode( $VERSION ) ?>" target="new" style="">check for new version</a></span>
							</div>
						</td>
					</tr>
					</table>
				</div>

			</td>
		</tr>
		</table>

		<div id="remote_disconnect_notice" style="display: none; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: url( ../pics/bg_trans_white.png ) repeat; overflow: hidden; z-index: 20;">
			<div style="padding-top: 300px; text-align: center;"><span class="info_error" style="">Disconnecting console [ <span id="op_login"></span> ].  Just a moment... <img src="../pics/loading_fb.gif" width="16" height="11" border="0" alt=""></span></div>
		</div>

<?php include_once( "./inc_footer.php" ) ; ?>
