<?php
/**
 * Elementor integration: a "Descasio" panel category with one widget per element.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

class Descasio_Elementor {

	public static function init(): void {
		if ( ! Descasio_Settings::uses( 'elementor' ) ) {
			return;
		}
		add_action(
			'elementor/elements/categories_registered',
			function ( $manager ) {
				$manager->add_category( 'descasio', array( 'title' => __( 'Descasio', 'descasio-elements' ), 'icon' => 'fa fa-plug' ) );
			}
		);
		add_action(
			'elementor/widgets/register',
			function ( $widgets ) {
				require_once DESCASIO_EL_DIR . 'includes/elementor/class-widget.php';
				$classes = require DESCASIO_EL_DIR . 'includes/elementor/widgets.php';
				foreach ( $classes as $class ) {
					$widgets->register( new $class() );
				}
			}
		);
		// Load the theme's styles and scripts inside the editor preview too.
		add_action(
			'elementor/preview/enqueue_styles',
			function () {
				wp_enqueue_style( 'descasio' );
			}
		);
	}
}
