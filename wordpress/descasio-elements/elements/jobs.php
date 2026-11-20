<?php
/**
 * Open roles: sticky heading on the left, role links on the right (Careers).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Open Roles', 'descasio-elements' ),
	'icon'   => 'eicon-bullet-list',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Work that matters.' ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', "We're not building another SaaS tool for Silicon Valley. We're building the cloud, the automation, and the advisory practice that African enterprises depend on. The work is hard, the impact is real." ),
		de_f( 'apply_email', __( 'Applications email', 'descasio-elements' ), 'text', 'hi@descasio.io' ),
		de_f(
			'items',
			__( 'Roles', 'descasio-elements' ),
			'repeater',
			array(
				array( 'title' => 'Senior Cloud Architect', 'team' => 'Engineering', 'location' => 'Lagos', 'type' => 'Full-time', 'url' => '' ),
				array( 'title' => 'AI/ML Engineer', 'team' => 'Engineering', 'location' => 'Lagos / Remote', 'type' => 'Full-time', 'url' => '' ),
				array( 'title' => 'DevOps Engineer', 'team' => 'Engineering', 'location' => 'Lagos', 'type' => 'Full-time', 'url' => '' ),
				array( 'title' => 'Technical Consultant', 'team' => 'Consulting', 'location' => 'Lagos', 'type' => 'Full-time', 'url' => '' ),
				array( 'title' => 'Enterprise Account Executive', 'team' => 'Sales', 'location' => 'Lagos', 'type' => 'Full-time', 'url' => '' ),
				array( 'title' => 'Content & Marketing Manager', 'team' => 'Marketing', 'location' => 'Lagos', 'type' => 'Full-time', 'url' => '' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'title', __( 'Role', 'descasio-elements' ) ), de_f( 'team', __( 'Team', 'descasio-elements' ) ), de_f( 'location', __( 'Location', 'descasio-elements' ) ), de_f( 'type', __( 'Type', 'descasio-elements' ), 'text', 'Full-time' ), de_f( 'url', __( 'Apply link (empty = email)', 'descasio-elements' ), 'url' ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$list = '';
		foreach ( $d['items'] as $i => $r ) {
			$href  = $r['url'] ? descasio_url( $r['url'] ) : 'mailto:' . $d['apply_email'] . '?subject=' . rawurlencode( 'Application: ' . $r['title'] );
			$list .= '<li ' . descasio_reveal( $i * 0.04 ) . '><a href="' . esc_url( $href ) . '" class="glass group flex items-center justify-between gap-4 rounded-[var(--radius-card)] px-6 py-5 no-underline transition-transform duration-500 hover:-translate-y-0.5"><div><p class="text-lg font-bold text-fg">' . de_e( $r['title'] ) . '</p>'
				. '<p class="mt-1 text-[15px] text-muted">' . de_e( implode( ', ', array_filter( array( $r['team'], $r['location'] ) ) ) . ( $r['type'] ? '. ' . $r['type'] : '' ) ) . '</p></div>'
				. '<span class="inline-flex shrink-0 items-center gap-1 font-semibold text-accent-strong dark:text-accent">' . esc_html__( 'Apply', 'descasio-elements' ) . ' ' . descasio_icon( 'arrow-up-right', 'bold', 'transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5' ) . '</span></a></li>';
		}
		return '<section class="mx-auto grid max-w-6xl gap-10 px-4 py-12 lg:grid-cols-[0.8fr_1.2fr]"><div class="lg:sticky lg:top-28 lg:self-start" ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'], $d['text'] ) . '</div>'
			. '<div><h2 class="sr-only">' . esc_html__( 'Open roles', 'descasio-elements' ) . '</h2><ul class="m-0 flex list-none flex-col gap-3 p-0">' . $list . '</ul></div></section>';
	},
);
