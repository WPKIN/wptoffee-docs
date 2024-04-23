<?php

global $post;


$home_url  = get_home_url();

$title = 'Docs';
$args = array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'title' => $title,
    'posts_per_page' => 1,
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $docs_page = get_post(get_the_ID());
    }
    wp_reset_postdata();
} else {
    $docs_page = null;
}

?>

<nav class="wptoffeedocs-breadcrumb">
    <ul class="wptoffeedocs-breadcrumb-list">

		<?php

		echo '<li class="wptoffeedocs-breadcrumb-item"><a class="breadcrumb-item-link bread-home" href="' . esc_url( $home_url ) . '" title="Home">Home</a></li>';


		if ( is_tax( 'docs_category' ) || is_tax( 'doc_tag' ) ) {
			// docs page
			if ( $docs_page ) {
				$docs_page_title = $docs_page->post_title;
				$docs_page_url   = get_permalink( $docs_page->ID );

				echo '<li class="wptoffeedocs-breadcrumb-item"><a class="breadcrumb-item-link bread-home" href="' . esc_url( $docs_page_url ) . '" title="' . $docs_page_title . '">' . $docs_page_title . '</a></li>';
			}

			// category
			$query_obj = get_queried_object();
			$term_id   = $query_obj->term_id;
			$term_link = get_term_link( $term_id );
			$term_name = $query_obj->name;

			echo '<li class="wptoffeedocs-breadcrumb-item"><a class="breadcrumb-item-link bread-home" href="' . esc_url( $term_link ) . '" title="' . $term_name . '">' . $term_name . '</a></li>';

		} else if ( is_single() ) {

			// docs page
			if ( $docs_page ) {
				$docs_page_title = $docs_page->post_title;
				$docs_page_url   = get_permalink( $docs_page->ID );

				echo '<li class="wptoffeedocs-breadcrumb-item"><a class="breadcrumb-item-link bread-home" href="' . esc_url( $docs_page_url ) . '" title="' . $docs_page_title . '">' . $docs_page_title . '</a></li>';
			}

			// category
			$single_html = '';
			$cat_terms   = array();

			if ( isset( $wp_query->query_vars['docs_category'] ) ) {
				$term = get_term_by( 'slug', $wp_query->query_vars['docs_category'], 'docs_category' );
				if ( ! empty( $term ) ) {
					$cat_terms[] = $term;
				}
			}

			if ( empty( $cat_terms ) ) {
				$cat_terms = wp_get_post_terms( $post->ID, 'docs_category' );
			}

			if ( $cat_terms ) {
				// parent terms
				$parent_terms = array_filter($cat_terms, function ($terms) {
					return $terms->parent == 0;
				});
				$parent_terms = reset( $parent_terms );

				$term_link = get_term_link( $parent_terms->term_id );
				$term_name = $parent_terms->name;

				echo '<li class="wptoffeedocs-breadcrumb-item"><a class="breadcrumb-item-link bread-home" href="' . esc_url( $term_link ) . '" title="' . $term_name . '">' . esc_html($term_name) . '</a></li>';
			}

			// title
			$title = get_the_title();
			echo '<li class="wptoffeedocs-breadcrumb-item"><a class="breadcrumb-item-link bread-home" href="#" title="' . $title . '">' . $title . '</a></li>';
		}


		?>
    </ul>
</nav>
