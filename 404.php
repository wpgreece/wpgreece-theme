<?php get_header(); ?>

<section class = "content row page-container responsiville-equalheights">

        <article class = "column tablet-column-100 laptop-column-65 laptop-push-15">
            
            <!-- ERROR 404 TITLES AND STUFF -->

            <h1><?php _e( 'Ωπ! Η σελίδα αυτή δεν βρέθηκε', 'wpgc' ); ?> <?php _e( '(Σφάλμα 404)', 'wpgc' ); ?></h1>

            <h2>
                <?php _e( 'Η σελίδα που ζητήσατε είτε έχει διαγραφεί είτε δεν υπάρχει.', 'wpgc' ); ?>
            </h2>
            
        </article>

    <?php include('inc/left-sidebar.php'); ?>
    <?php include('inc/right-sidebar.php'); ?>


</section> <!-- .content --> 

<?php get_footer(); ?>
