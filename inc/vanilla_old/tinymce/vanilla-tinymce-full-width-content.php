<?php

    /**
     * Functions for setting up and executing the Vanilla framework TinyMCE full
     * content width plugin, which gives users the ability to add full with
     * content to their texts directly via a button of the editor.
     * 
     * @author Nevma, http://www.nevma.gr, info@wnevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Sets actions and filters necessary for the Vanilla TinyMCE full width content plugin.
     */
    
    function vanilla_tinymce_full_width_content_add_plugin_action () {

        add_filter( 'mce_buttons_2',        'vanilla_tinymce_full_width_content_add_button' );
        add_filter( 'mce_external_plugins', 'vanilla_tinymce_full_width_content_add_plugin_js' );

        add_action( 'admin_head', 'vanilla_tinymce_full_width_content_add_plugin_css' );

    }

    add_action( 'admin_init', 'vanilla_tinymce_full_width_content_add_plugin_action' );



    /**
     * Adds the Vanilla TinyMCE full width content plugin.
     * 
     * @param array $plugin_array The array with the TinyMCE plugins to load.
     * 
     * @return void
     */

    function vanilla_tinymce_full_width_content_add_plugin_js ( $plugin_array ) {

        $plugin_array['vanillafullwidthcontent'] = get_template_directory_uri() . '/inc/vanilla/tinymce/vanilla-tinymce-full-width-content.js';

        return $plugin_array;

    }



    /**
     * Adds the CSS styles for the Vanilla TinyMCE full width content plugin.
     */

    function vanilla_tinymce_full_width_content_add_plugin_css () { 

        wp_enqueue_style( 'vanilla-tinymce-fullwidthcontent', get_template_directory_uri() . '/inc/vanilla/tinymce/vanilla-tinymce-full-width-content.css', false ); 

    }



    /**
     * Adds the buttons of the Vanilla TinyMCE full width content plugin.
     * 
     * @param array $button The array with the TinyMCE buttons of the current 
     *                      editor toolbar row to load.
     */

    function vanilla_tinymce_full_width_content_add_button ( $buttons ) {

        array_push( $buttons, 'fullwidthcontent' );

        return $buttons;

    }



    /**
     * Implements the full width content shortcode. Breaks normal HTML flow of
     * a post's contents in order to insert a full width panel and then resumes
     * it casually.
     * 
     * @param array  $atts    The attributes added to the shortcode.
     * @param string $content The text content inside the shortcode.
     * 
     * @return string The result of the full width content shortcode execution.
     * 
     * @todo Add a filter so that the developers may set their own custom HTML
     *       content here as per their specific project markup needs.
     */
    
    function vanilla_tinymce_full_width_content_shortcode ( $atts, $content='' ) {

        $text = '' .

            // Stop normal post content flow.
            
                    '</article>' .
                '</div>' .
            '</section>' .

            // Add a full width section.
            
            '<section class = "content">' .
                '<div class = "panel panel-full">' .
                    '<article class = "text">' . 
                        vanilla_tinymce_fixpdiv( do_shortcode( vanilla_tinymce_wpautopbr( $content ) ) ) .
                    '</article>' .
                '</div>' .
            '</section>' .

            // Resume normal post content flow.
            
            '<section class = "content">' .
                '<div class = "panel">' .
                    '<article class = "column-100 text">';

        return $text;

    }

    add_shortcode( 'full-width', 'vanilla_tinymce_full_width_content_shortcode' );

?>