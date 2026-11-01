<?php
/**
 * Translated image alt texts.
 *
 * The media library holds one alt per image, written in Ukrainian, and every
 * language shares the same attachment. Each alt is registered as a WPML string
 * whose source language is Ukrainian, and swapped for the current language's
 * translation wherever the theme prints an image.
 *
 * @package SteelPlast
 */

if ( ! defined( 'ABSPATH' ) ) exit;

const STEELPLAST_ALT_CONTEXT = 'steelplast/media';

function steelplast_alt_string_name( $attachment_id ) {
    return 'alt_' . (int) $attachment_id;
}

/**
 * The alt in the current language, or the Ukrainian original when there is no
 * translation yet.
 */
function steelplast_translate_alt( $alt, $attachment_id ) {
    if ( '' === (string) $alt || ! $attachment_id ) {
        return $alt;
    }
    return apply_filters( 'wpml_translate_single_string', $alt, STEELPLAST_ALT_CONTEXT, steelplast_alt_string_name( $attachment_id ) );
}

// wp_get_attachment_image() and everything built on it.
add_filter( 'wp_get_attachment_image_attributes', function ( $attr, $attachment ) {
    if ( isset( $attr['alt'] ) ) {
        $attr['alt'] = steelplast_translate_alt( $attr['alt'], $attachment->ID );
    }
    return $attr;
}, 10, 2 );

// ACF image fields returned as arrays — page heroes and section images.
add_filter( 'acf/format_value/type=image', function ( $value ) {
    if ( is_array( $value ) && ! empty( $value['alt'] ) && ! empty( $value['ID'] ) ) {
        $value['alt'] = steelplast_translate_alt( $value['alt'], $value['ID'] );
    }
    return $value;
}, 20 );

// Register an alt the moment it is saved, so a new upload appears in WPML
// String Translation without anyone running a script.
add_action( 'added_post_meta', 'steelplast_register_alt', 10, 4 );
add_action( 'updated_post_meta', 'steelplast_register_alt', 10, 4 );
function steelplast_register_alt( $meta_id, $post_id, $meta_key, $meta_value ) {
    if ( '_wp_attachment_image_alt' !== $meta_key || '' === trim( (string) $meta_value ) ) {
        return;
    }
    do_action( 'wpml_register_single_string', STEELPLAST_ALT_CONTEXT, steelplast_alt_string_name( $post_id ), $meta_value, false, 'uk' );
}
