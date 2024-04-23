<?php

class WPToffee_Docs_Hooks {

	private static $instance = null;

	public function __construct() {
		//add_action( 'template_redirect', [ $this, 'docs_archive' ], - 9 );
		//add_filter( 'the_content', [ $this, 'docs_single' ], 10, 1 );
		//add_filter( 'the_title', [ $this, 'docs_title' ], 10, 2 );

		add_filter( 'single_template', [ $this, 'docs_single' ] );
		add_filter( 'page_template', [ $this, 'docs_page' ] );
		add_filter( 'archive_template', [ $this, 'docs_archive' ] );
	}

	public function docs_archive( $template ) {
		if ( is_tax( 'docs_category' ) ) {
			$template = WPTOFFEE_DOCS_TEMPLATES . '/archive.php';
		}

		return $template;
	}

	public function docs_page( $page_template ) {

		if ( is_page( 'docs' ) ) {
			$page_template = WPTOFFEE_DOCS_TEMPLATES . '/docs.php';
		}

		return $page_template;
	}

	public function docs_single( $single_template ) {

		if ( get_post_type() == 'docs' ) {
			$single_template = WPTOFFEE_DOCS_TEMPLATES . '/single.php';
		}

		return $single_template;
	}

	public function docs_content() {


		if ( ! is_singular( 'docs' )
		     && ! is_tax( 'docs_category' )
		     && ! is_tax( 'docs_tag' )
		     && ! is_post_type_archive( 'docs' ) ) {
			return;
		}

		$queried_object = get_queried_object();
		global $wp_query;

		$is_tax               = is_tax( 'docs_category' );
		$is_post_type_archive = is_post_type_archive( 'docs' );
		$is_single            = is_singular( 'docs' );


		if ( $is_tax || $is_post_type_archive ) {
			$post_id   = 0;
			$post_name = ! empty( $queried_object->slug ) ? $queried_object->slug : '';

			ob_start();
			echo do_shortcode( '[wptoffee_docs]' );
			$post_content = ob_get_clean();

		} else if ( $is_single ) {
			$post_id   = $queried_object->ID;
			$post_name = $queried_object->post_name;

			ob_start();
			include_once WPTOFFEE_DOCS_TEMPLATES . '/single.php';
			$post_content = ob_get_clean();
		}


		$dummy_post_properties = array(
			'ID'                    => $post_id,
			'post_status'           => 'publish',
			'post_author'           => '',
			'post_parent'           => 0,
			'post_type'             => 'docs',
			'post_date'             => '',
			'post_date_gmt'         => '',
			'post_modified'         => '',
			'post_modified_gmt'     => '',
			'post_content'          => $post_content,
			'post_title'            => '',
			'post_excerpt'          => '',
			'post_content_filtered' => '',
			'post_mime_type'        => '',
			'post_password'         => '',
			'post_name'             => $post_name,
			'guid'                  => '',
			'menu_order'            => 0,
			'pinged'                => '',
			'to_ping'               => '',
			'ping_status'           => '',
			'comment_status'        => 'closed',
			'comment_count'         => 0,
			'filter'                => 'raw',
		);

		// Set the $post global.
		$post = new WP_Post( (object) $dummy_post_properties );

		// Copy the new post global into the main $wp_query.
		$wp_query->post  = $post;
		$wp_query->posts = array( $post );

		// Prevent comments form from appearing.
		$wp_query->post_count = 1;
		$wp_query->is_page    = true;
		$wp_query->is_single  = true;

		if ( is_tax() ) {
			$wp_query->is_single = false;
			$wp_query->is_tax    = true;
		}

		$wp_query->max_num_pages = 0;

		// Prepare everything for rendering.
		setup_postdata( $post );

		remove_all_filters( 'the_content' );
		remove_all_filters( 'the_excerpt' );
		remove_all_filters( 'the_title' );

	}

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

WPToffee_Docs_Hooks::instance();