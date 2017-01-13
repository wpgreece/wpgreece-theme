<?php get_header(); ?>

<section class="page-container row responsiville-equalheights" data-responsiville-equalheights-elements=".test">

        <!-- POST CONTENTS -->

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <div class="featured-news tablet-column-100 laptop-column-65 laptop-push-15">

               <?php include( 'inc/featured-article.php' ); ?>

                <!-- RELATED ARTICLES -->
                                        
                <div class="more-news">
                    <h2><?php _e('Σχετικά Άρθρα', 'wpgc'); ?> </h2>
                </div>

                <?php comments_template(); ?>         

            </div>

        <?php endwhile; endif; ?>

    <?php include('inc/left-sidebar.php'); ?>

    <?php include('inc/right-sidebar.php'); ?>

</section>

<?php get_footer(); ?>