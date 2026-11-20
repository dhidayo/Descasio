<?php
/**
 * Before-and-after cards (PlugIQ use cases).
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Before and After Cards', 'descasio-elements' ),
	'icon'   => 'eicon-exchange',
	'fields' => array(
		de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Workflows that used to take weeks.' ),
		de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', 'Real enterprise processes automated with PlugIQ. Live in days, not months.' ),
		de_f(
			'items',
			__( 'Cards', 'descasio-elements' ),
			'repeater',
			array(
				array( 'area' => 'Procurement', 'before' => '14 days', 'after' => 'Same day', 'title' => 'Purchase Order Approvals', 'text' => 'Multi-level approval routing based on amount thresholds. Auto-escalation on delays. Full audit trail for compliance.' ),
				array( 'area' => 'HR Operations', 'before' => '5 days', 'after' => '4 hours', 'title' => 'Leave & Expense Approvals', 'text' => 'Employee submits via mobile or web. PlugIQ routes to the right manager based on department and policy rules.' ),
				array( 'area' => 'Vendor Management', 'before' => '3 weeks', 'after' => '3 days', 'title' => 'Vendor Onboarding & KYC', 'text' => 'Automated document collection, verification checklists, compliance checks, and approval routing.' ),
				array( 'area' => 'Finance', 'before' => 'Manual', 'after' => 'Real-time', 'title' => 'Payment Requisitions', 'text' => 'Every payment request captured, routed, approved, and logged automatically. Complete audit trail.' ),
			),
			array( 'title_field' => 'title', 'fields' => array( de_f( 'area', __( 'Area', 'descasio-elements' ) ), de_f( 'before', __( 'Before', 'descasio-elements' ) ), de_f( 'after', __( 'After', 'descasio-elements' ) ), de_f( 'title', __( 'Title', 'descasio-elements' ) ), de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea' ) ) )
		),
	),
	'render' => function ( array $d ): string {
		$out = '<section class="mx-auto max-w-6xl px-4 py-20"><div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'], $d['text'] ) . '</div><div class="mt-12 grid gap-5 md:grid-cols-2">';
		foreach ( $d['items'] as $i => $u ) {
			$out .= de_reveal_open( ( $i % 2 ) * 0.08 ) . '<div class="glass de-spotlight h-full rounded-[var(--radius-card)] p-8"><p class="text-sm font-bold text-accent-strong dark:text-accent">' . de_e( $u['area'] ) . '</p>'
				. '<p class="mt-5 flex items-baseline gap-3"><span class="text-xl font-semibold text-muted line-through decoration-2">' . de_e( $u['before'] ) . '</span><span class="text-[18px] text-accent" aria-label="' . esc_attr__( 'to', 'descasio-elements' ) . '">' . descasio_icon( 'arrow-right', 'bold' ) . '</span><span class="text-4xl font-extrabold tracking-[-0.03em] text-fg">' . de_e( $u['after'] ) . '</span></p>'
				. '<h3 class="mt-6 text-xl font-bold text-fg">' . de_e( $u['title'] ) . '</h3><p class="mt-2 leading-relaxed text-muted">' . de_e( $u['text'] ) . '</p></div></div>';
		}
		return $out . '</div></section>';
	},
);
