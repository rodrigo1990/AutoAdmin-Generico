<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ;

	$query = Util_Format_Sanatize( Util_Format_GetVar( "q" ), "" ) ;
	if ( !$query ) { $query = Util_Format_Sanatize( Util_Format_GetVar( "v" ), "" ) ; }
	if ( !isset( $CONF["IE_cs"] ) ) { $CONF["IE_cs"] = 0 ; }
	$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
	LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
	$mobile = ( $os == 5 ) ? 1 : 0 ;

	$params = Array( ) ; $tok = strtok( $query, '|' ) ;
	while ( $tok !== false ) { $params[] = $tok ; $tok = strtok( '|' ) ; }

	$deptid = isset( $params[0] ) ? Util_Format_Sanatize( $params[0], "n" ) : 0 ;
	$btn = isset( $params[1] ) ? Util_Format_Sanatize( $params[1], "n" ) : 0 ;
	$proto = isset( $params[2] ) ? Util_Format_Sanatize( rawurldecode( $params[2] ), "n" ) : 0 ;
	$text = isset( $params[3] ) ? Util_Format_Sanatize( rawurldecode( $params[3] ), "ln" ) : "" ;

	$base_url = $CONF["BASE_URL"] ;
	$upload_dir = $CONF['CONF_ROOT'] ;
	if ( $proto == 1 ) { $base_url = preg_replace( "/(http:)|(https:)/i", "http:", $base_url ) ; }
	else if ( $proto == 2 ) { $base_url = preg_replace( "/(http:)|(https:)/i", "https:", $base_url ) ; }
	else { $base_url = preg_replace( "/(http:)|(https:)/i", "", $base_url ) ; }

	if ( !isset( $CONF['foot_log'] ) ) { $CONF['foot_log'] = "on" ; }
	if ( !isset( $CONF['icon_check'] ) ) { $CONF['icon_check'] = "on" ; }
	$popout_div = ( !isset( $VALS["POPOUT"] ) || ( $VALS["POPOUT"] != "off" ) ) ? "<div style='float: left; width: 16px; height: 16px; text-align: center; padding: 5px; margin-right: 5px; cursor: pointer;' id='phplive_embed_menu_popout' onClick='phplive_widget_embed_popout( )'><img src='$base_url/pics/space_big.png' width='16' height='16' border='0' alt=''></div>" : "" ;

	$initiate = ( isset( $VALS["auto_initiate"] ) && $VALS["auto_initiate"] ) ? unserialize( html_entity_decode( $VALS["auto_initiate"] ) ) : Array( ) ;
	$widget_max = 4 ;
	$widget_slider = ( isset( $initiate["pos"] ) ) ? $initiate["pos"] : 1 ;
	if ( $widget_slider == 1 ) { $widget_animate_show = "left: '50px'" ; $widget_animate_hide = "left: -800" ; $widget_top_left = "top: 190px; left: 50px;" ; $widget_cover_top_left = "top: 190px; left: -800px;" ; }
	else if ( $widget_slider == 2 ) { $widget_animate_show = "right: '50px'" ; $widget_animate_hide = "right: -800" ; $widget_top_left = "top: 190px; right: 50px;" ; $widget_cover_top_left = "top: 190px; right: -800px;" ; }
	else if ( $widget_slider == 3 ) { $widget_animate_show = "bottom: '50px'" ; $widget_animate_hide = "bottom: -800" ; $widget_top_left = "bottom: 50px; left: 50px;" ; $widget_cover_top_left = "bottom: -800px; left: 50px;" ; }
	else if ( $widget_slider == 4 ) { $widget_animate_show = "bottom: '50px'" ; $widget_animate_hide = "bottom: -800" ; $widget_top_left = "bottom: 50px; right: 50px;" ; $widget_cover_top_left = "bottom: -800px; right: 50px;" ; }
	else { $widget_animate_show = $widget_animate_hide = $widget_top_left = $widget_cover_top_left = "" ; }

	$online = ( isset( $VALS['ONLINE'] ) && $VALS['ONLINE'] ) ? unserialize( $VALS['ONLINE'] ) : Array( ) ;
	if ( !isset( $online[0] ) ) { $online[0] = "embed" ; }
	if ( !isset( $online[$deptid] ) ) { $online[$deptid] = $online[0] ; }
	$offline = ( isset( $VALS['OFFLINE'] ) && $VALS['OFFLINE'] ) ? unserialize( $VALS['OFFLINE'] ) : Array( ) ;
	if ( !isset( $offline[0] ) ) { $offline[0] = "embed" ; }
	if ( !isset( $offline[$deptid] ) ) { $offline[$deptid] = $offline[0] ; }

	$redirect_url = ( isset( $offline[$deptid] ) && !preg_match( "/^(icon|hide|embed)$/", $offline[$deptid] ) ) ? $offline[$deptid] : "" ;
	$icon_hide = ( isset( $offline[$deptid] ) && preg_match( "/^(hide)$/", $offline[$deptid] ) ) ? 1 : 0 ;
	$embed_online = ( isset( $online[$deptid] ) && preg_match( "/^(embed)$/", $online[$deptid] ) ) ? 1 : 0 ;
	$embed_offline = ( isset( $offline[$deptid] ) && preg_match( "/^(embed)$/", $offline[$deptid] ) ) ? 1 : 0 ;

	if ( !isset( $CONF["vsize"] ) ) { $width = $VARS_CHAT_WIDTH ; $height = $VARS_CHAT_HEIGHT ; }
	else { LIST( $width, $height ) = explode( "x", $CONF["vsize"] ) ; }
	$width_widget = $VARS_CHAT_WIDTH_WIDGET ; $height_widget = $VARS_CHAT_HEIGHT_WIDGET ;
	Header( "Content-Type: text/javascript" ) ;
?>
if ( typeof( phplive_md5 ) == "undefined" ) { !function(a){"use strict";function b(a,b){var c=(65535&a)+(65535&b),d=(a>>16)+(b>>16)+(c>>16);return d<<16|65535&c}function c(a,b){return a<<b|a>>>32-b}function d(a,d,e,f,g,h){return b(c(b(b(d,a),b(f,h)),g),e)}function e(a,b,c,e,f,g,h){return d(b&c|~b&e,a,b,f,g,h)}function f(a,b,c,e,f,g,h){return d(b&e|c&~e,a,b,f,g,h)}function g(a,b,c,e,f,g,h){return d(b^c^e,a,b,f,g,h)}function h(a,b,c,e,f,g,h){return d(c^(b|~e),a,b,f,g,h)}function i(a,c){a[c>>5]|=128<<c%32,a[(c+64>>>9<<4)+14]=c;var d,i,j,k,l,m=1732584193,n=-271733879,o=-1732584194,p=271733878;for(d=0;d<a.length;d+=16)i=m,j=n,k=o,l=p,m=e(m,n,o,p,a[d],7,-680876936),p=e(p,m,n,o,a[d+1],12,-389564586),o=e(o,p,m,n,a[d+2],17,606105819),n=e(n,o,p,m,a[d+3],22,-1044525330),m=e(m,n,o,p,a[d+4],7,-176418897),p=e(p,m,n,o,a[d+5],12,1200080426),o=e(o,p,m,n,a[d+6],17,-1473231341),n=e(n,o,p,m,a[d+7],22,-45705983),m=e(m,n,o,p,a[d+8],7,1770035416),p=e(p,m,n,o,a[d+9],12,-1958414417),o=e(o,p,m,n,a[d+10],17,-42063),n=e(n,o,p,m,a[d+11],22,-1990404162),m=e(m,n,o,p,a[d+12],7,1804603682),p=e(p,m,n,o,a[d+13],12,-40341101),o=e(o,p,m,n,a[d+14],17,-1502002290),n=e(n,o,p,m,a[d+15],22,1236535329),m=f(m,n,o,p,a[d+1],5,-165796510),p=f(p,m,n,o,a[d+6],9,-1069501632),o=f(o,p,m,n,a[d+11],14,643717713),n=f(n,o,p,m,a[d],20,-373897302),m=f(m,n,o,p,a[d+5],5,-701558691),p=f(p,m,n,o,a[d+10],9,38016083),o=f(o,p,m,n,a[d+15],14,-660478335),n=f(n,o,p,m,a[d+4],20,-405537848),m=f(m,n,o,p,a[d+9],5,568446438),p=f(p,m,n,o,a[d+14],9,-1019803690),o=f(o,p,m,n,a[d+3],14,-187363961),n=f(n,o,p,m,a[d+8],20,1163531501),m=f(m,n,o,p,a[d+13],5,-1444681467),p=f(p,m,n,o,a[d+2],9,-51403784),o=f(o,p,m,n,a[d+7],14,1735328473),n=f(n,o,p,m,a[d+12],20,-1926607734),m=g(m,n,o,p,a[d+5],4,-378558),p=g(p,m,n,o,a[d+8],11,-2022574463),o=g(o,p,m,n,a[d+11],16,1839030562),n=g(n,o,p,m,a[d+14],23,-35309556),m=g(m,n,o,p,a[d+1],4,-1530992060),p=g(p,m,n,o,a[d+4],11,1272893353),o=g(o,p,m,n,a[d+7],16,-155497632),n=g(n,o,p,m,a[d+10],23,-1094730640),m=g(m,n,o,p,a[d+13],4,681279174),p=g(p,m,n,o,a[d],11,-358537222),o=g(o,p,m,n,a[d+3],16,-722521979),n=g(n,o,p,m,a[d+6],23,76029189),m=g(m,n,o,p,a[d+9],4,-640364487),p=g(p,m,n,o,a[d+12],11,-421815835),o=g(o,p,m,n,a[d+15],16,530742520),n=g(n,o,p,m,a[d+2],23,-995338651),m=h(m,n,o,p,a[d],6,-198630844),p=h(p,m,n,o,a[d+7],10,1126891415),o=h(o,p,m,n,a[d+14],15,-1416354905),n=h(n,o,p,m,a[d+5],21,-57434055),m=h(m,n,o,p,a[d+12],6,1700485571),p=h(p,m,n,o,a[d+3],10,-1894986606),o=h(o,p,m,n,a[d+10],15,-1051523),n=h(n,o,p,m,a[d+1],21,-2054922799),m=h(m,n,o,p,a[d+8],6,1873313359),p=h(p,m,n,o,a[d+15],10,-30611744),o=h(o,p,m,n,a[d+6],15,-1560198380),n=h(n,o,p,m,a[d+13],21,1309151649),m=h(m,n,o,p,a[d+4],6,-145523070),p=h(p,m,n,o,a[d+11],10,-1120210379),o=h(o,p,m,n,a[d+2],15,718787259),n=h(n,o,p,m,a[d+9],21,-343485551),m=b(m,i),n=b(n,j),o=b(o,k),p=b(p,l);return[m,n,o,p]}function j(a){var b,c="";for(b=0;b<32*a.length;b+=8)c+=String.fromCharCode(a[b>>5]>>>b%32&255);return c}function k(a){var b,c=[];for(c[(a.length>>2)-1]=void 0,b=0;b<c.length;b+=1)c[b]=0;for(b=0;b<8*a.length;b+=8)c[b>>5]|=(255&a.charCodeAt(b/8))<<b%32;return c}function l(a){return j(i(k(a),8*a.length))}function m(a,b){var c,d,e=k(a),f=[],g=[];for(f[15]=g[15]=void 0,e.length>16&&(e=i(e,8*a.length)),c=0;16>c;c+=1)f[c]=909522486^e[c],g[c]=1549556828^e[c];return d=i(f.concat(k(b)),512+8*b.length),j(i(g.concat(d),640))}function n(a){var b,c,d="0123456789abcdef",e="";for(c=0;c<a.length;c+=1)b=a.charCodeAt(c),e+=d.charAt(b>>>4&15)+d.charAt(15&b);return e}function o(a){return unescape(encodeURIComponent(a))}function p(a){return l(o(a))}function q(a){return n(p(a))}function r(a,b){return m(o(a),o(b))}function s(a,b){return n(r(a,b))}function t(a,b,c){return b?c?r(b,a):s(b,a):c?p(a):q(a)}"function"==typeof define&&define.amd?define(function( ){return t}):a.phplive_md5=t}(this); }
if ( typeof( phplive_init_jquery ) == "undefined" )
{
	var phplive_jquery ;
	var phplive_stat_refer = encodeURIComponent( document.referrer.replace("http", "hphp") ) ;
	var phplive_stat_onpage = encodeURIComponent( location.toString( ).replace("http", "hphp") ) ;
	var phplive_stat_title = encodeURIComponent( document.title ) ;
	var phplive_win_width = screen.width ;
	var phplive_win_height = screen.height ;
	var phplive_resolution = escape( phplive_win_width + " x " + phplive_win_height ) ;
	var phplive_query_extra = "&r="+phplive_stat_refer+"&title="+phplive_stat_title+"&resolution="+phplive_resolution ;
	var proto = location.protocol ; // to avoid JS proto error, use page proto for areas needing to access the JS objects
	var phplive_browser = navigator.appVersion ; var phplive_mime_types = "" ;
	if ( navigator.mimeTypes.length > 0 ) { for (var x=0; x < navigator.mimeTypes.length; x++) { phplive_mime_types += navigator.mimeTypes[x].description ; } }
	var phplive_browser_token = phplive_md5( phplive_browser+phplive_mime_types ) ;
	var phplive_session_support = ( typeof( Storage ) !== "undefined" ) ? 1 : 0 ;
	if ( phplive_session_support ) { if ( typeof( sessionStorage.minmax ) == "undefined" ) { sessionStorage.minmax = 1 ; } }
	var phplive_js_center = function(a){var b=phplive_jquery(window),c=b.scrollTop( );return this.each(function( ){var f=phplive_jquery(this),e=phplive_jquery.extend({against:"window",top:false,topPercentage:0.5},a),d=function( ){var h,g,i;if(e.against==="window"){h=b;}else{if(e.against==="parent"){h=f.parent( );c=0;}else{h=f.parents(against);c=0;}}g=((h.width( ))-(f.outerWidth( )))*0.5;i=((h.height( ))-(f.outerHeight( )))*e.topPercentage+c;if(e.top){i=e.top+c;}f.css({left:g,top:i});};d( );b.resize(d);});} ;

	var phplive_quirks = 0 ;
	var phplive_IE ;
	//@cc_on phplive_IE = navigator.appVersion ;

	var phplive_IE_cs = ( phplive_IE && !<?php echo $mobile ?> ) ? <?php echo $CONF["IE_cs"] ?> : 0 ;
	var mode = document.compatMode,m ;
	if ( ( mode == 'BackCompat' ) && phplive_IE ) { phplive_quirks = 1 ; }

	window.phplive_init_jquery = function( )
	{
		if ( typeof( phplive_jquery ) == "undefined" )
		{
			if ( typeof( window.jQuery ) == "undefined" )
			{
				var script_jquery = document.createElement('script') ;
				script_jquery.type = "text/javascript" ; script_jquery.async = true ;
				script_jquery.onload = script_jquery.onreadystatechange = function ( ) {
					if ( ( typeof( this.readyState ) == "undefined" ) || ( this.readyState == "loaded" || this.readyState == "complete" ) )
					{
						phplive_jquery = window.jQuery.noConflict( ) ;
						phplive_jquery.fn.center = phplive_js_center ;
					}
				} ;
				script_jquery.src = "<?php echo $base_url ?>/js/framework.js?<?php echo $VERSION ?>" ;
				var script_jquery_s = document.getElementsByTagName('script')[0] ;
				script_jquery_s.parentNode.insertBefore(script_jquery, script_jquery_s) ;
			}
			else
			{
				phplive_jquery = window.jQuery ;
				phplive_jquery.fn.center = phplive_js_center ;
			}
		}
	}
	window.phplive_unique = function( ) { var date = new Date( ) ; return date.getTime( ) ; }
	phplive_init_jquery( ) ;
}

if ( typeof( phplive_widget_embed ) == "undefined" )
{
	var phplive_interval_jquery_check ;

	// one default invite per page to avoid multiple invites
	var phplive_widget_embed = 0 ;
	var this_position = ( phplive_quirks ) ? "absolute" : "fixed" ;

	var phplive_embed_div_js_loaded = 0 ;
	var phplive_embed_div_loaded = 0 ;

	var phplive_widget_div_js_loaded = 0 ;
	var phplive_widget_div_loaded = 0 ;

	// seems the quirks fixed so keep it same for now (was 270x180)
	var phplive_widget_width = ( phplive_quirks ) ? 250 : 250 ;
	var phplive_widget_height = ( phplive_quirks ) ? 160 : 160 ;
	var phplive_widget_image = '<?php echo Util_Upload_GetInitiate( $CONF["UPLOAD_HTTP"], 0 ) ; ?>' ;
	var phplive_widget_image_op = '<?php echo $base_url ?>/themes/initiate/initiate_op_cover.png' ;

	var phplive_widget = "<map name='initiate_chat_cover'><area shape='rect' coords='222,2,247,26' href='JavaScript:void(0)' onClick='phplive_widget_decline( )'><area shape='rect' coords='0,26,250,160' href='JavaScript:void(0)' onClick='phplive_widget_launch( )'></map><div id='phplive_widget' name='phplive_widget' style='display: none; position: "+this_position+"; <?php echo $widget_top_left ?> background: url( <?php echo $base_url ?>/themes/initiate/bg_trans.png ) repeat; padding: 10px; width: "+phplive_widget_width+"px; height: "+phplive_widget_height+"px; -moz-border-radius: 5px; border-radius: 5px; z-Index: 40000;'></iframe></div><div id='phplive_widget_image' style='display: none; position: "+this_position+"; <?php echo $widget_cover_top_left ?> padding: 10px; z-Index: 40001;'><img src='"+phplive_widget_image+"' id='phplive_widget_image_img' width='250' height='160' border=0 usemap='#initiate_chat_cover' style='-moz-border-radius: 5px; border-radius: 5px;'></div>" ;

	window.phplive_display_invite_widget = function( thecoverimg, theurl )
	{
		if ( !phplive_widget_div_js_loaded )
		{
			phplive_widget_div_js_loaded = 1 ;
			phplive_jquery( "body" ).append( phplive_widget ) ;
		}

		if ( !phplive_widget_div_loaded )
		{
			phplive_widget_div_loaded = 1 ;
			phplive_create_iframe( 'phplive_widget', 'iframe_widget', theurl ) ;
			phplive_jquery( '#phplive_widget_image_img').attr( 'src', thecoverimg ) ;

			if ( <?php echo $widget_slider ?> > <?php echo $widget_max ?> )
			{
				phplive_jquery( '#phplive_widget_image' ).center( ).show( ) ;
				phplive_jquery( '#phplive_widget' ).center( ).fadeIn('fast') ;
			}
			else
			{
				if ( thecoverimg.indexOf( "op_cover" ) != -1 )
				{
					phplive_jquery( '#phplive_widget' ).fadeIn( "fast", function( ) {
						phplive_jquery( '#phplive_widget_image' ).animate({ <?php echo $widget_animate_show ?> }, 200, function( ) {
							phplive_jquery( '#phplive_widget_image' ).show( ) ;
						}) ;
					}) ;
				}
				else
				{
					phplive_jquery( '#phplive_widget_image' ).show( ).animate({ <?php echo $widget_animate_show ?> }, 2000, function( ) {
						phplive_jquery( '#phplive_widget' ).fadeIn('fast') ;
					}) ;
				}
			}
		}
	}
	window.phplive_widget_init = function ( )
	{
		if ( typeof( phplive_interval_jquery_check ) != "undefined" ) { clearInterval( phplive_interval_jquery_check ) ; }
		phplive_interval_jquery_check = setInterval(function( ){
			if ( typeof( phplive_jquery ) != "undefined" )
			{
				clearInterval( phplive_interval_jquery_check ) ;
				phplive_display_invite_widget( phplive_widget_image_op, "<?php echo $base_url ?>/widget.php?token="+phplive_browser_token+"&height="+phplive_widget_height +"&"+phplive_unique( ) ) ;
			}
		}, 200) ;
	}
	window.phplive_widget_launch = function( )
	{
		phplive_widget_div_loaded = 0 ;
		phplive_widget_close( ) ;
		phplive_launch_chat_<?php echo $deptid ?>(0, 1, "", 0, 0, 1) ;
	}
	window.phplive_widget_close = function( )
	{
		phplive_jquery( '#phplive_widget' ).fadeOut('fast') ;
		phplive_jquery( '#phplive_widget_image' ).fadeOut('fast') ;
		phplive_create_iframe( 'phplive_widget', 'iframe_widget', 'about:blank' ) ;
	}
	window.phplive_widget_decline = function( )
	{
		if ( phplive_widget_div_loaded )
		{
			var phplive_pullimg_widget = new Image ;
			phplive_pullimg_widget.onload = function( ) {
				if ( <?php echo $widget_slider ?> > <?php echo $widget_max ?> ) { phplive_jquery( '#phplive_widget' ).fadeOut('fast') ; }
				else { phplive_jquery( '#phplive_widget_image' ).animate({ <?php echo $widget_animate_hide ?> }, 2000) ; }
			};
			phplive_pullimg_widget.src = "<?php echo $base_url ?>/ajax/chat_actions_disconnect.php?action=disconnect&token="+phplive_browser_token+"&isop=0&widget=1&"+phplive_unique( ) ;
			phplive_widget_close( ) ;
			phplive_widget_div_loaded = 0 ;
		}
	}
	window.phplive_widget_embed_launch = function( theurl, theminmax, theauto )
	{
		if ( !phplive_embed_div_js_loaded )
		{
			phplive_embed_div_js_loaded = 1 ;
			var phplive_widget_embed_div = "<div id='phplive_widget_embed_iframe_loading' style='display: none; position: fixed; width: 31px; height: 31px; padding: 2px; right: 5px; bottom: 5px; background: #FFFFFF; border: 1px solid #F1F5FB; -moz-border-radius: 5px; border-radius: 5px; z-Index: 40005;'><img src='<?php echo $base_url ?>/themes/initiate/loading.gif' width='31' height='31' border='0' alt=''></div> \
			<div id='phplive_widget_embed_iframe' style='position: fixed; width: <?php echo $width_widget ?>px; height: <?php echo $height_widget ?>px; right: 5px; bottom: 50000px; -moz-border-radius: 5px; border-radius: 5px; z-Index: 40003;'><div id='phplive_widget_embed_iframe_wrapper' style='width: 100%; height: 100%; -moz-border-radius: 5px; border-radius: 5px;'></div> \
				<div style='position: absolute; top: 0px; left: 0px; width: <?php echo $width_widget ?>px; height: 28px;'> \
					<div style='display: none; float: left; width: 16px; height: 16px; margin-right: 5px; text-align: center; padding: 5px; cursor: pointer;' id='phplive_embed_menu_maximize' onClick='phplive_widget_embed_maximize( )'><img src='<?php echo $base_url ?>/pics/space_big.png' width='16' height='16' border='0' alt=''></div> \
					<div style='float: left; width: 16px; height: 16px; text-align: center; padding: 5px; margin-right: 5px; cursor: pointer;' id='phplive_embed_menu_minimize' onClick='phplive_widget_embed_minimize( )'><img src='<?php echo $base_url ?>/pics/space_big.png' width='16' height='16' border='0' alt=''></div> <?php echo $popout_div ?>\
					<div style='float: right; width: 16px; height: 16px; text-align: right; padding: 5px; cursor: pointer;' onClick='phplive_widget_embed_close( )'><img src='<?php echo $base_url ?>/pics/space_big.png' width='16' height='16' border='0' alt=''></div> \
					<div style='clear: both;'></div> \
				</div> \
			</div><div id='phplive_widget_embed_iframe_shadow' style='display: none; position: fixed; width: 515px; height: 538px; right: 0px; bottom: 0px; z-Index: 40000;'><img src='<?php echo $base_url ?>/themes/initiate/widget_shadow.png' width='515' height='538' border='0' alt=''></div><div id='phplive_widget_embed_iframe_shadow_minimzed' style='display: none; position: fixed; width: 265px; height: 55px; right: 0px; bottom: 0px; z-Index: 40000;'><img src='<?php echo $base_url ?>/themes/initiate/widget_shadow_minimized.png' width='265' height='55' border='0' alt=''></div>" ;
			phplive_jquery( "body" ).append( phplive_widget_embed_div ) ;
		}

		if ( !phplive_embed_div_loaded )
		{
			phplive_embed_div_loaded = 1 ;
			var load_counter = 0 ;
			if ( phplive_session_support ) { sessionStorage.minmax = theminmax ; }

			if ( theminmax ) { phplive_jquery('#phplive_widget_embed_iframe_loading').show( ) ; }

			phplive_create_iframe( 'phplive_widget_embed_iframe_wrapper', 'iframe_widget_embed', theurl+"&embed=1&"+phplive_unique( ) ) ;
			phplive_jquery( '#iframe_widget_embed' ).load(function ( ){
				++load_counter ;
				// some browsers triggers load() multiple times... only check on 1st instance
				if ( load_counter == 1 )
				{
					if ( !theminmax )
					{
						phplive_jquery('#phplive_widget_embed_iframe_loading').hide( ) ;
						phplive_jquery('#phplive_widget_embed_iframe').css({'bottom': 50000}).show( ) ;
						setTimeout( function( ){ phplive_widget_embed_minimize( ) ; phplive_jquery('#phplive_widget_embed_iframe').css({'bottom': 5}) ; }, 1500 ) ;
					}
					else
					{
						phplive_jquery('#phplive_widget_embed_iframe').hide( ) ;
						phplive_jquery('#phplive_widget_embed_iframe').css({'bottom': 5}) ;
						phplive_jquery('#phplive_widget_embed_iframe').fadeIn('fast', function( ) {
							phplive_jquery('#phplive_widget_embed_iframe_loading').hide( ) ;
							phplive_jquery('#phplive_widget_embed_iframe_shadow').fadeIn('fast') ;
						}) ;
					}
				}
			}) ;
		}
		else
		{
			phplive_widget_embed_window_reset( ) ;
			if ( phplive_session_support ) { sessionStorage.minmax = 1 ; }
			phplive_jquery('#phplive_widget_embed_iframe').fadeOut('fast', function( ) {
				phplive_jquery('#phplive_widget_embed_iframe').fadeIn('fast', function ( ) { phplive_jquery( '#phplive_widget_embed_iframe_shadow' ).fadeIn('fast') ; } ) ;
			}) ;
		}
	}
	window.phplive_widget_embed_minimize = function( )
	{
		phplive_jquery('#phplive_widget_embed_iframe').css({'height': 40}) ;
		phplive_jquery('#phplive_widget_embed_iframe').css({'width': 250}) ;
		phplive_jquery('#phplive_embed_menu_minimize').hide( ) ;
		phplive_jquery('#phplive_embed_menu_popout').hide( ) ;
		phplive_jquery('#phplive_embed_menu_maximize').show( ) ;
		phplive_jquery('#phplive_widget_embed_iframe_shadow').hide( ) ;
		phplive_jquery('#phplive_widget_embed_iframe_shadow_minimzed').fadeIn("fast") ;
		if ( phplive_session_support ) { sessionStorage.minmax = 0 ; }
	}
	window.phplive_widget_embed_maximize = function( )
	{
		phplive_widget_embed_window_reset( ) ;
		phplive_jquery('#phplive_widget_embed_iframe_shadow').fadeIn("fast") ;
		phplive_jquery('#phplive_widget_embed_iframe_shadow_minimzed').hide( ) ;
		if ( phplive_session_support ) { sessionStorage.minmax = 1 ; }
	}
	window.phplive_widget_embed_popout = function( )
	{
		phplive_launch_chat_<?php echo $deptid ?>(1, 1, "", 0, 0, 0) ;
		phplive_jquery('#phplive_widget_embed_iframe').css({'bottom': 50000}) ;
		phplive_jquery('#phplive_widget_embed_iframe_shadow').hide( ) ;
		phplive_jquery('#phplive_widget_embed_iframe_shadow_minimzed').hide( ) ;
		phplive_widget_embed_window_reset( ) ;
		phplive_create_iframe( 'phplive_widget_embed_iframe_wrapper', 'iframe_widget_embed', 'about:blank' ) ;
		phplive_embed_div_loaded = 0 ;
	}
	window.phplive_widget_embed_close = function( )
	{
		phplive_jquery('#phplive_widget_embed_iframe').css({'bottom': 50000}) ;
		phplive_jquery('#phplive_widget_embed_iframe_shadow').hide( ) ;
		phplive_jquery('#phplive_widget_embed_iframe_shadow_minimzed').hide( ) ;
		phplive_widget_embed_window_reset( ) ;
		phplive_create_iframe( 'phplive_widget_embed_iframe_wrapper', 'iframe_widget_embed', 'about:blank' ) ;
		phplive_embed_div_loaded = 0 ;
	}
	window.phplive_widget_embed_window_reset = function( )
	{
		phplive_jquery('#phplive_widget_embed_iframe').css({'height': <?php echo $height_widget ?>}) ;
		phplive_jquery('#phplive_widget_embed_iframe').css({'width': <?php echo $width_widget ?>}) ;
		phplive_jquery('#phplive_embed_menu_maximize').hide( ) ;
		phplive_jquery('#phplive_embed_menu_popout').show( ) ;
		phplive_jquery('#phplive_embed_menu_minimize').show( ) ;
		phplive_jquery('#phplive_widget_embed_iframe_shadow_minimzed').hide( ) ;
	}
	window.phplive_create_iframe = function( thediv, thename, theurl )
	{
		var phplive_dynamic_iframe = document.createElement("iframe") ;
		phplive_dynamic_iframe.src = theurl ;
		phplive_dynamic_iframe.id = thename ; phplive_dynamic_iframe.name = thename ;
		phplive_dynamic_iframe.style.width = "100%" ;
		phplive_dynamic_iframe.style.height = "100%" ;
		phplive_dynamic_iframe.style.border = 0 ;
		phplive_dynamic_iframe.scrolling = "no" ;
		phplive_dynamic_iframe.frameBorder = 0 ;
		phplive_dynamic_iframe.style.MozBorderRadius = "5px" ;
		phplive_dynamic_iframe.style.borderRadius = "5px" ;
		phplive_jquery('#'+thediv).empty( ).html( phplive_dynamic_iframe ) ;
	}
	var phplive_interval_jquery_init = setInterval(function( ){ if ( typeof( phplive_jquery ) != "undefined" ) {
			clearInterval( phplive_interval_jquery_init ) ;
	} }, 100) ;
}

if ( typeof( phplive_thec_<?php echo $deptid ?> ) == "undefined" )
{
	var phplive_thec_<?php echo $deptid ?> = 0 ;
	var phplive_fetch_status_image_<?php echo $deptid ?> ;
	var phplive_fetch_footprint_image_<?php echo $deptid ?> ;

	var phplive_interval_fetch_status_<?php echo $deptid ?> ;
	var phplive_interval_footprint_<?php echo $deptid ?> ;
	var phplive_request_url_query_<?php echo $deptid ?> = "d=<?php echo $deptid ?>&token="+phplive_browser_token+"&onpage="+phplive_stat_onpage+"&title="+phplive_stat_title ;
	var phplive_fetch_status_url_<?php echo $deptid ?> = "<?php echo $base_url ?>/ajax/status.php?action=js&token="+phplive_browser_token+"&deptid=<?php echo $deptid ?>&jkey=<?php echo md5( $CONF["API_KEY"] ) ?>" ;
	var phplive_request_url_<?php echo $deptid ?> = "<?php echo $base_url ?>/phplive.php?"+phplive_request_url_query_<?php echo $deptid ?> ;
	var phplive_request_url_<?php echo $deptid ?>_embed = "<?php echo $base_url ?>/phplive_embed.php?"+phplive_request_url_query_<?php echo $deptid ?> ;
	var phplive_offline_redirect_<?php echo $deptid ?> = 0 ;
	var phplive_online_offline_<?php echo $deptid ?> ;

	var phplive_image_online_<?php echo $deptid ?> = "<?php echo Util_Upload_GetChatIcon( "$CONF[UPLOAD_HTTP]", "icon_online", $deptid ) ?>" ;
	var phplive_image_offline_<?php echo $deptid ?> = "<?php echo Util_Upload_GetChatIcon( "$CONF[UPLOAD_HTTP]", "icon_offline", $deptid ) ?>" ;

	window.phplive_get_thec_<?php echo $deptid ?> = function( ) { return phplive_thec_<?php echo $deptid ?> ; }
	window.phplive_fetch_status_<?php echo $deptid ?> = function( )
	{
		phplive_fetch_status_image_<?php echo $deptid ?> = new Image ;
		phplive_fetch_status_image_<?php echo $deptid ?>.onload = phplive_fetch_status_actions_<?php echo $deptid ?> ;
		phplive_fetch_status_image_<?php echo $deptid ?>.src = phplive_fetch_status_url_<?php echo $deptid ?>+"&"+phplive_unique( ) ;
	}
	window.phplive_fetch_status_actions_<?php echo $deptid ?> = function( )
	{
		var thisflag = phplive_fetch_status_image_<?php echo $deptid ?>.width ;

		if ( ( thisflag == 1 ) || ( thisflag == 4 ) || ( thisflag == 6 ) || ( thisflag == 8 ) || ( thisflag == 10 ) )
		{
			phplive_online_offline_<?php echo $deptid ?> = 1 ;
			if ( ( thisflag == 4 ) && !phplive_widget_div_loaded && !phplive_embed_div_loaded ) { phplive_widget_init( ) ; }
			else if ( ( thisflag == 10 ) && !phplive_widget_div_loaded && !phplive_embed_div_loaded ) { }
			else if ( ( thisflag == 8 ) && !phplive_embed_div_loaded )
			{
				// setTimeout is for brief delay to avoid too fast loading causing 1px height issue
				if ( phplive_session_support )
				{
					if ( sessionStorage.minmax == 1 ) { setTimeout( function( ){ phplive_launch_chat_<?php echo $deptid ?>(0, 1, "", 1, 1, 0) ; }, 100 ) ; }
					else { setTimeout( function( ){ phplive_launch_chat_<?php echo $deptid ?>(0, 0, "", 1, 1, 0) ; }, 100 ) ; }
				}
				else { setTimeout( function( ){ phplive_launch_chat_<?php echo $deptid ?>(0, 0, "", 0, 1, 0) ; }, 100 ) ; }
			}
			else if ( thisflag == 6 ) { phplive_display_invite_widget( phplive_widget_image, "about:blank" ) ; } // auto invite
		}
		else
		{
			phplive_online_offline_<?php echo $deptid ?> = 0 ;
			if ( ( thisflag == 5 ) && !phplive_widget_div_loaded && !phplive_embed_div_loaded ) { phplive_widget_init( ) ; }
			else if ( ( thisflag == 11 ) && !phplive_widget_div_loaded && !phplive_embed_div_loaded ) { }
			if ( ( thisflag == 9 ) && !phplive_embed_div_loaded )
			{
				if ( phplive_session_support )
				{
					if ( sessionStorage.minmax == 1 ) { setTimeout( function( ){ phplive_launch_chat_<?php echo $deptid ?>(0, 1, "", 1, 1, 0) ; }, 100 ) ; }
					else { setTimeout( function( ){ phplive_launch_chat_<?php echo $deptid ?>(0, 0, "", 1, 1, 0) ; }, 100 ) ; }
				}
				else { setTimeout( function( ){ phplive_launch_chat_<?php echo $deptid ?>(0, 0, "", 0, 1, 0) ; }, 100 ) ; }
			}
			else if ( thisflag == 7 ) { phplive_display_invite_widget( phplive_widget_image, "about:blank" ) ; } // auto invite
		}
		if ( typeof( phplive_interval_fetch_status_<?php echo $deptid ?> ) != "undefined" )
			clearInterval( phplive_interval_fetch_status_<?php echo $deptid ?> ) ;

		<?php if ( $CONF['icon_check'] == "on" ): ?>
		phplive_interval_fetch_status_<?php echo $deptid ?> = setInterval(function( ){ phplive_fetch_status_<?php echo $deptid ?>( ) ; }, <?php echo $VARS_JS_INVITE_CHECK ?> * 1000) ;
		<?php endif ; ?>

	}
	window.phplive_footprint_track_<?php echo $deptid ?> = function( )
	{
		var c = phplive_get_thec_<?php echo $deptid ?>( ) ; ++phplive_thec_<?php echo $deptid ?> ;
		var fetch_url = "<?php echo $base_url ?>/ajax/footprints.php?deptid=<?php echo $deptid ?>&token="+phplive_browser_token+"&onpage="+phplive_stat_onpage+"&c="+c+"&"+phplive_unique( ) ;

		if ( !c ) { fetch_url += phplive_query_extra ; }
		phplive_fetch_footprint_image_<?php echo $deptid ?> = new Image ;
		phplive_fetch_footprint_image_<?php echo $deptid ?>.onload = phplive_fetch_footprint_actions_<?php echo $deptid ?> ;
		phplive_fetch_footprint_image_<?php echo $deptid ?>.src = fetch_url ;
	}
	window.phplive_fetch_footprint_actions_<?php echo $deptid ?> = function( )
	{
		var thisflag = phplive_fetch_footprint_image_<?php echo $deptid ?>.width ;

		if ( thisflag == 1 )
		{
			if ( typeof( phplive_interval_footprint_<?php echo $deptid ?> ) != "undefined" )
				clearInterval( phplive_interval_footprint_<?php echo $deptid ?> ) ;
			phplive_interval_footprint_<?php echo $deptid ?> = setTimeout(function( ){ phplive_footprint_track_<?php echo $deptid ?>( ) }, <?php echo $VARS_JS_FOOTPRINT_CHECK ?> * 1000) ;
		}
		else if ( thisflag == 4 )
		{
			// if browser idle too long, clear all interval processes to save on resources
			if ( typeof( phplive_interval_footprint_<?php echo $deptid ?> ) != "undefined" ) { clearInterval( phplive_interval_footprint_<?php echo $deptid ?> ) ; }
			if ( typeof( phplive_interval_fetch_status_<?php echo $deptid ?> ) != "undefined" ) { clearInterval( phplive_interval_fetch_status_<?php echo $deptid ?> ) ; }
			if ( typeof( phplive_interval_status_check_<?php echo $btn ?> ) != "undefined" ) { clearInterval( phplive_interval_status_check_<?php echo $btn ?> ) ; }
		}
	}
	window.phplive_launch_chat_<?php echo $deptid ?> = function( theflag, theminmax, thetheme, theforce, theauto, thewidget )
	{
		// theflag - indication of md5 reset for chat window popout
		// theforce - force embed chat
		var winname = ( theflag ) ? "popup_win" : phplive_unique( ) ;
		var name = email = ""
		var custom_vars = "&custom=" ;
		if ( typeof( theminmax ) == "undefined" ){ theminmax = 1 ; }
		if ( typeof( thetheme ) == "undefined" ){ thetheme = "" ; }

		if ( typeof( phplive_v ) != "undefined" )
		{
			for ( var key in phplive_v )
			{
				if ( key == "name" ) { name = encodeURIComponent( phplive_v["name"] ) ; }
				else if ( key == "email" ) { email = encodeURIComponent( phplive_v["email"] ) ; }
				else { custom_vars += encodeURIComponent( key )+"-_-"+encodeURIComponent( phplive_v[key] )+"-cus-" ; }
			}
		}

		phplive_widget_close( ) ; // incase widget is opened, close it since chat window opened
		if ( ( "<?php echo $redirect_url ?>" != "" ) && !phplive_online_offline_<?php echo $deptid ?> && !theauto ) { location.href = "<?php echo $redirect_url ?>" ; }
		else
		{
			var launch_embed = ( theforce ) ? 1 : 0 ;

			if ( phplive_online_offline_<?php echo $deptid ?> ) { if ( <?php echo $embed_online ?>  && !theflag ) { launch_embed = 1 ; } }
			else { if ( <?php echo $embed_offline ?>  && !theflag ) { launch_embed = 1 ; } }

			// if the device window is smaller then widget width, most likely a mobile browser
			// and better to open in new window for streamlined chat experience (window.innerWidth)
			if ( <?php echo $width_widget ?> > phplive_win_width ) { launch_embed = 0 ; }

			if ( launch_embed && !phplive_IE_cs )
				phplive_widget_embed_launch( phplive_request_url_<?php echo $deptid ?>_embed+"&theme="+thetheme+"&js_name="+name+"&js_email="+email+"&"+custom_vars, theminmax, theauto ) ;
			else if ( !theauto )
			{
				if ( thewidget ) { theflag = 1 ; }
				window.open( phplive_request_url_<?php echo $deptid ?>+"&popout="+theflag+"&theme="+thetheme+"&js_name="+name+"&js_email="+email+"&"+custom_vars, winname, 'scrollbars=no,resizable=yes,menubar=no,location=no,screenX=50,screenY=100,width=<?php echo $width ?>,height=<?php echo $height ?>' ) ;
			}
		}
	}
	phplive_fetch_status_<?php echo $deptid ?>( ) ;
	
	<?php if ( $CONF['foot_log'] == "on" ): ?>
	phplive_footprint_track_<?php echo $deptid ?>( ) ;
	<?php endif ; ?>

}
if ( typeof( phplive_btn_loaded_<?php echo $btn ?> ) == "undefined" )
{
	var phplive_btn_loaded_<?php echo $btn ?> = 1 ;
	var phplive_interval_status_check_<?php echo $btn ?> ;
	var phplive_interval_jquery_check_<?php echo $btn ?> ;
	var phplive_online_offline_prev_<?php echo $btn ?> ;

	window.phplive_image_refresh_<?php echo $btn ?> = function( )
	{
		if ( typeof( phplive_interval_status_check_<?php echo $btn ?> ) != "undefined" ) { clearInterval( phplive_interval_status_check_<?php echo $btn ?> ) ; }

		var image_or_text ;
		if ( phplive_online_offline_<?php echo $deptid ?> )
			image_or_text = ( <?php echo ( $text ) ? 1 : 0 ; ?> ) ? "<?php echo $text ?>" : "<img src=\""+phplive_image_online_<?php echo $deptid ?>+"\" border=0>" ;
		else
		{
			if ( <?php echo $icon_hide ?> ) { image_or_text = "" ; }
			else { image_or_text = ( <?php echo ( $text ) ? 1 : 0 ; ?> ) ? "<?php echo $text ?>" : "<img src=\""+phplive_image_offline_<?php echo $deptid ?>+"\" border=0>" ; }
		}
		if ( phplive_online_offline_prev_<?php echo $btn ?> != image_or_text )
		{
			document.getElementById("phplive_btn_<?php echo $btn ?>").innerHTML = image_or_text ;
			phplive_online_offline_prev_<?php echo $btn ?> = image_or_text ;
		}
		phplive_interval_status_check_<?php echo $btn ?> = setInterval(function( ){ phplive_image_refresh_<?php echo $btn ?>( ) ; }, 5000) ;
	}
	window.phplive_output_image_or_text_<?php echo $btn ?> = function( )
	{
		if ( typeof( phplive_online_offline_<?php echo $deptid ?> ) == "undefined" )
		{
			phplive_interval_status_check_<?php echo $btn ?> = setInterval(function( ){
				if ( typeof( phplive_online_offline_<?php echo $deptid ?> ) != "undefined" )
					phplive_image_refresh_<?php echo $btn ?>( ) ;
			}, 200) ;
		}
		else { phplive_image_refresh_<?php echo $btn ?>( ) ; }
	}
	window.phplive_process_<?php echo $btn ?> = function( )
	{
		if ( phplive_quirks )
		{
			var phplive_btn = document.getElementById('phplive_btn_<?php echo $btn ?>') ;
			if ( ( typeof( phplive_btn.style.position ) != "undefined" ) && phplive_btn.style.position )
				phplive_btn.style.position = "absolute" ;
		}

		if ( typeof( phplive_jquery ) == "undefined" )
		{
			if ( typeof( phplive_interval_jquery_check_<?php echo $btn ?> ) != "undefined" ) { clearInterval( phplive_interval_jquery_check_<?php echo $btn ?> ) ; }
			phplive_interval_jquery_check_<?php echo $btn ?> = setInterval(function( ){
				if ( typeof( phplive_jquery ) != "undefined" )
				{
					clearInterval( phplive_interval_jquery_check_<?php echo $btn ?> ) ;
					phplive_output_image_or_text_<?php echo $btn ?>( ) ;
				}
			}, 200) ;
		}
		else
		{
			if ( typeof( phplive_interval_jquery_check_<?php echo $btn ?> ) != "undefined" ) { clearInterval( phplive_interval_jquery_check_<?php echo $btn ?> ) ; }
			phplive_output_image_or_text_<?php echo $btn ?>( ) ;
		}
	}
	phplive_process_<?php echo $btn ?>( ) ;
}
