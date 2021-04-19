<?php

    /**
     * Vanilla theme related enhancements.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Echoes all the necessary favicons for the Vanilla framework.
     * 
     * @return void
     */
    
    function vanilla_theme_head_favicons () { ?>

        <!-- Apple icons (apple-touch-icon-precomposed). -->
        <link rel = "apple-touch-icon" sizes = "152x152" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-152x152.png" />
        <link rel = "apple-touch-icon" sizes = "144x144" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-144x144.png" />
        <link rel = "apple-touch-icon" sizes = "120x120" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-120x120.png" />
        <link rel = "apple-touch-icon" sizes = "114x114" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-114x114.png" />
        <link rel = "apple-touch-icon" sizes = "76x76"   href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-76x76.png" />
        <link rel = "apple-touch-icon" sizes = "72x72"   href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-72x72.png" />
        <link rel = "apple-touch-icon" sizes = "60x60"   href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-60x60.png" />
        <link rel = "apple-touch-icon" sizes = "57x57"   href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-57x57.png" />
        <link rel = "apple-touch-icon"                   href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-57x57.png" />

        <!-- Your regular png favicon. -->
        <link rel = "icon" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon.png" /> 
        <link rel = "icon" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon.png" sizes = "256x256"/> 

        <!-- The rest of the favicon sizes. -->
        <link rel = "icon" type = "image/png" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-16x16.png"   sizes = "16x16" />
        <link rel = "icon" type = "image/png" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-32x32.png"   sizes = "32x32" />
        <link rel = "icon" type = "image/png" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-64x64.png"   sizes = "64x64" />
        <link rel = "icon" type = "image/png" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-96x96.png"   sizes = "96x96" />
        <link rel = "icon" type = "image/png" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-160x160.png" sizes = "160x160" />
        <link rel = "icon" type = "image/png" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon-196x196.png" sizes = "196x196" />

        <!-- IE6-9 icon with all 4 dimensions. -->
        <!--[if IE]>
            <link rel = "icon" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon.ico" />
        <![endif]-->
        
        <!-- IE10 Metro start screen icon. -->
        <meta name = "msapplication-TileColor" content = "#ffffff" />
        <meta name = "msapplication-TileImage" content = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon.png" />
        
        <!-- IE10 icon with all 4 dimensions inside. -->
        <link rel = "shortcut icon" type = "image/ico" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon.ico" /> <?php

    }



    /**
     * Enqueues all the necessary CSS files necessary for the Vanilla framework
     * to function properly on the theme side.
     * 
     * @return void
     */
    
    function vanilla_theme_enqueue_css () {

        $csss = array(
            array( 'id' => 'style',                    'file' => '/style.css' ),
            array( 'id' => 'responsiville-def',        'file' => '/inc/vanilla/responsiville/css/responsiville.def.css' ),
            array( 'id' => 'responsiville-bugsy',      'file' => '/inc/vanilla/responsiville/css/responsiville.bugsy.css' ),
            array( 'id' => 'responsiville-moressette', 'file' => '/inc/vanilla/responsiville/css/responsiville.moressette.css' ),
            array( 'id' => 'responsiville-ingrid',     'file' => '/inc/vanilla/responsiville/css/responsiville.ingrid.css' ),
            array( 'id' => 'responsiville-accordion',  'file' => '/inc/vanilla/responsiville/css/responsiville.accordion.css' ),
            array( 'id' => 'responsiville-drawers',    'file' => '/inc/vanilla/responsiville/css/responsiville.drawers.css' ),
            array( 'id' => 'responsiville-megamenu',   'file' => '/inc/vanilla/responsiville/css/responsiville.megamenu.css' ),
            array( 'id' => 'responsiville-mobimenu',   'file' => '/inc/vanilla/responsiville/css/responsiville.mobimenu.css' ),
            array( 'id' => 'responsiville-popup',      'file' => '/inc/vanilla/responsiville/css/responsiville.popup.css' ),
            array( 'id' => 'responsiville-scrollmenu', 'file' => '/inc/vanilla/responsiville/css/responsiville.scrollmenu.css' ),
            array( 'id' => 'responsiville-slideshow',  'file' => '/inc/vanilla/responsiville/css/responsiville.slideshow.css' ),
            array( 'id' => 'vanilla-theme',            'file' => '/inc/vanilla/base/css/vanilla.theme.css' ),
            array( 'id' => 'nevma-popup',              'file' => '/inc/vanilla/base/css/jquery.nevma.popup-1.2.css' ),
            array( 'id' => 'nevma-anchorPopup',        'file' => '/inc/vanilla/base/css/jquery.nevma.anchorPopup-1.0.css' )
        );

        foreach ( $csss as $css ) {
            wp_enqueue_style( $css['id'],  get_template_directory_uri() . $css['file'],  array(), filemtime( get_template_directory() . $css['file'] ), 'all' );
        }

    }



    /**
     * Enqueues all the necessary Javascript files for the Vanilla framework to 
     * function properly on the theme side.
     * 
     * @return void
     */
    
    function vanilla_theme_enqueue_js () {

        // Utility variables.
        
        $in_header = false;
        $in_footer = true;



        // Polyfill.io library to minimise general browser incompatibilies.

        wp_enqueue_script( 'polyfill-io', 'https://cdn.polyfill.io/v2/polyfill.min.js', array(), null, $in_header );



        // Manually enqueue jQuery and jQuery migrate so they can be concatenated and minified in the head. 

        global $wp_scripts;

        $jquery_core    = array( 'src' => $wp_scripts->registered['jquery-core']->src,    'ver' => $wp_scripts->registered['jquery-core']->ver );
        $jquery_migrate = array( 'src' => $wp_scripts->registered['jquery-migrate']->src, 'ver' => $wp_scripts->registered['jquery-migrate']->ver );

        wp_dequeue_script( 'jquery' );
        wp_dequeue_script( 'jquery-migrate' );

        wp_deregister_script( 'jquery' );
        wp_deregister_script( 'jquery-migrate' );

        wp_enqueue_script( 'jquery',           $jquery_core['src'],    array( 'polyfill-io' ), $jquery_core['ver'],    $in_header );
        wp_enqueue_script( 'jquery-migrate-x', $jquery_migrate['src'], array( 'jquery' ),      $jquery_migrate['ver'], $in_header );



        // Vanilla enqueued scripts (the order is important).

        $jsss = array(
            array( 'id' => 'cssutils',                   'file' => '/inc/vanilla/base/js/cssutilities.nevma.min.js',                  'deps' => array( 'jquery' ),                 'place' => $in_header ),
            array( 'id' => 'fixcssvars',                 'file' => '/inc/vanilla/base/js/nevma.fixcssvars.js',                        'deps' => array( 'cssutils' ),               'place' => $in_header ),
            array( 'id' => 'fixcssvars-run',             'file' => '/inc/vanilla/base/js/nevma.fixcssvars.run.js',                    'deps' => array( 'fixcssvars' ),             'place' => $in_header ),
            array( 'id' => 'responsiville-flags',        'file' => '/inc/vanilla/base/js/responsiville.flags.js',                     'deps' => array( 'jquery' ),                 'place' => $in_header ),
            array( 'id' => 'responsiville',              'file' => '/inc/vanilla/responsiville/js/responsiville.def.js',              'deps' => array( 'responsiville-flags' ),    'place' => $in_header ),
            array( 'id' => 'responsiville-bugsy',        'file' => '/inc/vanilla/responsiville/js/responsiville.bugsy.js',            'deps' => array( 'responsiville' ),          'place' => $in_header ),
            array( 'id' => 'responsiville-events',       'file' => '/inc/vanilla/responsiville/js/responsiville.events.js',           'deps' => array( 'responsiville-bugsy' ),    'place' => $in_header ),
            array( 'id' => 'responsiville-main',         'file' => '/inc/vanilla/responsiville/js/responsiville.main.js',             'deps' => array( 'responsiville-events' ),   'place' => $in_header ),
            array( 'id' => 'responsiville-main-run',     'file' => '/inc/vanilla/responsiville/js/responsiville.main.run.js',         'deps' => array( 'responsiville-main' ),     'place' => $in_header ),
            array( 'id' => 'velocity',                   'file' => '/inc/vanilla/base/js/velocity.min.js',                            'deps' => array( 'jquery' ),                 'place' => $in_footer ),
            array( 'id' => 'hammer',                     'file' => '/inc/vanilla/base/js/hammer.min.js',                              'deps' => array( 'jquery' ),                 'place' => $in_footer ),
            array( 'id' => 'hammer-jquery',              'file' => '/inc/vanilla/base/js/jquery.hammer.js',                           'deps' => array( 'hammer' ),                 'place' => $in_footer ),
            array( 'id' => 'responsiville-accordion',    'file' => '/inc/vanilla/responsiville/js/responsiville.accordion.js',        'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-drawers',      'file' => '/inc/vanilla/responsiville/js/responsiville.drawers.js',          'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-equalheights', 'file' => '/inc/vanilla/responsiville/js/responsiville.equalheights.js',     'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-lazyimage',    'file' => '/inc/vanilla/responsiville/js/responsiville.lazymg.js',           'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-megamenu',     'file' => '/inc/vanilla/responsiville/js/responsiville.megamenu.js',         'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-mobimenu',     'file' => '/inc/vanilla/responsiville/js/responsiville.mobimenu.js',         'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-parallax',     'file' => '/inc/vanilla/responsiville/js/responsiville.parallax.js',         'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-popup',        'file' => '/inc/vanilla/responsiville/js/responsiville.popup.js',            'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-resp-element', 'file' => '/inc/vanilla/responsiville/js/responsiville.responsiveelement.js','deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-scrollmenu',   'file' => '/inc/vanilla/responsiville/js/responsiville.scrollmenu.js',       'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-slideshow',    'file' => '/inc/vanilla/responsiville/js/responsiville.slideshow.js',        'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'responsiville-run',          'file' => '/inc/vanilla/responsiville/js/responsiville.run.js',              'deps' => array( 'responsiville-main-run' ), 'place' => $in_footer ),
            array( 'id' => 'nevma-greekuppercase',       'file' => '/inc/vanilla/base/js/jquery.nevma.greekUppercase-1.0.min.js',     'deps' => array( 'jquery' ),                 'place' => $in_footer ),
            array( 'id' => 'nevma-noscrolllayer',        'file' => '/inc/vanilla/base/js/jquery.nevma.noScrollLayer-1.0.min.js',      'deps' => array( 'jquery' ),                 'place' => $in_footer ),
            array( 'id' => 'nevma-popup',                'file' => '/inc/vanilla/base/js/jquery.nevma.popup-1.2.min.js',              'deps' => array( 'jquery' ),                 'place' => $in_footer ),
            array( 'id' => 'nevma-anchorPopup',          'file' => '/inc/vanilla/base/js/jquery.nevma.anchorPopup-1.0.min.js',        'deps' => array( 'nevma-popup' ),            'place' => $in_footer )
        );

        foreach ( $jsss as $js ) {
            wp_enqueue_script( $js['id'], get_template_directory_uri() . $js['file'], $js['deps'], filemtime( get_template_directory() . $js['file'] ), $js['place'] );
        }

        vanilla_theme_head_js_localise();

    }



    /**
     * Outputs localised Javascript variables with important flags useful in the
     * theme, the vanilla framework and the responsiville framework all in their
     * corresponding Javascript scopes (THEME, RESPONSIVILLE, VANILLA).
     * 
     * @return void
     */
    
    function vanilla_theme_head_js_localise () {

        global $LANG;

        wp_localize_script( 'responsiville-flags', 'VANILLA', 
            array( 
                'LANG'                    => $LANG, 
                'BLOG_URL'                => home_url(), 
                'TEMPLATE_URL'            => get_template_directory_uri(),
                'AJAX_URL'                => admin_url( 'admin-ajax.php' ),
                'WP_DEBUG'                => defined( 'WP_DEBUG' )                && WP_DEBUG                ? true : false,
                'VANILLA_DEBUG'           => defined( 'VANILLA_DEBUG' )           && VANILLA_DEBUG           ? true : false,
                'RESPONSIVILLE_DEBUG'     => defined( 'RESPONSIVILLE_DEBUG' )     && RESPONSIVILLE_DEBUG     ? true : false,
                'RESPONSIVILLE_AUTO_INIT' => defined( 'RESPONSIVILLE_AUTO_INIT' ) && RESPONSIVILLE_AUTO_INIT ? true : false
            )
        );

    }



    /**
     * Enqueues Vanilla head scripts and styles.
     * 
     * @return void
     */

    function vanilla_theme_head_scripts_and_styles () {

        // Then enqueue Vanilla CSS stylesheets.
        
        vanilla_theme_enqueue_css();

        // Then enqueue Vanilla Javascript files.

        vanilla_theme_enqueue_js();

    }



    /**
     * Echoes a meaningful title for the generic index.php page or any other 
     * page that might require a generic but meaningful title.
     * 
     * @return void
     */

    function vanilla_theme_index_title () {

        if ( is_single() || is_page() || is_home() || is_front_page() ) {

            // Single post.
            $title = single_post_title( '', false );

        } else if ( is_category() || is_tag() ) {

            // Category archive.
            $title = single_cat_title( '', false );

        } else if ( is_tax() ) {

            // Taxonomy archive.
            $title = single_term_title( '', false );

        } else if ( is_post_type_archive() ) {

            // Post type archive.
            $title = post_type_archive_title( '', false );

        } else if ( is_author() ) {

            // Author archive.
            $title = the_author( '', false );

        } else if ( is_archive() ) {

            // Date archive.
            $title = the_archive_title( '', false );

        } else if ( is_search() ) {

            // Search page.
            global $wp_query; 

            $title = 
                __( 'You searched for: ', 'nevma-theme' ) . '&quot;' . $_GET['s'] . '&quot; <br />' . 
               '<small>' . __( 'we found', 'nevma-theme' ) . ' ' . $wp_query->found_posts . __( ' result(s)', 'nevma-theme' ) . '</small>';

        } else {

            // Whateva.
            $title = wp_title( '', false );

        }

        echo apply_filters( 'vanilla_theme_index_title', $title );
    
    }



    /**
     * Replaces greek accented letters with their non accented equivalents.
     * 
     * @param string $text The input string whose greek accented letters are to
     *                     be replaced.
     * 
     * @return string A new string with the greek accented characters replaced.
     */

    function vanilla_theme_replace_accented_letters ( $text ) {

        $acc_vowels = array( 'ά','έ','ή','ί','ΐ','ό','ύ','ΰ','ώ','ς' );

        $vowels = array( 'α','ε','η','ι','ι','ο','υ','υ','ω','σ' );

        return str_replace( $acc_vowels, $vowels, $text);

    }



    /**
     * Converts numeric representations (1..12, 01..12) or full textual 
     * representations of months in greek genitive case ("Ιανουαρίου", 
     * "Φεβρουαρίου", etc.), to the nominative case equivalent. All full textual
     * representations are expected in (and replaced with values in) lower case,
     * properly accented in greek, with the first letter capitalized.
     *
     * @param int|string $input The input to convert, in one of the following 
     *                          forms: numeric representation of a month (as an
     *                          int or string) or string containing one or more 
     *                          occurences of the genitive forms of one or more
     *                          months.
     *
     * @return string The full textual representation of the given month in 
     *                nominative case.
     *  
     * @todo Respect and work for any input case (upper/lower), accented or not.
     */

    function vanilla_theme_replace_months ( $input ) {

        $months_genitive   = array( 'Ιανουαρίου', 'Φεβρουαρίου','Μαρτίου', 'Απριλίου', 'Μαΐου', 'Ιουνίου', 'Ιουλίου', 'Αυγούστου', 'Σεπτεμβρίου', 'Οκτωβρίου', 'Νοεμβρίου', 'Δεκεμβρίου' );
        $months_nominative = array( 'Ιανουάριος', 'Φεβρουάριος','Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβριος', 'Οκτώβριος', 'Νοέμβριος', 'Δεκέμβριος' );

        if ( is_string( $input ) && ctype_digit( $input ) ) {
            $input = intval( $input );
        }

        if ( is_string( $input ) ) {
            return str_replace( $months_genitive, $months_nominative, $input );
        }

        if ( is_int( $input ) && $input >= 1 && $input <= 12 ) {
            return $months_nominative[$input-1];
        }

        return $input;
    }



    /**
     * Same as `get_the_date()` but outputs the date in Genitive correctly
     * declined, if the current active translation supports it. 
     * 
     * @param string   $date_format The format of the date to be output. 
     * @param int|null $timestamp   The timestamp of the date to be output. If 
     *                              left null then the date is obtained from the
     *                              current WordPress loop. 
     * 
     * @return string
     */
    
    function vanilla_theme_get_the_date_declined ( $date_format, $timestamp=NULL ) {

        global $wp_locale;

        if ( $timestamp == NULL ) {
            $date = get_the_date( $date_format );
        } else {  
            $date = date_i18n( $date_format, $timestamp );
        }

        if ( 'on' == _x( 'off', 'decline months names: on or off' ) ) {

            $months          = $wp_locale->month;
            $months_genitive = $wp_locale->month_genitive;
             
            foreach ( $months as $key => $month ) {
                $months[ $key ] = $month;
            }
             
            foreach ( $months_genitive as $key => $month ) {
                $months_genitive[ $key ] = ' ' . $month;
            }
           
            $date = str_replace( $months, $months_genitive, $date );

            return $date;

        } else {

            return $date;
            
        }

    }



    /**
     * Gets the url of a given image. Convenience function because WordPress 
     * does not have a direct way of returning this in one single function call.
     * 
     * @param int    $image_ID   The ID of the image as a WordPress attachment
     *                           in the media library.
     * @param string $image_size The image size being sought, ie thumbnail, 
     *                           medium, large, full, etc. Default is thumbnail.
     * 
     * @return string|bool The url of the image, or false, if no image is
     *                     available.
     */

    function vanilla_theme_get_image_src ( $image_ID, $image_size = 'thumbnail' ) {
                    
        $image_data = wp_get_attachment_image_src( $image_ID, $image_size );

        if ( $image_data ) {
            return $image_data[0]; 
        } else {
            return false;
        }
    }



    /**
     * Gets the alt of a given image as it is registered as an attachment meta.
     * 
     * @param int $image_ID The ID of the image as a WordPress attachment in the
     *                      media library.
     * 
     * @return string The alt of the image.
     */

    function vanilla_theme_get_image_alt ( $image_ID ) {

        return get_post_meta( $image_ID, '_wp_attachment_image_alt', true );
        
    }



    /**
     * Gets the title of a given image as it is registered as an attachemnt
     * post.
     * 
     * @param int $image_ID The ID of the image as a WordPress attachment in the
     *                      media library.
     * 
     * @return string The title of the image.
     */

    function vanilla_theme_get_image_title ( $image_ID ) {

        return get_the_title( $image_ID );

    }



    /**
     * Gets the description of a given image as it is registered as the content
     * of an attachment post
     * 
     * @param int $image_ID The ID of the image as a WordPress attachment in the
     *                      media library.
     * 
     * @return string The description of the image.
     */

    function vanilla_theme_get_image_description ( $image_ID ) {

        $image = get_post( $image_ID );
        $image_description = $image->post_content;

        return $image_description;

    }



    /**
     * Gets the caption of a given image as it is registered as an image 
     * attachment meta.
     * 
     * @param int $image_ID The ID of the image as a WordPress attachment in the
     *                      media library.
     * 
     * @return string The caption of the image.
     */

    function vanilla_theme_get_image_caption ( $image_ID ) {

        return wp_get_attachment_caption( $image_ID );

    }



    /**
     * Gets the best available string to be used as the alt attribute of an
     * image in HTML. Returns one of the following, whichever is found first:
     * alt, description, caption, title.
     * 
     * @param int $image_ID The ID of the image as a WordPress attachment in the
     *                      media library.
     * 
     * @return string The alt of the image.
     */

    function vanilla_theme_get_image_alt_html ( $image_ID ) {

        $image_alt = vanilla_theme_get_image_alt( $image_ID );

        if ( $image_alt ) {
            return $image_alt;
        }

        $image_description = vanilla_theme_get_image_description( $image_ID );

        if ( $image_description ) {
            return $image_description;
        }

        $image_caption = vanilla_theme_get_image_caption( $image_ID );

        if ( $image_caption ) {
            return $image_caption;
        }

        $image_title = vanilla_theme_get_image_title( $image_ID );

        if ( $image_title ) {
            return $image_title;
        }

    }



    /**
     * Checks if a post has been set as the selected value for an ACF option 
     * field. It is developed in a way that resembles the WordPress core 
     * functions is_page(), is_single() etc. Meant to be used for custom fields
     * set on options pages.
     * 
     * @param string $acf_field_slug The ACF field where the given post might
     *                               have been set as a valule.
     * @param int    $post_ID        The ID of the post to check against or the
     *                               current post if not set.
     */

    function vanilla_theme_is_page ( $acf_field_slug, $post_ID=null ) {

        if ( ! $post_ID ) {
            $post_ID = get_the_ID();
        }

        $acf_field_value = get_field( $acf_field_slug, 'option' );

        return $post_ID == $acf_field_value;

    }



    /**
     * Gets the first available image of a post's text contents. Meant to be
     * used within The Loop to retrieve a fallback featured image for a post 
     * when the real featured image is not set.
     * 
     * @return string The url of the image.
     * 
     * @todo Put a special facebook fallback image in the theme image dirctory
     *       which will be included by default when no other image is found.
     */

    function vanilla_theme_get_first_available_image () {

        global $post;
        
        $first_img = '';

        if ( ! $post ) {
            return $first_img;
        }

        $output    = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
        $first_img = count( $matches[1] ) > 0 ? $matches[1][0] : false;

        if ( ! $first_img ) { 
            $first_img = vanilla_theme_get_site_logo_url();
        }

        return $first_img;

    }



    /**
     * Echoes a best-effort meta featured image (og:image) of the current post
     * for social media sharing just in case nobody else has taken care of it. 
     * Even if YOAST is installed there cases, like the home page or the blog
     * page, where no social image is output.
     * 
     * @return void
     */

    function vanilla_theme_get_facebook_featured_image () {

        if ( is_front_page() || is_home() ) : ?>

            <meta property = "og:image" content = "<?php echo vanilla_theme_get_site_logo_url(); ?>" />

        <?php elseif ( has_post_thumbnail() ) : ?>

            <meta property = "og:image" content = "<?php echo vanilla_theme_get_image_src( get_post_thumbnail_id(), 'full' ); ?>" />

        <?php else : ?>

            <meta property = "og:image" content = "<?php echo vanilla_theme_get_first_available_image(); ?>" />

        <?php endif;

    }



    /**
     * Returns the URL of the website's logo image, after passing it through a 
     * filter to allow overrides by child themes. The default logo of the
     * website is expected to be found inside the active theme in the path
     * 'img/logo.png'. The filter is 'vanilla_get_site_logo_url'.
     * 
     * @return string The site's logo URL.
     */
    
    function vanilla_theme_get_site_logo_url () {

        return apply_filters( 'vanilla_get_site_logo_url', get_template_directory_uri() . '/img/logo.png' );

    }



    /**
     * Adds a class to the anchor elements inside WP Nav Menu items, so as to
     * enable Responsiville Megamenu for a particular menu. The class is added
     * (and thus the Megamenu is enabled) only if 'responsiville_megamenu'
     * custom arg is set in the args of 'wp_nav_menu', it resolves to true, AND
     * the particular menu item being processed has children (so that a Megamenu
     * behavior makes sense).
     *
     * @param  array  $atts HTML attributes of the anchor elements in an 
     *                      associative array.
     * @param  Object $item Object containing item details.
     * @param  Object $args Nav menu arguments
     * 
     * @return array The filtered anchor element HMTL attributes.
     */
    
    function vanilla_theme_enable_responsiville_megamenus ( $atts, $item, $args ) {

        if ( ! empty( $args->responsiville_megamenu ) && 
             ! empty( $item->classes ) && 
             in_array( 'menu-item-has-children', $item->classes ) ) {

            if ( empty( $atts['class'] ) ) {
                $atts['class'] = 'responsiville-megamenu';
            } else {
                $atts['class'] .= ' responsiville-megamenu';
            }

            if ( is_array( $args->responsiville_megamenu ) ) {
                foreach( $args->responsiville_megamenu as $key => $value) {
                    $atts['data-' . $key] = $value;
                }
            }

        }

        return $atts;

    }

?>