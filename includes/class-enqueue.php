<?php

defined( 'ABSPATH' ) || exit();

class WPToffeeDocs_Enqueue {

	private static $instance = null;

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
	}

	/**
	 * Frontend Scripts
	 *
	 * @param $hook
	 */
	public function frontend_scripts( $hook ) {

		/* enqueue frontend styles */
		wp_enqueue_style( 'wptoffee-docs-frontend', WPTOFFEE_DOCS_ASSETS . '/css/frontend.css', [ 'dashicons' ], WPTOFFEE_DOCS_VERSION );


		/* enqueue frontend script */
		wp_enqueue_script( 'wptoffee-docs-frontend', WPTOFFEE_DOCS_ASSETS . '/js/frontend.js', [
			'jquery',
			'wp-element',
			'wp-components',
			'wp-editor',
			'wp-util',
		], WPTOFFEE_DOCS_VERSION, true );


		wp_localize_script( 'wptoffee-docs-frontend', 'wptoffeeDocs', $this->get_localize_data() );

	}

	/**
	 * Admin Scripts
	 *
	 * @param $hook
	 */
	public function admin_enqueue( $hook ) {

		wp_enqueue_style( 'wptoffee-docs-admin', WPTOFFEE_DOCS_ASSETS . '/css/admin.css', false, WPTOFFEE_DOCS_VERSION );

		wp_enqueue_media();
		wp_enqueue_script( 'wptoffee-docs-admin', WPTOFFEE_DOCS_ASSETS . '/js/admin.js', [
			'jquery',
			'wp-util',
		], WPTOFFEE_DOCS_VERSION, true );

		wp_localize_script( 'wptoffee-docs-admin', 'wptoffeeDocs', $this->get_localize_data() );

	}

	public function get_localize_data() {
		$data = [];

		return $data;
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

WPToffeeDocs_Enqueue::instance();




