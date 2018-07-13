<?php

defined('ABSPATH') or die;

/*
 *
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 *
 */
require_once( dirname( __FILE__ ) . '/options/options.php' );

/*
 * 
 * Add support tab
 *
 */
if ( ! defined('MTS_THEME_WHITE_LABEL') || ! MTS_THEME_WHITE_LABEL ) {
	require_once( dirname( __FILE__ ) . '/options/support.php' );
	$mts_options_tab_support = MTS_Options_Tab_Support::get_instance();
}

/*
 *
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){

	//$sections = array();
	$sections[] = array(
				'title' => __('A Section added by hook', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.', 'sociallyviral' ) . '</p>',
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array()
				);

	return $sections;

}//function
//add_filter('nhp-opts-sections-twenty_eleven', 'add_another_section');


/*
 *
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){

	//$args['dev_mode'] = false;

	return $args;

}//function
//add_filter('nhp-opts-args-twenty_eleven', 'change_framework_args');

/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
$args = array();

//Set it to dev mode to view the class settings/info in the form - default is false
$args['dev_mode'] = false;
//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
//$args['stylesheet_override'] = true;

//Add HTML before the form
//$args['intro_text'] = __('<p>This is the HTML which can be displayed before the form, it isnt required, but more info is always better. Anything goes in terms of markup here, any HTML.</p>', 'sociallyviral' );

if ( ! MTS_THEME_WHITE_LABEL ) {
	//Setup custom links in the footer for share icons
	$args['share_icons']['twitter'] = array(
		'link' => 'http://twitter.com/mythemeshopteam',
		'title' => __( 'Follow Us on Twitter', 'sociallyviral' ),
		'img' => 'fa fa-twitter-square'
	);
	$args['share_icons']['facebook'] = array(
		'link' => 'http://www.facebook.com/mythemeshop',
		'title' => __( 'Like us on Facebook', 'sociallyviral' ),
		'img' => 'fa fa-facebook-square'
	);
}

//Choose to disable the import/export feature
//$args['show_import_export'] = false;

//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$args['opt_name'] = MTS_THEME_NAME;

//Custom menu icon
//$args['menu_icon'] = '';

//Custom menu title for options page - default is "Options"
$args['menu_title'] = __('Theme Options', 'sociallyviral' );

//Custom Page Title for options page - default is "Options"
$args['page_title'] = __('Theme Options', 'sociallyviral' );

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"
$args['page_slug'] = 'theme_options';

//Custom page capability - default is set to "manage_options"
//$args['page_cap'] = 'manage_options';

//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
//$args['page_type'] = 'submenu';

//parent menu - default is set to "themes.php" (Appearance)
//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'themes.php';

//custom page location - default 100 - must be unique or will override other items
$args['page_position'] = 62;

//Custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';

if ( ! MTS_THEME_WHITE_LABEL ) {
	//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition
	$args['help_tabs'][] = array(
		'id' => 'nhp-opts-1',
		'title' => __('Support', 'sociallyviral' ),
		'content' => '<p>' . __('If you are facing any problem with our theme or theme option panel, head over to our', 'sociallyviral' ) . ' <a href="http://community.mythemeshop.com/">Support Forums</a>.</p>'
	);
	$args['help_tabs'][] = array(
		'id' => 'nhp-opts-2',
		'title' => __('Earn Money', 'sociallyviral' ),
		'content' => '<p>' . __('Earn 70% commision on every sale by refering your friends and readers. Join our', 'sociallyviral' ) . ' <a href="http://mythemeshop.com/affiliate-program/">Affiliate Program</a>.</p>'
	);
}

//Set the Help Sidebar for the options page - no sidebar by default
//$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'sociallyviral' );

$mts_patterns = array(
	'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
	'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
	'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
	'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
	'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
	'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
	'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
	'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
	'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
	'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
	'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
	'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
	'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
	'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
	'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
	'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
	'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
	'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
	'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
	'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
	'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
	'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
	'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
	'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
	'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
	'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
	'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
	'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
	'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
	'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
	'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
	'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
	'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
	'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
	'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
	'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
	'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
	'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
	'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
	'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
	'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
	'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
	'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
	'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
	'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
	'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
	'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
	'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
	'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
	'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
	'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
	'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
	'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
	'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
	'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
	'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
	'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
	'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
	'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
	'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
	'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
	'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
	'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
	'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
);

$sections = array();

$sections[] = array(
				'icon' => 'fa fa-cogs',
				'title' => __('General Settings', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('This tab contains common setting options which will be applied to the whole theme.', 'sociallyviral' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_logo',
						'type' => 'upload',
						'title' => __('Logo Image', 'sociallyviral' ),
						'sub_desc' => __('Upload your logo using the Upload Button or insert image URL.', 'sociallyviral' ),
						'return' => 'url'
						),
					array(
						'id' => 'mts_favicon',
						'type' => 'upload',
						'title' => __('Favicon', 'sociallyviral' ),
						'sub_desc' => wp_kses( __('Upload a <strong>32 x 32 px</strong> image that will represent your website\'s favicon.', 'sociallyviral' ), array( 'strong' ) )
						),
					array(
						'id' => 'mts_touch_icon',
						'type' => 'upload',
						'title' => __('Touch icon', 'sociallyviral' ),
						'sub_desc' => wp_kses( __('Upload a <strong>152 x 152 px</strong> image that will represent your website\'s touch icon for iOS 2.0+ and Android 2.1+ devices.', 'sociallyviral' ), array( 'strong' ) )
						),
					array(
						'id' => 'mts_metro_icon',
						'type' => 'upload',
						'title' => __('Metro icon', 'sociallyviral' ),
						'sub_desc' => wp_kses( __('Upload a <strong>144 x 144 px</strong> image that will represent your website\'s IE 10 Metro tile icon.', 'sociallyviral' ), array( 'strong' ) )
						),
					array(
						'id' => 'mts_twitter_username',
						'type' => 'text',
						'title' => __('Twitter Username', 'sociallyviral' ),
						'sub_desc' => __('Enter your Username here.', 'sociallyviral' ),
						),
					array(
						'id' => 'mts_feedburner',
						'type' => 'text',
						'title' => __('FeedBurner URL', 'sociallyviral' ),
						'sub_desc' => wp_kses( __('Enter your FeedBurner\'s URL here, ex: <strong>http://feeds.feedburner.com/mythemeshop</strong> and your main feed (http://example.com/feed) will get redirected to the FeedBurner ID entered here.)', 'sociallyviral' ), array( 'strong', 'a' => array( 'href' => array() ) ) ),
						'validate' => 'url'
						),
					array(
						'id' => 'mts_header_code',
						'type' => 'textarea',
						'title' => __('Header Code', 'sociallyviral' ),
						'sub_desc' => wp_kses( __('Enter the code which you need to place <strong>before closing &lt;/head&gt; tag</strong>. (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)', 'sociallyviral' ), array( 'strong', 'a' => array( 'href' => array() ) ) )
						),
					array(
						'id' => 'mts_analytics_code',
						'type' => 'textarea',
						'title' => __('Footer Code', 'sociallyviral' ),
						'sub_desc' => wp_kses( __('Enter the codes which you need to place in your footer. <strong>(ex: Google Analytics, Clicky, STATCOUNTER, Woopra, Histats, etc.)</strong>.', 'sociallyviral' ), array( 'strong', 'a' => array( 'href' => array() ) ) )
						),
					array(
                        'id' => 'mts_pagenavigation_type',
                        'type' => 'radio',
                        'title' => __('Pagination Type', 'sociallyviral' ),
                        'sub_desc' => __('Select pagination type.', 'sociallyviral' ),
                        'options' => array(
                                        '0'=> __('Default (Next / Previous)', 'sociallyviral' ),
                                        '1' => __('Numbered (1 2 3 4...)', 'sociallyviral' ),
                                        '2' => __( 'AJAX (Load More Button)', 'sociallyviral' ),
                                        '3' => __( 'AJAX (Auto Infinite Scroll)', 'sociallyviral' ) ),
                        'std' => '3'
                        ),
                    array(
                        'id' => 'mts_ajax_search',
                        'type' => 'button_set',
                        'title' => __('AJAX Quick search', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Enable or disable search results appearing instantly below the search form', 'sociallyviral' ),
						'std' => '0'
                        ),
					array(
						'id' => 'mts_responsive',
						'type' => 'button_set',
						'title' => __('Responsiveness', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('MyThemeShop themes are responsive, which means they adapt to tablet and mobile devices, ensuring that your content is always displayed beautifully no matter what device visitors are using. Enable or disable responsiveness using this option.', 'sociallyviral' ),
						'std' => '1'
						),
					array(
						'id' => 'mts_rtl',
						'type' => 'button_set',
						'title' => __('Right To Left Language Support', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Enable this option for right-to-left sites.', 'sociallyviral' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_shop_products',
						'type' => 'text',
						'title' => __('No. of Products', 'sociallyviral' ),
						'sub_desc' => __('Enter the total number of products which you want to show on shop page (WooCommerce plugin must be enabled).', 'sociallyviral' ),
						'validate' => 'numeric',
						'std' => '9',
						'class' => 'small-text'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-bolt',
				'title' => __('Performance', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('This tab contains performance-related options which can help speed up your website.', 'sociallyviral' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_prefetching',
						'type' => 'button_set',
						'title' => __('Prefetching', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Enable or disable prefetching. If user is on homepage, then single page will load faster and if user is on single page, homepage will load faster in modern browsers.', 'sociallyviral' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_lazy_load',
						'type' => 'button_set_hide_below',
						'title' => __('Lazy Load', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Delay loading of images outside of viewport, until user scrolls to them.', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'std' => '0',
						'args' => array('hide' => 2)
						),
					array(
						'id' => 'mts_lazy_load_thumbs',
						'type' => 'button_set',
						'title' => __('Lazy load fatured images', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Enable or disable Lazy load of featured images across site.', 'sociallyviral' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_lazy_load_content',
						'type' => 'button_set',
						'title' => __('Lazy load post content images', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Enable or disable Lazy load of images inside post/page content.', 'sociallyviral' ),
						'std' => '0'
						),
					array(
						'id' => 'mts_async_js',
						'type' => 'button_set',
						'title' => __('Async JavaScript', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Add <code>async</code> attribute to script tags to improve page download speed.', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'std' => '1',
						),
					array(
						'id' => 'mts_remove_ver_params',
						'type' => 'button_set',
						'title' => __('Remove ver parameters', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Remove <code>ver</code> parameter from CSS and JS file calls. It may improve speed in some browsers which do not cache files having the parameter.', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'std' => '1',
						),
					array(
						'id' => 'mts_optimize_wc',
						'type' => 'button_set',
						'title' => __('Optimize WooCommerce scripts', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Load WooCommerce scripts and styles only on WooCommerce pages (WooCommerce plugin must be enabled).', 'sociallyviral' ),
						'std' => '0'
						),
					'cache_message' => array(
						'id' => 'mts_cache_message',
						'type' => 'info',
						'title' => __('Use Cache', 'sociallyviral' ),
						'desc' => sprintf( __('A <a href="%1$s">cache plugin</a> can increase page download speed dramatically. We recommend using <a href="%2$s" class="thickbox" title="W3 Total Cache">W3 Total Cache</a> or <a href="%3$s" class="thickbox" title="WP Super Cache">WP Super Cache</a>.', 'sociallyviral' ), admin_url( 'plugin-install.php?tab=search&s=cache' ), admin_url( 'plugin-install.php?tab=plugin-information&plugin=w3-total-cache&TB_iframe=true&width=772&height=574' ), admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-super-cache&TB_iframe=true&width=772&height=574' ) ),
						),
				)
			);

// Check for cache plugins
if (strstr(join(';', get_option('active_plugins')), 'cache')) {
	unset($sections[1]['fields']['cache_message']);
}

$sections[] = array(
				'icon' => 'fa fa-adjust',
				'title' => __('Styling Options', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('Control the visual appearance of your theme, such as colors, layout and patterns, from here.', 'sociallyviral' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_color_scheme',
						'type' => 'color',
						'title' => __('Color Scheme 1', 'sociallyviral' ),
						'sub_desc' => __('The theme comes with unlimited color schemes for your theme\'s styling.', 'sociallyviral' ),
						'std' => '#33bcf2'
						),
					array(
						'id' => 'mts_color_scheme_2',
						'type' => 'color',
						'title' => __('Color Scheme 2', 'sociallyviral' ),
						'sub_desc' => __('The theme comes with unlimited color schemes for your theme\'s styling.', 'sociallyviral' ),
						'std' => '#f47555'
						),
					array(
						'id' => 'mts_layout',
						'type' => 'radio_img',
						'title' => __('Layout Style', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Choose the <strong>default sidebar position</strong> for your site. The position of the sidebar for individual posts can be set in the post editor.', 'sociallyviral' ) ),
						'options' => array(
										'cslayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/cs.png'),
										'sclayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/sc.png')
											),
						'std' => 'cslayout'
						),
					array(
						'id' => 'mts_background',
						'type' => 'background',
						'title' => __('Site Background', 'sociallyviral' ),
						'sub_desc' => __('Set background color, pattern and image from here.', 'sociallyviral' ),
						'options' => array(
							'color'         => '',            // false to disable, not needed otherwise
							'image_pattern' => $mts_patterns, // false to disable, array of options otherwise ( required !!! )
							'image_upload'  => '',            // false to disable, not needed otherwise
							'repeat'        => array(),       // false to disable, array of options to override default ( optional )
							'attachment'    => array(),       // false to disable, array of options to override default ( optional )
							'position'      => array(),       // false to disable, array of options to override default ( optional )
							'size'          => array(),       // false to disable, array of options to override default ( optional )
							'gradient'      => '',            // false to disable, not needed otherwise
							'parallax'      => array(),       // false to disable, array of options to override default ( optional )
						),
						'std' => array(
							'color'         => '#f0ede9',
							'use'           => 'pattern',
							'image_pattern' => 'nobg',
							'image_upload'  => '',
							'repeat'        => 'repeat',
							'attachment'    => 'scroll',
							'position'      => 'left top',
							'size'          => 'cover',
							'gradient'      => array('from' => '#ffffff', 'to' => '#000000', 'direction' => 'horizontal' ),
							'parallax'      => '0',
						)
					),
					array(
						'id' => 'mts_custom_css',
						'type' => 'textarea',
						'title' => __('Custom CSS', 'sociallyviral' ),
						'sub_desc' => __('You can enter custom CSS code here to further customize your theme. This will override the default CSS used on your site.', 'sociallyviral' )
					),
					array(
						'id' => 'mts_lightbox',
						'type' => 'button_set',
						'title' => __('Lightbox', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('A lightbox is a stylized pop-up that allows your visitors to view larger versions of images without leaving the current page. You can enable or disable the lightbox here.', 'sociallyviral' ),
						'std' => '0'
					),

				)
			);
$sections[] = array(
				'icon' => 'fa fa-credit-card',
				'title' => __('Header', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('From here, you can control the elements of header section.', 'sociallyviral' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_header_section2',
						'type' => 'button_set',
						'title' => __('Show Logo', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => wp_kses_post( __('Use this button to Show or Hide <strong>Logo</strong> completely.', 'sociallyviral' ) ),
						'std' => '1'
						),
					array(
						'id' => 'mts_header_search',
						'type' => 'button_set',
						'title' => __('Header Search Form', 'sociallyviral'),
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to enable <strong>Header Search form</strong>.', 'sociallyviral'),
						'std' => '1'
						),
					array(
						'id' => 'mts_sticky_nav',
						'type' => 'button_set',
						'title' => __('Floating Navigation Menu', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => wp_kses_post( __('Use this button to enable <strong>Floating Navigation Menu</strong>.', 'sociallyviral' ) ),
						'std' => '0'
						),
                    array(
						'id' => 'mts_show_primary_nav',
						'type' => 'button_set',
						'title' => __('Show Navigation Menu', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => wp_kses_post( __('Use this button to enable <strong>Primary Navigation Menu</strong>.', 'sociallyviral' ) ),
						'std' => '1'
						),
					array(
						'id' => 'mts_show_header_social',
						'type' => 'button_set_hide_below',
						'title' => __('Show header social icons', 'sociallyviral'),
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to show or hide Header Social Icons.', 'sociallyviral'),
						'std' => '1'
						),
					array(
                     	'id' => 'mts_header_social',
                     	'title' => __('Header Social Icons', 'sociallyviral'),
                     	'sub_desc' => __( 'Add Social Media icons in header.', 'sociallyviral' ),
                     	'type' => 'group',
                     	'groupname' => __('Header Icons', 'sociallyviral'), // Group name
                     	'subfields' =>
                            array(
                                array(
                                    'id' => 'mts_header_icon_title',
            						'type' => 'text',
            						'title' => __('Title', 'sociallyviral'),
            						),
								array(
                                    'id' => 'mts_header_icon',
            						'type' => 'icon_select',
            						'title' => __('Icon', 'sociallyviral')
            						),
								array(
                                    'id' => 'mts_header_icon_link',
            						'type' => 'text',
            						'title' => __('URL', 'sociallyviral'),
            						),
								array(
									'id' => 'mts_header_icon_bg_color',
									'type' => 'color',
									'title' => __('Background Color', 'sociallyviral'),
									'sub_desc' => __('Pick a color for the icon.', 'sociallyviral'),
									'std' => '#375593'
									),
			                	),
                        'std' => array(
            					'facebook' => array(
            						'group_title' => 'Facebook',
            						'group_sort' => '1',
            						'mts_header_icon_title' => 'Facebook',
            						'mts_header_icon' => 'facebook',
            						'mts_header_icon_link' => '#',
            						'mts_header_icon_bg_color' => '#375593'
            					),
            					'twitter' => array(
            						'group_title' => 'Twitter',
            						'group_sort' => '2',
            						'mts_header_icon_title' => 'Twitter',
            						'mts_header_icon' => 'twitter',
            						'mts_header_icon_link' => '#',
            						'mts_header_icon_bg_color' => '#0eb6f6'
            					),
            					'gplus' => array(
            						'group_title' => 'Google Plus',
            						'group_sort' => '3',
            						'mts_header_icon_title' => 'Google Plus',
            						'mts_header_icon' => 'google-plus',
            						'mts_header_icon_link' => '#',
            						'mts_header_icon_bg_color' => '#dd4b39'
            					),
            					'youtube' => array(
            						'group_title' => 'YouTube',
            						'group_sort' => '4',
            						'mts_header_icon_title' => 'YouTube',
            						'mts_header_icon' => 'youtube-play',
            						'mts_header_icon_link' => '#',
            						'mts_header_icon_bg_color' => '#e32c26'
            					)
            				)
                        ),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-table',
				'title' => __('Footer', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('From here, you can control the elements of Footer section.', 'sociallyviral' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_top_footer',
						'type' => 'button_set_hide_below',
						'title' => __('Footer Widgets', 'sociallyviral' ),
						'sub_desc' => __('Enable or disable footer widgets with this option.', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'std' => '0'
						),
                        array(
						'id' => 'mts_top_footer_num',
						'type' => 'button_set',
                        'class' => 'green',
						'title' => __('Footer Widget Columns', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Choose the number of widget areas in the <strong>footer</strong>', 'sociallyviral' ) ),
						'options' => array(
							'3' => __( '3 Widgets', 'sociallyviral' ),
							'4' => __( '4 Widgets', 'sociallyviral' ),
						),
						'std' => '3'
						),
					array(
						'id' => 'mts_footer_nav',
						'type' => 'button_set',
						'title' => __('Show Footer Navigation', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => wp_kses_post( __('Use this button to Show or Hide <strong>Footer Navigation</strong> completely.', 'sociallyviral' ) ),
						'std' => '1'
						),
					array(
						'id' => 'mts_copyrights',
						'type' => 'textarea',
						'title' => __('Copyrights Text', 'sociallyviral' ),
						'sub_desc' => __( 'You can change or remove our link from footer and use your own custom text.', 'sociallyviral' ) . ( MTS_THEME_WHITE_LABEL ? '' : ' '.wp_kses( __('(You can also use your affiliate link to <strong>earn 70% of sales</strong>. Example: <a href="https://mythemeshop.com/go/aff/aff" target="_blank">https://mythemeshop.com/?ref=username</a>)', 'sociallyviral' ), array( 'strong', 'a' => array( 'href' => array() ) ) ) ),
						'std' => MTS_THEME_WHITE_LABEL ? null : __( 'Theme by <a href="http://mythemeshop.com/" rel="nofollow">MyThemeShop</a>', 'sociallyviral' )
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-home',
				'title' => __('Homepage', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('From here, you can control the elements of the homepage.', 'sociallyviral' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_home_layout',
						'type' => 'radio_img',
						'title' => __('Home Layout Style', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Choose the <strong>layout design</strong> for your homepage.', 'sociallyviral' ) ),
						'options' => array(
										'h1' => array('img' => NHP_OPTIONS_URL.'img/layouts/h1.jpg'),
										'h2' => array('img' => NHP_OPTIONS_URL.'img/layouts/h2.jpg')
											),
						'std' => 'h1'
						),
					array(
						'id' => 'mts_home_layout_big_post',
						'type' => 'button_set',
						'title' => __('Larger First Post', 'sociallyviral' ),
						'options' => array( '' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => wp_kses_post( __('<strong>Enable or Disable</strong> larger first post.', 'sociallyviral' ) ),
						'std' => '1',
						'reset_at_version' => '2.0.9'
						),
					array(
						'id' => 'mts_featured_slider',
						'type' => 'button_set_hide_below',
						'title' => __('Homepage Slider', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => wp_kses_post( __('<strong>Enable or Disable</strong> homepage slider with this button. The slider will show recent articles from the selected categories.', 'sociallyviral' ) ),
						'std' => '0',
                        'args' => array('hide' => 3)
						),
						array(
						'id' => 'mts_featured_slider_cat',
						'type' => 'cats_multi_select',
						'title' => __('Slider Category(s)', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Select a category from the drop-down menu, latest articles from this category will be shown <strong>in the slider</strong>.', 'sociallyviral' ) ),
						),
                        array(
						'id' => 'mts_featured_slider_num',
						'type' => 'text',
                        'class' => 'small-text',
						'title' => __('Number of posts', 'sociallyviral' ),
						'sub_desc' => __('Enter the number of posts to show in the slider', 'sociallyviral' ),
                        'std' => '3',
                        'args' => array('type' => 'number')
						),
                        array(
                        'id'        => 'mts_custom_slider',
                        'type'      => 'group',
                        'title'     => __('Custom Slider', 'sociallyviral' ),
                        'sub_desc'  => __('With this option you can set up a slider with custom image and text instead of the default slider automatically generated from your posts. (Recommended width 1170px & height larger than 400px)', 'sociallyviral' ),
                        'groupname' => __('Slider', 'sociallyviral' ), // Group name
                        'subfields' =>
                            array(
                                array(
                                    'id' => 'mts_custom_slider_title',
            						'type' => 'text',
            						'title' => __('Title', 'sociallyviral' ),
            						'sub_desc' => __('Title of the slide', 'sociallyviral' ),
                                    ),
                                array(
                                    'id' => 'mts_custom_slider_image',
            						'type' => 'upload',
            						'title' => __('Image', 'sociallyviral' ),
            						'sub_desc' => __('Upload or select an image for this slide', 'sociallyviral' ),
            						'return' => 'id',
            						),
                                array('id' => 'mts_custom_slider_text',
            						'type' => 'text',
            						'title' => __('Text', 'sociallyviral' ),
            						'sub_desc' => __('Description of the slide', 'sociallyviral' ),
                                    ),
                                array('id' => 'mts_custom_slider_link',
            						'type' => 'text',
            						'title' => __('Link', 'sociallyviral' ),
            						'sub_desc' => __('Insert a link URL for the slide', 'sociallyviral' ),
                                    'std' => '#'
                                    ),
                            ),
                        ),
                    array(
                        'id'        => 'mts_featured_categories',
                        'type'      => 'group',
                        'title'     => __('Featured Categories', 'sociallyviral' ),
                        'sub_desc'  => __('Select categories appearing on the homepage.', 'sociallyviral' ),
                        'groupname' => __('Section', 'sociallyviral' ), // Group name
                        'subfields' =>
                            array(
                                array(
                                    'id' => 'mts_featured_category',
            						'type' => 'cats_select',
            						'title' => __('Category', 'sociallyviral' ),
            						'sub_desc' => __('Select a category or the latest posts for this section', 'sociallyviral' ),
									'std' => 'latest',
                                    'args' => array('include_latest' => 1, 'hide_empty' => 0),
            						),
                                array(
                                    'id' => 'mts_featured_category_postsnum',
            						'type' => 'text',
                                    'class' => 'small-text',
            						'title' => __('Number of posts', 'sociallyviral' ),
            						'sub_desc' => sprintf( wp_kses_post( __('Enter the number of posts to show in this section.<br/><strong>For Latest Posts</strong>, this setting will be ignored, and number set in <a href="%s" target="_blank">Settings&nbsp;&gt;&nbsp;Reading</a> will be used instead.', 'sociallyviral' ) ), admin_url('options-reading.php')),
                                    'std' => '5',
                                    'args' => array('type' => 'number')
            						),
                            ),
            				'std' => array(
            					'1' => array(
            						'group_title' => '',
            						'group_sort' => '1',
            						'mts_featured_category' => 'latest',
            						'mts_featured_category_postsnum' => get_option('posts_per_page')
            					)
            				)
                        ),
					array(
                        'id'       => 'mts_home_headline_meta_info',
                        'type'     => 'layout',
                        'title'    => __('HomePage Post Meta Info', 'sociallyviral' ),
                        'sub_desc' => __('Organize how you want the post meta info to appear on the homepage', 'sociallyviral' ),
                        'options'  => array(
                            'enabled'  => array(
                                'date'     => __('Date', 'sociallyviral' ),
                                'category' => __('Categories', 'sociallyviral' ),
                            ),
                            'disabled' => array(
                                'author'   => __('Author Name', 'sociallyviral' ),
                                'comment'  => __('Comment Count', 'sociallyviral' )
                            )
                        ),
                        'std'  => array(
                            'enabled'  => array(
                                'date'     => __('Date', 'sociallyviral' ),
                                'category' => __('Categories', 'sociallyviral' ),
                            ),
                            'disabled' => array(
                                'author'   => __('Author Name', 'sociallyviral' ),
                                'comment'  => __('Comment Count', 'sociallyviral' )
                            )
                        ),
                        'reset_at_version' => '2.0'
                    ),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-file-text',
				'title' => __('Single Posts', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('From here, you can control the appearance and functionality of your single posts page.', 'sociallyviral' ) . '</p>',
				'fields' => array(
					array(
                        'id'       => 'mts_single_post_layout',
                        'type'     => 'layout2',
                        'title'    => __('Single Post Layout', 'sociallyviral' ),
                        'sub_desc' => __('Customize the look of single posts', 'sociallyviral' ),
                        'options'  => array(
                            'enabled'  => array(
                                'content'   => array(
                                	'label' 	=> __('Post Content', 'sociallyviral' ),
                                	'subfields'	=> array(

                                	)
                                ),
                                'related'   => array(
                                	'label' 	=> __('Related Posts', 'sociallyviral' ),
                                	'subfields'	=> array(
					        			array(
					        				'id' => 'mts_related_posts_taxonomy',
					        				'type' => 'button_set',
					        				'title' => __('Related Posts Taxonomy', 'sociallyviral' ) ,
					        				'options' => array(
					        					'tags' => __( 'Tags', 'sociallyviral' ),
					        					'categories' => __( 'Categories', 'sociallyviral' )
					        				) ,
					        				'class' => 'green',
					        				'sub_desc' => __('Related Posts based on tags or categories.', 'sociallyviral' ) ,
					        				'std' => 'categories'
					        			),
					        			array(
					        				'id' => 'mts_related_postsnum',
					        				'type' => 'text',
					        				'class' => 'small-text',
					        				'title' => __('Number of related posts', 'sociallyviral' ) ,
					        				'sub_desc' => __('Enter the number of posts to show in the related posts section.', 'sociallyviral' ) ,
					        				'std' => '6',
					        				'args' => array(
					        					'type' => 'number'
					        				)
					        			),

                                	)
                                ),
                                'author'   => array(
                                	'label' 	=> __('Author Box', 'sociallyviral' ),
                                	'subfields'	=> array(

                                	)
                                ),
                            ),
                            'disabled' => array(
                            	'tags'   => array(
                                	'label' 	=> __('Tags', 'sociallyviral' ),
                                	'subfields'	=> array(
                                	)
                                ),
                            )
                        )
                    ),
					array(
						'id' => 'mts_single_headline_meta',
						'type' => 'button_set_hide_below',
						'title' => __('Post Meta Info.', 'sociallyviral'),
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide Post Meta Info <strong>Author name and Categories</strong>.', 'sociallyviral'),
						'std' => '1'
						),
					array(
 						'id' => 'mts_single_headline_meta_info',
 						'type' => 'multi_checkbox',
 						'title' => __('Meta Info to Show', 'sociallyviral'),
 						'sub_desc' => __('Choose What Meta Info to Show.', 'sociallyviral'),
 						'options' => array('author' => __('Author Name','sociallyviral'),'date' => __('Date','sociallyviral'),'category' => __('Categories','sociallyviral'),'comment' => __('Comment Count','sociallyviral')),
 						'std' => array('author' => '1', 'date' => '1', 'category' => '1', 'comment' => '1')
 						),
					array(
						'id' => 'mts_breadcrumb',
						'type' => 'button_set',
						'title' => __('Breadcrumbs', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Breadcrumbs are a great way to make your site more user-friendly. You can enable them by checking this box.', 'sociallyviral' ),
						'std' => '1'
						),
					array(
						'id' => 'mts_author_comment',
						'type' => 'button_set',
						'title' => __('Highlight Author Comment', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Use this button to highlight author comments.', 'sociallyviral' ),
						'std' => '1'
						),
					array(
						'id' => 'mts_comment_date',
						'type' => 'button_set',
						'title' => __('Date in Comments', 'sociallyviral' ),
						'options' => array( '0' => __( 'Off', 'sociallyviral' ), '1' => __( 'On', 'sociallyviral' ) ),
						'sub_desc' => __('Use this button to show the date for comments.', 'sociallyviral' ),
						'std' => '1'
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-group',
				'title' => __('Social Buttons', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('Enable or disable social sharing buttons on single posts using these buttons.', 'sociallyviral' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_social_button_position',
						'type' => 'button_set',
						'title' => __('Social Sharing Buttons Position', 'sociallyviral' ),
						'options' => array('top' => __('Above Content', 'sociallyviral' ), 'bottom' => __('Below Content', 'sociallyviral' ), 'both' => __('Both', 'sociallyviral' ), 'floating' => __('Floating', 'sociallyviral' )),
						'sub_desc' => __('Choose position for Social Sharing Buttons.', 'sociallyviral' ),
						'std' => 'both',
						'class' => 'green'
					),
					array(
						'id' => 'mts_social_buttons_on_pages',
						'type' => 'button_set',
						'title' => __('Social Sharing Buttons on Pages', 'sociallyviral' ),
						'options' => array('0' => __('Off', 'sociallyviral' ), '1' => __('On', 'sociallyviral' )),
						'sub_desc' => __('Enable the sharing buttons for pages too, not just posts.', 'sociallyviral' ),
						'std' => '0',
					),
					array(
                        'id'       => 'mts_social_buttons',
                        'type'     => 'layout',
                        'title'    => __('Social Media Buttons', 'sociallyviral' ),
                        'sub_desc' => __('Organize how you want the social sharing buttons to appear on single posts', 'sociallyviral' ),
                        'options'  => array(
                            'enabled'  => array(
                            	'facebook'  => __('Facebook Like', 'sociallyviral' ),
                            	'gplus'     => __('Google Plus', 'sociallyviral' ),
                                'twitter'   => __('Twitter', 'sociallyviral' ),
                                'reddit' 	=> __('Reddit', 'sociallyviral' ),
                                'pinterest' => __('Pinterest', 'sociallyviral' ),
                                'stumble'   => __('StumbleUpon', 'sociallyviral' ),
                                'email' 	=> __('Email', 'sociallyviral' ),
                            ),
                            'disabled' => array(
                            )
                        ),
                        'std'  => array(
                            'enabled'  => array(
                            	'facebook'  => __('Facebook Like', 'sociallyviral' ),
                            	'gplus'     => __('Google Plus', 'sociallyviral' ),
                                'twitter'   => __('Twitter', 'sociallyviral' ),
                                'reddit' 	=> __('Reddit', 'sociallyviral' ),
                                'pinterest' => __('Pinterest', 'sociallyviral' ),
                                'stumble'   => __('StumbleUpon', 'sociallyviral' ),
                                'email' 	=> __('Email', 'sociallyviral' ),
                            ),
                            'disabled' => array(
                            )
                        ),
                        'reset_at_version' => '2.0'
                    ),
				)
			);
$sections[] = array(
				'icon' => 'fa fa-bar-chart-o',
				'title' => __('Ad Management', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('Now, ad management is easy with our options panel. You can control everything from here, without using separate plugins.', 'sociallyviral' ) . '</p>',
				'fields' => array(
					array(
						'id' => 'mts_header_adcode',
						'type' => 'textarea',
						'title' => __('Header Ad', 'sociallyviral' ),
						'sub_desc' => __('This Ad will appear just after header menu. Recommended size: 728x90.', 'sociallyviral' )
						),
					array(
						'id' => 'mts_posttop_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Title', 'sociallyviral' ),
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below your article title on single posts.', 'sociallyviral' )
						),
					array(
						'id' => 'mts_posttop_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'sociallyviral' ),
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad. Enter 0 to disable this feature.', 'sociallyviral' ),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text',
                        'args' => array('type' => 'number')
						),
					array(
						'id' => 'mts_postend_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Content', 'sociallyviral' ),
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below the post content on single posts.', 'sociallyviral' )
						),
					array(
						'id' => 'mts_postend_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'sociallyviral' ),
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Content Ad. Enter 0 to disable this feature.', 'sociallyviral' ),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text',
                        'args' => array('type' => 'number')
						),
					)
				);
$sections[] = array(
				'icon' => 'fa fa-columns',
				'title' => __('Sidebars', 'sociallyviral' ),
				'desc' => '<p class="description">' . __('Now you have full control over the sidebars. Here you can manage sidebars and select one for each section of your site, or select a custom sidebar on a per-post basis in the post editor.', 'sociallyviral' ) . '<br></p>',
                'fields' => array(
                    array(
                        'id'        => 'mts_custom_sidebars',
                        'type'      => 'group', //doesn't need to be called for callback fields
                        'title'     => __('Custom Sidebars', 'sociallyviral' ),
                        'sub_desc'  => wp_kses_post( __('Add custom sidebars. <strong style="font-weight: 800;">You need to save the changes to use the sidebars in the dropdowns below.</strong><br />You can add content to the sidebars in Appearance &gt; Widgets.', 'sociallyviral' ) ),
                        'groupname' => __('Sidebar', 'sociallyviral' ), // Group name
                        'subfields' =>
                            array(
                                array(
                                    'id' => 'mts_custom_sidebar_name',
            						'type' => 'text',
            						'title' => __('Name', 'sociallyviral' ),
            						'sub_desc' => __('Example: Homepage Sidebar', 'sociallyviral' )
            						),
                                array(
                                    'id' => 'mts_custom_sidebar_id',
            						'type' => 'text',
            						'title' => __('ID', 'sociallyviral' ),
            						'sub_desc' => __('Enter a unique ID for the sidebar. Use only alphanumeric characters, underscores (_) and dashes (-), eg. "sidebar-home"', 'sociallyviral' ),
            						'std' => 'sidebar-'
            						),
                            ),
                        ),
                    array(
						'id' => 'mts_sidebar_for_home',
						'type' => 'sidebars_select',
						'title' => __('Homepage', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the homepage.', 'sociallyviral' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_post',
						'type' => 'sidebars_select',
						'title' => __('Single Post', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the single posts. If a post has a custom sidebar set, it will override this.', 'sociallyviral' ),
                        'args' => array('exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_page',
						'type' => 'sidebars_select',
						'title' => __('Single Page', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the single pages. If a page has a custom sidebar set, it will override this.', 'sociallyviral' ),
                        'args' => array('exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_archive',
						'type' => 'sidebars_select',
						'title' => __('Archive', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the archives. Specific archive sidebars will override this setting (see below).', 'sociallyviral' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_category',
						'type' => 'sidebars_select',
						'title' => __('Category Archive', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the category archives.', 'sociallyviral' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_tag',
						'type' => 'sidebars_select',
						'title' => __('Tag Archive', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the tag archives.', 'sociallyviral' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_date',
						'type' => 'sidebars_select',
						'title' => __('Date Archive', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the date archives.', 'sociallyviral' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_author',
						'type' => 'sidebars_select',
						'title' => __('Author Archive', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the author archives.', 'sociallyviral' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_search',
						'type' => 'sidebars_select',
						'title' => __('Search', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the search results.', 'sociallyviral' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),
                    array(
						'id' => 'mts_sidebar_for_notfound',
						'type' => 'sidebars_select',
						'title' => __('404 Error', 'sociallyviral' ),
						'sub_desc' => __('Select a sidebar for the 404 Not found pages.', 'sociallyviral' ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => ''
						),

                    array(
						'id' => 'mts_sidebar_for_shop',
						'type' => 'sidebars_select',
						'title' => __('Shop Pages', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Select a sidebar for Shop main page and product archive pages (WooCommerce plugin must be enabled). Default is <strong>Shop Page Sidebar</strong>.', 'sociallyviral' ) ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => 'shop-sidebar'
						),
                    array(
						'id' => 'mts_sidebar_for_product',
						'type' => 'sidebars_select',
						'title' => __('Single Product', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Select a sidebar for single products (WooCommerce plugin must be enabled). Default is <strong>Single Product Sidebar</strong>.', 'sociallyviral' ) ),
                        'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header', 'widget-home', 'shop-sidebar', 'product-sidebar')),
                        'std' => 'product-sidebar'
						),
                    ),
				);
//$sections[] = array(
//				'icon' => NHP_OPTIONS_URL.'img/glyphicons/fontsetting.png',
//				'title' => __('Fonts', 'sociallyviral' ),
//				'desc' => __('<p class="description"><div class="controls">You can find theme font options under the Appearance Section named <a href="themes.php?page=typography"><b>Theme Typography</b></a>, which will allow you to configure the typography used on your site.<br></div></p>', 'sociallyviral' ),
//				);
$sections[] = array(
				'icon' => 'fa fa-list-alt',
				'title' => __('Navigation', 'sociallyviral' ),
				'desc' => '<p class="description">' . wp_kses_post( __('Navigation settings can now be modified from the <a href="nav-menus.php"><b>Menus Section</b></a>.', 'sociallyviral' ) ) . '<br></p>',
				'fields' => array(
					array(
						'id' => 'mts_navbar_primary-menu_for_home',
						'type' => 'menu_select',
						'title' => __('Homepage (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the homepage.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_home',
						'type' => 'menu_select',
						'title' => __('Homepage (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the homepage.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_post',
						'type' => 'menu_select',
						'title' => __('Single Post (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the single posts. If a post has a custom primary navbar set, it will override this.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_post',
						'type' => 'menu_select',
						'title' => __('Single Post (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the single posts. If a post has a custom mobile navbar set, it will override this.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_page',
						'type' => 'menu_select',
						'title' => __('Single Page (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the single pages. If a page has a custom primary navbar set, it will override this.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_page',
						'type' => 'menu_select',
						'title' => __('Single Page (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the single pages. If a page has a custom mobile navbar set, it will override this.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_archive',
						'type' => 'menu_select',
						'title' => __('Archive (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the archives. Specific archive navbars will override this setting (see below).', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_archive',
						'type' => 'menu_select',
						'title' => __('Archive (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the archives. Specific archive navbars will override this setting (see below).', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_category',
						'type' => 'menu_select',
						'title' => __('Category Archive (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the category archives.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_category',
						'type' => 'menu_select',
						'title' => __('Category Archive (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the category archives.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_tag',
						'type' => 'menu_select',
						'title' => __('Tag Archive (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the tag archives.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_tag',
						'type' => 'menu_select',
						'title' => __('Tag Archive (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the tag archives.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_date',
						'type' => 'menu_select',
						'title' => __('Date Archive (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the date archives.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_date',
						'type' => 'menu_select',
						'title' => __('Date Archive (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the date archives.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_author',
						'type' => 'menu_select',
						'title' => __('Author Archive (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the author archives.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_author',
						'type' => 'menu_select',
						'title' => __('Author Archive (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the author archives.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_search',
						'type' => 'menu_select',
						'title' => __('Search (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the search results.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_search',
						'type' => 'menu_select',
						'title' => __('Search (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the search results.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_notfound',
						'type' => 'menu_select',
						'title' => __('404 Error (Primary)', 'sociallyviral' ),
						'sub_desc' => __('Select a primary navbar for the 404 Not found pages.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_notfound',
						'type' => 'menu_select',
						'title' => __('404 Error (Mobile)', 'sociallyviral' ),
						'sub_desc' => __('Select a mobile navbar for the 404 Not found pages.', 'sociallyviral' ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_shop',
						'type' => 'menu_select',
						'title' => __('Shop Pages (Primary)', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Select a primary navbar for Shop main page and product archive pages (WooCommerce plugin must be enabled).', 'sociallyviral' ) ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_shop',
						'type' => 'menu_select',
						'title' => __('Shop Pages (Mobile)', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Select a mobile navbar for Shop main page and product archive pages (WooCommerce plugin must be enabled).', 'sociallyviral' ) ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_primary-menu_for_product',
						'type' => 'menu_select',
						'title' => __('Single Product (Primary)', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Select a primary navbar for single products (WooCommerce plugin must be enabled).', 'sociallyviral' ) ),
						'std' => ''
					),
					array(
						'id' => 'mts_navbar_mobile_for_product',
						'type' => 'menu_select',
						'title' => __('Single Product (Mobile)', 'sociallyviral' ),
						'sub_desc' => wp_kses_post( __('Select a mobile navbar for single products (WooCommerce plugin must be enabled).', 'sociallyviral' ) ),
						'std' => ''
					),
				),
);


	$tabs = array();

    $args['presets'] = array();
	$args['show_translate'] = false;
    include('theme-presets.php');

	global $NHP_Options;
	$NHP_Options = new NHP_Options($sections, $args, $tabs);

}//function
add_action('init', 'setup_framework_options', 0);

/*
 *
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value){
	print_r($field);
	print_r($value);

}//function

/*
 *
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){

	$error = false;
	$value =  'just testing';
	/*
	do your validation

	if(something){
		$value = $value;
	}elseif(somthing else){
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
	}
	*/
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;

}//function

/*--------------------------------------------------------------------
 *
 * Default Font Settings
 *
 --------------------------------------------------------------------*/
if(function_exists('mts_register_typography')) {
  mts_register_typography(array(
  	'logo_font' => array(
      'preview_text' => 'Logo',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => '500',
      'font_size' => '44px',
      'font_color' => '#33bcf2',
      'css_selectors' => '#logo a',
    ),
    'navigation_font' => array(
      'preview_text' => 'Navigation Font',
      'preview_color' => 'dark',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '18px',
      'font_color' => '#ffffff',
      'css_selectors' => '#primary-navigation li, #primary-navigation li a',
      'additional_css' => 'text-transform: uppercase;'
    ),
    'home_title_font' => array(
      'preview_text' => 'Home Article Title',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_size' => '24px',
	  'font_variant' => 'normal',
      'font_color' => '#555555',
      'css_selectors' => '.latestPost .title, .latestPost .title a',
      'additional_css' => 'line-height: 36px;'
    ),
    'single_title_font' => array(
      'preview_text' => 'Single Article Title',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_size' => '38px',
	  'font_variant' => 'normal',
      'font_color' => '#555555',
      'css_selectors' => '.single-title',
      'additional_css' => 'line-height: 53px;'
    ),
    'content_font' => array(
      'preview_text' => 'Content Font',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_size' => '16px',
	  'font_variant' => 'normal',
      'font_color' => '#707070',
      'css_selectors' => 'body'
    ),
    'sidebar_title_font' => array(
      'preview_text' => 'Widget Title',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => '500',
      'font_size' => '18px',
      'font_color' => '#555555',
      'css_selectors' => '.widget .widget-title',
      'additional_css' => 'text-transform: uppercase;'
    ),
	'sidebar_font' => array(
      'preview_text' => 'Sidebar Font',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '16px',
      'font_color' => '#707070',
      'css_selectors' => '#sidebars .widget'
    ),
	'footer_font' => array(
      'preview_text' => 'Footer Font',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '14px',
      'font_color' => '#707070',
      'css_selectors' => '.footer-widgets'
    ),
    'h1_headline' => array(
      'preview_text' => 'Content H1',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '38px',
      'font_color' => '#555555',
      'css_selectors' => 'h1'
    ),
	'h2_headline' => array(
      'preview_text' => 'Content H2',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '34px',
      'font_color' => '#555555',
      'css_selectors' => 'h2'
    ),
	'h3_headline' => array(
      'preview_text' => 'Content H3',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '30px',
      'font_color' => '#555555',
      'css_selectors' => 'h3'
    ),
	'h4_headline' => array(
      'preview_text' => 'Content H4',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '28px',
      'font_color' => '#555555',
      'css_selectors' => 'h4'
    ),
	'h5_headline' => array(
      'preview_text' => 'Content H5',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '24px',
      'font_color' => '#555555',
      'css_selectors' => 'h5'
    ),
	'h6_headline' => array(
      'preview_text' => 'Content H6',
      'preview_color' => 'light',
      'font_family' => 'Roboto',
      'font_variant' => 'normal',
      'font_size' => '20px',
      'font_color' => '#555555',
      'css_selectors' => 'h6'
    )
  ));
}

?>
