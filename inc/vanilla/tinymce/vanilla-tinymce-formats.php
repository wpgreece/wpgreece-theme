<?php

    /**
     * Custom formats for the the TinyMCE editor useful in the Vanilla WordPress
     * framework. 
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Sets actions and filters necessary for the Vanilla TinyMCE custom
     * formats.
     * 
     * @return void
     */
    
    function vanilla_tinymce_formats_add_action () {

        add_filter( 'mce_buttons_2', 'vanilla_tinymce_formats_add_button' );

    }

    add_action( 'admin_init', 'vanilla_tinymce_formats_add_action' );



    /**
     * Ensures the TinyMCE editor has a custom formats button.
     * 
     * @param array $buttons The TinyMCE buttons array.
     * 
     * @return array The array enhanced.
     */
    
    function vanilla_tinymce_formats_add_button ( $buttons ) {

        array_unshift( $buttons, 'styleselect' );

        return $buttons;

    }



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
    
    function vanilla_tinymce_formats_add_styles ( $formats ) {  

        if ( isset( $formats['style_formats'] ) ) {
            $formats_array = json_decode( $formats['style_formats'] );
        } else {
            $formats_array = array();
        }


        // Creates a blockquote with a .

        $formats_array []= array(  
            'selector' => 'blockquote', 
            'title'    => 'Blockquote panel', 
            'classes'  => 'panel',
            'wrapper'  => false
        );
        
        // Makes a blockquote big and shouting.

        $formats_array []= array(  
            'selector' => 'blockquote', 
            'title'    => 'Blockquote shout', 
            'classes'  => 'shout',
            'wrapper'  => false
        );

        // Floats a blockquote to the left.

        $formats_array []= array(
            'selector' => 'blockquote', 
            'title'    => 'Blockquote left', 
            'classes'  => 'alignleft',
            'wrapper'  => false
        );

        // Floats a blockquote to the right.

        $formats_array []= array(
            'selector' => 'blockquote', 
            'title'    => 'Blockquote right',
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

    add_filter( 'tiny_mce_before_init', 'vanilla_tinymce_formats_add_styles' ); 

?>