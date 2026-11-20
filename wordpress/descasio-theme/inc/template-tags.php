<?php
/**
 * Shared template helpers. The Descasio Elements plugin uses these too, so every
 * element renders with exactly the same markup as the theme.
 *
 * @package Descasio
 */

defined( 'ABSPATH' ) || exit;

/** Theme option with a sensible default (set in Appearance > Customize > Descasio). */
function descasio_opt( string $key ) {
	$defaults = array(
		'booking_url'      => 'https://calendly.com/hi-descasio',
		'booking_label'    => 'Book a Strategy Session',
		'email'            => 'hi@descasio.io',
		'phone'            => '+234-1-912-5048',
		'address'          => '3/5 Boyle Street, Lagos Island, Lagos, Nigeria',
		'tagline'          => "Africa's Intelligent Enterprise Platform. We build the cloud, automate the workflows, and transform the enterprise.",
		'legal_name'       => 'Descasio Technology',
		'logo_light'       => '',
		'logo_dark'        => '',
		'featured_badge'   => 'Flagship platform',
		'featured_title'   => 'Decision Intelligence Platform',
		'featured_text'    => 'Turn fragmented data into decisions you can trust.',
		'featured_url'     => '/decision-intelligence-platform/',
		'featured_label'   => 'Explore DIP',
		'featured_icon'    => 'chart-line-up',
		'mega_note'        => "Not sure where to start? We'll help you find the highest-impact first step.",
		'solutions_url'    => '/solutions/',
		'resources_footer' => 'Take the free AI Readiness Assessment',
		'resources_url'    => '/ai-readiness/',
	);
	$value = get_theme_mod( 'descasio_' . $key, null );
	return ( null === $value || '' === $value ) ? ( $defaults[ $key ] ?? '' ) : $value;
}

/** Turns a site-relative path such as "/contact/" into a full URL; leaves full URLs alone. */
function descasio_url( string $url ): string {
	if ( '' === $url ) {
		return '';
	}
	if ( str_starts_with( $url, '/' ) && ! str_starts_with( $url, '//' ) ) {
		return home_url( $url );
	}
	return $url;
}

function descasio_is_external( string $url ): bool {
	$host = wp_parse_url( $url, PHP_URL_HOST );
	return $host && wp_parse_url( home_url(), PHP_URL_HOST ) !== $host;
}

/** URL of a file bundled in the theme's assets folder. */
function descasio_asset( string $path ): string {
	return DESCASIO_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Phosphor icon. $name is the icon's kebab-case name from phosphoricons.com, e.g. "chart-line-up".
 * $weight is duotone, bold or fill.
 */
function descasio_icon( string $name, string $weight = 'duotone', string $class = '' ): string {
	$name = sanitize_html_class( $name ? $name : 'sparkle' );
	return sprintf( '<i class="ph-%1$s ph-%2$s %3$s" aria-hidden="true"></i>', esc_attr( $weight ), esc_attr( $name ), esc_attr( $class ) );
}

/**
 * Escapes text and colours any words wrapped in curly braces with the brand accent.
 * Example: "Real impact. {Real results.}"
 */
function descasio_accent( string $text ): string {
	$safe = esc_html( $text );
	return preg_replace( '/\{(.+?)\}/s', '<span class="text-accent-strong dark:text-accent">$1</span>', $safe );
}

/** Plain text with any accent braces removed, for attributes and titles. */
function descasio_plain( string $text ): string {
	return trim( str_replace( array( '{', '}' ), '', $text ) );
}

/** Attributes for scroll reveal: echo inside an opening tag. */
function descasio_reveal( float $delay = 0, int $y = 24 ): string {
	$style = array();
	if ( $delay ) {
		$style[] = '--reveal-delay:' . round( $delay, 2 ) . 's';
	}
	if ( 24 !== $y ) {
		$style[] = '--reveal-y:' . $y . 'px';
	}
	return 'data-reveal' . ( $style ? ' style="' . esc_attr( implode( ';', $style ) ) . '"' : '' );
}

/** Pill button that matches the site: primary (accent fill) or glass. */
function descasio_button( string $label, string $url, string $variant = 'primary', array $args = array() ): string {
	if ( '' === trim( $label ) || '' === trim( $url ) ) {
		return '';
	}
	$args  = wp_parse_args( $args, array( 'arrow' => true, 'class' => '' ) );
	$url   = descasio_url( $url );
	$base  = 'group inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-full px-6 py-3 text-[15px] font-semibold no-underline transition-[transform,background-color,box-shadow] duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] active:scale-[0.98]';
	$style = 'glass' === $variant
		? 'glass text-fg hover:-translate-y-0.5'
		: 'bg-accent-strong text-white shadow-[inset_0_1px_0_rgb(255_255_255/0.25),0_12px_30px_-12px_rgb(198_59_28/0.7)] hover:bg-[var(--accent-strong-hover)] hover:-translate-y-0.5';
	$ext   = descasio_is_external( $url ) ? ' target="_blank" rel="noopener noreferrer"' : '';
	$arrow = $args['arrow'] ? descasio_icon( 'arrow-right', 'bold', 'text-base transition-transform duration-300 group-hover:translate-x-0.5' ) : '';
	return sprintf( '<a href="%s" class="%s"%s>%s%s</a>', esc_url( $url ), esc_attr( "$base $style {$args['class']}" ), $ext, esc_html( $label ), $arrow );
}

/** Ticked list used in service pages and panels. */
function descasio_check_list( array $items, string $class = '' ): string {
	$items = array_filter( array_map( 'trim', $items ) );
	if ( ! $items ) {
		return '';
	}
	$out = '<ul class="space-y-3 ' . esc_attr( $class ) . '">';
	foreach ( $items as $item ) {
		$out .= '<li class="flex gap-3 leading-snug text-fg"><span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-accent-soft text-[12px] text-accent-strong dark:text-accent">' . descasio_icon( 'check', 'bold' ) . '</span><span>' . esc_html( $item ) . '</span></li>';
	}
	return $out . '</ul>';
}

/** Splits a textarea into lines (one list item per line). */
function descasio_lines( $text ): array {
	if ( is_array( $text ) ) {
		return $text;
	}
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ) ) );
}

/** Stacked section heading: title, then optional body. */
function descasio_section_heading( string $title, string $body = '', string $align = 'left', string $tag = 'h2' ): string {
	$tag   = in_array( $tag, array( 'h1', 'h2', 'h3' ), true ) ? $tag : 'h2';
	$wrap  = 'center' === $align ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl';
	$out   = '<div class="' . $wrap . '"><' . $tag . ' class="text-balance text-[2.2rem] font-extrabold leading-[1.08] tracking-[-0.03em] text-fg md:text-5xl">' . descasio_accent( $title ) . '</' . $tag . '>';
	if ( '' !== trim( $body ) ) {
		$out .= '<p class="mt-5 max-w-[60ch] text-lg leading-relaxed text-muted' . ( 'center' === $align ? ' mx-auto' : '' ) . '">' . esc_html( $body ) . '</p>';
	}
	return $out . '</div>';
}

/** Theme-aware logo: ink version on light, white version on dark. */
function descasio_logo( string $class = 'h-7 w-auto' ): string {
	$light = descasio_opt( 'logo_light' );
	$dark  = descasio_opt( 'logo_dark' );
	$light = $light ? $light : descasio_asset( 'brand/descasio-logo-light-bg.png' );
	$dark  = $dark ? $dark : descasio_asset( 'brand/descasio-logo-dark-bg.png' );
	$name  = get_bloginfo( 'name' );
	return sprintf(
		'<img src="%1$s" alt="%3$s" width="249" height="68" class="%4$s dark:hidden"><img src="%2$s" alt="%3$s" width="249" height="68" class="%4$s hidden dark:block">',
		esc_url( $light ),
		esc_url( $dark ),
		esc_attr( $name ),
		esc_attr( $class )
	);
}

/** Inner-page hero: label, headline, intro and optional buttons. Used by the theme and the Page Hero element. */
function descasio_page_hero( array $a ): string {
	$a = wp_parse_args(
		$a,
		array( 'label' => '', 'status' => '', 'title' => '', 'intro' => '', 'buttons' => '' )
	);
	$out = '<section class="mx-auto max-w-6xl px-4 pb-12 pt-36 md:pt-44"><div ' . descasio_reveal() . '>';
	if ( $a['label'] || $a['status'] ) {
		$out .= '<div class="flex flex-wrap items-center gap-2">';
		if ( $a['label'] ) {
			$out .= '<span class="rounded-full bg-accent-soft px-3.5 py-1.5 text-sm font-bold text-accent-strong dark:text-accent">' . esc_html( $a['label'] ) . '</span>';
		}
		if ( $a['status'] ) {
			$out .= '<span class="glass rounded-full px-3.5 py-1.5 text-sm font-semibold text-fg">' . esc_html( $a['status'] ) . '</span>';
		}
		$out .= '</div>';
	}
	$out .= '<h1 class="mt-6 max-w-4xl text-balance text-[2.6rem] font-extrabold leading-[1.04] tracking-[-0.04em] text-fg md:text-6xl lg:text-[4.2rem]">' . descasio_accent( $a['title'] ) . '</h1>';
	if ( $a['intro'] ) {
		$out .= '<p class="mt-6 max-w-[58ch] text-lg leading-relaxed text-muted md:text-xl">' . esc_html( $a['intro'] ) . '</p>';
	}
	if ( $a['buttons'] ) {
		$out .= '<div class="mt-9 flex flex-wrap gap-3">' . $a['buttons'] . '</div>';
	}
	return $out . '</div></section>';
}

/** Closing call to action band with the turning logo marks. */
function descasio_cta_band( array $a = array() ): string {
	$a = wp_parse_args(
		$a,
		array(
			'title' => 'Ready to stop stitching together vendors?',
			'body'  => 'Book a 30-minute strategy session with our team. No pitch deck, no pressure. Just an honest conversation about where your technology needs to go next.',
			'label' => descasio_opt( 'booking_label' ),
			'url'   => descasio_opt( 'booking_url' ),
		)
	);
	$mark = esc_url( descasio_asset( 'brand/descasio-mark.svg' ) );
	return '<section class="mx-auto max-w-6xl px-4 pt-12"><div ' . descasio_reveal() . '><div class="glass relative overflow-hidden rounded-[32px] px-6 py-16 text-center md:px-16 md:py-20">'
		. '<img src="' . $mark . '" alt="" class="turn pointer-events-none absolute -left-24 -top-24 size-80 opacity-[0.12]">'
		. '<img src="' . $mark . '" alt="" class="turn pointer-events-none absolute -bottom-28 -right-20 size-96 opacity-[0.12]">'
		. '<h2 class="relative mx-auto max-w-2xl text-balance text-4xl font-extrabold leading-[1.06] tracking-[-0.035em] text-fg md:text-5xl">' . descasio_accent( $a['title'] ) . '</h2>'
		. ( $a['body'] ? '<p class="relative mx-auto mt-5 max-w-[52ch] text-lg leading-relaxed text-muted">' . esc_html( $a['body'] ) . '</p>' : '' )
		. '<div class="relative mt-9 flex justify-center">' . descasio_button( $a['label'], $a['url'] ) . '</div>'
		. '</div></div></section>';
}

/** True when the current post was built with Elementor or WPBakery (so the theme adds no title or wrapper). */
function descasio_is_builder_page( $post_id = null ): bool {
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( ! $post_id ) {
		return false;
	}
	if ( 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true ) ) {
		return true;
	}
	$content = (string) get_post_field( 'post_content', $post_id );
	return str_contains( $content, '[vc_row' ) || str_contains( $content, '[descasio_' );
}
