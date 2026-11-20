<?php
/**
 * Navigation data: WordPress menus with an icon field per item, and defaults that mirror
 * the current site so the theme looks right before any menu is set up.
 *
 * Menu structure for a mega menu (like "Solutions"):
 *   Solutions                 (top level)
 *     Infrastructure          (column title, link "#")
 *       Sovereign AI Cloud    (link, with description and icon)
 * A top-level item whose children have their own children becomes a mega menu.
 *
 * @package Descasio
 */

defined( 'ABSPATH' ) || exit;

/** Icon field on each menu item (Appearance > Menus). */
add_action(
	'wp_nav_menu_item_custom_fields',
	function ( $item_id ) {
		$icon = get_post_meta( $item_id, '_descasio_icon', true );
		?>
		<p class="field-descasio-icon description description-wide">
			<label for="edit-menu-item-descasio-icon-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Icon (Phosphor name, e.g. chart-line-up)', 'descasio' ); ?><br>
				<input type="text" id="edit-menu-item-descasio-icon-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="descasio_menu_icon[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $icon ); ?>">
			</label>
		</p>
		<?php
	}
);

add_action(
	'wp_update_nav_menu_item',
	function ( $menu_id, $item_id ) {
		if ( ! current_user_can( 'edit_theme_options' ) || ! isset( $_POST['descasio_menu_icon'][ $item_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification -- core verifies the menu nonce.
			return;
		}
		update_post_meta( $item_id, '_descasio_icon', sanitize_html_class( wp_unslash( $_POST['descasio_menu_icon'][ $item_id ] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification
	},
	10,
	2
);

/** Builds a nested array from an assigned menu location, or returns null when none is assigned. */
function descasio_menu_tree( string $location ): ?array {
	$locations = get_nav_menu_locations();
	if ( empty( $locations[ $location ] ) ) {
		return null;
	}
	$items = wp_get_nav_menu_items( $locations[ $location ] );
	if ( ! $items ) {
		return null;
	}
	_wp_menu_item_classes_by_context( $items );
	$by_parent = array();
	foreach ( $items as $item ) {
		$by_parent[ (int) $item->menu_item_parent ][] = $item;
	}
	$build = function ( int $parent ) use ( &$build, $by_parent ): array {
		$nodes = array();
		foreach ( $by_parent[ $parent ] ?? array() as $item ) {
			$nodes[] = array(
				'label'       => $item->title,
				'url'         => $item->url,
				'description' => trim( (string) $item->description ),
				'icon'        => (string) get_post_meta( $item->ID, '_descasio_icon', true ),
				'current'     => ! empty( $item->current ) || ! empty( $item->current_item_ancestor ),
				'children'    => $build( (int) $item->ID ),
			);
		}
		return $nodes;
	};
	return $build( 0 );
}

/** Default navigation, matching the current descasio.io structure. */
function descasio_default_nav(): array {
	$l = fn( $label, $url, $desc = '', $icon = '' ) => array( 'label' => $label, 'url' => home_url( $url ), 'description' => $desc, 'icon' => $icon, 'children' => array(), 'current' => false );
	$g = fn( $label, $children ) => array( 'label' => $label, 'url' => '#', 'description' => '', 'icon' => '', 'children' => $children, 'current' => false );
	return array(
		$g(
			'Solutions',
			array(
				$g(
					'Infrastructure',
					array(
						$l( 'Sovereign AI Cloud', '/sovereign-cloud/', 'In-country, AI-ready compute', 'cloud-arrow-up' ),
						$l( 'Cloud Migration', '/cloud-migration/', 'Move to cloud with zero disruption', 'arrows-clockwise' ),
						$l( 'Cybersecurity & Compliance', '/cybersecurity/', 'Defence in depth, NDPR ready', 'shield-check' ),
						$l( 'Backup & Disaster Recovery', '/backup/', 'Resilience from day one', 'clock-counter-clockwise' ),
					)
				),
				$g(
					'Platforms',
					array(
						$l( 'Decision Intelligence Platform', '/decision-intelligence-platform/', 'Decisions you can trust', 'chart-line-up' ),
						$l( 'PlugIQ Workflow Automation', '/plugiq/', 'Approvals live in days', 'flow-arrow' ),
					)
				),
				$g(
					'Advisory',
					array(
						$l( 'AI Transformation Advisory', '/ai-advisory/', 'From strategy to scale', 'brain' ),
						$l( 'AI Readiness Assessment', '/ai-readiness/', 'Free 5-minute self-assessment', 'exam' ),
						$l( 'AI Competency', '/ai-competency/', 'AWS-validated AI delivery', 'trophy' ),
						$l( 'Cloud Cost Optimisation', '/cost-optimization/', 'Cut cloud spend by 25-40%', 'currency-circle-dollar' ),
					)
				),
			)
		),
		$l( 'Decision Intelligence', '/decision-intelligence-platform/' ),
		$g(
			'Resources',
			array(
				$l( 'Blog', '/blog/', 'Insights on cloud, AI, and data', 'article' ),
				$l( 'Whitepapers & Guides', '/whitepapers/', 'In-depth guides, free to download', 'book-open-text' ),
				$l( 'Case Studies', '/case-studies/', 'Real outcomes for real enterprises', 'briefcase' ),
				$l( 'Events', '/events/', 'The Trust Layer and more', 'calendar-star' ),
				$l( 'Press', '/press/', 'News and media coverage', 'megaphone' ),
			)
		),
		$g(
			'Company',
			array(
				$l( 'About Us', '/about/', '15 years of building infrastructure', 'buildings' ),
				$l( 'Partners', '/partners/', 'AWS, Google, and security alliances', 'handshake' ),
				$l( 'Careers', '/careers/', 'Join our team of 70+ specialists', 'users-three' ),
				$l( 'Contact', '/contact/', 'Talk to our team', 'chats-circle' ),
			)
		),
	);
}

function descasio_nav(): array {
	return descasio_menu_tree( 'primary' ) ?? descasio_default_nav();
}

/** Footer columns: [title, links[]] from the three footer menu locations, with defaults. */
function descasio_footer_columns(): array {
	$defaults = array(
		'footer-solutions' => array( 'Solutions', array( array( 'Decision Intelligence Platform', '/decision-intelligence-platform/' ), array( 'Sovereign AI Cloud', '/sovereign-cloud/' ), array( 'Cloud Migration', '/cloud-migration/' ), array( 'Cybersecurity & Compliance', '/cybersecurity/' ), array( 'Backup & Disaster Recovery', '/backup/' ), array( 'PlugIQ', '/plugiq/' ), array( 'AI Advisory', '/ai-advisory/' ), array( 'Cloud Cost Optimisation', '/cost-optimization/' ), array( 'AI Competency', '/ai-competency/' ) ) ),
		'footer-company'   => array( 'Company', array( array( 'About Us', '/about/' ), array( 'Partners', '/partners/' ), array( 'Careers', '/careers/' ), array( 'Press', '/press/' ), array( 'Contact', '/contact/' ) ) ),
		'footer-resources' => array( 'Resources', array( array( 'Blog', '/blog/' ), array( 'Case Studies', '/case-studies/' ), array( 'Whitepapers & Guides', '/whitepapers/' ), array( 'Events', '/events/' ), array( 'AI Readiness Assessment', '/ai-readiness/' ), array( 'Privacy Policy', '/privacy-policy/' ) ) ),
	);
	$columns   = array();
	$locations = get_nav_menu_locations();
	foreach ( $defaults as $location => list( $title, $links ) ) {
		$tree = descasio_menu_tree( $location );
		if ( $tree ) {
			$menu      = wp_get_nav_menu_object( $locations[ $location ] );
			$columns[] = array( $menu ? $menu->name : $title, array_map( fn( $n ) => array( $n['label'], $n['url'] ), $tree ) );
		} else {
			$columns[] = array( $title, array_map( fn( $l ) => array( $l[0], home_url( $l[1] ) ), $links ) );
		}
	}
	return $columns;
}
