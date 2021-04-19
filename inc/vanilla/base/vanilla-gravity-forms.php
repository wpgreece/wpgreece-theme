<?php

    /**
     * Vanilla Gravity Forms related enhancements.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Require login to download or view Gravity Forms uploads.
     * 
     * @return void
     */

    function vanilla_gf_uploads_require_login () {

        if ( ! is_user_logged_in() ) {
           auth_redirect();
        }

    }

?>