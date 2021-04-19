<?php

    /**
     * Contains default configurations and enhancements to the TinyMCE editor
     * useful for the Vanilla WordPress framework.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */
    


    /**
     * Adds default stylings from "vanilla/tinymce/vanilla-tinymce-defaults.css" 
     * to the TinyMCE editor and imports theme specific styles as well from 
     * "css/style.tinymce.css".
     * 
     * @return void
     */
    
    function vanilla_tinymce_add_editor_styles () {

        // Vanilla default TinyMCE content stylings.
        
        add_editor_style( 'inc/vanilla/tinymce/vanilla-tinymce-defaults.css' );

        // Theme-specific TinyMCE content stylings.
        
        add_editor_style( 'css/style.tinymce.css' );

    }

    add_action( 'admin_init', 'vanilla_tinymce_add_editor_styles' );



    /**
     * Ensures the TinyMCE editor has a custom formats button.
     * 
     * @param array $buttons The TinyMCE buttons array.
     * 
     * @return void
     */
    
    function vanilla_tinymce_add_custom_formats_button ( $buttons ) {

        array_unshift( $buttons, 'styleselect' );

        return $buttons;

    }

    add_filter( 'mce_buttons_2', 'vanilla_tinymce_add_custom_formats_button' );



    /**
     * Adds custom formats contents to the TinyMCE editor. These formats are 
     * custom blockquotes, buttons, etc, which are found under the Formats
     * dropdown menu of the TinyMCE editor.
     * 
     * @param array $formats The contents of the TinyMCE editor format dropdown
     *                       menu which is to be enhanced with Vanilla stylings.
     * 
     * @return void
     */
    
    function vanilla_tinymce_add_custom_formats_styles ( $formats ) {  

        $formats_array = json_decode( $formats['style_formats'] );

        // Makes a blockquote big and shouting.

        $formats_array []= array(  
            'selector' => 'blockquote', 
            'title'    => 'Blockquote shout', 
            'block'    => 'blockquote', 
            'classes'  => 'shout',
            'wrapper'  => false
        );

        // Floats a blockquote to the left.

        $formats_array []= array(  
            'selector' => 'blockquote', 
            'title'    => 'Blockquote left', 
            'block'    => 'blockquote', 
            'classes'  => 'alignleft',
            'wrapper'  => false
        );

        // Floats a blockquote to the right.

        $formats_array []= array(  
            'selector' => 'blockquote', 
            'title'    => 'Blockquote right',
            'block'    => 'blockquote', 
            'classes'  => 'alignright',
            'wrapper'  => false
        );

        // Makes a link become like a button.

        $formats_array []= array(  
            'selector' => 'a',
            'title'    => 'Button link', 
            'classes'  => 'button inline',
            'wrapper'  => false
        );

        // Makes a text part smaller.

        $formats_array []= array(  
            'selector' => '',
            'title'    => 'Smaller text', 
            'inline'   => 'span', 
            'classes'  => 'smaller',
            'wrapper'  => false
        );

        // Makes a text part bigger.

        $formats_array []= array(  
            'selector' => '',
            'title'    => 'Bigger text', 
            'inline'   => 'span', 
            'classes'  => 'bigger',
            'wrapper'  => false
        );

        $formats['style_formats'] = json_encode( $formats_array );  
        
        return $formats;  
      
    } 

    add_filter( 'tiny_mce_before_init', 'vanilla_tinymce_add_custom_formats_styles' ); 

?>