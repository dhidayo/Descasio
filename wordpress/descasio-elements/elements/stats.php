<?php
/**
 * Statistics strip with count-up numbers.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Statistics', 'descasio-elements' ),
	'icon'   => 'eicon-counter',
	'fields' => array(
		de_f(
			'items',
			__( 'Statistics', 'descasio-elements' ),
			'repeater',
			array(
				array( 'value' => '100', 'suffix' => 'K+', 'label' => 'Cloud licences deployed and managed' ),
				array( 'value' => '60', 'suffix' => '%', 'label' => 'Faster approvals with PlugIQ automation' ),
				array( 'value' => '400', 'suffix' => '+', 'label' => 'Organisations transformed across Nigeria' ),
				array( 'value' => '15', 'suffix' => '', 'label' => "Years building Africa's digital infrastructure" ),
			),
			array(
				'title_field' => 'label',
				'fields'      => array(
					de_f( 'value', __( 'Number', 'descasio-elements' ), 'number', 100 ),
					de_f( 'suffix', __( 'Suffix (e.g. K+, %)', 'descasio-elements' ), 'text', '' ),
					de_f( 'label', __( 'Label', 'descasio-elements' ), 'text', '' ),
				),
			)
		),
	),
	'render' => function ( array $d ): string {
		$out = '<section class="mx-auto max-w-6xl px-4"><div ' . descasio_reveal() . ' class="glass grid grid-cols-2 gap-y-10 rounded-[28px] px-6 py-10 md:grid-cols-4 md:px-10">';
		foreach ( $d['items'] as $i => $s ) {
			$out .= '<div class="px-2 md:px-6' . ( $i > 0 ? ' md:border-l md:border-line' : '' ) . '">'
				. '<p class="text-4xl font-extrabold tracking-[-0.04em] text-fg md:text-5xl"><span class="tabular-nums" data-count-to="' . esc_attr( $s['value'] ) . '" data-suffix="' . esc_attr( $s['suffix'] ) . '">' . de_e( $s['value'] . $s['suffix'] ) . '</span></p>'
				. '<p class="mt-2 max-w-[22ch] text-[15px] leading-snug text-muted">' . de_e( $s['label'] ) . '</p></div>';
		}
		return $out . '</div></section>';
	},
);
