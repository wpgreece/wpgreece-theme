<!-- PAGINATION -->

<div class = "pages">

    <?php 
        global $wp_query;

        echo paginate_links( array(
            'base'     => str_replace( 999999, '%#%', get_pagenum_link( 999999 ) ),
            'format'   => '?paged=%#%',
            'end_size' => 3,
            'mid_size' => 2,
            'current'  => max( 1, get_query_var( 'paged' ) ),
            'total'    => $wp_query->max_num_pages
        )); 
    ?> 

</div> <!-- .pages -->