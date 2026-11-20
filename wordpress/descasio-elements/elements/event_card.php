<?php
/**
 * Upcoming event card (Events page).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Event Card', 'descasio-elements' ),
	'icon'   => 'eicon-calendar',
	'fields' => array(
		de_f( 'heading', __( 'Section heading', 'descasio-elements' ), 'text', 'Upcoming' ),
		de_f( 'tag', __( 'Label', 'descasio-elements' ), 'text', 'Flagship launch: Decision Intelligence Platform' ),
		de_f( 'title', __( 'Event name', 'descasio-elements' ), 'text', 'The Trust Layer' ),
		de_f( 'text', __( 'Description', 'descasio-elements' ), 'textarea', 'Executive roundtable for Financial Services and FMCG leaders. Date to be confirmed.' ),
		de_f( 'location', __( 'Location', 'descasio-elements' ), 'text', 'Lagos' ),
		de_f( 'format', __( 'Format', 'descasio-elements' ), 'text', 'Executive roundtable' ),
		de_f( 'date', __( 'Date', 'descasio-elements' ), 'text', 'Date to be confirmed' ),
		de_f( 'btn_label', __( 'Button text', 'descasio-elements' ), 'text', 'Reserve a seat' ),
		de_f( 'btn_url', __( 'Button link', 'descasio-elements' ), 'url', '/contact/?topic=dip' ),
		de_f( 'more_label', __( 'Link below (optional)', 'descasio-elements' ), 'text', 'Learn about the Decision Intelligence Platform' ),
		de_f( 'more_url', __( 'Link below: URL', 'descasio-elements' ), 'url', '/decision-intelligence-platform/' ),
	),
	'render' => function ( array $d ): string {
		$meta = '';
		foreach ( array( array( 'map-pin', 'location' ), array( 'users-three', 'format' ), array( 'calendar-star', 'date' ) ) as list( $icon, $k ) ) {
			if ( $d[ $k ] ) {
				$meta .= '<li class="flex items-center gap-2"><span class="text-[18px] leading-none text-accent">' . descasio_icon( $icon ) . '</span>' . de_e( $d[ $k ] ) . '</li>';
			}
		}
		return '<section class="mx-auto max-w-6xl px-4 py-8">' . ( $d['heading'] ? '<h2 class="text-xl font-bold text-fg">' . de_e( $d['heading'] ) . '</h2>' : '' )
			. '<div class="mt-6" ' . descasio_reveal() . '><article class="glass grid gap-8 rounded-[28px] p-8 md:grid-cols-[auto_1fr_auto] md:items-center md:p-10"><span class="grid size-16 place-items-center rounded-2xl bg-accent-strong text-[32px] text-white">' . descasio_icon( 'calendar-star' ) . '</span>'
			. '<div><p class="text-sm font-bold text-accent-strong dark:text-accent">' . de_e( $d['tag'] ) . '</p><h3 class="mt-2 text-3xl font-extrabold tracking-tight text-fg">' . de_e( $d['title'] ) . '</h3><p class="mt-2 max-w-xl leading-relaxed text-muted">' . de_e( $d['text'] ) . '</p>'
			. ( $meta ? '<ul class="m-0 mt-4 flex list-none flex-wrap gap-x-6 gap-y-2 p-0 text-[15px] text-fg">' . $meta . '</ul>' : '' ) . '</div>' . descasio_button( $d['btn_label'], $d['btn_url'] ) . '</article></div>'
			. ( $d['more_label'] ? '<div class="mt-6" ' . descasio_reveal() . '><a href="' . esc_url( descasio_url( $d['more_url'] ) ) . '" class="inline-flex items-center gap-2 font-semibold text-accent-strong no-underline dark:text-accent">' . de_e( $d['more_label'] ) . ' ' . descasio_icon( 'arrow-right', 'bold' ) . '</a></div>' : '' ) . '</section>';
	},
);
