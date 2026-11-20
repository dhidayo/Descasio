<?php
/**
 * Flagship product band: headline, outcomes, buttons and the animated evidence trail.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Flagship Product Band (DIP)', 'descasio-elements' ),
	'icon'   => 'eicon-star',
	'fields' => array_merge(
		array(
			de_f( 'eyebrow', __( 'Small label', 'descasio-elements' ), 'text', 'Our flagship platform' ),
			de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Decisions you can trust, from data you can defend.' ),
			de_f( 'text', __( 'Text', 'descasio-elements' ), 'textarea', 'The Decision Intelligence Platform connects, governs, and monitors your critical data, so every report and AI initiative stands on evidence.' ),
			de_f(
				'outcomes',
				__( 'Outcomes', 'descasio-elements' ),
				'repeater',
				array(
					array( 'icon' => 'target', 'title' => 'Make smarter decisions' ),
					array( 'icon' => 'trend-up', 'title' => 'Predict business outcomes' ),
					array( 'icon' => 'gauge', 'title' => 'Improve operational efficiency' ),
					array( 'icon' => 'trophy', 'title' => 'Gain a competitive advantage' ),
				),
				array( 'title_field' => 'title', 'fields' => array( de_f( 'icon', __( 'Icon', 'descasio-elements' ), 'icon', 'target' ), de_f( 'title', __( 'Text', 'descasio-elements' ), 'text', '' ) ) )
			),
		),
		Descasio_Registry::button_fields( 'btn', 'Explore DIP', '/decision-intelligence-platform/', 'Request Your Assessment', '/contact/?topic=dip' ),
		Descasio_Evidence_Trail::fields()
	),
	'render' => function ( array $d ): string {
		ob_start();
		?>
		<section class="mx-auto max-w-6xl px-4 pt-24">
			<div <?php echo descasio_reveal(); // phpcs:ignore ?>>
				<div class="glass relative overflow-hidden rounded-[32px] p-7 md:p-12">
					<div aria-hidden="true" class="pointer-events-none absolute -right-32 -top-32 size-96 rounded-full bg-[radial-gradient(circle,var(--blob-a),transparent_65%)] blur-2xl"></div>
					<div class="relative grid items-center gap-12 lg:grid-cols-[1.1fr_0.9fr]">
						<div>
							<?php if ( $d['eyebrow'] ) : ?>
								<p class="text-sm font-bold text-accent-strong dark:text-accent"><?php echo de_e( $d['eyebrow'] ); ?></p>
							<?php endif; ?>
							<h2 class="mt-3 text-balance text-[2.2rem] font-extrabold leading-[1.05] tracking-[-0.035em] text-fg md:text-5xl"><?php echo descasio_accent( $d['title'] ); // phpcs:ignore ?></h2>
							<p class="mt-5 max-w-[52ch] text-lg leading-relaxed text-muted"><?php echo de_e( $d['text'] ); ?></p>
							<ul class="m-0 mt-8 grid list-none gap-4 p-0 sm:grid-cols-2">
								<?php foreach ( $d['outcomes'] as $o ) : ?>
									<li class="flex items-center gap-3">
										<span class="grid size-10 shrink-0 place-items-center rounded-xl bg-accent-soft text-[20px] text-accent-strong dark:text-accent"><?php echo descasio_icon( $o['icon'] ); // phpcs:ignore ?></span>
										<span class="font-semibold leading-snug text-fg"><?php echo de_e( $o['title'] ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
							<div class="mt-10 flex flex-wrap gap-3"><?php echo Descasio_Registry::buttons( $d, 'btn' ); // phpcs:ignore ?></div>
						</div>
						<?php echo Descasio_Evidence_Trail::html( $d, '!bg-[var(--bg-elevated)]/70' ); // phpcs:ignore ?>
					</div>
				</div>
			</div>
		</section>
		<?php
		return ob_get_clean();
	},
);
