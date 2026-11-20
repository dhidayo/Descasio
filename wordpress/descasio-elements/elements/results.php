<?php
/**
 * "Real outcomes" section: a featured case study with metrics and two article links.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Featured Results', 'descasio-elements' ),
	'icon'   => 'eicon-call-to-action',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Real outcomes for real enterprises.' ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', "We don't hide behind anonymity. Here's what delivery looks like." ),
		de_f( 'f_sector', __( 'Featured: sector', 'descasio-elements' ), 'text', 'Public Sector' ),
		de_f( 'f_title', __( 'Featured: title', 'descasio-elements' ), 'text', 'Digital transformation for a federal government ministry' ),
		de_f( 'f_text', __( 'Featured: summary', 'descasio-elements' ), 'textarea', 'Modernised document management, collaboration, and communication infrastructure for a major federal ministry.' ),
		de_f( 'f_m1_value', __( 'Featured: metric 1 value', 'descasio-elements' ), 'text', '5,000+' ),
		de_f( 'f_m1_label', __( 'Featured: metric 1 label', 'descasio-elements' ), 'text', 'Users migrated' ),
		de_f( 'f_m2_value', __( 'Featured: metric 2 value', 'descasio-elements' ), 'text', '70%' ),
		de_f( 'f_m2_label', __( 'Featured: metric 2 label', 'descasio-elements' ), 'text', 'Process efficiency' ),
		de_f(
			'links',
			__( 'Article links', 'descasio-elements' ),
			'repeater',
			array(
				array( 'sector' => 'E-commerce', 'title' => 'How Shopzone built a scalable e-commerce platform on AWS for peak shopping demand', 'url' => '/case-studies/' ),
				array( 'sector' => 'Fintech', 'title' => 'How PayNaira secured its digital payments platform with AWS cloud infrastructure', 'url' => '/case-studies/' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'sector', __( 'Sector', 'descasio-elements' ) ), de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'url', __( 'Link', 'descasio-elements' ), 'url' ) ) )
		),
		de_f( 'more_label', __( 'Button text', 'descasio-elements' ), 'text', 'All case studies' ),
		de_f( 'more_url', __( 'Button link', 'descasio-elements' ), 'url', '/case-studies/' ),
	),
	'render' => function ( array $d ): string {
		$metrics = '';
		foreach ( array( 1, 2 ) as $n ) {
			if ( $d[ "f_m{$n}_value" ] ) {
				$metrics .= '<div><dt class="text-sm text-muted">' . de_e( $d[ "f_m{$n}_label" ] ) . '</dt><dd class="m-0 mt-1 text-5xl font-extrabold tracking-[-0.04em] text-fg">' . de_e( $d[ "f_m{$n}_value" ] ) . '</dd></div>';
			}
		}
		$links = '';
		foreach ( $d['links'] as $i => $l ) {
			$url    = descasio_url( $l['url'] );
			$ext    = descasio_is_external( $url ) ? ' target="_blank" rel="noopener noreferrer"' : '';
			$links .= de_reveal_open( 0.08 * ( $i + 1 ), 'flex-1' ) . '<a href="' . esc_url( $url ) . '"' . $ext . ' class="glass group flex h-full flex-col justify-between rounded-[var(--radius-card)] p-7 no-underline transition-transform duration-500 hover:-translate-y-1"><div><p class="text-sm font-bold text-accent-strong dark:text-accent">' . de_e( $l['sector'] ) . '</p><h3 class="mt-2 text-lg font-bold leading-snug text-fg">' . de_e( $l['title'] ) . '</h3></div>'
				. '<span class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-fg">' . esc_html__( 'Read case study', 'descasio-elements' ) . ' ' . descasio_icon( 'arrow-up-right', 'bold', 'transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5' ) . '</span></a></div>';
		}
		return '<section class="mx-auto max-w-6xl px-4 py-24"><div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'], $d['text'] ) . '</div><div class="mt-14 grid gap-5 lg:grid-cols-[1.25fr_1fr]">'
			. de_reveal_open() . '<article class="glass flex h-full flex-col justify-between rounded-[var(--radius-card)] p-8 md:p-10"><div><p class="text-sm font-bold text-accent-strong dark:text-accent">' . de_e( $d['f_sector'] ) . '</p><h3 class="mt-3 text-3xl font-extrabold leading-tight tracking-tight text-fg">' . de_e( $d['f_title'] ) . '</h3><p class="mt-4 max-w-lg leading-relaxed text-muted">' . de_e( $d['f_text'] ) . '</p></div>'
			. ( $metrics ? '<dl class="m-0 mt-10 grid grid-cols-2 gap-6 border-t border-line pt-8">' . $metrics . '</dl>' : '' ) . '</article></div>'
			. '<div class="flex flex-col gap-5">' . $links . '</div></div>'
			. ( $d['more_label'] ? '<div class="mt-10">' . descasio_button( $d['more_label'], $d['more_url'], 'glass' ) . '</div>' : '' ) . '</section>';
	},
);
