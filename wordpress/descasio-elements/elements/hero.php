<?php
/**
 * Home hero: announcement pill, headline, subtext, buttons and the glass proof-point stack over the turning logo mark.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Home Hero', 'descasio-elements' ),
	'icon'   => 'eicon-banner',
	'fields' => array_merge(
		array(
			de_f( 'badge_tag', __( 'Announcement tag', 'descasio-elements' ), 'text', 'New' ),
			de_f( 'badge_text', __( 'Announcement text', 'descasio-elements' ), 'text', 'Decision Intelligence Platform' ),
			de_f( 'badge_url', __( 'Announcement link', 'descasio-elements' ), 'url', '/decision-intelligence-platform/' ),
			de_f( 'title', __( 'Headline', 'descasio-elements' ), 'text', 'Cloud. Automation. {AI.}', array( 'help' => __( 'Wrap words in {curly braces} to colour them.', 'descasio-elements' ) ) ),
			de_f( 'text', __( 'Subtext', 'descasio-elements' ), 'textarea', 'We build the cloud, automate the workflows and transform the enterprise. Built in Nigeria, owned end to end.' ),
		),
		Descasio_Registry::button_fields( 'btn', 'Book a Strategy Session', 'https://calendly.com/hi-descasio', 'Explore Solutions', '/solutions/' ),
		array(
			de_f( 'mark', __( 'Background mark', 'descasio-elements' ), 'image', 'asset:brand/descasio-mark.svg' ),
			de_f( 'card1_icon', __( 'Card 1 icon', 'descasio-elements' ), 'icon', 'certificate' ),
			de_f( 'card1_title', __( 'Card 1 title', 'descasio-elements' ), 'text', 'AWS Advanced Consulting Partner' ),
			de_f( 'card1_text', __( 'Card 1 text', 'descasio-elements' ), 'text', 'Plus the AWS AI Competency' ),
			de_f( 'card2_people', __( 'Card 2 photos', 'descasio-elements' ), 'gallery', array( 'asset:team/Dele-Nedd.png', 'asset:team/Femi-Olugbesan.png' ) ),
			de_f( 'card2_title', __( 'Card 2 title', 'descasio-elements' ), 'text', '70+ specialists' ),
			de_f( 'card2_text', __( 'Card 2 text', 'descasio-elements' ), 'textarea', 'Engineers, consultants and operators led by co-founders Dele Nedd and Femi Olugbesan.' ),
		)
	),
	'render' => function ( array $d ): string {
		ob_start();
		?>
		<section class="relative mx-auto grid min-h-[100dvh] max-w-6xl items-center gap-14 px-4 pb-16 pt-28 md:pt-24 lg:grid-cols-[1.1fr_0.9fr] lg:gap-8" data-parallax-root>
			<div>
				<?php if ( $d['badge_text'] ) : ?>
					<div class="de-rise">
						<a href="<?php echo esc_url( descasio_url( $d['badge_url'] ) ); ?>" class="glass group inline-flex items-center gap-2.5 rounded-full py-1.5 pl-1.5 pr-4 text-sm font-semibold text-fg no-underline transition-transform duration-300 hover:-translate-y-0.5">
							<?php if ( $d['badge_tag'] ) : ?>
								<span class="rounded-full bg-accent-strong px-2.5 py-1 text-xs font-bold text-white"><?php echo de_e( $d['badge_tag'] ); ?></span>
							<?php endif; ?>
							<?php echo de_e( $d['badge_text'] ); ?>
							<?php echo descasio_icon( 'arrow-right', 'bold', 'text-[14px] transition-transform group-hover:translate-x-0.5' ); // phpcs:ignore ?>
						</a>
					</div>
				<?php endif; ?>
				<h1 class="de-rise mt-6 text-balance text-[2.75rem] font-extrabold leading-[1.02] tracking-[-0.04em] text-fg sm:text-6xl lg:text-[4.6rem]" style="--rise-delay:.08s"><?php echo descasio_accent( $d['title'] ); // phpcs:ignore ?></h1>
				<p class="de-rise mt-6 max-w-[34ch] text-lg leading-relaxed text-muted md:text-xl" style="--rise-delay:.16s"><?php echo de_e( $d['text'] ); ?></p>
				<div class="de-rise mt-9 flex flex-wrap gap-3" style="--rise-delay:.24s"><?php echo Descasio_Registry::buttons( $d, 'btn' ); // phpcs:ignore ?></div>
			</div>

			<div class="relative mx-auto aspect-[4/5] w-full max-w-[520px] sm:aspect-square">
				<?php if ( $d['mark'] ) : ?>
					<div class="absolute inset-x-[10%] top-[18%] aspect-square sm:inset-[8%] sm:aspect-auto" data-depth style="--depth:-14">
						<div class="de-spin-in size-full"><img src="<?php echo esc_url( $d['mark'] ); ?>" alt="" class="turn size-full opacity-90"></div>
					</div>
				<?php endif; ?>
				<div class="absolute left-0 top-[4%] w-[82%] sm:top-[14%] sm:w-[62%]" data-depth style="--depth:10">
					<div class="de-rise glass rounded-[var(--radius-card)] p-5" style="--rise-delay:.45s">
						<div class="flex items-center gap-3">
							<span class="grid size-10 shrink-0 place-items-center rounded-full bg-accent-soft text-[22px] text-accent-strong dark:text-accent"><?php echo descasio_icon( $d['card1_icon'] ); // phpcs:ignore ?></span>
							<div>
								<p class="text-[15px] font-bold leading-tight text-fg"><?php echo de_e( $d['card1_title'] ); ?></p>
								<p class="mt-0.5 text-[13px] text-muted"><?php echo de_e( $d['card1_text'] ); ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="absolute bottom-[2%] right-0 w-[86%] sm:bottom-[8%] sm:w-[70%]" data-depth style="--depth:22">
					<div class="de-rise glass rounded-[var(--radius-card)] p-5" style="--rise-delay:.6s">
						<div class="flex items-center -space-x-3">
							<?php foreach ( $d['card2_people'] as $p ) : ?>
								<img src="<?php echo esc_url( $p['url'] ); ?>" alt="<?php echo esc_attr( $p['alt'] ); ?>" width="96" height="96" class="size-12 rounded-full border-2 border-[var(--bg-elevated)] object-cover object-top">
							<?php endforeach; ?>
							<span class="!ml-3 grid size-12 place-items-center rounded-full bg-accent-strong text-[22px] text-white"><?php echo descasio_icon( 'users-three', 'bold' ); // phpcs:ignore ?></span>
						</div>
						<p class="mt-4 text-2xl font-extrabold tracking-tight text-fg"><?php echo de_e( $d['card2_title'] ); ?></p>
						<p class="mt-1 text-[14px] leading-snug text-muted"><?php echo de_e( $d['card2_text'] ); ?></p>
					</div>
				</div>
			</div>
		</section>
		<?php
		return ob_get_clean();
	},
);
