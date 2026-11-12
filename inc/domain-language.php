<?php
/**
 * Language by domain.
 *
 * Every domain the company owns points at this site. The other domains do not
 * show the site under their own name: each sends the visitor to one language
 * on the main domain, so search engines see one site and not copies of it.
 * Domains without a language of their own on the site go to English.
 *
 * On the main domain itself Ukrainian is the default language, so its bare
 * home page would open in Ukrainian. A domain listed for that sends a visitor who
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

add_action( 'init', static function () {
    $alias_language = array(
        'steel-plast.pl'  => 'pl',
        'steelplast.de'   => 'de',
        'steel-plast.de'  => 'de',
        'steelplast.cz'   => 'en',
        'steel-plast.cz'  => 'en',
        'steel-plast.fr'  => 'en',
        'steel-plast.com' => 'en',
    );

    $host = preg_replace( '/^www\.|:\d+$/', '', strtolower( $_SERVER['HTTP_HOST'] ?? '' ) );
    if ( ! isset( $alias_language[ $host ] ) ) {
        return;
    }

    // Raw option: WPML rewrites home_url() to the current language's home.
    wp_redirect( untrailingslashit( get_option( 'home' ) ) . '/' . $alias_language[ $host ] . '/', 301 );
    exit;
} );

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

    // The raw option, not home_url(): WPML rewrites home_url() to the current language's home.
    // 302: the home page itself has not moved, this domain just opens on another language.
    wp_safe_redirect( untrailingslashit( get_option( 'home' ) ) . '/' . $language . '/', 302 );
    exit;
} );
