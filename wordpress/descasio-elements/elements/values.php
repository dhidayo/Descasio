<?php
/**
 * Values grid with accent top rules (About).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Values Grid', 'descasio-elements' ),
	'icon'   => 'eicon-bullet-list',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'What drives us every day.' ),
		de_f(
			'items',
			__( 'Values', 'descasio-elements' ),
			'repeater',
			array(
				array( 'title' => 'Customer-Centricity', 'text' => 'We solve real problems for real businesses. Not theoretical frameworks. Not proofs of concept that never ship.' ),
				array( 'title' => 'Ownership', 'text' => "We act with integrity and take responsibility for outcomes. When something breaks at 2am, we're already on it." ),
				array( 'title' => 'Innovation', 'text' => "We challenge norms and lead with possibility. We built our own cloud and our own automation platform because the alternatives weren't good enough." ),
				array( 'title' => 'Leadership', 'text' => 'We drive change, not wait for it. From cloud pioneers in 2010 to Sovereign AI Cloud in 2026.' ),
				array( 'title' => 'Value Creation', 'text' => 'We prioritise impact and lasting results over noise. Every engagement is measured by what it delivered, not what it promised.' ),
				array( 'title' => 'Forward Thinking', 'text' => 'Our founding principle. We invest today in the infrastructure and capabilities our clients will need tomorrow.' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea' ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$out = '<section class="mx-auto max-w-6xl px-4 py-16"><div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'] ) . '</div><div class="mt-12 grid gap-x-10 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">';
		foreach ( $d['items'] as $i => $v ) {
			$out .= de_reveal_open( ( $i % 3 ) * 0.06 ) . '<div class="border-t-2 border-accent pt-6"><h3 class="text-xl font-bold text-fg">' . de_e( $v['title'] ) . '</h3><p class="mt-3 leading-relaxed text-muted">' . de_e( $v['text'] ) . '</p></div></div>';
		}
		return $out . '</div></section>';
	},
);
