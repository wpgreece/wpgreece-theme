<?php get_header(); ?>



<section class = "content row page-container responsiville-equalheights" data-responsiville-equalheights-elements=".test">

    <div class = "text tablet-column-100 laptop-column-65 laptop-push-15">



        <div class = "column">
            <h1><?php vanilla_theme_index_title(); ?></h1>
        </div>



        <!-- LATEST POSTS OF ANY POST TYPE -->

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <article class = "clear text">

                <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">

                    <?php if ( has_post_thumbnail() ) : ?>

                        <div class = "column tablet-column-40 text">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </div>
                        <div class = "column tablet-column-60 text">
                            <h2><?php the_title(); ?></h2>
                            <?php if ( get_post_type() == 'post' ) : ?>
                                <p class = "article-date"><?php the_date( 'l, d F Y' ); ?></p>
                            <?php endif; ?>
                            <?php the_excerpt(); ?>
                        </div>

                    <?php else : ?>

                        <div class = "column text">
                            <h2><?php the_title(); ?></h2>
                            <?php if ( get_post_type() == 'post' ) : ?>
                                <p class = "article-date"><?php the_date( 'l, d F Y' ); ?></p>
                            <?php endif; ?>
                            <?php the_excerpt(); ?>
                        </div>

                    <?php endif; ?>

                </a>

            </article>

        <?php endwhile; endif; ?>

        <?php get_template_part( 'inc/pagination' ); ?>


        
    </div> <!-- text tablet-column-100 laptop-column-65 laptop-push-15 -->

    <?php include('inc/left-sidebar.php'); ?>
    <?php include('inc/right-sidebar.php'); ?>

</section> <!-- .content -->



<?php get_footer(); ?>