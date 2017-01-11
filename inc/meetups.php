<!-- Meetups -->

<?php 

    $posts = get_posts(array(
        'numberposts'   => -1,
        'post_type'     => 'post',
        'category_name'      => 'meetup',
        'meta_key'      => 'meetup_datetime',
    ));
    if ($posts): 
     foreach( $posts as $post ): 
            
            setup_postdata( $post ); ?>


<?php /* if( have_rows('meetups' , 'option') ):

    while ( have_rows('meetups', 'option' ) ) : the_row(); */?>

        <section class="row">
            
            <div class="column-100 city-meetup">

                <?php 

                $cities = get_field('meetup_city');

                if( $cities == 'athens' ): ?>

                    <img src = "<?php bloginfo ( 'template_url' ) ?>/img/meetup/athens.jpg" alt = "Athens Meetup" />

                <?php elseif ( $cities == 'larissa' ): ?>

                    <img src = "<?php bloginfo ( 'template_url' ) ?>/img/meetup/larissa.jpg" alt = "Athens Meetup" />

                <?php endif; ?>

            </div>

            <div class="column-100">

                <div class="city-meetup-container">

                        <p class="next-meetup"><?php _e('Επόμενο Meetup ', 'wpgc'); ?><?php echo $cities['value']; ); ?></p>

                        <h5><?php the_title();?> </h5>

                    <?php /* <div class= "place">
                        <p><?php the_sub_field('meetup_place_title', 'option'); ?></p>
                        <p><?php the_sub_field('meetup_place_subtitle', 'option'); ?></p>
                    </div> */?>

                    <div class="meetup-date">

                        <?php $meetup_date = get_sub_field('meetup_date', 'option'); ?>
                        <p><?php echo $meetup_date; ?></p>

                    </div>

                 </div>

            </div>

        </section>

        <?php endforeach; ?>
    
    
    <?php wp_reset_postdata(); ?>

<?php endif; ?>

    <?php /* endwhile; ?>

<?php endif; */?>