<?php
/**
 * Single blog post, matching the site's article view.
 *
 * @package Descasio
 */

get_header();

while ( have_posts() ) :
	the_post();
	if ( descasio_is_builder_page() ) {
		the_content();
		continue;
	}
	$descasio_cats = get_the_category();
	$descasio_cat  = $descasio_cats && 'uncategorized' !== $descasio_cats[0]->slug ? $descasio_cats[0] : null;
	$descasio_blog = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
	?>
	<article <?php post_class( 'mx-auto max-w-3xl px-4 pt-36 md:pt-40' ); ?>>
		<a href="<?php echo esc_url( $descasio_blog ); ?>" class="inline-flex items-center gap-2 text-[15px] font-semibold text-muted no-underline hover:text-fg">
			<?php echo descasio_icon( 'arrow-left', 'bold' ); // phpcs:ignore ?> <?php esc_html_e( 'All articles', 'descasio' ); ?>
		</a>
		<div class="mt-8 flex flex-wrap items-center gap-3 text-sm">
			<?php if ( $descasio_cat ) : ?>
				<a href="<?php echo esc_url( get_category_link( $descasio_cat ) ); ?>" class="rounded-full bg-accent-soft px-3 py-1 font-bold text-accent-strong no-underline dark:text-accent"><?php echo esc_html( $descasio_cat->name ); ?></a>
			<?php endif; ?>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="text-muted"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time>
		</div>
		<h1 class="mt-5 text-balance text-4xl font-extrabold leading-[1.08] tracking-[-0.035em] text-fg md:text-5xl"><?php the_title(); ?></h1>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="glass relative mt-10 aspect-[16/9] overflow-hidden rounded-[var(--radius-card)] p-1.5">
				<?php the_post_thumbnail( 'large', array( 'class' => 'size-full rounded-[18px] object-cover' ) ); ?>
			</div>
		<?php endif; ?>
		<div class="prose-descasio mt-10"><?php the_content(); ?></div>
	</article>
	<?php
	echo descasio_cta_band(); // phpcs:ignore WordPress.Security.EscapeOutput
endwhile;

get_footer();
