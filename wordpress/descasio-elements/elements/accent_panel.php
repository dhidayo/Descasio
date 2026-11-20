<?php
/**
 * Accent-filled panel with a headline, text and three columns (DIP "the problem").
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Accent Panel', 'descasio-elements' ),
	'icon'   => 'eicon-info-box',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Your business is only as reliable as the data behind it.' ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', 'Critical decisions are made every day using data spread across systems, spreadsheets, and teams. When accuracy, accountability, or compliance is questioned, most organisations discover they lack the visibility to respond with confidence.' ),
		de_f(
			'items',
			__( 'Columns', 'descasio-elements' ),
			'repeater',
			array(
				array( 'title' => 'Reporting without trust', 'text' => 'Data moves across multiple systems with little visibility into where it originated, how it changed, or whether it can be verified when it matters most.' ),
				array( 'title' => 'AI without a foundation', 'text' => 'AI initiatives struggle to deliver value when the underlying data lacks governance, quality controls, and traceability.' ),
				array( 'title' => 'Decisions without evidence', 'text' => 'When executives, auditors, or regulators challenge a number, teams spend valuable time investigating instead of acting.' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea' ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$cols = '';
		foreach ( $d['items'] as $p ) {
			$cols .= '<div class="border-t border-white/30 pt-6"><h3 class="text-xl font-bold">' . de_e( $p['title'] ) . '</h3><p class="mt-2 leading-relaxed text-white/85">' . de_e( $p['text'] ) . '</p></div>';
		}
		return '<section class="mx-auto max-w-6xl px-4 py-16"><div ' . descasio_reveal() . '><div class="relative overflow-hidden rounded-[32px] bg-accent-strong p-8 text-white md:p-14">'
			. '<h2 class="max-w-2xl text-balance text-3xl font-extrabold leading-[1.08] tracking-[-0.03em] md:text-5xl">' . de_e( descasio_plain( $d['title'] ) ) . '</h2>'
			. ( $d['text'] ? '<p class="mt-5 max-w-2xl text-lg leading-relaxed text-white/85">' . de_e( $d['text'] ) . '</p>' : '' )
			. ( $cols ? '<div class="mt-12 grid gap-8 md:grid-cols-3">' . $cols . '</div>' : '' ) . '</div></div></section>';
	},
);
