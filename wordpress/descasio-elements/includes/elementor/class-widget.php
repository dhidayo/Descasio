<?php
/**
 * Base Elementor widget: controls are generated from the element's field list and output comes from
 * Descasio_Registry::render(), so Elementor shows exactly the same markup as WPBakery and the shortcodes.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

abstract class Descasio_Elementor_Widget extends Widget_Base {

	/** Element slug, set by each generated subclass. */
	const SLUG = '';

	protected function el(): array {
		return Descasio_Registry::get( static::SLUG ) ?? array( 'title' => static::SLUG, 'fields' => array() );
	}

	public function get_name() {
		return 'descasio-' . str_replace( '_', '-', static::SLUG );
	}

	public function get_title() {
		return $this->el()['title'];
	}

	public function get_icon() {
		return $this->el()['icon'] ?? 'eicon-apps';
	}

	public function get_categories() {
		return array( 'descasio' );
	}

	public function get_keywords() {
		return array( 'descasio', static::SLUG );
	}

	public function get_script_depends() {
		return array( 'descasio', 'descasio-elements' );
	}

	public function get_style_depends() {
		return array( 'descasio' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => __( 'Content', 'descasio-elements' ), 'tab' => Controls_Manager::TAB_CONTENT ) );
		foreach ( $this->el()['fields'] as $f ) {
			if ( 'repeater' === $f['type'] ) {
				$repeater = new Repeater();
				foreach ( $f['fields'] as $sub ) {
					$repeater->add_control( $sub['key'], self::control( $sub ) );
				}
				$this->add_control(
					$f['key'],
					array(
						'label'       => $f['label'],
						'type'        => Controls_Manager::REPEATER,
						'fields'      => $repeater->get_controls(),
						'default'     => self::repeater_default( $f ),
						'title_field' => '{{{ ' . ( $f['title_field'] ?? $f['fields'][0]['key'] ) . ' }}}',
						'separator'   => 'before',
					)
				);
			} else {
				$this->add_control( $f['key'], self::control( $f ) );
			}
		}
		$this->end_controls_section();
	}

	/** Maps one field definition to an Elementor control. */
	public static function control( array $f ): array {
		$default = $f['default'] ?? '';
		$c       = array( 'label' => $f['label'] );
		if ( ! empty( $f['help'] ) ) {
			$c['description'] = $f['help'];
		}
		switch ( $f['type'] ) {
			case 'textarea':
				$c += array( 'type' => Controls_Manager::TEXTAREA, 'default' => $default, 'rows' => 4 );
				break;
			case 'lines':
				$c += array( 'type' => Controls_Manager::TEXTAREA, 'default' => implode( "\n", (array) $default ), 'rows' => 6, 'description' => __( 'One item per line.', 'descasio-elements' ) );
				break;
			case 'image':
				$c += array( 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => Descasio_Registry::media( $default ) ) );
				break;
			case 'gallery':
				// Defaults are bundled files without Media Library IDs, which this control needs, so it starts empty
				// and the element shows the bundled images until you choose your own.
				$c += array( 'type' => Controls_Manager::GALLERY, 'default' => array(), 'description' => __( 'Leave empty to use the default images.', 'descasio-elements' ) );
				break;
			case 'select':
				$c += array( 'type' => Controls_Manager::SELECT, 'options' => $f['options'], 'default' => $default );
				break;
			case 'switch':
				$c += array( 'type' => Controls_Manager::SWITCHER, 'default' => $default ? 'yes' : '', 'return_value' => 'yes' );
				break;
			case 'number':
				$c += array( 'type' => Controls_Manager::NUMBER, 'default' => $default );
				break;
			case 'icon':
				$c += array( 'type' => Controls_Manager::TEXT, 'default' => $default, 'description' => __( 'Phosphor icon name from phosphoricons.com, e.g. chart-line-up.', 'descasio-elements' ), 'label_block' => false );
				break;
			case 'url':
				$c += array( 'type' => Controls_Manager::TEXT, 'default' => $default, 'placeholder' => 'https:// or /page/', 'label_block' => true );
				break;
			default:
				$c += array( 'type' => Controls_Manager::TEXT, 'default' => $default, 'label_block' => true );
		}
		return $c;
	}

	/** Repeater defaults in Elementor's format (images become media arrays, switches "yes"). */
	private static function repeater_default( array $f ): array {
		$rows = array();
		foreach ( (array) ( $f['default'] ?? array() ) as $row ) {
			foreach ( $f['fields'] as $sub ) {
				if ( 'image' === $sub['type'] && isset( $row[ $sub['key'] ] ) && ! is_array( $row[ $sub['key'] ] ) ) {
					$row[ $sub['key'] ] = array( 'url' => Descasio_Registry::media( $row[ $sub['key'] ] ) );
				}
			}
			$rows[] = $row;
		}
		return $rows;
	}

	protected function render() {
		echo Descasio_Registry::render( static::SLUG, (array) $this->get_settings_for_display() ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in templates.
	}
}
