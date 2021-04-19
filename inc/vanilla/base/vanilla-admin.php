<?php

    /**
     * Vanilla /wp-admin related enhancements.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Set favicon for the admin and login area.
     * 
     * @return void
     */

    function vanilla_admin_favicon () {

        $favicon_path = get_template_directory_uri() . '/img/favicons/favicon.ico'; ?>

        <link rel = "shortcut icon" href = "<?php echo $favicon_path; ?>" /> <?php

    }



    /**
     * Fix various admin CSS stylings.
     * 
     * @return void
     */

    function vanilla_admin_css () { 

        wp_enqueue_style( 'vanilla-wordpress-admin', get_template_directory_uri() . '/inc/vanilla/base/css/vanilla.admin.css', false ); 

    }
    


    /**
     * Sets the login screen logos to show the website logo and the Nevma logo.
     * 
     * @return void
     */

    function vanilla_admin_login_page_css () { 

        wp_enqueue_style( 'vanilla-wordpress-login', get_template_directory_uri() . '/inc/vanilla/base/css/vanilla.login.css', false ); 

    }



    /**
     * Sets the login screen link url to point to the home page.
     * 
     * @return string The home url.
     */

    function vanilla_admin_login_page_link () {

        return home_url();

    }



    /**
     * Sets the login screen title text to the website title.
     * 
     * @return string The blog name.
     */

    function vanilla_admin_login_page_link_title() {

        return get_bloginfo( 'name' ); ;

    }



    /**
     * Add SVGs to the list of allowed mime types.
     * 
     * @param array $upload_mimes The existing allowed mime types.
     * 
     * @return array The enhanced allowed mime types.
     */

    function vanilla_admin_add_svg_to_upload_mimes( $upload_mimes ) {

        $upload_mimes['svg']  = 'image/svg+xml';
        $upload_mimes['svgz'] = 'image/svg+xml';

        return $upload_mimes;

    }

?>