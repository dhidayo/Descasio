<?php
/**
 * Contact details card beside the enquiry form. Submissions go to Leads and are emailed to your team.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Contact Form', 'descasio-elements' ),
	'icon'   => 'eicon-form-horizontal',
	'fields' => array(
		de_f( 'card_title', __( 'Card headline', 'descasio-elements' ), 'text', 'How we can help.' ),
		de_f( 'card_text', __( 'Card text', 'descasio-elements' ), 'textarea', "Whether you're modernising infrastructure, automating operations, or planning an AI transformation, our team will help you identify the highest-impact starting point." ),
		de_f( 'note', __( 'Response time note', 'descasio-elements' ), 'textarea', 'Within 4 business hours. For urgent infrastructure issues, call us directly.' ),
		de_f( 'submit', __( 'Button text', 'descasio-elements' ), 'text', 'Submit Request' ),
		de_f( 'success_title', __( 'Success headline', 'descasio-elements' ), 'text', 'Request received' ),
	),
	'render' => function ( array $d ): string {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only preselection of the topic.
		$preset  = isset( $_GET['topic'] ) ? sanitize_key( wp_unslash( $_GET['topic'] ) ) : '';
		$email   = descasio_opt( 'email' );
		$phone   = descasio_opt( 'phone' );
		$details = array(
			array( 'envelope-simple', __( 'Email', 'descasio-elements' ), $email, 'mailto:' . $email ),
			array( 'phone', __( 'Phone', 'descasio-elements' ), $phone, 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ),
			array( 'map-pin', __( 'Office', 'descasio-elements' ), descasio_opt( 'address' ), '' ),
		);
		$list = '';
		foreach ( $details as list( $icon, $label, $value, $href ) ) {
			$body  = '<span class="grid size-11 shrink-0 place-items-center rounded-2xl bg-accent-soft text-[22px] text-accent-strong dark:text-accent">' . descasio_icon( $icon ) . '</span><span><span class="block text-sm text-muted">' . esc_html( $label ) . '</span><span class="block font-semibold text-fg">' . esc_html( $value ) . '</span></span>';
			$list .= '<li>' . ( $href ? '<a href="' . esc_url( $href ) . '" class="flex items-center gap-4 no-underline">' . $body . '</a>' : '<div class="flex items-center gap-4">' . $body . '</div>' ) . '</li>';
		}
		$options = '<option value="" disabled' . ( $preset ? '' : ' selected' ) . '>' . esc_html__( 'Select a topic', 'descasio-elements' ) . '</option>';
		foreach ( Descasio_Forms::TOPICS as $value => $label ) {
			$options .= '<option value="' . esc_attr( $value ) . '"' . selected( $preset, $value, false ) . '>' . esc_html( $label ) . '</option>';
		}
		$f = 'Descasio_Forms';
		return '<section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[0.8fr_1.2fr]">' . de_reveal_open() . '<div class="glass h-full rounded-[var(--radius-card)] p-8"><h2 class="text-2xl font-extrabold tracking-tight text-fg">' . de_e( $d['card_title'] ) . '</h2><p class="mt-3 leading-relaxed text-muted">' . de_e( $d['card_text'] ) . '</p>'
			. '<ul class="m-0 mt-8 list-none space-y-5 p-0">' . $list . '</ul>'
			. ( $d['note'] ? '<p class="mt-8 flex gap-3 rounded-[14px] border border-line p-4 text-[15px] leading-relaxed text-muted"><span class="mt-0.5 shrink-0 text-[20px] text-accent">' . descasio_icon( 'clock' ) . '</span><span><strong class="text-fg">' . esc_html__( 'Typical response time:', 'descasio-elements' ) . '</strong> ' . de_e( $d['note'] ) . '</span></p>' : '' ) . '</div></div>'
			. de_reveal_open( 0.08 ) . '<div class="glass rounded-[var(--radius-card)] p-8 md:p-10" data-de-form="contact">'
			. '<form novalidate class="relative grid gap-5 sm:grid-cols-2">' . $f::honeypot()
			. $f::input( 'first_name', __( 'First name', 'descasio-elements' ), true, 'text', 'given-name' )
			. $f::input( 'last_name', __( 'Last name', 'descasio-elements' ), true, 'text', 'family-name' )
			. $f::input( 'email', __( 'Work email', 'descasio-elements' ), true, 'email', 'email' )
			. $f::input( 'company', __( 'Company', 'descasio-elements' ), true, 'text', 'organization' )
			. '<div class="flex flex-col gap-2 sm:col-span-2"><label for="de-topic" class="text-[15px] font-semibold text-fg">' . esc_html__( 'Topic', 'descasio-elements' ) . '<span class="text-accent-strong dark:text-accent"> *</span></label><select id="de-topic" name="topic" required class="' . $f::control_class() . '">' . $options . '</select><p class="de-error hidden text-sm font-semibold text-accent-strong dark:text-accent" data-error-for="topic"></p></div>'
			. '<div class="flex flex-col gap-2 sm:col-span-2"><label for="de-message" class="text-[15px] font-semibold text-fg">' . esc_html__( 'Message', 'descasio-elements' ) . '<span class="text-accent-strong dark:text-accent"> *</span></label><textarea id="de-message" name="message" required class="' . $f::control_class() . ' min-h-36 resize-y"></textarea><p class="de-error hidden text-sm font-semibold text-accent-strong dark:text-accent" data-error-for="message"></p></div>'
			. '<p role="alert" class="de-form-alert hidden items-start gap-2 rounded-[14px] bg-accent-soft px-4 py-3 text-[15px] font-medium text-fg sm:col-span-2"></p>'
			. '<div class="sm:col-span-2">' . $f::submit( $d['submit'] ) . '</div></form>'
			. '<div role="status" class="de-form-success hidden flex-col items-start gap-4 py-10"><span class="block text-[44px] leading-none text-accent">' . descasio_icon( 'check-circle' ) . '</span><h2 class="text-2xl font-extrabold text-fg">' . de_e( $d['success_title'] ) . '</h2><p class="de-success-text max-w-md leading-relaxed text-muted"></p></div>'
			. '</div></div></section>';
	},
);
