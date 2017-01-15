<?php get_header(); ?>

<section class="home-page-features row responsiville-equalheights" data-responsiville-equalheights-elements=".test">

    <!-- POSTS -->

    <div class="featured-news tablet-column-100 laptop-column-65 laptop-push-15">

        <!-- FEATURED POSTS -->


        <?php

        $posts = get_field('featured_posts');

        $post_counter = 0;

        if ($posts) : ?>

        <?php foreach ( $posts as $post ) : ?>

        <?php setup_postdata( $post ); ?>

        <?php if( $post_counter == 0 ) : ?>

            <?php include( 'inc/featured-article.php' ); ?>

    <?php else : ?>

    <article class = "featured-article-small column tablet-column-50">

        <div class="featured-article-image">

            <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">

                <?php if ( has_post_thumbnail() ) : ?>

                    <?php the_post_thumbnail( 'front-page-rectangle' ); ?>

                <?php else: ?>

                <?php 
                    $image_acf = get_field('default_featured_image', 'option');
                    $size_img_acf = 'front-page-rectangle';
                    $link_image_acf = vanilla_theme_get_image_src( $image_acf, $size_img_acf ); ?>

                     <img src = "<?php echo $link_image_acf; ?>" alt = "<?php the_title(); ?>" />

                <?php endif; ?>

            </a>

          <?php get_template_part( 'inc/primary' ); ?>

        </div>


        <div class ="featured-article-small-container">

            <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">
                <h3><?php the_title(); ?></h3>
            </a>

        
            <div class="post-meta"> 

                <h6 class= "post-author"> <?php _e('Απο', 'wpgc'); ?> <?php the_author(); ?></h6>

                <h6 class="post-date"><?php the_time('d/m/y'); ?></h6>

            </div>

        </div>

    </article>


<?php endif; ?>

<?php $post_counter++; endforeach; ?>

<?php wp_reset_postdata(); ?>

<?php endif; ?>


<!-- BANNER ADVERTISEMENT -->

<?php 

$banner_image = get_field('fullwidth_banner');

if( !empty($banner_image) ): ?>

<div class="column full-width-banner">

    <a href="<?php the_field('banner_link'); ?>" target="_blank" title="Βρείτε την ομάδα μας στο Facebook">

        <?php echo wp_get_attachment_image( $banner_image, 'full' ); ?>

    </a>

</div>

<?php endif; ?>


<!-- MORE NEWS -->

<div class="more-news column">
    <h2><?php _e('Περισσότερα Νέα', 'wpgc'); ?> </h2>
</div>

<div class = "tablet-group-2 desktop-group-3 responsiville-equalheights" data-responsiville-equalheights-elements=".defined-title">

    <?php $posts = get_posts( array( 'numberposts' => 6, 'suppress_filters' => 0 ) ); ?>

    <?php foreach ( $posts as $post ) : ?>

    <?php setup_postdata( $post ); ?>

    <article class = "small-column tablet-column-50 desktop-column-33 three-columns">

        <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">

            <?php include( 'inc/article-structure.php' ); ?>

        </a>

    </article>


<?php endforeach; ?>

<?php wp_reset_postdata(); ?>

</div>


<!-- MORE BLOG POSTS -->

<div class="column text-center">
    <a class="button read-more" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><?php _e('Περισσότερα Νέα', 'wpgc'); ?></a>
</div>

</div>



<?php include('inc/left-sidebar.php'); ?>


<?php include('inc/right-sidebar.php'); ?>


</section><!-- .home-page-features row -->



<?php get_footer(); ?>
