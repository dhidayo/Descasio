<?php
/**
 * Site header: ambient background, skip link and the glass navigation with mega menu.
 *
 * @package Descasio
 */

defined( 'ABSPATH' ) || exit;

$descasio_nav     = descasio_nav();
$descasio_booking = descasio_opt( 'booking_url' );
$descasio_book_lb = descasio_opt( 'booking_label' );

/** One link inside a menu panel: icon tile, label and description. */
$descasio_menu_link = function ( array $link ): string {
	$icon = $link['icon'] ? $link['icon'] : 'sparkle';
	$out  = '<a href="' . esc_url( $link['url'] ) . '" class="group/link flex items-start gap-3 rounded-[14px] p-2.5 no-underline transition-colors hover:bg-accent-soft focus-visible:bg-accent-soft">';
	$out .= '<span class="grid size-9 shrink-0 place-items-center rounded-[10px] border border-line bg-[var(--bg)] text-[18px] text-accent-strong transition-colors group-hover/link:border-transparent group-hover/link:bg-accent-strong group-hover/link:text-white dark:text-accent dark:group-hover/link:text-white">' . descasio_icon( $icon ) . '</span>';
	$out .= '<span class="min-w-0 pt-0.5"><span class="block text-[14.5px] font-semibold leading-tight text-fg">' . esc_html( $link['label'] ) . '</span>';
	if ( $link['description'] ) {
		$out .= '<span class="mt-1 block text-[13px] leading-snug text-muted">' . esc_html( $link['description'] ) . '</span>';
	}
	return $out . '</span></a>';
};

$descasio_is_mega = fn( array $item ): bool => (bool) array_filter( $item['children'], fn( $c ) => ! empty( $c['children'] ) );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-full focus:bg-accent-strong focus:px-4 focus:py-2 focus:text-white"><?php esc_html_e( 'Skip to content', 'descasio' ); ?></a>

<?php // Fixed ambient light behind the page: gives the glass something to refract. ?>
<div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10 overflow-hidden bg-bg transition-colors duration-500">
	<div class="drift absolute -top-[18%] right-[-12%] h-[60vmax] w-[60vmax] rounded-full bg-[radial-gradient(circle,var(--blob-a),transparent_62%)] blur-3xl"></div>
	<div class="drift absolute top-[30%] -left-[18%] h-[58vmax] w-[58vmax] rounded-full bg-[radial-gradient(circle,var(--blob-b),transparent_62%)] blur-3xl" style="animation-delay:-9s"></div>
	<div class="drift absolute -bottom-[25%] right-[10%] h-[50vmax] w-[50vmax] rounded-full bg-[radial-gradient(circle,var(--blob-c),transparent_62%)] blur-3xl" style="animation-delay:-16s"></div>
</div>

<header class="de-header fixed inset-x-0 top-0 z-40 px-4 pt-3 md:pt-4" data-de-nav>
	<div aria-hidden="true" class="de-scrim fixed inset-0 -z-20 bg-[rgb(10_18_32/0.12)] backdrop-blur-[3px] dark:bg-[rgb(0_0_0/0.3)]" data-de-scrim></div>

	<nav aria-label="<?php esc_attr_e( 'Main', 'descasio' ); ?>" class="relative mx-auto flex h-16 max-w-6xl items-center justify-between rounded-full pl-5 pr-2" data-de-bar>
		<?php // The bar's frosted layer sits beside the menus, not around them, so dropdowns blur the page itself. ?>
		<span aria-hidden="true" class="de-nav-surface glass-nav pointer-events-none absolute inset-0 -z-10 rounded-full"></span>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' home' ); ?>" class="shrink-0">
			<?php echo descasio_logo( 'h-[26px] w-auto' ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in helper. ?>
		</a>

		<ul class="m-0 hidden list-none items-center gap-1 p-0 lg:flex">
			<?php
			foreach ( $descasio_nav as $descasio_item ) :
				if ( empty( $descasio_item['children'] ) ) :
					?>
					<li>
						<a href="<?php echo esc_url( $descasio_item['url'] ); ?>" class="rounded-full px-4 py-2 text-[15px] font-semibold no-underline transition-colors hover:text-fg <?php echo $descasio_item['current'] ? 'text-accent-strong dark:text-accent' : 'text-fg/80'; ?>">
							<?php echo esc_html( $descasio_item['label'] ); ?>
						</a>
					</li>
					<?php
					continue;
				endif;
				$descasio_mega = $descasio_is_mega( $descasio_item );
				?>
				<li class="<?php echo $descasio_mega ? '' : 'relative'; ?>" data-de-dropdown>
					<button type="button" aria-expanded="false" aria-haspopup="true" class="flex items-center gap-1 rounded-full px-4 py-2 text-[15px] font-semibold text-fg/80 transition-colors hover:text-fg [.is-open>&]:bg-accent-soft [.is-open>&]:text-fg">
						<?php echo esc_html( $descasio_item['label'] ); ?>
						<?php echo descasio_icon( 'caret-down', 'bold', 'de-caret text-[13px]' ); // phpcs:ignore ?>
					</button>

					<?php if ( $descasio_mega ) : ?>
						<div class="de-menu-panel absolute inset-x-0 top-full pt-3">
							<div class="glass-menu overflow-hidden rounded-[24px]">
								<div class="grid grid-cols-[250px_1fr] gap-2 p-2">
									<a href="<?php echo esc_url( descasio_url( descasio_opt( 'featured_url' ) ) ); ?>" class="group/dip relative flex flex-col justify-between overflow-hidden rounded-[18px] bg-accent-strong p-5 text-white no-underline">
										<div aria-hidden="true" class="pointer-events-none absolute -bottom-16 -right-16 size-48 rounded-full bg-white/10"></div>
										<div class="relative">
											<span class="inline-flex rounded-full bg-white/15 px-2.5 py-1 text-[11px] font-bold"><?php echo esc_html( descasio_opt( 'featured_badge' ) ); ?></span>
											<span class="mt-5 block text-[30px] leading-none"><?php echo descasio_icon( descasio_opt( 'featured_icon' ) ); // phpcs:ignore ?></span>
											<p class="mt-3 text-lg font-extrabold leading-tight"><?php echo esc_html( descasio_opt( 'featured_title' ) ); ?></p>
											<p class="mt-2 text-[13.5px] leading-snug text-white/85"><?php echo esc_html( descasio_opt( 'featured_text' ) ); ?></p>
										</div>
										<span class="relative mt-6 inline-flex items-center gap-1.5 text-sm font-semibold">
											<?php echo esc_html( descasio_opt( 'featured_label' ) ); ?>
											<?php echo descasio_icon( 'arrow-right', 'bold', 'transition-transform group-hover/dip:translate-x-1' ); // phpcs:ignore ?>
										</span>
									</a>
									<div class="grid grid-cols-3 gap-1 p-2">
										<?php foreach ( $descasio_item['children'] as $descasio_col ) : ?>
											<div>
												<p class="px-2.5 pb-2 pt-1 text-xs font-bold text-muted"><?php echo esc_html( $descasio_col['label'] ); ?></p>
												<ul class="m-0 list-none space-y-0.5 p-0">
													<?php foreach ( $descasio_col['children'] as $descasio_link ) : ?>
														<li><?php echo $descasio_menu_link( $descasio_link ); // phpcs:ignore ?></li>
													<?php endforeach; ?>
												</ul>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
								<div class="flex items-center justify-between border-t border-line bg-[var(--bg)]/60 px-5 py-3 text-[14px]">
									<span class="text-muted"><?php echo esc_html( descasio_opt( 'mega_note' ) ); ?></span>
									<div class="flex items-center gap-5">
										<a href="<?php echo esc_url( descasio_url( descasio_opt( 'solutions_url' ) ) ); ?>" class="font-semibold text-fg no-underline hover:text-accent-strong dark:hover:text-accent"><?php esc_html_e( 'All solutions', 'descasio' ); ?></a>
										<a href="<?php echo esc_url( $descasio_booking ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 font-semibold text-accent-strong no-underline dark:text-accent"><?php echo esc_html( $descasio_book_lb ); ?> <?php echo descasio_icon( 'arrow-right', 'bold' ); // phpcs:ignore ?></a>
									</div>
								</div>
							</div>
						</div>
					<?php else : ?>
						<div class="de-menu-panel absolute left-1/2 top-full w-[360px] -translate-x-1/2 pt-3">
							<div class="glass-menu overflow-hidden rounded-[22px]">
								<ul class="m-0 list-none space-y-0.5 p-2">
									<?php foreach ( $descasio_item['children'] as $descasio_link ) : ?>
										<li><?php echo $descasio_menu_link( $descasio_link ); // phpcs:ignore ?></li>
									<?php endforeach; ?>
								</ul>
								<?php
								$descasio_is_company = 'company' === strtolower( $descasio_item['label'] );
								$descasio_foot_url   = $descasio_is_company ? 'mailto:' . descasio_opt( 'email' ) : descasio_url( descasio_opt( 'resources_url' ) );
								$descasio_foot_text  = $descasio_is_company ? descasio_opt( 'email' ) : descasio_opt( 'resources_footer' );
								?>
								<a href="<?php echo esc_url( $descasio_foot_url ); ?>" class="flex items-center justify-between border-t border-line bg-[var(--bg)]/60 px-5 py-3 text-[14px] font-semibold text-accent-strong no-underline dark:text-accent">
									<?php echo esc_html( $descasio_foot_text ); ?>
									<?php echo descasio_icon( 'arrow-right', 'bold' ); // phpcs:ignore ?>
								</a>
							</div>
						</div>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="flex items-center gap-1">
			<button type="button" class="grid size-10 place-items-center rounded-full text-[19px] text-fg transition-colors hover:bg-accent-soft" data-de-theme-toggle aria-label="<?php esc_attr_e( 'Switch colour theme', 'descasio' ); ?>">
				<span class="dark:hidden"><?php echo descasio_icon( 'moon', 'bold' ); // phpcs:ignore ?></span>
				<span class="hidden dark:inline"><?php echo descasio_icon( 'sun', 'bold' ); // phpcs:ignore ?></span>
			</button>
			<a href="<?php echo esc_url( $descasio_booking ); ?>" target="_blank" rel="noopener noreferrer" class="hidden rounded-full bg-accent-strong px-5 py-2.5 text-[14px] font-semibold text-white no-underline transition-[transform,background-color] duration-300 hover:-translate-y-0.5 hover:bg-[var(--accent-strong-hover)] active:scale-[0.98] sm:inline-flex">
				<?php echo esc_html( $descasio_book_lb ); ?>
			</a>
			<button type="button" class="grid size-10 place-items-center rounded-full text-[22px] text-fg transition-colors hover:bg-accent-soft lg:hidden" data-de-mobile-toggle aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'descasio' ); ?>">
				<span class="[.de-mobile-open_&]:hidden"><?php echo descasio_icon( 'list', 'bold' ); // phpcs:ignore ?></span>
				<span class="hidden [.de-mobile-open_&]:inline"><?php echo descasio_icon( 'x', 'bold' ); // phpcs:ignore ?></span>
			</button>
		</div>
	</nav>

	<div class="de-mobile-panel glass-menu mx-auto mt-2 max-h-[calc(100dvh-6rem)] max-w-6xl overflow-y-auto rounded-[24px] p-3 lg:hidden" data-lenis-prevent>
		<div class="flex flex-col gap-1">
			<a href="<?php echo esc_url( descasio_url( descasio_opt( 'featured_url' ) ) ); ?>" class="mb-2 flex items-center gap-3 rounded-[16px] bg-accent-strong p-4 text-white no-underline">
				<span class="shrink-0 text-[26px]"><?php echo descasio_icon( descasio_opt( 'featured_icon' ) ); // phpcs:ignore ?></span>
				<span class="min-w-0">
					<span class="block text-[11px] font-bold text-white/80"><?php echo esc_html( descasio_opt( 'featured_badge' ) ); ?></span>
					<span class="block font-bold leading-tight"><?php echo esc_html( descasio_opt( 'featured_title' ) ); ?></span>
				</span>
				<span class="ml-auto shrink-0"><?php echo descasio_icon( 'arrow-right', 'bold' ); // phpcs:ignore ?></span>
			</a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="rounded-[16px] px-3 py-3 text-base font-bold text-fg no-underline"><?php esc_html_e( 'Home', 'descasio' ); ?></a>
			<?php foreach ( $descasio_nav as $descasio_item ) : ?>
				<?php if ( empty( $descasio_item['children'] ) ) : ?>
					<a href="<?php echo esc_url( $descasio_item['url'] ); ?>" class="rounded-[16px] px-3 py-3 text-base font-bold text-fg no-underline"><?php echo esc_html( $descasio_item['label'] ); ?></a>
				<?php else : ?>
					<details class="group rounded-[16px] open:bg-[var(--bg)]/60">
						<summary class="flex cursor-pointer items-center justify-between rounded-[16px] px-3 py-3 text-base font-bold text-fg">
							<?php echo esc_html( $descasio_item['label'] ); ?>
							<?php echo descasio_icon( 'caret-down', 'bold', 'de-caret text-[15px]' ); // phpcs:ignore ?>
						</summary>
						<div class="px-1 pb-2">
							<?php if ( $descasio_is_mega( $descasio_item ) ) : ?>
								<?php foreach ( $descasio_item['children'] as $descasio_col ) : ?>
									<p class="px-2.5 pb-1 pt-2 text-xs font-bold text-muted"><?php echo esc_html( $descasio_col['label'] ); ?></p>
									<?php foreach ( $descasio_col['children'] as $descasio_link ) : ?>
										<?php echo $descasio_menu_link( $descasio_link ); // phpcs:ignore ?>
									<?php endforeach; ?>
								<?php endforeach; ?>
							<?php else : ?>
								<?php foreach ( $descasio_item['children'] as $descasio_link ) : ?>
									<?php echo $descasio_menu_link( $descasio_link ); // phpcs:ignore ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</details>
				<?php endif; ?>
			<?php endforeach; ?>
			<a href="<?php echo esc_url( $descasio_booking ); ?>" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-accent-strong px-6 py-3.5 font-semibold text-white no-underline">
				<?php echo esc_html( $descasio_book_lb ); ?> <?php echo descasio_icon( 'arrow-right', 'bold' ); // phpcs:ignore ?>
			</a>
		</div>
	</div>
</header>

<main id="main">
