<?php get_header(); ?>

<section class="home-page-features row responsiville-equalheights">

    <!-- POSTS -->

    <div class="featured-news tablet-column-100 laptop-column-65 laptop-push-15" style="background: <?php the_field('bg_color', 'option');?>">

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
                <?php the_post_thumbnail( 'medium' ); ?>
            </a>

            <h5 class="post-cat <?php foreach ( get_the_category() as $category ) { echo "cat-" .$category->term_id .' '; }  ?>">
                <?php the_category(' / '); ?>
            </h5>

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

    <a href="<?php the_field('banner_link'); ?>">

        <?php echo wp_get_attachment_image( $banner_image, 'full' ); ?>

    </a>

</div>

<?php endif; ?>


<!-- MORE NEWS -->

<div class="more-news column">
    <h2><?php _e('Περισσότερα Νέα'); ?> </h2>
</div>

<div class = "tablet-group-2 laptop-group-3">

    <?php $posts = get_posts( array( 'numberposts' => 6, 'suppress_filters' => 0 ) ); ?>

    <?php foreach ( $posts as $post ) : ?>

    <?php setup_postdata( $post ); ?>

    <article class = "small-column tablet-column-50 laptop-column-33 three-columns">

        <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">

            <?php get_template_part( 'inc/article', 'structure' ); ?>

        </a>

    </article>



<?php endforeach; ?>

<?php wp_reset_postdata(); ?>

</div>


<!-- MORE BLOG POSTS -->

<div class="column text-center">
    <a class="button read-more" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><?php _e('Περισσότερα Νέα'); ?></a>
</div>

</div>



<?php include('inc/left-sidebar.php'); ?>


<?php include('inc/right-sidebar.php'); ?>


</section><!-- .home-page-features row -->



<?php get_footer(); ?>