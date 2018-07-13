<?php
/**
 * The template for displaying the header.
 *
 * Displays everything from the doctype declaration down to the navigation.
 */
?>
<!DOCTYPE html>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<html class="no-js" <?php language_attributes(); ?>>
<head itemscope itemtype="http://schema.org/WebSite">
	<meta charset="<?php bloginfo('charset'); ?>">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php mts_meta(); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body id="blog" <?php body_class('main'); ?> itemscope itemtype="http://schema.org/WebPage">    
	<div class="main-container">
		<header id="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
			<div class="container">
				<div id="header">
					<div class="logo-wrap">
						<?php if ($mts_options['mts_logo'] != '') { ?>
							<?php
							$logo_id = mts_get_image_id_from_url( $mts_options['mts_logo'] );
							$logo_w_h = '';
							if ( $logo_id ) {
								$logo     = wp_get_attachment_image_src( $logo_id, 'full' );
								if ( !empty( $logo[1] ) && !empty( $logo[2] ) ) $logo_w_h = ' width="'.$logo[1].'" height="'.$logo[2].'"';
							}
        					?>
							<?php if( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="image-logo" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo esc_url( $mts_options['mts_logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"<?php echo $logo_w_h; ?>></a>
									</h1><!-- END #logo -->
							<?php } else { ?>
								  <h2 id="logo" class="image-logo" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><img src="<?php echo esc_url( $mts_options['mts_logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"<?php echo $logo_w_h; ?>></a>
									</h2><!-- END #logo -->
							<?php } ?>
						<?php } else { ?>
							<?php if( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="text-logo" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
									</h1><!-- END #logo -->
							<?php } else { ?>
								  <h2 id="logo" class="text-logo" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
									</h2><!-- END #logo -->
							<?php } ?>
						<?php } ?>
					</div>

					<?php if($mts_options['mts_header_search'] == '1') { ?>
						<div class="header-search"><?php get_search_form( ); ?></div>
					<?php } ?>

					<?php if ( $mts_options['mts_show_header_social'] == '1' && !empty($mts_options['mts_header_social']) && is_array($mts_options['mts_header_social'])) { ?>
						<div class="header-social">
					        <?php foreach( $mts_options['mts_header_social'] as $header_icons ) : ?>
					            <?php if( ! empty( $header_icons['mts_header_icon'] ) && isset( $header_icons['mts_header_icon'] ) ) : ?>
					                <a href="<?php print $header_icons['mts_header_icon_link'] ?>" class="header-<?php print $header_icons['mts_header_icon'] ?>" style="background: <?php print $header_icons['mts_header_icon_bg_color'] ?>" target="_blank"><span class="fa fa-<?php print $header_icons['mts_header_icon'] ?>"></span></a>
					            <?php endif; ?>
					        <?php endforeach; ?>
					    </div>
					<?php } ?>

					

			        <?php if ( $mts_options['mts_show_primary_nav'] == '1' ) { ?>
					<?php if( $mts_options['mts_sticky_nav'] == '1' ) { ?>
						<div id="catcher" class="clear" ></div>
						<div id="primary-navigation" class="sticky-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<?php } else { ?>
						<div id="primary-navigation" class="primary-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<?php } ?>
						<a href="#" id="pull" class="toggle-mobile-menu"><?php _e('Menu', 'sociallyviral' ); ?></a>
						<?php if ( has_nav_menu( 'mobile' ) ) { ?>
							<nav class="navigation clearfix">
								<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
									<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_menu_walker ) ); ?>
								<?php } else { ?>
									<ul class="menu clearfix">
										<?php wp_list_categories('title_li='); ?>
									</ul>
								<?php } ?>
							</nav>
							<nav class="navigation mobile-only clearfix mobile-menu-wrapper">
								<?php wp_nav_menu( array( 'theme_location' => 'mobile', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_menu_walker ) ); ?>
							</nav>
						<?php } else { ?>
							<nav class="navigation clearfix mobile-menu-wrapper">
								<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
									<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu clearfix', 'container' => '', 'walker' => new mts_menu_walker ) ); ?>
								<?php } else { ?>
									<ul class="menu clearfix">
										<?php wp_list_categories('title_li='); ?>
									</ul>
								<?php } ?>
							</nav>
						<?php } ?>
					</div>
					<?php } ?> 

				</div><!--#header-->
			</div><!--.container-->
		</header>
		<?php if(!empty($mts_options['mts_header_adcode'])) { ?>
			<div class="header-ad">
				<?php echo do_shortcode($mts_options['mts_header_adcode']); ?>
			</div>
		<?php } ?>