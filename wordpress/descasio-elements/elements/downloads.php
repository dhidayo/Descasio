<?php
/**
 * Whitepapers and guides: the first item is featured on an accent panel.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Downloads (Whitepapers)', 'descasio-elements' ),
	'icon'   => 'eicon-download-button',
	'fields' => array(
		de_f( 'label', __( 'Button text', 'descasio-elements' ), 'text', 'Download Free' ),
		de_f(
			'items',
			__( 'Downloads', 'descasio-elements' ),
			'repeater',
			array(
				array( 'title' => 'The Enterprise Playbook for Becoming AI-Ready', 'text' => "Who really owns your AI? A new report reveals why Nigeria's next competitive advantage won't come from where your data sits alone.", 'url' => '' ),
				array( 'title' => "The CIO's Guide to Sovereign Cloud in Nigeria", 'text' => 'Everything you need to know about data sovereignty, NDPR compliance, and building AI-ready infrastructure in-country.', 'url' => '' ),
				array( 'title' => 'How Enterprises Cut Approval Time by 60%', 'text' => 'Real-world examples of how PlugIQ transforms manual approval workflows into automated, auditable processes.', 'url' => '' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'text', __( 'Summary', 'descasio-elements' ), 'textarea' ), de_f( 'url', __( 'File or page link', 'descasio-elements' ), 'url' ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$items = $d['items'];
		if ( ! $items ) {
			return '';
		}
		$link = function ( string $url ): string {
			$url = descasio_url( $url ? $url : '#' );
			return 'href="' . esc_url( $url ) . '"' . ( descasio_is_external( $url ) ? ' target="_blank" rel="noopener noreferrer"' : '' );
		};
		$lead = array_shift( $items );
		$out  = '<section class="mx-auto max-w-6xl px-4 py-8"><div ' . descasio_reveal() . '><a ' . $link( $lead['url'] ) . ' class="group relative grid overflow-hidden rounded-[28px] bg-accent-strong p-8 text-white no-underline md:grid-cols-[1fr_auto] md:items-end md:p-12"><div><span class="block text-[36px] leading-none">' . descasio_icon( 'book-open-text' ) . '</span>'
			. '<h2 class="mt-6 max-w-2xl text-3xl font-extrabold leading-tight tracking-tight md:text-4xl">' . de_e( $lead['title'] ) . '</h2><p class="mt-3 max-w-xl leading-relaxed text-white/85">' . de_e( $lead['text'] ) . '</p></div>'
			. '<span class="mt-8 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 font-semibold text-accent-strong md:mt-0">' . descasio_icon( 'download-simple', 'bold' ) . ' ' . de_e( $d['label'] ) . '</span></a></div><div class="mt-5 grid gap-5 sm:grid-cols-2">';
		foreach ( $items as $i => $p ) {
			$out .= de_reveal_open( ( $i % 2 ) * 0.07 ) . '<a ' . $link( $p['url'] ) . ' class="glass group flex h-full flex-col justify-between rounded-[var(--radius-card)] p-7 no-underline transition-transform duration-500 hover:-translate-y-1"><div><span class="block h-[29px] text-[28px] leading-none text-accent">' . descasio_icon( 'book-open-text' ) . '</span><h2 class="mt-5 text-xl font-bold leading-snug text-fg">' . de_e( $p['title'] ) . '</h2><p class="mt-2 leading-relaxed text-muted">' . de_e( $p['text'] ) . '</p></div>'
				. '<span class="mt-6 inline-flex items-center gap-2 font-semibold text-accent-strong dark:text-accent">' . descasio_icon( 'download-simple', 'bold' ) . ' ' . de_e( $d['label'] ) . '</span></a></div>';
		}
		return $out . '</div></section>';
	},
);
