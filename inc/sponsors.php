<!-- Sponsors -->

<?php

if( have_rows('sponsors' , 'option') ): ?>
<h2 class="widgettitle"> <?php _e('Χορηγοί', 'wpgc'); ?> </h2>
  <?php while ( have_rows('sponsors', 'option' ) ) : the_row(); ?>

    <div class="sponsors desktop-column xlarge-column-50">

         <?php 

        $sponsor_img = get_sub_field('sponsor_image', 'option');

        if( !empty( $sponsor_img ) && ( get_sub_field('sponsor_link', 'option') ) ): ?>

            <a href="<?php the_sub_field('sponsor_link','option'); ?>" target="_blank"><img src="<?php echo $sponsor_img['url']; ?>" alt="<?php echo $sponsor_img['alt']; ?>" /></a>

        <?php endif; ?>
        
    </div>


    <?php endwhile; ?>

<?php endif; ?>
