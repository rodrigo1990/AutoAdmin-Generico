<?php
/**
 * The main template file.
 *
 * Used to display the homepage when home.php doesn't exist.
 */
$featured = '';
?>
<?php $mts_options = get_option(MTS_THEME_NAME); ?>
<?php get_header(); ?>
<div id="page" class="home-<?php echo $mts_options['mts_home_layout']; ?>">
    <div id="content_box">

        <?php if ( is_home() && $mts_options['mts_featured_slider'] == '1' && !is_paged() ) { ?>
            <div class="primary-slider-container clearfix loading">
                <div id="slider" class="primary-slider">
                <?php if ( empty( $mts_options['mts_custom_slider'] ) ) { ?>
                    <?php
                    // prevent implode error
                    if ( empty( $mts_options['mts_featured_slider_cat'] ) || !is_array( $mts_options['mts_featured_slider_cat'] ) ) {
                        $mts_options['mts_featured_slider_cat'] = array('0');
                    }

                    $slider_cat = implode( ",", $mts_options['mts_featured_slider_cat'] );
                    $slider_query = new WP_Query('cat='.$slider_cat.'&posts_per_page='.$mts_options['mts_featured_slider_num']);
                    while ( $slider_query->have_posts() ) : $slider_query->the_post();
                    ?>
                    <div>
                        <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                            <?php the_post_thumbnail('sociallyviral-slider',array('title' => '')); ?>
                            <div class="slide-caption">
                                <h2 class="slide-title"><?php the_title(); ?></h2>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php } else { ?>
                    <?php foreach( $mts_options['mts_custom_slider'] as $slide ) : ?>
                        <div>
                            <a href="<?php echo esc_url( $slide['mts_custom_slider_link'] ); ?>">
                                <?php echo wp_get_attachment_image( $slide['mts_custom_slider_image'], 'sociallyviral-slider', false, array('title' => '') ); ?>
                                <div class="slide-caption">
                                    <h2 class="slide-title"><?php echo esc_html( $slide['mts_custom_slider_title'] ); ?></h2>
                                    <p class="slide-text"><?php echo esc_html( $slide['mts_custom_slider_text'] ); ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php } ?>
                </div><!-- .primary-slider -->
            </div><!-- .primary-slider-container -->
        <?php } ?>

        <?php if($mts_options['mts_home_layout'] == "h2") { ?>
            <div class="article">
        <?php } ?>
            <?php if ( !is_paged() ) {
                $featured_categories = array();
                if ( !empty( $mts_options['mts_featured_categories'] ) ) {
                    //$mts_options['mts_featured_categories'] = array_values( $mts_options['mts_featured_categories'] );
                    foreach ( $mts_options['mts_featured_categories'] as $index => $section ) {
                        $category_id = $section['mts_featured_category'];
                        $featured_categories[] = $category_id;
                        $posts_num = $section['mts_featured_category_postsnum'];

                        $widget_displayed = false;
                        if (!is_active_sidebar('widget-home'))
                            $widget_displayed = true;

                        if ( 'latest' == $category_id ) {

                            $j = 0; // counter

                            if ( have_posts() ) : while ( have_posts() ) : the_post();
                                $j++;
                                $featured = get_post_meta($post->ID, 'mts_featured', true);
                                $image_size = 'sociallyviral-featured';
                                $post_class = '';

                                if($mts_options['mts_home_layout'] != "h2") {
                                    // Homepage Widget area
                                    if ($j > 2 && !$widget_displayed/* && $index == 0*/) {
                                        $widget_displayed = true; ?>
                                        <article class="latestPost excerpt homepage-widget<?php echo (($j+2) % 3 == 0) ? ' first' : ''; ?><?php echo ($j % 3 == 0) ? ' last' : ''; ?>">
                                            <?php dynamic_sidebar( 'widget-home' ); ?>
                                        </article><!--.post excerpt-->
                                        <?php $j++;
                                    }
                                }

                                if ( $j == 1 && !empty($mts_options['mts_home_layout_big_post']) ) { // ($featured && $j % 3 != 0) {
                                    $j++; // count +1
                                    $image_size = 'sociallyviral-featuredbig';
                                    $post_class = 'featuredPost';
                                } ?>
                                <article class="latestPost excerpt<?php echo (($j+2) % 3 == 0) ? ' first' : ''; ?><?php if($mts_options['mts_home_layout'] == "h1") { echo ($j % 3 == 0) ? ' last' : ''; } else { echo ($j % 2 == 0) ? ' last' : ''; } ?> <?php echo $post_class; ?>">
                                    <a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="post-image post-image-left">
                                        <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail($image_size, array('title' => '')); echo '</div>'; ?>
                                        <?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
                                        <?php if ($featured) : ?><div class="post-label"><i class="fa fa-star"></i> <span><?php _e('Featured','sociallyviral'); ?></span></div><?php endif; ?>
                                    </a>
                                    <header>
                                        <h2 class="title front-view-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h2>
                                        <?php mts_the_postinfo(); ?>
                                    </header>
                                </article>
                            <?php endwhile; endif; ?>

                            <?php if ( $j !== 0 ) { // No pagination if there is no posts ?>
                                <?php mts_pagination(); ?>
                            <?php } ?>

                        <?php } else { // if $category_id != 'latest': ?>
                            <h3 class="featured-category-title"><a href="<?php echo esc_url( get_category_link( $category_id ) ); ?>" title="<?php echo esc_attr( get_cat_name( $category_id ) ); ?>"><?php echo esc_html( get_cat_name( $category_id ) ); ?></a></h3>
                            <?php
                            $j = 0;
                            $cat_query = new WP_Query('cat='.$category_id.'&posts_per_page='.$posts_num);
                            if ( $cat_query->have_posts() ) : while ( $cat_query->have_posts() ) : $cat_query->the_post();
                                $featured = get_post_meta(get_the_ID(), 'mts_featured', true);
                                $j++;
                                $image_size = 'sociallyviral-featured';
                                $post_class = '';


                                /*if($mts_options['mts_home_layout'] != "h2") {
                                    // Homepage Widget area
                                    if ($j > 2 && !$widget_displayed && $index == 0) {
                                        $widget_displayed = true;
                                        ?>
                                        <article class="latestPost excerpt homepage-widget<?php echo (($j+2) % 3 == 0) ? ' first' : ''; ?><?php echo ($j % 3 == 0) ? ' last' : ''; ?>">
                                            <?php dynamic_sidebar( 'widget-home' ); ?>
                                        </article><!--.post excerpt-->
                                        <?php
                                        $j++;
                                    }
                                }*/

                                if ( $j == 1 && !empty($mts_options['mts_home_layout_big_post']) ) { // ($featured && $j % 3 != 0) {
                                    $j++; // count +1
                                    $image_size = 'sociallyviral-featuredbig';
                                    $post_class = 'featuredPost';
                                }
                            ?>
                                <article class="latestPost excerpt<?php echo (($j+2) % 3 == 0) ? ' first' : ''; ?><?php if($mts_options['mts_home_layout'] == "h1") { echo ($j % 3 == 0) ? ' last' : ''; } else { echo ($j % 2 == 0) ? ' last' : ''; } ?> <?php echo $post_class; ?>">
                                    <a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="post-image post-image-left">
                                        <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail($image_size, array('title' => '')); echo '</div>'; ?>
                                        <?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
                                        <?php if ($featured) : ?><div class="post-label"><i class="fa fa-star"></i> <span><?php _e('Featured','sociallyviral'); ?></span></div><?php endif; ?>
                                    </a>
                                    <header>
                                        <h2 class="title front-view-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h2>
                                        <?php mts_the_postinfo(); ?>
                                    </header>
                                </article>
                            <?php
                            endwhile; endif; wp_reset_postdata();
                        }
                    }
                }
                ?>

            <?php } else { //Paged ?>

                <?php
                $j = 0; if ( have_posts() ) : while ( have_posts() ) : the_post();
                    $featured = get_post_meta(get_the_ID(), 'mts_featured', true);
                    $j++;
                    $image_size = 'sociallyviral-featured';
                    $post_class = '';

                    if ( $j == 1 && !empty($mts_options['mts_home_layout_big_post']) ) { // ($featured && $j % 3 != 0) {
                        $j++; // count +1
                        $image_size = 'sociallyviral-featuredbig';
                        $post_class = 'featuredPost';
                    }
                ?>
                <article class="latestPost excerpt<?php echo (($j+2) % 3 == 0) ? ' first' : ''; ?><?php if($mts_options['mts_home_layout'] == "h1") { echo ($j % 3 == 0) ? ' last' : ''; } else { echo ($j % 2 == 0) ? ' last' : ''; } ?> <?php echo $post_class; ?>">
                    <a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" class="post-image post-image-left">
                        <?php echo '<div class="featured-thumbnail">'; the_post_thumbnail($image_size, array('title' => '')); echo '</div>'; ?>
                        <?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'latestPost-review-wrapper'); ?>
                        <?php if ($featured) : ?><div class="post-label"><i class="fa fa-star"></i> <span><?php _e('Featured','sociallyviral'); ?></span></div><?php endif; ?>
                    </a>
                    <header>
                        <h2 class="title front-view-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h2>
                        <?php mts_the_postinfo(); ?>
                    </header>
                </article>
                <?php endwhile; endif; ?>

                <?php if ( $j !== 0 ) { // No pagination if there is no posts ?>
                    <?php mts_pagination(); ?>
                <?php } ?>

            <?php } ?>
        <?php $sidebar = mts_custom_sidebar(); ?>
        <?php if($mts_options['mts_home_layout'] == "h2" && 'mts_nosidebar' !== $sidebar) { ?>
        </div>
        <aside id="sidebar" class="sidebar c-4-12" role="complementary" itemscope="" itemtype="http://schema.org/WPSideBar">
            <?php dynamic_sidebar( $sidebar ); ?>
        </aside>
        <?php } ?>
    </div>
</div><!--#page-->
<?php get_footer(); ?>
