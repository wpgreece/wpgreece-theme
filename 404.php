<?php get_header(); ?>


<section class = "content row page-container responsiville-equalheights">

        <article class = "column tablet-column-100 laptop-column-65 laptop-push-15">

            
            <!-- ERROR 404 TITLES AND STUFF -->

            <h1><?php _e( 'The page you requested was not found', 'nevma-theme' ); ?> <?php _e( '(error 404)', 'nevma-theme' ); ?></h1>

            <p>
                <?php _e( 'Unfortunately the page you requested could not be found. We apologise for this.', 'nevma-theme' ); ?>
            </p>

            <div class = "row">

                <!-- MAIN MENU TO HELP USERS NAVIGATE -->

                <div class = "column">

                    <h3><?php _e( 'Τry the main menu:', 'nevma-theme' ); ?></h3>

                    <?php
                        wp_nav_menu ( array(
                            'menu'           => 'Main navigation',
                            'theme_location' => 'main-navigation',
                            'container'      => 'main-navigation-container', 
                            'menu_class'     => 'main-navigation-404', 
                            'menu_id'        => 'main-navigation-404'
                        ));
                    ?>

                </div>

            </div>

            <h3><?php _e( 'Happy browsing!', 'nevma-theme' ); ?></h3>

        </article>

    <?php include('inc/left-sidebar.php'); ?>
    <?php include('inc/right-sidebar.php'); ?>


</section> <!-- .content -->
   


<?php get_footer(); ?>