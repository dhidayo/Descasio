<?php
/**
 * Element registry: loads every element definition from /elements and renders it.
 *
 * An element file returns:
 *   array(
 *     'title'    => 'Home Hero',
 *     'icon'     => 'eicon-banner',          // Elementor panel icon
 *     'fields'   => array( ...field... ),     // see Descasio_Registry::normalise()
 *     'render'   => function ( array $d ) { return '<section>…</section>'; },
 *   )
 *
 * Field: array( 'key', 'label', 'type', 'default', 'help', 'options' (select), 'fields' (repeater), 'title_field' (repeater) )
 * Types: text, textarea, lines (one item per line), url, image, gallery, select, switch, number, icon, repeater.
 *
 * Elementor widgets, WPBakery elements and [descasio_*] shortcodes are all generated from this one definition,
 * so they render identical markup.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

class Descasio_Registry {

	/** @var array<string, array> */
	private static $elements = null;

	public static function all(): array {
		if ( null === self::$elements ) {
			self::$elements = array();
			foreach ( glob( DESCASIO_EL_DIR . 'elements/*.php' ) as $file ) {
				$slug = basename( $file, '.php' );
				$def  = require $file;
				if ( is_array( $def ) ) {
					$def['slug']             = $slug;
					self::$elements[ $slug ] = $def;
				}
			}
			ksort( self::$elements );
		}
		return self::$elements;
	}

	public static function get( string $slug ): ?array {
		return self::all()[ $slug ] ?? null;
	}

	/** Default value of every field, for previews and the importer. */
	public static function defaults( string $slug ): array {
		$el  = self::get( $slug );
		$out = array();
		foreach ( $el['fields'] ?? array() as $f ) {
			$out[ $f['key'] ] = $f['default'] ?? self::empty_value( $f['type'] );
		}
		return $out;
	}

	private static function empty_value( string $type ) {
		return in_array( $type, array( 'repeater', 'gallery', 'lines' ), true ) ? array() : '';
	}

	/**
	 * Merges raw builder values over the defaults and converts each to a plain PHP value.
	 * Accepts Elementor settings, WPBakery attributes or shortcode attributes.
	 */
	public static function normalise( string $slug, array $raw ): array {
		$el  = self::get( $slug );
		$out = array();
		foreach ( $el['fields'] ?? array() as $f ) {
			$has      = array_key_exists( $f['key'], $raw ) && null !== $raw[ $f['key'] ];
			$value    = $has ? $raw[ $f['key'] ] : ( $f['default'] ?? self::empty_value( $f['type'] ) );
			if ( 'gallery' === $f['type'] && self::is_empty_gallery( $value ) ) {
				$value = $f['default'] ?? array(); // Empty gallery: use the bundled images.
			}
			$out[ $f['key'] ] = self::value( $f, $value, $has );
		}
		return $out;
	}

	private static function value( array $f, $v, bool $from_builder ) {
		switch ( $f['type'] ) {
			case 'switch':
				return in_array( $v, array( true, 1, '1', 'yes', 'true', 'on' ), true );
			case 'number':
				return is_numeric( $v ) ? $v + 0 : ( $f['default'] ?? 0 );
			case 'image':
				return self::media( $v );
			case 'gallery':
				if ( is_string( $v ) ) {
					$v = '' === trim( $v ) ? array() : explode( ',', $v ); // WPBakery: "12,13,14".
				}
				$urls = array();
				foreach ( (array) $v as $item ) {
					$url = self::media( $item );
					if ( $url ) {
						$urls[] = array( 'url' => $url, 'alt' => self::media_alt( $item ) );
					}
				}
				return $urls;
			case 'lines':
				return descasio_lines( self::text( $v ) );
			case 'repeater':
				if ( is_string( $v ) ) {
					$v = self::parse_group( $v ); // WPBakery param_group.
				}
				$items = array();
				foreach ( (array) $v as $row ) {
					$row  = (array) $row;
					$item = array();
					foreach ( $f['fields'] as $sub ) {
						$has                 = array_key_exists( $sub['key'], $row ) && null !== $row[ $sub['key'] ];
						$item[ $sub['key'] ] = self::value( $sub, $has ? $row[ $sub['key'] ] : ( $sub['default'] ?? self::empty_value( $sub['type'] ) ), $has );
					}
					$items[] = $item;
				}
				return $items;
			default:
				return self::text( $v );
		}
	}

	private static function is_empty_gallery( $v ): bool {
		return '' === $v || array() === $v || ( is_string( $v ) && '' === trim( $v ) );
	}

	/** Undoes WPBakery's attribute encodings: textarea_safe and backtick quotes. */
	public static function text( $v ): string {
		if ( is_array( $v ) ) {
			$v = $v['url'] ?? implode( "\n", array_map( 'strval', $v ) ); // Elementor URL control or similar.
		}
		$v = (string) $v;
		if ( str_starts_with( $v, '#E-8_' ) ) {
			$v = rawurldecode( base64_decode( substr( $v, 5 ) ) ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- WPBakery's own format.
		}
		return str_replace( '``', '"', $v );
	}

	/** WPBakery's encoding for multi-line attributes. */
	public static function to_safe( string $v ): string {
		return '#E-8_' . base64_encode( rawurlencode( $v ) ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
	}

	private static function parse_group( string $v ): array {
		if ( function_exists( 'vc_param_group_parse_atts' ) ) {
			return (array) vc_param_group_parse_atts( $v );
		}
		$decoded = json_decode( rawurldecode( $v ), true );
		return is_array( $decoded ) ? $decoded : array();
	}

	/**
	 * Image value to URL. Accepts an attachment ID (WPBakery), an Elementor media array,
	 * a URL, or "asset:path" for images bundled with the theme.
	 */
	public static function media( $v ): string {
		if ( is_array( $v ) ) {
			if ( ! empty( $v['id'] ) ) {
				$url = wp_get_attachment_image_url( (int) $v['id'], 'full' );
				if ( $url ) {
					return $url;
				}
			}
			$v = $v['url'] ?? '';
		}
		if ( is_numeric( $v ) && (int) $v > 0 ) {
			return (string) wp_get_attachment_image_url( (int) $v, 'full' );
		}
		$v = trim( (string) $v );
		if ( str_starts_with( $v, 'asset:' ) ) {
			return descasio_asset( substr( $v, 6 ) );
		}
		return $v;
	}

	private static function media_alt( $v ): string {
		$id = is_array( $v ) ? (int) ( $v['id'] ?? 0 ) : ( is_numeric( $v ) ? (int) $v : 0 );
		if ( $id ) {
			return (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
		}
		$url = is_array( $v ) ? ( $v['url'] ?? '' ) : (string) $v;
		$name = pathinfo( wp_parse_url( $url, PHP_URL_PATH ) ?? '', PATHINFO_FILENAME );
		return ucwords( strtolower( str_replace( array( '-', '_' ), ' ', $name ) ) );
	}

	/** Renders an element. Builders call this with their raw values. */
	public static function render( string $slug, array $raw = array() ): string {
		$el = self::get( $slug );
		if ( ! $el || ! function_exists( 'descasio_icon' ) ) {
			return '';
		}
		$data = self::normalise( $slug, $raw );
		return '<div class="de-el de-el-' . esc_attr( $slug ) . '">' . call_user_func( $el['render'], $data ) . '</div>';
	}

	/** Shared field: two buttons (primary + glass). Returns field definitions. */
	public static function button_fields( string $prefix, string $label, string $url, string $label2 = '', string $url2 = '' ): array {
		return array(
			array( 'key' => "{$prefix}_label", 'label' => __( 'Primary button text', 'descasio-elements' ), 'type' => 'text', 'default' => $label ),
			array( 'key' => "{$prefix}_url", 'label' => __( 'Primary button link', 'descasio-elements' ), 'type' => 'url', 'default' => $url ),
			array( 'key' => "{$prefix}2_label", 'label' => __( 'Second button text', 'descasio-elements' ), 'type' => 'text', 'default' => $label2 ),
			array( 'key' => "{$prefix}2_url", 'label' => __( 'Second button link', 'descasio-elements' ), 'type' => 'url', 'default' => $url2 ),
		);
	}

	/** Renders the two buttons defined by button_fields(). */
	public static function buttons( array $d, string $prefix, bool $second_arrow = false ): string {
		return descasio_button( $d[ "{$prefix}_label" ] ?? '', $d[ "{$prefix}_url" ] ?? '' )
			. descasio_button( $d[ "{$prefix}2_label" ] ?? '', $d[ "{$prefix}2_url" ] ?? '', 'glass', array( 'arrow' => $second_arrow ) );
	}
}

/** Short helpers used inside element templates. */
function de_e( $v ): string {
	return esc_html( (string) $v );
}

function de_f( string $key, string $label, string $type = 'text', $default = '', array $extra = array() ): array {
	return array_merge( array( 'key' => $key, 'label' => $label, 'type' => $type, 'default' => $default ), $extra );
}
