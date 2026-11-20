<?php
/**
 * Press timeline with a media enquiries panel.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Press Timeline', 'descasio-elements' ),
	'icon'   => 'eicon-time-line',
	'fields' => array(
		de_f(
			'items',
			__( 'Press items', 'descasio-elements' ),
			'repeater',
			array(
				array( 'date' => 'February 2026', 'title' => "Descasio Launches Africa's First Sovereign AI Cloud", 'text' => 'Enabling Nigerian enterprises to run AI workloads entirely in-country with enterprise-grade security and compliance.', 'url' => '' ),
				array( 'date' => 'December 2025', 'title' => 'Descasio Celebrates 15 Years of Technology Leadership in Nigeria', 'text' => "From cloud pioneers in 2010 to Sovereign AI Cloud in 2025, a look back at 15 years of building Africa's digital infrastructure.", 'url' => '' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'date', __( 'Date', 'descasio-elements' ) ), de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'text', __( 'Summary', 'descasio-elements' ), 'textarea' ), de_f( 'url', __( 'Link', 'descasio-elements' ), 'url' ) ) )
		),
		de_f( 'aside_title', __( 'Side panel title', 'descasio-elements' ), 'text', 'Media inquiries' ),
		de_f( 'aside_text', __( 'Side panel text', 'descasio-elements' ), 'textarea', 'For press inquiries, interviews, or speaking requests, contact' ),
		de_f( 'aside_email', __( 'Side panel email', 'descasio-elements' ), 'text', 'marketing@descasio.io' ),
	),
	'render' => function ( array $d ): string {
		$list = '';
		foreach ( $d['items'] as $i => $p ) {
			$url   = descasio_url( $p['url'] );
			$title = $url ? '<a href="' . esc_url( $url ) . '"' . ( descasio_is_external( $url ) ? ' target="_blank" rel="noopener noreferrer"' : '' ) . ' class="group mt-2 inline-flex items-start gap-2 text-xl font-bold leading-snug text-fg no-underline">' . de_e( $p['title'] ) . descasio_icon( 'arrow-up-right', 'bold', 'mt-1 shrink-0 text-[18px] transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5' ) . '</a>' : '<p class="mt-2 text-xl font-bold leading-snug text-fg">' . de_e( $p['title'] ) . '</p>';
			$list .= '<li ' . descasio_reveal( $i * 0.04 ) . ' class="relative pb-10 last:pb-0"><span aria-hidden="true" class="absolute -left-[41px] top-1.5 size-4 rounded-full border-4 border-[var(--bg)] bg-accent"></span><p class="text-sm font-bold text-accent-strong dark:text-accent">' . de_e( $p['date'] ) . '</p>' . $title . '<p class="mt-2 max-w-xl leading-relaxed text-muted">' . de_e( $p['text'] ) . '</p></li>';
		}
		return '<section class="mx-auto grid max-w-6xl gap-10 px-4 py-8 lg:grid-cols-[1.3fr_0.7fr]"><ol class="relative m-0 list-none border-l-2 border-line pl-8">' . $list . '</ol>'
			. '<aside class="lg:sticky lg:top-28 lg:self-start"><div class="glass rounded-[var(--radius-card)] p-7"><h2 class="text-lg font-bold text-fg">' . de_e( $d['aside_title'] ) . '</h2><p class="mt-2 leading-relaxed text-muted">' . de_e( $d['aside_text'] ) . '</p>'
			. ( $d['aside_email'] ? '<a href="mailto:' . esc_attr( $d['aside_email'] ) . '" class="mt-3 inline-block font-semibold text-accent-strong no-underline dark:text-accent">' . de_e( $d['aside_email'] ) . '</a>' : '' ) . '</div></aside></section>';
	},
);
