<?php
/**
 * Process steps: connected circles on a line (DIP "how it works") or cards with arrows (PlugIQ).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Process Steps', 'descasio-elements' ),
	'icon'   => 'eicon-flow',
	'fields' => array(
		de_f( 'style', __( 'Style', 'descasio-elements' ), 'select', 'line', array( 'options' => array( 'line' => __( 'Connected line', 'descasio-elements' ), 'cards' => __( 'Cards with arrows', 'descasio-elements' ) ) ) ),
		de_f( 'title', __( 'Headline (optional)', 'descasio-elements' ), 'text', 'From raw data to trusted decisions.' ),
		de_f( 'text', __( 'Text (optional)', 'descasio-elements' ), 'textarea', 'DIP creates a governed data foundation that connects your critical systems, enforces quality and governance controls, and delivers insights you can trust, with complete visibility from source to outcome.' ),
		de_f(
			'items',
			__( 'Steps', 'descasio-elements' ),
			'repeater',
			array(
				array( 'icon' => 'plugs-connected', 'title' => 'Connect', 'text' => 'Integrates with your existing data sources without disrupting the systems you already rely on.' ),
				array( 'icon' => 'check-square-offset', 'title' => 'Validate', 'text' => 'Applies automated quality checks to identify gaps, inconsistencies, duplicates, and anomalies before they impact reporting.' ),
				array( 'icon' => 'path', 'title' => 'Trace', 'text' => 'Tracks every data movement and transformation, creating complete lineage from source to insight.' ),
				array( 'icon' => 'shield-check', 'title' => 'Govern', 'text' => 'Enforces access controls, retention policies, and audit requirements across your data environment.' ),
				array( 'icon' => 'chart-line-up', 'title' => 'Deliver', 'text' => 'Provides trusted reporting, analytics, and AI-ready data that business and technology leaders can confidently act on.' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'icon', __( 'Icon', 'descasio-elements' ), 'icon', 'sparkle' ), de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea' ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$n   = max( 1, count( $d['items'] ) );
		$out = '<section class="mx-auto max-w-6xl px-4 ' . ( 'line' === $d['style'] ? 'py-16' : 'py-12' ) . '">';
		if ( $d['title'] ) {
			$out .= '<div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'], $d['text'] ) . '</div>';
		}
		if ( 'cards' === $d['style'] ) {
			$out .= '<ol class="m-0 grid list-none gap-5 p-0 sm:grid-cols-2 lg:grid-cols-' . min( 4, $n ) . ( $d['title'] ? ' mt-12' : '' ) . '">';
			foreach ( $d['items'] as $i => $s ) {
				$out .= '<li ' . descasio_reveal( $i * 0.07 ) . ' class="glass relative h-full rounded-[var(--radius-card)] p-7"><span class="grid size-12 place-items-center rounded-2xl bg-accent-soft text-[24px] text-accent-strong dark:text-accent">' . descasio_icon( $s['icon'] ) . '</span>'
					. '<h3 class="mt-6 text-lg font-bold text-fg">' . de_e( $s['title'] ) . '</h3><p class="mt-2 leading-relaxed text-muted">' . de_e( $s['text'] ) . '</p>'
					. ( $i < $n - 1 ? '<span aria-hidden="true" class="absolute -right-4 top-12 z-10 hidden text-[18px] text-accent lg:block">' . descasio_icon( 'arrow-right', 'bold' ) . '</span>' : '' ) . '</li>';
			}
			return $out . '</ol></section>';
		}
		$cols = array( 2 => 'lg:grid-cols-2', 3 => 'lg:grid-cols-3', 4 => 'lg:grid-cols-4', 5 => 'lg:grid-cols-5', 6 => 'lg:grid-cols-6' )[ min( 6, $n ) ] ?? 'lg:grid-cols-5';
		$out .= '<ol class="relative m-0 mt-14 grid list-none gap-8 p-0 lg:gap-5 ' . $cols . '"><span aria-hidden="true" class="absolute left-[10%] right-[10%] top-7 hidden h-0.5 bg-gradient-to-r from-accent/20 via-accent to-accent/20 lg:block"></span>';
		foreach ( $d['items'] as $i => $s ) {
			$out .= '<li ' . descasio_reveal( $i * 0.08 ) . ' class="relative flex gap-5 lg:block lg:text-center"><span class="relative z-10 grid size-14 shrink-0 place-items-center rounded-full bg-accent-strong text-[26px] text-white shadow-[0_10px_30px_-10px_rgb(198_59_28/0.7)] lg:mx-auto">' . descasio_icon( $s['icon'] ) . '</span>'
				. '<div class="lg:mt-6"><h3 class="text-lg font-bold text-fg">' . de_e( $s['title'] ) . '</h3><p class="mt-2 text-[15px] leading-relaxed text-muted">' . de_e( $s['text'] ) . '</p></div></li>';
		}
		return $out . '</ol></section>';
	},
);
