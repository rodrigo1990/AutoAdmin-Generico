<?php

/**
 * Add a "Sidebar" selection metabox.
 */
function mts_add_sidebar_metabox() {
    $screens = array('post', 'page');
    foreach ($screens as $screen) {
        add_meta_box(
            'mts_sidebar_metabox',                  // id
            __('Sidebar', 'sociallyviral' ),    // title
            'mts_inner_sidebar_metabox',            // callback
            $screen,                                // post_type
            'side',                                 // context (normal, advanced, side)
            'high'                               // priority (high, core, default, low)
                                                    // callback args ($post passed by default)
        );
    }
}
add_action('add_meta_boxes', 'mts_add_sidebar_metabox');


/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_sidebar_metabox($post) {
    global $wp_registered_sidebars;
    
    // Add an nonce field so we can check for it later.
    wp_nonce_field('mts_inner_sidebar_metabox', 'mts_inner_sidebar_metabox_nonce');
    
    /*
    * Use get_post_meta() to retrieve an existing value
    * from the database and use the value for the form.
    */
    $custom_sidebar = get_post_meta( $post->ID, '_mts_custom_sidebar', true );
    $sidebar_location = get_post_meta( $post->ID, '_mts_sidebar_location', true );

    // Select custom sidebar from dropdown
    echo '<select name="mts_custom_sidebar" id="mts_custom_sidebar" style="margin-bottom: 10px;">';
    echo '<option value="" '.selected('', $custom_sidebar).'>-- '.__('Default', 'sociallyviral' ).' --</option>';
    
    // Exclude built-in sidebars
    $hidden_sidebars = array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar');    
    
    foreach ($wp_registered_sidebars as $sidebar) {
        if (!in_array($sidebar['id'], $hidden_sidebars)) {
            echo '<option value="'.esc_attr($sidebar['id']).'" '.selected($sidebar['id'], $custom_sidebar, false).'>'.$sidebar['name'].'</option>';
        }
    }
    echo '<option value="mts_nosidebar" '.selected('mts_nosidebar', $custom_sidebar).'>-- '.__('No sidebar --', 'sociallyviral' ).'</option>';
    echo '</select><br />';
    
    // Select single layout (left/right sidebar)
    echo '<div class="mts_sidebar_location_fields">';
    echo '<label for="mts_sidebar_location_default" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_default" value=""'.checked('', $sidebar_location, false).'>'.__('Default side', 'sociallyviral' ).'</label>';
    echo '<label for="mts_sidebar_location_left" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_left" value="left"'.checked('left', $sidebar_location, false).'>'.__('Left', 'sociallyviral' ).'</label>';
    echo '<label for="mts_sidebar_location_right" style="display: inline-block; margin-right: 20px;"><input type="radio" name="mts_sidebar_location" id="mts_sidebar_location_right" value="right"'.checked('right', $sidebar_location, false).'>'.__('Right', 'sociallyviral' ).'</label>';
    echo '</div>';
    
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            function mts_toggle_sidebar_location_fields() {
                $('.mts_sidebar_location_fields').toggle(($('#mts_custom_sidebar').val() != 'mts_nosidebar'));
            }
            mts_toggle_sidebar_location_fields();
            $('#mts_custom_sidebar').change(function() {
                mts_toggle_sidebar_location_fields();
            });
        });
    </script>
    <?php
    //debug
    //global $wp_meta_boxes;
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int
 */
function mts_save_custom_sidebar( $post_id ) {
    
    /*
    * We need to verify this came from our screen and with proper authorization,
    * because save_post can be triggered at other times.
    */
    
    // Check if our nonce is set.
    if ( ! isset( $_POST['mts_inner_sidebar_metabox_nonce'] ) )
    return $post_id;
    
    $nonce = $_POST['mts_inner_sidebar_metabox_nonce'];
    
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'mts_inner_sidebar_metabox' ) )
      return $post_id;
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
    
    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {
    
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
    
    } else {
    
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    }
    
    /* OK, its safe for us to save the data now. */
    
    // Sanitize user input.
    $sidebar_name = sanitize_text_field( $_POST['mts_custom_sidebar'] );
    $sidebar_location = sanitize_text_field( $_POST['mts_sidebar_location'] );
    
    // Update the meta field in the database.
    update_post_meta( $post_id, '_mts_custom_sidebar', $sidebar_name );
    update_post_meta( $post_id, '_mts_sidebar_location', $sidebar_location );
}
add_action( 'save_post', 'mts_save_custom_sidebar' );


/**
 * Add "Post Template" selection meta box
 */
function mts_add_posttemplate_metabox() {
    add_meta_box(
        'mts_posttemplate_metabox',         // id
        __('Template', 'sociallyviral' ),      // title
        'mts_inner_posttemplate_metabox',   // callback
        'post',                             // post_type
        'side',                             // context (normal, advanced, side)
        'high'                              // priority (high, core, default, low)
    );
}
//add_action('add_meta_boxes', 'mts_add_posttemplate_metabox');


/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_posttemplate_metabox($post) {
    
    // Add an nonce field so we can check for it later.
    wp_nonce_field('mts_inner_posttemplate_metabox', 'mts_inner_posttemplate_metabox_nonce');
    
    /*
    * Use get_post_meta() to retrieve an existing value
    * from the database and use the value for the form.
    */
    $posttemplate = get_post_meta( $post->ID, '_mts_posttemplate', true );

    // Select post template
    echo '<select name="mts_posttemplate" style="margin-bottom: 10px;">';
    echo '<option value="" '.selected('', $posttemplate).'>'.__('Default Post Template', 'sociallyviral' ).'</option>';
    echo '<option value="parallax" '.selected('parallax', $posttemplate).'>'.__('Parallax Template', 'sociallyviral' ).'</option>';
    echo '<option value="zoomout" '.selected('zoomout', $posttemplate).'>'.__('Zoom Out Effect Template', 'sociallyviral' ).'</option>';
    echo '</select><br />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int
 */
function mts_save_posttemplate( $post_id ) {
    
    /*
    * We need to verify this came from our screen and with proper authorization,
    * because save_post can be triggered at other times.
    */
    
    // Check if our nonce is set.
    if ( ! isset( $_POST['mts_inner_posttemplate_metabox_nonce'] ) )
    return $post_id;
    
    $nonce = $_POST['mts_inner_posttemplate_metabox_nonce'];
    
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'mts_inner_posttemplate_metabox' ) )
      return $post_id;
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
    
    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {
    
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
    
    } else {
    
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    }
    
    /* OK, its safe for us to save the data now. */
    
    // Sanitize user input.
    $posttemplate = sanitize_text_field( $_POST['mts_posttemplate'] );
    
    // Update the meta field in the database.
    update_post_meta( $post_id, '_mts_posttemplate', $posttemplate );
}
add_action( 'save_post', 'mts_save_posttemplate' );

// Related function: mts_get_posttemplate( $single_template ) in functions.php

/**
 * Add "Page Header Animation" metabox.
 */
function mts_add_postheader_metabox() {
    $screens = array('post', 'page');
    foreach ($screens as $screen) {
        add_meta_box(
            'mts_postheader_metabox',                  // id
            __('Header Animation', 'sociallyviral' ),    // title
            'mts_inner_postheader_metabox',            // callback
            $screen,                                // post_type
            'side',                                 // context (normal, advanced, side)
            'high'                               // priority (high, core, default, low)
                                                    // callback args ($post passed by default)
        );
    }
}
add_action('add_meta_boxes', 'mts_add_postheader_metabox');


/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_postheader_metabox($post) {
    
    // Add an nonce field so we can check for it later.
    wp_nonce_field('mts_inner_postheader_metabox', 'mts_inner_postheader_metabox_nonce');
    
    /*
    * Use get_post_meta() to retrieve an existing value
    * from the database and use the value for the form.
    */
    $postheader = get_post_meta( $post->ID, '_mts_postheader', true );

    // Select post header effect
    echo '<select name="mts_postheader" style="margin-bottom: 10px;">';
    echo '<option value="" '.selected('', $postheader).'>'.__('None', 'sociallyviral' ).'</option>';
    echo '<option value="parallax" '.selected('parallax', $postheader).'>'.__('Parallax Effect', 'sociallyviral' ).'</option>';
    echo '<option value="zoomout" '.selected('zoomout', $postheader).'>'.__('Zoom Out Effect', 'sociallyviral' ).'</option>';
    echo '</select><br />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int
 *
 * @see mts_get_post_header_effect
 */
function mts_save_postheader( $post_id ) {
    
    /*
    * We need to verify this came from our screen and with proper authorization,
    * because save_post can be triggered at other times.
    */
    
    // Check if our nonce is set.
    if ( ! isset( $_POST['mts_inner_postheader_metabox_nonce'] ) )
    return $post_id;
    
    $nonce = $_POST['mts_inner_postheader_metabox_nonce'];
    
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'mts_inner_postheader_metabox' ) )
      return $post_id;
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
    
    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {
    
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    
    } else {
    
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
    }
    
    /* OK, its safe for us to save the data now. */
    
    // Sanitize user input.
    $postheader = sanitize_text_field( $_POST['mts_postheader'] );
    
    // Update the meta field in the database.
    update_post_meta( $post_id, '_mts_postheader', $postheader );
}
add_action( 'save_post', 'mts_save_postheader' );

/**
 * Add a "Menus" metabox.
 */
function mts_add_menu_metabox() {
    $screens = array('post', 'page');
    foreach ($screens as $screen) {
        add_meta_box(
            'mts_menu_metabox',                  // id
            __('Menus', 'sociallyviral' ),    // title
            'mts_inner_menu_metabox',            // callback
            $screen,                                // post_type
            'side',                                 // context (normal, advanced, side)
            'high'                               // priority (high, core, default, low)
                                                    // callback args ($post passed by default)
        );
    }
}
add_action('add_meta_boxes', 'mts_add_menu_metabox');
/**
 * Print the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_menu_metabox( $post ) {
    
    // Add an nonce field so we can check for it later.
    wp_nonce_field('mts_inner_menu_metabox', 'mts_inner_menu_metabox_nonce');
    
    /*
    * Use get_post_meta() to retrieve an existing value
    * from the database and use the value for the form.
    */
    $custom_menu = get_post_meta( $post->ID, '_mts_custom_menu', true );
    $registered_nav_menus = get_registered_nav_menus();
    $locations = get_nav_menu_locations();
    $menus = wp_get_nav_menus();
    foreach ( $registered_nav_menus as $location => $description ) {
        echo '<label for="mts_custom_menu_'.$location.'">' . $description . '</label><br />';
        if ( isset( $locations[ $location ] ) ) {
            $menu_id = isset( $custom_menu[ $location ] ) && wp_get_nav_menu_object( $custom_menu[ $location ] ) ? $custom_menu[ $location ] : $locations[ $location ];
            echo '<select name="mts_custom_menu['.$location.']" id="mts_custom_menu_'.$location.'" style="margin-bottom: 10px;">';
            if ( $menus ) {
                foreach ( $menus as $menu ) {
                    echo '<option value="'.$menu->term_id.'"'.selected( $menu->term_id, $menu_id, false).'>'.$menu->name.'</option>';
                }
            }
            echo '</select><br />';
        } else {
            echo '<p>' . __('No menu assigned to this location.', 'sociallyviral' ) . '</p>';
        }
    }
}
/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int
 */
function mts_save_custom_menu( $post_id ) {
    
    /*
    * We need to verify this came from our screen and with proper authorization,
    * because save_post can be triggered at other times.
    */
    
    // Check if our nonce is set.
    if ( ! isset( $_POST['mts_inner_menu_metabox_nonce'] ) )
    return $post_id;
    
    $nonce = $_POST['mts_inner_menu_metabox_nonce'];
    
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'mts_inner_menu_metabox' ) )
      return $post_id;
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
    
    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {
    
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
    
    } else {
    
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    }
    
    /* OK, its safe for us to save the data now. */
    
    // Sanitize user input.
    $custom_menu = $_POST['mts_custom_menu'];
    
    // Update the meta field in the database.
    update_post_meta( $post_id, '_mts_custom_menu', $custom_menu );
}
add_action( 'save_post', 'mts_save_custom_menu' );

/**
 * Add Featured meta to Publish box
 */
add_action( 'post_submitbox_misc_actions', 'mts_featured_post_field' );
function mts_featured_post_field()
{
    global $post;

    /* check if this is a post, if not then we won't add the custom field */
    /* change this post type to any type you want to add the custom field to */
    if (get_post_type($post) != 'post') return false;

    /* get the value corrent value of the custom field */
    $value = get_post_meta($post->ID, 'mts_featured', true);
    ?>
        <div class="misc-pub-section" id="mts_featured_field">
            <?php //if there is a value (1), check the checkbox ?>
            <label><div class="dashicons dashicons-star-empty" style="padding: 0 2px 0 0; color: #888;"></div> <?php _e('Featured Post', 'sociallyviral'); ?> <input type="checkbox"<?php echo (!empty($value) ? ' checked="checked"' : null) ?> value="1" name="mts_featured" id="mts_featured" style="display: none;" /></label>
        </div>
        <script>jQuery(document).ready(function($) {
            $('#mts_featured').change(function() {
                var $this = $(this),
                    $icon = $this.parent().find('.dashicons');

                if ($this.is(':checked')) {
                    $icon.attr('class', 'dashicons dashicons-star-filled');
                } else {
                    $icon.attr('class', 'dashicons dashicons-star-empty');
                }
            });
            $('#mts_featured_field .dashicons').attr('class', function() {
                return $('#mts_featured').is(':checked') ? 'dashicons dashicons-star-filled' : 'dashicons dashicons-star-empty';
            });
        });</script>
    <?php
}

add_action( 'save_post', 'mts_save_featured_meta');
function mts_save_featured_meta($postid)
{
    /* check if this is an autosave */
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;

    /* check if the user can edit this page */
    if ( !current_user_can( 'edit_page', $postid ) ) return false;

    // check if quick edit
    if (isset($_POST['_inline_edit']) && wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce'))
      return;

    /* check if there's a post id and check if this is a post */
    /* make sure this is the same post type as above */
    if(empty($postid) || (!empty($_POST['post_type']) && $_POST['post_type'] != 'post')  || (!empty($_GET['post_type']) && $_GET['post_type'] != 'post') ) return false;

    /* if you are going to use text fields, then you should change the part below */
    /* use add_post_meta, update_post_meta and delete_post_meta, to control the stored value */

    /* check if the custom field is submitted (checkboxes that aren't marked, aren't submitted) */
    if(isset($_POST['mts_featured'])){
        /* store the value in the database */
        add_post_meta($postid, 'mts_featured', 1, true );
    }
    else{
        /* not marked? delete the value in the database */
        delete_post_meta($postid, 'mts_featured');
    }
}
?>