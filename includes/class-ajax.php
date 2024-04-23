<?php

class WPToffee_Docs_Ajax {

	private static $instance = null;

	public function __construct() {
		add_action( 'wp_ajax_wptoffeedocs_search', [ $this, 'search' ] );
		add_action( 'wp_ajax_nopriv_wptoffeedocs_search', [ $this, 'search' ] );
	}

	public function search() {

		$search   = ! empty( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';
		$category = ! empty( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';

		$args = [
			'post_type'      => 'docs',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			's'              => $search,
		];

		if ( $category ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'docs_category',
					'field'    => 'slug',
					'terms'    => $category,
				],
			];
		}


		$posts = get_posts( $args );

		ob_start();
		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$permalink = get_permalink( $post->ID );
				$title     = $post->post_title;

				$terms      = get_the_terms( $post->ID, 'docs_category' );
				$term       = $terms[0];
				$term_title = $term->name;

				?>
                <div class="wptoffeedocs-search-item">
                    <a href="<?php echo $permalink; ?>">
                        <h3 class="wptoffeedocs-search-item-title"><?php echo $title; ?></h3>
                        <span class="wptoffeedocs-search-item-category"><?php echo $term_title; ?></span>
                    </a>
                </div>
				<?php
			}
		} else {
			?>
            <div class="wptoffeedocs-search-item">
                <h3 class="wptoffeedocs-search-item-title">No results found</h3>
            </div>
			<?php
		}
		$html = ob_get_clean();

		wp_send_json_success( $html );

	}

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

WPToffee_Docs_Ajax::get_instance();

