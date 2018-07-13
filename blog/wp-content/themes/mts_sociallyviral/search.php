<?php
/**
 * The template for displaying search results pages.
 */
?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page" class="home-<?php echo $mts_options['mts_home_layout']; ?>">
	<div id="content_box">
		<h1 class="postsby">
			<span><?php _e("Search Results for:", 'sociallyviral' ); ?></span> <?php the_search_query(); ?>
		</h1>
		<?php if($mts_options['mts_home_layout'] == "h2") { ?>
            <div class="article">
        <?php } ?>
		<?php $j = 1; if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php $featured = get_post_meta(get_the_ID(), 'mts_featured', true); ?>
			<article class="latestPost excerpt<?php echo (($j+2) % 3 == 0) ? ' first' : ''; ?><?php if($mts_options['mts_home_layout'] == "h1") { echo ($j % 3 == 0) ? ' last' : ''; } else { echo ($j % 2 == 0) ? ' last' : ''; } ?>">
			    <a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="post-image post-image-left">
                    <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail('sociallyviral-featured', array('title' => '')); echo '</div>'; ?>
                    <?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
                    <?php if ($featured) : ?><div class="post-label"><i class="fa fa-star"></i> <span><?php _e('Featured','sociallyviral'); ?></span></div><?php endif; ?>
                </a>
                <header>
                    <h2 class="title front-view-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h2>
                    <?php mts_the_postinfo(); ?>
                </header>
            </article>
		<?php $j++; endwhile; else: ?>
			<div class="no-results">
				<h2><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'sociallyviral' ); ?></h2>
				<?php get_search_form(); ?>
			</div><!--noResults-->
		<?php endif; ?>

		<?php if ( $j !== 0 ) { // No pagination if there is no posts ?>
			<?php mts_pagination(); ?>
		<?php } ?>
		<?php if($mts_options['mts_home_layout'] == "h2") { ?>
            </div>
            <?php get_sidebar(); ?>
        <?php } ?>
	</div>
</div><!--#page-->
<?php get_footer(); ?>
