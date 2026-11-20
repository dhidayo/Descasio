<?php
/**
 * Plugin Name: Descasio Elements
 * Plugin URI: https://descasio.io
 * Description: Every section of the Descasio website as editable elements for Elementor and WPBakery, plus the contact form, AI Readiness Assessment, lead inbox and a one-click page importer. Requires the Descasio theme.
 * Version: 1.0.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Author: Descasio Technology
 * License: Proprietary. All rights reserved.
 * Text Domain: descasio-elements
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

define( 'DESCASIO_EL_VERSION', '1.0.0' );
define( 'DESCASIO_EL_FILE', __FILE__ );
define( 'DESCASIO_EL_DIR', plugin_dir_path( __FILE__ ) );
define( 'DESCASIO_EL_URI', plugin_dir_url( __FILE__ ) );

require DESCASIO_EL_DIR . 'includes/class-registry.php';
require DESCASIO_EL_DIR . 'includes/class-parts.php';
require DESCASIO_EL_DIR . 'includes/class-settings.php';
require DESCASIO_EL_DIR . 'includes/class-forms.php';
require DESCASIO_EL_DIR . 'includes/class-shortcodes.php';
require DESCASIO_EL_DIR . 'includes/class-wpbakery.php';
require DESCASIO_EL_DIR . 'includes/class-elementor.php';
require DESCASIO_EL_DIR . 'includes/class-importer.php';

add_action(
	'after_setup_theme',
	function () {
		// The elements reuse the Descasio theme's design system and helpers.
		if ( ! function_exists( 'descasio_icon' ) ) {
			add_action(
				'admin_notices',
				function () {
					echo '<div class="notice notice-warning"><p>' . esc_html__( 'Descasio Elements needs the Descasio theme. Activate it under Appearance > Themes.', 'descasio-elements' ) . '</p></div>';
				}
			);
			return;
		}
		Descasio_Settings::init();
		Descasio_Forms::init();
		Descasio_Shortcodes::init();
		Descasio_WPBakery::init();
		Descasio_Elementor::init();
		Descasio_Importer::init();
	},
	20
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_register_script( 'descasio-elements', DESCASIO_EL_URI . 'assets/js/elements.js', array(), DESCASIO_EL_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
		wp_localize_script(
			'descasio-elements',
			'DescasioElements',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'descasio_forms' ),
			)
		);
		wp_enqueue_script( 'descasio-elements' );
	}
);

register_activation_hook( __FILE__, array( 'Descasio_Forms', 'activate' ) );
