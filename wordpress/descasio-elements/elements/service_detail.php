<?php
/**
 * Service page body: content blocks on the left, sticky lists on the right, optional assessment promo.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Service Details', 'descasio-elements' ),
	'icon'   => 'eicon-column',
	'fields' => array(
		de_f(
			'blocks',
			__( 'Content blocks', 'descasio-elements' ),
			'repeater',
			array(
				array( 'title' => 'Our approach', 'text' => "Every migration starts with a comprehensive assessment: what you're running, where it lives, what it costs, and what's at risk.", 'list' => '' ),
				array( 'title' => 'What we migrate', 'text' => '', 'list' => "On-premise servers and data centres to AWS, Azure, or our Sovereign AI Cloud\nLegacy applications to cloud-native architectures" ),
			),
			array(
				'title_field' => 'title',
				'fields'      => array(
					de_f( 'title', __( 'Title', 'descasio-elements' ) ),
					de_f( 'text', __( 'Paragraph', 'descasio-elements' ), 'textarea' ),
					de_f( 'list', __( 'Ticked list (one per line, optional)', 'descasio-elements' ), 'textarea' ),
				),
			)
		),
		de_f(
			'lists',
			__( 'Side panels', 'descasio-elements' ),
			'repeater',
			array( array( 'title' => 'Typical results', 'items' => "25-40% infrastructure cost reduction\n99.9% uptime post-migration\nZero data loss track record\n8-16 week migration timeline" ) ),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'items', __( 'Items (one per line)', 'descasio-elements' ), 'textarea' ) ) )
		),
		de_f( 'promo', __( 'Show the AI Readiness Assessment promo', 'descasio-elements' ), 'switch', '' ),
		de_f( 'promo_title', __( 'Promo title', 'descasio-elements' ), 'text', 'AI Readiness Assessment' ),
		de_f( 'promo_text', __( 'Promo text', 'descasio-elements' ), 'textarea', 'Take our self-assessment to understand where your organisation stands on AI readiness.' ),
		de_f( 'promo_url', __( 'Promo link', 'descasio-elements' ), 'url', '/ai-readiness/' ),
	),
	'render' => function ( array $d ): string {
		$main = '';
		foreach ( $d['blocks'] as $i => $b ) {
			$main .= de_reveal_open( $i * 0.04 ) . '<article class="glass rounded-[var(--radius-card)] p-7 md:p-9"><h2 class="text-2xl font-extrabold tracking-tight text-fg md:text-[1.7rem]">' . de_e( $b['title'] ) . '</h2>'
				. ( $b['text'] ? '<p class="mt-4 text-[17px] leading-relaxed text-muted">' . de_e( $b['text'] ) . '</p>' : '' )
				. descasio_check_list( descasio_lines( $b['list'] ), 'mt-5' ) . '</article></div>';
		}
		$aside = '';
		foreach ( $d['lists'] as $i => $l ) {
			$aside .= de_reveal_open( 0.08 + $i * 0.06 ) . '<div class="glass rounded-[var(--radius-card)] p-7"><h2 class="text-lg font-bold text-fg">' . de_e( $l['title'] ) . '</h2>' . descasio_check_list( descasio_lines( $l['items'] ), 'mt-5 text-[15px]' ) . '</div></div>';
		}
		if ( $d['promo'] ) {
			$aside .= de_reveal_open( 0.2 ) . '<div class="relative overflow-hidden rounded-[var(--radius-card)] bg-accent-strong p-7 text-white"><p class="text-sm font-bold text-white/80">' . esc_html__( 'Free', 'descasio-elements' ) . '</p><h3 class="mt-2 text-2xl font-extrabold tracking-tight">' . de_e( $d['promo_title'] ) . '</h3><p class="mt-2 leading-relaxed text-white/85">' . de_e( $d['promo_text'] ) . '</p>'
				. descasio_button( __( 'Start Assessment', 'descasio-elements' ), $d['promo_url'], 'glass', array( 'class' => 'mt-6 !text-white' ) ) . '</div></div>';
		}
		return '<section class="mx-auto grid max-w-6xl gap-8 px-4 py-12 lg:grid-cols-[1.35fr_0.85fr] lg:gap-12"><div class="flex flex-col gap-5">' . $main . '</div>'
			. ( $aside ? '<aside class="flex flex-col gap-5 lg:sticky lg:top-28 lg:self-start">' . $aside . '</aside>' : '' ) . '</section>';
	},
);
