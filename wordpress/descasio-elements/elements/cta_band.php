<?php
/**
 * Closing call to action.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Call to Action Band', 'descasio-elements' ),
	'icon'   => 'eicon-call-to-action',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Ready to stop stitching together vendors?' ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', 'Book a 30-minute strategy session with our team. No pitch deck, no pressure. Just an honest conversation about where your technology needs to go next.' ),
		de_f( 'label', __( 'Button text', 'descasio-elements' ), 'text', 'Book a Strategy Session' ),
		de_f( 'url', __( 'Button link', 'descasio-elements' ), 'url', 'https://calendly.com/hi-descasio' ),
	),
	'render' => fn( array $d ): string => descasio_cta_band( array( 'title' => $d['title'], 'body' => $d['text'], 'label' => $d['label'], 'url' => $d['url'] ) ),
);
