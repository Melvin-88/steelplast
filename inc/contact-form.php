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
    icl_register_string( $ctx, 'contact_hero_desc',  'Send us a request, and we will get back to you.' );

    $ctx = 'steelplast/contacts/form';
    icl_register_string( $ctx, 'contact_form_aria',        'Contact form' );
    icl_register_string( $ctx, 'field_name_placeholder',   'Your name' );
    icl_register_string( $ctx, 'field_email_placeholder',  'Email' );
    icl_register_string( $ctx, 'field_phone_placeholder',  'Phone' );
    icl_register_string( $ctx, 'field_or_label',           'or' );
    icl_register_string( $ctx, 'field_comment_placeholder','Your message (optional)' );
    icl_register_string( $ctx, 'submit_label',             'Send request' );
    icl_register_string( $ctx, 'success_message',          'Thank you! We will get back to you shortly.' );
    icl_register_string( $ctx, 'err_name_required',        'Please enter your name' );
    icl_register_string( $ctx, 'err_email_or_phone',       'Please enter an email or phone number' );
    icl_register_string( $ctx, 'err_email_invalid',        'Invalid email address' );
    icl_register_string( $ctx, 'err_phone_invalid',        'Please enter a complete phone number' );
    icl_register_string( $ctx, 'err_rate_limit',           'Too many requests. Please wait a minute.' );
    icl_register_string( $ctx, 'err_send_failed',          'The message could not be sent. Please try again later.' );
    icl_register_string( $ctx, 'err_server',               'Something went wrong. Please try again.' );
    icl_register_string( $ctx, 'field_files_label',         'Attach files' );
    icl_register_string( $ctx, 'field_files_hint',          'Optional — up to 3 files, max. 5 MB each: images, PDF, STEP, x_t, TXT, CSV, Word, Excel' );
    icl_register_string( $ctx, 'err_files_count',           'You can attach no more than 3 files.' );
    icl_register_string( $ctx, 'err_files_size',            'Files are too large — up to 5 MB each and 10 MB in total.' );
    icl_register_string( $ctx, 'err_files_type',            'This file type is not accepted.' );
    icl_register_string( $ctx, 'err_files_failed',          'File upload failed. Please try again.' );
}

// ── Attachments ──────────────────────────────────────────────────

/**
 * Attachment rules for the contact form — one source of truth for the
 * accept="" list in the markup, the JS pre-check and the server-side check.
 * The same numbers appear in field_files_hint / err_files_* above; change
 * them together.
 */
function steelplast_contact_upload_rules() {
    return array(
        'max_files'       => 3,
        'max_file_bytes'  => 5 * MB_IN_BYTES,
        'max_total_bytes' => 10 * MB_IN_BYTES,
        // ext => mime, in the shape wp_check_filetype_and_ext() expects.
        'mimes' => array(
            'jpg|jpeg' => 'image/jpeg',
            'png'      => 'image/png',
            'webp'     => 'image/webp',
            'gif'      => 'image/gif',
            'pdf'      => 'application/pdf',
            'txt'      => 'text/plain',
            'csv'      => 'text/csv',
            'docx'     => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xlsx'     => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ),
        // Formats libmagic cannot pin down: it reports plain text for the CAD
        // exports and one generic OLE2 container for legacy Office. These are
        // matched on the format's own leading bytes instead, which still turns
        // away anything merely renamed, an .exe or an archive included.
        // Known limit: every OLE2 file shares that signature, so the .doc/.xls
        // check cannot tell a document from an installer or a macro carrier.
        'signatures' => array(
            'stp'  => 'ISO-10303-21',
            'step' => 'ISO-10303-21',
            'x_t'  => '**ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'doc'  => "\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1",
            'xls'  => "\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1",
        ),
    );
}

/**
 * Allowed extensions as an accept="" value, e.g. '.jpg,.jpeg,.png'.
 */
function steelplast_contact_upload_accept() {
    $rules = steelplast_contact_upload_rules();
    $exts  = array();

    foreach ( array_keys( $rules['mimes'] ) as $group ) {
        foreach ( explode( '|', $group ) as $ext ) {
            $exts[] = '.' . $ext;
        }
    }

    foreach ( array_keys( $rules['signatures'] ) as $ext ) {
        $exts[] = '.' . $ext;
    }

    return implode( ',', $exts );
}

/**
 * True when the file opens with the signature registered for its extension.
 * Used for the formats wp_check_filetype_and_ext() cannot identify by content.
 */
function steelplast_contact_signature_matches( $path, $ext, array $rules ) {
    if ( ! isset( $rules['signatures'][ $ext ] ) ) {
        return false;
    }

    $signature = $rules['signatures'][ $ext ];
    $handle    = fopen( $path, 'rb' );
    if ( ! $handle ) {
        return false;
    }

    $head = fread( $handle, 64 );
    fclose( $handle );

    if ( ! is_string( $head ) || '' === $head ) {
        return false;
    }

    // CAD exporters sometimes prepend a BOM or blank lines; the binary OLE2
    // signature opens with a byte this trim list does not touch.
    $head = ltrim( $head, "\xEF\xBB\xBF \t\r\n" );

    return 0 === strncmp( $head, $signature, strlen( $signature ) );
}

/**
 * Validate the files posted with one submission.
 *
 * Returns array( 'attachments' => array( 'shown-name.pdf' => '/tmp/path' ),
 * 'error' => '' ). Nothing is copied into the webroot: the files stay in
 * PHP's own upload temp dir, which PHP clears when the request ends.
 */
function steelplast_contact_collect_uploads() {
    $ctx   = 'steelplast/contacts/form';
    $rules = steelplast_contact_upload_rules();
    $out   = array( 'attachments' => array(), 'error' => '' );
    $files = $_FILES['sp_files'] ?? null;

    if ( ! is_array( $files ) || empty( $files['name'] ) || ! is_array( $files['name'] ) ) {
        return $out;
    }

    // An untouched file input still posts one empty slot.
    $picked = array();
    foreach ( array_keys( $files['name'] ) as $i ) {
        if ( UPLOAD_ERR_NO_FILE !== (int) ( $files['error'][ $i ] ?? UPLOAD_ERR_NO_FILE ) ) {
            $picked[] = $i;
        }
    }

    if ( ! $picked ) {
        return $out;
    }

    if ( count( $picked ) > $rules['max_files'] ) {
        $out['error'] = steelplast_t( $ctx, 'err_files_count', 'You can attach no more than 3 files.' );
        return $out;
    }

    $total = 0;

    foreach ( $picked as $i ) {
        $name  = $files['name'][ $i ] ?? null;
        $tmp   = $files['tmp_name'][ $i ] ?? null;
        $size  = (int) ( $files['size'][ $i ] ?? 0 );
        $total += $size;

        // A crafted POST can nest arrays where single values belong.
        if ( ! is_string( $name ) || ! is_string( $tmp )
            || UPLOAD_ERR_OK !== (int) $files['error'][ $i ]
            || ! is_uploaded_file( $tmp ) ) {
            $out['error'] = steelplast_t( $ctx, 'err_files_failed', 'File upload failed. Please try again.' );
            return $out;
        }

        if ( $size <= 0 || $size > $rules['max_file_bytes'] || $total > $rules['max_total_bytes'] ) {
            $out['error'] = steelplast_t( $ctx, 'err_files_size', 'Files are too large — up to 5 MB each and 10 MB in total.' );
            return $out;
        }

        // Reads the real content type, so an executable renamed .png is rejected.
        $check = wp_check_filetype_and_ext( $tmp, $name, $rules['mimes'] );
        $ext   = $check['ext'] ?: strtolower( (string) pathinfo( $name, PATHINFO_EXTENSION ) );

        if ( empty( $check['ext'] ) && ! steelplast_contact_signature_matches( $tmp, $ext, $rules ) ) {
            $out['error'] = steelplast_t( $ctx, 'err_files_type', 'This file type is not accepted.' );
            return $out;
        }

        // wp_mail keys attachments by the name it shows, so duplicate names
        // would overwrite each other.
        $label = sanitize_file_name( $name ) ?: 'file.' . $ext;
        $shown = $label;
        $n     = 1;
        while ( isset( $out['attachments'][ $shown ] ) ) {
            $shown = ++$n . '-' . $label;
        }

        $out['attachments'][ $shown ] = $tmp;
    }

    return $out;
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
    // A POST over PHP's post_max_size arrives with $_POST and $_FILES empty, so
    // the nonce check below would blame security for what is really a size cap.
    if ( empty( $_POST ) && ! empty( $_SERVER['CONTENT_LENGTH'] ) ) {
        wp_send_json_error( array( 'message' => steelplast_t( 'steelplast/contacts/form', 'err_files_size', 'Files are too large — up to 5 MB each and 10 MB in total.' ) ), 413 );
    }

    // Nonce check
    if ( empty( $_POST['sp_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sp_contact_nonce'] ) ), 'sp_contact_form' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ), 403 );
    }

    // Rate limit: 1 request per IP per 60 seconds via transient
    $ip_key = 'sp_contact_' . md5( sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) ) );
    if ( get_transient( $ip_key ) ) {
        wp_send_json_error( array( 'message' => steelplast_t( 'steelplast/contacts/form', 'err_rate_limit', 'Too many requests. Please wait a minute.' ) ), 429 );
    }

    // Sanitize
    $name    = sanitize_text_field( wp_unslash( $_POST['sp_name']    ?? '' ) );
    $email   = sanitize_email( wp_unslash( $_POST['sp_email']   ?? '' ) );
    $phone   = sanitize_text_field( wp_unslash( $_POST['sp_phone']   ?? '' ) );
    $comment = sanitize_textarea_field( wp_unslash( $_POST['sp_comment'] ?? '' ) );

    // Server-side validation
    if ( empty( $name ) ) {
        wp_send_json_error( array( 'message' => steelplast_t( 'steelplast/contacts/form', 'err_name_required', 'Please enter your name' ) ), 422 );
    }

    $has_email = ! empty( $email ) && is_email( $email );
    // E.164: 7–15 digits after stripping non-digits
    $phone_digits = preg_replace( '/\D/', '', $phone );
    $has_phone    = ! empty( $phone ) && strlen( $phone_digits ) >= 7 && strlen( $phone_digits ) <= 15;

    if ( ! $has_email && ! $has_phone ) {
        wp_send_json_error( array( 'message' => steelplast_t( 'steelplast/contacts/form', 'err_email_or_phone', 'Please enter an email or phone number' ) ), 422 );
    }

    // Optional attachments — validated before anything is sent.
    $uploads = steelplast_contact_collect_uploads();
    if ( '' !== $uploads['error'] ) {
        wp_send_json_error( array( 'message' => $uploads['error'] ), 422 );
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
    if ( $uploads['attachments'] ) $body .= "\nAttachments: " . implode( ', ', array_keys( $uploads['attachments'] ) ) . "\n";
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

    $sent = wp_mail( $to, $subject, $body, $headers, $uploads['attachments'] );

    remove_action( 'wp_mail_failed', $mail_error_handler );

    if ( ! $sent ) {
        if ( WP_DEBUG && $mail_error_message ) {
            error_log( 'SteelPlast contact form wp_mail failed: ' . $mail_error_message );
        }
        wp_send_json_error( array( 'message' => steelplast_t( 'steelplast/contacts/form', 'err_send_failed', 'The message could not be sent. Please try again later.' ) ), 500 );
    }

    // Set rate limit transient (60 seconds)
    set_transient( $ip_key, 1, 60 );

    wp_send_json_success();
}
