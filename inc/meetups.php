<!-- Meetups -->

<?php 

if( have_rows('meetups' , 'option') ):

    while ( have_rows('meetups', 'option' ) ) : the_row(); ?>

        <section class="row">
            
            <div class="column-100 city-meetup">

                <?php 

                $meetup_img = get_sub_field('image_map', 'option');

                if( !empty($meetup_img) ): ?>

                    <img src="<?php echo $meetup_img['url']; ?>" alt="<?php echo $meetup_img['alt']; ?>" />

                <?php endif; ?>

            </div>

            <div class="column-100">

                <div class="city-meetup-container">

                    <?php if( get_sub_field('meetup_title', 'option') ) :?>

                        <p class="next-meetup"><?php _e('Next Meetup '); ?><?php the_sub_field( 'city_name', 'option' ); ?></p>

                        <h5><?php the_sub_field('meetup_title', 'option'); ?></h5>

                    <?php endif; ?>

                    <div class= "place">
                        <p><?php the_sub_field('meetup_place_title', 'option'); ?></p>
                        <p><?php the_sub_field('meetup_place_subtitle', 'option'); ?></p>
                    </div>

                     <?php /* <div class="meetup-date">
                         <p><?php the_sub_field('meetup_date_and_time', 'option'); ?></p>
                     </div> */?>
                    <div class="meetup-date">

                        <?php $meetup_date = get_sub_field('meetup_date', 'option'); ?>
                        <?php if ($meetup_date < current_time() ) : ?>
                        <p><?php echo date_i18n( $meetup_date ); ?></p>
                        <?php endif; ?>

                        <?php echo current_time();?>
                    </div>

                 </div>

            </div>

        </section>

    <?php endwhile; ?>

<?php endif; ?>