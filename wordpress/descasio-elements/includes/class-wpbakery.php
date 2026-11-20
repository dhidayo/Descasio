<?php
/**
 * WPBakery Page Builder integration: maps every element with vc_map(), generated from the element's fields.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

class Descasio_WPBakery {

	public static function init(): void {
		if ( ! Descasio_Settings::uses( 'wpbakery' ) ) {
			return;
		}
		add_action( 'vc_before_init', array( __CLASS__, 'map' ) );
	}

	public static function map(): void {
		if ( ! function_exists( 'vc_map' ) ) {
			return;
		}
		foreach ( Descasio_Registry::all() as $slug => $el ) {
			vc_map(
				array(
					'name'        => $el['title'],
					'base'        => 'descasio_' . $slug,
					'category'    => __( 'Descasio', 'descasio-elements' ),
					'icon'        => DESCASIO_EL_URI . 'assets/css/icon.svg',
					'description' => __( 'Descasio design system', 'descasio-elements' ),
					'params'      => array_map( array( __CLASS__, 'param' ), $el['fields'] ),
				)
			);
		}
	}

	/** Converts one field definition into a WPBakery param. */
	public static function param( array $f ): array {
		$p = array(
			'param_name'  => $f['key'],
			'heading'     => $f['label'],
			'description' => $f['help'] ?? '',
			'admin_label' => in_array( $f['key'], array( 'title', 'label' ), true ),
		);
		$default = $f['default'] ?? '';
		switch ( $f['type'] ) {
			case 'textarea':
				$p['type']  = 'textarea_safe';
				$p['value'] = is_string( $default ) ? $default : '';
				break;
			case 'lines':
				$p['type']        = 'textarea_safe';
				$p['value']       = implode( "\n", (array) $default );
				$p['description'] = trim( $p['description'] . ' ' . __( 'One item per line.', 'descasio-elements' ) );
				break;
			case 'image':
				$p['type'] = 'attach_image';
				break;
			case 'gallery':
				$p['type']        = 'attach_images';
				$p['description'] = trim( $p['description'] . ' ' . __( 'Leave empty to use the default images.', 'descasio-elements' ) );
				break;
			case 'select':
				$p['type']  = 'dropdown';
				$p['value'] = array_flip( $f['options'] );
				$p['std']   = $default;
				break;
			case 'switch':
				$p['type']  = 'checkbox';
				$p['value'] = array( __( 'Yes', 'descasio-elements' ) => 'yes' );
				$p['std']   = $default ? 'yes' : '';
				break;
			case 'repeater':
				$p['type']   = 'param_group';
				$p['value']  = rawurlencode( wp_json_encode( $default ) );
				$p['params'] = array_map( array( __CLASS__, 'param' ), $f['fields'] );
				break;
			case 'icon':
				$p['type']        = 'textfield';
				$p['value']       = $default;
				$p['description'] = trim( $p['description'] . ' ' . __( 'Phosphor icon name from phosphoricons.com, e.g. chart-line-up.', 'descasio-elements' ) );
				break;
			default:
				$p['type']  = 'textfield';
				$p['value'] = is_scalar( $default ) ? (string) $default : '';
		}
		return $p;
	}
}
