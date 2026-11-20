<?php
/**
 * Page not found.
 *
 * @package Descasio
 */

get_header();
?>
<section class="mx-auto flex min-h-[80dvh] max-w-3xl flex-col items-center justify-center px-4 pt-28 text-center">
	<img src="<?php echo esc_url( descasio_asset( 'brand/descasio-mark.svg' ) ); ?>" alt="" class="turn size-24">
	<h1 class="mt-8 text-5xl font-extrabold tracking-[-0.04em] text-fg"><?php esc_html_e( 'Page not found', 'descasio' ); ?></h1>
	<p class="mt-4 max-w-md text-lg leading-relaxed text-muted"><?php esc_html_e( "The page you're looking for has moved or no longer exists.", 'descasio' ); ?></p>
	<div class="mt-8 flex flex-wrap justify-center gap-3">
		<?php
		echo descasio_button( __( 'Back to home', 'descasio' ), home_url( '/' ) ); // phpcs:ignore
		echo descasio_button( __( 'Contact us', 'descasio' ), '/contact/', 'glass', array( 'arrow' => false ) ); // phpcs:ignore
		?>
	</div>
</section>
<?php
get_footer();
