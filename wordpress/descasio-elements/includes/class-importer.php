<?php
/**
 * Descasio > Import pages: recreates the whole site in one click, as Elementor layouts or WPBakery rows,
 * with menus, the home page and the blog page set up.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

class Descasio_Importer {

	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ), 20 );
		add_action( 'admin_post_descasio_import', array( __CLASS__, 'handle' ) );
	}

	public static function menu(): void {
		add_submenu_page( 'descasio', __( 'Import pages', 'descasio-elements' ), __( 'Import pages', 'descasio-elements' ), 'manage_options', 'descasio-import', array( __CLASS__, 'page' ) );
	}

	public static function pages(): array {
		return json_decode( (string) file_get_contents( DESCASIO_EL_DIR . 'data/pages.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local file.
	}

	public static function page(): void {
		$builder = Descasio_Settings::get( 'builder' );
		$target  = 'wpbakery' === $builder ? 'WPBakery' : 'Elementor';
		$report  = get_transient( 'descasio_import_report' );
		delete_transient( 'descasio_import_report' );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Import the Descasio pages', 'descasio-elements' ); ?></h1>
			<?php if ( $report ) : ?>
				<div class="notice notice-success"><p><?php echo esc_html( $report ); ?></p></div>
			<?php endif; ?>
			<p>
				<?php
				/* translators: %s: page builder name */
				printf( esc_html__( 'Creates every page of the Descasio website as editable %s layouts, using the Descasio elements and the current copy.', 'descasio-elements' ), '<strong>' . esc_html( $target ) . '</strong>' );
				?>
			</p>
			<p><?php esc_html_e( 'Pages that already exist (same address) are left alone unless you tick "Replace existing pages". Change the builder under Descasio > Settings.', 'descasio-elements' ); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="descasio_import">
				<?php wp_nonce_field( 'descasio_import' ); ?>
				<p><label><input type="checkbox" name="replace" value="1"> <?php esc_html_e( 'Replace existing pages', 'descasio-elements' ); ?></label></p>
				<p><label><input type="checkbox" name="menus" value="1" checked> <?php esc_html_e( 'Create the main and footer menus (only where none is assigned)', 'descasio-elements' ); ?></label></p>
				<p><label><input type="checkbox" name="reading" value="1" checked> <?php esc_html_e( 'Set "Home" as the front page and "Blog" as the posts page', 'descasio-elements' ); ?></label></p>
				<?php submit_button( __( 'Import pages', 'descasio-elements' ) ); ?>
			</form>
			<h2><?php esc_html_e( 'Pages included', 'descasio-elements' ); ?></h2>
			<p><?php echo esc_html( implode( ', ', array_map( fn( $p ) => $p['title'], self::pages() ) ) ); ?></p>
		</div>
		<?php
	}

	public static function handle(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You are not allowed to do this.', 'descasio-elements' ) );
		}
		check_admin_referer( 'descasio_import' );
		$result = self::run( ! empty( $_POST['replace'] ), ! empty( $_POST['menus'] ), ! empty( $_POST['reading'] ) );
		set_transient( 'descasio_import_report', $result, MINUTE_IN_SECONDS );
		wp_safe_redirect( admin_url( 'admin.php?page=descasio-import' ) );
		exit;
	}

	/** Runs the import. Also used by WP-CLI: wp eval 'echo Descasio_Importer::run();' */
	public static function run( bool $replace = false, bool $menus = true, bool $reading = true ): string {
		$builder = 'wpbakery' === Descasio_Settings::get( 'builder' ) ? 'wpbakery' : 'elementor';
		$created = 0;
		$updated = 0;
		$skipped = 0;
		$ids     = array();

		foreach ( self::pages() as $p ) {
			$existing = get_page_by_path( $p['slug'], OBJECT, 'page' );
			// WordPress creates a draft "Privacy Policy" page on install; drafts are always safe to replace.
			if ( $existing && ! $replace && 'publish' === $existing->post_status ) {
				$ids[ $p['slug'] ] = $existing->ID;
				++$skipped;
				continue;
			}
			$postarr = array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $p['title'],
				'post_name'    => $p['slug'],
				'post_excerpt' => $p['excerpt'] ?? '',
				'post_content' => $p['content'] ?? '',
			);
			$is_layout = ! empty( $p['elements'] );
			if ( $is_layout && 'wpbakery' === $builder ) {
				$postarr['post_content'] = self::wpbakery_content( $p['elements'] );
			}
			if ( $existing ) {
				$postarr['ID'] = $existing->ID;
				$id            = wp_update_post( wp_slash( $postarr ), true );
				++$updated;
			} else {
				$id = wp_insert_post( wp_slash( $postarr ), true );
				++$created;
			}
			if ( is_wp_error( $id ) ) {
				continue;
			}
			$ids[ $p['slug'] ] = $id;
			if ( $is_layout ) {
				'wpbakery' === $builder ? self::mark_wpbakery( $id ) : self::save_elementor( $id, $p['elements'] );
			}
		}

		if ( $reading && isset( $ids['home'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $ids['home'] );
			if ( isset( $ids['blog'] ) ) {
				update_option( 'page_for_posts', $ids['blog'] );
			}
		}
		if ( $menus ) {
			self::menus();
		}
		if ( 'elementor' === $builder ) {
			// Let the theme's design system style everything, and refresh Elementor's generated CSS.
			update_option( 'elementor_disable_color_schemes', 'yes' );
			update_option( 'elementor_disable_typography_schemes', 'yes' );
			if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
				\Elementor\Plugin::$instance->files_manager->clear_cache();
			}
		}
		flush_rewrite_rules();

		/* translators: 1: builder, 2: created, 3: updated, 4: skipped */
		return sprintf( __( 'Import finished for %1$s: %2$d pages created, %3$d replaced, %4$d left as they were.', 'descasio-elements' ), 'wpbakery' === $builder ? 'WPBakery' : 'Elementor', $created, $updated, $skipped );
	}

	/* ---------------- Elementor ---------------- */

	private static function eid(): string {
		return substr( md5( wp_generate_uuid4() ), 0, 7 );
	}

	/** Converts canonical settings into Elementor's stored format. */
	private static function elementor_settings( string $slug, array $settings ): array {
		$el  = Descasio_Registry::get( $slug );
		$out = array();
		foreach ( $el['fields'] as $f ) {
			if ( array_key_exists( $f['key'], $settings ) ) {
				$out[ $f['key'] ] = self::elementor_value( $f, $settings[ $f['key'] ] );
			}
		}
		return $out;
	}

	private static function elementor_value( array $f, $v ) {
		switch ( $f['type'] ) {
			case 'image':
				return array( 'id' => '', 'url' => Descasio_Registry::media( $v ) );
			case 'gallery':
				return array(); // Empty means "use the bundled images" (see Descasio_Registry::normalise()).
			case 'switch':
				return $v ? 'yes' : '';
			case 'lines':
				return is_array( $v ) ? implode( "\n", $v ) : (string) $v;
			case 'repeater':
				$rows = array();
				foreach ( (array) $v as $row ) {
					$item = array( '_id' => self::eid() );
					foreach ( $f['fields'] as $sub ) {
						if ( array_key_exists( $sub['key'], $row ) ) {
							$item[ $sub['key'] ] = self::elementor_value( $sub, $row[ $sub['key'] ] );
						}
					}
					$rows[] = $item;
				}
				return $rows;
			default:
				return $v;
		}
	}

	private static function save_elementor( int $id, array $elements ): void {
		$containers = class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->experiments )
			? \Elementor\Plugin::$instance->experiments->is_feature_active( 'container' )
			: true;
		$zero       = array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true );
		$data       = array();
		foreach ( $elements as $e ) {
			$widget = array(
				'id'         => self::eid(),
				'elType'     => 'widget',
				'widgetType' => 'descasio-' . str_replace( '_', '-', $e['type'] ),
				'settings'   => self::elementor_settings( $e['type'], (array) $e['settings'] ),
				'elements'   => array(),
			);
			if ( $containers ) {
				$data[] = array(
					'id'       => self::eid(),
					'elType'   => 'container',
					'settings' => array(
						'content_width' => 'full',
						'padding'       => $zero,
						'flex_gap'      => array( 'unit' => 'px', 'size' => 0, 'column' => '0', 'row' => '0', 'isLinked' => true ),
						'css_classes'   => 'de-con',
					),
					'elements' => array( $widget ),
					'isInner'  => false,
				);
			} else {
				$data[] = array(
					'id'       => self::eid(),
					'elType'   => 'section',
					'settings' => array( 'layout' => 'full_width', 'gap' => 'no', 'css_classes' => 'de-section', 'padding' => $zero ),
					'elements' => array(
						array(
							'id'       => self::eid(),
							'elType'   => 'column',
							'settings' => array( '_column_size' => 100 ),
							'elements' => array( $widget ),
							'isInner'  => false,
						),
					),
					'isInner'  => false,
				);
			}
		}
		update_post_meta( $id, '_elementor_edit_mode', 'builder' );
		update_post_meta( $id, '_elementor_template_type', 'wp-page' );
		update_post_meta( $id, '_elementor_version', defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.0.0' );
		update_post_meta( $id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
		update_post_meta( $id, '_wp_page_template', 'default' );
		delete_post_meta( $id, '_elementor_css' );
	}

	/* ---------------- WPBakery ---------------- */

	private static function wpbakery_content( array $elements ): string {
		$out = '';
		foreach ( $elements as $e ) {
			$out .= '[vc_row el_class="de-row"][vc_column]' . self::shortcode( $e['type'], (array) $e['settings'] ) . '[/vc_column][/vc_row]';
		}
		return $out;
	}

	/** Builds a [descasio_*] shortcode with values encoded the way WPBakery stores them. */
	public static function shortcode( string $slug, array $settings ): string {
		$el    = Descasio_Registry::get( $slug );
		$attrs = '';
		foreach ( $el['fields'] as $f ) {
			if ( ! array_key_exists( $f['key'], $settings ) ) {
				continue;
			}
			$attrs .= ' ' . $f['key'] . '="' . self::wpb_value( $f, $settings[ $f['key'] ] ) . '"';
		}
		return '[descasio_' . $slug . $attrs . ']';
	}

	private static function wpb_value( array $f, $v ): string {
		switch ( $f['type'] ) {
			case 'textarea':
				return Descasio_Registry::to_safe( (string) $v );
			case 'lines':
				return Descasio_Registry::to_safe( is_array( $v ) ? implode( "\n", $v ) : (string) $v );
			case 'switch':
				return $v ? 'yes' : '';
			case 'gallery':
				return implode( ',', (array) $v ); // Asset paths are resolved at render time.
			case 'repeater':
				return rawurlencode( wp_json_encode( array_values( (array) $v ) ) );
			default:
				// WPBakery stores straight double quotes as double backticks; square brackets would end the shortcode.
				return str_replace( array( '"', '[', ']' ), array( '``', '&#91;', '&#93;' ), (string) $v );
		}
	}

	private static function mark_wpbakery( int $id ): void {
		update_post_meta( $id, '_wpb_vc_js_status', 'true' );
		delete_post_meta( $id, '_elementor_edit_mode' );
		delete_post_meta( $id, '_elementor_data' );
	}

	/* ---------------- Menus ---------------- */

	private static function menus(): void {
		$locations = get_nav_menu_locations();
		if ( empty( $locations['primary'] ) ) {
			$menu_id = self::create_menu( __( 'Main navigation', 'descasio-elements' ), descasio_default_nav() );
			if ( $menu_id ) {
				$locations['primary'] = $menu_id;
			}
		}
		$titles = array( 'footer-solutions' => 'Solutions', 'footer-company' => 'Company', 'footer-resources' => 'Resources' );
		foreach ( descasio_footer_columns() as $i => list( $title, $links ) ) {
			$location = array_keys( $titles )[ $i ];
			if ( ! empty( $locations[ $location ] ) ) {
				continue;
			}
			$tree    = array_map( fn( $l ) => array( 'label' => $l[0], 'url' => $l[1], 'description' => '', 'icon' => '', 'children' => array() ), $links );
			$menu_id = self::create_menu( $titles[ $location ], $tree ); // The menu name is the footer column heading.
			if ( $menu_id ) {
				$locations[ $location ] = $menu_id;
			}
		}
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	private static function create_menu( string $name, array $tree ): int {
		$existing = wp_get_nav_menu_object( $name );
		if ( $existing ) {
			return (int) $existing->term_id;
		}
		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) ) {
			return 0;
		}
		self::add_items( $menu_id, $tree, 0 );
		return (int) $menu_id;
	}

	private static function add_items( int $menu_id, array $nodes, int $parent ): void {
		foreach ( $nodes as $n ) {
			$item_id = wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'       => $n['label'],
					'menu-item-url'         => $n['url'],
					'menu-item-description' => $n['description'],
					'menu-item-parent-id'   => $parent,
					'menu-item-type'        => 'custom',
					'menu-item-status'      => 'publish',
				)
			);
			if ( is_wp_error( $item_id ) ) {
				continue;
			}
			if ( $n['icon'] ) {
				update_post_meta( $item_id, '_descasio_icon', $n['icon'] );
			}
			if ( $n['children'] ) {
				self::add_items( $menu_id, $n['children'], (int) $item_id );
			}
		}
	}
}
