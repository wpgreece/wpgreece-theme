<!-- FEATURED ARTICLE -->

<article class = "featured-article-big column tablet-column-100">

    <?php if ( has_post_thumbnail() ) : ?>

        <?php the_post_thumbnail( 'featured-post-100' ); ?>

    <?php else: ?>

         <img src = "<?php the_field('default_featured_image', 'option');?>" alt = "<?php the_title(); ?>" />

    <?php endif; ?>

    <div class="featured-article-big-container <?php if ( is_front_page() ) { echo "homepage-enabled"; } ?>">

        <div class="post-meta">

            <h5 class="post-cat <?php foreach ( get_the_category() as $category ) { echo "cat-" .$category->term_id .' '; }  ?>">

                <?php the_category(); ?>

            </h5>

            <h5 class="post-date">

                <?php the_time('d/m/y'); ?>

            </h5>

        </div>

        <div class="author-image">

            <?php echo get_avatar( get_the_author_meta('user_email') , 90 ); ?>

        </div>

        <h6><?php _e('Απο', 'wpgc'); ?> <?php the_author(); ?></h6>

        <?php if (is_front_page()): ?>

            <a href = "<?php the_permalink(); ?>" title = "<?php the_title(); ?>">

                <h3><?php the_title(); ?></h3>

                <?php the_excerpt();?>

            </a>

        <?php else: ?>

            <h3><?php the_title(); ?></h3>

            <?php get_template_part( 'inc/sharing' ); ?>


                <?php if ( has_category( 'meetup') ) : ?>

                <div class="meetup-info-container column nexus responsiville-equalheights">

                    <?php if( get_field('meetup_datetime') ) : ?>
                    
                    <div class="small column laptop-column-33 inside-article meetup-date">

                        <?php $meetup_date = get_field('meetup_datetime'); ?>
                        <p><?php echo $meetup_date; ?></p>
                        
                    </div>

                    <?php endif; ?>

                    <?php if( get_field('meetup_place') ) : ?>

                        <div class="small column laptop-column-33 inside-article place">

                            <p><?php the_field('meetup_place'); ?></p>
                            <p><?php the_field('meetup_address'); ?></p>
                            
                        </div>

                    <?php endif; ?>

                    <?php if ( get_field('meetupcom_link') ) : ?>

                        <div class="small column laptop-column-33 inside-article book-ticket">

                            <a href="<?php the_field('meetupcom_link'); ?>" title="Κάνε κράτηση">Κλείσε θέση</a>
                            
                        </div>

                    <?php endif; ?>

                </div>

                <?php endif; ?>

            <div class="text">

                <?php the_content();?>

            </div>    

        <?php endif;?>

    </div>

</article><!-- .article-container -->