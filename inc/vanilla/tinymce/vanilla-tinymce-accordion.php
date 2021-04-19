<?php

    /**
     * Functions for setting up and executing the Vanilla framework TinyMCE 
     * accordion plugin which enhances it with the ability to add accordion
     * elements to WordPress texts.
     * 
     * @author Nevma, http://www.nevma.gr, info@wnevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Sets actions and filters necessary for the Vanilla TinyMCE accordion
     * plugin.
     * 
     * @return void
     */
    
    function vanilla_tinymce_accordion_add_plugin_action () {

        add_filter( 'mce_buttons_2',        'vanilla_tinymce_accordion_add_button' );
        add_filter( 'mce_external_plugins', 'vanilla_tinymce_accordion_add_plugin_js' );

        add_action( 'admin_head', 'vanilla_tinymce_accordion_add_plugin_css' );

    }

    add_action( 'admin_init', 'vanilla_tinymce_accordion_add_plugin_action' );



    /**
     * Adds the Vanilla TinyMCE accordion plugin.
     * 
     * @param array $plugin_array The array with the TinyMCE plugins to load.
     * 
     * @return array The array enhanced.
     */

    function vanilla_tinymce_accordion_add_plugin_js ( $plugin_array ) {

        $plugin_array['vanillaaccordion'] = get_template_directory_uri() . '/inc/vanilla/tinymce/js/vanilla-tinymce-accordion.js';

        return $plugin_array;

    }



    /**
     * Adds the CSS styles for the Vanilla TinyMCE accordion plugin.
     * 
     * @return void
     */

    function vanilla_tinymce_accordion_add_plugin_css () { 

        wp_enqueue_style( 'vanilla-tinymce-accordion', get_template_directory_uri() . '/inc/vanilla/tinymce/css/vanilla-tinymce-accordion.css', false ); 

    }



    /**
     * Adds the buttons of the Vanilla TinyMCE accordion plugin.
     * 
     * @param array $button The array with the TinyMCE buttons of the current 
     *                      editor toolbar row to load.
     * 
     * @return void
     */

    function vanilla_tinymce_accordion_add_button ( $buttons ) {

        array_push( $buttons, 'accordion' );

        return $buttons;

    }



    /**
     * Implements the accordion element shortcode. 
     * 
     * @param array  $atts    The attributes added to the shortcode.
     * @param string $content The text content inside the shortcode.
     * 
     * @return string The result of the accordion shortcode execution.
     */
    
    function vanilla_tinymce_accordion_shortcode ( $atts, $content='' ) {

        $result = '' .
            '<div class = "responsiville-accordion">' . 
                do_shortcode( vanilla_tinymce_wpautopbr( $content ) ) .
            '</div>';

        // Remove extraneous line breaks between accordion internal elements.

        $result = preg_replace( '/\/div>\s*<br\s*\/>\s*<div/', '/div><div', $result );

        return $result;

    }

    add_shortcode( 'accordion', 'vanilla_tinymce_accordion_shortcode' );



    /**
     * Implements the accordion panel element shortcode. 
     * 
     * @param array  $atts    The attributes added to the shortcode.
     * @param string $content The text content inside the shortcode.
     * 
     * @return string The result of the accordion panel shortcode execution.
     */
    
    function vanilla_tinymce_accordion_panel_shortcode ( $atts, $content='' ) {

        return '' .
            '<div class = "responsiville-accordion-panel">' . 
                do_shortcode( vanilla_tinymce_wpautopbr( $content ) ) .
            '</div>';

    }

    add_shortcode( 'accordion-panel', 'vanilla_tinymce_accordion_panel_shortcode' );



    /**
     * Implements the accordion header element shortcode. 
     * 
     * @param array  $atts    The attributes added to the shortcode.
     * @param string $content The text content inside the shortcode.
     * 
     * @return string The result of the accordion header shortcode execution.
     */
    
    function vanilla_tinymce_accordion_header_shortcode ( $atts, $content='' ) {

        return '' .
            '<div class = "responsiville-accordion-header">' . 
                do_shortcode( vanilla_tinymce_wpautopbr( $content ) ) .
            '</div>';

    }

    add_shortcode( 'accordion-header', 'vanilla_tinymce_accordion_header_shortcode' );



    /**
     * Implements the accordion excerpt element shortcode. 
     * 
     * @param array  $atts    The attributes added to the shortcode.
     * @param string $content The text content inside the shortcode.
     * 
     * @return string The result of the accordion excerpt shortcode execution.
     */
    
    function vanilla_tinymce_accordion_excerpt_shortcode ( $atts, $content='' ) {

        return '' .
            '<div class = "responsiville-accordion-excerpt">' . 
                do_shortcode( vanilla_tinymce_wpautopbr( $content ) ) .
            '</div>';

    }

    add_shortcode( 'accordion-excerpt', 'vanilla_tinymce_accordion_excerpt_shortcode' );



    /**
     * Implements the accordion content element shortcode. 
     * 
     * @param array  $atts    The attributes added to the shortcode.
     * @param string $content The text content inside the shortcode.
     * 
     * @return string The result of the accordion content shortcode execution.
     */
    
    function vanilla_tinymce_accordion_content_shortcode ( $atts, $content='' ) {

        return '' .
            '<div class = "responsiville-accordion-content">' .  
                do_shortcode( vanilla_tinymce_wpautopbr( $content ) ) .
            '</div>';

    }

    add_shortcode( 'accordion-content', 'vanilla_tinymce_accordion_content_shortcode' );

?>