<!-- SIDEBAR -->


<div class="home-sidebar tablet-column-50 laptop-column-20">

    <?php get_sidebar(); ?>

    <?php get_template_part( 'inc/join', 'forum' ); ?>

    <?php get_template_part( 'inc/meetups' ); ?>

    <?php get_template_part( 'inc/sponsors' ); ?>

    <div class="column">

        <?php gravity_form(2); ?>

    </div>

</div>
