<?php
/**
 * Descasio theme bootstrap.
 *
 * @package Descasio
 */

defined( 'ABSPATH' ) || exit;

define( 'DESCASIO_VERSION', '1.0.0' );
define( 'DESCASIO_DIR', get_template_directory() );
define( 'DESCASIO_URI', get_template_directory_uri() );

require DESCASIO_DIR . '/inc/template-tags.php';
require DESCASIO_DIR . '/inc/setup.php';
require DESCASIO_DIR . '/inc/assets.php';
require DESCASIO_DIR . '/inc/customizer.php';
require DESCASIO_DIR . '/inc/nav.php';
