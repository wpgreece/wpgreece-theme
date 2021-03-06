<?php

    // Vanilla theme framework flags.

    define( 'VANILLA_DEBUG',       false );
    define( 'VANILLA_JPEG_QUALITY',   75 );
    define( 'VANILLA_EXCERPT_LENGTH', 25 );
    define( 'VANILLA_EXCERPT_MORE',   '&hellip;' );



    // Responsiville framework flags.

    define( 'RESPONSIVILLE_DEBUG',     false );
    define( 'RESPONSIVILLE_AUTO_INIT', true );


    // Add a custom thumbnail image size.
    
    add_image_size( 'featured-post-100', 997, 556, true );
    add_image_size( 'front-page-rectangle', 460, 345, true );

    
    // Enqueue theme specific CSS with correct dependencies after all other styles.

    function enqueue_theme_css () {

        wp_enqueue_style( 'theme-init', get_template_directory_uri() . '/css/style.init.css', array(), '', 'all' );
        wp_enqueue_style( 'theme-main', get_template_directory_uri() . '/css/style.main.css', array(), '', 'all' );
        wp_enqueue_style( 'icons', get_template_directory_uri() . '/css/icons/style.css', array(), '', 'all' );

        wp_enqueue_style( 'open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,700,700italic&subset=latin,greek', array(), '', 'all' );
        wp_enqueue_style( 'open-sans-condensed', 'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300i,700&amp;subset=greek,greek-ext', array(), '', 'all' );

    }

    add_action( 'wp_enqueue_scripts', 'enqueue_theme_css', 999 );



    // Enqueue theme specific Javascript with correct dependencies after all other scripts.
    
    function enqueue_theme_js () {

       wp_enqueue_script( 'functions', get_template_directory_uri() . '/js/functions.js', array(), '', true );
       wp_enqueue_script( 'share', get_template_directory_uri() . '/js/share.js', array(), '', true );

    }

    add_action( 'wp_enqueue_scripts', 'enqueue_theme_js', 999 );



    // Enhance default search to take custom fields into account. 
    
    function add_postmeta_to_search ( $postmeta ) {

        // $postmeta []= 'meta_key';

        return $postmeta;

    }

    add_filter( 'vanilla_postmeta_keys', 'add_postmeta_to_search' );




    // Register custom menus.

    function register_custom_menus () {

        register_nav_menus( 
            array(
                'main-navigation'   => __( 'Main Navigation', 'wpgc' ),
                'footer-main-navigation'=> __( 'Footer Main Navigation', 'wpgc' ),
                'footer-navigation' => __( 'Footer Navigation', 'wpgc' ),
                'main-sidebar-menu' =>__( 'Main Sidebar Menu', 'wpgc' )
            )
        );

    }

    add_action( 'init', 'register_custom_menus' );



    // Register sidebars.
    
    function register_custom_sidebars () {

        $args = array(
            'id'          => 'sidebar-1',
            'class'       => 'sidebar-1',
            'name'        => 'Sidebar 1',
            'description' => 'The first sidebar'
        );

        register_sidebar( $args );

    }

    add_action( 'widgets_init', 'register_custom_sidebars' );



    // Sets a page for general Nevma admin settings and options via ACF.

    function acf_setup_settings () {

        if ( is_admin() ) {
            
            if ( function_exists( 'acf_add_options_page' ) ) {

                acf_add_options_page( array(
                    'page_title' => 'Theme Options',
                    'menu_title' => 'Theme Options',
                    'menu_slug'  => 'nevma-options',
                    'capability' => 'edit_posts'
                ));

            }

        }
    
    }
    
    add_action( 'init', 'acf_setup_settings' );

    //Change Search form text button with the Hex code of the search icon
     
    function wpgc_search_form($text) {
         $text = str_replace('value="Αναζήτηση"', 'value="&#xE90E;"', $text);
         return $text;
    }

    add_filter('get_search_form', 'wpgc_search_form');

    //this adds the login form on a single topic so someone can leave a reply. It uses the same logic as form-reply
    function wpgc_new_reply_login(){
        if( !bbp_current_user_can_access_create_reply_form() && !bbp_is_topic_closed() && !bbp_is_forum_closed( bbp_get_topic_forum_id() ) ){
            bbp_get_template_part('form', 'user-login');
        }
    }

    add_action('bbp_template_after_single_topic', 'wpgc_new_reply_login');

    //this adds the login form on a single forum so someone can start a topic. It uses the same logic as form-topic
    function wpgc_new_topic_login(){
        if( !bbp_current_user_can_access_create_topic_form() && !bbp_is_forum_closed() ){
            bbp_get_template_part('form', 'user-login');
        }
    }

    add_action('bbp_template_after_single_forum', 'wpgc_new_topic_login');

    //Create related posts function

    function wpgc_related_posts() {

        if (is_single()) {

            global $post;
            $current_post = $post->ID;
            $categories = get_the_category();
            $category = $categories[0]; 
            $posts = get_posts('numberposts=3&category='. $category->term_id . '&exclude=' . $current_post); ?>
        
        <?php if( $posts ) : ?>

            <div class="more-news column">
                <h2><?php _e('Σχετικά Άρθρα', 'wpgc'); ?> </h2>
            </div>

        <?php endif; ?>

        <div class = "tablet-group-2 desktop-group-3 related-posts responsiville-equalheights" data-responsiville-equalheights-elements=".defined-title">

            <?php foreach($posts as $post) : ?>

             <article class = "small-column tablet-column-50 desktop-column-33 three-columns">

                <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">

                  <?php  include( locate_template( array( 'inc/article-structure.php' ), false, false ) ); ?>

                </a>

            </article>
             
            <?php endforeach; ?>

        </div>
        
        <?php
        }
        
        wp_reset_query();
    }

    add_action('wpgc_add_to_content','wpgc_related_posts');

     

?>
