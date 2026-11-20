<?php
/**
 * Tabbed audience cards (DIP "who it's for"): one tab per industry, up to three role cards each.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

$descasio_role = fn( $n ) => array( de_f( "r{$n}_title", sprintf( __( 'Card %d title', 'descasio-elements' ), $n ) ), de_f( "r{$n}_text", sprintf( __( 'Card %d text', 'descasio-elements' ), $n ), 'textarea' ) );

return array(
	'title'  => __( 'Tabbed Cards', 'descasio-elements' ),
	'icon'   => 'eicon-tabs',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Built for organisations where every number matters.' ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', 'DIP is designed for highly regulated and data-intensive enterprises that need confidence in their reporting, governance, and AI readiness.' ),
		de_f( 'card_label', __( 'Small label on each card', 'descasio-elements' ), 'text', 'What they see in DIP' ),
		de_f(
			'tabs',
			__( 'Tabs', 'descasio-elements' ),
			'repeater',
			array(
				array(
					'name'     => 'Financial Services',
					'r1_title' => 'Executive Leadership',
					'r1_text'  => 'Portfolio health, emerging credit risk, branch performance, revenue trends, and where management intervention is needed.',
					'r2_title' => 'Risk & Credit Teams',
					'r2_text'  => 'High-risk customer segments, delinquency patterns, early-warning signals, loan and portfolio risk drivers, and collection priorities.',
					'r3_title' => 'Branch & Field Operations',
					'r3_text'  => 'Branch and agent performance, customer repayment behaviour, geographic trends, underperforming locations, and actionable intervention opportunities.',
				),
				array(
					'name'     => 'FMCG',
					'r1_title' => 'Executive & Commercial Leadership',
					'r1_text'  => 'Revenue performance, demand trends, growth opportunities, product and category performance, and market risks.',
					'r2_title' => 'Sales & Distribution Teams',
					'r2_text'  => 'Distributor and territory performance, sales trends, channel opportunities, customer behaviour, and underperforming areas.',
					'r3_title' => 'Supply Chain & Operations',
					'r3_text'  => 'Demand forecasts, inventory risks, product movement, stock-out patterns, warehouse performance, and supply-demand gaps.',
				),
			),
			array( 'title_field' => 'name', 'fields' => array_merge( array( de_f( 'name', __( 'Tab name', 'descasio-elements' ) ) ), $descasio_role( 1 ), $descasio_role( 2 ), $descasio_role( 3 ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$uid  = 'de-tabs-' . wp_unique_id();
		$list = '';
		$pans = '';
		foreach ( $d['tabs'] as $i => $t ) {
			$list .= '<button type="button" role="tab" id="' . $uid . '-t' . $i . '" aria-controls="' . $uid . '-p' . $i . '" aria-selected="' . ( 0 === $i ? 'true' : 'false' ) . '" class="relative rounded-full px-5 py-2.5 text-[15px] font-semibold text-fg/75 transition-colors hover:text-fg aria-selected:bg-accent-strong aria-selected:text-white">' . de_e( $t['name'] ) . '</button>';
			$cards = '';
			foreach ( array( 1, 2, 3 ) as $n ) {
				if ( '' !== $t[ "r{$n}_title" ] ) {
					$cards .= '<li class="glass rounded-[var(--radius-card)] p-7"><h3 class="text-lg font-bold text-fg">' . de_e( $t[ "r{$n}_title" ] ) . '</h3>' . ( $d['card_label'] ? '<p class="mt-1 text-sm font-semibold text-accent-strong dark:text-accent">' . de_e( $d['card_label'] ) . '</p>' : '' ) . '<p class="mt-3 leading-relaxed text-muted">' . de_e( $t[ "r{$n}_text" ] ) . '</p></li>';
				}
			}
			$pans .= '<div role="tabpanel" id="' . $uid . '-p' . $i . '" aria-labelledby="' . $uid . '-t' . $i . '" class="de-tab-panel"' . ( $i ? ' hidden' : '' ) . '><ul class="m-0 grid list-none gap-5 p-0 md:grid-cols-3">' . $cards . '</ul></div>';
		}
		return '<section class="mx-auto max-w-6xl px-4 py-16"><div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'], $d['text'] ) . '</div>'
			. '<div class="mt-10" ' . descasio_reveal() . ' data-de-tabs><div role="tablist" class="glass inline-flex flex-wrap rounded-full p-1.5">' . $list . '</div><div class="mt-8">' . $pans . '</div></div></section>';
	},
);
