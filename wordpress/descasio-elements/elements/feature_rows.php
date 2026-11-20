<?php
/**
 * Stacked glass rows: copy and a button on the left, a ticked list on the right (Solutions, Partners).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Feature Rows', 'descasio-elements' ),
	'icon'   => 'eicon-section',
	'fields' => array(
		de_f( 'numbered', __( 'Number the labels (01, 02, ...)', 'descasio-elements' ), 'switch', 'yes' ),
		de_f(
			'items',
			__( 'Rows', 'descasio-elements' ),
			'repeater',
			array(
				array( 'icon' => 'chart-line-up', 'label' => 'Decision Intelligence', 'status' => 'Flagship', 'title' => 'Decision Intelligence Platform (DIP)', 'text' => 'Turn fragmented data into decisions you can trust.', 'badges' => '', 'btn_label' => 'Explore DIP', 'btn_url' => '/decision-intelligence-platform/', 'list_title' => '', 'list' => "Connects to your existing systems without disruption\nAutomated quality checks before data reaches reporting\nComplete lineage from source to insight\nGoverned, AI-ready data leaders can act on" ),
			),
			array(
				'title_field' => 'title',
				'fields'      => array(
					de_f( 'icon', __( 'Icon (leave empty for none)', 'descasio-elements' ), 'icon', '' ),
					de_f( 'label', __( 'Label', 'descasio-elements' ) ),
					de_f( 'status', __( 'Status pill', 'descasio-elements' ) ),
					de_f( 'title', __( 'Title', 'descasio-elements' ) ),
					de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea' ),
					de_f( 'badges', __( 'Badges (one per line)', 'descasio-elements' ), 'textarea' ),
					de_f( 'btn_label', __( 'Button text', 'descasio-elements' ) ),
					de_f( 'btn_url', __( 'Button link', 'descasio-elements' ), 'url' ),
					de_f( 'list_title', __( 'List title (optional)', 'descasio-elements' ) ),
					de_f( 'list', __( 'List (one per line)', 'descasio-elements' ), 'textarea' ),
				),
			)
		),
	),
	'render' => function ( array $d ): string {
		$out = '<section class="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-12">';
		foreach ( $d['items'] as $i => $r ) {
			$head = '';
			if ( $r['icon'] ) {
				$head .= '<span class="grid size-12 place-items-center rounded-2xl bg-accent-strong text-[26px] text-white">' . descasio_icon( $r['icon'] ) . '</span>';
			}
			$head .= '<span class="text-sm font-bold text-accent-strong dark:text-accent">' . ( $d['numbered'] ? sprintf( '%02d ', $i + 1 ) : '' ) . de_e( $r['label'] ) . '</span>';
			if ( $r['status'] ) {
				$head .= '<span class="rounded-full border border-line px-3 py-1 text-xs font-semibold text-muted">' . de_e( $r['status'] ) . '</span>';
			}
			$badges = descasio_lines( $r['badges'] );
			$out   .= '<div ' . descasio_reveal() . '><article class="glass grid rounded-[28px] p-8 md:p-12 ' . ( $r['icon'] ? 'gap-10 md:grid-cols-[1.1fr_0.9fr]' : 'gap-8 md:grid-cols-[1.2fr_0.8fr]' ) . '"><div><div class="flex flex-wrap items-center gap-3">' . $head . '</div>'
				. '<h2 class="' . ( $r['icon'] ? 'mt-7' : 'mt-3' ) . ' text-3xl font-extrabold leading-tight tracking-tight text-fg md:text-4xl">' . descasio_accent( $r['title'] ) . '</h2><p class="mt-4 ' . ( $r['icon'] ? 'max-w-lg' : 'max-w-xl' ) . ' text-lg leading-relaxed text-muted">' . de_e( $r['text'] ) . '</p>'
				. ( $badges ? '<ul class="m-0 mt-6 flex list-none flex-wrap gap-2 p-0">' . implode( '', array_map( fn( $b ) => '<li class="rounded-full bg-accent-soft px-3.5 py-1.5 text-sm font-semibold text-accent-strong dark:text-accent">' . de_e( $b ) . '</li>', $badges ) ) . '</ul>' : '' )
				. descasio_button( $r['btn_label'], $r['btn_url'], 'glass', array( 'class' => 'mt-8' ) ) . '</div>'
				. '<div class="self-center rounded-[var(--radius-card)] border border-line bg-[var(--bg-elevated)]/50 p-7">' . ( $r['list_title'] ? '<h3 class="mb-5 font-bold text-fg">' . de_e( $r['list_title'] ) . '</h3>' : '' ) . descasio_check_list( descasio_lines( $r['list'] ), $r['list_title'] ? 'text-[15px]' : '' ) . '</div></article></div>';
		}
		return $out . '</section>';
	},
);
