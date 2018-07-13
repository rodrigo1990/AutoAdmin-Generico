var chat_http_error ;
var st_http ;

function add_text( theces, thetext )
{
	if ( ( thetext != "" ) && ( typeof( chats[theces] ) != "undefined" ) )
	{
		thetext = init_timestamps( thetext.nl2br() ) ;
		chats[theces]["trans"] += thetext ;

		if ( theces == ces )
		{
			$('#chat_body').append( thetext.emos() ) ;

			// on IE 8 (standard view) it's not remembering the srollTop... when any div takes focus away
			// scrolling goes back to ZERO... effects are minimal
			init_scrolling() ;
		}
	}
}

function add_text_prepare()
{
	if ( isop )
		thetext = $( "textarea#input_text" ).val().trimreturn().noreturns().tags().vars() ;
	else
		thetext = $( "textarea#input_text" ).val().trimreturn().noreturns().tags() ;

	thetext = autolink_it( thetext ) ;

	if ( ( thetext != "" ) && ( typeof( chats[ces] ) != "undefined" ) )
	{
		var cdiv ;
		var now = unixtime() ;

		if ( isop )
		{
			var height_input_text = $("textarea#input_text").height() ;
			if ( parseInt( height_input_text ) != 75 )
			{
				//$("#chat_input").css({'bottom': "auto"}) ; $('textarea#input_text').css({'height': 75}) ;
				//$('#chat_body').css({'height': height_chat_body}) ;
			}

			if ( chats[ces]["op2op"] )
			{
				if ( parseInt( chats[ces]["op2op"] ) == parseInt( isop ) )
					cdiv = "co" ;
				else
					cdiv = "cv" ;
			}
			else
				cdiv = "co" ;
		}
		else
			cdiv = "cv" ;

		thetext = "<"+cid+"><div class='"+cdiv+"'><span class='notranslate'><b>"+cname+"<timestamp_"+now+"_"+cdiv+">:</b></span> "+thetext+"</div></"+cid+">" ;

		st_http = setTimeout( function(){ $('#chat_processing').show() ; }, 5000 ) ;
		idle_reset( ces ) ; $('#idle_timer_notice').hide() ;
		add_text( ces, thetext ) ;
		http_text( thetext ) ;
	}

	$('button#input_btn').attr( "disabled", true ) ;
	$('textarea#input_text').val( "" ) ;

	if ( !mobile ) { $('textarea#input_text').focus() ; }
}

function http_text( thetext )
{
	var json_data = new Object ;
	var unique = unixtime() ;

	var thesalt = ( typeof( salt ) != "undefined" ) ? salt : "nosalt" ;

	if ( typeof( chats[ces] ) != "undefined" )
	{
		$.ajax({
		type: "POST",
		url: base_url+"/ajax/chat_submit.php",
		data: "requestid="+chats[ces]["requestid"]+"&t_vses="+chats[ces]["t_ses"]+"&isop="+isop+"&isop_="+isop_+"&isop__="+isop__+"&op2op="+chats[ces]["op2op"]+"&ces="+ces+"&text="+encodeURIComponent( thetext )+"&salt="+thesalt+"&unique="+unique,
		success: function(data){
			try {
				if ( chat_http_error ) { do_alert( 1, "Reconnect success!" ) ; chat_http_error = 0 ; }
				eval(data) ;
			} catch(err) {
				do_alert( 0, "Disconnected. Reconnecting..." ) ; chat_http_error = 1 ;
				setTimeout( function(){ http_text( thetext ) ; }, 6000 ) ;
				return false ;
			}
			if ( json_data.status ) {
				if( typeof( st_http ) != "undefined" ) { clearTimeout( st_http ) ; st_http = this.undefined ; }
				$('#chat_processing').hide() ;
				clearTimeout( st_typing ) ;
				st_typing = this.undefined ;
			}
			else { do_alert( 0, "Error sending message.  Please reload the page and try again." ) ; }
		},
		error:function (xhr, ajaxOptions, thrownError){
			// keep trying and don't track timeout so it processes all dropped requests
			setTimeout( function(){ http_text( thetext ) ; }, 6000 ) ;
		} });
	}
}

function input_text_listen( e )
{
	var key = e.keyCode ;
	var shift = e.shiftKey ;

	if ( !shift && ( ( key == 13 ) || ( key == 10 ) ) )
	{
		add_text_prepare() ;
	}
	else if ( ( key == 8 ) || ( key == 46 ) )
	{
		if ( $( "textarea#input_text" ).val() == "" )
			$( "button#input_btn" ).attr( "disabled", true ) ;
	}
	else if ( $( "textarea#input_text" ).val() == "" )
		$( "button#input_btn" ).attr( "disabled", true ) ;
	else
		$( "button#input_btn" ).attr( "disabled", false ) ;
}

function input_text_typing( e )
{
	input_focus() ;

	if ( $( "textarea#input_text" ).val() )
	{
		if ( typeof( st_typing ) == "undefined" )
		{
			send_istyping() ;
			st_typing = setTimeout( function(){ clear_istyping() ; }, 5000 ) ;
		}
	}
}

function init_typing()
{
	si_typing = setInterval(function(){
		if ( typeof( chats[ces] ) != "undefined" )
		{
			if ( chats[ces]["istyping"] )
				$('#chat_vistyping').show() ;
			else
				$('#chat_vistyping').hide() ;
		}
	}, 1500) ;
}

function init_idle( theces )
{
	if ( ( typeof( chats[theces] ) != "undefined" ) && ( typeof( chats[theces]["idle_counter"] ) != "undefined" ) && ( typeof( chats[theces]["idle_si"] ) == "undefined" ) && parseInt( chats[theces]["idle"] ) )
	{
		chats[theces]["idle_si"] = setInterval(function(){
			if ( typeof( chats[theces] ) != "undefined" )
			{
				if ( parseInt( chats[theces]["idle_counter_pause"] ) ) { idle_reset( theces ) ; }
				if ( parseInt( chats[theces]["idle_counter"] ) != -1 ) { ++chats[theces]["idle_counter"] ; }
				idle_check( theces, parseInt( chats[theces]["idle"] ) - 60 ) ;
			}
		}, 1000) ;
	}
}

function idle_check( theces, thecounter )
{
	if ( ( typeof( chats[theces] ) != "undefined" ) && chats[theces]["idle"] )
	{
		if ( parseInt( chats[theces]["idle_counter"] ) == parseInt( thecounter ) )
		{
			idle_alert( theces, 0 ) ;
		}
		else if ( parseInt( chats[theces]["idle_counter"] ) >= parseInt( chats[theces]["idle"] ) )
		{
			idle_disconnect( theces ) ;
		}
	}
}

function idle_alert( theces, theskip )
{
	if ( ( typeof( chats[theces] ) != "undefined" ) )
	{
		if ( !theskip )
		{
			if ( !chats[theces]["idle_alert"] )
			{
				chats[theces]["idle_alert"] = setInterval(function(){
					if ( ces == theces )
					{
						var idle_countdown = parseInt( chats[ces]["idle"] ) - parseInt( chats[ces]["idle_counter"] ) ;
						if ( ( idle_countdown > 0 ) && ( parseInt( chats[ces]["idle_counter"] ) != -1 ) ) { $('#idle_countdown').html( idle_countdown ) ; }
						else { $('#idle_countdown').html( "0" ) ; }
					}
				}, 1000) ;
			}

			if ( ces != theces ) { menu_blink( "green", theces ) ; }
			else { $('#idle_timer_notice').show() ; }

			if ( chats[theces]["status"] )
			{
				if ( chat_sound ) { play_sound( 0, "new_text", "new_text_"+sound_new_text ) ; }
				if ( !isop && embed )
				{
					if ( ( typeof( parent.win_minimized ) != "undefined" ) && parent.win_minimized ) { flash_console(0) ; }
				}
				title_blink_init() ;
			}
		}
		else
		{
			if ( parseInt( chats[theces]["idle_alert"] ) && ( parseInt( chats[theces]["idle_counter"] ) != -1 ) ) { $('#idle_timer_notice').show() ; }
			else { $('#idle_timer_notice').hide() ; }
		}
	}
}

function idle_reset( theces )
{
	if ( chats[theces]["idle_alert"] ) { clearInterval( chats[theces]["idle_alert"] ) ; }
	chats[theces]["idle_alert"] = 0 ;
	chats[theces]["idle_counter"] = 0 ;
}

function idle_disconnect( theces )
{
	chats[theces]["idle_counter"] = -1 ; // flag to indicate idle disconnect processed
	if ( typeof( chats[theces]["idle_si"] ) != "undefined" ) { clearInterval( chats[theces]["idle_si"] ) ; chats[theces]["idle_si"] = this.undefined ; }
	if ( typeof( chats[theces]["timer_si"] ) != "undefined" ) { clearInterval( chats[theces]["timer_si"] ) ; chats[theces]["timer_si"] = this.undefined ; }
	if ( isop )
	{
		add_text( theces, "<div class=\"cl\">Operator chat is idle.  Session automatically disconnected.</div>" ) ;
		disconnect(0, theces) ;
	} else { disconnect(1, theces) ; }
}

function send_istyping()
{
	var json_data = new Object ;
	var unique = unixtime() ;

	if ( typeof( chats[ces] ) != "undefined" )
	{
		$.ajax({
		type: "GET",
		url: base_url+"/ajax/chat_actions_istyping.php",
		data: "action=istyping&isop="+isop+"&isop_"+isop_+"&isop_="+isop_+"&ces="+ces+"&flag=1&unique="+unique,
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				do_alert( 0, err ) ;
				return false ;
			}

			if ( json_data.status ) {
				return true ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			// suppress error to limit confusion... if error here, there will be error reporting in more crucial areas
		} });
	}
}

function clear_istyping()
{
	var json_data = new Object ;
	var unique = unixtime() ;

	if ( typeof( chats[ces] ) != "undefined" )
	{
		$.ajax({
		type: "GET",
		url: base_url+"/ajax/chat_actions_istyping.php",
		data: "action=istyping&isop="+isop+"&isop_="+isop_+"&isop_="+isop_+"&ces="+ces+"&flag=0&unique="+unique,
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				do_alert( 0, err ) ;
				return false ;
			}
			
			if ( json_data.status ) {
				clearTimeout( st_typing ) ;
				st_typing = this.undefined ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			// suppress error to limit confusion... if error here, there will be error reporting in more crucial areas
		} });
	}
}

function init_scrolling()
{
	if ( ( typeof( chats[ces] ) != "undefined" ) && ( parseInt( chats[ces]["status"] ) != 2 ) && !widget )
		$('#chat_body').prop( "scrollTop", $('#chat_body').prop( "scrollHeight" ) ) ;
}

function init_textarea()
{
	if ( typeof( chats[ces] ) != "undefined" )
	{
		if ( ( parseInt( chats[ces]["status"] ) == 1 ) && !parseInt( chats[ces]["disconnected"] ) )
			$('textarea#input_text').attr("disabled", false) ;
		else if ( parseInt( chats[ces]["op2op"] ) && !parseInt( chats[ces]["disconnected"] ) )
			$('textarea#input_text').attr("disabled", false) ;
		else if ( parseInt( chats[ces]["initiated"] ) && !parseInt( chats[ces]["disconnected"] ) )
			$('textarea#input_text').attr("disabled", false) ;
		else
			$('textarea#input_text').val( "" ).attr("disabled", true) ;
	}
	else
		$('textarea#input_text').val( "" ).attr("disabled", true) ;
}

function init_divs( theresize )
{
	var chat_body_padding = $('#chat_body').css('padding-left') ;
	var chat_body_padding_diff = ( typeof( chat_body_padding ) != "undefined" ) ? 20 - ( chat_body_padding.replace( /px/, "" ) * 2 ) : 0 ;

	var browser_height = $(window).height() ; var browser_width = $(window).width() ;
	var body_height = ( ( typeof( isop ) != "undefined" ) && parseInt( isop ) ) ? browser_height - $('#chat_footer').height() - 152 : browser_height - $('#chat_footer').height() - 132 ;
	var body_width = ( ( typeof( isop ) != "undefined" ) && parseInt( isop ) ) ? browser_width - 450 : browser_width - 42 ;
	var chat_body_width = body_width + chat_body_padding_diff ;
	var chat_body_height = body_height + chat_body_padding_diff - $('#chat_options').outerHeight() ;
	var input_text_width = ( ( typeof( isop ) != "undefined" ) && parseInt( isop ) ) ? body_width + 17 : body_width - 100 ;
	var intro_top = ( ( typeof( isop ) != "undefined" ) && parseInt( isop ) ) ? 30 : 12 ; var intro_left = ( ( typeof( isop ) != "undefined" ) && parseInt( isop ) ) ? body_width + 40 : input_text_width + 30 ;
	var chat_btn_top, intro_width, intro_height ;
	var chat_btn_left = intro_left ;

	if ( widget ) { return true ; }
	else if ( ( typeof( isop ) != "undefined" ) && parseInt( isop ) )
	{
		extra_top = browser_height - $('#chat_footer').outerHeight() ; // css top val of footer
		intro_height = browser_height - 153 ; // tweak it depending on footer height
		chat_btn_top = intro_height + 40 ;
		chat_btn_left += 5 ;
		var chat_info_body_height = intro_height - ( $('#chat_info_header').height() + $('#chat_info_menu_list').height() ) - 24 ;
		var chat_panel_left = intro_left + $('#chat_btn').outerWidth() ;
		var chat_status_offline_left = chat_panel_left + $('#chat_cans').outerWidth() ;
		var chat_status_offline_top = intro_height - 55 ;
		var chat_data_height = intro_height ;
		var chat_extra_wrapper_height = browser_height - 90 ;
		var chat_info_network_height = chat_info_body_height - 55 ;

		$('#chat_body').css({'height': chat_body_height, 'width': chat_body_width}) ;
		$('#chat_data').css({'top': intro_top, 'left': intro_left, 'height': chat_data_height, 'width': 410}) ;
		$('#chat_info_body').css({'max-height': chat_info_body_height}) ;
		$('#chat_info_wrapper_network').css({'height': chat_info_network_height}) ;

		$('#chat_panel').css({'top': chat_btn_top, 'left': chat_panel_left}) ;
		$('#chat_status_offline').css({'top': chat_status_offline_top, 'left': chat_status_offline_left}) ;

		$('#chat_extra_wrapper').css({'height': chat_extra_wrapper_height}) ;
		$('#chat_extra_wrapper').hide() ;

		$("#chat_input").css({'bottom': "auto"}) ; $("textarea#input_text").css({'height': 75}) ;
		if ( theresize )
		{
			clearTimeout( st_resize ) ;
			st_resize = setTimeout( function(){ close_extra( extra ) ; }, 800 ) ;
		}
		else
			close_extra( extra ) ;
	}
	else
	{
		// only applies to op_trans_view.php
		if ( typeof( view ) != "undefined" )
		{
			if ( parseInt( view ) == 1 )
				chat_body_height -= 90 ; // lift it up so more stats show
			else
				chat_body_height += 50 ;
		}

		chat_body_height -= 25 ; // visitor chat header height
		$('#chat_body').css({'height': chat_body_height, 'width': chat_body_width}) ;

		if ( mobile )
			chat_btn_top = browser_height - 85 ;
		else
			chat_btn_top = browser_height - 115 ;

		//chat_body_width -= 117 ;
		//$('#chat_body').css({'height': chat_body_height, 'width': chat_body_width}) ;
		//$('#profile_pic').css({'top': 50, 'left': chat_btn_left}) ;
	}

	$('#input_text').css({'width': input_text_width}) ;
	$('#chat_btn').css({'top': chat_btn_top, 'left': chat_btn_left}) ;
}

function update_ces( thejson_data )
{
	var thisces = thejson_data["ces"] ;
	var orig_text = thejson_data["text"] ;
	var append_text = init_timestamps( thejson_data["text"] ) ;

	if ( ( typeof( chats[thisces] ) != "undefined" ) )
	{
		chats[thisces]["chatting"] = 1 ;
		chats[thisces]["trans"] += append_text ;

		// parse for flags before doing functions
		if ( ( append_text.indexOf("</top>") != -1 ) && !parseInt( isop ) )
		{
			var regex_trans = /<top>(.*?)</ ;
			var regex_trans_match = regex_trans.exec( append_text ) ;
			
			chats[ces]["oname"] = regex_trans_match[1] ;
			$('#chat_vname').empty().html( regex_trans_match[1] ) ;

			var regex_opid = /<!--opid:(.*?)-->/ ;
			var regex_opid_match = regex_opid.exec( append_text ) ;
			isop_ = regex_opid_match[1] ;
		}

		if ( thejson_data["text"].indexOf( "<disconnected>" ) != -1 )
		{
			chats[thisces]["disconnected"] = unixtime() ;
			if ( thisces == ces ) { $('#idle_timer_notice').hide() ; }
			if ( typeof( chats[thisces]["idle_si"] ) != "undefined" ) { clearInterval( chats[thisces]["idle_si"] ) ; chats[thisces]["idle_si"] = this.undefined ; }
			if ( isop ) { clearInterval( chats[thisces]["timer_si"] ) ; chats[thisces]["timer_si"] = this.undefined ; } else { document.getElementById('iframe_chat_engine').contentWindow.stopit(0) ; }
		}
		if ( ( thejson_data["text"].indexOf( "<restart_router>" ) != -1 ) && !isop )
		{
			chats[thisces]["status"] = 2 ;
			document.getElementById('iframe_chat_engine').contentWindow.routing() ;
		}
		if ( ( thejson_data["text"].indexOf( "<idle_start>" ) != -1 ) && parseInt( isop ) ) { init_idle( thisces ) ; }
		if ( ( thejson_data["text"].indexOf( "<idle_pause>" ) != -1 ) && !parseInt( isop ) && !parseInt( widget ) ) { chats[thisces]["idle_counter_pause"] = 1 ; }
		if ( ( thejson_data["text"].indexOf( "<idle_restart>" ) != -1 ) && !parseInt( isop ) && !parseInt( widget ) ) { chats[thisces]["idle_counter_pause"] = 0 ; }

		if ( ces == thisces )
		{
			$('#chat_body').append( append_text.emos() ) ;
			init_scrolling() ;
			init_textarea() ;
			$('#chat_vistyping').hide() ;

			if ( document.getElementById('iframe_chat_engine').contentWindow.stopped )
			{
				if ( typeof( parent.chat_disconnected ) != "undefined" )
					parent.chat_disconnected = 1 ;
				if ( thisces == ces ) { $('#idle_timer_notice').hide() ; }
				chat_survey() ;
			}
		}
		else { menu_blink( "green", thisces ) ; }

		var flash_console_on = 0 ;
		if ( isop )
		{
			var reg = RegExp( chats[thisces]["vname"]+": ", "g" ) ;
			if ( ( typeof( dn_enabled_response ) != "undefined" ) && dn_enabled_response && chats[thisces]["status"] )
			{
				if ( wp )
					window.external.wp_incoming_chat( thisces, "Response: " + chats[thisces]["vname"], orig_text.replace( /<(.*?)>/g, '' ).replace( reg, ' ' ).replace( /\s+/g, ' ' ) ) ;
				else
					dn_show( 'new_response', thisces, "Response: " + chats[thisces]["vname"], orig_text.replace( /<(.*?)>/g, '' ).replace( reg, ' ' ).replace( /\s+/g, ' ' ), 15000 ) ;
			}

			if ( console_blink_r ) { flash_console_on = 1 ; }
		}

		if ( chats[thisces]["status"] || chats[thisces]["initiated"] )
		{
			if ( chat_sound )
			{
				play_sound( 0, "new_text", "new_text_"+sound_new_text ) ;
			}
			if ( !isop && embed )
			{
				if ( ( typeof( parent.win_minimized ) != "undefined" ) && parent.win_minimized ) { flash_console_on = 1 ; }
			}
			title_blink_init() ;
		}
		
		if ( flash_console_on ) { flash_console(0) ; }
	}
}

function disconnect( theclick, theces, thevclick )
{
	if ( typeof( widget ) == "undefined" ) { widget = 0 ; }
	if ( typeof( theces ) == "undefined" ) { theces = ces ; }
	if ( typeof( thevclick ) == "undefined" ) { thevclick = 0 ; } vclick = thevclick ;
	if ( theclick )
	{
		document.getElementById('info_disconnect')._onclick= document.getElementById('info_disconnect').onclick ;
		$('#info_disconnect').prop( "onclick", null ).html('<img src="'+base_url+'/pics/loading_fb.gif" width="16" height="11" border="0" alt="">') ;
	}

	if ( ( theces == ces ) && isop ) { $('#idle_timer_notice').hide() ; }
	else if ( theces == ces ) { $('#chat_vistyping').hide() ; }
	if ( ( ( typeof( theces ) != "undefined" ) && ( typeof( chats[theces] ) != "undefined" ) ) || widget )
	{
		var json_data = new Object ;
		var unique = unixtime() ;

		// limit multiple clicks during internet lag
		if ( !chats[theces]["disconnect_click"] )
		{
			chats[theces]["disconnect_click"] = theclick ;

			$.ajax({
			type: "POST",
			url: base_url+"/ajax/chat_actions_disconnect.php",
			data: "action=disconnect&isop="+isop+"&isop_="+isop_+"&isop__="+isop__+"&ces="+theces+"&ip="+chats[theces]["ip"]+"&widget="+widget+"&t_vses="+chats[theces]["t_ses"]+"&idle="+chats[theces]["idle_counter"]+"&vclick="+thevclick+"&unique="+unique,
			success: function(data){
				try {
					eval(data) ;
				} catch(err) {
					do_alert( 0, "Error processing disconnect.  Please reload the page and try again." ) ;
					return false ;
				}

				if ( theclick ) { document.getElementById('info_disconnect').onclick= document.getElementById('info_disconnect')._onclick ; }
				if ( json_data.status )
				{
					if ( parseInt( isop ) && ( parseInt( chats[theces]["idle_counter"] ) == -1 ) && !theclick )
					{
						// automatic process the idle disconnect but don't close the chat unless clicked disconnect
						chats[theces]["disconnect_click"] = 0 ;
						chats[theces]["disconnected"] = unixtime() ;
						$('textarea#input_text').val( "" ).attr("disabled", true) ;
					}
					else
						cleanup_disconnect( json_data.ces ) ;
				}
				else { do_alert( 0, "Error processing disconnect.  Please reload the page and try again." ) ; }
			},
			error:function (xhr, ajaxOptions, thrownError){
				do_alert( 0, "Error processing disconnect.  Please reload the page and try again." ) ;
			} });
		}
	}
}

function init_disconnect()
{
	$('#info_disconnect').hover(
		function () {
			$(this).removeClass('info_disconnect').addClass('info_disconnect_hover') ;
		}, 
		function () {
			$(this).removeClass('info_disconnect_hover').addClass('info_disconnect') ;
		}
	);
}

function init_timer()
{
	if ( typeof( chats[ces] ) != "undefined" )
	{
		start_timer( chats[ces]["timer"] ) ;
		if ( ( ( parseInt( chats[ces]["status"] ) == 1 ) && !parseInt( chats[ces]["disconnected"] ) ) || ( parseInt( chats[ces]["initiated"] ) && !parseInt( chats[ces]["disconnected"] ) ) )
		{
			if ( typeof( chats[ces]["timer_si"] ) != "undefined" ) { clearInterval( chats[ces]["timer_si"] ) ; chats[ces]["timer_si"] = this.undefined ; }
			chats[ces]["timer_si"] = setInterval(function(){ if ( typeof( chats[ces] ) != "undefined" ) { start_timer( chats[ces]["timer"] ) ; } }, 1000) ;
		}
	}
}

function start_timer( thetimer )
{
	var diff ;
	if ( chats[ces]["disconnected"] )
		diff = chats[ces]["disconnected"] - thetimer ;
	else
		diff = unixtime() - thetimer ;

	var hours = Math.floor( diff/3600 ) ;
	var mins =  Math.floor( ( diff - ( hours * 3600 ) )/60 ) ;
	var secs = diff - ( hours * 3600 ) - ( mins * 60 ) ;

	var display = pad( mins, 2 )+":"+pad( secs, 2 ) ;
	if ( hours ) { display = pad( hours, 2 )+":"+display ; }

	if ( chats[ces]["status"] || chats[ces]["initiated"] )
		$('#chat_vtimer').empty().html( ""+display+"" ) ;
	else
		$('#chat_vtimer').empty() ;
}

function init_marquees()
{
	start_marquees() ;
	setInterval( "start_marquees()", 10000 ) ;
}

function start_marquees()
{
	if ( typeof( marquees_messages[marquee_index] ) != "undefined" )
	{
		$('#chat_footer').empty().html( "<div class=\"marquee\">"+parse_marquee(marquees_messages[marquee_index])+"</div>" ) ;
		++marquee_index ;
		if ( marquee_index >= marquees.length )
			marquee_index = 0 ;
	}
}

function chat_survey()
{
	if ( !chats[ces]["survey"] )
	{
		chats[ces]["survey"] = 1 ;

		var survey_text = ( chats[ces]["rate"] ) ? survey + survey_rate : survey ;
		add_text( ces, survey_text ) ;
	}
	window.onbeforeunload = null ;

	if ( !widget ) { $('#info_disconnect').hide() ; }
}

function submit_survey( theobject, thetexts )
{
	var json_data = new Object ;
	var unique = unixtime() ;

	if ( parseInt( chats[ces]["survey"] ) != 2 )
	{
		$.ajax({
		type: "POST",
		url: base_url+"/ajax/chat_actions_rating.php",
		data: "action=rating&requestid="+chats[ces]["requestid"]+"&ces="+ces+"&opid="+chats[ces]["opid"]+"&deptid="+chats[ces]["deptid"]+"&rating="+theobject.value+"&unique="+unique,
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				do_alert( 0, err ) ;
				return false ;
			}

			if ( json_data.status )
			{
				chats[ces]["survey"] = 2 ;
				do_alert( 1, thetexts[0] ) ;

				$("input[name='rating']").each(function(i) {
					$(this).attr('disabled', true) ;
				});
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			// suppress error to limit confusion... if error here, there will be error reporting in more crucial areas
		} });
	}
}

function do_print( theces, thedeptid, theopid, thewidth, theheight )
{
	var winname = "Print"+theces ;
	var deptid = ( typeof( chats[theces]["deptid"] ) != "undefined" ) ? parseInt( chats[theces]["deptid"] ) : parseInt( thedeptid ) ;
	var opid = ( typeof( chats[theces]["opid"] ) != "undefined" ) ? parseInt( chats[theces]["opid"] ) : parseInt( theopid ) ;

	var url = base_url_full+"/ops/op_print.php?ces="+theces+"&deptid="+deptid+"&opid="+theopid+"&"+unixtime() ;

	if ( !wp )
		newwin_print = window.open( url, winname, "scrollbars=yes,menubar=no,resizable=1,location=no,width="+thewidth+",height="+theheight+",status=0" ) ;
	else
	{
		if ( typeof( isop ) != "undefined" ) { wp_new_win( url, winname, thewidth, theheight ) ; }
		else { location.href = url ; }
	}
}

function init_timestamps( thetranscript )
{
	var lines = thetranscript.split( "<>" ) ;

	var transcript = "" ;
	for ( c = 0; c < lines.length; ++c )
	{
		var line = lines[c] ;
		var matches = line.match( /timestamp_(\d+)_/ ) ;
		
		var timestamp = "" ;
		if ( matches != null )
		{
			var time = extract_time( matches[1] ) ;
			timestamp = " (<span class='ct'>"+time+"</span>) " ;
			transcript += ( !widget ) ? line.replace( /<timestamp_(\d+)_((co)|(cv))>/, timestamp ) : line.replace( /<timestamp_(\d+)_((co)|(cv))>/, '' ) ;
		}
		else { transcript += line ; }
	}
	return transcript ;
}

function extract_time( theunixtime )
{
	var time_expanded = new Date( parseInt( theunixtime ) * 1000) ;
	var hours = time_expanded.getHours() ;
	if( hours >= 13 ) hours -= 12 ;
	var output = pad(hours,2)+":"+pad(time_expanded.getMinutes(), 2)+":"+pad(time_expanded.getSeconds(), 2) ;
	return output ;
}

function input_focus()
{
	focused = 1 ;
}

function play_sound( theloop, thediv, thesound )
{
	var unique = unixtime() ;

	if ( mp3_support )
	{
		var loop_string = ( theloop ) ? "loop='loop'" : "" ;
		$("#div_sounds_"+thediv).empty().html( "<audio "+loop_string+" autoplay='autoplay' id='div_sounds_audio_"+thediv+"'><source src='"+base_url+"/media/"+thesound+'.mp3'+"' /></audio>" ) ;
	}
	else
		flashembed( "div_sounds_"+thediv, base_url+'/media/'+thesound+'.swf' ) ;
}

function clear_sound( thediv )
{
	if ( mp3_support ) { $('#div_sounds_audio_'+thediv).trigger("pause") ; }
	$('#div_sounds_'+thediv).empty() ;
}

function title_blink_init()
{
	if ( ( typeof( title_orig ) != "undefined" ) && !parseInt( focused ) )
	{
		if ( typeof( si_title ) != "undefined" )
			clearInterval( si_title ) ;

		if ( ( typeof( embed ) != "undefined" ) && parseInt( embed ) ) {  }
		else { si_title = setInterval(function(){ title_blink( 1, title_orig, "Alert __________________ " ) ; }, 800) ; }
	}
}

function title_blink( theflag, theorig, thenew )
{
	if( !parseInt( focused ) && ( thenew != "reset" ) )
	{
		if ( ( si_counter % 2 ) && theflag ) { document.title = thenew ; }
		else { document.title = theorig ; }

		++si_counter ;
	}
	else
	{
		if ( typeof( si_title ) != "undefined" )
		{
			clearInterval( si_title ) ; si_title = this.undefined ;
			document.title = theorig ;
		}
	}
}

function print_chat_sound_image( thetheme )
{
	if ( chat_sound )
		$('#chat_sound').attr('src', base_url+'/themes/'+thetheme+'/sound_on.png') ;
	else
		$('#chat_sound').attr('src', base_url+'/themes/'+thetheme+'/sound_off.png') ;
}

function flash_console( thecounter )
{
	if ( !wp )
	{
		++thecounter ;
		if ( thecounter % 2 )
			$('#chat_canvas').addClass('chat_canvas_alert') ;
		else
			$('#chat_canvas').removeClass('chat_canvas_alert') ;

		if ( typeof( st_flash_console ) != "undefined" )
			clearTimeout( st_flash_console ) ;
		st_flash_console = setTimeout( function(){ flash_console( thecounter ) ; }, 1000 ) ;
	}
}

function clear_flash_console()
{
	$('#chat_canvas').removeClass('chat_canvas_alert') ;
	if ( typeof( st_flash_console ) != "undefined" )
	{
		clearTimeout( st_flash_console ) ;
		st_flash_console = this.undefined ;
	}
}

function close_misc()
{
	if ( isop )
	{
		clear_flash_console() ;
		//clear_sound( "new_request" ) ;
	}
	if ( typeof toggle_emo_box == 'function' ) { toggle_emo_box(1) ; }
}
