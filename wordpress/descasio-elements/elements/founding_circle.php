<?php
/**
 * Offer panel with ticked perks, beside a dark event card (DIP Founding Circle + launch event).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Offer + Event Cards', 'descasio-elements' ),
	'icon'   => 'eicon-price-list',
	'fields' => array(
		de_f( 'anchor', __( 'Section ID (for links like #founding-circle)', 'descasio-elements' ), 'text', 'founding-circle' ),
		de_f( 'label', __( 'Offer: label', 'descasio-elements' ), 'text', 'Founding Circle' ),
		de_f( 'pill', __( 'Offer: pill', 'descasio-elements' ), 'text', 'Limited availability' ),
		de_f( 'title', __( 'Offer: headline', 'descasio-elements' ), 'text', 'Shape DIP as one of a limited number of founding customers.' ),
		de_f( 'text', __( 'Offer: text', 'descasio-elements' ), 'textarea', "We're onboarding a limited number of foundation customers directly with the product and delivery team, in exchange for reference rights and use-case feedback." ),
		de_f( 'perks', __( 'Offer: perks (one per line)', 'descasio-elements' ), 'lines', array( 'Preferred founding pricing', 'Direct influence over the product roadmap', 'Quarterly executive review with the DIP team', 'Co-branded success story once live' ) ),
		de_f( 'btn_label', __( 'Offer: button text', 'descasio-elements' ), 'text', 'Apply for the Founding Circle' ),
		de_f( 'btn_url', __( 'Offer: button link', 'descasio-elements' ), 'url', '/contact/?topic=dip' ),
		de_f( 'show_event', __( 'Show the event card', 'descasio-elements' ), 'switch', 'yes' ),
		de_f( 'e_icon', __( 'Event: icon', 'descasio-elements' ), 'icon', 'calendar-star' ),
		de_f( 'e_label', __( 'Event: label', 'descasio-elements' ), 'text', 'Launch event, Lagos' ),
		de_f( 'e_title', __( 'Event: name', 'descasio-elements' ), 'text', 'The Trust Layer' ),
		de_f( 'e_text', __( 'Event: description', 'descasio-elements' ), 'textarea', "Descasio's flagship DIP launch event in Lagos." ),
		de_f( 'e_detail', __( 'Event: details', 'descasio-elements' ), 'textarea', 'Executive roundtable for Financial Services and FMCG leaders. Date to be confirmed.' ),
		de_f( 'e_link_label', __( 'Event: link text', 'descasio-elements' ), 'text', 'Reserve a seat' ),
		de_f( 'e_link_url', __( 'Event: link', 'descasio-elements' ), 'url', '/contact/?topic=dip' ),
	),
	'render' => function ( array $d ): string {
		$perks = '';
		foreach ( $d['perks'] as $p ) {
			$perks .= '<li class="flex items-start gap-3 font-medium text-fg"><span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-accent text-[13px] text-white">' . descasio_icon( 'check', 'bold' ) . '</span>' . de_e( $p ) . '</li>';
		}
		$id    = $d['anchor'] ? ' id="' . esc_attr( sanitize_title( $d['anchor'] ) ) . '"' : '';
		$event = '';
		if ( $d['show_event'] ) {
			$event = de_reveal_open( 0.08 ) . '<div class="relative flex h-full flex-col justify-between overflow-hidden rounded-[28px] bg-fg p-8 text-[var(--bg)]"><div><span class="block text-[32px] leading-none text-accent">' . descasio_icon( $d['e_icon'] ) . '</span>'
				. '<p class="mt-6 text-sm font-bold text-accent">' . de_e( $d['e_label'] ) . '</p><h2 class="mt-2 text-3xl font-extrabold tracking-tight">' . de_e( $d['e_title'] ) . '</h2><p class="mt-3 leading-relaxed opacity-80">' . de_e( $d['e_text'] ) . '</p><p class="mt-2 leading-relaxed opacity-80">' . de_e( $d['e_detail'] ) . '</p></div>'
				. ( $d['e_link_label'] ? '<a href="' . esc_url( descasio_url( $d['e_link_url'] ) ) . '" class="mt-8 inline-flex items-center gap-2 font-semibold text-accent no-underline">' . de_e( $d['e_link_label'] ) . ' ' . descasio_icon( 'arrow-right', 'bold' ) . '</a>' : '' ) . '</div></div>';
		}
		return '<section' . $id . ' class="mx-auto grid max-w-6xl scroll-mt-28 gap-5 px-4 py-16' . ( $event ? ' lg:grid-cols-[1.3fr_0.7fr]' : '' ) . '">' . de_reveal_open() . '<div class="glass h-full rounded-[28px] p-8 md:p-10"><div class="flex flex-wrap items-center gap-2">'
			. '<span class="text-sm font-bold text-accent-strong dark:text-accent">' . de_e( $d['label'] ) . '</span>' . ( $d['pill'] ? '<span class="rounded-full border border-line px-3 py-1 text-xs font-semibold text-muted">' . de_e( $d['pill'] ) . '</span>' : '' ) . '</div>'
			. '<h2 class="mt-4 text-3xl font-extrabold leading-tight tracking-[-0.03em] text-fg">' . descasio_accent( $d['title'] ) . '</h2><p class="mt-4 max-w-xl leading-relaxed text-muted">' . de_e( $d['text'] ) . '</p>'
			. ( $perks ? '<ul class="m-0 mt-7 grid list-none gap-3 p-0 sm:grid-cols-2">' . $perks . '</ul>' : '' ) . descasio_button( $d['btn_label'], $d['btn_url'], 'primary', array( 'class' => 'mt-9' ) ) . '</div></div>' . $event . '</section>';
	},
);
