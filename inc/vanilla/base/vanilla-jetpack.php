<?php

    /**
     * Vanilla Jetpack related enhancements.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Forces Jetpack to stop concatenating the CSS files of each features. This
     * way only the CSS of the enabled Jetpack features will be included, while
     * otherwise Jetpack is tricked into including all of them in the
     * concatenated version.
     * 
     * @return void
     */

    function vanilla_jetpack_stop_concatenating_css () {

        add_filter( 'jetpack_implode_frontend_css', '__return_false' );

    }

?>
