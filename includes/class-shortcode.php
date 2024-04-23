<?php

defined( 'ABSPATH' ) || exit();


class WPToffeeDocs_Shortcode {
	/**
	 * @var null
	 */
	protected static $instance = null;

	public function __construct() {
		add_shortcode( 'wptoffee_docs', [ $this, 'render_docs' ] );
		add_shortcode( 'documentation_archive', [ $this, 'render_documentation_archive' ] );
		add_shortcode( 'documentation_single', [ $this, 'render_documentation_single' ] );
	}


	public function render_docs( $atts = [], $data = null ) {

		ob_start();
		include_once WPTOFFEE_DOCS_TEMPLATES . '/docs.php';

		return ob_get_clean();
	}

	public function render_documentation_archive( $atts = [], $data = null ) {
		ob_start();
		include_once WPTOFFEE_DOCS_TEMPLATES . '/archive.php';

		return ob_get_clean();
	}

	public function render_documentation_single( $atts = [], $data = null ) {
		ob_start();
		include_once WPTOFFEE_DOCS_TEMPLATES . '/single.php';

		return ob_get_clean();
	}


	/**
	 * @return WPToffeeDocs_Shortcode|null
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

WPToffeeDocs_Shortcode::instance();