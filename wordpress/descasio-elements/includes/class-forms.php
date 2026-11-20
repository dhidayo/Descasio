<?php
/**
 * Contact form and AI Readiness Assessment: AJAX handlers, the private Leads inbox and email notifications.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

class Descasio_Forms {

	const CPT = 'descasio_lead';

	const TOPICS = array(
		'general'     => 'General Inquiry',
		'dip'         => 'Decision Intelligence Platform (DIP)',
		'cloud'       => 'Cloud Services',
		'ai-advisory' => 'AI Advisory',
		'plugiq'      => 'PlugIQ Demo',
		'partnership' => 'Partnership',
	);

	public static function init(): void {
		add_action( 'init', array( __CLASS__, 'register_cpt' ) );
		foreach ( array( 'contact', 'assessment' ) as $form ) {
			add_action( "wp_ajax_descasio_{$form}", array( __CLASS__, "handle_{$form}" ) );
			add_action( "wp_ajax_nopriv_descasio_{$form}", array( __CLASS__, "handle_{$form}" ) );
		}
		add_filter( 'manage_' . self::CPT . '_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_' . self::CPT . '_posts_custom_column', array( __CLASS__, 'column' ), 10, 2 );
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box' ) );
	}

	public static function activate(): void {
		self::register_cpt();
		flush_rewrite_rules();
	}

	public static function register_cpt(): void {
		register_post_type(
			self::CPT,
			array(
				'labels'          => array(
					'name'          => __( 'Leads', 'descasio-elements' ),
					'singular_name' => __( 'Lead', 'descasio-elements' ),
					'menu_name'     => __( 'Leads', 'descasio-elements' ),
					'all_items'     => __( 'All leads', 'descasio-elements' ),
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_icon'       => 'dashicons-email-alt',
				'menu_position'   => 26,
				'supports'        => array( 'title' ),
				'capability_type' => 'post',
				'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'    => true,
			)
		);
	}

	/** Shared checks: nonce, honeypot and a gentle per-visitor rate limit. */
	private static function guard(): void {
		if ( ! check_ajax_referer( 'descasio_forms', 'nonce', false ) ) {
			wp_send_json_error( array( 'message' => __( 'Your session expired. Please refresh the page and try again.', 'descasio-elements' ) ), 403 );
		}
		if ( ! empty( $_POST['website'] ) ) { // Honeypot: real visitors never fill this.
			wp_send_json_success( array( 'message' => __( "Thanks. We'll be in touch shortly.", 'descasio-elements' ) ) );
		}
		$ip  = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );
		$key = 'descasio_rl_' . md5( $ip );
		$n   = (int) get_transient( $key );
		if ( $n >= 8 ) {
			wp_send_json_error( array( 'message' => __( 'Too many submissions. Please try again in a few minutes.', 'descasio-elements' ) ), 429 );
		}
		set_transient( $key, $n + 1, 10 * MINUTE_IN_SECONDS );
	}

	private static function field( string $key, int $max = 200 ): string {
		$v = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification -- checked in guard().
		return mb_substr( trim( $v ), 0, $max );
	}

	/** Returns field errors for the person's details shared by both forms. */
	private static function person( array &$errors ): array {
		$p = array(
			'first_name' => self::field( 'first_name', 100 ),
			'last_name'  => self::field( 'last_name', 100 ),
			'email'      => sanitize_email( self::field( 'email', 254 ) ),
			'company'    => self::field( 'company', 200 ),
		);
		if ( '' === $p['first_name'] ) {
			$errors['first_name'] = __( 'Enter your first name', 'descasio-elements' );
		}
		if ( '' === $p['last_name'] ) {
			$errors['last_name'] = __( 'Enter your last name', 'descasio-elements' );
		}
		if ( ! is_email( $p['email'] ) ) {
			$errors['email'] = __( 'Enter a valid work email', 'descasio-elements' );
		}
		if ( '' === $p['company'] ) {
			$errors['company'] = __( 'Enter your company', 'descasio-elements' );
		}
		return $p;
	}

	public static function handle_contact(): void {
		self::guard();
		$errors  = array();
		$p       = self::person( $errors );
		$topic   = self::field( 'topic', 40 );
		$message = isset( $_POST['message'] ) ? mb_substr( trim( sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) ), 0, 5000 ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
		if ( ! isset( self::TOPICS[ $topic ] ) ) {
			$errors['topic'] = __( 'Choose a topic', 'descasio-elements' );
		}
		if ( mb_strlen( $message ) < 10 ) {
			$errors['message'] = __( 'Tell us a little more (at least 10 characters)', 'descasio-elements' );
		}
		if ( $errors ) {
			wp_send_json_error( array( 'message' => __( 'Please check the highlighted fields.', 'descasio-elements' ), 'errors' => $errors ), 422 );
		}

		$meta = $p + array( 'type' => 'contact', 'topic' => self::TOPICS[ $topic ], 'message' => $message, 'page' => esc_url_raw( wp_get_referer() ) );
		self::save( sprintf( '%s %s (%s)', $p['first_name'], $p['last_name'], $p['company'] ), $meta );
		self::notify( sprintf( __( 'New enquiry: %1$s from %2$s', 'descasio-elements' ), self::TOPICS[ $topic ], $p['company'] ), $meta );

		wp_send_json_success( array( 'message' => __( "Thanks. Your request is with our team, and we'll reply within 4 business hours.", 'descasio-elements' ) ) );
	}

	public static function handle_assessment(): void {
		self::guard();
		$errors  = array();
		$p       = self::person( $errors );
		$answers = array_map( 'intval', explode( ',', self::field( 'answers', 60 ) ) );
		$data    = self::assessment_data();
		if ( count( $answers ) !== count( $data['questions'] ) || min( $answers ) < 0 || max( $answers ) > 3 ) {
			$errors['answers'] = __( 'Please answer every question.', 'descasio-elements' );
		}
		$size = self::field( 'company_size', 20 );
		if ( $size && ! in_array( $size, array( '1-50', '51-200', '201-1000', '1000+' ), true ) ) {
			$size = '';
		}
		if ( $errors ) {
			wp_send_json_error( array( 'message' => __( 'Please check the highlighted fields.', 'descasio-elements' ), 'errors' => $errors ), 422 );
		}

		$score = self::score( $answers, $data );
		$meta  = $p + array(
			'type'         => 'assessment',
			'job_title'    => self::field( 'job_title', 150 ),
			'company_size' => $size,
			'answers'      => implode( ',', $answers ),
			'total_score'  => $score['total'],
			'dim_scores'   => implode( ' / ', $score['dims'] ),
		);
		self::save( sprintf( '%s %s (%s): %d/100', $p['first_name'], $p['last_name'], $p['company'], $score['total'] ), $meta );
		self::notify( sprintf( __( 'AI Readiness result: %1$s scored %2$d/100', 'descasio-elements' ), $p['company'], $score['total'] ), $meta );

		wp_send_json_success( array( 'score' => $score ) );
	}

	public static function assessment_data(): array {
		static $data = null;
		if ( null === $data ) {
			$data = json_decode( (string) file_get_contents( DESCASIO_EL_DIR . 'data/assessment.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local file.
		}
		return $data;
	}

	/** Same scoring as the original site: each dimension out of 25, total out of 100. */
	public static function score( array $answers, array $data ): array {
		$raw = array( 0, 0, 0, 0 );
		foreach ( $answers as $i => $opt ) {
			$q                   = $data['questions'][ $i ];
			$raw[ $q['dim'] ]   += $q['options'][ $opt ]['score'];
		}
		$dims  = array_map( fn( $s ) => (int) round( $s / 12 * 25 ), $raw );
		$total = (int) round( array_sum( array_map( fn( $s ) => $s / 12 * 25, $raw ) ) );
		return array( 'total' => $total, 'dims' => $dims );
	}

	private static function save( string $title, array $meta ): void {
		$id = wp_insert_post(
			array(
				'post_type'   => self::CPT,
				'post_status' => 'private',
				'post_title'  => $title,
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			foreach ( $meta as $k => $v ) {
				update_post_meta( $id, '_lead_' . $k, $v );
			}
		}
	}

	private static function notify( string $subject, array $meta ): void {
		$to = Descasio_Settings::get( 'notify_email' );
		if ( ! $to ) {
			return;
		}
		$lines = array();
		foreach ( $meta as $k => $v ) {
			if ( '' !== (string) $v ) {
				$lines[] = ucwords( str_replace( '_', ' ', $k ) ) . ': ' . $v;
			}
		}
		$lines[] = '';
		$lines[] = __( 'View all leads:', 'descasio-elements' ) . ' ' . admin_url( 'edit.php?post_type=' . self::CPT );
		wp_mail( $to, '[' . get_bloginfo( 'name' ) . '] ' . $subject, implode( "\n", $lines ), array( 'Reply-To: ' . $meta['first_name'] . ' ' . $meta['last_name'] . ' <' . $meta['email'] . '>' ) );
	}

	public static function columns( array $cols ): array {
		return array(
			'cb'           => $cols['cb'],
			'title'        => __( 'Lead', 'descasio-elements' ),
			'lead_type'    => __( 'Source', 'descasio-elements' ),
			'lead_email'   => __( 'Email', 'descasio-elements' ),
			'lead_summary' => __( 'Topic or score', 'descasio-elements' ),
			'date'         => $cols['date'],
		);
	}

	public static function column( string $col, int $id ): void {
		$m = fn( $k ) => (string) get_post_meta( $id, '_lead_' . $k, true );
		if ( 'lead_type' === $col ) {
			echo esc_html( 'assessment' === $m( 'type' ) ? __( 'AI Readiness Assessment', 'descasio-elements' ) : __( 'Contact form', 'descasio-elements' ) );
		} elseif ( 'lead_email' === $col ) {
			printf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $m( 'email' ) ) );
		} elseif ( 'lead_summary' === $col ) {
			echo esc_html( 'assessment' === $m( 'type' ) ? $m( 'total_score' ) . '/100' : $m( 'topic' ) );
		}
	}

	public static function meta_box(): void {
		add_meta_box(
			'descasio_lead_details',
			__( 'Lead details', 'descasio-elements' ),
			function ( $post ) {
				echo '<table class="widefat striped"><tbody>';
				foreach ( get_post_meta( $post->ID ) as $k => $v ) {
					if ( str_starts_with( $k, '_lead_' ) ) {
						printf( '<tr><th style="width:180px">%s</th><td style="white-space:pre-wrap">%s</td></tr>', esc_html( ucwords( str_replace( '_', ' ', substr( $k, 6 ) ) ) ), esc_html( $v[0] ) );
					}
				}
				echo '</tbody></table>';
			},
			self::CPT,
			'normal',
			'high'
		);
	}

	/** Form field markup shared by both forms. Labels sit above inputs; errors appear below. */
	public static function input( string $name, string $label, bool $required = true, string $type = 'text', string $autocomplete = '' ): string {
		return '<div class="flex flex-col gap-2"><label for="de-' . esc_attr( $name ) . '" class="text-[15px] font-semibold text-fg">' . esc_html( $label ) . ( $required ? '<span class="text-accent-strong dark:text-accent"> *</span>' : '' ) . '</label>'
			. '<input id="de-' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" type="' . esc_attr( $type ) . '"' . ( $required ? ' required' : '' ) . ( $autocomplete ? ' autocomplete="' . esc_attr( $autocomplete ) . '"' : '' ) . ' class="' . self::control_class() . '">'
			. '<p class="de-error hidden text-sm font-semibold text-accent-strong dark:text-accent" data-error-for="' . esc_attr( $name ) . '"></p></div>';
	}

	public static function control_class(): string {
		return 'w-full rounded-[14px] border border-line bg-[var(--bg-elevated)] px-4 py-3 text-[16px] text-fg transition-[border-color,box-shadow] focus:border-accent focus:outline-none focus:ring-4 focus:ring-accent-soft aria-[invalid=true]:border-accent-strong';
	}

	public static function honeypot(): string {
		return '<div aria-hidden="true" class="absolute -left-[9999px] h-0 w-0 overflow-hidden"><label for="de-website">Website</label><input id="de-website" name="website" tabindex="-1" autocomplete="off"></div>';
	}

	public static function submit( string $label ): string {
		return '<button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-accent-strong px-7 py-3.5 text-[15px] font-semibold text-white transition-[transform,background-color,opacity] duration-300 hover:-translate-y-0.5 hover:bg-[var(--accent-strong-hover)] active:scale-[0.98] disabled:translate-y-0 disabled:opacity-70">'
			. '<span aria-hidden="true" class="de-spinner hidden size-4 animate-spin rounded-full border-2 border-white/40 border-t-white"></span><span class="de-submit-label">' . esc_html( $label ) . '</span></button>';
	}
}
