<?php

	/**
	 * Contains the necessary functions so that the default WordPress search is
	 * extended in order to search inside postmeta and/or taxonomy terms attached
	 * to the post.
	 * 
	 * @author Nevma, http://www.nevma.gr, info@nevma.gr
	 * 
	 * @license http://www.gnu.org/licenses/gpl-3.0.en.html GPLv3
	 */

	/**
	 * Sets all the necessary filters and hooks so that the default WordPress
	 * search is extended in order to search inside extended data associated
	 * with each post.
	 *
	 * @return void
	 */
	
	function vanilla_frontend_search_setup ( $query ) {

		// Bail if frontend search enhancement is turned off, or this isn't a main front-end search query.
		// CAUTION: `is_search()` returns true in the admin, so check explicitly.
		if ( apply_filters( 'vanilla_enhance_frontend_search', true )
		&& $query->is_main_query()
		&& is_search()
		&& ! is_admin() ) {

			// Hook the required functions.
			add_filter( 'posts_join', 'vanilla_frontend_search_join' );
			add_filter( 'posts_where', 'vanilla_frontend_search_where_inject_placeholder', 1 );
			add_filter( 'posts_where', 'vanilla_frontend_search_where_replace_placeholder', 80 );
			add_filter( 'posts_distinct', 'vanilla_frontend_search_distinct' );

			// Hook the cleanup function so that any subsequent queries are unaffected.
			add_action( 'wp', 'vanilla_frontend_search_remove_filters' );
		}

	}

	/**
	 * Unhooks all the functions that are used by this module in order to
	 * enhance the main query in front-end search requests, so that any
	 * subsequent queries (other than the main one, that is) remain
	 * untouched.
	 * @return void
	 */
	function vanilla_frontend_search_remove_filters() {

		remove_filter( 'posts_join', 'vanilla_frontend_search_join' );
		remove_filter( 'posts_where', 'vanilla_frontend_search_where_inject_placeholder', 1 );
		remove_filter( 'posts_where', 'vanilla_frontend_search_where_replace_placeholder', 80 );
		remove_filter( 'posts_distinct', 'vanilla_frontend_search_distinct' );

	}

	/**
	 * Joins the posts table with extra tables (e.g. postmeta or taxonomy-related
	 * tables), as required. Meant to be used as a filter callback in order to
	 * extend the original database seach SQL query.
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

		// WooCommerce joins postmeta on posts itself. Skip this join if it is active.
		if ( ! empty( vanilla_frontend_search_postmeta_keys() ) && ! is_plugin_active( 'woocommerce/woocommerce.php') ) {

			$join .= ' LEFT JOIN ' . $wpdb->postmeta . ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
		}

		if ( ! empty( vanilla_frontend_search_taxonomies() ) ) {

			$join .= ' LEFT JOIN ' . $wpdb->term_relationships . ' ON ( ' . $wpdb->posts . '.ID = ' . $wpdb->term_relationships . '.object_id ) ';
			$join .= ' LEFT JOIN ' . $wpdb->term_taxonomy . ' ON ( ' . $wpdb->term_relationships . '.term_taxonomy_id = ' . $wpdb->term_taxonomy . '.term_taxonomy_id ) ';
			$join .= ' LEFT JOIN ' . $wpdb->terms . ' ON ( ' . $wpdb->terms . '.term_id = ' . $wpdb->term_taxonomy . '.term_id ) ';
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
	 * The necessary custom conditions replace the placeholder that has
	 * already been injected by
	 * `vanilla_frontend_search_where_inject_placeholder()`.
	 *
	 * This function is supposed to run at a reasonably high priority (late),
	 * so that the conditions that it injects are not likely to be matched by
	 * regexp lookups of third party code, as a false-positive.
	 * 
	 * @param string $where The original WHERE clause of the database search
	 *                      SQL query.
	 *
	 * @return string The WHERE clause of the database search SQL query,
	 *                having been extended to take into account the values of
	 *                each post's meta or associated taxonomy terms, as required.
	 */
	
	function vanilla_frontend_search_where_replace_placeholder ( $where ) {

		global $wpdb, $wp;
	   
		// Get the queried search term
		$search_term = esc_sql( $wp->query_vars[ 's' ] );

		// Trim and split to words
		$search_term_words = mb_split( '\s+', trim( $search_term ) );

		// Bail on empty input (e.g. whitespace-only)
		if ( empty( $search_term_words ) ) {

			return $where;
		}

		// The logical SQL conditions that will be merged into the original ones.
		$extra_conditions = array();

		// The postmeta keys, the values of which the extended search should take into account.
		$postmeta = vanilla_frontend_search_postmeta_keys();

		if ( ! empty( $postmeta ) ) {

			$meta_value_matches = array();

			foreach ( $search_term_words as $word ) {

				$meta_value_matches[] = "meta_value LIKE '%$word%'";
			}

			// This query returns the IDs of posts with postmeta that matches the searched term.
			$ids_of_posts_matching_postmeta = "SELECT post_id
				FROM {$wpdb->postmeta} 
				WHERE meta_key IN ( '" . implode( "', '", $postmeta ) . "' ) AND " . implode( " AND ", $meta_value_matches );

			$extra_conditions[] = "{$wpdb->posts}.ID IN ( $ids_of_posts_matching_postmeta )";

			// The taxonomy names in which the extended search should look for matching names of terms associated with each post.
			$taxonomies = vanilla_frontend_search_taxonomies();

			if ( ! empty( $taxonomies ) ) {

				$term_name_matches = array();

				foreach ( $search_term_words as $word ) {

					$term_name_matches[] = "{$wpdb->terms}.name LIKE '%$word%'";
				}

				$extra_conditions[] = "{$wpdb->term_taxonomy}.taxonomy IN( '" . implode( "', '", $taxonomies ) . "' ) AND " . implode( " AND ", $term_name_matches );

			}

			// If any extra conditions were created, inject them into the original WHERE clause.
			if ( $extra_conditions ) {

				/**
				 * There is no positive way to determine the correct injection point, due to the
				 * lack of a specific filter for that purpose, so we have to attempt to guess it.
				 * The best guess is to look for the condition that searches in post titles, and
				 * append the 'OR'ed extra conditions right after that.
				 *
				 * The search pattern matches a string like:
				 * ( wp_posts.post_title LIKE ( 'the_search_term' ) )
				 */
				$where = str_replace( '/*vanilla_search_placeholder*/', '( ' . implode( ') OR (', $extra_conditions ) . ' ) OR', $where );

			}

		}

		return $where;

	}

	/**
	 * Injects a custom placeholder comment in the original database search
	 * SQL query. Is meant to do so in an extremely low priority (early),
	 * assuming that the query has not been manipulated by third party code so
	 * far, in  order to do a best guess and mark the point where the extra
	 * custom conditions that will follow should be placed.
	 * 
	 * @param string $where The original WHERE clause of the database search
	 *                      SQL query.
	 *
	 * @return string The WHERE clause of the database search SQL query,
	 *                having been extended to take into account the values of
	 *                each post's meta or associated taxonomy terms, as required.
	 */

	function vanilla_frontend_search_where_inject_placeholder( $where ) {

		global $wpdb, $wp;
	   
		// Inject the placeholder without checking any further criteria. It is an inline comment, so it should not ruin anything even if not removed.
		$where = preg_replace(
			"/^(\s*AND\s*\()/",
			"$1 /*vanilla_search_placeholder*/ ",
			$where
		);

		return $where;
	}

	/**
	 * Returns the names of the taxonomies whose terms' names will be included in
	 * the enhanced front-end search.
	 * 
	 * @return array The names of the taxonomies whose terms' names will be included
	 *               in the enhanced front-end search.
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
	 *                been extended with a distinct clause to prevent duplicates.
	 */
	
	function vanilla_frontend_search_distinct () {

		return 'DISTINCT';
	}
	
?>