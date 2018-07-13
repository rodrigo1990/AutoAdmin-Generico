<?php
/**
 * Enqueue WP Pointer.
 */
function mts_sociallyviral_pointer_header() {
    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    if ( ! in_array( 'mts_sociallyviral_pointer', $dismissed ) ) {
        add_action( 'admin_print_footer_scripts', 'mts_sociallyviral_pointer_footer' );

        wp_enqueue_script( 'wp-pointer' );
        wp_enqueue_style( 'wp-pointer' );
    }
}
add_action( 'admin_enqueue_scripts', 'mts_sociallyviral_pointer_header' );

/**
 * Display WP Pointer configuration.
 */
function mts_sociallyviral_pointer_footer() {
    $pointer_content = '<h3>'.__('Awesomeness!', 'sociallyviral' ).'</h3>';
    $pointer_content .= '<p>'.__('You have just Installed sociallyviral WordPress Theme by MyThemeShop.', 'sociallyviral' ).'</p>';
	$pointer_content .= '<p>'.__('You can Trigger The Awesomeness using Amazing Option Panel in <b>Theme Options</b>.', 'sociallyviral' ).'</p>';

    if ( ! MTS_THEME_WHITE_LABEL ) {
        $pointer_content .= '<p>'.__('If you face any problem, head over to', 'sociallyviral' ).' <a href="http://community.mythemeshop.com/">'.__('Support Forums', 'sociallyviral' ).'</a></p>';
    }
?>
<script type="text/javascript">// <![CDATA[
jQuery(document).ready(function($) {
    $('#menu-appearance').pointer({
        content: '<?php echo wp_kses_post( $pointer_content ); ?>',
        position: {
            edge: 'left',
            align: 'center'
        },
        close: function() {
            $.post( ajaxurl, {
                pointer: 'mts_sociallyviral_pointer',
                action: 'dismiss-wp-pointer'
            });
        }
    }).pointer('open');
});
// ]]></script>
<?php
}

?>
