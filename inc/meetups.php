<!-- Meetups -->

<?php 

    $date_now = date('Y-m-d H:i:s');
    $time_now = strtotime($date_now);


    // find date time in 7 days
    $time_next_week = strtotime('+365 day', $time_now);
    $date_next_week = date('Y-m-d H:i:s', $time_next_week);


    // query events
    $posts = get_posts(array(
        'posts_per_page'    => -1,
        'post_type'         => 'post',
        'category_name'     => 'meetup',
        'meta_query'        => array(
            array(
                'key'           => 'meetup_datetime',
                'compare'       => 'BETWEEN',
                'value'         => array( $date_now, $date_next_week ),
                'type'          => 'DATETIME'
            )
        ),
        'order'             => 'ASC',
        'orderby'           => 'meta_value',
        'meta_key'          => 'meetup_datetime',
        'meta_type'         => 'DATETIME'
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