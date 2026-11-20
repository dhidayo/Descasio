<?php
/**
 * Blog index, archives and search results: glass cards in a three-column grid.
 *
 * @package Descasio
 */

get_header();

if ( is_home() && ! is_front_page() && get_option( 'page_for_posts' ) ) {
	$descasio_title = get_the_title( get_option( 'page_for_posts' ) );
	$descasio_intro = get_the_excerpt( get_option( 'page_for_posts' ) );
} elseif ( is_search() ) {
	/* translators: %s: search query */
	$descasio_title = sprintf( __( 'Results for {%s}', 'descasio' ), get_search_query() );
	$descasio_intro = '';
} elseif ( is_archive() ) {
	$descasio_title = wp_strip_all_tags( get_the_archive_title() );
	$descasio_intro = wp_strip_all_tags( get_the_archive_description() );
} else {
	$descasio_title = __( 'Insights on cloud, AI, and enterprise technology {in Africa.}', 'descasio' );
	$descasio_intro = __( "Perspectives from the team building Africa's digital infrastructure.", 'descasio' );
}
if ( ! $descasio_intro && is_home() ) {
	$descasio_intro = __( "Perspectives from the team building Africa's digital infrastructure.", 'descasio' );
}

echo descasio_page_hero( array( 'label' => __( 'Blog', 'descasio' ), 'title' => $descasio_title, 'intro' => $descasio_intro ) ); // phpcs:ignore WordPress.Security.EscapeOutput
?>
<section class="mx-auto max-w-6xl px-4 py-8">
	<?php if ( have_posts() ) : ?>
		<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
			<?php
			$descasio_i = 0;
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card', null, array( 'delay' => ( $descasio_i++ % 3 ) * 0.06 ) );
			endwhile;
			?>
		</div>
		<?php
		$descasio_prev = get_previous_posts_link( descasio_icon( 'arrow-left', 'bold' ) . ' ' . __( 'Newer', 'descasio' ) );
		$descasio_next = get_next_posts_link( __( 'Older', 'descasio' ) . ' ' . descasio_icon( 'arrow-right', 'bold' ) );
		if ( $descasio_prev || $descasio_next ) :
			global $wp_query;
			?>
			<nav aria-label="<?php esc_attr_e( 'Pagination', 'descasio' ); ?>" class="de-pager mt-12 flex items-center justify-between [&_a]:glass [&_a]:inline-flex [&_a]:items-center [&_a]:gap-2 [&_a]:rounded-full [&_a]:px-5 [&_a]:py-2.5 [&_a]:font-semibold [&_a]:text-fg [&_a]:no-underline">
				<span><?php echo $descasio_prev; // phpcs:ignore ?></span>
				<span class="text-[15px] text-muted">
					<?php
					/* translators: 1: current page, 2: total pages */
					printf( esc_html__( 'Page %1$d of %2$d', 'descasio' ), max( 1, get_query_var( 'paged' ) ), (int) $wp_query->max_num_pages );
					?>
				</span>
				<span><?php echo $descasio_next; // phpcs:ignore ?></span>
			</nav>
		<?php endif; ?>
	<?php else : ?>
		<div class="glass flex flex-col items-start gap-3 rounded-[var(--radius-card)] p-10">
			<span class="block text-[36px] leading-none text-accent"><?php echo descasio_icon( 'article' ); // phpcs:ignore ?></span>
			<h2 class="text-xl font-bold text-fg"><?php esc_html_e( 'Nothing to show yet', 'descasio' ); ?></h2>
			<p class="text-muted"><?php esc_html_e( 'New articles will appear here as soon as they are published.', 'descasio' ); ?></p>
		</div>
	<?php endif; ?>
</section>
<?php
get_footer();
