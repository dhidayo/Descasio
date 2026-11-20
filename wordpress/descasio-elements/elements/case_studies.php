<?php
/**
 * Case study cards with two metrics each.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Case Study Grid', 'descasio-elements' ),
	'icon'   => 'eicon-gallery-grid',
	'fields' => array(
		de_f(
			'items',
			__( 'Case studies', 'descasio-elements' ),
			'repeater',
			array(
				array( 'sector' => 'Public Sector', 'title' => 'Digital transformation for a federal government ministry', 'text' => 'Modernised document management, collaboration, and communication infrastructure for a major federal ministry.', 'm1_value' => '5,000+', 'm1_label' => 'Users migrated', 'm2_value' => '70%', 'm2_label' => 'Process efficiency', 'url' => '' ),
				array( 'sector' => 'Energy / Oil & Gas', 'title' => 'Cloud migration and digital operations for a major national energy company', 'text' => 'Migrated legacy infrastructure to hybrid cloud, enabling real-time operational visibility across distributed sites nationwide.', 'm1_value' => '40%', 'm1_label' => 'Cost reduction', 'm2_value' => '99.9%', 'm2_label' => 'Uptime achieved', 'url' => '' ),
			),
			array(
				'title_field' => 'title',
				'fields'      => array(
					de_f( 'sector', __( 'Sector', 'descasio-elements' ) ),
					de_f( 'title', __( 'Title', 'descasio-elements' ) ),
					de_f( 'text', __( 'Summary', 'descasio-elements' ), 'textarea' ),
					de_f( 'm1_value', __( 'Metric 1 value', 'descasio-elements' ) ),
					de_f( 'm1_label', __( 'Metric 1 label', 'descasio-elements' ) ),
					de_f( 'm2_value', __( 'Metric 2 value', 'descasio-elements' ) ),
					de_f( 'm2_label', __( 'Metric 2 label', 'descasio-elements' ) ),
					de_f( 'url', __( 'Link (optional)', 'descasio-elements' ), 'url' ),
				),
			)
		),
	),
	'render' => function ( array $d ): string {
		$out = '<section class="mx-auto max-w-6xl px-4 py-12"><div class="grid gap-5 md:grid-cols-2">';
		foreach ( $d['items'] as $i => $c ) {
			$metrics = '';
			foreach ( array( 1, 2 ) as $n ) {
				if ( $c[ "m{$n}_value" ] ) {
					$metrics .= '<div><dd class="m-0 text-3xl font-extrabold tracking-[-0.03em] text-fg">' . de_e( $c[ "m{$n}_value" ] ) . '</dd><dt class="mt-1 text-sm text-muted">' . de_e( $c[ "m{$n}_label" ] ) . '</dt></div>';
				}
			}
			$inner = '<div><p class="text-sm font-bold text-accent-strong dark:text-accent">' . de_e( $c['sector'] ) . '</p><h2 class="mt-3 text-xl font-bold leading-snug text-fg md:text-2xl">' . de_e( $c['title'] ) . '</h2><p class="mt-3 leading-relaxed text-muted">' . de_e( $c['text'] ) . '</p></div>'
				. ( $metrics ? '<dl class="m-0 mt-8 grid grid-cols-2 gap-6 border-t border-line pt-6">' . $metrics . '</dl>' : '<span class="mt-8 inline-flex items-center gap-1 border-t border-line pt-6 font-semibold text-fg">' . esc_html__( 'Read case study', 'descasio-elements' ) . ' ' . descasio_icon( 'arrow-up-right', 'bold' ) . '</span>' );
			$cls   = 'glass flex h-full flex-col justify-between rounded-[var(--radius-card)] p-8';
			$url   = descasio_url( $c['url'] );
			$out  .= de_reveal_open( ( $i % 2 ) * 0.07 ) . ( $url
				? '<a href="' . esc_url( $url ) . '"' . ( descasio_is_external( $url ) ? ' target="_blank" rel="noopener noreferrer"' : '' ) . ' class="' . $cls . ' no-underline transition-transform duration-500 hover:-translate-y-1">' . $inner . '</a>'
				: '<article class="' . $cls . '">' . $inner . '</article>' ) . '</div>';
		}
		return $out . '</div></section>';
	},
);
