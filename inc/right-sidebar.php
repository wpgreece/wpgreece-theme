<!-- SIDEBAR -->


<div class="home-sidebar test tablet-column-50 laptop-column-20">

    <?php get_sidebar(); ?>

    <?php get_template_part( 'inc/join', 'forum' ); ?>

    <?php get_template_part( 'inc/meetups' ); ?>

    <div class="column newsletter">

        <?php gravity_form('Newsletter'); ?>

    </div>
 
</div>
