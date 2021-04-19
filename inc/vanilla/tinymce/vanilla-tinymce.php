<?php

    /**
     * Convenience functions for TinyMCE enhancements in the WordPress /wp-admin
     * area by the Vanilla framework.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Sets actions and filters necessary for the Vanilla TinyMCE .
     * 
     * @return void
     */
    
    function vanilla_tinymce_add_action () {

        add_action( 'admin_head', 'vanilla_tinymce_general_css' );

    }

    add_action( 'admin_init', 'vanilla_tinymce_add_action' );



    /**
     * Adds the general CSS styles for the Vanilla TinyMCE plugins.
     * 
     * @return void
     */

    function vanilla_tinymce_general_css () { 

        wp_enqueue_style( 'vanilla-tinymce', get_template_directory_uri() . '/inc/vanilla/tinymce/css/vanilla-tinymce-admin.css', false ); 

    }



    /**
     * Adds default stylings from "vanilla/tinymce/vanilla-tinymce-defaults.css" 
     * to the TinyMCE editor and imports theme specific styles as well from 
     * "css/style.tinymce.css".
     * 
     * @return void
     */
    
    function vanilla_tinymce_add_editor_styles () {

        // Vanilla default TinyMCE content stylings.
        
        add_editor_style( 'inc/vanilla/tinymce/css/vanilla-tinymce-editor.css' );

        // Theme-specific TinyMCE content stylings.
        
        add_editor_style( 'css/style.tinymce.css' );

    }

    add_action( 'admin_init', 'vanilla_tinymce_add_editor_styles' );



    /**
     * Adds the "shortcode_unautop" function filter after the "the_content" 
     * to ensure that the extraneous opening and closing paragraphs, which are
     * added around shortcodes in tinyMCE, are removed.
     * 
     * @return void
     */
    
    function vanilla_tinymce_remove_wpautop_filters () {
    
        remove_filter( 'the_content', 'wpautop' );
        add_filter( 'the_content', 'wpautop' , 999 );
        add_filter( 'the_content', 'shortcode_unautop', 1000 );

    }

    add_filter( 'theme_init', 'vanilla_tinymce_remove_wpautop_filters' );



    /**
     * Takes a string which is meant to have been produced by TinyMCE and 
     * possibly contains shortcodes and removes any extraneous opening and 
     * closing paragrpahs and/or breaking lines from its beginning or end.
     * 
     * @param string $content The input string to clean.
     * 
     * @return string The input string cleaned.
     */
    
    function vanilla_tinymce_wpautopbr ( $content ) {

        $regexp = 
            '/'.
                 '\A' . '\s*<\/p>\s*'            . '|' . // Closing paragraph in the beginning.
                 '\A' . '\s*<br\s*\/>\s*'        . '|' . // Line break in the beginning.
                        '\s*<p>\s*'       . '\z' . '|' . // Closing paragraph in the end.
                        '\s*<br\s*\/>\s*' . '\z' .       // Line break in the end.
            '/im';
    
        $content = preg_replace( $regexp, '', $content );

        return $content;
        
    }



    /**
     * Takes a string which is meant to have been produced by TinyMCE after the 
     * shortcodes have been applied and replaces P elements that erroneously
     * enclose DIV elements. For instance, TinyMCE will wrap a [gallery...]
     * shortcode inside a P element and then the resulting DIV of the gallery
     * will be found inside that P, which is just not very nice.
     * 
     * @param string $content The input string to fix.
     * 
     * @return string The input string fixed.
     */
    
    function vanilla_tinymce_fixpdiv ( $content ) {

        // Take a <p><div> and replace it with a <div>.

        $regexp1 = '/\A\s*<p>\s*<div/im';
        $content = preg_replace( $regexp1, '<div', $content );

        // Take a </div></p> and replace it with a </div>.

        $regexp2 = '/\s*<\/div>\s*<\/p>\s*\z/im';
        $content = preg_replace( $regexp2, '</div>', $content );

        return $content;
        
    }

?>