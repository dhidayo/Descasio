<?php
/**
 * Client logo marquee (the only marquee on the site).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

$descasio_logos = array_map( fn( $n ) => 'asset:clients/' . $n . '.png', array( 'DANGOTE', 'NNPC', 'TOTAL-ENERGIES', 'FED-MINISTRY-OF-FINANCE', 'HILTON', 'SANOFI', 'HONEYWELL', 'UNIFIED-PAYMENTS', 'KONGA', 'WAKANOW', 'COSCHARIS', 'NCDMB', 'NBS', 'AVON', '7UP' ) );

return array(
	'title'  => __( 'Client Logos', 'descasio-elements' ),
	'icon'   => 'eicon-logo',
	'fields' => array(
		de_f( 'title', __( 'Heading', 'descasio-elements' ), 'text', 'Trusted by 400+ organisations across every major industry in Nigeria' ),
		de_f( 'logos', __( 'Logos', 'descasio-elements' ), 'gallery', $descasio_logos ),
	),
	'render' => function ( array $d ): string {
		$logos = $d['logos'];
		if ( ! $logos ) {
			return '';
		}
		$row = array_merge( $logos, $logos );
		$n   = count( $logos );
		$out = '<section class="py-20"><h2 class="mx-auto max-w-2xl px-4 text-center text-lg font-semibold text-muted">' . de_e( $d['title'] ) . '</h2>'
			. '<div class="marquee relative mt-10 overflow-hidden [mask-image:linear-gradient(90deg,transparent,#000_12%,#000_88%,transparent)]"><ul class="marquee-track m-0 flex w-max list-none gap-4 p-0">';
		foreach ( $row as $i => $logo ) {
			$hidden = $i >= $n;
			$out   .= '<li' . ( $hidden ? ' aria-hidden="true"' : '' ) . ' class="grid h-24 w-36 shrink-0 place-items-center rounded-2xl bg-white p-3 shadow-[0_8px_24px_-14px_rgb(14_26_43/0.35)] ring-1 ring-black/5">'
				. '<img src="' . esc_url( $logo['url'] ) . '" alt="' . esc_attr( $hidden ? '' : $logo['alt'] ) . '" loading="lazy" class="max-h-full w-auto object-contain"></li>';
		}
		return $out . '</ul></div></section>';
	},
);
