<?php
/**
 * Appearance > Customize > Descasio: logos, contact details, booking link and the featured menu card.
 *
 * @package Descasio
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'customize_register',
	function ( WP_Customize_Manager $c ) {
		$c->add_panel( 'descasio', array( 'title' => __( 'Descasio', 'descasio' ), 'priority' => 30 ) );

		$sections = array(
			'descasio_brand'    => array(
				'title'  => __( 'Brand and contact', 'descasio' ),
				'fields' => array(
					'logo_light'    => array( __( 'Logo for light backgrounds', 'descasio' ), 'image' ),
					'logo_dark'     => array( __( 'Logo for dark backgrounds', 'descasio' ), 'image' ),
					'booking_label' => array( __( 'Main button label', 'descasio' ), 'text' ),
					'booking_url'   => array( __( 'Main button link (e.g. Calendly)', 'descasio' ), 'url' ),
					'email'         => array( __( 'Email', 'descasio' ), 'text' ),
					'phone'         => array( __( 'Phone', 'descasio' ), 'text' ),
					'address'       => array( __( 'Office address', 'descasio' ), 'textarea' ),
					'tagline'       => array( __( 'Footer description', 'descasio' ), 'textarea' ),
					'legal_name'    => array( __( 'Company name for copyright', 'descasio' ), 'text' ),
				),
			),
			'descasio_menu'     => array(
				'title'  => __( 'Mega menu', 'descasio' ),
				'fields' => array(
					'featured_badge'   => array( __( 'Featured card badge', 'descasio' ), 'text' ),
					'featured_title'   => array( __( 'Featured card title', 'descasio' ), 'text' ),
					'featured_text'    => array( __( 'Featured card text', 'descasio' ), 'textarea' ),
					'featured_label'   => array( __( 'Featured card link label', 'descasio' ), 'text' ),
					'featured_url'     => array( __( 'Featured card link', 'descasio' ), 'text' ),
					'featured_icon'    => array( __( 'Featured card icon (Phosphor name)', 'descasio' ), 'text' ),
					'mega_note'        => array( __( 'Mega menu footer note', 'descasio' ), 'text' ),
					'solutions_url'    => array( __( '"All solutions" link', 'descasio' ), 'text' ),
					'resources_footer' => array( __( 'Single-column menu footer text', 'descasio' ), 'text' ),
					'resources_url'    => array( __( 'Single-column menu footer link', 'descasio' ), 'text' ),
				),
			),
		);

		foreach ( $sections as $id => $section ) {
			$c->add_section( $id, array( 'title' => $section['title'], 'panel' => 'descasio' ) );
			foreach ( $section['fields'] as $key => list( $label, $type ) ) {
				$setting = 'descasio_' . $key;
				$c->add_setting(
					$setting,
					array(
						'default'           => '',
						'sanitize_callback' => 'textarea' === $type ? 'sanitize_textarea_field' : ( 'url' === $type || 'image' === $type ? 'esc_url_raw' : 'sanitize_text_field' ),
						'transport'         => 'refresh',
					)
				);
				if ( 'image' === $type ) {
					$c->add_control( new WP_Customize_Image_Control( $c, $setting, array( 'label' => $label, 'section' => $id ) ) );
				} else {
					$c->add_control(
						$setting,
						array(
							'label'       => $label,
							'section'     => $id,
							'type'        => 'url' === $type ? 'url' : $type,
							'input_attrs' => array( 'placeholder' => descasio_opt( $key ) ),
						)
					);
				}
			}
		}
	}
);
