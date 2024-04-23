<?php

defined( 'ABSPATH' ) || exit();

final class WPToffeeDocs {


	/**
	 * Minimum PHP version required
	 *
	 * @var string
	 */
	private $min_php = '5.6.0';

	/**
	 * The single instance of the class.
	 *
	 * @var WPToffeeDocs
	 * @since 1.0.0
	 */
	protected static $instance = null;

	public function __construct() {
		$this->check_environment();
		$this->includes();
		$this->init_hooks();

		register_activation_hook( WPTOFFEE_DOCS_FILE, array( $this, 'activate' ) );

		do_action( 'wptoffee_docs_loaded' );
	}

	public function activate() {
		if ( ! class_exists( 'WPToffeeDocs_Install' ) ) {
			//include_once WPTOFFEE_DOCS_INCLUDES . '/class-install.php';
		}

		//WPToffeeDocs_Install::activate();
	}

	/**
	 * Ensure theme and server variable compatibility
	 */
	public function check_environment() {

		if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
			deactivate_plugins( plugin_basename( WPTOFFEE_DOCS_FILE ) );

			wp_die( "Unsupported PHP version Min required PHP Version:{$this->min_php}" );
		}

	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {

		//core includes
		include_once WPTOFFEE_DOCS_INCLUDES . '/functions.php';
		include_once WPTOFFEE_DOCS_INCLUDES . '/class-shortcode.php';
		include_once WPTOFFEE_DOCS_INCLUDES . '/class-enqueue.php';
		include_once WPTOFFEE_DOCS_INCLUDES . '/class-cpt.php';
		include_once WPTOFFEE_DOCS_INCLUDES . '/class-hooks.php';
		include_once WPTOFFEE_DOCS_INCLUDES . '/class-ajax.php';


	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 2.3
	 */
	private function init_hooks() {

		add_action( 'admin_notices', [ $this, 'print_notices' ], 15 );

		add_action( 'wptoffee_docs_notices', [ $this, 'print_notices' ], 15 );

		//Localize our plugin
		add_action( 'init', [ $this, 'localization_setup' ] );

	}


	/**
	 * Initialize plugin for localization
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'reader-mode', false, dirname( plugin_basename( WPTOFFEE_DOCS_FILE ) ) . '/languages/' );
	}


	public function add_notice( $class, $message ) {

		$notices = get_option( sanitize_key( 'wptoffee_docs_notice' ), [] );
		if ( is_string( $message ) && is_string( $class ) && ! wp_list_filter( $notices, array( 'message' => $message ) ) ) {

			$notices[] = array(
				'message' => $message,
				'class'   => $class,
			);

			update_option( sanitize_key( 'wptoffee_docs_notice' ), $notices );
		}

	}

	public function print_notices() {
		$notices = get_option( sanitize_key( 'wptoffee_docs_notice' ), [] );
		foreach ( $notices as $notice ) { ?>
            <div class="notice notice-large is-dismissible  notice-<?php echo esc_attr( $notice['class'] ); ?>">
				<?php echo esc_html( $notice['message'] ); ?>
            </div>
			<?php
			update_option( sanitize_key( 'wptoffee_docs_notice' ), [] );
		}
	}

	public function get_template( $name = null, $args = false ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args );
		}

		$template = locate_template( WPTOFFEE_DOCS_TEMPLATES . $name . '.php' );

		if ( ! $template ) {
			$template = WPTOFFEE_DOCS_TEMPLATES . "/$name.php";
		}

		if ( file_exists( $template ) ) {
			include $template;
		} else {
			return false;
		}
	}


	/**
	 * Main WP_Radio Instance.
	 *
	 * Ensures only one instance of WP_Radio is loaded or can be loaded.
	 *
	 * @return WPToffeeDocs - Main instance.
	 * @since 1.0.0
	 * @static
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

if ( ! function_exists( 'wptoffee_docs' ) ) {
	function wptoffee_docs() {
		return WPToffeeDocs::instance();
	}
}

//fire off the plugin
wptoffee_docs();