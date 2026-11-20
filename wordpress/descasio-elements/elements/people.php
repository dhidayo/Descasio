<?php
/**
 * Team: large photo cards (leadership) or round portraits (board).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Team Members', 'descasio-elements' ),
	'icon'   => 'eicon-person',
	'fields' => array(
		de_f( 'title', __( 'Headline (optional)', 'descasio-elements' ), 'text', 'The team behind Descasio.' ),
		de_f( 'style', __( 'Style', 'descasio-elements' ), 'select', 'cards', array( 'options' => array( 'cards' => __( 'Photo cards', 'descasio-elements' ), 'circles' => __( 'Round portraits', 'descasio-elements' ) ) ) ),
		de_f(
			'items',
			__( 'People', 'descasio-elements' ),
			'repeater',
			array(
				array( 'name' => 'Dele Nedd', 'role' => 'CEO & Co-Founder', 'photo' => 'asset:team/Dele-Nedd.png' ),
				array( 'name' => 'Femi Olugbesan', 'role' => 'CIO & Co-Founder', 'photo' => 'asset:team/Femi-Olugbesan.png' ),
				array( 'name' => 'Nehita Fashe', 'role' => 'Chief Sales Officer', 'photo' => 'asset:team/Nehitas-Photo.png' ),
			),
			array( 'title_field' => 'name', 'fields' => array( de_f( 'name', __( 'Name', 'descasio-elements' ) ), de_f( 'role', __( 'Role', 'descasio-elements' ) ), de_f( 'photo', __( 'Photo', 'descasio-elements' ), 'image' ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$circles = 'circles' === $d['style'];
		$out     = '<section class="mx-auto max-w-6xl px-4 ' . ( $circles ? 'pb-16 pt-4' : 'py-16' ) . '">'; // pt-4: the live site's spacing above the board.
		if ( $d['title'] ) {
			$out .= $circles
				? '<h2 class="text-2xl font-extrabold tracking-tight text-fg" ' . descasio_reveal() . '>' . descasio_accent( $d['title'] ) . '</h2>'
				: '<div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'] ) . '</div>';
		}
		$out .= $circles ? '<div class="mt-8 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-5">' : '<div class="mt-12 grid gap-5 sm:grid-cols-3">';
		foreach ( $d['items'] as $i => $p ) {
			if ( $circles ) {
				$out .= de_reveal_open( $i * 0.05 ) . '<figure class="m-0 text-center"><div class="relative mx-auto aspect-square w-full max-w-[180px] overflow-hidden rounded-full ring-4 ring-white/70 dark:ring-white/10">' . ( $p['photo'] ? '<img src="' . esc_url( $p['photo'] ) . '" alt="' . esc_attr( $p['name'] ) . '" loading="lazy" class="absolute inset-0 size-full object-cover">' : '' ) . '</div>'
					. '<figcaption class="mt-4"><p class="font-bold text-fg">' . de_e( $p['name'] ) . '</p><p class="text-sm text-muted">' . de_e( $p['role'] ) . '</p></figcaption></figure></div>';
			} else {
				$out .= de_reveal_open( $i * 0.07 ) . '<figure class="glass m-0 overflow-hidden rounded-[var(--radius-card)] p-2"><div class="relative aspect-[4/3] overflow-hidden rounded-[16px] bg-[var(--bg-elevated)]">' . ( $p['photo'] ? '<img src="' . esc_url( $p['photo'] ) . '" alt="' . esc_attr( $p['name'] ) . '" loading="lazy" class="absolute inset-0 size-full object-cover object-top">' : '' ) . '</div>'
					. '<figcaption class="px-4 pb-4 pt-5"><p class="text-lg font-bold text-fg">' . de_e( $p['name'] ) . '</p><p class="text-[15px] text-muted">' . de_e( $p['role'] ) . '</p></figcaption></figure></div>';
			}
		}
		return $out . '</div></section>';
	},
);
