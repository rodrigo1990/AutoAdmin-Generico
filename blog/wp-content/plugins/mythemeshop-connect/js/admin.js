/*
 * Plugin Name: MyThemeShop Connect
 * Plugin URI: http://www.mythemeshop.com
 * Description: Update MyThemeShop themes & plugins, get news & exclusive offers right from your WordPress dashboard
 * Author: MyThemeShop
 * Author URI: http://www.mythemeshop.com
 */
jQuery(document).ready(function($) {
    var closed_notices = 0;
    function dismiss_notices(ids) {
        $.each(ids, function(index, id) {
            var $notice = $('#notice_'+id);
            $notice.fadeOut('slow', function() {
                if (closed_notices >= 2) {
                    $('.mts-notice-dismiss-all-icon').fadeIn();
                }
            });
        });
        
        $.ajax({
            url: ajaxurl,
            method: 'post',
            data: {'action': 'mts_connect_dismiss_notice', 'ids': ids}
        });

        closed_notices++;
    }
    
    $('.mts-notice-dismiss-icon', this).click(function(e) {
        e.preventDefault();
        var id = $(this).closest('.mts-connect-notice').prop('id').replace('notice_', '');
        dismiss_notices([id]);
    });
                
    var notices = [];
    $('.mts-connect-notice').each(function() {
        notices.push(this.id.replace('notice_', ''));
    });
    
    $('.mts-notice-dismiss-all-icon', this).click(function(e) {
        e.preventDefault();
        dismiss_notices(notices);
    });
    
    // Admin menu
    jQuery('#adminmenu .toplevel_page_mts-connect .dashicons-update').addClass(mtsconnect.connected_class_attr);
    
    // Extra buttons
    if (jQuery('body').hasClass('themes-php')) {
        jQuery('h2 .add-new-h2').after(' <a href="'+mtsconnect.check_themes_url+'" id="mts-connect-check-theme-updates" class="add-new-h2">'+mtsconnect.l10n_check_themes_button+'</a>');
    } else if (jQuery('body').hasClass('plugins-php')) {
        jQuery('h2 .add-new-h2').after(' <a href="'+mtsconnect.check_plugins_url+'" id="mts-connect-check-theme-updates" class="add-new-h2">'+mtsconnect.l10n_check_plugins_button+'</a>');
    }
});