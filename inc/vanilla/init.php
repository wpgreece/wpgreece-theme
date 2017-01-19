<?php

    /**
     * Vanilla WordPress framework initialisation. Contains all initialisation
     * code for the Vanilla WordPress framework. Simply include this file in
     * your functions.php and your WordPress installation gets Vanilla flavour
     * at once.
     * 
     * @todo Make framework directory detectable or parameterizable.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * @version versionstring
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */
    


    // Just a version flag.

    define( 'VANILLA_VERSION', '1.2' );
    


    // Vanilla debug functions.

    require_once( 'base/vanilla-debug.php' );

    

    // Vanilla theme enhancements.

    require_once( 'base/vanilla-config.php' );
    require_once( 'base/vanilla-theme.php' );
    require_once( 'base/vanilla-frontend-search.php' );
    require_once( 'base/vanilla-widgets.php' );

   

    // Vanilla admin enhancements.

    require_once( 'base/vanilla-admin.php' );
    require_once( 'base/vanilla-wpml.php' );

   

    // Vanilla TinyMCE enhancements.
    
    require_once( 'tinymce/vanilla-tinymce.php' );
    require_once( 'tinymce/vanilla-tinymce-defaults.php' );
    require_once( 'tinymce/vanilla-tinymce-columns.php' );
    require_once( 'tinymce/vanilla-tinymce-full-width-content.php' );
    require_once( 'tinymce/vanilla-tinymce-accordion.php' );



    // Login page related actions and filters.

    add_action( 'login_head',            'vanilla_admin_favicon' );
    add_action( 'login_enqueue_scripts', 'vanilla_admin_login_page_css' );

    add_filter( 'login_headerurl',       'vanilla_admin_login_page_link' );
    add_filter( 'login_headertitle',     'vanilla_admin_login_page_link_title' );



    // Admin related actions and filters.

    add_action( 'init',           'vanilla_config_setup_theme_support' );
    add_action( 'admin_head',     'vanilla_admin_css' );
    add_action( 'admin_head',     'vanilla_admin_favicon' );



    // Theme related actions and filters.

    add_action( 'wp_loaded',                'vanilla_config_cleanup_head', 999 );
    add_action( 'wp_loaded',                'vanilla_config_no_texturize', 999 );
    add_action( 'wp_loaded',                'vanilla_config_no_emojis', 999 );
    add_action( 'wp_loaded',                'vanilla_config_disable_admin_bar', 999 );
    add_action( 'pre_get_posts',            'vanilla_frontend_search_setup', 999 );
    add_action( 'wp_loaded',                'vanilla_wpml_cleanup', 999 );
    add_action( 'wp_enqueue_scripts',       'vanilla_theme_head_scripts_and_styles',  10 );
    add_action( 'nav_menu_link_attributes', 'vanilla_theme_enable_responsiville_megamenus', 10, 3 );
    add_action( 'wp_footer',                'vanilla_debug_show_wp_usage_in_responsiville', 999 );
    
    add_filter( 'excerpt_length',           'vanilla_config_excerpt_length' );
    add_filter( 'excerpt_more',             'vanilla_config_excerpt_more' );
    add_filter( 'jpeg_quality',             'vanilla_config_jpeg_quality' );
    add_filter( 'bwp_minify_is_loadable',   'vanilla_debug_bwp_minify_is_loadable' );

    

    // Custom WordPress general admin error page.
        
    add_filter( 'wp_die_handler', 'vanilla_config_return_die_handler_name', 0, 3 );

?>