<?php

    /**
     * Define language settings for WPML.
     */

    global $LANG;

    $LANG = defined( 'WPLANG' ) ? WPLANG : 'el';

    if ( function_exists ( 'icl_object_id' ) ) {
        $LANG = ICL_LANGUAGE_CODE;
    }

    

    /**
     * Removes WMPL scripts and styles from theme.
     * 
     * @return void
     */

    function vanilla_wpml_cleanup () {

        if ( ! function_exists ( 'icl_object_id' ) ) {
            return;
        }

        define( 'ICL_DONT_LOAD_LANGUAGES_JS',          true );
        define( 'ICL_DONT_LOAD_NAVIGATION_CSS',        true );
        define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );

        global $sitepress;

        remove_action( 'wp_head', array( $sitepress, 'meta_generator_tag' ) );
        
    }



    /**
     * Create an HTML unordered list of available languages for the current 
     * post. It works for any post type the current post belongs to.
     * 
     * @param array $args An associative array with the 'id' and 'class' of the
     *                    generated HTML list element and an associative array
     *                    named 'languages' with associations of language codes
     *                    with custom names for the respective language.
     * 
     * @return string The HTML UL element string of the available languages.
     */
     
    function vanilla_wpml_language_switcher ( $args = array( 'id' => null, 'class' => null, 'languages' => array() ) ) {

        if ( ! function_exists( 'icl_get_languages' ) ) { 
            return '';
        }

        $output = '';

        $languages = icl_get_languages( 'skip_missing=1' );


        if ( $languages ) {

            $output .=  
                '<ul'. 
                    ( $args['id'] ? ' id = "' . $args['id'] . '" ' : ' ' ) . 
                    'class = "vanilla-language-switcher' . ( $args['class'] ? ' ' . ' ' . $args['class'] : '' ) . '">';

            foreach ( $languages as $language ) {

                $language_string = ! empty( $args['languages'][$language['language_code']] ) ? $args['languages'][$language['language_code']] : $language['native_name'];

                $output .= 
                    '<li class = "vanilla-language vanilla-language-' . $language['language_code'] . '">' . 
                        '<a href = "' . $language['url'] . '" title = "' . $language_string . '">' . $language_string . '</a>' . 
                    '</li>';

            }
            
            $output .=
                '</ul><!-- .vanilla-language-switcher -->';
        }

        return $output;
    }



    /**
     * WPML helper function that gets the ID of an object's version in another
     * language, if this object has been translated.
     * 
     * @param int     $object_id       The ID of the object.
     * @param string  $object_type     The type of the object. Defaults to the
     *                                 value 'post'.
     * @param boolean $return_original Whether to return the orginal object if
     *                                 the translation is missing. Defaults to 
     *                                 false.
     * @param string  $language_code   The two letter code of the language in 
     *                                 which the original object's version is
     *                                 being sought. Defaults to null.
     * 
     * @return int The ID of the object that corresponds the original object's
     *             version in the requested language.
     */

    function vanilla_wpml_get_translation ( $object_id, $object_type='post', $return_original=false, $language_code=null ) {

        if ( function_exists ( 'icl_object_id' ) ) {
            return icl_object_id ( $object_id, $object_type, $return_original, $language_code );
        } else {
            return $object_id;
        }    

    }

?>