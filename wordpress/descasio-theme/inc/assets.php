<?php
/**
 * Front-end styles and scripts.
 *
 * @package Descasio
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'wp_enqueue_scripts',
	function () {
		$v = DESCASIO_VERSION;
		wp_enqueue_style( 'descasio-icons-duotone', DESCASIO_URI . '/assets/vendor/phosphor/duotone/style.css', array(), $v );
		wp_enqueue_style( 'descasio-icons-bold', DESCASIO_URI . '/assets/vendor/phosphor/bold/style.css', array(), $v );
		wp_enqueue_style( 'descasio-icons-fill', DESCASIO_URI . '/assets/vendor/phosphor/fill/style.css', array(), $v );
		wp_enqueue_style( 'descasio', DESCASIO_URI . '/assets/css/descasio.css', array(), $v );

		wp_enqueue_script( 'lenis', DESCASIO_URI . '/assets/vendor/lenis/lenis.min.js', array(), '1', array( 'strategy' => 'defer', 'in_footer' => true ) );
		wp_enqueue_script( 'descasio', DESCASIO_URI . '/assets/js/descasio.js', array( 'lenis' ), $v, array( 'strategy' => 'defer', 'in_footer' => true ) );
	}
);

/** Preload the brand font so headings never flash in a fallback face. */
add_action(
	'wp_head',
	function () {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( DESCASIO_URI . '/assets/fonts/PlusJakartaSans-Variable.woff2' )
		);
	},
	1
);

/**
 * Applies the saved or system colour theme before first paint (no flash), and marks JS as available
 * so scroll-reveal styles only apply when the script can reveal them.
 */
add_action(
	'wp_head',
	function () {
		echo "<script>(function(){var d=document.documentElement;d.classList.add('de-js');try{var t=localStorage.getItem('theme');if(!t){t=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light'}d.dataset.theme=t}catch(e){d.dataset.theme='light'}})()</script>\n";
	},
	0
);

add_action(
	'wp_head',
	function () {
		echo '<meta name="theme-color" content="#f6f7fa" media="(prefers-color-scheme: light)">' . "\n";
		echo '<meta name="theme-color" content="#0a1220" media="(prefers-color-scheme: dark)">' . "\n";
	},
	2
);

/** Favicon from the brand mark when no Site Icon is set. */
add_action(
	'wp_head',
	function () {
		if ( ! has_site_icon() ) {
			printf( '<link rel="icon" href="%s" type="image/svg+xml">' . "\n", esc_url( DESCASIO_URI . '/assets/brand/descasio-mark.svg' ) );
		}
	}
);
