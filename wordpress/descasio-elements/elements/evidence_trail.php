<?php
/**
 * The DIP evidence trail on its own, for any layout.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Evidence Trail', 'descasio-elements' ),
	'icon'   => 'eicon-time-line',
	'fields' => Descasio_Evidence_Trail::fields(),
	'render' => fn( array $d ): string => '<div class="mx-auto max-w-md px-4">' . Descasio_Evidence_Trail::html( $d ) . '</div>',
);
