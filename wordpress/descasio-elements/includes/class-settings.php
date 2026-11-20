<?php
/**
 * Descasio > Settings: choose the page builder and where lead notifications go.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

class Descasio_Settings {

	const OPTION = 'descasio_elements';

	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
	}

	public static function get( string $key ) {
		$opts = wp_parse_args(
			(array) get_option( self::OPTION, array() ),
			array(
				'builder'      => self::detect_builder(),
				'notify_email' => get_option( 'admin_email' ),
			)
		);
		return $opts[ $key ] ?? null;
	}

	/** Default builder: whichever is installed, Elementor first. */
	private static function detect_builder(): string {
		if ( did_action( 'elementor/loaded' ) || defined( 'ELEMENTOR_VERSION' ) ) {
			return 'elementor';
		}
		if ( defined( 'WPB_VC_VERSION' ) ) {
			return 'wpbakery';
		}
		return 'elementor';
	}

	public static function uses( string $builder ): bool {
		$choice = self::get( 'builder' );
		return 'both' === $choice || $builder === $choice;
	}

	public static function menu(): void {
		add_menu_page( __( 'Descasio', 'descasio-elements' ), __( 'Descasio', 'descasio-elements' ), 'manage_options', 'descasio', array( __CLASS__, 'page' ), 'dashicons-art', 59 );
		add_submenu_page( 'descasio', __( 'Settings', 'descasio-elements' ), __( 'Settings', 'descasio-elements' ), 'manage_options', 'descasio', array( __CLASS__, 'page' ) );
	}

	public static function register(): void {
		register_setting(
			'descasio_elements',
			self::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => function ( $in ) {
					$in = (array) $in;
					return array(
						'builder'      => in_array( $in['builder'] ?? '', array( 'elementor', 'wpbakery', 'both' ), true ) ? $in['builder'] : 'elementor',
						'notify_email' => sanitize_email( $in['notify_email'] ?? '' ),
					);
				},
			)
		);
	}

	public static function page(): void {
		$builder  = self::get( 'builder' );
		$has_el   = defined( 'ELEMENTOR_VERSION' );
		$has_wpb  = defined( 'WPB_VC_VERSION' );
		$installed = function ( bool $yes ) {
			return $yes ? '<span style="color:#1a7f37">' . esc_html__( 'Installed', 'descasio-elements' ) . '</span>' : '<span style="color:#b32d2e">' . esc_html__( 'Not installed', 'descasio-elements' ) . '</span>';
		};
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Descasio Elements', 'descasio-elements' ); ?></h1>
			<p><?php esc_html_e( 'Every section of the Descasio website is available as an element in your page builder, with the same design and motion as the live site.', 'descasio-elements' ); ?></p>
			<form method="post" action="options.php">
				<?php settings_fields( 'descasio_elements' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Page builder', 'descasio-elements' ); ?></th>
						<td>
							<fieldset>
								<label><input type="radio" name="<?php echo esc_attr( self::OPTION ); ?>[builder]" value="elementor" <?php checked( $builder, 'elementor' ); ?>> <strong>Elementor</strong> (<?php echo wp_kses_post( $installed( $has_el ) ); ?>)</label><br>
								<label><input type="radio" name="<?php echo esc_attr( self::OPTION ); ?>[builder]" value="wpbakery" <?php checked( $builder, 'wpbakery' ); ?>> <strong>WPBakery Page Builder</strong> (<?php echo wp_kses_post( $installed( $has_wpb ) ); ?>)</label><br>
								<label><input type="radio" name="<?php echo esc_attr( self::OPTION ); ?>[builder]" value="both" <?php checked( $builder, 'both' ); ?>> <?php esc_html_e( 'Both', 'descasio-elements' ); ?></label>
								<p class="description"><?php esc_html_e( 'The Descasio elements appear in the builder you choose, under a "Descasio" category. The page importer also builds pages for this builder.', 'descasio-elements' ); ?></p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="descasio-notify"><?php esc_html_e( 'Send new leads to', 'descasio-elements' ); ?></label></th>
						<td>
							<input id="descasio-notify" type="email" class="regular-text" name="<?php echo esc_attr( self::OPTION ); ?>[notify_email]" value="<?php echo esc_attr( self::get( 'notify_email' ) ); ?>">
							<p class="description"><?php esc_html_e( 'Contact form and AI Readiness Assessment submissions are saved under Leads and emailed here. Leave empty to save without emailing.', 'descasio-elements' ); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
			<hr>
			<h2><?php esc_html_e( 'Elements available', 'descasio-elements' ); ?></h2>
			<ul style="columns:3;max-width:900px">
				<?php foreach ( Descasio_Registry::all() as $slug => $el ) : ?>
					<li><?php echo esc_html( $el['title'] ); ?> <code style="font-size:11px">[descasio_<?php echo esc_html( $slug ); ?>]</code></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}
