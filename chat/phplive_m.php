<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "./web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Email.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Marquee/get.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;
	$theme = Util_Format_Sanatize( Util_Format_GetVar( "theme" ), "ln" ) ;
	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
	$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;
	$chat = Util_Format_Sanatize( Util_Format_GetVar( "chat" ), "n" ) ;
	$vname = Util_Format_Sanatize( Util_Format_Sanatize( Util_Format_GetVar( "vname" ), "v" ), "ln" ) ;
	$vemail = Util_Format_Sanatize( Util_Format_GetVar( "vemail" ), "e" ) ;
	$vsubject = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "vsubject" ), "htmltags" ) ) ;
	$vquestion = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "vquestion" ), "htmltags" ) ) ;
	$onpage = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "onpage" ), "url" ) ) ; $onpage = ( $onpage ) ? $onpage : "" ;
	$embed = Util_Format_Sanatize( Util_Format_GetVar( "embed" ), "n" ) ;
	$custom = Util_Format_Sanatize( Util_Format_GetVar( "custom" ), "ln" ) ;
	$token = Util_Format_Sanatize( Util_Format_GetVar( "token" ), "ln" ) ;
	$dept_themes = ( isset( $VALS["THEMES"] ) ) ? unserialize( $VALS["THEMES"] ) : Array() ;
	if ( !$theme && isset( $dept_themes[$deptid] ) && $deptid ) { $theme = $dept_themes[$deptid] ; }
	else if ( !$theme ) { $theme = $CONF["THEME"] ; }

	$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
	LIST( $ip, $vis_token ) = Util_IP_GetIP( $token ) ;
	LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
	$mobile = ( $os == 5 ) ? 1 : 0 ;

	if ( preg_match( "/$ip/", $VALS["CHAT_SPAM_IPS"] ) ) { $spam_exist = 1 ; }
	else { $spam_exist = 0 ; }

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	if ( !isset( $deptinfo["deptID"] ) )
	{
		$query = $_SERVER["QUERY_STRING"] ;
		$query = preg_replace( "/^d=(\d+)&/", "d=0&", $query ) ;
		database_mysql_close( $dbh ) ;
		HEADER( "location: phplive.php?$query" ) ; exit ;
	}

	if ( $deptinfo["smtp"] )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;

		$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;

		$CONF["SMTP_HOST"] = $smtp_array["host"] ;
		$CONF["SMTP_LOGIN"] = $smtp_array["login"] ;
		$CONF["SMTP_PASS"] = $smtp_array["pass"] ;
		$CONF["SMTP_PORT"] = $smtp_array["port"] ;
	}

	if ( $deptinfo["lang"] )
		$CONF["lang"] = $deptinfo["lang"] ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ;

	if ( $action == "send_email" )
	{
		$custom_string = "" ;
		$customs = explode( "-cus-", $custom ) ;
		for ( $c = 0; $c < count( $customs ); ++$c )
		{
			$custom_var = $customs[$c] ;
			if ( $custom_var && preg_match( "/-_-/", $custom_var ) )
			{
				LIST( $cus_name, $cus_var ) = explode( "-_-", $custom_var ) ;
				$custom_string .= $cus_name.": ".$cus_var."\r\n" ;
			}
		}

		$trans = Util_Format_Sanatize( Util_Format_GetVar( "trans" ), "n" ) ;
		if ( !$vsubject ) { $vsubject = $LANG["CHAT_JS_LEAVE_MSG"] ; }
		if ( $trans )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

			$opinfo = Ops_get_OpInfoByID( $dbh, $opid ) ;
			$transcript = Chat_ext_get_Transcript( $dbh, $ces ) ;
			$extra = "trans" ;

			$from_name = $vname ;
			$from_email = $vemail ;
			$vname = $opinfo["name"] ;
			$vemail = $opinfo["email"] ;
			// fix the dollar ($) variable
			$message = preg_replace( "/%%transcript%%/", preg_replace( "/\\$/", "-dollar-", $transcript["formatted"] ), $vquestion ) ;
		}
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/IPs/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Messages/put.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_ext.php" ) ;

			$ipinfo = IPs_get_IPInfo( $dbh, $vis_token, $ip ) ;
			$referinfo = Footprints_get_IPRefer( $dbh, $vis_token ) ;
			$t_footprints = isset( $ipinfo["t_footprints"] ) ? $ipinfo["t_footprints"] : 1 ;
			$refer_url = ( isset( $referinfo["refer"] ) && $referinfo["refer"] ) ? $referinfo["refer"] : "" ;

			if ( $deptinfo["savem"] )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Messages/remove.php" ) ;
				Messages_remove_LastMessages( $dbh, $deptinfo["deptID"], $deptinfo["savem"] ) ;
			}
			Messages_put_Message( $dbh, $deptid, $chat, $t_footprints, $ip, $vname, $vemail, $vsubject, $onpage, $refer_url, $custom, $vquestion ) ;

			$extra = "" ;
			$from_name = $deptinfo["name"] ;
			$from_email = $deptinfo["email"] ;
			$message = "Message to $from_name:\r\n\r\n$vquestion\r\n\r\n======= Visitor Information =======\r\n\r\n$custom_string"."Name: $vname\r\nEmail: $vemail\r\n\r\nFootprints: $t_footprints\r\nIP Address: $ip\r\nVisitor ID: $vis_token\r\n\r\nClicked From:\r\n$onpage\r\n\r\n======\r\n\r\n".$LANG["MSG_EMAIL_FOOTER"]."\r\nto: $from_name" ;
		}
		$message = preg_replace( "/&lt;/", "<", $message ) ; $message = preg_replace( "/&gt;/", ">", $message ) ;
		$error = "" ;
		$error = Util_Email_SendEmail( $vname, $vemail, $from_name, $from_email, $vsubject, $message, $extra ) ;

		if ( !$error )
			$json_data = "json_data = { \"status\": 1 };" ;
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"$error\" };" ;

		print "$json_data" ;
		exit ;
	}
	else if ( $action == "send_email_trans" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put_itr.php" ) ;

		// to process sending email in the function
		Chat_put_itr_Transcript( $dbh, $ces, 1, "null", "null", $deptid, $opid, "null", "null", 0, "null", $vname, $vemail, "null", "null", "null", "null", "null" ) ;
		$json_data = "json_data = { \"status\": 1 };" ;

		print "$json_data" ;
		exit ;
	}

	if ( is_file( "$CONF[TYPE_IO_DIR]/$ces.txt" ) ) { unlink( "$CONF[TYPE_IO_DIR]/$ces.txt" ) ; }
	$upload_dir = $CONF['CONF_ROOT'] ;

	$marquees = Marquee_get_DeptMarquees( $dbh, $deptid ) ;
	$marquee_string = "" ;
	for ( $c = 0; $c < count( $marquees ); ++$c )
	{
		$marquee = $marquees[$c] ;
		$snapshot = preg_replace( "/'/", "&#39;", preg_replace( "/\"/", "&quot;", $marquee["snapshot"] ) ) ;
		$message = preg_replace( "/'/", "&#39;", preg_replace( "/\"/", "", $marquee["message"] ) ) ;

		$marquee_string .= "marquees[$c] = '$snapshot' ; marquees_messages[$c] = '$message' ; " ;
	}
	if ( !count( $marquees ) )
		$marquee_string = "marquees[0] = '' ; marquees_messages[0] = '' ; " ;

	include_once( "$CONF[DOCUMENT_ROOT]/inc_cache.php" ) ;
?>
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
<title> <?php echo $LANG["CHAT_WELCOME"] ?> </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=<?php echo $LANG["CHARSET"] ?>">
<?php include_once( "./inc_meta_dev.php" ) ; ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

<link rel="Stylesheet" href="./themes/<?php echo $theme ?>/style.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="./js/global.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/global_chat.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/jquery_md5.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	var marquees = new Array(), marquees_messages = new Array() ;
	var marquee_index = 0 ;
	var mobile = <?php echo $mobile ?> ;
	var phplive_browser = navigator.appVersion ; var phplive_mime_types = "" ;
	if ( navigator.mimeTypes.length > 0 ) { for (var x=0; x < navigator.mimeTypes.length; x++) { phplive_mime_types += navigator.mimeTypes[x].description ; } }
	var phplive_browser_token = phplive_md5( phplive_browser+phplive_mime_types ) ;

	$(document).ready(function()
	{
		<?php echo $marquee_string ?>

		$("body").show() ;
		init_divs_pre() ;

		init_marquees() ;

		if ( typeof( parent.chat_connected ) != "undefined" )
		{
			parent.chat_connected = 0 ;
			parent.toggle_show_close( 1 ) ;
		}
	});
	$(window).resize(function() {
		if ( !mobile ) { init_divs_pre() ; }
	});

	function init_divs_pre()
	{
		var browser_height = $(window).height() ; var browser_width = $(window).width() ;
		var body_height = browser_height - $('#chat_footer').height() - 45 ;
		var body_width = browser_width - 42 ;
		var logo_width = body_width - 10 ;
		var deptid_width = logo_width + 5 ;
		var powered_bottom = $('#chat_footer').height( ) + 25 ;
		var input_width = Math.floor( logo_width/2 ) - 19 ;
		var subject_width = ( input_width * 2 ) + 35 ;

		$('#chat_logo').css({'width': logo_width}) ;
		$('#chat_body').css({'height': body_height, 'width': body_width}) ;
		$('#vdeptid').css({'width': deptid_width}) ;
		$('#vname').css({'width': input_width }) ;
		$('#vemail').css({'width': input_width }) ;
		$('#vsubject').css({'width': input_width }) ;
		$('#vquestion').css({'width': input_width }) ;
		$('#chat_text_powered').css({'bottom': powered_bottom}) ;
	}

	function do_submit()
	{
		if ( !$('#vname').val() )
		{
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_NAME"] ?>" ) ;
			return false ;
		}
		if ( !$('#vemail').val() )
		{
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_EMAIL"] ?>" ) ;
			return false ;
		}
		if ( !check_email( $('#vemail').val() ) )
		{
			do_alert( 0, "<?php echo $LANG["CHAT_JS_INVALID_EMAIL"] ?>" ) ;
			return false ;
		}
		if ( !$('#vsubject').val() )
		{
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_SUBJECT"] ?>" ) ;
			return false ;
		}
		if ( !$('#vquestion').val() )
		{
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_QUESTION"] ?>" ) ;
			return false ;
		}

		do_it() ;
	}

	function do_it()
	{
		var unique = unixtime() ;
		var vname = $('#vname').val() ;
		var vemail = $('#vemail').val() ;
		var vsubject = encodeURIComponent( $('#vsubject').val() ) ;
		var vquestion =  encodeURIComponent( $('#vquestion').val() ) ;
		var onpage =  encodeURIComponent( "<?php echo $onpage ?>" ).replace( /http/g, "hphp" ) ;

		$('#chat_button_start').attr( "disabled", true ) ;
		$.ajax({
		type: "POST",
		url: "./phplive_m.php",
		data: "action=send_email&deptid=<?php echo $deptid ?>&token="+phplive_browser_token+"&chat=<?php echo $chat ?>&vname="+vname+"&vemail="+vemail+"&vsubject="+vsubject+"&vquestion="+vquestion+"&onpage="+onpage+"&custom=<?php echo $custom ?>&unique="+unique,
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				$('#chat_button_start').attr( "disabled", false ) ;
				do_alert( 0, "Email did not send. [Error: "+err+"]" ) ;
				return false ;
			}

			if ( json_data.status )
			{
				do_alert( 1, "<?php echo $LANG["CHAT_JS_EMAIL_SENT"] ?>" ) ;
				$('#chat_button_start').attr( "disabled", true ) ;
				$('#chat_button_start').html( "<img src=\"./themes/<?php echo $theme ?>/alert_good.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\"> <?php echo $LANG["CHAT_JS_EMAIL_SENT"] ?>" ) ;
			}
			else
			{
				do_alert( 0, json_data.error ) ;
				$('#chat_button_start').attr( "disabled", false ) ;
				$('#chat_button_start').html( "<?php echo $LANG["CHAT_BTN_EMAIL"] ?>" ) ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Email did not send.  Please reload the page and try again." ) ;
		} });
	}

//-->
</script>
</head>
<body style="">

<div id="chat_canvas" style="min-height: 100%; width: 100%;"></div>
<div style="position: absolute; top: 2px; padding: 10px; z-Index: 2;">
	<div id="chat_body" style="padding: 10px;">

		<?php if ( !$embed ): ?><div id="chat_logo" style="padding-bottom: 15px;"><img src="<?php echo Util_Upload_GetLogo( "$CONF[UPLOAD_HTTP]", $deptid ) ?>" border=0></div><?php endif ; ?>
		<div id="chat_text_header" style="margin-top: 10px;"><?php echo $LANG["MSG_LEAVE_MESSAGE"] ?></div>
		<div id="chat_text_header_sub" style="margin-top: 5px;"><?php echo ( $chat && $deptinfo["msg_busy"] ) ? $deptinfo["msg_busy"] : $deptinfo["msg_offline"] ; ?></div>

		<form method="POST" action="phplive_m.php?submit" id="theform" accept-charset="<?php echo $LANG["CHARSET"] ?>">
		<input type="hidden" name="action" value="submit">
		<input type="hidden" name="deptid" id="deptid" value="<?php echo $deptid ?>">
		<input type="hidden" name="ces" value="<?php echo $ces ?>">
		<input type="hidden" name="onpage" value="<?php echo $onpage ?>">
		<div style="margin-top: 10px;">
			<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td style="padding-bottom: 10px;">
					<div style="margin-top: 5px;">
					<?php echo $LANG["TXT_NAME"] ?><br>
					<input type="input" class="input_text" id="vname" name="vname" maxlength="40" value="<?php echo ( $vname ) ? $vname : "" ; ?>" onKeyPress="return noquotestags(event)">
					</div>
				</td>
				<td style="padding-bottom: 10px;">
					<div style="margin-top: 5px; margin-left: 23px;">
					<?php echo $LANG["TXT_EMAIL"] ?><br>
					<input type="input" class="input_text" id="vemail" name="vemail" maxlength="160" value="<?php echo ( $vemail && ( $vemail != "null" ) ) ? $vemail : "" ; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td colspan=2 style="padding-bottom: 10px;">
					<div style="margin-top: 5px;">
					<?php echo $LANG["TXT_SUBJECT"] ?><br>
					<input type="input" class="input_text" id="vsubject" name="vsubject" maxlength="155" value="<?php echo ( $vsubject ) ? $vsubject : "" ; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<div style="margin-top: 5px;">
					<?php echo $LANG["TXT_MESSAGE"] ?><br>
					<textarea class="input_text" id="vquestion" name="vquestion" rows="4" wrap="virtual" style="resize: none;"><?php echo ( $vquestion ) ? preg_replace( "/&lt;br&gt;/i", "\r\n", $vquestion ) : "" ?></textarea>
					</div>
				</td>
				<td style="padding-bottom: 10px;">
					<div style="margin-top: 5px; margin-left: 23px;">
						&nbsp;<br>
						<div id="chat_btn" style="margin-top: 5px;"><button id="chat_button_start" type="button" class="input_button" style="<?php echo ( $mobile ) ? "" : "width: 150px; height: 45px; font-size: 14px; font-weight: bold;" ?> padding: 6px;" onClick="do_submit()"><?php echo $LANG["CHAT_BTN_EMAIL"] ?></button></div>
					</div>
				</td>
			</tr>
			</table>
		</div>
		</form>

	</div>
</div>

<div id="chat_text_powered" style="position: absolute; bottom: -1px; right: 35px; font-size: 10px; z-Index: 3;"><?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>&nbsp;<br><a href="http://www.phplivesupport.com/?plk=pi-5-ykq-m" target="_blank">PHP Live!</a> powered<?php endif ; ?></div>
<?php if ( !$mobile ): ?>
<div id="chat_footer" style="position: relative; width: 100%; margin-top: -28px; height: 28px; padding-top: 7px; padding-left: 15px; z-Index: 10;"></div>
<?php endif ; ?>

</body>
</html>
<?php
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
?>