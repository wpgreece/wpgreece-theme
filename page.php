<?php get_header(); ?>

    <section class="page-container row responsiville-equalheights" data-responsiville-equalheights-elements=".test">



        <!-- PAGE CONTENTS -->

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <article class = "text tablet-column-100 laptop-column-65 laptop-push-15">

                <h1><?php the_title(); ?></h1>

                <?php the_post_thumbnail( 'large' ); ?>

                <?php the_content(); ?>

                <?php comments_template(); ?>

            </article>

        <?php endwhile; endif; ?>

        <?php include('inc/left-sidebar.php'); ?>
        <?php include('inc/right-sidebar.php'); ?>

    </section>

<?php get_footer(); ?>