<?php
/**
 * Shared pieces used by more than one element.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

/** DIP evidence trail: stages verify one after another when the panel scrolls into view. */
class Descasio_Evidence_Trail {

	public static function fields(): array {
		return array(
			de_f( 'trail_title', __( 'Evidence trail: title', 'descasio-elements' ), 'text', 'Evidence trail' ),
			de_f( 'trail_badge', __( 'Evidence trail: live badge', 'descasio-elements' ), 'text', 'Live' ),
			de_f(
				'trail_steps',
				__( 'Evidence trail: stages', 'descasio-elements' ),
				'repeater',
				array(
					array( 'stage' => 'Source', 'state' => 'Verified' ),
					array( 'stage' => 'Ingestion', 'state' => 'Verified' ),
					array( 'stage' => 'Quality check', 'state' => 'Verified' ),
					array( 'stage' => 'Lineage', 'state' => 'Traced' ),
					array( 'stage' => 'Governance', 'state' => 'Enforced' ),
					array( 'stage' => 'Insight', 'state' => 'Defensible' ),
				),
				array( 'title_field' => 'stage', 'fields' => array( de_f( 'stage', __( 'Stage', 'descasio-elements' ) ), de_f( 'state', __( 'Status', 'descasio-elements' ) ) ) )
			),
			de_f( 'trail_done', __( 'Evidence trail: result line', 'descasio-elements' ), 'text', 'Every number traceable from source to decision' ),
		);
	}

	public static function html( array $d, string $class = '' ): string {
		$steps = $d['trail_steps'];
		$out   = '<div class="de-trail glass rounded-[28px] p-6 md:p-7 ' . esc_attr( $class ) . '" ' . descasio_reveal( 0, 0 ) . '>'
			. '<div class="flex items-center justify-between"><p class="text-[15px] font-bold text-fg">' . de_e( $d['trail_title'] ) . '</p>';
		if ( $d['trail_badge'] ) {
			$out .= '<span class="inline-flex items-center gap-2 rounded-full bg-accent-soft px-3 py-1 text-xs font-bold text-accent-strong dark:text-accent"><span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-accent opacity-60 motion-reduce:animate-none"></span><span class="relative inline-flex size-2 rounded-full bg-accent"></span></span>' . de_e( $d['trail_badge'] ) . '</span>';
		}
		$out .= '</div><ol class="relative m-0 mt-6 list-none p-0"><span aria-hidden="true" class="absolute bottom-4 left-[15px] top-4 w-0.5 rounded-full bg-line"></span><span aria-hidden="true" class="de-trail-fill absolute left-[15px] top-4 w-0.5 origin-top rounded-full bg-accent"></span>';
		foreach ( $steps as $i => $s ) {
			$out .= '<li class="de-trail-step relative flex items-center gap-4 py-2.5" style="--i:' . (int) $i . '">'
				. '<span class="de-trail-dot relative z-10 grid size-8 shrink-0 place-items-center rounded-full border-2 border-line bg-[var(--bg-elevated)]" style="--i:' . (int) $i . '"><span class="text-[11px] font-bold text-muted">' . sprintf( '%02d', $i + 1 ) . '</span></span>'
				. '<span class="flex-1 text-[15px] font-semibold text-fg">' . de_e( $s['stage'] ) . '</span>'
				. '<span class="de-trail-state inline-flex items-center gap-1.5 text-sm font-semibold text-accent-strong dark:text-accent" style="--i:' . (int) $i . '">' . descasio_icon( 'check-circle', 'fill', 'text-base' ) . de_e( $s['state'] ) . '</span></li>';
		}
		$out .= '</ol>';
		if ( $d['trail_done'] ) {
			$out .= '<div class="de-trail-done mt-5 flex items-center gap-3 rounded-[16px] bg-accent-strong px-4 py-3.5 text-white" style="transition-delay:' . ( 0.3 + count( $steps ) * 0.4 ) . 's"><span class="text-[22px]">' . descasio_icon( 'shield-check' ) . '</span><span class="text-[15px] font-semibold">' . de_e( $d['trail_done'] ) . '</span></div>';
		}
		return $out . '</div>';
	}
}

/** Reveal wrapper with a stagger delay. */
function de_reveal_open( float $delay = 0, string $class = '' ): string {
	return '<div ' . descasio_reveal( $delay ) . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . '>';
}
