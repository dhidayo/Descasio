<?php
/**
 * Section heading with optional text, for free-form layouts.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Section Heading', 'descasio-elements' ),
	'icon'   => 'eicon-t-letter',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'A clear, confident headline.', array( 'help' => __( 'Wrap words in {curly braces} to colour them.', 'descasio-elements' ) ) ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', '' ),
		de_f( 'align', __( 'Alignment', 'descasio-elements' ), 'select', 'left', array( 'options' => array( 'left' => __( 'Left', 'descasio-elements' ), 'center' => __( 'Centre', 'descasio-elements' ) ) ) ),
	),
	'render' => fn( array $d ): string => '<section class="mx-auto max-w-6xl px-4 pt-16"><div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'], $d['text'], $d['align'] ) . '</div></section>',
);
