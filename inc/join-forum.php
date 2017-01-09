<!-- Join our Forum -->

<?php 

$forum_img = get_field('forum_background_image', 'option');

if( !empty($forum_img) ): ?>

<section class="row join-forum">

    <div class="column-100 join-forum-image">

        <img src="<?php echo $forum_img['url']; ?>" alt="<?php echo $forum_img['alt']; ?>" />

    </div>

    <div class="column-100 join-forum-container">

        <?php if ( get_field('forum_text_title', 'option') ) : ?>

            <h6><strong><?php the_field('forum_text_title', 'option'); ?></strong></h6>

        <?php endif; ?>

        <?php if ( get_field('forum_text_subtitle', 'option') ) : ?>

            <p><?php the_field('forum_text_subtitle', 'option'); ?></p>

        <?php endif; ?>

        <?php if ( get_field('forum_button_text', 'option') && get_field('forum_button_link', 'option' ) ) : ?>

            <a class ="button read-more" href="<?php the_field('forum_button_link', 'option'); ?>"><?php the_field('forum_button_text', 'option'); ?></a>

        <?php endif; ?>

    </div>
        
    

</section>

<?php endif; ?>