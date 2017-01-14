
<?php if ( has_post_thumbnail() ) : ?>

        <?php the_post_thumbnail( 'medium' ); ?>

    <?php else: ?>

         <img src = "<?php the_field('default_featured_image', 'option');?>" alt = "<?php the_title(); ?>" />

    <?php endif; ?>

<?php get_template_part( 'inc/primary' ); ?>

<div class="more-news-container">

    <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">
        <h4 class="defined-title"><?php the_title(); ?></h4>
    </a>

    <div class="post-meta"> 
   
        <h6 class= "post-author"> <?php _e('Απο', 'wpgc'); ?> <?php the_author(); ?></h6>

        <h6 class="post-date"><?php the_time('d/m/y'); ?></h6>

    </div>
    
</div>
