    </main>



    <!-- PAGE FOOTER -->

    <footer class = "row">

        <div class ="panel"> 

            <!-- Logo -->

            <div class = "small-column-100 tablet-column-33">
            
                <a href = "<?php bloginfo ( 'url' ) ?>" title = "<?php echo bloginfo ( 'name' ); ?> - <?php _e( 'Home page', 'wpgc' ); ?>">
                    <img src = "<?php bloginfo ( 'template_url' ) ?>/img/logo.png" alt = "<?php bloginfo ( 'name' ) ?>" />
                </a>

                <?php get_template_part( 'inc/social', 'media'); ?>

            </div>



            <!-- Secondary navigation -->

            <nav class = "navigation vertical small-column-100 tablet-column-33">

                <h4><?php _e( 'Χρησιμα Αρθρα', 'wpgc' ); ?></h4>

                <?php
                    wp_nav_menu ( array(
                        'menu'           => 'Footer navigation',
                        'theme_location' => 'footer-navigation',
                        'container'      => '', 
                        'menu_class'     => 'footer-navigation', 
                        'menu_id'        => 'footer-navigation'
                    ));
                ?>

            </nav>



            <!-- Secondary navigation -->

            <nav class = "navigation vertical small-column-100 tablet-column-33">

                <h4><?php _e( 'Μενου', 'wpgc' ); ?></h4>

                <?php
                    wp_nav_menu ( array(
                        'menu'           => 'Footer Main navigation',
                        'theme_location' => 'footer-main-navigation',
                        'container'      => '', 
                        'menu_class'     => 'footer-navigation', 
                        'menu_id'        => 'footer-navigation'
                    ));
                ?>

            </nav>
        </div>
            <!-- Credits -->

            <div class = "credits small-column-100 text-center">

                <p>
                &copy; <?php echo date("Y"); ?> WordPress Greek Community | web design &amp; development by the WPCG team
                </p>

            </div>
    </footer>

</div> <!-- .container -->



<!--  WORDPRESS FOOTER OUTPUT -->

<?php 
    // Output WordPress footer stuff.
    wp_footer(); 
?>



</body>

</html>

