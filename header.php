<?php require_once ( 'head.php' ) ?>



<div class = "wrapper">



    <!-- PAGE HEADER -->

    <header class = "row">

            <!-- Logo -->

            <div class = "logo small-column-70 laptop-column-20 large-column-25">

                <?php echo is_front_page() ? '<h1>' : '' ?>

                    <a href = "<?php bloginfo ( 'url' ) ?>" title = "<?php echo bloginfo ( 'name' ); ?> - <?php _e( 'Home page', 'wpgc' ); ?>">
                        <img src = "<?php bloginfo ( 'template_url' ) ?>/img/logo.png" alt = "<?php bloginfo ( 'name' ) ?>" />
                    </a>

                <?php echo is_front_page() ? '</h1>' : '' ?>

            </div>
            
            
            <!-- Search form -->

            <div class = "column-25 small-hidden laptop-right">

                <?php get_template_part( 'inc/social', 'media' ); ?>

            </div> 
      
            
            <!-- Main navigation -->

            <div class="small-right laptop-column-55 large-column-50">
                
                <nav class="navigation responsiville-mobimenu">

                    <?php
                        wp_nav_menu( array(
                            'menu'           => 'Main navigation',
                            'theme_location' => 'main-navigation',
                            'container'      => '', 
                            'menu_class'     => 'main-navigation', 
                            'menu_id'        => 'main-navigation',
                            'responsiville_megamenu' => true,
                        ));
                    ?>
                    
                </nav>

            </div>
            
    </header>



    <!-- MAIN PAGE ELEMENT -->

    <main class = "clear">