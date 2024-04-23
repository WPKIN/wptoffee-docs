<?php
/**
 * Plugin Name:  WPToffee Docs
 * Plugin URI:  https://wptoffee.com/wptoffee-docs/
 * Description: Documentation & Knowledge Base Plugin
 * Version:     1.0.0
 * Author:      WPToffee
 * Author URI:  https://wptoffee.com/
 * Text Domain: wptoffee-docs
 * Domain Path: /languages/*
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( __( 'You can\'t access this page', 'wptoffee-docs' ) );
}

/** define constants */
define( 'WPTOFFEE_DOCS_VERSION', '1.0.2' );
define( 'WPTOFFEE_DOCS_FILE', __FILE__ );
define( 'WPTOFFEE_DOCS_PATH', dirname( WPTOFFEE_DOCS_FILE ) );
define( 'WPTOFFEE_DOCS_INCLUDES', WPTOFFEE_DOCS_PATH . '/includes' );
define( 'WPTOFFEE_DOCS_URL', plugins_url( '', WPTOFFEE_DOCS_FILE ) );
define( 'WPTOFFEE_DOCS_ASSETS', WPTOFFEE_DOCS_URL . '/assets' );
define( 'WPTOFFEE_DOCS_TEMPLATES', WPTOFFEE_DOCS_PATH . '/templates' );


//Include the base plugin file.
include_once WPTOFFEE_DOCS_INCLUDES . '/class-base.php';