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
            <?php /*

                <form class = "search-form" action = "<?php echo home_url(); ?>" method = "get">

                    <p>
                        <input id = "search-field" type = "text" name = "s" value = "<?php if ( ! empty( $_GET['s'] ) ) { echo $_GET['s']; } ?>" placeholder = "<?php _e( 'Search' , 'wpgc' ); ?>" />
                    </p>

                </form>
            */?>

            </div> 

            
            
            <!-- Main navigation -->

            <nav class = "navigation responsiville-mobimenu small-right laptop-column-55 large-column-60">

                <?php
                    wp_nav_menu( array(
                        'menu'           => 'Main navigation',
                        'theme_location' => 'main-navigation',
                        'container'      => '', 
                        'menu_class'     => 'main-navigation', 
                        'menu_id'        => 'main-navigation'
                    ));
                ?>

                <div class = "language-switcher-wrapper small-block laptop-right">
                    <?php echo vanilla_wpml_language_switcher(); ?>
                </div>
                
            </nav>
            
    </header>



    <!-- MAIN PAGE ELEMENT -->

    <main class = "clear">