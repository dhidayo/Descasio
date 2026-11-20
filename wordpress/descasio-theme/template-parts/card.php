<?php
/**
 * Blog card: image, category, date, title and excerpt.
 *
 * @package Descasio
 */

$descasio_cats = get_the_category();
$descasio_cat  = $descasio_cats && 'uncategorized' !== $descasio_cats[0]->slug ? $descasio_cats[0]->name : '';
?>
<div <?php echo descasio_reveal( (float) ( $args['delay'] ?? 0 ) ); // phpcs:ignore ?>>
	<a href="<?php the_permalink(); ?>" class="glass group flex h-full flex-col overflow-hidden rounded-[var(--radius-card)] p-1.5 no-underline transition-transform duration-500 hover:-translate-y-1">
		<div class="relative aspect-[16/10] overflow-hidden rounded-[17px] bg-accent-soft">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large', array( 'class' => 'absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-[1.04]' ) ); ?>
			<?php else : ?>
				<span class="absolute inset-0 grid place-items-center text-[40px] text-accent"><?php echo descasio_icon( 'article' ); // phpcs:ignore ?></span>
			<?php endif; ?>
		</div>
		<div class="flex flex-1 flex-col p-5">
			<div class="flex flex-wrap items-center gap-2 text-[13px]">
				<?php if ( $descasio_cat ) : ?>
					<span class="font-bold text-accent-strong dark:text-accent"><?php echo esc_html( $descasio_cat ); ?></span>
				<?php endif; ?>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="text-muted"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time>
			</div>
			<h2 class="mt-3 text-lg font-bold leading-snug text-fg"><?php the_title(); ?></h2>
			<p class="mt-2 line-clamp-3 text-[15px] leading-relaxed text-muted"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
		</div>
	</a>
</div>
