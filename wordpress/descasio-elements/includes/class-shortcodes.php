<?php
/**
 * [descasio_*] shortcodes for every element. WPBakery uses these; they also work in the block editor's Shortcode block.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

class Descasio_Shortcodes {

	public static function init(): void {
		foreach ( array_keys( Descasio_Registry::all() ) as $slug ) {
			add_shortcode(
				'descasio_' . $slug,
				function ( $atts ) use ( $slug ) {
					return Descasio_Registry::render( $slug, is_array( $atts ) ? $atts : array() );
				}
			);
		}
	}
}
