<?php

    /**
     * Overrides the default error page template for generic WordPress errors.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */
    
?>

<!DOCTYPE html>

<html lang = "en">

<head>

    <!-- GENERAL META TAGS -->

	<meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />

    <title><?php _e( 'Error', 'nevma-theme' ); ?> &mdash; <?php echo bloginfo ( 'name' ); ?></title>

    <meta name = "Author"    content = "<?php bloginfo( 'name' ); ?> &copy;" />
    <meta name = "Owner"     content = "<?php bloginfo( 'name' ); ?> &copy;" />
    <meta name = "Publisher" content = "<?php bloginfo( 'name' ); ?> &copy;" />
    <meta name = "Copyright" content = "<?php bloginfo( 'name' ); ?> &copy;" />

    <meta name = "Robots" content = "all, index, follow" />

    <meta name = "viewport" content = "width=device-width, initial-scale=1, user-scalable=1, minimal-ui" />
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" />



    <!-- FAVICONS, THE WORKS -->

    <?php
        // Output all favicons.
        vanilla_theme_head_favicons();
    ?>

    

    <!-- CSS STYLESHEETS -->
      
    <link rel = "stylesheet" href = "<?php echo get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.def.css' ?>" />
    <link rel = "stylesheet" href = "<?php echo get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.bugsy.css' ?>" />
    <link rel = "stylesheet" href = "<?php echo get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.main.css' ?>" />
    <link rel = "stylesheet" href = "<?php echo get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.moressette.css' ?>" />
    <link rel = "stylesheet" href = "<?php echo get_template_directory_uri() . '/inc/vanilla/responsiville/css/responsiville.ingrid.css' ?>" />

    <link rel = "stylesheet" href = "<?php echo get_template_directory_uri() . '/inc/vanilla/base/css/vanilla.error.css' ?>" />

</head>

<body>

    <div class = "container align-center">

        <div class = "row">



            <!-- Error header -->

            <header class = "text text-center column-full">
                <h1><?php _e( 'Error', 'nevma-theme' ); ?></h1>
            </header>



            <!-- Error main content -->

            <main class = "text column-full">
                <blockquote class = "citation">

                    <!-- Title and message are injected by WordPress -->

                    <?php if ( ! empty( $title ) ) : ?>

                        <h2><?php echo $title; ?></h2>

                    <?php endif; ?>
                    
                    <?php if ( ! empty( $message ) ) : ?>

                        <p class = "error-message"><?php echo $message; ?></p>

                    <?php endif; ?>

                </blockquote>
            </main>


            
            <!-- Error footer -->

            <footer class = "text-center column-full">

                <p><?php bloginfo( 'name' ); ?> &mdash; <?php bloginfo( 'description' ); ?></p>
                
                <div class = "logo column-80 margin-10">
                    <p>
                        <a href = "<?php echo bloginfo ( 'url' ) ?>" title = "<?php echo bloginfo ( 'name' ); ?> - <?php _e( 'Home page', 'nevma-theme' ); ?>">
                            <img src = "<?php echo vanilla_theme_get_site_logo_url(); ?>" alt = "<?php echo bloginfo ( 'name' ) ?>" />
                        </a>
                    </p>
                </div>

            </footer>


            
        </div>

    </div> <!-- .container -->
    
</body>

</html>