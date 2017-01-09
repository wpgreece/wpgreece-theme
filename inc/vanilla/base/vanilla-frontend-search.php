<?php

	/**
	 * Contains the necessary functions so that the default WordPress search is
	 * extended in order to search inside postmeta and/or taxonomy terms
	 * attached to the post.
	 * 
	 * @author Nevma, http://www.nevma.gr, info@nevma.gr
	 * 
	 * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
	 */



	/**
	 * Joins the posts table with extra tables (e.g. postmeta or taxonomy
	 * related tables), as required. Meant to be used as a filter callback in
	 * order to extend the original database seach SQL query.
	 * 
	 * @param string $join The original join part of the database search SQL
	 *                     query.
	 *
	 * @return string The join part of the database search SQL query, having
	 *                joined the posts table with the appropriate extra tables.
	 */
	
	function vanilla_frontend_search_join ( $join ) {

		global $wpdb;

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// Ensure this is a front-end search. CAUTION: `is_search()` returns true in the admin.
		
		if ( is_search() && ! is_admin() ) {

			// WooCommerce joins postmeta on posts itself. Skip this join if it is active.
			
			if ( ! empty( vanilla_frontend_search_postmeta_keys() ) && ! is_plugin_active( 'woocommerce/woocommerce.php') ) {

				$join .= ' LEFT JOIN ' . $wpdb->postmeta . ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
			}

			if ( ! empty( vanilla_frontend_search_taxonomies() ) ) {

				$join .= ' LEFT JOIN ' . $wpdb->term_relationships . ' ON ( ' . $wpdb->posts . '.ID = ' . $wpdb->term_relationships . '.object_id ) ';
				$join .= ' LEFT JOIN ' . $wpdb->term_taxonomy . ' ON ( ' . $wpdb->term_relationships . '.term_taxonomy_id = ' . $wpdb->term_taxonomy . '.term_taxonomy_id ) ';
				$join .= ' LEFT JOIN ' . $wpdb->terms . ' ON ( ' . $wpdb->terms . '.term_id = ' . $wpdb->term_taxonomy . '.term_id ) ';
			}

		}
		
		return $join;

	}



	/**
	 * Extends the original database search SQL query in order to take into 
	 * account extended data associated with each post. The extended data can
	 * be postmeta values and/or taxonomy term names of terms associated with
	 * each post. Meant to be used as a filter callback in order to extend the
	 * original database seach SQL query.
	 * 
	 * @param string $where The original where part of the database search SQL
	 *                      query.
	 *
	 * @return string The where part of the database search SQL query, having
	 *                been extended to take into account the values of each
	 *                post's meta or associated taxonomy terms, as required.
	 */
	
	function vanilla_frontend_search_where ( $where ) {

		global $wpdb, $wp;
	   
		// Ensure this is a front-end search. CAUTION: `is_search()` returns true in the admin as well.
		
		if ( is_search() && ! is_admin() ) {

			// Get the queried search term
			
			$search_term = esc_sql( $wp->query_vars[ 's' ] );

			// The logical SQL conditions that will be merged to the original ones.
			
			$extra_conditions = array();

			// The postmeta keys, the values of which the extended search should take into account.
			
			$postmetas = vanilla_frontend_search_postmeta_keys();

			if ( ! empty( $postmetas ) ) {

				// This query returns the IDs of posts with postmeta that matches the searched term.
				$ids_of_posts_matching_postmeta = "SELECT post_id
					FROM {$wpdb->postmeta} 
					WHERE meta_key IN ( '" . implode( "', '", $postmetas ) . "' ) AND meta_value LIKE '%%$search_term%%'";

				$extra_conditions[] = "{$wpdb->posts}.ID IN ( $ids_of_posts_matching_postmeta )";
			}

			

			// The taxonomy names in which the extended search should look for matching names of terms associated with each post.
			
			$taxonomies = vanilla_frontend_search_taxonomies();

			if ( ! empty( $taxonomies ) ) {

				$extra_conditions[] = "{$wpdb->term_taxonomy}.taxonomy IN( '" . implode( "', '", $taxonomies ) . "' ) AND {$wpdb->terms}.name = '$search_term'";
			}

			

			// If any extra conditions were created, inject them into the original WHERE clause.
			
			if ( $extra_conditions ) {

				/**
				 * There is no positive way to determine the correct injection point, due to the
				 * lack of a specific filter for that purpose, so we have to attempt to guess it.
				 * The best guess is to look for the condition that searches in post titles, and
				 * append the extra `OR` conditions right after it.
				 *
				 * The search pattern matches a string like:
				 * ( wp_posts.post_title LIKE ( 'the_search_term' ) )
				 */
				$where = preg_replace(
					"/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
					"({$wpdb->posts}.post_title LIKE $1) OR ( " . implode( ') OR (', $extra_conditions ) . " )",
					$where
				);

			}

		}

		return $where;

	}



	/**
	 * Returns the names of the taxonomies whose terms' names will be included
	 * in the enhanced front-end search.
	 * 
	 * @return array The names of the taxonomies whose terms' names will be
	 *               included in the enhanced front-end search.
	 */
	
	function vanilla_frontend_search_taxonomies() {

		return apply_filters( 'vanilla_search_taxonomies', array() );

	}



	/**
	 * Returns the meta_keys of postmeta that will be included in the enhanced
	 * front-end search.
	 * 
	 * @return array The meta_keys for which the corresponding meta_value will
	 *               be compared against the search term.
	 */
	
	function vanilla_frontend_search_postmeta_keys() {

		return apply_filters( 'vanilla_search_postmeta_keys', array() );

	}



	/**
	 * Extends the original database seach SQL query with a distinct clause to
	 * prevent duplicates. Meant to be used as a filter callback in order to
	 * extend the original database seach SQL query.
	 *
	 * @return string The where part of the database search SQL query, having
	 *                been extended with a distinct clause to prevent
	 *                duplicates.
	 */
	
	function vanilla_frontend_search_distinct () {

		// Ensure this is a front-end search. CAUTION: `is_search()` returns true in the admin as well.
		
		if ( is_search() && ! is_admin() ) {
			return 'DISTINCT';
		}

		return '';

	}
 


	/**
	 * Sets all the necessary filters and hooks so that the default WordPress
	 * search is extended in order to search inside extended data associated
	 * with each post.
	 *
	 * @return void
	 */
	
	function vanilla_frontend_search_setup () {

		// Bail if frontend search enhancement is turned off.
		
		if ( ! apply_filters( 'vanilla_enhance_frontend_search', true ) ) {
			return;
		}

		// Hook the required functions.
		
		add_filter( 'posts_join', 'vanilla_frontend_search_join' );
		add_filter( 'posts_where', 'vanilla_frontend_search_where' );
		add_filter( 'posts_distinct', 'vanilla_frontend_search_distinct' );

	}

?>