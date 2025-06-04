<?php

///QUAN LY CAC PHAN CSS VA JS CHO ADMIN VA CLINET
// PHAN BIET ADD VO PHAN ADMIN HAY CLIENT
function header_scripts()
{

    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
        //FRONT END
        wp_register_script('bootstrap-js', URI_JS . 'bootstrap.min.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('bootstrap-js');
    
        wp_register_style('bootstrap_css', URI_CSS . 'bootstrap.css', array(), '1.0', 'all');
        wp_enqueue_style('bootstrap_css'); // Enqueue it!
    
        wp_register_style('bootstrap-theme', URI_CSS . 'bootstrap-theme.css', array(), '1.0', 'all');
        wp_enqueue_style('bootstrap-s');

        wp_register_style('style_main', URI_CSS . 'style/main.css', array(), '1.0', 'all');
        wp_enqueue_style('style_main');


    } else {
        // BACK END

        wp_register_style('style_admin', URI_CSS . 'admin/admin.css', array(), '1.0', 'all');
        wp_enqueue_style('style_admin'); // Enqueue it!

        $current_user = wp_get_current_user();
        if (!in_array('administrator', (array) $current_user->roles)) {
            wp_register_style('role_admin', URI_CSS . 'admin/admin-role.css', array(), '1.0', 'all');
            wp_enqueue_style('role_admin');
        }
    }
  
    // FRONT END AND BACK END  
    wp_register_script('jquery-ui-js', URI_JS . 'jquery-ui.min.js', array('jquery'), '1.0.0'); // Custom scripts
    wp_enqueue_script('jquery-ui-js');

    wp_register_style('jquery-ui-css', URI_CSS . 'jquery-ui.css', array(), '1.0', 'all');
    wp_enqueue_style('jquery-ui-css');

    wp_register_script('custom-js', URI_JS . 'custom.js', array('jquery'), '1.0.0'); // Custom scripts
    wp_enqueue_script('custom-js');

}

add_action('init', 'header_scripts');



