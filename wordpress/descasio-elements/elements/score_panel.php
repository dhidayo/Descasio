<?php
/**
 * Glass panel with a pitch on the left and numbered points on the right (DIP executive assessment).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Numbered Points Panel', 'descasio-elements' ),
	'icon'   => 'eicon-number-field',
	'fields' => array(
		de_f( 'eyebrow', __( 'Small label', 'descasio-elements' ), 'text', 'Free executive assessment' ),
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Measure the strength of your data foundation.' ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', 'Get a clear score across three dimensions, then talk to our team about what it means for your organisation. No obligation required.' ),
		de_f( 'btn_label', __( 'Button text', 'descasio-elements' ), 'text', 'Speak With a Data Specialist' ),
		de_f( 'btn_url', __( 'Button link', 'descasio-elements' ), 'url', '/contact/?topic=dip' ),
		de_f(
			'items',
			__( 'Points', 'descasio-elements' ),
			'repeater',
			array(
				array( 'title' => 'Data Trust', 'text' => 'Evaluate how confidently your organisation can trace, verify, and defend critical reporting and business decisions.' ),
				array( 'title' => 'Governance Maturity', 'text' => 'Assess how consistently data quality, access controls, retention policies, and governance standards are applied.' ),
				array( 'title' => 'AI Readiness', 'text' => 'Understand whether your current data foundation can support reliable, explainable, and scalable AI initiatives.' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea' ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$items = '';
		foreach ( $d['items'] as $i => $s ) {
			$items .= '<li class="flex gap-5 rounded-[18px] border border-line bg-[var(--bg-elevated)]/60 p-5"><span class="text-3xl font-extrabold tracking-tighter text-accent">' . ( $i + 1 ) . '</span><div><h3 class="font-bold text-fg">' . de_e( $s['title'] ) . '</h3><p class="mt-1 text-[15px] leading-relaxed text-muted">' . de_e( $s['text'] ) . '</p></div></li>';
		}
		return '<section class="mx-auto max-w-6xl px-4 py-16"><div ' . descasio_reveal() . '><div class="glass rounded-[32px] p-8 md:p-12"><div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr]"><div>'
			. ( $d['eyebrow'] ? '<p class="text-sm font-bold text-accent-strong dark:text-accent">' . de_e( $d['eyebrow'] ) . '</p>' : '' )
			. '<h2 class="mt-3 text-3xl font-extrabold leading-tight tracking-[-0.03em] text-fg md:text-4xl">' . descasio_accent( $d['title'] ) . '</h2><p class="mt-4 leading-relaxed text-muted">' . de_e( $d['text'] ) . '</p>'
			. descasio_button( $d['btn_label'], $d['btn_url'], 'primary', array( 'class' => 'mt-8' ) ) . '</div><ol class="m-0 grid list-none gap-4 p-0">' . $items . '</ol></div></div></div></section>';
	},
);
