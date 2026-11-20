<?php
/**
 * "Three layers" section: sticky headline on the left, spotlight cards on the right.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Sticky Heading + Cards', 'descasio-elements' ),
	'icon'   => 'eicon-posts-grid',
	'fields' => array(
		de_f( 'title', __( 'Headline (one line per row)', 'descasio-elements' ), 'lines', array( 'Three layers.', 'One partner.', '{Zero handoffs.}' ) ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', "Most partners advise or build or manage. We do all three, on infrastructure we own, with a platform we built. That's why enterprises trust us with their most critical systems." ),
		de_f(
			'items',
			__( 'Cards', 'descasio-elements' ),
			'repeater',
			array(
				array( 'icon' => 'briefcase', 'number' => '01', 'title' => 'Enterprise Consulting & Managed Services', 'text' => "From cloud migration strategy to ongoing infrastructure management. We don't hand you a report and leave. We stay, we run it, we take ownership of outcomes.", 'link_label' => 'Explore Services', 'link_url' => '/solutions/' ),
				array( 'icon' => 'cloud-arrow-up', 'number' => '02', 'title' => 'Cloud Infrastructure & Sovereign AI', 'text' => 'AWS Advanced Partner managing 100K+ cloud licences. Plus in-country, compliant cloud for organisations that need full data sovereignty and AI-ready compute.', 'link_label' => 'Explore Infrastructure', 'link_url' => '/sovereign-cloud/' ),
				array( 'icon' => 'flow-arrow', 'number' => '03', 'title' => 'Our Platforms: DIP and PlugIQ', 'text' => 'Our Decision Intelligence Platform turns fragmented data into decisions you can trust. PlugIQ turns manual approvals into automated, auditable workflows. Built and owned by us.', 'link_label' => 'Explore DIP', 'link_url' => '/decision-intelligence-platform/' ),
			),
			array(
				'title_field' => 'title',
				'fields'      => array(
					de_f( 'icon', __( 'Icon', 'descasio-elements' ), 'icon', 'sparkle' ),
					de_f( 'number', __( 'Number', 'descasio-elements' ), 'text', '' ),
					de_f( 'title', __( 'Title', 'descasio-elements' ) ),
					de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea' ),
					de_f( 'link_label', __( 'Link text', 'descasio-elements' ) ),
					de_f( 'link_url', __( 'Link', 'descasio-elements' ), 'url' ),
				),
			)
		),
	),
	'render' => function ( array $d ): string {
		$title = implode( '<br>', array_map( 'descasio_accent', $d['title'] ) );
		$out   = '<section class="mx-auto grid max-w-6xl gap-10 px-4 py-24 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16"><div class="lg:sticky lg:top-32 lg:self-start"><div ' . descasio_reveal() . '>'
			. '<h2 class="text-[2.4rem] font-extrabold leading-[1.04] tracking-[-0.035em] text-fg md:text-6xl">' . $title . '</h2>'
			. '<p class="mt-6 max-w-[46ch] text-lg leading-relaxed text-muted">' . de_e( $d['text'] ) . '</p></div></div><div class="flex flex-col gap-5">';
		foreach ( $d['items'] as $i => $c ) {
			$out .= de_reveal_open( $i * 0.08 ) . '<div class="glass de-spotlight group relative overflow-hidden rounded-[var(--radius-card)] p-7 md:p-9">'
				. '<div class="flex items-start justify-between gap-6"><span class="grid size-12 place-items-center rounded-2xl bg-accent-soft text-[26px] text-accent-strong dark:text-accent">' . descasio_icon( $c['icon'] ) . '</span><span class="text-5xl font-extrabold tracking-tighter text-fg/10">' . de_e( $c['number'] ) . '</span></div>'
				. '<h3 class="mt-6 text-2xl font-bold tracking-tight text-fg">' . de_e( $c['title'] ) . '</h3><p class="mt-3 leading-relaxed text-muted">' . de_e( $c['text'] ) . '</p>';
			if ( $c['link_label'] ) {
				$out .= '<a href="' . esc_url( descasio_url( $c['link_url'] ) ) . '" class="mt-6 inline-flex items-center gap-1.5 font-semibold text-accent-strong no-underline dark:text-accent">' . de_e( $c['link_label'] ) . descasio_icon( 'arrow-right', 'bold', 'transition-transform group-hover:translate-x-1' ) . '</a>';
			}
			$out .= '</div></div>';
		}
		return $out . '</div></section>';
	},
);
