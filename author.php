<?php get_header();

$author_id = get_the_author_meta('ID');
$author_meetup = get_field('organiser_of', 'user_' . $author_id);
?>



<section class="content row page-container responsiville-equalheights" data-responsiville-equalheights-elements=".test">

    <div class="text tablet-column-100 laptop-column-65 laptop-push-15">


        <!-- GET USER INFO -->

        <div class="column text-center" style="padding: 5rem;">
            <?php
            if ($author_id) :
            ?><?php echo get_avatar(get_the_author_meta('user_email'), '', $default, $alt, array('class' => array('rounded',))); ?>

        <?php endif; ?>
        <h1 style="margin: 1rem;"><?php vanilla_theme_index_title(); ?></h1>
        <?php if ($author_meetup) : ?>
            <h5 style="text-transform: uppercase;"><?php echo implode(', ', $author_meetup); ?></h5>
        <?php endif; ?>
        <p><?php $authorDesc = the_author_meta('description');
            echo $authorDesc; ?></p>
        </div>


        <!-- LATEST POSTS OF ANY POST TYPE -->

        <div class="tablet-group-2 desktop-group-3 responsiville-equalheights" data-responsiville-equalheights-elements=".defined-title">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <article class=" clear text small-column tablet-column-50 desktop-column-33 three-columns">

                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

                            <?php get_template_part('inc/article', 'structure'); ?>

                        </a>

                    </article>

            <?php endwhile;
            endif; ?>

        </div>

        <div class="column">
            <?php get_template_part('inc/pagination'); ?>
        </div>


    </div> <!-- text tablet-column-100 laptop-column-65 laptop-push-15 -->

    <?php include('inc/left-sidebar.php'); ?>
    <?php include('inc/right-sidebar.php'); ?>

</section> <!-- .content -->



<?php get_footer(); ?>