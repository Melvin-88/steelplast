<?php
/**
 * Search-engine indexing switch.
 *
 * The site stays closed to search engines until wp-config.php opens it:
 *
 *     define( 'STEELPLAST_ALLOW_INDEXING', true );
 *
 * Closed is the default on purpose: a test copy on a public host must not
 * depend on someone remembering a setting. The constant is the only switch —
 * Settings → Reading → "Search engine visibility" follows it and saving that
 * checkbox changes nothing.
 *
 * While closed:
 * - pages carry `noindex, nofollow` (meta tag and HTTP header) and stay
 *   crawlable, because a crawler has to read the page to see the tag;
 * - files under wp-content (photos, video, PDFs) cannot carry a tag, so
 *   robots.txt keeps crawlers away from them instead;
 * - robots.txt does not advertise the sitemap.
 *
 * @package SteelPlast
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function steelplast_indexing_allowed() {
    return defined( 'STEELPLAST_ALLOW_INDEXING' ) && STEELPLAST_ALLOW_INDEXING;
}

// WordPress core, Yoast and WPML all read this option to decide on noindex,
// sitemaps and pings, so answering for it here switches every one of them.
add_filter( 'pre_option_blog_public', static function () {
    return steelplast_indexing_allowed() ? '1' : '0';
} );

if ( ! steelplast_indexing_allowed() ) {

    // Feeds and other responses without a <head> have no meta tag to carry it.
    add_filter( 'wp_headers', static function ( $headers ) {
        $headers['X-Robots-Tag'] = 'noindex, nofollow';
        return $headers;
    } );

    // Replaces the whole file, Yoast's sitemap line included (it adds it at 99999).
    add_filter( 'robots_txt', static function () {
        $content_path = wp_parse_url( content_url(), PHP_URL_PATH );
        return "User-agent: *\nDisallow: {$content_path}/\n";
    }, PHP_INT_MAX );
}
