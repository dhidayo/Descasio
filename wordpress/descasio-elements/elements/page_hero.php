<?php
/**
 * Inner-page hero: label, status pill, headline, intro and buttons.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Page Hero', 'descasio-elements' ),
	'icon'   => 'eicon-heading',
	'fields' => array_merge(
		array(
			de_f( 'label', __( 'Label', 'descasio-elements' ), 'text', 'Solutions' ),
			de_f( 'status', __( 'Status pill (optional, e.g. Coming soon)', 'descasio-elements' ), 'text', '' ),
			de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Technology built to transform how African enterprises operate, scale, and win.', array( 'help' => __( 'Wrap words in {curly braces} to colour them.', 'descasio-elements' ) ) ),
			de_f( 'intro', __( 'Intro', 'descasio-elements' ), 'textarea', '' ),
		),
		Descasio_Registry::button_fields( 'btn', '', '', '', '' ),
		array( de_f( 'pills', __( 'Pills under the intro (one per line, optional)', 'descasio-elements' ), 'lines', array() ) )
	),
	'render' => function ( array $d ): string {
		$buttons = Descasio_Registry::buttons( $d, 'btn' );
		if ( $d['pills'] ) {
			$buttons .= '<ul class="m-0 flex list-none flex-wrap gap-2 p-0">' . implode( '', array_map( fn( $p ) => '<li class="glass rounded-full px-5 py-2 font-semibold text-fg">' . de_e( $p ) . '</li>', $d['pills'] ) ) . '</ul>';
		}
		return descasio_page_hero( array( 'label' => $d['label'], 'status' => $d['status'], 'title' => $d['title'], 'intro' => $d['intro'], 'buttons' => $buttons ) );
	},
);
