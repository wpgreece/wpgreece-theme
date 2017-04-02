
<?php if ( has_post_thumbnail() ) : ?>

        <?php the_post_thumbnail( 'front-page-rectangle' ); ?>

    <?php else: ?>

        <?php 
            $image_acf = get_field('default_featured_image', 'option');
            $size_img_acf = 'front-page-rectangle';
            $link_image_acf = vanilla_theme_get_image_src( $image_acf, $size_img_acf ); ?>

        <img src = "<?php echo $link_image_acf; ?>" alt = "<?php the_title(); ?>" />

    <?php endif; ?>

<?php get_template_part( 'inc/primary' ); ?>

<div class="more-news-container">

    <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">
        <h4 class="defined-title"><?php the_title(); ?></h4>
    </a>

    <div class="post-meta"> 
   
        <h6 class= "post-author"> <?php _e('Απο', 'wpgc'); ?> <?php the_author_posts_link(); ?></h6>

        <h6 class="post-date"><?php the_time('d/m/y'); ?></h6>

    </div>
    
</div>
