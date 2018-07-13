/*
 * Plugin Name: MyThemeShop Connect
 * Plugin URI: http://www.mythemeshop.com
 * Description: Update MyThemeShop themes & plugins, get news & exclusive offers right from your WordPress dashboard
 * Author: MyThemeShop
 * Author URI: http://www.mythemeshop.com
 */
jQuery(document).ready(function($) {
    $('#mts_connect_form').submit(function(e) {
        e.preventDefault();
        var $this = $(this);
        /* if ($this.find('#mts_username').val().indexOf('@') > -1) {
            $this.find('.error').remove();
            $this.append('<p class="error">'+mtsconnect.l10n_insert_username+'</p>');
            return true;
        } */
        $.ajax({
            url: ajaxurl,
            method: 'post',
            data: $this.serialize(),
            dataType: 'json',
            beforeSend: function( xhr ) {
                $this.addClass('loading');
            },
            success: function( data ) {
                $this.removeClass('loading');
                if (data !== null && data.status == 'success') {
                    $this.closest('.mts_connect_ui_content').html(mtsconnect.l10n_ajax_login_success);
                    jQuery('#adminmenu .toplevel_page_mts-connect .dashicons-update').removeClass('disconnected').addClass('connected');
                    $.get(ajaxurl, 'action=mts_connect_check_themes').done(function() {
                        jQuery('.mts_connect_ui_content').append(mtsconnect.l10n_ajax_theme_check_done);
                        setTimeout(function() {
                            $.get(ajaxurl, 'action=mts_connect_check_plugins').done(function() {
                                jQuery('.mts_connect_ui_content').append(mtsconnect.l10n_ajax_plugin_check_done);
                                setTimeout(function() {
                                    window.location.href = mtsconnect.pluginurl+'&updated=1';
                                }, 100);
                            });
                        }, 1000);
                    });
                } else { // status = fail
                    var errors = '';
                    $.each(data.errors, function(i, msg) {
                        errors += '<p class="error">'+msg+'</p>';
                    });
                    $this.find('.error').remove();
                    $this.append(errors);
                }
            }
        });
    });
});