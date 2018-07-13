function add_text( thetext )
{
	if ( ( thetext != "" ) && ( typeof( chats[ces] ) != "undefined" ) )
	{
		thetext = init_timestamps( thetext.nl2br() ) ;
		chats[ces]["trans"] += thetext ;
		$('#chat_body').append( thetext ) ;

		// on IE 8 (standard view) it's not remembering the srollTop... when any div takes focus away
		// scrolling goes back to ZERO... effects are minimal
		init_scrolling() ;
	}
}

function add_text_prepare()
{
	if ( isop )
		thetext = $( "textarea#input_text" ).val().trimreturn().noreturns().tags().vars() ;
	else
	{
		thetext = $( "textarea#input_text" ).val().trimreturn().noreturns().tags() ;
		thetext = thetext.autoLink({ target: "new" }) ;
	}

	if ( ( thetext != "" ) && ( typeof( chats[ces] ) != "undefined" ) )
	{
		var cdiv ;
		var now = unixtime() ;

		if ( isop )
		{
			if ( chats[ces]["op2op"] )
			{
				if ( chats[ces]["op2op"] == isop )
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

		$('#chat_processing').html( "<img src=\""+base_url+"/themes/"+theme+"/loading_chat.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"\">" ) ;
		add_text( thetext ) ;
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
			eval( data ) ;
			if ( json_data.status ) {
				$('#chat_processing').html( "<img src=\""+base_url+"/pics/space.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"\">" ) ;
				clearTimeout( st_typing ) ;
				st_typing = this.undefined ;
			}
			else { do_alert( 0, "Error sending message.  Please reload the page and try again." ) ; }
		},
		error:function (xhr, ajaxOptions, thrownError){
			// keep trying and don't track timeout so it processes all dropped requests
			setTimeout( function(){ http_text( thetext ) ; }, 5000 ) ;
		} });
	}
}

function input_text_listen( e )
{
	var key = -1 ;
	var shift ;

	key = e.keyCode ;
	shift = e.shiftKey ;

	if ( !shift && ( ( key == 13 ) || ( key == 10 ) ) )
		add_text_prepare() ;
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
				$('#chat_vistyping').empty().html( " is typing..." ) ;
			else
				$('#chat_vistyping').empty().html( "" ) ;
		}
	}, 1500) ;
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
			eval( data ) ;

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
			eval( data ) ;
			
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
	if ( ( typeof( chats[ces] ) != "undefined" ) && ( chats[ces]["status"] != 2 ) && !widget )
		$('#chat_body').prop( "scrollTop", $('#chat_body').prop( "scrollHeight" ) ) ;
}

function init_textarea()
{
	if ( typeof( chats[ces] ) != "undefined" )
	{
		if ( ( chats[ces]["status"] == 1 ) && !chats[ces]["disconnected"] )
			$('textarea#input_text').attr("disabled", false) ;
		else if ( chats[ces]["op2op"] && !chats[ces]["disconnected"] )
			$('textarea#input_text').attr("disabled", false) ;
		else if ( chats[ces]["initiated"] && !chats[ces]["disconnected"] )
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
	var body_height = ( ( typeof( isop ) != "undefined" ) && isop ) ? browser_height - $('#chat_footer').height() - 152 : browser_height - $('#chat_footer').height() - 132 ;
	var body_width = ( ( typeof( isop ) != "undefined" ) && isop ) ? browser_width - 450 : browser_width - 42 ;
	var chat_body_width = body_width + chat_body_padding_diff ;
	var chat_body_height = body_height + chat_body_padding_diff - $('#chat_options').outerHeight() ;
	var input_text_width = ( ( typeof( isop ) != "undefined" ) && isop ) ? body_width + 17 : body_width - 100 ;
	var intro_top = ( ( typeof( isop ) != "undefined" ) && isop ) ? 30 : 12 ; var intro_left = ( ( typeof( isop ) != "undefined" ) && isop ) ? body_width + 40 : input_text_width + 30 ;
	var chat_btn_top, intro_width, intro_height ;
	var chat_btn_left = intro_left ;

	if ( widget ) { return true ; }
	else if ( ( typeof( isop ) != "undefined" ) && isop )
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
			if ( view == 1 )
				chat_body_height -= 90 ; // lift it up so more stats show
			else
				chat_body_height += 50 ;
		}
		else if ( widget )
			chat_body_height += 20 ;

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
	var append_text = init_timestamps( thejson_data["text"] ) ;

	if ( ( typeof( chats[thisces] ) != "undefined" ) )
	{
		chats[thisces]["chatting"] = 1 ;
		chats[thisces]["trans"] += append_text ;

		// parse for flags before doing functions
		if ( ( append_text.indexOf("</top>") != -1 ) && !isop )
		{
			var regex_trans = /<top>(.*?)</ ;
			var regex_trans_match = regex_trans.exec( append_text ) ;
			
			chats[ces]["oname"] = regex_trans_match[1] ;
			$('#chat_vname').empty().html( regex_trans_match[1] ) ;

			var regex_opid = /<!--opid:(.*?)-->/ ;
			var regex_opid_match = regex_opid.exec( append_text ) ;
			isop_ = regex_opid_match[1] ;
		}

		if ( ( thejson_data["text"].indexOf( "<disconnected>" ) != -1 ) )
		{
			chats[thisces]["disconnected"] = unixtime() ;
			if ( isop ) { clearInterval( si_timer ) ; si_timer = this.undefined ; } else { document.getElementById('iframe_chat_engine').contentWindow.stopit(0) ; }
		}
		if ( ( thejson_data["text"].indexOf( "<restart_router>" ) != -1 ) && !isop )
		{
			chats[thisces]["status"] = 2 ;
			document.getElementById('iframe_chat_engine').contentWindow.routing() ;
		}

		if ( ces == thisces )
		{
			$('#chat_body').append( append_text ) ;
			init_scrolling() ;
			init_textarea() ;
			$('#chat_vistyping').empty().html( "" ) ;

			if ( document.getElementById('iframe_chat_engine').contentWindow.stopped )
			{
				if ( typeof( parent.chat_disconnected ) != "undefined" )
					parent.chat_disconnected = 1 ;
				chat_survey() ;
			}
		}
		else
			menu_blink( "green", thisces ) ;

		if ( chats[thisces]["status"] || chats[thisces]["initiated"] )
		{
			if ( chat_sound )
				play_sound( "new_text", "new_text_"+sound_new_text ) ;
			if ( !isop && embed )
			{
				if ( ( typeof( parent.win_minimized ) != "undefined" ) && parent.win_minimized ) { flash_console(0) ; }
			}
			title_blink_init() ;
		}
	}
}

function disconnect()
{
	if ( typeof( widget ) == "undefined" )
		widget = 0 ;

	if ( ( ( typeof( ces ) != "undefined" ) && ( typeof( chats[ces] ) != "undefined" ) ) || widget )
	{
		var json_data = new Object ;
		var unique = unixtime() ;

		$.ajax({
		type: "GET",
		url: base_url+"/ajax/chat_actions_disconnect.php",
		data: "action=disconnect&isop="+isop+"&isop_="+isop_+"&isop__="+isop__+"&ces="+ces+"&ip="+chats[ces]["ip"]+"&widget="+widget+"&t_vses="+chats[ces]["t_ses"]+"&unique="+unique,
		success: function(data){
			eval( data ) ;

			if ( json_data.status )
				cleanup_disconnect( json_data.ces ) ;
			else { do_alert( 0, "Error processing disconnect.  Please reload the page and try again." ) ; }
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Error processing disconnect.  Please reload the page and try again." ) ;
		} });
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
	start_timer( chats[ces]["timer"] ) ;
	if ( typeof( chats[ces] ) != "undefined" )
	{
		if ( ( ( chats[ces]["status"] == 1 ) && !chats[ces]["disconnected"] ) || ( chats[ces]["initiated"] && !chats[ces]["disconnected"] ) )
		{
			if ( typeof( si_timer ) != "undefined" )
				clearInterval( si_timer ) ;
			
			si_timer = setInterval(function(){ if ( typeof( chats[ces] ) != "undefined" ) { start_timer( chats[ces]["timer"] ) ; } }, 1000) ;
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

	var display = pad( hours, 2 )+":"+pad( mins, 2 )+":"+pad( secs, 2 ) ;

	if ( chats[ces]["status"] || chats[ces]["initiated"] )
		$('#chat_vtimer').empty().html( "["+display+"]" ) ;
	else
		$('#chat_vtimer').empty().html( "" ) ;
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
	if ( !chats[ces]["survey"] && chats[ces]["vsurvey"] )
	{
		chats[ces]["survey"] = 1 ;
		add_text( survey ) ;
	}
	window.onbeforeunload = null ;

	if ( !widget ) { $('#info_disconnect').hide() ; }
}

function submit_survey( theobject, thetexts )
{
	var json_data = new Object ;
	var unique = unixtime() ;

	if ( chats[ces]["survey"] != 2 )
	{
		$.ajax({
		type: "POST",
		url: base_url+"/ajax/chat_actions_rating.php",
		data: "action=rating&requestid="+chats[ces]["requestid"]+"&ces="+ces+"&opid="+chats[ces]["opid"]+"&deptid="+chats[ces]["deptid"]+"&rating="+theobject.value+"&unique="+unique,
		success: function(data){
			eval( data ) ;

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
	var deptid = ( typeof( chats[theces]["deptid"] ) != "undefined" ) ? chats[theces]["deptid"] : thedeptid ;
	var opid = ( typeof( chats[theces]["opid"] ) != "undefined" ) ? chats[theces]["opid"] : theopid ;

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

function play_sound( thediv, thesound )
{
	var unique = unixtime() ;

	flashembed( "div_sounds_"+thediv, base_url+'/media/'+thesound+'.swf' ) ;
}

function clear_sound( thediv )
{
	$('#div_sounds_'+thediv).empty().html( "" ) ;
}

function title_blink_init()
{
	if ( ( typeof( title_orig ) != "undefined" ) && !focused )
	{
		if ( typeof( si_title ) != "undefined" )
			clearInterval( si_title ) ;

		if ( ( typeof( embed ) != "undefined" ) && embed ) {  }
		else { si_title = setInterval(function(){ title_blink( 1, title_orig, "Alert __________________ " ) ; }, 800) ; }
	}
}

function title_blink( theflag, theorig, thenew )
{
	if( !focused && ( thenew != "reset" ) )
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

function toggle_chat_sound( thetheme )
{
	if ( chat_sound )
	{
		chat_sound = 0 ;
		if ( isop && !wp )
			do_alert( 1, "For new chat requests, the operator console will now blink." ) ;
	}
	else
		chat_sound = 1 ;

	print_chat_sound_image( thetheme ) ;
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
