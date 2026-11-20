<?php
/**
 * AI Readiness Assessment: 12 questions, a details step, then scored results. Leads go to the Leads inbox.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'AI Readiness Assessment', 'descasio-elements' ),
	'icon'   => 'eicon-checkbox',
	'fields' => array(
		de_f( 'cta_title', __( 'Results: closing headline', 'descasio-elements' ), 'text', 'Want a deeper analysis?' ),
		de_f( 'cta_text', __( 'Results: closing text', 'descasio-elements' ), 'textarea', "Book a 30-minute session with our AI advisory team. We'll walk through your results and identify the highest-impact starting point." ),
		de_f( 'cta_label', __( 'Results: button text', 'descasio-elements' ), 'text', 'Book a Strategy Session' ),
		de_f( 'cta_url', __( 'Results: button link', 'descasio-elements' ), 'url', 'https://calendly.com/hi-descasio' ),
	),
	'render' => function ( array $d ): string {
		$f    = 'Descasio_Forms';
		$data = $f::assessment_data();
		$gate = '<form novalidate class="relative mt-8 grid gap-5 sm:grid-cols-2">' . $f::honeypot()
			. $f::input( 'first_name', __( 'First name', 'descasio-elements' ), true, 'text', 'given-name' )
			. $f::input( 'last_name', __( 'Last name', 'descasio-elements' ), true, 'text', 'family-name' )
			. $f::input( 'email', __( 'Work email', 'descasio-elements' ), true, 'email', 'email' )
			. $f::input( 'company', __( 'Company', 'descasio-elements' ), true, 'text', 'organization' )
			. $f::input( 'job_title', __( 'Job title', 'descasio-elements' ), false, 'text', 'organization-title' )
			. '<div class="flex flex-col gap-2"><label for="de-company_size" class="text-[15px] font-semibold text-fg">' . esc_html__( 'Company size', 'descasio-elements' ) . '</label><select id="de-company_size" name="company_size" class="' . $f::control_class() . '"><option value="">' . esc_html__( 'Select...', 'descasio-elements' ) . '</option><option>1-50</option><option>51-200</option><option>201-1000</option><option>1000+</option></select></div>'
			. '<p role="alert" class="de-form-alert hidden text-sm font-semibold text-accent-strong sm:col-span-2 dark:text-accent"></p>'
			. '<div class="flex flex-wrap items-center gap-4 sm:col-span-2">' . $f::submit( __( 'See My Results', 'descasio-elements' ) ) . '<button type="button" data-de-back class="text-[15px] font-semibold text-muted hover:text-fg">' . esc_html__( 'Change my answers', 'descasio-elements' ) . '</button></div></form>';

		$config = array(
			'data'    => $data,
			'strings' => array(
				'question' => __( 'Question %1$d of %2$d', 'descasio-elements' ),
				'back'     => __( 'Back', 'descasio-elements' ),
				'next'     => __( 'Next', 'descasio-elements' ),
				'outOf'    => __( 'OUT OF 100', 'descasio-elements' ),
			),
		);
		return '<section class="mx-auto max-w-3xl px-4 pb-8"><div class="glass rounded-[28px] p-6 md:p-10" data-de-assessment data-config="' . esc_attr( wp_json_encode( $config ) ) . '">'
			. '<div data-step="quiz"><noscript><p class="text-muted">' . esc_html__( 'Please enable JavaScript to take the assessment.', 'descasio-elements' ) . '</p></noscript></div>'
			. '<div data-step="gate" hidden><p class="text-sm font-bold text-accent-strong dark:text-accent">' . esc_html__( 'Assessment complete', 'descasio-elements' ) . '</p><h2 class="mt-2 text-3xl font-extrabold tracking-tight text-fg">' . esc_html__( 'Your score:', 'descasio-elements' ) . ' <span class="text-accent-strong dark:text-accent" data-score-preview></span></h2>'
			. '<p class="mt-3 max-w-xl leading-relaxed text-muted">' . esc_html__( 'Enter your details to see your full results and personalised recommendations.', 'descasio-elements' ) . '</p>' . $gate . '</div>'
			. '<div data-step="results" hidden><div data-results></div><div class="mt-10 rounded-[var(--radius-card)] bg-accent-soft p-7"><h3 class="text-xl font-extrabold text-fg">' . de_e( $d['cta_title'] ) . '</h3><p class="mt-2 max-w-xl leading-relaxed text-muted">' . de_e( $d['cta_text'] ) . '</p>'
			. '<div class="mt-6 flex flex-wrap items-center gap-4">' . descasio_button( $d['cta_label'], $d['cta_url'] ) . '<button type="button" data-de-restart class="inline-flex items-center gap-2 font-semibold text-muted hover:text-fg">' . descasio_icon( 'arrow-counter-clockwise', 'bold' ) . ' ' . esc_html__( 'Retake', 'descasio-elements' ) . '</button></div></div></div>'
			. '</div></section>';
	},
);
