<?php
/**
 * "What sets us apart" bento: accent cell, two spotlight cells and a wide cell with pills.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Bento Differentiators', 'descasio-elements' ),
	'icon'   => 'eicon-gallery-grid',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'What sets us apart from the alternatives.' ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', "Not another IT reseller. Not a Big 4 report factory. Here's why enterprises choose us." ),
		de_f( 'a_icon', __( 'Large accent cell: icon', 'descasio-elements' ), 'icon', 'buildings' ),
		de_f( 'a_title', __( 'Large accent cell: title', 'descasio-elements' ), 'text', 'We own the infrastructure' ),
		de_f( 'a_text', __( 'Large accent cell: text', 'descasio-elements' ), 'textarea', "Our Sovereign AI Cloud means your data stays in-country, compliant, and under your control. We don't just resell hyperscaler capacity." ),
		de_f( 'b_icon', __( 'Small cell 1: icon', 'descasio-elements' ), 'icon', 'lightning' ),
		de_f( 'b_title', __( 'Small cell 1: title', 'descasio-elements' ), 'text', 'We build our own platforms' ),
		de_f( 'b_text', __( 'Small cell 1: text', 'descasio-elements' ), 'textarea', 'DIP and PlugIQ are our products, not white-labelled vendor tools. When something breaks, we fix it. When you need a feature, we build it.' ),
		de_f( 'c_icon', __( 'Small cell 2: icon', 'descasio-elements' ), 'icon', 'globe-hemisphere-east' ),
		de_f( 'c_title', __( 'Small cell 2: title', 'descasio-elements' ), 'text', '15 years, Africa-only focus' ),
		de_f( 'c_text', __( 'Small cell 2: text', 'descasio-elements' ), 'textarea', "We know the bandwidth constraints, the regulatory environment, the procurement cycles. We've seen what works here, not what works in theory." ),
		de_f( 'd_icon', __( 'Wide cell: icon', 'descasio-elements' ), 'icon', 'handshake' ),
		de_f( 'd_title', __( 'Wide cell: title', 'descasio-elements' ), 'text', 'AWS Advanced Partner + global alliances' ),
		de_f( 'd_text', __( 'Wide cell: text', 'descasio-elements' ), 'textarea', 'Certified across AWS, Google, IBM, Cisco, Fortinet, Sophos, and Checkpoint. Global standards, local delivery.' ),
		de_f( 'd_pills', __( 'Wide cell: pills (one per line)', 'descasio-elements' ), 'lines', array( 'AWS', 'Google', 'IBM', 'Cisco', 'Sophos', 'Fortinet', 'Checkpoint' ) ),
	),
	'render' => function ( array $d ): string {
		$tile = function ( string $k, string $extra = '' ) use ( $d ): string {
			return '<span class="grid size-12 place-items-center rounded-2xl bg-accent-soft text-[26px] text-accent-strong dark:text-accent">' . descasio_icon( $d[ $k . '_icon' ] ) . '</span>'
				. '<h3 class="mt-8 text-xl font-bold tracking-tight text-fg">' . de_e( $d[ $k . '_title' ] ) . '</h3><p class="mt-3 ' . $extra . ' leading-relaxed text-muted">' . de_e( $d[ $k . '_text' ] ) . '</p>';
		};
		$mark  = esc_url( descasio_asset( 'brand/descasio-mark.svg' ) );
		$pills = '';
		foreach ( $d['d_pills'] as $p ) {
			$pills .= '<li class="rounded-full border border-line bg-[var(--bg-elevated)]/60 px-4 py-1.5 text-sm font-semibold text-fg">' . de_e( $p ) . '</li>';
		}
		return '<section class="mx-auto max-w-6xl px-4 py-24"><div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'], $d['text'] ) . '</div><div class="mt-14 grid gap-5 md:grid-cols-6">'
			. de_reveal_open( 0, 'md:col-span-4' ) . '<div class="relative h-full overflow-hidden rounded-[var(--radius-card)] bg-accent-strong p-8 text-white md:p-10"><img src="' . $mark . '" alt="" class="pointer-events-none absolute -bottom-16 -right-16 size-72 opacity-25 mix-blend-screen">'
			. '<span class="relative grid size-12 place-items-center rounded-2xl bg-white/15 text-[26px]">' . descasio_icon( $d['a_icon'] ) . '</span><h3 class="relative mt-8 max-w-md text-3xl font-extrabold tracking-tight">' . de_e( $d['a_title'] ) . '</h3><p class="relative mt-3 max-w-lg leading-relaxed text-white/85">' . de_e( $d['a_text'] ) . '</p></div></div>'
			. de_reveal_open( 0.08, 'md:col-span-2' ) . '<div class="glass de-spotlight h-full rounded-[var(--radius-card)] p-8">' . $tile( 'b' ) . '</div></div>'
			. de_reveal_open( 0.04, 'md:col-span-2' ) . '<div class="glass de-spotlight h-full rounded-[var(--radius-card)] p-8">' . $tile( 'c' ) . '</div></div>'
			. de_reveal_open( 0.1, 'md:col-span-4' ) . '<div class="glass de-spotlight h-full rounded-[var(--radius-card)] p-8 md:p-10">' . $tile( 'd', 'max-w-xl' ) . ( $pills ? '<ul class="m-0 mt-6 flex list-none flex-wrap gap-2 p-0">' . $pills . '</ul>' : '' ) . '</div></div>'
			. '</div></section>';
	},
);
