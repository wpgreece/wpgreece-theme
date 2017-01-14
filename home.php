<?php get_header(); ?>


<section class = "content row page-container responsiville-equalheights">


       <div class="blog-container tablet-column-100 laptop-column-65 laptop-push-15">

            <div class = "column">

                <h1 class="blog-title"><?php _e( 'Όλα τα νέα μας', 'wpgc' ); ?></h1>

            </div>

            <!-- LATEST POSTS (NEWS) -->

            <div class = "tablet-group-2 laptop-group-3">

                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                <article class = "clear text small-column tablet-column-50 desktop-column-33 three-columns">

                        <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">
                            
                            <?php get_template_part( 'inc/article', 'structure' ); ?>

                        </a>

                    </article>

                <?php endwhile; endif; ?>

            </div>

            <div class = "column">
                <?php get_template_part( 'inc/pagination' ); ?>
            </div>
            
        </div>


    <?php include('inc/left-sidebar.php'); ?>
    <?php include('inc/right-sidebar.php'); ?>

</section> <!-- .content -->
  

<?php get_footer(); ?>