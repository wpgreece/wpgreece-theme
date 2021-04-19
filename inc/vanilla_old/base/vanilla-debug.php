<?php

    /**
     * Contains functions useful in debugging.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Disallows loading of BWP (Better WordPress Minify) on production websites
     * and allows it during development based on the VANILLA_DEBUG constant and 
     * the disable_minification theme option.
     * 
     * @return void
     */

    function vanilla_debug_bwp_minify_is_loadable () {

        if ( get_field( 'disable_minification', 'option' ) == true && is_user_logged_in () ) {
            return false;
        } else {
            return ! ( defined( 'VANILLA_DEBUG' ) && VANILLA_DEBUG );
        }
        
    }



    /**
     * Lists all hooked functions in the current request.
     * 
     * @param string  $tag             If given defines the hook/filter whose 
     *                                 functions are requested to be listed.
     * @param boolean $show_properties Whether to show its properties along each
     *                                 listed hooked function.
     * 
     * @return void
     */

    function vanilla_debug_list_hooked_functions ( $tag=false, $show_properties=false ) {

        global $wp_filter;

        if ( $tag ) {
            
            $hook[$tag] = $wp_filter[$tag];

            if ( ! is_array( $hook[$tag] ) ) {
                return;
            }

        } else {

          $hook = $wp_filter;
          ksort( $hook );

        }


        foreach ( $hook as $tag => $priority ) {

            echo '<pre class = "vanilla-debug">';
            echo '<strong>' . $tag . ' </strong><br>';

            ksort( $priority );

            foreach ( $priority as $priority => $function ) {

                echo '<br><strong>Priority: ' . $priority . '</strong><br>';

                foreach ( $function as $name => $properties) {

                    echo '' . $name . '(&hellip;)<br>';

                    if ( $show_properties ) {
                        var_dump( $properties );
                    }

                }
            }

            echo '</pre>';

        }

    }



    /**
     * Wraps a var_dump call in an HTML PRE element for convenience.
     * 
     * @param string $thing The PHP object that is to be printed.
     * @param string $type  A type to be added as a class to the echoed PRE 
     *                      element for convenience.
     * 
     * @return void
     */

    function vanilla_debug_var_dump ( $thing, $type = false ) {

        echo '<pre class = "vanilla-debug' . ( $type ? $type : '' ) . '">';
        var_dump( $thing );
        echo '</pre>';

    }



    /**
     * Show WordPress resources usage in responsiville debug panel (PHP time, 
     * RAM usage, MySQL queries, etc). This is done via Javascript.
     * 
     * @return void
     */

    function vanilla_debug_show_wp_usage_in_responsiville () {

        if ( ! defined( 'VANILLA_DEBUG' ) || ! VANILLA_DEBUG ) {
            return false;
        }



        $time        = str_replace( ',', '.', timer_stop( 0, 2 ) ); 
        $max_ram     = ceil( memory_get_peak_usage( true ) / 1024 / 1024 );
        $num_queries = get_num_queries();
        $username    = '&mdash;';

        $current_user = wp_get_current_user();

        if ( $current_user->ID != 0 ) {
            $username = $current_user->user_login;
        } ?>


            
        <script type = "text/javascript">

            // Show WordPress resources usage in responsiville debug panel.

            jQuery( function () {

                window.setTimeout( function () {

                    jQuery( '.responsiville-debug-controls' ).append(

                        '<section class = "responsiville-debug-wp">' +
                            '<table class = "vanilla" cellspacing = "0" cellpadding = "0"><tbody>' + 
                                '<tr>' + 
                                    '<td>PHP time</td>' + 
                                    '<td>&mdash;&gt;</td>' + 
                                    '<td><?php echo $time; ?></td>' + 
                                    '<td class = "text-left">sec</td>' + 
                                '</tr>' + 
                                '<tr>' + 
                                    '<td>PHP RAM</td>' + 
                                    '<td>&mdash;&gt;</td>' + 
                                    '<td><?php echo $max_ram; ?></td>' + 
                                    '<td class = "text-left">mb</td>' + 
                                '</tr>' + 
                                '<tr>' + 
                                    '<td>MySQL queries</td>' + 
                                    '<td>&mdash;&gt;</td>' + 
                                    '<td><?php echo $num_queries; ?></td>' + 
                                    '<td class = "text-left">#</td>' + 
                                '</tr>' + 
                                '<tr>' + 
                                    '<td>WP user</td>' + 
                                    '<td>&mdash;&gt;</td>' + 
                                    '<td><?php echo $username; ?></td>' + 
                                    '<td class = "text-left"></td>' + 
                                '</tr>' + 
                            '</tbody></table>' +
                        '</section>'

                    );
                }, 0 );

            });

        </script><?php

    }

?>