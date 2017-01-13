<!-- RELATED ARTICLES -->

<section class="row">

    <div class="panel">

        <?php
        // Default arguments
        $args = array(
            'posts_per_page' => 3, // How many items to display
            'post__not_in'   => array( get_the_ID() ), // Exclude current post
            'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
        );

        // Check for current post category and add tax_query to the query arguments
        $cats = wp_get_post_terms( get_the_ID(), 'category' ); 
        $cats_ids = array();  
        foreach( $cats as $wpex_related_cat ) {
            $cats_ids[] = $wpex_related_cat->term_id; 
        }
        if ( ! empty( $cats_ids ) ) {
            $args['category__in'] = $cats_ids;
        }

        // Query posts
        $wpex_query = new wp_query( $args );

        // Loop through posts
        foreach( $wpex_query->posts as $post ) : setup_postdata( $post ); ?>
            
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a>

        <?php
        // End loop
        endforeach;

        // Reset post data
        wp_reset_postdata(); ?>
        

    </div>
    
</section>