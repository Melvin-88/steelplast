<?php
/**
 * Home page language by domain.
 *
 * Ukrainian is the default language, so the bare home page of any domain the
 * site answers on opens in Ukrainian. A domain listed here sends a visitor who
 * arrives at its home page to its own language instead: steelplast.pl → /pl/.
 *
 * Someone who reaches the home page from a page of this site (picked
 * Ukrainian in the language switcher, clicked the logo) is left where they
 * are, so every language stays reachable on every domain.
 *
 * shortcut: home page only, by a PHP redirect, so a full-page cache would skip it;
 * replace with WPML's "different domain per language" when steelplast.com.ua goes live.
 *
 * @package SteelPlast
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'template_redirect', static function () {
    $domain_language = array(
        'steelplast.pl' => 'pl',
    );

    $host = wp_parse_url( home_url(), PHP_URL_HOST );
    if ( ! isset( $domain_language[ $host ] ) || ! is_front_page() || ! empty( $_GET ) ) {
        return;
    }

    $language = $domain_language[ $host ];
    if ( apply_filters( 'wpml_current_language', null ) !== apply_filters( 'wpml_default_language', null )
        || $language === apply_filters( 'wpml_default_language', null ) ) {
        return;
    }

    $referer = wp_get_raw_referer();
    if ( $referer && wp_parse_url( $referer, PHP_URL_HOST ) === $host ) {
        return;
    }

    // 302: the home page itself has not moved, this domain just opens on another language.
    wp_safe_redirect( home_url( '/' . $language . '/' ), 302 );
    exit;
} );
