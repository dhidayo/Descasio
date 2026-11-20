<?php
/**
 * Product hero: proposition on the left, animated evidence trail on the right (DIP page).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Product Hero with Evidence Trail', 'descasio-elements' ),
	'icon'   => 'eicon-device-desktop',
	'fields' => array_merge(
		array(
			de_f( 'label', __( 'Label', 'descasio-elements' ), 'text', 'Decision Intelligence Platform' ),
			de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Turn fragmented data into decisions {you can trust.}' ),
			de_f( 'intro', __( 'Intro', 'descasio-elements' ), 'textarea', 'DIP connects, governs, and monitors your critical data so every report, insight, and AI initiative is built on a foundation of accuracy, traceability, and control.' ),
		),
		Descasio_Registry::button_fields( 'btn', 'Request Your Assessment', '/contact/?topic=dip', 'Founding Circle', '#founding-circle' ),
		array( de_f( 'note', __( 'Small note under the buttons', 'descasio-elements' ), 'textarea', 'The Decision Intelligence Readiness & Value Assessment is a guided engagement with our team, not a self-serve quiz.' ) ),
		Descasio_Evidence_Trail::fields()
	),
	'render' => function ( array $d ): string {
		return '<section class="mx-auto grid max-w-6xl items-center gap-12 px-4 pb-16 pt-36 md:pt-40 lg:grid-cols-[1.15fr_0.85fr]"><div ' . descasio_reveal() . '>'
			. ( $d['label'] ? '<span class="rounded-full bg-accent-soft px-3.5 py-1.5 text-sm font-bold text-accent-strong dark:text-accent">' . de_e( $d['label'] ) . '</span>' : '' )
			. '<h1 class="mt-6 text-balance text-[2.6rem] font-extrabold leading-[1.03] tracking-[-0.04em] text-fg md:text-6xl">' . descasio_accent( $d['title'] ) . '</h1>'
			. '<p class="mt-6 max-w-[52ch] text-lg leading-relaxed text-muted md:text-xl">' . de_e( $d['intro'] ) . '</p>'
			. '<div class="mt-9 flex flex-wrap gap-3">' . Descasio_Registry::buttons( $d, 'btn' ) . '</div>'
			. ( $d['note'] ? '<p class="mt-5 max-w-md text-sm leading-relaxed text-muted">' . de_e( $d['note'] ) . '</p>' : '' )
			. '</div>' . de_reveal_open( 0.1 ) . Descasio_Evidence_Trail::html( $d ) . '</div></section>';
	},
);
