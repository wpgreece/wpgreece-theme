<!-- Meetups -->

<?php 

    $posts = get_posts(array(
        'numberposts'   => -1,
        'post_type'     => 'post',
        'category_name' => 'meetup',
        'meta_key'      => 'meetup_datetime',
    ));
    if ($posts): 
     foreach( $posts as $post ): 
            
            setup_postdata( $post ); ?>


<?php /* if( have_rows('meetups' , 'option') ):

    while ( have_rows('meetups', 'option' ) ) : the_row(); */?>

        <section class="row">
            
            <div class="column-100 city-meetup">
                
                <?php $city = get_field('meetup_city'); ?>

                <?php if( $city['value'] == 'athens' ): ?>

                    <img src = "<?php bloginfo ( 'template_url' ) ?>/img/meetup/athens.jpg" alt = "Athens Meetup" />

                <?php elseif ( $city['value'] == 'larissa' ): ?>

                    <img src = "<?php bloginfo ( 'template_url' ) ?>/img/meetup/larissa.jpg" alt = "Athens Meetup" />

                <?php endif; ?>

            </div>

            <div class="column-100">

                <div class="city-meetup-container">


                        <p class="next-meetup"><?php _e('Επόμενο Meetup ', 'wpgc'); ?><?php echo $city['label']; ?></p>

                        <h5><?php the_title();?> </h5>

                    <div class= "place">
                        <p><?php the_field('meetup_place'); ?></p>
                        <p><?php the_field('meetup_address'); ?></p>
                    </div> 

                    <div class="meetup-date">

                        <?php $meetup_date = get_field('meetup_datetime'); ?>
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