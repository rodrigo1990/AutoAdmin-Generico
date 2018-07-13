<?php
/**
 * The template for displaying all single posts.
 */
?>
<?php get_header(); ?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php if ($mts_options['mts_breadcrumb'] == '1') { ?>
	<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#"><?php mts_the_breadcrumb(); ?></div>
<?php } ?>
<div id="page" class="<?php mts_single_page_class(); ?>">
	
	<?php $header_animation = mts_get_post_header_effect(); ?>
	<?php if ( 'parallax' === $header_animation ) {?>
		<?php if (mts_get_thumbnail_url()) : ?>
	        <div id="parallax" <?php echo 'style="background-image: url('.mts_get_thumbnail_url().');"'; ?>></div>
	    <?php endif; ?>
	<?php } else if ( 'zoomout' === $header_animation ) {?>
		 <?php if (mts_get_thumbnail_url()) : ?>
	        <div id="zoom-out-effect"><div id="zoom-out-bg" <?php echo 'style="background-image: url('.mts_get_thumbnail_url().');"'; ?>></div></div>
	    <?php endif; ?>
	<?php } ?>

	<article class="<?php mts_article_class(); ?>">
		<div id="content_box" >
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
					<?php
					// Single post parts ordering
					if ( isset( $mts_options['mts_single_post_layout'] ) && is_array( $mts_options['mts_single_post_layout'] ) && array_key_exists( 'enabled', $mts_options['mts_single_post_layout'] ) ) {
						$single_post_parts = $mts_options['mts_single_post_layout']['enabled'];
					} else {
						$single_post_parts = array( 'content' => 'content', 'related' => 'related', 'author' => 'author' );
					}
					foreach( $single_post_parts as $part => $label ) { 
						switch ($part) {
							case 'content':
								?>
								<div class="single_post">
									<header>
										<?php if( ! empty( $mts_options["mts_single_headline_meta_info"]['category']) ) { ?>
			                                <div class="thecategory"><i class="fa fa-globe"></i> <?php mts_the_category(', ') ?></div>
			                            <?php } ?>
										<h1 class="title single-title entry-title"><?php the_title(); ?></h1>
										<?php if ( ! empty( $mts_options["mts_single_headline_meta"] ) ) { ?>
					                        <div class="post-info">
					                            <?php if ( ! empty( $mts_options["mts_single_headline_meta_info"]['author']) ) { ?>
					                                <span class="theauthor"><i class="fa fa-user"></i> <span><?php the_author_posts_link(); ?></span></span>
					                            <?php } ?>
					                            <?php if( ! empty( $mts_options["mts_single_headline_meta_info"]['date']) ) { ?>
					                                <span class="thetime date updated"><i class="fa fa-calendar"></i> <span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago','sociallyviral'); ?></span></span>
					                            <?php } ?>
					                            <?php if( ! empty( $mts_options["mts_single_headline_meta_info"]['comment']) ) { ?>
					                               
					                            <?php } ?>
					                        </div>
			                   			<?php } ?>
									</header><!--.headline_area-->
									<div class="post-single-content box mark-links entry-content">
										<?php if (isset($mts_options['mts_social_button_position']) && ($mts_options['mts_social_button_position'] == 'top' || $mts_options['mts_social_button_position'] == 'both')) mts_social_buttons(); ?>
										<div class="single-prev-next">
											<?php previous_post_link('%link', '<i class="fa fa-long-arrow-left"></i> '.__('Artículo Previo','sociallyviral')); ?>
											<?php next_post_link('%link', __('Siguiente Artículo','sociallyviral').' <i class="fa fa-long-arrow-right"></i>'); ?>
										</div>
										<div class="thecontent clearfix">
											<?php if ($mts_options['mts_posttop_adcode'] != '') { ?>
												<?php $toptime = $mts_options['mts_posttop_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$toptime day")), get_the_time("Y-m-d") ) >= 0) { ?>
													<div class="topad">
														<?php echo do_shortcode($mts_options['mts_posttop_adcode']); ?>
													</div>
												<?php } ?>
											<?php } ?>
											<?php the_content(); ?>
										</div>
										<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next', 'sociallyviral' ), 'previouspagelink' => __('Anterior', 'sociallyviral' ), 'pagelink' => '%','echo' => 1 )); ?>
										<?php if ($mts_options['mts_postend_adcode'] != '') { ?>
											<?php $endtime = $mts_options['mts_postend_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$endtime day")), get_the_time("Y-m-d") ) >= 0) { ?>
												<div class="bottomad">
													<?php echo do_shortcode($mts_options['mts_postend_adcode']); ?>
												</div>
											<?php } ?>
										<?php } ?> 
										<?php if (isset($mts_options['mts_social_button_position']) && ($mts_options['mts_social_button_position'] !== 'top' || $mts_options['mts_social_button_position'] == 'both')) mts_social_buttons(); ?>
										<div class="single-prev-next">
											<?php previous_post_link('%link', '<i class="fa fa-long-arrow-left"></i> '.__('Artículo Previo','sociallyviral')); ?>
											<?php next_post_link('%link', __('Siguiente Artículo','sociallyviral').' <i class="fa fa-long-arrow-right"></i>'); ?>
										</div>
									</div><!--.post-single-content-->
								</div><!--.single_post-->
								<?php
							break;

							case 'tags':
								?>
								<div class="tags"><?php mts_the_tags('<span class="tagtext">'.__('Tags', 'sociallyviral' ).':</span>',', ') ?></div>
								<?php
							break;

							case 'related':
								mts_related_posts();
							break;

							case 'author':
								?>
								<div class="postauthor">
									<h4><?php _e('About The Author', 'sociallyviral' ); ?></h4>
									<div class="author-wrap">
										<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '168' );  } ?>
										<h5 class="vcard author"><span class="fn"><?php the_author_meta( 'nickname' ); ?></span></h5>
										<span class="author-posts"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="nofollow"><?php _e('More from this Author','sociallyviral'); ?> <i class="fa fa-angle-double-right"></i></a></span>
										<p><?php the_author_meta('description') ?></p>
									</div>
								</div>
								<?php
							break;
						}
					}
					?>
				</div><!--.g post-->
				<?php comments_template( '', true ); ?>
			<?php endwhile; /* end loop */ ?>
		</div>
	</article>
	<?php get_sidebar(); ?>
</div><!--#page-->
<?php get_footer(); ?>
