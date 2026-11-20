<?php
/**
 * Article layout for ordinary pages (e.g. Privacy Policy): page hero and readable text on glass.
 *
 * @package Descasio
 */

$descasio_excerpt = has_excerpt() ? get_the_excerpt() : '';
echo descasio_page_hero( array( 'title' => get_the_title(), 'intro' => $descasio_excerpt ) ); // phpcs:ignore WordPress.Security.EscapeOutput
?>
<section class="mx-auto max-w-3xl px-4 pb-8">
	<div class="glass prose-descasio rounded-[28px] p-7 md:p-12">
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
	</div>
</section>
