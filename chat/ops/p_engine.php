<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;

	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;
	$t = Util_Format_Sanatize( Util_Format_GetVar( "t" ), "ln" ) ;
	$charset = Util_Format_Sanatize( Util_Format_GetVar( "charset" ), "ln" ) ;
	if ( !$charset ) { $charset = "UTF-8" ; }

	include_once( "../inc_cache.php" ) ;
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> [ chat engine ] </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=<?php echo $charset ?>"> 
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../themes/default/style.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/global_chat.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	var debug = 0 ; var on = 1 ; var dev_run = 0 ;
	var isop = parent.isop ; var isop_ ; var isop__ ;
	var ces = "<?php echo $ces ?>" ;
	var stopped = 0 ;
	var reconnect = 0 ;
	var rloop = parent.rloop ;
	var loop = 1 ;

	var c_routing = c_chatting = c_requesting = 0 ;
	var st_routing, st_chatting, st_requesting, st_init_chatting, st_network, st_connect, st_reconnect ;

	$(document).ready(function()
	{
		$.ajaxSetup({ cache: false }) ;

		if ( on )
		{
			if ( debug && isop )
			{
				$('#log').show() ;
				$('#debug_menu', parent.document ).show() ;
			}
			if ( isop )
				st_requesting = setTimeout( "requesting()", 2000 ) ; // slight delay to let parent load
			else if ( !parent.widget )
				st_routing = setTimeout( "routing()" , 1000 ) ; // take out timeout on live
		
			init_chatting() ;
		}
	});

	function init_chatting()
	{
		if ( !parent.loaded )
			st_init_chatting = setTimeout(function(){ init_chatting() }, 300) ;
		else
		{
			if ( typeof( st_init_chatting ) != "undefined" )
				clearTimeout( st_init_chatting ) ;

			// only start chatting() if not operator... operators are started with requesting()
			if ( !isop )
				chatting() ;
		}
	}

	function routing()
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		$.ajax({
		type: "GET",
		url: "../ajax/chat_routing.php",
		data: "&action=routing&ces="+ces+"&deptid="+parent.deptid+"&rtype="+parent.rtype+"&rtime="+parent.rtime+"&c_routing="+c_routing+"&rloop="+rloop+"&loop="+loop+"&"+unique,
		success: function(data){
			eval( data ) ;

			if ( typeof( st_routing ) != "undefined" )
			{
				clearTimeout( st_routing ) ;
				st_routing = this.undefined ;
			}

			if ( json_data.status == 1 )
				parent.init_connect( json_data ) ;
			else if ( json_data.status == 2 )
			{
				// routed to new operator
				if ( typeof( json_data.reset ) != "undefined" )
					++loop ;

				++c_routing ;
				st_routing = setTimeout( "routing()" , <?php echo $VARS_JS_ROUTING ?> * 1000 ) ;
			}
			else if ( json_data.status == 10 )
			{
				stopit(0) ;
				parent.leave_a_mesg() ;
			}
			else if ( json_data.status == 0 )
			{
				++c_routing ;
				st_routing = setTimeout( "routing()" , <?php echo $VARS_JS_ROUTING ?> * 1000 ) ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			if ( typeof( st_routing ) != "undefined" )
			{
				clearTimeout( st_routing ) ;
				st_routing = this.undefined ;
			}
			st_routing = setTimeout( "routing()" , <?php echo $VARS_JS_ROUTING ?> * 1000 ) ;
		} });
	}

	function requesting()
	{
		var start = microtime( true ) ;
		var unique = unixtime() ;
		var json_data = new Object ;
		var q_ces = "" ;

		if ( typeof( st_network ) != "undefined" )
		{
			clearTimeout( st_network ) ;
			st_network = this.undefined ;
		}
		if ( typeof( st_requesting ) != "undefined" )
		{
			clearTimeout( st_requesting ) ;
			st_requesting = this.undefined ;
		}

		for ( var ces in parent.chats )
		{
			q_ces += "q_ces[]="+ces+"&" ;
		}

		// add more seconds to give it some buffer
		st_network = setTimeout( function(){ stopit(0) ; parent.check_network( 715, this.undefined, this.undefined ) }, <?php echo $VARS_JS_OP_CONSOLE_TIMEOUT ?> * 1000 ) ;

		$.ajax({
		type: "GET",
		url: "../ajax/chat_requesting.php",
		data: "action=requests&prev_status="+parent.prev_status+"&traffic="+parent.traffic+"&c_requesting="+c_requesting+"&"+q_ces+"&"+unique,
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				// most likely internet disconnect or server response error will cause console to disconnect automatically
				// suppress error and let the console autoreconnect
				return false ;
			}

			if ( !stopped || ( stopped && reconnect ) )
			{
				stopped = 0 ; // reset it for disconnect situation
				reconnect = 0 ;
				clearTimeout( st_network ) ; st_network = this.undefined ;
				parent.reconnect_success() ;

				// reset it here for network status
				unique = unixtime() ;

				if ( json_data.status == -1 )
				{
					parent.toggle_status( 3 ) ;
				}
				else if ( json_data.status )
				{
					for ( c = 0; c < json_data.requests.length; ++c )
					{
						if ( json_data.requests[c]["op2op"] || ( typeof( parent.op_depts_hash[json_data.requests[c]["deptid"]] ) != "undefined" ) )
						{
							parent.new_chat( json_data.requests[c], unique ) ;
						}
					}

					parent.init_chat_list( unique ) ;
					parent.update_traffic_counter( pad( json_data.traffics, 2 ) ) ;

					if ( typeof( st_requesting ) == "undefined" )
						st_requesting = setTimeout( "requesting()" , <?php echo ( $VARS_JS_REQUESTING * 1000 ) ?> ) ;

					var end = microtime( true ) ;
					var diff = end - start ;

					parent.check_network( diff, unique, json_data.process_duration ) ;
				}
				else
				{
					write_debug( "<br>[ ERROR: undefined ] " ) ;
				}
				++c_requesting ;

				chatting() ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			stopit(0) ;
			st_reconnect = setTimeout(function(){ parent.check_network( 815, this.undefined, this.undefined ) }, 3000) ;
		} });

		if ( dev_run && ( c_requesting > 1 ) )
			stopit(0) ;
	}

	function chatting()
	{
		var json_data = new Object ;
		var start = 0 ;
		var q_ces = q_chattings = q_cids = q_isop_ = q_isop__ = "" ;

		for ( var ces in parent.chats )
		{
			// only check chats that are in session...
			if ( ( ( parent.chats[ces]["status"] == 1 ) || parent.chats[ces]["op2op"] || parent.chats[ces]["initiated"] ) && !parent.chats[ces]["disconnected"] && !parent.chats[ces]["tooslow"] )
			{
				q_ces += "q_ces[]="+ces+"&" ;
				q_chattings += "q_chattings[]="+parent.chats[ces]["chatting"]+"&" ;
				q_cids += "q_cids[]="+parent.chats[ces]["cid"]+"&" ;
				q_isop_ += "q_isop_[]="+parent.chats[ces]["op2op"]+"&" ;
				q_isop__ += "q_isop__[]="+parent.chats[ces]["opid"]+"&" ;
				start = 1 ;
			}
		}

		if ( typeof( st_chatting ) != "undefined" )
		{
			clearTimeout( st_chatting ) ;
			st_chatting = this.undefined ;
		}

		if ( start )
		{
			var unique = unixtime() ;
			isop_ = parent.isop_ ; isop__ = parent.isop__ ;
			var thisces = ( typeof( parent.ces ) != "undefined" ) ? parent.ces : "" ;
			var t_vses = ( thisces ) ? parent.chats[thisces]["t_ses"] : 0 ;
			var mobile = ( typeof( parent.mobile ) != "undefined" ) ? parent.mobile : 0 ;

			$.ajax({
			type: "GET",
			url: "../ajax/chat_chatting.php",
			data: "action=chatting&t_vses="+t_vses+"&isop="+isop+"&isop_="+isop_+"&isop__="+isop__+"&ces="+thisces+"&c_chatting="+c_chatting+"&"+q_ces+q_chattings+q_cids+q_isop_+q_isop__+"&m="+mobile+"&"+unique,
			success: function(data){
				try {
					eval(data) ;
				} catch(err) {
					// if operator, the console will attempt to reconnect
					// if visitor, keep trying to send the data
					if ( !isop ) { visitor_reconnect() ; }
				}

				if ( !stopped || ( stopped && reconnect ) )
				{
					stopped = 0 ; // reset it for disconnect situation
					reconnect = 0 ;

					if ( json_data.status )
					{
						for ( c = 0; c < json_data.chats.length; ++c )
							parent.update_ces( json_data.chats[c] ) ;

						parent.init_chats() ;

						if ( typeof( parent.chats[thisces] ) != "undefined" )
							parent.chats[thisces]["istyping"] = json_data.istyping ;

						// only apply to visitor... for operator requesting() calls it for disconnection detection
						if ( !isop )
						{
							if ( typeof( st_chatting ) == "undefined" )
								st_chatting = setTimeout( "chatting()" , <?php echo ( $VARS_JS_REQUESTING * 1000 ) ?> ) ;
						}
					}
				}
				else
				{
					clearTimeout( st_chatting ) ; st_chatting = this.undefined ;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				if ( isop )
				{
					stopit(0) ;
					st_reconnect = setTimeout(function(){ parent.check_network( 915, this.undefined, this.undefined ) }, 1000) ;
				}
				else { visitor_reconnect() ; }
			} });
			++c_chatting ;
		}
		else
		{
			if ( !isop ) { st_chatting = setTimeout( "chatting()" , <?php echo ( $VARS_JS_REQUESTING * 1000 ) ?> ) ; }
		}
	}

	function visitor_reconnect()
	{
		// keep trying to reconnect the chat engine
		// todo: maximum number of attempts before final disconnect
		if ( typeof( st_chatting ) != "undefined" )
		{
			clearTimeout( st_chatting ) ;
			st_chatting = this.undefined ;
		}
		st_chatting = setTimeout( "chatting()" , <?php echo ( $VARS_JS_REQUESTING * 1000 ) ?> ) ;
	}

	function stopit( thereconnect )
	{
		reconnect = thereconnect ;
		clear_timeouts() ;
	}

	function clear_timeouts()
	{
		if ( typeof( st_routing ) != "undefined" ) { clearTimeout( st_routing ) ; st_routing = this.undefined ; }
		if ( typeof( st_chatting ) != "undefined" ) { clearTimeout( st_chatting ) ; st_chatting = this.undefined ; }
		if ( typeof( st_requesting ) != "undefined" ) { clearTimeout( st_requesting ) ; st_requesting = this.undefined ; }

		if ( typeof( st_network ) != "undefined" ) { clearTimeout( st_network ) ; st_network = this.undefined ; }
		if ( typeof( st_reconnect ) != "undefined" ) { clearTimeout( st_reconnect ) ; st_reconnect = this.undefined ; }

		stopped = 1 ;
	}

	function write_debug( thestring )
	{
		if ( debug )
			$( "#log" ).append( thestring ) ;
	}
//-->
</script>
</head>
<body>
<div id="log" class="chat_info_td_traffic_info" style="display: none; padding: 2px; width: 100%; height: 28px; height: 150px; overflow: auto; border-top: 1px solid #000000;">
	<?php if ( $ses ): ?>
		<a href="JavaScript:void(0)" onClick="stopit(0)">o</a>:
	<?php else: ?>
		<a href="JavaScript:void(0)" onClick="stopit(0)">v</a>: 
	<?php endif; ?>
</div>
</body>
</html>
<?php database_mysql_close( $dbh ) ; ?>