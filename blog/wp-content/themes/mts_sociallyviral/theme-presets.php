<?php
// make sure to not include translations
$args['presets']['SV1'] = array(
	'title' => 'Layout 1',
	'demo' => 'http://demo.mythemeshop.com/sociallyviral/',
	'thumbnail' => get_template_directory_uri().'/options/demo-importer/demo-files/SV1/thumb.jpg', // could use external url, to minimize theme zip size
	'menus' => array( 'primary-menu' => 'Primary Menu', 'footer-menu' => 'Footer Menu', 'mobile' => '' ), // menu location slug => Demo menu name
	'options' => array( 'show_on_front' => 'posts', 'posts_per_page' => 9 ),
);

$args['presets']['SV2'] = array(
	'title' => 'Layout 2',
	'demo' => 'http://demo.mythemeshop.com/sociallyviral-2/',
	'thumbnail' => get_template_directory_uri().'/options/demo-importer/demo-files/SV2/thumb.jpg', // could use external url, to minimize theme zip size
	'menus' => array( 'primary-menu' => 'Primary Menu', 'footer-menu' => 'Footer Menu', 'mobile' => '' ), // menu location slug => Demo menu name
	'options' => array( 'show_on_front' => 'posts', 'posts_per_page' => 6 ),
);

global $mts_presets;
$mts_presets = $args['presets'];
