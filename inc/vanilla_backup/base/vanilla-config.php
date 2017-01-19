<?php

    /**
     * Sets up default base theme behaviour like cleaning up unused scripts, 
     * adding support for HTML5, registering a custom error handler page, etc.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Cleans up frontend elements from the HEAD like print styles, etc. 
     * 
     * @return void
     */

    function vanilla_config_cleanup_head () {

        // Only care for the frontend.

        if ( is_admin() ) {
             return;
        }

        // Remove WP head crap.

        remove_action( 'wp_head', 'rel_canonical' );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'feed_links_extra', 3 );
        remove_action( 'wp_head', 'wp_shortlink_wp_head' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'index_rel_link' );
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );

    }

    

    /**
     * Stops transformations of quotes to smart quotes, apostrophes, dashes, 
     * in post and comment contents etc. 
     * 
     * @return void
     */

    function vanilla_config_no_texturize () {

        // Only care for the frontend.

        if ( is_admin() ) {
             return;
        }

        // Fixes double apostrophe issue.

        remove_filter( 'the_content',  'wptexturize' );
        remove_filter( 'the_title',    'wptexturize' );
        remove_filter( 'the_excerpt',  'wptexturize' );
        remove_filter( 'comment_text', 'wptexturize' );

    }

    

    /**
     * Cleans up and fixes various frontend details like elements from the HEAD
     * emojis, print styles, etc. 
     * 
     * @return void
     */

    function vanilla_config_no_emojis () {

        // Only care for the frontend.

        if ( is_admin() ) {
             return;
        }

        // Disables emojis everywhere.

        remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles',     'print_emoji_styles' );
        remove_action( 'admin_print_styles',  'print_emoji_styles' );    
        remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );  
        remove_filter( 'wp_mail',             'wp_staticize_emoji_for_email' );

    }

    

    /**
     * Disables the admin bar in the frontend.
     * 
     * @return void
     */

    function vanilla_config_disable_admin_bar () {

        // Sets the admin bar filter to return false.

        add_filter( 'show_admin_bar', '__return_false' );


    }

    

    /**
     * Sets up capabilities that this theme supports.
     * 
     * @return void
     */

    function vanilla_config_setup_theme_support () {
        
        // Add HTML5 elements theme support.

        add_theme_support( 
            'html5', 
            array( 
                'comment-list', 
                'comment-form', 
                'search-form', 
                'gallery', 
                'caption' 
            )
        );


        // Use post thumbnails.

        add_theme_support( 'post-thumbnails' );

        // Support page excerpts. 

        add_post_type_support( 'page', array( 'excerpt' ) );

    }


    
    /**
     * Returns the JPEG compression quality level that WordPress will use when
     * creating new images like thumbnail sizes, etc.
     * 
     * @return int The JPEG compression quality level.
     */

    function vanilla_config_jpeg_quality () {

        if ( defined( 'VANILLA_JPEG_QUALITY' ) ) {
            return VANILLA_JPEG_QUALITY; 
        } else {
            return 75;
        }

    }


    
    /**
     * Returns excerpt length according to what the developer has defined in 
     * their functions.php.
     * 
     * @return int The excerpt length.
     */

    function vanilla_config_excerpt_length () {

        if ( defined( 'VANILLA_EXCERPT_LENGTH' ) ) {
            return VANILLA_EXCERPT_LENGTH; 
        } else {
            return 25;
        }

    }



    /**
     * Returns the posts excerpt suffix according to what the developer has 
     * defined in their functions.php.
     * 
     * @return string The posts excerpt suffix.
     */

    function vanilla_config_excerpt_more () {

        if ( defined( 'VANILLA_EXCERPT_MORE' ) ) {
            return VANILLA_EXCERPT_MORE;
        } else {
            return '&hellip;';
        }

    }



    /**
     * Registers a custom WordPress die handler for the Vanilla framework.
     * 
     * @param string $message   The WordPress error page message.
     * @param string $title     The WordPress error page title.
     * @param array  $arguments Extra error information arguments.
     * 
     * @return void
     */

    function vanilla_config_die_handler ( $message, $title = 'Die, dying, dead', $arguments = array() ) {

        // In case user is accessing the wp-admin not logged in.

        if ( strpos( $_SERVER['REQUEST_URI'], '/wp-admin/' ) !== false && ! is_user_logged_in() ) {

            // Help them remember their correct login url by adding a hint to the error message.

            $message .= '
                </p>
                <p>
                    If you cannot remember your login page url, 
                    then you should ask the Nevma team. 
                    They will tell you, but it&apos;s a secret between you and them!
                </p>
                <p>
                    <strong>Hint:</strong> 
                    It is the page where the <em>&ldquo;user logs in&rdquo;</em>&hellip; 
                    Get it?
            ';
            
        }

        nocache_headers();



        // Otherwise just show the current error

        include( locate_template( array( 'inc/vanilla/base/vanilla-error.php' ), false, false ) );

        die();
    
    }



    /**
     * Returns the name of the custom die handler for the Vanilla framework.
     * 
     * @return void
     */
    
    function vanilla_config_return_die_handler_name () {

        return 'vanilla_config_die_handler';
    
    }
    
?>