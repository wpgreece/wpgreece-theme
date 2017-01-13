<?php

    /**
     * Contains functions useful in extending and parameterising the admin area 
     * of WordPress.
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

?>