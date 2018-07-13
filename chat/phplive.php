<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	if ( !is_file( "./web/VERSION.php" ) ) { touch( "./web/VERSION.php" ) ; }  // patch 4.2.105 adjustment
	include_once( "./web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	/* AUTO PATCH */
	if ( !is_file( "$CONF[CONF_ROOT]/patches/$patch_v" ) )
	{
		$query = ( isset( $_SERVER["QUERY_STRING"] ) ) ? $_SERVER["QUERY_STRING"] : "" ;
		HEADER( "location: patch.php?from=chat&".$query ) ;
		exit ;
	}
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Marquee/get.php" ) ;

	$onpage = Util_Format_Sanatize( Util_Format_GetVar( "onpage" ), "url" ) ; $onpage = ( $onpage ) ? $onpage : "" ;
	$title = Util_Format_Sanatize( Util_Format_GetVar( "title" ), "title" ) ; $title = ( $title ) ? $title : "" ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "d" ), "n" ) ;
	$theme = Util_Format_Sanatize( Util_Format_GetVar( "theme" ), "ln" ) ;
	$embed = Util_Format_Sanatize( Util_Format_GetVar( "embed" ), "n" ) ;
	$popout = Util_Format_Sanatize( Util_Format_GetVar( "popout" ), "n" ) ;
	$js_name = Util_Format_Sanatize( Util_Format_GetVar( "js_name" ), "ln" ) ;
	$js_email = Util_Format_Sanatize( Util_Format_GetVar( "js_email" ), "e" ) ;
	$custom = Util_Format_Sanatize( Util_Format_GetVar( "custom" ), "ln" ) ;
	$token = Util_Format_Sanatize( Util_Format_GetVar( "token" ), "ln" ) ;
	$marquee_test = Util_Format_ConvertQuotes( Util_Format_Sanatize( Util_Format_GetVar( "marquee_test" ), "notags" ) ) ;
	$dept_themes = ( isset( $VALS["THEMES"] ) ) ? unserialize( $VALS["THEMES"] ) : Array() ;
	if ( !$theme && isset( $dept_themes[$deptid] ) && $deptid ) { $theme = $dept_themes[$deptid] ; }
	else if ( !$theme ) { $theme = $CONF["THEME"] ; }

	$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
	LIST( $ip, $vis_token ) = Util_IP_GetIP( $token ) ;
	LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
	$mobile = ( $os == 5 ) ? 1 : 0 ;
	$cookie = ( !isset( $CONF["cookie"] ) || ( $CONF["cookie"] == "on" ) ) ? 1 : 0 ;

	$temp_vname = ( !$js_name && ( isset( $_COOKIE["phplive_vname"] ) && $cookie ) ) ? Util_Format_Sanatize( $_COOKIE["phplive_vname"], "ln" ) : $js_name ;
	$temp_vemail = ( !$js_email && ( isset( $_COOKIE["phplive_vemail"] ) && ( $_COOKIE["phplive_vemail"] != "null" ) && $cookie ) ) ? Util_Format_Sanatize( $_COOKIE["phplive_vemail"], "e" ) : $js_email ;
	$vname = ( $temp_vname ) ? $temp_vname : "" ;
	$vemail = ( $temp_vemail ) ? $temp_vemail : "" ;
	$dept_offline = $dept_settings = $dept_customs = "" ;

	if ( preg_match( "/$ip/", $VALS["CHAT_SPAM_IPS"] ) ) { $spam_exist = 1 ; }
	else { $spam_exist = 0 ; }

	if ( is_file( "$CONF[TYPE_IO_DIR]/$vis_token.txt" ) )
		unlink( "$CONF[TYPE_IO_DIR]/$vis_token.txt" ) ;

	$requestinfo = Chat_get_itr_RequestIPInfo( $dbh, $ip, $vis_token ) ;
	if ( isset( $requestinfo["deptID"] ) )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;

		$deptid = $requestinfo["deptID"] ;
		// if popout, reset the agent_md5 so that it does not display the embed chat on page reloads
		if ( $popout ) { $embed = 0 ; Chat_update_RequestValueByCes( $dbh, $requestinfo["ces"], "md5_vis", "" ) ;  }

		HEADER( "location: phplive_.php?embed=$embed&popout=$popout&deptid=$deptid&token=$token&theme=$theme&ces=$requestinfo[ces]&vname=null&vquestion=null&onpage=".urlencode( Util_Format_URL( $requestinfo["onpage"] ) )."&".time() ) ;
		exit ;
	}
	else
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/remove.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/remove_itr.php" ) ;

		Footprints_remove_itr_Expired_U( $dbh ) ;
		Footprints_remove_ExpiredStats( $dbh ) ;
	}

	$widget = ( isset( $requestinfo["deptID"] ) ) ? 1 : 0 ;

	$total_ops = 0 ; $dept_online = Array() ; $departments = Array() ;
	if ( $deptid )
	{
		$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
		$departments[0] = $deptinfo ;
		if ( !isset( $deptinfo["deptID"] ) )
		{
			$query = $_SERVER["QUERY_STRING"] ;
			$query = preg_replace( "/(d=(.*?)(&|$))/", "d=0&", $query ) ;
			database_mysql_close( $dbh ) ;
			HEADER( "location: phplive.php?$query" ) ; exit ;
		}

		$total = ( $widget ) ? 1 : Ops_get_itr_AnyOpsOnline( $dbh, $deptinfo["deptID"] ) ;
		$total_ops += $total ;
		$dept_online[$deptinfo["deptID"]] = $total ;
		$dept_offline .= "dept_offline[$deptinfo[deptID]] = '".preg_replace( "/'/", "", preg_replace( "/\"/", "\"", $deptinfo["msg_offline"] ) )."' ; " ;
		$dept_settings .= " dept_settings[$deptinfo[deptID]] = Array( $deptinfo[remail], $deptinfo[temail], $deptinfo[rquestion] ) ; " ;
		$custom_fields = ( $deptinfo["custom"] ) ? unserialize( $deptinfo["custom"] ) : Array() ;
		if ( isset( $custom_fields[0] ) )
			$dept_customs .= " dept_customs[$deptinfo[deptID]] = Array( '$custom_fields[0]', $custom_fields[1] ) ;" ;
		
		if ( $deptinfo["lang"] ) { $CONF["lang"] = $deptinfo["lang"] ; }
	}
	else
	{
		$departments_pre = Depts_get_AllDepts( $dbh ) ;
		for ( $c = 0; $c < count( $departments_pre ); ++$c )
		{
			$department = $departments_pre[$c] ;
			if ( $department["visible"] ) { $departments[] = $department ; }
		}

		for ( $c = 0; $c < count( $departments ); ++$c )
		{
			$department = $departments[$c] ;
			if ( $spam_exist )
				$total = 0 ;
			else
				$total = Ops_get_itr_AnyOpsOnline( $dbh, $department["deptID"] ) ;
			$total_ops += $total ;

			$dept_online[$department["deptID"]] = $total ;
			$dept_offline .= "dept_offline[$department[deptID]] = '".preg_replace( "/'/", "", preg_replace( "/\"/", "\"", $department["msg_offline"] ) )."' ; " ;
			$dept_settings .= " dept_settings[$department[deptID]] = Array( $department[remail], $department[temail], $department[rquestion] ) ; " ;
			$custom_fields = ( $department["custom"] ) ? unserialize( $department["custom"] ) : Array( ) ;
			if ( isset( $custom_fields[0] ) )
				$dept_customs .= " dept_customs[$department[deptID]] = Array( '$custom_fields[0]', $custom_fields[1] ) ;" ;
		}

		if ( count( $departments ) == 1 )
			$deptid = $departments[0]["deptID"] ;
	}

	include_once( "$CONF[DOCUMENT_ROOT]/setup/KEY.php" ) ;
	$upload_dir = $CONF['CONF_ROOT'] ;

	if ( $marquee_test )
		$marquees = Array( Array( "snapshot" => "", "message" => "$marquee_test" ) ) ;
	else
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
		$$marquee_string = "marquees[0] = '' ; marquees_messages[0] = '' ; " ;

	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ;
	/////////////////////////////////////////////
	if ( defined( "LANG_CHAT_WELCOME" ) || !isset( $LANG["CHAT_JS_CUSTOM_BLANK"] ) )
		ErrorHandler( 611, "Update to your custom language file is required ($CONF[lang]).  Copy an existing language file and create a new custom language file.", $PHPLIVE_FULLURL, 0, Array( ) ) ;

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
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="Stylesheet" href="./themes/<?php echo $theme ?>/style.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="./js/global.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/global_chat.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/setup.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/jquery_md5.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="./js/jquery.tools.min.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	var marquees = marquees_messages = new Array( ) ;
	var marquee_index = 0 ;
	var widget = <?php echo $widget ?> ;
	var mobile = <?php echo $mobile ?> ;

	var win_width = screen.width ;
	var win_height = screen.height ;
	var input_width ;

	var dept_offline = new Object ;
	var dept_settings = new Object ;
	var dept_customs = new Object ;

	var onoff = 0 ;
	var custom_required = 0 ;
	var js_email = "<?php echo $js_email ?>" ;
	var phplive_browser = navigator.appVersion ; var phplive_mime_types = "" ;
	if ( navigator.mimeTypes.length > 0 ) { for (var x=0; x < navigator.mimeTypes.length; x++) { phplive_mime_types += navigator.mimeTypes[x].description ; } }
	var phplive_browser_token = phplive_md5( phplive_browser+phplive_mime_types ) ;

	$(document).ready(function( )
	{
		$('#win_dim').val( win_width + " x " + win_height ) ;

		<?php echo $dept_offline ?>
		<?php echo $dept_settings ?>
		<?php echo $dept_customs ?>
		<?php echo $marquee_string ?>

		init_divs_pre( ) ;
		init_marquees( ) ;

		<?php if ( $marquee_test ): ?>
		var pos = $('#chat_body').position() ; $('#marquee_cover').css({'top': pos.top, 'left': pos.left}).fadeTo( "fast" , 0.0 ) ;
		<?php endif ; ?>

		$('#chat_button_start').html( "<?php echo $LANG["CHAT_BTN_START_CHAT"] ?>" ).unbind('click').bind('click', function( ) {
			start_chat( ) ;
		}) ;

		var key_count = 0 ;
		for ( var key_ in dept_offline ) {
			key_count++ ;
		}
		if ( !key_count )
		{
			$('#pre_chat_form').hide( ) ;
			$('#pre_chat_no_depts').show( ) ;
		}

		select_dept( <?php echo $deptid ?> ) ;
		$('body').show( ) ; 

		<?php
			if ( !$deptid )
				print "$('#div_vdeptids').show( ) ; " ;
		?>
	});
	$(window).resize(function( ) {
		if ( !mobile ) { init_divs_pre( ) ; }
	});

	function init_divs_pre( )
	{
		var browser_height = $(window).height( ) ; var browser_width = $(window).width( ) ;
		var body_height = browser_height - $('#chat_footer').height( ) - 45 ;
		var body_width = browser_width - 42 ;
		var logo_width = body_width - 10 ;
		var deptid_width = body_width ;
		var powered_bottom = $('#chat_footer').height( ) + 25 ;
		input_width = Math.floor( body_width/2 ) - 24 ;

		$('#chat_body').css({'height': body_height, 'width': body_width}) ;
		$('#vdeptid').css({'width': deptid_width}) ;
		$('#vsubject').css({'width': input_width }) ;
		$('#vname').css({'width': input_width }) ;
		$('#vemail').css({'width': input_width }) ;
		$('#vemail_null').css({'width': input_width }) ;
		$('#custom_field_input_1').css({'width': input_width }) ;
		$('#chat_text_powered').css({'bottom': powered_bottom}) ;

		if ( mobile ) { $('#vquestion').css({'height': "45px" }) ; }
		else { $('#vquestion').css({'width': input_width }) ; }
	}

	function select_dept( thevalue )
	{
		$('#deptid').val( thevalue ) ;
		$('#custom_field_input_1').val('') ;

		if ( thevalue && ( typeof( dept_customs[thevalue] ) != "undefined" ) )
		{
			$('#custom_field_title').html( dept_customs[thevalue][0] ) ;
			$('#div_customs').show( ) ;
			custom_required = dept_customs[thevalue][1] ;
		}
		else
		{
			$('#div_customs').hide( ) ;
			custom_required = 0 ;
		}

		if ( ( $('#vdeptid option:selected').attr( "class" ) == "offline" ) )
		{
			onoff = 0 ;
			$('#chat_text_header_sub').html( dept_offline[thevalue] ) ;
			if ( parseInt( js_email ) ) { $('#vemail').val( js_email ).attr( "disabled", true ) ; }
			$('#div_subject').show( ) ; $('#div_question').show() ;
			$('#chat_button_start').html( "<?php echo $LANG["CHAT_BTN_EMAIL"] ?>" ).unbind('click').bind('click', function( ) {
				send_email( ) ;
			});
		}
		else
		{
			onoff = 1 ;
			$('#chat_text_header_sub').html( "<?php echo preg_replace( "/\"/", "&quot;", $LANG["CHAT_WELCOME_SUBTEXT"] ) ?>" ) ;
			if ( thevalue && ( typeof( dept_settings[thevalue] ) != "undefined" ) )
			{
				if ( dept_settings[thevalue][0] )
				{
					if ( parseInt( js_email ) ) { $('#vemail').val( js_email ).attr( "disabled", true ) ; }
				}
				if ( dept_settings[thevalue][2] ) { $('#div_question').show() ; }
				else { $('#div_question').hide() ; }
			}

			$('#div_subject').hide( ) ;
			if ( parseInt( thevalue ) )
			{
				$('#chat_button_start').html( "<?php echo $LANG["CHAT_BTN_START_CHAT"] ?>" ).unbind('click').bind('click', function( ) {
					start_chat( ) ;
				});
			}
			else
			{
				$('#chat_button_start').html( "<?php echo $LANG["TXT_SUBMIT"] ?>" ).attr( "disabled", false ).unbind('click').bind('click', function( ) {
					start_chat( ) ;
				});
			}
		}
	}

	function check_form( theflag )
	{
		var error = 0 ;

		if ( widget )
			return true ;

		var deptid = parseInt( $('#deptid').val( ) ) ;

		if ( !deptid ){
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_DEPT"] ?>" ) ;
			return false ;
		}
		if ( !$('#vsubject').val( ) ){
			if ( theflag )
			{
				do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_SUBJECT"] ?>" ) ;
				return false ;
			}
		}
		if ( !$('#vname').val( ) ){
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_NAME"] ?>" ) ;
			return false ;
		}
		if ( !$('#vemail').val( ) ){
			if ( dept_settings[deptid][0] || theflag )
			{
				do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_EMAIL"] ?>" ) ;
				return false ;
			}
		}
		if ( !$('#vquestion').val( ) ){
			if ( dept_settings[deptid][2] || theflag )
			{
				do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_QUESTION"] ?>" ) ;
				return false ;
			}
		}
		if ( !check_email( $('#vemail').val( ) ) ){
			if ( dept_settings[deptid][0] || theflag )
			{
				do_alert( 0, "<?php echo $LANG["CHAT_JS_INVALID_EMAIL"] ?>" ) ;
				return false ;
			}
		}
		if ( custom_required && !$('#custom_field_input_1').val( ) ){
			do_alert( 0, "<?php echo $LANG["CHAT_JS_CUSTOM_BLANK"] ?>"+" "+$('#custom_field_title').html( ) ) ;
			return false ;
		}

		return true ;
	}

	function start_chat( )
	{
		if ( check_form(0) )
		{
			var deptid = $('#deptid').val( ) ;
			var custom_field_value_1 = $('#custom_field_input_1').val( ) ;
			var custom_extra = ( typeof( dept_customs[deptid] ) != "undefined" ) ? encodeURIComponent( dept_customs[deptid][0] )+"-_-"+encodeURIComponent( custom_field_value_1 )+"-cus-" : "" ;
			var custom = "<?php echo $custom ?>" + custom_extra ;

			$('#token').val( phplive_browser_token ) ;
			$('#custom').val( custom ) ;

			<?php if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/inc_lang.php" ) ): ?>
			$('#pre_chat_form').hide( ) ;
			$('#pre_chat_lang').show( ) ;
			<?php else: ?>
			
			if ( <?php echo ( !isset( $requestinfo["requestID"] ) ) ? 1 : 0 ; ?> && <?php echo $embed ?> && ( typeof( parent.chat_connected ) != "undefined" ) )
			{
				parent.start_chat( 0, deptid, "" ) ;
				// delay of a second so it doesn't flicker "Connecting.." when loading too fast
				setTimeout( function(){ $('#chat_button_start').attr( "disabled", true ).html( "<?php echo $LANG["TXT_CONNECTING"] ?>" ) ; }, 1000 ) ;
				// delay of few seconds before re-enable button to try again
				setTimeout( function(){ $('#chat_button_start').attr( "disabled", false ).html( "<?php echo $LANG["CHAT_BTN_START_CHAT"] ?>" ) ; }, 6000 ) ;
			}
			else if ( <?php echo ( isset( $requestinfo["requestID"] ) ) ? 1 : 0 ; ?> && <?php echo $embed ?> ) { parent.start_chat( 1, "<?php $requestinfo["deptID"] ?>", "<?php echo $requestinfo["ces"] ?>" ) ; }
			else { $('#theform').submit( ) ; }

			<?php endif ; ?>
		}
	}

	function send_email( )
	{
		if( check_form(1) )
		{
			var json_data = new Object ;
			var unique = unixtime( ) ;
			var deptid = $('#deptid').val( ) ;
			var vname = $('#vname').val( ) ;
			var vemail = $('#vemail').val( ) ;
			var vsubject = encodeURIComponent( $('#vsubject').val( ) ) ;
			var vquestion = encodeURIComponent( $('#vquestion').val( ) ) ;
			var onpage = encodeURIComponent( "<?php echo $onpage ?>" ).replace( /http/g, "hphp" ) ;
			var custom_field_value_1 = $('#custom_field_input_1').val( ) ;
			var custom_extra = ( ( typeof( dept_customs[deptid] ) != "undefined" ) && custom_field_value_1 ) ? encodeURIComponent( dept_customs[deptid][0] )+"-_-"+encodeURIComponent( custom_field_value_1 )+"-cus-" : "" ;
			var custom = "<?php echo $custom ?>" + custom_extra ;

			$('#chat_button_start').attr( "disabled", true ) ;
			$.ajax({
			type: "POST",
			url: "./phplive_m.php",
			data: "action=send_email&deptid="+deptid+"&token="+phplive_browser_token+"&vname="+vname+"&vemail="+vemail+"&custom="+custom+"&vsubject="+vsubject+"&vquestion="+vquestion+"&onpage="+onpage+"&unique="+unique,
			success: function(jdata){
				eval( jdata ) ;

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
				do_alert( 0, "Error sending email.  Please reload the page and try again." ) ;
			} });
		}
	}

//-->
</script>
</head>
<body style="display: none; overflow: hidden;">
<div id="chat_canvas" style="min-height: 100%; width: 100%;"></div>
<div style="position: absolute; top: 2px; padding: 10px; z-Index: 2;">
	<div id="chat_body" style="padding: 10px;">

		<?php if ( !$embed ): ?><div id="chat_logo" style="padding-bottom: 15px;"><img src="<?php echo Util_Upload_GetLogo( "$CONF[UPLOAD_HTTP]", $deptid ) ?>" border=0></div><?php endif ; ?>
		<div id="chat_text_header" style=""><?php echo $LANG["CHAT_WELCOME"] ?></div>
		<div id="chat_text_header_sub" style="margin-top: 5px;"><?php echo $LANG["CHAT_WELCOME_SUBTEXT"] ?></div>

		<form method="POST" action="phplive_.php?submit&<?php echo time( ) ?>" id="theform" accept-charset="<?php echo $LANG["CHARSET"] ?>">
		<input type="hidden" name="deptid" id="deptid" value="<?php echo ( isset( $requestinfo["deptID"] ) ) ? $requestinfo["deptID"] : $deptid ; ?>">
		<input type="hidden" name="ces" id="ces" value="<?php echo ( isset( $requestinfo["ces"] ) ) ? $requestinfo["ces"] : "" ; ?>">
		<input type="hidden" name="onpage" id="onpage" value="<?php echo ( isset( $requestinfo["ces"] ) ) ? Util_Format_URL( $requestinfo["onpage"] ) : Util_Format_URL( $onpage ) ; ?>">
		<input type="hidden" name="title" id="title" value="<?php echo ( isset( $requestinfo["ces"] ) ) ? $requestinfo["title"] : htmlentities( $title ) ; ?>">
		<input type="hidden" name="win_dim" id="win_dim" value="">
		<input type="hidden" name="token" id="token" value="">
		<input type="hidden" name="widget" id="widget" value="<?php echo $widget ?>">
		<input type="hidden" name="embed" id="embed" value="<?php echo $embed ?>">
		<input type="hidden" name="theme" id="theme" value="<?php echo $theme ?>">
		<input type="hidden" name="popout" id="popout" value="<?php echo $popout ?>">
		<input type="hidden" name="custom" id="custom" value="<?php echo $custom ?>">

		<?php if ( $js_name || $js_email ): ?><input type="hidden" id="auto_pop" name="auto_pop" value="1"><?php endif ; ?>
		<?php if ( $js_name ): ?><input type="hidden" name="vname" value="<?php echo $vname ?>"><?php endif ; ?>
		<?php if ( $js_email ): ?><input type="hidden" name="vemail" value="<?php echo $vemail ?>"><?php endif ; ?>
		<div id="pre_chat_form" style="margin-top: 15px;">
			<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td style="" colspan=2>
					<div id="div_vdeptids" style="display: none; padding-bottom: 10px;">
						<?php echo $LANG["TXT_DEPARTMENT"] ?><br>
						<select id="vdeptid" onChange="select_dept(this.value)"><option value=0><?php echo $LANG["CHAT_SELECT_DEPT"] ?></option>
						<?php
							$selected = "" ;
							for ( $c = 0; $c < count( $departments ); ++$c )
							{
								$department = $departments[$c] ;
								$class = "offline" ; $text = $LANG["TXT_OFFLINE"] ;
								if ( $dept_online[$department["deptID"]] ) { $class = "online" ; $text = $LANG["TXT_ONLINE"] ; }
								if ( count( $departments ) == 1 ) { $selected = "selected" ; }
								print "<option class=\"$class\" value=\"$department[deptID]\" $selected>$department[name] - $text</option>" ;
							}
						?>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom: 10px;">
					<div style="margin-top: 5px;">
						<?php echo $LANG["TXT_NAME"] ?><br>
						<input type="input" class="input_text" id="vname" name="vname" maxlength="30" value="<?php echo isset( $requestinfo["vname"] ) ? $requestinfo["vname"] : $vname ; ?>" onKeyPress="return noquotestags(event)" <?php echo ( $js_name ) ? "disabled" : "" ?>>
					</div>
				</td>
				<td style="padding-bottom: 10px;">
					<div style="margin-top: 5px; margin-left: 23px;">
						<?php echo $LANG["TXT_EMAIL"] ?><br>
						<input type="input" class="input_text" id="vemail" name="vemail" maxlength="160" value="<?php echo isset( $requestinfo["vemail"] ) ? $requestinfo["vemail"] : $vemail ; ?>" onKeyPress="return justemails(event)" <?php echo ( $js_email ) ? "disabled" : "" ?>>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" style="padding-bottom: 10px;">
					<div id="div_customs" style="display: none;">
						<span id="custom_field_title"></span><br>
						<input type="input" class="input_text" id="custom_field_input_1" name="custom_field_input_1" maxlength="30" onKeyPress="return noquotestags(event)">
					</div>

					<div id="div_subject" style="display: none; margin-top: 10px;">
						<?php echo $LANG["TXT_SUBJECT"] ?><br>
						<input type="input" class="input_text" id="vsubject" name="vsubject" maxlength="125" onKeyPress="return noquotestags(event)">
					</div>

					<div id="div_question" style="display: none; margin-top: 10px;">
						<?php echo $LANG["TXT_QUESTION"] ?><br>
						<textarea class="input_text" id="vquestion" name="vquestion" rows="3" wrap="virtual" style="resize: vertical; resize: none;"><?php echo isset( $requestinfo["question"] ) ? $requestinfo["question"] : "" ; ?></textarea>
					</div>
				</td>
				<td style="padding-bottom: 10px;">
					<div id="chat_btn" style="margin-top: 5px; margin-left: 23px;">
						<div style="">
							<button id="chat_button_start" class="input_button" type="button" style="<?php echo ( $mobile ) ? "" : "width: 150px; height: 45px; font-size: 14px; font-weight: bold;" ?> padding: 6px;"><?php echo $LANG["CHAT_BTN_START_CHAT"] ?></button>
						</div>
					</div>
				</td>
			</tr>
		</table>
		</div>

		<div id="pre_chat_no_depts" style="display: none; margin-top: 10px;">
			<img src="./themes/<?php echo $theme ?>/alert.png" width="12" height="12" border="0" alt=""> There are no visible live chat departments available at this time.  Please try back later as this may be temporary.  If you are the live chat setup admin, enable at least one department to be visible for selection.
		</div>
		</form>

	</div>
</div>

<div id="chat_text_powered" style="position: absolute; bottom: -1px; right: 35px; font-size: 10px; z-Index: 3;"><?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>&nbsp;<br><a href="http://www.phplivesupport.com/?plk=pi-5-ykq-m" target="_blank">PHP Live!</a> powered<?php endif ; ?></div>
<div id="marquee_cover" style="display: none; position: absolute; width: 100%; height: 90%; background: url( pics/bg_trans_white.png ) repeat; cursor: pointer; z-Index: 11;" onClick="parent.close_view()">&nbsp;</div>

<?php if ( !$mobile ): ?>
<div id="chat_footer" style="position: relative; width: 100%; margin-top: -28px; height: 28px; padding-top: 7px; padding-left: 15px; z-Index: 10;"></div>
<?php endif ; ?>

</body>
</html>
<?php
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
?>
