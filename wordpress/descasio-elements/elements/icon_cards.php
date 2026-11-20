<?php
/**
 * Section heading plus a grid of glass cards with icons (e.g. DIP outcomes).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Icon Cards Grid', 'descasio-elements' ),
	'icon'   => 'eicon-icon-box',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Make your next big decision with data intelligence.' ),
		de_f( 'text', __( 'Text (optional)', 'descasio-elements' ), 'textarea', '' ),
		de_f( 'columns', __( 'Columns', 'descasio-elements' ), 'select', '2', array( 'options' => array( '2' => '2', '3' => '3', '4' => '4' ) ) ),
		de_f( 'layout', __( 'Card layout', 'descasio-elements' ), 'select', 'stack', array( 'options' => array( 'row' => __( 'Icon beside text', 'descasio-elements' ), 'stack' => __( 'Icon above text', 'descasio-elements' ) ) ) ),
		de_f(
			'items',
			__( 'Cards', 'descasio-elements' ),
			'repeater',
			array(
				array( 'icon' => 'target', 'title' => 'Make smarter decisions', 'text' => 'Turn complex business data into actionable insights for better strategic decisions.' ),
				array( 'icon' => 'trend-up', 'title' => 'Predict business outcomes', 'text' => 'Identify emerging trends, patterns, and potential risks before they impact performance.' ),
				array( 'icon' => 'gauge', 'title' => 'Improve operational efficiency', 'text' => 'Uncover bottlenecks, optimise processes, and identify opportunities for cost savings.' ),
				array( 'icon' => 'trophy', 'title' => 'Gain a competitive advantage', 'text' => 'Make faster, data-driven decisions that drive growth and business performance.' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'icon', __( 'Icon', 'descasio-elements' ), 'icon', 'sparkle' ), de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea' ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$cols = array( '2' => 'sm:grid-cols-2', '3' => 'sm:grid-cols-2 lg:grid-cols-3', '4' => 'sm:grid-cols-2 lg:grid-cols-4' )[ $d['columns'] ] ?? 'sm:grid-cols-2';
		$row  = 'row' === $d['layout'];
		$out  = '<section class="mx-auto max-w-6xl px-4 py-16">' . ( $d['title'] ? '<div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'], $d['text'] ) . '</div>' : '' ) . '<div class="mt-12 grid gap-5 ' . $cols . '">';
		foreach ( $d['items'] as $i => $c ) {
			$icon = '<span class="grid size-12 shrink-0 place-items-center rounded-2xl bg-accent-soft text-[26px] text-accent-strong dark:text-accent">' . descasio_icon( $c['icon'] ) . '</span>';
			$body = '<div><h3 class="text-xl font-bold text-fg">' . de_e( $c['title'] ) . '</h3><p class="mt-2 leading-relaxed text-muted">' . de_e( $c['text'] ) . '</p></div>';
			$out .= de_reveal_open( ( $i % (int) $d['columns'] ) * 0.07 ) . '<div class="glass de-spotlight h-full rounded-[var(--radius-card)] p-7' . ( $row ? ' flex gap-5' : '' ) . '">' . $icon . $body . '</div></div>';
		}
		return $out . '</div></section>';
	},
);
