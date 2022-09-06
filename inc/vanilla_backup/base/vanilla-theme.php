<?php

    /**
     * Contains functions useful in theme coding like head meta output, favicon
     * hell, getting images, handling greek text peculiarities, etc.
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

        <?php // The rest of the favicon sizes. ?>
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
        
        <?php // IE10 icon with all 4 dimensions inside. ?>
        <link rel = "shortcut icon" type = "image/ico" href = "<?php echo get_stylesheet_directory_uri(); ?>/img/favicons/favicon.ico" /> <?php

    }



    /**
     * Enqueues all the necessary CSS files necessary for the Vanilla framework
     * to function properly on the theme side.
     * 
     * @return void
     */
    
    function vanilla_theme_enqueue_css () {

        wp_enqueue_style( 'style-css',                  get_bloginfo( 'stylesheet_url' ),                                                               array(), '', 'all' );

        wp_enqueue_style( 'responsiville',              get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.def.css',          array(), '', 'all' );
        wp_enqueue_style( 'responsiville-bugsy',        get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.bugsy.css',        array(), '', 'all' );
        wp_enqueue_style( 'responsiville-moressette',   get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.moressette.css',   array(), '', 'all' );
        wp_enqueue_style( 'responsiville-ingrid',       get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.ingrid.css',       array(), '', 'all' );

        wp_enqueue_style( 'responsiville-accordion',    get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.accordion.css',    array(), '', 'all' );
        wp_enqueue_style( 'responsiville-megamenu',     get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.megamenu.css',     array(), '', 'all' );
        wp_enqueue_style( 'responsiville-mobimenu',     get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.mobimenu.css',     array(), '', 'all' );
        wp_enqueue_style( 'responsiville-scrollmenu',   get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.scrollmenu.css',   array(), '', 'all' );
        wp_enqueue_style( 'responsiville-slideshow',    get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.slideshow.css',    array(), '', 'all' );

        wp_enqueue_style( 'vanilla-theme',              get_template_directory_uri() . '/inc/vanilla/base/css/vanilla.theme.css',                       array(), '', 'all' );
        
        wp_enqueue_style( 'nevma-popup',                get_template_directory_uri() . '/inc/vanilla/base/css/jquery.nevma.popup-1.2.css',              array(), '', 'all' );
        wp_enqueue_style( 'nevma-anchorPopup',          get_template_directory_uri() . '/inc/vanilla/base/css/jquery.nevma.anchorPopup-1.0.css',        array(), '', 'all' );

    }



    /**
     * Enqueues all the necessary Javascript files for the Vanilla framework to 
     * function properly on the theme side.
     * 
     * @return void
     */
    
    function vanilla_theme_enqueue_js () {

        // Utility variables.
        
        $version   = '';
        $in_header = false;
        $in_footer = true;



        // JQuery output in the head.
        
        wp_enqueue_script( 'jquery' ); 

        // General purpose and third-party Javascript libraries.

        wp_enqueue_script( 'velocity',                   get_template_directory_uri() . '/inc/vanilla/base/js/velocity.min.js',                        array( 'jquery' ),                   $version, $in_footer );
        wp_enqueue_script( 'hammer',                     get_template_directory_uri() . '/inc/vanilla/base/js/hammer.min.js',                          array( 'jquery' ),                   $version, $in_footer );
        wp_enqueue_script( 'hammer-jquery',              get_template_directory_uri() . '/inc/vanilla/base/js/jquery.hammer.js',                       array( 'hammer' ),                   $version, $in_footer );
        wp_enqueue_script( 'cssutilities',               get_template_directory_uri() . '/inc/vanilla/base/js/cssutilities.nevma.min.js',              array( 'jquery' ),                   $version, $in_footer );
        wp_enqueue_script( 'nevma-fixcssvars',           get_template_directory_uri() . '/inc/vanilla/base/js/nevma.fixcssvars.js',                    array( 'cssutilities' ),             $version, $in_footer );
        wp_enqueue_script( 'nevma-fixcssvars-run',       get_template_directory_uri() . '/inc/vanilla/base/js/nevma.fixcssvars.run.js',                array( 'nevma-fixcssvars' ),         $version, $in_footer );

        wp_enqueue_script( 'nevma-greekUppercase',       get_template_directory_uri() . '/inc/vanilla/base/js/jquery.nevma.greekUppercase-1.0.min.js', array( 'jquery' ),                   $version, $in_footer );
        wp_enqueue_script( 'nevma-noScrollLayer',        get_template_directory_uri() . '/inc/vanilla/base/js/jquery.nevma.noScrollLayer-1.0.min.js',  array( 'jquery' ),                   $version, $in_footer );
        wp_enqueue_script( 'nevma-popup',                get_template_directory_uri() . '/inc/vanilla/base/js/jquery.nevma.popup-1.2.min.js',          array( 'jquery' ),                   $version, $in_footer );
        wp_enqueue_script( 'nevma-anchorPopup',          get_template_directory_uri() . '/inc/vanilla/base/js/jquery.nevma.anchorPopup-1.0.min.js',    array( 'nevma-popup' ),              $version, $in_footer );
        
        // Responsiville flags for auto init and debug.

        wp_enqueue_script( 'responsiville-flags',        get_template_directory_uri() . '/inc/vanilla/base/js/responsiville.flags.js',                 array( 'jquery' ),                   $version, $in_header );

        // Responsiville scripts.

        wp_enqueue_script( 'responsiville',              get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.def.js',          array( 'jquery' ),                   $version, $in_header );
        wp_enqueue_script( 'responsiville-bugsy',        get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.bugsy.js',        array( 'responsiville' ),            $version, $in_header );
        wp_enqueue_script( 'responsiville-events',       get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.events.js',       array( 'responsiville-bugsy' ),      $version, $in_header );
        wp_enqueue_script( 'responsiville-main',         get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.main.js',         array( 'responsiville-events' ),     $version, $in_header );
        wp_enqueue_script( 'responsiville-main-run',     get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.main.run.js',     array( 'responsiville-main' ),       $version, $in_header );

        wp_enqueue_script( 'responsiville-accordion',    get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.accordion.js',    array( 'responsiville-main-run' ),   $version, $in_footer );
        wp_enqueue_script( 'responsiville-equalheights', get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.equalheights.js', array( 'responsiville-main-run' ),   $version, $in_footer );
        wp_enqueue_script( 'responsiville-megamenu',     get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.megamenu.js',     array( 'responsiville-main-run' ),   $version, $in_footer );
        wp_enqueue_script( 'responsiville-mobimenu',     get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.mobimenu.js',     array( 'responsiville-main-run' ),   $version, $in_footer );
        wp_enqueue_script( 'responsiville-scrollmenu',   get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.scrollmenu.js',   array( 'responsiville-main-run' ),   $version, $in_footer );
        wp_enqueue_script( 'responsiville-slideshow',    get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.slideshow.js',    array( 'responsiville-main-run' ),   $version, $in_footer );

        wp_enqueue_script( 'responsiville-run',          get_template_directory_uri() . '/inc/vanilla/responsiville/js/responsiville.run.js',          array( 'responsiville-main-run' ),   $version, $in_footer );

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

        wp_localize_script( 'jquery', 'THEME', 
            array( 
                'LANG'         => $LANG, 
                'BLOG_URL'     => home_url(), 
                'TEMPLATE_URL' => get_template_directory_uri(),
                'AJAX_URL'     => admin_url( 'admin-ajax.php' ),
                'WP_DEBUG'     => defined( 'WP_DEBUG' ) && WP_DEBUG ? true : false,
            )
        );

        wp_localize_script( 'jquery', 'VANILLA', 
            array( 
                'DEBUG' => defined( 'VANILLA_DEBUG' ) && VANILLA_DEBUG ? true : false
            )
        );

        wp_localize_script( 'jquery', 'RESPONSIVILLE', 
            array( 
                'DEBUG'     => defined( 'RESPONSIVILLE_DEBUG' ) && RESPONSIVILLE_DEBUG ? true : false,
                'AUTO_INIT' => defined( 'RESPONSIVILLE_AUTO_INIT' ) && RESPONSIVILLE_AUTO_INIT ? true : false
            )
        );

    }



    /**
     * 
     * 
     * @return void
     */

    function vanilla_theme_head_scripts_and_styles () {

        // First output global Javascript variables.
        
        vanilla_theme_head_js_localise();

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

        if ( is_single() ) {

            // Single post.
            single_post_title();

        } else if ( is_page() ) {

            // Single page.
            single_post_title();

        } else if ( is_home() ) {

            // Blog page.
            single_post_title();

        } else if ( is_front_page() ) {

            // Front page.
            single_post_title();

        } else if ( is_category() ) {

            // Category archive.
            _e( 'News archive - ', 'nevma-theme' );
            single_cat_title();

        } else if ( is_tag() ) {

            // Tag archive.
            _e( 'News archive - ', 'nevma-theme' );
            single_tag_title();

        } else if ( is_post_type_archive() ) {

            // Post type archive.
            post_type_archive_title();

        } else if ( is_tax() ) {

            // Taxonomy archive.
            single_term_title();

        } else if ( is_author() ) {

            // Author archive.
            _e( 'Author archive - ', 'nevma-theme' );
            the_author();

        } else if ( is_archive() ) {

            // Date archive.
            _e( 'News archive - ', 'nevma-theme' ); 

            if ( is_year() ) {
                echo get_query_var( 'year' );
            } else if ( is_month() ) {
                single_month_title( ' ' );
            }

        } else if ( is_search() ) {

            // Search page.
            global $wp_query; 

            echo __( 'You searched for: ', 'nevma-theme' ) . '&quot;' . esc_html( $_GET['s'] ) . '&quot;'; 
            echo '<br><small>' . __( 'we found', 'nevma-theme' ) . ' ' . $wp_query->found_posts . __( ' result(s)', 'nevma-theme' ) . '</small>';

        } else {

            // Whateva.
            echo '-';
            wp_title( '' );

        }
    
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

            // The image url
            return $image_data[0]; 

        } else {
            return false;
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
     * `img/logo.png`. The filter is `vanilla_get_site_logo_url`.
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
     * custom arg is set in the args of `wp_nav_menu`, it resolves to true, AND
     * the particular menu item being processed has children (so that a Megamenu
     * behavior makes sense).
     *
     * @param  array  $atts HTML attributes of the anchor elements in an associative array.
     * @param  Object $item Object containing item details.
     * @param  Object $args Nav menu arguments
     * 
     * @return array The filtered anchor element HMTL attributes.
     */
    
    function vanilla_theme_enable_responsiville_megamenus ( $atts, $item, $args ) {

        if ( ! empty( $args->responsiville_megamenu ) && ! empty( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {

            if ( empty( $atts['class'] ) ) {
                $atts['class'] = 'responsiville-megamenu';
            } else {
                $atts['class'] .= ' responsiville-megamenu';
            }

        }

        return $atts;

    }

?>
