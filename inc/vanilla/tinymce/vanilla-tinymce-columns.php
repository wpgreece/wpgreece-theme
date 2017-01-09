<?php

    /**
     * This plugin adds capabilities for adding rows and columns of the
     * Responsiville framework inside the TinyMCE editor.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */
    


    /**
     * Sets up the actions and filters which are necessary for the Vanilla
     * TinyMCE columns plugin.
     * 
     * @return void
     */
    
    function vanilla_tinymce_columns_add_plugin_action () {

        add_filter( 'mce_buttons_2',        'vanilla_tinymce_columns_add_buttons' );
        add_filter( 'mce_external_plugins', 'vanilla_tinymce_columns_add_plugin_js' );

        add_action( 'admin_head', 'vanilla_tinymce_columns_add_plugin_css' );

    }

    add_action( 'admin_init', 'vanilla_tinymce_columns_add_plugin_action' );



    /**
     * Adds the Javascript files for the Vanilla TinyMCE columns plugin. 
     * 
     * @param array $plugin_array The array that holds the plugins added to 
     *                            TinyMCE editor so far.
     * 
     * @return array The array enhanced with the Vanilla TinyMCE columns plugin.
     */

    function vanilla_tinymce_columns_add_plugin_js ( $plugin_array ) {

        $plugin_array['vanillacolumns'] = get_template_directory_uri() . '/inc/vanilla/tinymce/vanilla-tinymce-columns.js';

        return $plugin_array;

    }



    /**
     * Adds the CSS styles for the Vanilla TinyMCE columns plugin.
     * 
     * @return void
     */

    function vanilla_tinymce_columns_add_plugin_css () { 

        wp_enqueue_style( 'vanilla-tinymce-columns', get_template_directory_uri() . '/inc/vanilla/tinymce/vanilla-tinymce-columns.css', false ); 

    }



    /**
     * Adds the buttons of the Vanilla TinyMCE columns plugin.
     * 
     * @param array $buttons The array that holds the buttons added to the 
     *                       TinyMCE editor so far.
     * 
     * @return array The array enhanced with the Vanilla TinyMCE buttons for
     *               rows and columns.
     */

    function vanilla_tinymce_columns_add_buttons ( $buttons ) {

        array_push( $buttons, 'twocolumns' );
        array_push( $buttons, 'threecolumns' );
        array_push( $buttons, 'fourcolumns' );

        return $buttons;

    }

?>