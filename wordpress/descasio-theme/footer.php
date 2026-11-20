<?php
/**
 * Site footer.
 *
 * @package Descasio
 */

defined( 'ABSPATH' ) || exit;
$descasio_email = descasio_opt( 'email' );
$descasio_phone = descasio_opt( 'phone' );
?>
</main>

<footer class="px-4 pb-6 pt-24">
	<div class="glass mx-auto max-w-6xl rounded-[28px] p-8 md:p-12">
		<div class="grid gap-12 md:grid-cols-[1.4fr_1fr_1fr_1fr]">
			<div>
				<?php echo descasio_logo( 'h-8 w-auto' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				<p class="mt-5 max-w-xs leading-relaxed text-muted"><?php echo esc_html( descasio_opt( 'tagline' ) ); ?></p>
				<address class="mt-6 space-y-1.5 text-[15px] not-italic">
					<a href="mailto:<?php echo esc_attr( $descasio_email ); ?>" class="block font-semibold text-fg no-underline hover:text-accent-strong dark:hover:text-accent"><?php echo esc_html( $descasio_email ); ?></a>
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $descasio_phone ) ); ?>" class="block text-muted no-underline hover:text-fg"><?php echo esc_html( $descasio_phone ); ?></a>
					<span class="block text-muted"><?php echo esc_html( descasio_opt( 'address' ) ); ?></span>
				</address>
			</div>
			<?php foreach ( descasio_footer_columns() as list( $descasio_title, $descasio_links ) ) : ?>
				<div>
					<h3 class="text-sm font-bold text-fg"><?php echo esc_html( $descasio_title ); ?></h3>
					<ul class="m-0 mt-4 list-none space-y-2.5 p-0">
						<?php foreach ( $descasio_links as list( $descasio_label, $descasio_url ) ) : ?>
							<li><a href="<?php echo esc_url( $descasio_url ); ?>" class="text-[15px] text-muted no-underline transition-colors hover:text-fg"><?php echo esc_html( $descasio_label ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="mt-12 border-t border-line pt-6 text-sm text-muted">
			&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( descasio_opt( 'legal_name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'descasio' ); ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
