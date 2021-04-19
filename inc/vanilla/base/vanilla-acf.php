<?php
    
    /**
     * Vanilla ACF related enhancements.
     * 
     * @author Nevma, http://www.nevma.gr, info@nevma.gr
     * 
     * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
     */



    /**
     * Make the posts that appear in ACF relationship fields be ordered by 
     * descending date (most recent).
     * 
     * @return void
     */

    function vanilla_acf_change_relationship_field_post_order ( $args, $field, $post_id ) {
        
        $args['orderby']     = 'date';
        $args['order']       = 'DESC';
        $args['post_status'] = 'publish';
         
        return $args;
        
    }

?>