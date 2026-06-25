<?php
/**
 * Contact form AJAX handler + WPML string registration
 *
 * @package SteelPlast
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ── Register WPML strings ────────────────────────────────────────

add_action( 'after_setup_theme', 'steelplast_register_contact_strings' );
function steelplast_register_contact_strings() {
    if ( ! function_exists( 'icl_register_string' ) ) return;

    $ctx = 'steelplast/contacts/hero';
    icl_register_string( $ctx, 'contact_hero_title', 'Still have questions?' );
    icl_register_string( $ctx, 'contact_hero_desc',  'Leave your request and we will contact you within 2 hours.' );

    $ctx = 'steelplast/contacts/form';
    icl_register_string( $ctx, 'contact_form_aria',        'Contact form' );
    icl_register_string( $ctx, 'field_name_placeholder',   'Your name' );
    icl_register_string( $ctx, 'field_email_placeholder',  'E-mail' );
    icl_register_string( $ctx, 'field_or_label',           'or' );
    icl_register_string( $ctx, 'field_comment_placeholder','Your message (optional)' );
    icl_register_string( $ctx, 'submit_label',             'Send request' );
    icl_register_string( $ctx, 'success_message',          'Thank you! We will contact you soon.' );
    icl_register_string( $ctx, 'err_name_required',        'Please enter your name' );
    icl_register_string( $ctx, 'err_email_or_phone',       'Please enter email or phone' );
    icl_register_string( $ctx, 'err_email_invalid',        'Invalid email address' );
    icl_register_string( $ctx, 'err_phone_invalid',        'Enter full phone number' );
    icl_register_string( $ctx, 'err_server',               'Something went wrong. Please try again.' );
}

// ── Nonce refresh endpoint (for cached pages) ─────────────────────

add_action( 'wp_ajax_sp_contact_nonce',        'steelplast_contact_nonce' );
add_action( 'wp_ajax_nopriv_sp_contact_nonce', 'steelplast_contact_nonce' );

function steelplast_contact_nonce() {
    wp_send_json_success( array( 'nonce' => wp_create_nonce( 'sp_contact_form' ) ) );
}

// ── AJAX handler ─────────────────────────────────────────────────

add_action( 'wp_ajax_sp_contact_submit',        'steelplast_contact_submit' );
add_action( 'wp_ajax_nopriv_sp_contact_submit', 'steelplast_contact_submit' );

function steelplast_contact_submit() {
    // Nonce check
    if ( empty( $_POST['sp_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sp_contact_nonce'] ) ), 'sp_contact_form' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ), 403 );
    }

    // Rate limit: 1 request per IP per 60 seconds via transient
    $ip_key = 'sp_contact_' . md5( sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) ) );
    if ( get_transient( $ip_key ) ) {
        wp_send_json_error( array( 'message' => 'Too many requests. Please wait a moment.' ), 429 );
    }

    // Sanitize
    $name    = sanitize_text_field( wp_unslash( $_POST['sp_name']    ?? '' ) );
    $email   = sanitize_email( wp_unslash( $_POST['sp_email']   ?? '' ) );
    $phone   = sanitize_text_field( wp_unslash( $_POST['sp_phone']   ?? '' ) );
    $comment = sanitize_textarea_field( wp_unslash( $_POST['sp_comment'] ?? '' ) );

    // Server-side validation
    if ( empty( $name ) ) {
        wp_send_json_error( array( 'message' => 'Name is required.' ), 422 );
    }

    $has_email = ! empty( $email ) && is_email( $email );
    // E.164: 7–15 digits after stripping non-digits
    $phone_digits = preg_replace( '/\D/', '', $phone );
    $has_phone    = ! empty( $phone ) && strlen( $phone_digits ) >= 7 && strlen( $phone_digits ) <= 15;

    if ( ! $has_email && ! $has_phone ) {
        wp_send_json_error( array( 'message' => 'Email or phone is required.' ), 422 );
    }

    // Compose email — use Customizer setting, fall back to admin email
    $to      = steelplast_mod( 'contact_form_email', get_option( 'admin_email' ) );
    if ( ! is_email( $to ) ) {
        $to = get_option( 'admin_email' );
    }
    $subject = sprintf( '[SteelPlast] New contact request from %s', $name );
    $body    = "Name: {$name}\n";
    if ( $has_email ) $body .= "Email: {$email}\n";
    if ( $has_phone ) $body .= "Phone: {$phone}\n";
    if ( ! empty( $comment ) ) $body .= "\nMessage:\n{$comment}\n";
    $body   .= "\n---\nSent from: " . home_url();

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );
    if ( $has_email ) {
        $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
    }
    $cc = steelplast_mod( 'contact_form_email_cc', '' );
    if ( $cc && is_email( $cc ) ) {
        $headers[] = 'Cc: ' . $cc;
    }

    // Capture wp_mail errors for debugging
    $mail_error_message = '';
    $mail_error_handler = function( WP_Error $error ) use ( &$mail_error_message ) {
        $mail_error_message = $error->get_error_message();
    };
    add_action( 'wp_mail_failed', $mail_error_handler );

    $sent = wp_mail( $to, $subject, $body, $headers );

    remove_action( 'wp_mail_failed', $mail_error_handler );

    if ( ! $sent ) {
        $debug = WP_DEBUG ? ' (' . $mail_error_message . ')' : '';
        wp_send_json_error( array( 'message' => 'Failed to send email. Please try again later.' . $debug ), 500 );
    }

    // Set rate limit transient (60 seconds)
    set_transient( $ip_key, 1, 60 );

    wp_send_json_success();
}
