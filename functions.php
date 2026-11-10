<?php
/**
 * SteelPlast functions and definitions
 *
 * @package SteelPlast
 */

if ( ! defined( 'STEELPLAST_VERSION' ) ) {
    define( 'STEELPLAST_VERSION', '1.0.0' );
}

require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/media-alt-i18n.php';
require_once get_template_directory() . '/inc/indexing.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function steelplast_setup() {
    load_theme_textdomain( 'steelplast', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable post thumbnails
    add_theme_support( 'post-thumbnails' );
    
    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // HTML5 support
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Menus
    register_nav_menus(
        array(
            'primary' => esc_html__( 'Primary', 'steelplast' ),
            'footer'  => esc_html__( 'Footer', 'steelplast' ),
        )
    );
}
add_action( 'after_setup_theme', 'steelplast_setup' );

/**
 * Register widget areas.
 */
function steelplast_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'steelplast' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'steelplast' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'Hero Section', 'steelplast' ),
            'id'            => 'hero-section',
            'description'   => esc_html__( 'Hero section for front page.', 'steelplast' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'steelplast_widgets_init' );

// =============================================
// Favicons
// =============================================

remove_action( 'wp_head', 'wp_site_icon', 99 );

function steelplast_favicons() {
    $uri = get_template_directory_uri() . '/assets/img/favicons';
    ?>
    <link rel="icon" type="image/x-icon" href="<?php echo esc_url( $uri . '/favicon.ico' ); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( $uri . '/favicon.svg' ); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( $uri . '/favicon-16x16.png' ); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( $uri . '/favicon-32x32.png' ); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( $uri . '/apple-touch-icon.png' ); ?>">
    <link rel="manifest" href="<?php echo esc_url( $uri . '/site.webmanifest' ); ?>">
    <meta name="theme-color" content="#090a0c">
    <?php
}
add_action( 'wp_head', 'steelplast_favicons', 1 );

/**
 * Enqueue scripts and styles.
 */
function steelplast_scripts() {
    wp_enqueue_style( 'steelplast-style', get_stylesheet_uri(), array(), STEELPLAST_VERSION );

    wp_enqueue_style(
        'steelplast-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    $main_css = get_template_directory() . '/assets/css/main.css';
    wp_enqueue_style(
        'steelplast-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array( 'steelplast-google-fonts' ),
        file_exists( $main_css ) ? filemtime( $main_css ) : STEELPLAST_VERSION
    );

    $header_js = get_template_directory() . '/assets/js/header.js';
    wp_enqueue_script(
        'steelplast-header',
        get_template_directory_uri() . '/assets/js/header.js',
        array(),
        file_exists( $header_js ) ? filemtime( $header_js ) : STEELPLAST_VERSION,
        true
    );

    // Animations — GSAP + ScrollTrigger, sitewide. Deferred in the footer so
    // they never block the first paint; the page is complete without them.
    $deferred = array( 'in_footer' => true, 'strategy' => 'defer' );
    foreach ( array(
        'gsap'               => array( 'vendor/gsap.min.js', array() ),
        'gsap-scrolltrigger' => array( 'vendor/ScrollTrigger.min.js', array( 'gsap' ) ),
        'steelplast-motion'  => array( 'motion.js', array( 'gsap', 'gsap-scrolltrigger' ) ),
    ) as $handle => $script ) {
        $path = get_template_directory() . '/assets/js/' . $script[0];
        wp_enqueue_script(
            $handle,
            get_template_directory_uri() . '/assets/js/' . $script[0],
            $script[1],
            file_exists( $path ) ? filemtime( $path ) : STEELPLAST_VERSION,
            $deferred
        );
    }

    // Contact form JS/CSS — sitewide. The quick-contact modal (footer.php)
    // renders template-parts/contact-form.php on every page, and the full
    // section-contact.php form is used by most templates already, so these
    // assets are needed everywhere rather than gated per-template.
    $iti_css = get_template_directory() . '/assets/css/vendor/intlTelInput.min.css';
    wp_enqueue_style(
        'intl-tel-input',
        get_template_directory_uri() . '/assets/css/vendor/intlTelInput.min.css',
        array(),
        file_exists( $iti_css ) ? filemtime( $iti_css ) : STEELPLAST_VERSION
    );
    // Fix flag paths + force light dropdown theme — must be AFTER vendor CSS
    $flags_uri = get_template_directory_uri() . '/assets/img';
    wp_add_inline_style( 'intl-tel-input', sprintf(
        ':root{--iti-path-flags-1x:url("%1$s/flags.webp");--iti-path-flags-2x:url("%1$s/flags@2x.webp");}
        .iti__dropdown-content,.iti__dropdown-content *{color:#090a0c!important;box-sizing:border-box;}
        .iti__dropdown-content{background:#ffffff!important;border:1px solid rgba(9,10,12,.12)!important;box-shadow:0 8px 24px rgba(9,10,12,.12)!important;}
        .iti__search-input{color:#090a0c!important;background:#ffffff!important;border-bottom:1px solid rgba(9,10,12,.12)!important;}
        .iti__country{color:#090a0c!important;background:#ffffff!important;}
        .iti__country:hover,.iti__country--highlight{background:rgba(9,10,12,.06)!important;}
        .iti__country-name{color:#090a0c!important;}
        .iti__dial-code{color:#8a8a8a!important;}
        .iti__selected-dial-code{color:#090a0c!important;}
        .iti__selected-country-primary,.iti__selected-country{color:#090a0c!important;}',
        esc_url( $flags_uri )
    ) );

    $iti_js = get_template_directory() . '/assets/js/vendor/intlTelInputWithUtils.min.js';
    wp_enqueue_script(
        'intl-tel-input',
        get_template_directory_uri() . '/assets/js/vendor/intlTelInputWithUtils.min.js',
        array(),
        file_exists( $iti_js ) ? filemtime( $iti_js ) : STEELPLAST_VERSION,
        true
    );

    $contact_js = get_template_directory() . '/assets/js/contact-form.js';
    wp_enqueue_script(
        'steelplast-contact',
        get_template_directory_uri() . '/assets/js/contact-form.js',
        array( 'intl-tel-input' ),
        file_exists( $contact_js ) ? filemtime( $contact_js ) : STEELPLAST_VERSION,
        true
    );
    $upload_rules = steelplast_contact_upload_rules();
    wp_localize_script( 'steelplast-contact', 'spContact', array(
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'flagsUrl1x' => get_template_directory_uri() . '/assets/img/flags.webp',
        'flagsUrl2x' => get_template_directory_uri() . '/assets/img/flags@2x.webp',
        'i18n'    => array(
            'nameRequired' => steelplast_t( 'steelplast/contacts/form', 'err_name_required', 'Please enter your name' ),
            'emailOrPhone' => steelplast_t( 'steelplast/contacts/form', 'err_email_or_phone', 'Please enter an email or phone number' ),
            'emailInvalid' => steelplast_t( 'steelplast/contacts/form', 'err_email_invalid', 'Invalid email address' ),
            'phoneInvalid' => steelplast_t( 'steelplast/contacts/form', 'err_phone_invalid', 'Please enter a complete phone number' ),
            'serverError'  => steelplast_t( 'steelplast/contacts/form', 'err_server', 'Something went wrong. Please try again.' ),
            'filesCount'   => steelplast_t( 'steelplast/contacts/form', 'err_files_count', 'You can attach no more than 3 files.' ),
            'filesSize'    => steelplast_t( 'steelplast/contacts/form', 'err_files_size', 'Files are too large — up to 5 MB each and 10 MB in total.' ),
            'filesType'    => steelplast_t( 'steelplast/contacts/form', 'err_files_type', 'This file type is not accepted.' ),
        ),
        'files'   => array(
            'maxFiles'      => $upload_rules['max_files'],
            'maxFileBytes'  => $upload_rules['max_file_bytes'],
            'maxTotalBytes' => $upload_rules['max_total_bytes'],
            'accept'        => explode( ',', steelplast_contact_upload_accept() ),
        ),
    ) );

    // Quick-contact modal — sitewide, triggered via data-sp-modal-open.
    $modal_js = get_template_directory() . '/assets/js/modal.js';
    wp_enqueue_script(
        'steelplast-modal',
        get_template_directory_uri() . '/assets/js/modal.js',
        array(),
        file_exists( $modal_js ) ? filemtime( $modal_js ) : STEELPLAST_VERSION,
        true
    );

    // Pass available WPML languages to JS for browser language detection
    if ( function_exists( 'icl_get_languages' ) ) {
        $wpml_langs     = icl_get_languages( 'skip_missing=0' );
        $langs_for_js   = array();
        $default_url    = home_url( '/' );

        if ( is_array( $wpml_langs ) && ! empty( $wpml_langs ) ) {
            foreach ( $wpml_langs as $lang ) {
                $langs_for_js[ strtolower( $lang['language_code'] ) ] = $lang['url'];
                if ( ( ! empty( $lang['default_locale'] ) && $lang['default_locale'] ) || $lang['language_code'] === 'en' ) {
                    $default_url = $lang['url'];
                }
            }
        }

        wp_localize_script( 'steelplast-header', 'steelplastLangs', array(
            'available'  => $langs_for_js,
            'defaultUrl' => $default_url,
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'steelplast_scripts' );

// FAQ accordion JS — FAQ page only
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_page_template( 'page-templates/template-faq.php' ) ) return;
    $faq_js = get_template_directory() . '/assets/js/faq.js';
    wp_enqueue_script(
        'steelplast-faq',
        get_template_directory_uri() . '/assets/js/faq.js',
        array(),
        file_exists( $faq_js ) ? filemtime( $faq_js ) : STEELPLAST_VERSION,
        true
    );
} );

/**
 * Add hreflang tags for multilingual support (Polylang/WPML compatible)
 */
function steelplast_hreflang_tags() {
    // Skip if Yoast SEO, Polylang or WPML handles this
    if ( function_exists( 'pll_the_languages' ) || defined( 'WPSEO_VERSION' ) || defined( 'ICL_SITEPRESS_VERSION' ) ) {
        return;
    }
    
    // Use WordPress helpers instead of raw $_SERVER variables
    $hreflang     = str_replace( '_', '-', get_locale() );
    $current_url  = home_url( add_query_arg( null, null ) );
    
    printf(
        '<link rel="alternate" hreflang="%s" href="%s" />' . "\n",
        esc_attr( $hreflang ),
        esc_url( $current_url )
    );
}
add_action( 'wp_head', 'steelplast_hreflang_tags', 1 );

/**
 * Disable default WordPress SEO if Yoast is active
 */
function steelplast_disable_wp_seo() {
    if ( defined( 'WPSEO_VERSION' ) ) {
        // WordPress generates canonical URLs - let Yoast handle it
        remove_action( 'wp_head', 'rel_canonical' );
    }
}
add_action( 'after_setup_theme', 'steelplast_disable_wp_seo' );

/**
 * Disable WPML default footer language switcher and dev banner.
 * Scoped to WPML being active to avoid side-effects on non-WPML installs.
 */
// =============================================
// WPML String Translation — register theme strings
// =============================================

function steelplast_register_wpml_strings() {
    if ( ! function_exists( 'icl_register_string' ) ) return;

    // Format: icl_register_string( 'steelplast/{page}/{section}', 'key', 'default' )

    // -- steelplast/global/header --
    icl_register_string( 'steelplast/global/header', 'contacts', 'Contact' );
    icl_register_string( 'steelplast/global/header', 'cta',      'Get in touch' );

    // -- Labels for screen readers and keyboard users, plus the empty-results page --
    icl_register_string( 'steelplast/global/a11y', 'skip_link', 'Skip to content' );
    icl_register_string( 'steelplast/global/a11y', 'home_link', 'home page' );
    icl_register_string( 'steelplast/global/a11y', 'primary_menu', 'Main menu' );
    icl_register_string( 'steelplast/global/a11y', 'open_menu', 'Open menu' );
    icl_register_string( 'steelplast/home/hero', 'section_aria', 'Introduction' );
    icl_register_string( 'steelplast/home/hero', 'stats_aria', 'Key figures' );
    icl_register_string( 'steelplast/home/about-preview', 'section_aria', 'About us' );
    icl_register_string( 'steelplast/contacts/page', 'info_aria', 'Contact information' );
    icl_register_string( 'steelplast/contacts/page', 'map_aria', 'Map' );
    icl_register_string( 'steelplast/contacts/page', 'map_title', 'Map of our location' );
    icl_register_string( 'steelplast/news/archive', 'filter_aria', 'Filter by category' );
    icl_register_string( 'steelplast/news/archive', 'pagination_aria', 'Article navigation' );
    icl_register_string( 'steelplast/global/not-found', 'title', 'Nothing found' );
    icl_register_string( 'steelplast/global/not-found', 'search_none', 'Sorry, nothing matched your search. Please try different keywords.' );
    icl_register_string( 'steelplast/global/not-found', 'none', "We can't find what you're looking for. Perhaps searching can help." );

    // -- steelplast/global/footer --
    icl_register_string( 'steelplast/global/footer', 'description',  'We specialize in supplying high-quality components for the automotive, medical, household goods, electrical, furniture and construction industries.' );
    icl_register_string( 'steelplast/global/footer', 'menu_title',   'MENU' );
    icl_register_string( 'steelplast/global/footer', 'social_title', 'FOLLOW US' );
    icl_register_string( 'steelplast/global/footer', 'copyright',    'All rights reserved.' );
    // Social URLs are managed via Customizer → Site Settings → Social Media

    // -- steelplast/global/modal-contact -- quick-contact modal, triggerable
    // from any page via data-sp-modal-open="quick-contact" (see header CTA, single.php)
    icl_register_string( 'steelplast/global/modal-contact', 'title',      'Contact us' );
    icl_register_string( 'steelplast/global/modal-contact', 'desc',       'Leave your contact details, and we will get back to you shortly.' );
    icl_register_string( 'steelplast/global/modal-contact', 'close_aria', 'Close' );

    // -- steelplast/home/hero --
    icl_register_string( 'steelplast/home/hero', 'title',       'Design Manufacture Scale' );
    icl_register_string( 'steelplast/home/hero', 'description', 'Steel Plast takes care of the entire journey — from concept to series production, whatever the complexity or scale.' );
    icl_register_string( 'steelplast/home/hero', 'stat_1_label', 'Plastic parts manufactured' );
    icl_register_string( 'steelplast/home/hero', 'stat_2_label', 'Metal parts manufactured' );
    icl_register_string( 'steelplast/home/hero', 'stat_3_label', 'Projects completed in 2025/2026' );
    icl_register_string( 'steelplast/home/hero', 'format_millions', '%sM' );
    icl_register_string( 'steelplast/home/hero', 'format_thousands', '%sK' );

    // -- steelplast/contacts/page --
    icl_register_string( 'steelplast/contacts/page', 'emails_heading',    'Email' );
    icl_register_string( 'steelplast/contacts/page', 'phones_heading',    'Phone' );
    icl_register_string( 'steelplast/contacts/page', 'locations_heading', 'Our Locations' );
    icl_register_string( 'steelplast/contacts/page', 'location_label',   'Head office and production facility' );
    icl_register_string( 'steelplast/contacts/page', 'location_address', "2/9 Avtobazivska St.\nPoltava 36000\nPoltava Oblast, Ukraine" );

    // Email labels
    icl_register_string( 'steelplast/contacts/page', 'email_1_label', 'General inquiries and orders' );
    icl_register_string( 'steelplast/contacts/page', 'email_2_label', 'Procurement department' );

    // Phone labels
    icl_register_string( 'steelplast/contacts/page', 'phone_1_label', 'General inquiries' );
    icl_register_string( 'steelplast/contacts/page', 'phone_2_label', 'Technical department (drawing-related questions)' );
    icl_register_string( 'steelplast/contacts/page', 'phone_3_label', 'Partner hotline' );

    // -- steelplast/news/single --
    icl_register_string( 'steelplast/news/single', 'back_label',      'Back to news' );
    icl_register_string( 'steelplast/news/single', 'date_label',      'Published' );
    icl_register_string( 'steelplast/news/single', 'read_time_label', 'Reading time' );
    icl_register_string( 'steelplast/news/single', 'read_time_value', '%d min' );
    icl_register_string( 'steelplast/news/single', 'tags_label',      'Tags' );

    // -- steelplast/news/header --
    icl_register_string( 'steelplast/news/header', 'news_label',   'Articles & News' );
    icl_register_string( 'steelplast/news/header', 'news_title',   "Stay up to date\nwith company news" );
    icl_register_string( 'steelplast/news/header', 'news_desc',    'Production updates, completed projects and news from our manufacturing floor.' );
    icl_register_string( 'steelplast/news/header', 'news_all_btn', 'All articles' );

    // -- steelplast/news/archive --
    icl_register_string( 'steelplast/news/archive', 'filter_label',  'Categories' );
    icl_register_string( 'steelplast/news/archive', 'filter_all',    'All articles' );
    icl_register_string( 'steelplast/news/archive', 'archive_empty', 'No articles yet. Check back later.' );

    // -- steelplast/post-card --
    icl_register_string( 'steelplast/post-card', 'read_more', 'Read more' );

    // -- steelplast/contacts/hero --
    icl_register_string( 'steelplast/contacts/hero', 'contact_hero_title', 'Still have questions?' );
    icl_register_string( 'steelplast/contacts/hero', 'contact_hero_desc',  'Send us a request, and we will get back to you.' );

    // -- steelplast/contacts/form --
    icl_register_string( 'steelplast/contacts/form', 'contact_form_aria',         'Contact form' );
    icl_register_string( 'steelplast/contacts/form', 'field_name_placeholder',    'Your name' );
    icl_register_string( 'steelplast/contacts/form', 'field_email_placeholder',   'Email' );
    icl_register_string( 'steelplast/contacts/form', 'field_phone_placeholder',   'Phone' );
    icl_register_string( 'steelplast/contacts/form', 'field_comment_placeholder', 'Your message (optional)' );
    icl_register_string( 'steelplast/contacts/form', 'submit_label',              'Send request' );
    icl_register_string( 'steelplast/contacts/form', 'success_message',           'Thank you! We will get back to you shortly.' );
    icl_register_string( 'steelplast/contacts/form', 'err_name_required',         'Please enter your name' );
    icl_register_string( 'steelplast/contacts/form', 'err_email_or_phone',        'Please enter an email or phone number' );
    icl_register_string( 'steelplast/contacts/form', 'err_email_invalid',         'Invalid email address' );
    icl_register_string( 'steelplast/contacts/form', 'err_phone_invalid',         'Please enter a complete phone number' );
    icl_register_string( 'steelplast/contacts/form', 'err_server',                'Something went wrong. Please try again.' );
    icl_register_string( 'steelplast/contacts/form', 'err_rate_limit',            'Too many requests. Please wait a minute.' );
    icl_register_string( 'steelplast/contacts/form', 'err_send_failed',           'The message could not be sent. Please try again later.' );

    // -- steelplast/home/about-preview --
    icl_register_string( 'steelplast/home/about-preview', 'tag',         '[02] About us' );
    icl_register_string( 'steelplast/home/about-preview', 'title',       'We turn drawings into parts, and parts into series production' );
    icl_register_string( 'steelplast/home/about-preview', 'description', 'Steel Plast combines CNC metal machining, mold design and manufacturing, and series production of plastic components. 10+ years of making things that work.' );
    icl_register_string( 'steelplast/home/about-preview', 'button',      'Learn more about us' );

    // -- steelplast/home/services --
    icl_register_string( 'steelplast/home/services', 'section_label',   'SERVICES' );
    icl_register_string( 'steelplast/home/services', 'title',           'Modern equipment, manufacturing precision and quality control' );
    icl_register_string( 'steelplast/home/services', 'cta_label',       'Learn more' );
    icl_register_string( 'steelplast/home/services', 'card_1_title',    'Metal Stamping' );
    icl_register_string( 'steelplast/home/services', 'card_1_desc',     'Sheet metal stamping — blanking, bending and deep drawing.' );
    icl_register_string( 'steelplast/home/services', 'card_2_title',    'Plastic Injection Molding' );
    icl_register_string( 'steelplast/home/services', 'card_2_desc',     'Plastic injection molding on modern injection molding machines — from prototypes to series production.' );
    icl_register_string( 'steelplast/home/services', 'card_3_title',    'Molds & Dies' );
    icl_register_string( 'steelplast/home/services', 'card_3_desc',     'Design and manufacture of molds and dies — from inquiry to finished product.' );
    icl_register_string( 'steelplast/home/services', 'card_4_title',    'Metal Machining' );
    icl_register_string( 'steelplast/home/services', 'card_4_desc',     'CNC turning and milling of highly complex parts — from a single piece to series production.' );
    icl_register_string( 'steelplast/home/services', 'card_5_title',    'Custom Tooling' );
    icl_register_string( 'steelplast/home/services', 'card_5_desc',     'Assembly fixtures, inspection gauges and jigs, designed and built for your process.' );
    icl_register_string( 'steelplast/home/services', 'card_6_title',     'Springs & Wire Products' );
    icl_register_string( 'steelplast/home/services', 'card_6_desc',      'Custom springs and bent wire products — to a drawing or a sample.' );

    // -- steelplast/collaboration/header --
    icl_register_string( 'steelplast/collaboration/header', 'collab_label',   'Collaboration' );
    icl_register_string( 'steelplast/collaboration/header', 'collab_title',   'LET\'S BUILD SOMETHING THAT WORKS.' );
    icl_register_string( 'steelplast/collaboration/header', 'collab_desc_1',  'You come to us with an idea, a drawing or a specific production task — we help you find the way to a finished product. We support the project, launch production and scale it up.' );

    // -- steelplast/collaboration/steps --
    icl_register_string( 'steelplast/collaboration/steps', 'steps_aria',   'How we work' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_1_tag',   'Stage 1' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_1_title', 'YOUR REQUEST' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_1_text',  'Submit a request via the website or contact us directly. Briefly describe the task and your product requirements.' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_2_tag',   'Stage 2' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_2_title', 'A SOLUTION FOR YOUR PROJECT' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_2_text',  'We discuss the technical specification before production begins.' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_3_tag',   'Stage 3' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_3_title', 'PRODUCTION LAUNCH' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_3_text',  'We manufacture products to the approved requirements, with quality control at every stage.' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_4_tag',   'Stage 4' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_4_title', 'FINISHED PRODUCT' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_4_text',  'We arrange packaging and delivery of finished products within the agreed timeframe.' );

    // -- steelplast/quality/hero --
    icl_register_string( 'steelplast/quality/hero', 'title', 'Production and Quality: Standards You Can Trust' );

    // -- steelplast/quality/steps --
    icl_register_string( 'steelplast/quality/steps', 'label',        'Quality Management System' );
    icl_register_string( 'steelplast/quality/steps', 'title',        "Our quality management system\ncovers the entire product lifecycle" );
    icl_register_string( 'steelplast/quality/steps', 'desc_1',       'We have built our approach so that quality is controlled at every stage, from raw material intake to finished, shipped products.' );
    icl_register_string( 'steelplast/quality/steps', 'step_1_tag',   '01' );
    icl_register_string( 'steelplast/quality/steps', 'step_1_title', 'Unified Process Control' );
    icl_register_string( 'steelplast/quality/steps', 'step_1_text',  'Every processing stage is controlled under a single quality control protocol, from raw material to finished part.' );
    icl_register_string( 'steelplast/quality/steps', 'step_2_tag',   '02' );
    icl_register_string( 'steelplast/quality/steps', 'step_2_title', 'Dedicated Inspector' );
    icl_register_string( 'steelplast/quality/steps', 'step_2_text',  'A dedicated quality inspector is assigned to each production batch, ensuring full accountability.' );
    icl_register_string( 'steelplast/quality/steps', 'step_3_tag',   '03' );
    icl_register_string( 'steelplast/quality/steps', 'step_3_title', 'Thorough Testing' );
    icl_register_string( 'steelplast/quality/steps', 'step_3_text',  'Finished products undergo thorough testing before shipment to confirm compliance with specifications.' );

    // -- steelplast/quality/cards --
    icl_register_string( 'steelplast/quality/cards', 'card_1_title', 'IATF 16949 Certified' );
    icl_register_string( 'steelplast/quality/cards', 'card_1_desc',  'International automotive quality management standard applied at every production stage.' );
    icl_register_string( 'steelplast/quality/cards', 'card_2_title', 'ISO 9001 Certification' );
    icl_register_string( 'steelplast/quality/cards', 'card_2_desc',  'A certified quality management system that ensures consistently excellent products.' );
    icl_register_string( 'steelplast/quality/cards', 'card_3_title', '6-Stage Inspection' );
    icl_register_string( 'steelplast/quality/cards', 'card_3_desc',  'Multi-stage inspection from raw material intake to shipment of finished products.' );
    icl_register_string( 'steelplast/quality/cards', 'card_4_title', 'Zero-Defect Policy' );
    icl_register_string( 'steelplast/quality/cards', 'card_4_desc',  'Numerous awards from clients for high quality and excellent production results.' );
    icl_register_string( 'steelplast/quality/cards', 'grid_aria',    'Quality certificates' );

    // -- steelplast/quality/header --
    icl_register_string( 'steelplast/quality/header', 'label',    'Product Quality' );
    icl_register_string( 'steelplast/quality/header', 'title',    'Quality is not a separate stage. It is the foundation of everything we make.' );
    icl_register_string( 'steelplast/quality/header', 'desc',     'We don\'t rely on random sampling: our quality is confirmed by certification and checked at every stage of production.' );
    icl_register_string( 'steelplast/quality/header', 'cta_aria', 'Learn more about our quality standards' );
    icl_register_string( 'steelplast/quality/header', 'cta_text', 'Learn more' );

    // -- steelplast/quality/certification --
    icl_register_string( 'steelplast/quality/certification', 'title',          'Quality Assurance: ISO Certification' );
    icl_register_string( 'steelplast/quality/certification', 'download_label', 'Download file' );
    icl_register_string( 'steelplast/quality/certification', 'file_1_label',   'ISO 9001 Certificate' );
    icl_register_string( 'steelplast/quality/certification', 'file_2_label',   'Technical specifications and quality certificates' );
    icl_register_string( 'steelplast/quality/certification', 'label',          'ISO Certificates' );
    icl_register_string( 'steelplast/quality/certification', 'desc',           'We demonstrate a high standard of management and production safety not just in words but in practice. Steel Plast regularly undergoes independent audits for compliance with strict international standards.' );

    // -- steelplast/quality/reliability --
    icl_register_string( 'steelplast/quality/reliability', 'title',          'Reliability in Every Product' );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_2_title', 'Compliance with Standards' );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_2_desc',  'Our products comply with national and international standards (DSTU / ISO).' );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_3_title', 'Manufacturer\'s Warranty' );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_3_desc',  'We take full responsibility for every product we ship and provide an official warranty.' );
    icl_register_string( 'steelplast/quality/reliability', 'label',          'Uncompromising Quality Control' );
    icl_register_string( 'steelplast/quality/reliability', 'intro',          'We understand that the stability of your production depends on our components, which is why we never compromise on quality.' );

    // -- steelplast/quality/equipment --
    icl_register_string( 'steelplast/quality/equipment', 'card_1_title',  'Modern Equipment Fleet' );
    icl_register_string( 'steelplast/quality/equipment', 'card_1_desc',   'Our production equipment is regularly upgraded in line with the highest manufacturing standards.' );
    icl_register_string( 'steelplast/quality/equipment', 'card_2_title',  'Process Automation' );
    icl_register_string( 'steelplast/quality/equipment', 'card_2_desc',   'Automated processes minimize human error and maintain consistent quality in every production batch.' );
    icl_register_string( 'steelplast/quality/equipment', 'card_3_title',  'Highly Qualified Team' );
    icl_register_string( 'steelplast/quality/equipment', 'card_3_desc',   'Our engineers and operators have many years of experience in precision manufacturing.' );
    icl_register_string( 'steelplast/quality/equipment', 'section_label', 'Production' );
    icl_register_string( 'steelplast/quality/equipment', 'title',         'Our Own Modern Production Facility' );
    icl_register_string( 'steelplast/quality/equipment', 'description',  'Our own modern production facility allows us to deliver projects of any complexity, from series products to custom orders built to client drawings.' );

    // ===== Added 2026-07-08: strings from pages built after the previous
    // registration pass (About page, FAQ, all 5 service pages) had never
    // been registered with WPML — they existed in templates via
    // steelplast_t() but icl_t() alone doesn't auto-register anything, so
    // they were invisible in String Translation and impossible to translate.
    // See steelplast_t() above: it only looks up an existing translation,
    // it does not register. Every new steelplast_t() call needs a matching
    // icl_register_string() line here or it silently falls back to English
    // on every language, forever. =====

    // -- steelplast/about/hero --
    icl_register_string( 'steelplast/about/hero', 'title', 'Who We Are and What We Make' );

    // -- steelplast/service-metal-stamping/specs --
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_1_title', 'Materials' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_1_subtitle', 'We stamp:' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_1_item_1', 'Low-carbon steel' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_1_item_2', 'Stainless steel' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_1_item_3', 'Galvanized steel' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_1_item_4', 'Aluminum' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_1_item_5', 'Copper' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_1_item_6', 'Brass' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_1_note', 'Sheet thickness from 0.15 to 5 mm.' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_title', 'Stamping Operations' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_subtitle', 'Core operations' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_1_title', 'Cutting operations' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_1_item_1', 'Blanking' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_1_item_2', 'Piercing' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_1_item_3', 'Trimming' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_2_title', 'Forming' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_2_item_1', 'Bending' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_2_item_2', 'Deep drawing' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_2_item_3', 'Embossing' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_title', 'Equipment & Quality Control' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_subtitle', 'Precision you can rely on' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_stat_suffix', 't' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_stat_label', 'Maximum press force' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_item_1', 'Pneumatic crank presses' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_item_2', 'Incoming material inspection' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_item_3', 'Die wear monitoring' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_item_4', 'First-article inspection' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_stat_suffix', 'business days' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_stat_label', 'Minimum lead time' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_badges_label', 'Accepted file formats:' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_note', 'No drawing? Our engineers will help prepare the documentation and a 3D model for production.' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'label', 'Technical Specifications' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'title', 'Steel Plast delivers the full cycle of metal stamping — from your drawing to the finished part' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'desc_2', 'Stamping forms sheet metal into finished parts using dedicated tooling — dies mounted on crank presses. It is one of the fastest and most cost-effective methods of series production.' );

    // -- steelplast/service-metal-stamping/hero --
    icl_register_string( 'steelplast/service-metal-stamping/hero', 'title', 'Metal Stamping' );

    // -- steelplast/service-metal-stamping/content --
    icl_register_string( 'steelplast/service-metal-stamping/content', 'label', 'Cutting & Forming' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'title', 'Sheet Metal Cutting and Forming Services' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'intro', 'Steel Plast operates a fleet of stamping presses for cutting and forming sheet metal parts — from small brackets to structural components. Depending on the customer\'s needs, we can build a dedicated die or use a die supplied by the client.' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_1_heading', 'Sheet Metal Cutting' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_1_p1', 'Blanking and piercing separate the part contour from the sheet metal strip and form internal features — holes, slots and cutouts — in a single press stroke. The process is fast and repeatable, making it ideal for both prototype runs and high-volume production of flat parts.' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_1_p2', 'We also perform trimming and edge cutting to bring the part profile to the exact drawing specifications, keeping burr height and edge quality consistent across the entire production batch.' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_2_heading', 'Sheet Metal Forming' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_2_p1', 'Bending turns flat blanks into brackets, channels and enclosures, while deep drawing forms sheet metal into cylinders, housings and other three-dimensional shapes without cutting the material.' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_2_p2', 'Embossing adds stiffening ribs, louvers and other reinforcing features directly into the sheet, increasing part rigidity without additional material or a separate assembly step.' );

    // -- steelplast/service-metal-stamping/about --
    icl_register_string( 'steelplast/service-metal-stamping/about', 'tag', '[03] About us' );

    // -- steelplast/service-cnc-machining/hero --
    icl_register_string( 'steelplast/service-cnc-machining/hero', 'title', 'Metal Machining' );

    // -- steelplast/service-cnc-machining/about --
    icl_register_string( 'steelplast/service-cnc-machining/about', 'tag', '[03] About us' );

    // -- steelplast/service-mold-manufacturing/specs --
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_title', 'Mold & Die Types' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_subtitle', 'We manufacture:' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_item_1', 'Injection molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_1_item_1', 'Single-cavity molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_1_item_2', 'Multi-cavity molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_1_item_3', 'Two-plate and three-plate molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_1_item_4', 'Hot-runner molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_1_item_5', 'Overmolding molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_item_3', 'Prototype molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_item_5', 'Insert molds for metal and embedded components' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_item_2', 'Stamping dies' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_2_item_1', 'Blanking dies' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_2_item_2', 'Bending dies' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_2_item_3', 'Forming dies' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_2_item_4', 'Drawing dies' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_group_2_item_5', 'Compound dies' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_title', 'Manufacturing Processes' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_subtitle', 'Core operations' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_1_title', 'Machining' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_1_item_1', '3-axis and 5-axis CNC milling' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_1_item_2', 'CNC turning' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_1_item_3', 'Grinding' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_2_title', 'Finishing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_2_item_1', 'Wire and sinker EDM' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_2_item_2', 'Polishing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_2_item_4', 'Bench fitting' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_2_item_5', 'Assembly' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_title', 'Precision & Quality Control' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_subtitle', 'Tolerances we guarantee' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_stat_label', 'Machining tolerance' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_stat_value', '±0.005 mm' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_item_1', 'Incoming material inspection' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_item_2', 'Trial shots and sample testing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_item_3', 'In-process inspection' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_item_4', 'High-precision mechanical and optical measuring instruments' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_stat_value', 'from 1' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_stat_suffix', 'month' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_stat_label', 'Lead time' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_badges_label', 'Accepted file formats:' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_note', 'We also provide maintenance and repair of molds and dies already in production.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'label', 'Technical Specifications' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'title', 'Steel Plast delivers the full cycle of mold and die manufacturing — from your drawing to finished tooling' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'desc_1', 'We handle both one-off tooling orders and long-term production programs, keeping quality consistent at every stage.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'desc_2', 'Every injection mold and stamping die is designed and built in-house, from steel selection to trial samples. Alongside proven CNC machining and EDM processes, we ensure a stable process and tight tolerances, backed by a toolroom team capable of building tooling with complex geometry.' );

    // -- steelplast/service-mold-manufacturing/hero --
    icl_register_string( 'steelplast/service-mold-manufacturing/hero', 'title', 'Mold and Die Manufacturing' );

    // -- steelplast/service-mold-manufacturing/content --
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'label', 'Tooling Design & Manufacturing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'title', 'Mold and Die Manufacturing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'intro', 'Steel Plast designs and builds custom tooling in-house, which gives us full control over lead times, precision and cost. Depending on the part geometry, our engineers choose the mold design, steel grade and machining strategy that ensure a reliable, long-lasting tool.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_1_heading', 'Injection Mold Manufacturing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_1_p1', 'Mold manufacturing begins with the technical specification — a feasibility study and a review of the drawings or a sample of the required part. Next come mold design and 3D modeling, and the selection of a steel grade to match the required tool life. Then comes machining: milling and drilling, wire and sinker EDM, and grinding. The cycle is completed by polishing the molding surfaces and assembling the tool.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_1_p2', 'Trial shots and sample testing confirm that the mold is ready before it goes into series production, verifying that dimensions, surface quality and part cycle time meet the specification.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_2_heading', 'Stamping Die Manufacturing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_2_p1', 'Stamping dies are designed for a specific sheet metal operation — blanking, piercing, bending or deep drawing. They are made of hardened tool steel to withstand high-volume production.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_2_p2', 'We machine die components on CNC milling and EDM equipment, then fit, heat-treat and polish the tooling to extend die life and maintain consistent part quality throughout the entire production batch.' );

    // -- steelplast/service-mold-manufacturing/about --
    icl_register_string( 'steelplast/service-mold-manufacturing/about', 'tag', '[03] About us' );

    // -- steelplast/service-custom-tooling/specs --
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_title', 'Tooling Types' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_subtitle', 'We manufacture:' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_1', 'Assembly jigs and fixtures' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_2', 'Inspection and measuring gauges' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_3', 'Cutting tools' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_4', 'Welding fixtures' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_5', 'Custom test equipment' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_note', 'Built for your process, not picked from a catalog.' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_title', 'Design & Manufacturing Process' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_subtitle', 'Core operations' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_1_title', 'Design' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_1_item_1', 'Requirements analysis' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_1_item_2', '3D modeling' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_1_item_3', 'Design verification' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_2_title', 'Manufacturing' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_2_item_1', 'CNC milling and turning' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_2_item_2', 'Grinding' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_2_item_3', 'Assembly and calibration' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_title', 'Precision & Quality Control' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_subtitle', 'Tolerances we guarantee' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_stat_label', 'Machining tolerance' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_stat_value', '±0.005 mm' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_item_1', 'Calibration against reference standards' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_item_2', 'Repeatability testing' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_item_3', 'Material certification' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_item_4', 'Coordinate measuring machines (CMM)' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_stat_suffix', 'business days' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_stat_label', 'Minimum lead time' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_badges_label', 'Accepted file formats:' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_note', 'No drawing? Describe the task, and our engineers will design the tooling from scratch.' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'label', 'Technical Specifications' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'title', 'Steel Plast builds custom tooling and fixtures — from your requirements to finished equipment' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'desc_1', 'We handle both one-off requests and equipment for complete production lines, keeping quality consistent at every stage.' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'desc_2', 'Some tasks can\'t be solved with an off-the-shelf tool. We design and build jigs, fixtures, gauges and other custom equipment in-house, precisely for your process, instead of adapting your process to a catalog part.' );

    // -- steelplast/service-custom-tooling/hero --
    icl_register_string( 'steelplast/service-custom-tooling/hero', 'title', 'Custom Tooling and Fixtures Made to Order' );

    // -- steelplast/service-custom-tooling/content --
    icl_register_string( 'steelplast/service-custom-tooling/content', 'label', 'Custom Tooling' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'title', 'Custom Tooling and Fixtures for Non-Standard Applications' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'intro', 'Some tasks can\'t be solved with an off-the-shelf tool — a fixture to hold a non-standard part, a gauge to check a feature no catalog instrument can measure, or a jig that speeds up a repetitive assembly operation. Steel Plast designs and builds such tooling in-house, precisely for your process.' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_1_heading', 'Jigs and Fixtures' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_1_p1', 'Assembly and welding fixtures hold parts in a stable, repeatable position, removing manual alignment from your process and ensuring consistent cycle times and quality for every operator and shift.' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_1_p2', 'We design fixtures around your existing process — including quick-change elements when a single fixture has to support several part variants.' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_2_heading', 'Inspection and Measuring Gauges' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_2_p1', 'Custom gauges check features that standard measuring instruments can\'t reach or aren\'t designed for — a specific hole pattern, a contoured surface or a go/no-go check of a critical dimension.' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_2_p2', 'Every gauge is calibrated against a reference standard and tested for repeatability before it is introduced into your quality control process.' );

    // -- steelplast/service-custom-tooling/about --
    icl_register_string( 'steelplast/service-custom-tooling/about', 'tag', '[03] About us' );

    // -- steelplast/service-wire-products/hero --
    icl_register_string( 'steelplast/service-wire-products/hero', 'title', 'Springs and Wire Products' );

    // -- steelplast/service-wire-products/specs --
    icl_register_string( 'steelplast/service-wire-products/specs', 'label', 'Technical Specifications' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'title', 'Steel Plast manufactures springs and bent wire products — from your drawing or sample to a finished batch' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'desc_1', 'We produce small and medium batches, keeping the geometry identical on every part in the batch.' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'desc_2', 'A spring is rarely an off-the-shelf item: wire diameter, coil pitch, working load and installation dimensions are set by your assembly. We do the coiling, bending and heat treatment in-house, so the geometry is adapted to the part, not the other way around.' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_title', 'Spring Types' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_subtitle', 'We manufacture:' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_1', 'Compression springs' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_2', 'Extension springs' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_3', 'Torsion springs' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_4', 'Flat and shaped springs' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_5', 'Retaining rings and spring rings' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_note', 'Wire diameter from 0.4 to 2.5 mm; 0.5 to 2.0 mm for compression and extension springs.' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_title', 'Wire Products' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_subtitle', 'Core operations' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_1_title', 'Forming' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_1_item_1', 'Spring coiling' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_1_item_2', 'Custom wire forms' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_1_item_3', 'Rings, hooks and clips' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_2_title', 'Post-Processing' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_2_item_2', 'Heat treatment' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_2_item_3', 'Electroplating or powder coating' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_title', 'Materials & Precision' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_subtitle', 'We work with' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_stat_label', 'Geometry repeatability' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_stat_value', '±0.05 mm' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_item_1', 'Spring wire' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_item_2', 'Stainless steel' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_item_3', 'Galvanized and low-carbon wire' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_stat_value', 'from 7' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_stat_suffix', 'business days' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_stat_label', 'Lead time' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_badges_label', 'Accepted file formats:' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_note', 'No drawing? Send us a sample part, and we\'ll reproduce its geometry.' );

    // -- steelplast/service-wire-products/content --
    icl_register_string( 'steelplast/service-wire-products/content', 'label', 'Springs & Wire' );
    icl_register_string( 'steelplast/service-wire-products/content', 'title', 'Springs and Bent Wire Products for Industrial and Household Use' );
    icl_register_string( 'steelplast/service-wire-products/content', 'intro', 'A spring is rarely a stand-alone product — it works inside a lock, a furniture mechanism, a household appliance or an agricultural assembly, and it determines how long the entire assembly will last. We make such parts in small and medium batches, to a drawing or a sample.' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_1_heading', 'Custom Springs' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_1_p1', 'We coil compression, extension and torsion springs from wire 0.4 to 2 mm in diameter. Our calculations start from how the part works in the assembly: working load, travel, mounting diameters and the number of cycles it has to withstand.' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_1_p2', 'After coiling, every spring is stress-relieved by heat treatment — this step determines whether the part will keep its specified load after thousands of cycles.' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_1_p3', 'These springs work in furniture and lock mechanisms, household appliances, agricultural assemblies and machinery assemblies: wherever a part has to compress and return to its original shape thousands of times.' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_2_heading', 'Bent Wire Products' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_2_p1', 'Rings, clips, hooks, retainers, wire frames and baskets — custom wire forms made to your drawing.' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_2_p2', 'Finished products can be supplied with electroplating or powder coating, depending on where the part will work: indoors, in a humid environment or outdoors.' );

    // -- steelplast/service-wire-products/about --
    icl_register_string( 'steelplast/service-wire-products/about', 'tag', '[03] About us' );


    // -- steelplast/faq/intro --
    icl_register_string( 'steelplast/faq/intro', 'title', 'We want working with Steel Plast to be transparent and easy for you.' );
    icl_register_string( 'steelplast/faq/intro', 'desc', "Here you'll find answers to the questions our clients ask most often: about our products, orders and delivery.\nIf you can't find what you need, our team is always ready to help you personally." );

    // -- steelplast/faq/list --
    icl_register_string( 'steelplast/faq/list', 'q_1', 'What does Steel Plast manufacture?' );
    icl_register_string( 'steelplast/faq/list', 'a_1', 'We specialize in CNC metal machining (turning and milling) and in producing engineering plastic parts by injection molding, as well as designing and manufacturing injection molds. We offer machined metal parts, plastic and metal-plastic products, packaging, housings and components for the automotive, industrial, electrical, medical, agricultural, aerospace and construction industries.' );
    icl_register_string( 'steelplast/faq/list', 'q_2', 'Can you make an injection mold for our project?' );
    icl_register_string( 'steelplast/faq/list', 'a_2', 'Yes. We design and build injection molds in-house: from 3D modeling and CNC machining to trial shots and fine-tuning, in line with your project\'s specifications and volumes.' );
    icl_register_string( 'steelplast/faq/list', 'q_3', 'What is the minimum order quantity?' );
    icl_register_string( 'steelplast/faq/list', 'a_3', 'The minimum order quantity depends on the complexity of the part, the cost of the mold and the material. We review every request individually. Send us your drawing, and we will propose the optimal production scenario.' );
    icl_register_string( 'steelplast/faq/list', 'q_4', 'What clamping force range do your injection molding machines cover?' );
    icl_register_string( 'steelplast/faq/list', 'a_4', 'Our injection molding machines cover a clamping force range of 35 to 400 metric tons, which allows us to produce parts of various sizes, from small precision components to large housings and structural parts.' );
    icl_register_string( 'steelplast/faq/list', 'q_5', 'What materials do you work with?' );
    icl_register_string( 'steelplast/faq/list', 'a_5', 'We work with a wide range of engineering plastics (pellets): polypropylene (PP), ABS, polyamide (PA6, PA66), polycarbonate (PC), polyethylenes (LDPE, HDPE), TPE / TPU / TPV, PS / HIPS, POM, SAN and PVC, as well as their reinforced and filled grades, selected to suit the requirements of your part.' );
    icl_register_string( 'steelplast/faq/list', 'q_6', 'Do you offer two-component molding or insert molding?' );
    icl_register_string( 'steelplast/faq/list', 'a_6', 'Yes, we offer two-component (2K) molding and insert molding, which allow us to combine materials or embed metal inserts directly during the molding cycle.' );
    icl_register_string( 'steelplast/faq/list', 'q_7', 'How do you ensure dimensional stability and minimal warpage?' );
    icl_register_string( 'steelplast/faq/list', 'a_7', 'Every mold and process is validated through trial shots and part-by-part measurement. We control shrinkage and warpage from the design stage and monitor dimensional stability throughout the entire molding cycle.' );
    icl_register_string( 'steelplast/faq/list', 'q_8', 'What is the typical service life of a mold?' );
    icl_register_string( 'steelplast/faq/list', 'a_8', 'Mold service life depends on the tool steel grade, part geometry and production volume, and is confirmed individually for each project. We design every mold for reliable, repeatable production throughout its entire service life.' );
    icl_register_string( 'steelplast/faq/list', 'q_9', 'What quality control stages does production go through?' );
    icl_register_string( 'steelplast/faq/list', 'a_9', 'Every batch goes through several inspection stages: incoming material inspection, in-process monitoring during the molding cycle, and final dimensional and visual inspection before shipment, in accordance with ISO 9001.' );
    icl_register_string( 'steelplast/faq/list', 'q_10', 'How do I place an order?' );
    icl_register_string( 'steelplast/faq/list', 'a_10', 'Send us your drawings or samples via the form on our Contact page or by email. Our team will review the details and get back to you with production options within 2 hours. We accept files in STEP, PDF and x_t formats.' );

    // -- steelplast/service-injection-molding/specs --
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_title', 'Materials' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_subtitle', 'We mold:' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_1', 'Polypropylene (PP)' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_2', 'ABS' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_3', 'Polyamide (PA6, PA66)' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_4', 'Polycarbonate (PC)' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_5', 'Polyethylenes (LDPE, HDPE)' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_6', 'TPE / TPU / TPV' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_7', 'PS / HIPS' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_8', 'POM' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_9', 'SAN' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_10', 'PVC' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_title', 'Molding Processes' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_subtitle', 'Core capabilities' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_1_item_1', 'Single-component molding' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_1_item_2', 'Insert molding' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_1_item_3', 'Metal insert molding' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_2_item_1', 'Molding with mold temperature control' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_title', 'Precision & Quality Control' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_subtitle', 'Dimensional stability we guarantee' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_stat_label', 'Molding tolerance' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_stat_value', '±0.05 mm' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_item_1', 'Incoming raw material inspection' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_item_2', 'Shrinkage and warpage control' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_item_3', 'First-shot inspection' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_item_4', 'Production to a part-specific checklist' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_title', 'Equipment & Terms' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_stat_suffix', 't' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_stat_label', 'Clamping force range' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_stat2_suffix', 'cm³' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_stat2_label', 'Shot volume' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_dimensions', 'Mold dimensions: from 250×200 mm to 750×1200 mm' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_badges_label', 'Accepted file formats:' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_note', 'No mold yet? We design and build the mold in-house — from 3D model to first shot.' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'label', 'Technical Specifications' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'title', 'Steel Plast delivers the full cycle of plastic injection molding — from material selection to the finished part' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'desc_2', 'Plastic injection molding is a process in which molten plastic is injected under pressure into a mold cavity by an injection molding machine. Unlike 3D printing, it is the most cost-effective way to produce plastic parts in large volumes.' );

    // -- steelplast/service-injection-molding/hero --
    icl_register_string( 'steelplast/service-injection-molding/hero', 'title', 'Plastic Injection Molding' );

    // -- steelplast/service-injection-molding/content --
    icl_register_string( 'steelplast/service-injection-molding/content', 'label', 'Molding Capabilities' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'title', 'Injection Molding Process and Capabilities' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'intro', 'Steel Plast operates a modern fleet of injection molding machines, giving us the flexibility to produce plastic parts — from small precision components to large housings. Whatever your drawing requires, our engineers select the material, process and mold design that deliver the best precision and the shortest lead times.' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_1_heading', 'Injection Molding' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_1_p1', 'Injection molding melts plastic pellets and injects them under pressure into a mold cavity, where the part cools and solidifies before ejection. The process is fast, repeatable and cost-effective at high volumes, which makes it the standard choice for producing plastic parts in batches from a few hundred to millions of pieces.' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_1_p2', 'We control every molding cycle — melt temperature, injection speed and clamping force — to maintain dimensional stability and cycle repeatability throughout the entire production batch.' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_2_heading', 'Insert Molding' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_2_p1', 'Insert molding embeds a metal or plastic insert directly in the part during the molding cycle, combining materials in a single component without a separate assembly step.' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_2_p2', 'Overmolding: a finished plastic part is placed in a mold and another polymer is molded over it. This combines the properties of the selected materials in a single part.' );

    // -- steelplast/service-injection-molding/about --
    icl_register_string( 'steelplast/service-injection-molding/about', 'tag', '[03] About us' );

    // -- steelplast/about/intro --
    icl_register_string( 'steelplast/about/intro', 'label', 'Steel Plast is' );
    icl_register_string( 'steelplast/about/intro', 'title', 'Modern Manufacturing in Light Engineering' );
    icl_register_string( 'steelplast/about/intro', 'desc_1', 'We bring the key manufacturing processes together in one place: metalworking, mold making, metal stamping and plastic injection molding. We take on a project at any stage — from concept and engineering development to series launch and finished products.' );
    icl_register_string( 'steelplast/about/intro', 'desc_2', 'A full cycle under one roof means fewer handoffs, more control and a clear result at every stage.' );
    icl_register_string( 'steelplast/about/intro', 'desc_3', 'Our facility is equipped with modern high-precision machinery, including CNC turning, milling and EDM machines, injection molding machines and stamping presses. This allows us to deliver projects of any complexity while meeting the highest standards of quality and precision.' );

    // -- steelplast/about/audience --
    icl_register_string( 'steelplast/about/audience', 'label', 'Why Choose Us' );
    icl_register_string( 'steelplast/about/audience', 'title', 'Who We Manufacture For' );
    icl_register_string( 'steelplast/about/audience', 'desc_1', 'Our clients include manufacturing companies, machinery manufacturers, engineering design firms, startups, manufacturers of furniture and construction products, and other businesses that need high-quality metal or plastic components.' );
    icl_register_string( 'steelplast/about/audience', 'desc_2', 'We believe successful manufacturing starts with a reliable partnership. That is why Steel Plast is not just a contractor but a team that takes responsibility for the result and helps clients solve their most complex production challenges.' );

    // -- steelplast/about/advantages --
    icl_register_string( 'steelplast/about/advantages', 'label', 'Our Advantages' );
    icl_register_string( 'steelplast/about/advantages', 'title', 'We combine modern technology, team experience
and quality control at every stage of production.' );

    // -- steelplast/about/advantages-cards --
    icl_register_string( 'steelplast/about/advantages-cards', 'card_1_title', 'Full Production Cycle' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_1_desc', 'We carry out the full scope of work — from engineering design and documentation to manufacturing the finished product.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_2_title', 'Modern Equipment' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_2_desc', 'We use high-precision equipment and technologies that ensure consistent quality and accuracy for every part.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_3_title', 'Experienced Team' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_3_desc', 'Every project is handled by qualified engineers, design engineers and process engineers with many years of experience.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_4_title', 'Tailored Approach' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_4_desc', 'We develop solutions that take into account technical requirements, production specifics and the client\'s goals.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_5_title', 'Quality Control' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_5_desc', 'We carry out quality control at every stage of production, guaranteeing compliance with technical standards.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_6_title', 'Flexible Production' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_6_desc', 'We handle one-off orders and prototypes as well as large production runs.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_7_title', 'On-Time Delivery' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_7_desc', 'Optimized production processes allow us to complete orders within the agreed deadlines without compromising quality.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_8_title', 'Reliable Partnership' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_8_desc', 'We build long-term relationships with clients, ensuring open communication and a responsible approach to every project.' );

    // -- steelplast/about/equipment --
    icl_register_string( 'steelplast/about/equipment', 'label', 'Our Equipment' );
    icl_register_string( 'steelplast/about/equipment', 'title', 'Modern manufacturing requires modern technology' );
    icl_register_string( 'steelplast/about/equipment', 'desc', 'That is why Steel Plast uses high-precision automated equipment that enables us to deliver products of the highest quality.' );

    // -- steelplast/about/equipment-cards --
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_title', 'Swiss-Type Automatic Lathes' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_lead', 'What they do:' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_bullet_1', 'Produce small, high-precision parts — pins, shafts, screws and components for medical devices, watches and electronics.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_bullet_2', 'Turn, mill, drill and cut threads.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_bullet_3', 'Run fully automatically without an operator — just load the bar stock.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_2_title', 'Crank Stamping Presses' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_2_desc_1', 'A crank stamping press is a machine that forms, bends, cuts and draws metal by compressive force.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_2_desc_2', 'Key advantages: productivity, energy efficiency and high repeatability.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_3_title', 'Injection Molding Machines' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_3_lead', 'How does it work?' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_3_desc_1', 'Plastic pellets are fed into the machine, melted to a liquid state and injected into the mold under high pressure.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_4_title', 'Wire and Sinker EDM Machines' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_4_desc_1', 'EDM, or electrical discharge machining, shapes metal not with a cutting tool or milling cutter but with an electric spark that erodes it with micron-level precision.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_title', '5-Axis CNC Milling Machines' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_lead', 'What they do:' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_bullet_1', 'Mill, drill and cut complex shapes.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_bullet_2', 'Produce 3D surfaces, blades, housings and other complex parts.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_bullet_3', 'Work with metal, plastic and composite materials.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_6_title', 'CNC Mill-Turn Machines' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_6_lead', 'What they do:' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_6_bullet_1', 'Turning, milling, drilling, threading — all in a single setup!' );

    // -- steelplast/service-cnc-machining/specs --
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'label', 'Technical Specifications' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'title', 'Steel Plast delivers the full cycle of CNC metal machining — from your drawing to the finished part' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'desc_1', 'We handle both one-off orders and series production, keeping quality consistent at every stage.' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'desc_2', 'CNC metal machining is based on computer numerical control — the foundation of modern precision manufacturing. Alongside proven turning and milling processes, we ensure a stable process and tight tolerances, backed by a team capable of machining parts with complex geometry.' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_title', 'Materials' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_subtitle', 'We machine:' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_1', 'Structural steel' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_2', 'Tool steel' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_3', 'Stainless steel' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_4', 'Aluminum' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_5', 'Brass' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_6', 'Copper' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_7', 'Titanium' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_note', 'Part diameters from 0.5 mm.' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_title', 'Machining Types' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_subtitle', 'Core operations' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_1_title', 'Turning' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_1_item_1', 'External and internal turning' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_1_item_2', 'Threading' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_1_item_3', 'Grooving and parting off' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_title', 'Milling' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_item_1', 'Face milling' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_item_2', 'Slot and pocket milling' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_item_3', 'Complex contours' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_item_4', '3D milling' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_title', 'Precision & Quality Control' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_subtitle', 'Tolerances we guarantee' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_stat_label', 'Machining tolerance' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_stat_value', '±0.005 mm' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_item_1', 'Incoming material inspection' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_item_2', 'Part geometry inspection' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_item_3', 'Calibrated tooling' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_item_4', 'Optical measuring instruments' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_stat_value', 'from 2' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_stat_suffix', 'weeks' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_stat_label', 'Project launch' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_badges_label', 'Accepted file formats:' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_note', 'No drawing? Our engineers will help prepare the documentation and a 3D model for production.' );

    // -- steelplast/service-cnc-machining/content --
    icl_register_string( 'steelplast/service-cnc-machining/content', 'label', 'CNC Milling & Turning' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'title', 'CNC Milling and Turning Services' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'intro', 'Steel Plast operates a fleet of CNC milling and turning machines, which allows us to machine parts of virtually any geometry — from flat brackets to complex rotational parts. Whatever your drawing requires, our engineers select the process, tooling and setup that deliver the best precision and the shortest lead times.' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_1_heading', 'CNC Milling' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_1_p1', 'Our CNC machining centers mill material from a solid workpiece to produce flat surfaces, pockets, slots and complex 3D contours with high precision. Multi-axis milling lets us machine undercuts and curved surfaces in a single setup, which shortens lead times and keeps dimensions consistent across the entire part.' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_1_p2', 'CNC milling is our core technology for producing housings, brackets, plates and mold components. We machine both prototypes and production batches at high speed.' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_2_heading', 'CNC Turning' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_2_p1', 'CNC turning rotates the workpiece against a cutting tool to produce cylindrical and other rotational shapes — shafts, bushings, flanges, pins and threaded parts. Our machines perform external and internal turning, threading, grooving and parting off in a single cycle, minimizing the number of setups.' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_2_p2', 'Finished parts are widely used in the automotive industry, industrial equipment and fasteners, where round geometry and axial precision matter most. We manufacture parts from steel, stainless steel, aluminum, copper and brass, and can combine turning with subsequent milling for parts that need both round and flat features.' );
}
add_action( 'after_setup_theme', 'steelplast_register_wpml_strings' );

/**
 * Helper: get translated string by context + key.
 * Usage: steelplast_t( 'steelplast/home/hero', 'title', 'Design Manufacture Scale' )
 */
function steelplast_t( $context, $name, $default ) {
    if ( function_exists( 'icl_t' ) ) {
        return icl_t( $context, $name, $default );
    }
    return $default;
}

/**
 * Get an ACF field from the default-language post.
 *
 * Media/config fields (images, files, video, map embed URLs, contact
 * details) carry no translatable text, so a single value should apply to
 * every WPML language instead of needing to be re-entered per translation.
 *
 * Usage: steelplast_get_field_default_lang( 'page_hero_image' )
 */
function steelplast_get_field_default_lang( $selector, $post_id = null ) {
    if ( ! function_exists( 'get_field' ) ) {
        return false;
    }

    $post_id = $post_id ?: get_the_ID();

    if ( function_exists( 'icl_object_id' ) ) {
        $default_lang = apply_filters( 'wpml_default_language', null );
        $original_id  = $default_lang ? icl_object_id( $post_id, get_post_type( $post_id ), true, $default_lang ) : 0;
        if ( $original_id ) {
            $post_id = $original_id;
        }
    }

    return get_field( $selector, $post_id );
}

/**
 * Permalink of a page addressed by its default-language slug.
 *
 * Slugs are translated per language, so hard-coding a path breaks the link in
 * every language but one. Callers name the page once, by its slug in the
 * default language, and WPML resolves the translation being rendered.
 *
 * Usage: steelplast_page_url( 'контакти' )
 */
function steelplast_page_url( $slug ) {
    static $cache = array();

    if ( array_key_exists( $slug, $cache ) ) {
        return $cache[ $slug ];
    }

    $page = get_page_by_path( $slug );
    $id   = $page ? (int) $page->ID : 0;

    // get_page_by_path() is not language-aware and may hand back any
    // translation, so normalise to the original post before mapping forward.
    if ( $id && function_exists( 'icl_object_id' ) ) {
        $default = apply_filters( 'wpml_default_language', null );
        $id      = ( $default ? (int) icl_object_id( $id, 'page', true, $default ) : 0 ) ?: $id;
        $id      = (int) apply_filters( 'wpml_object_id', $id, 'page', true ) ?: $id;
    }

    $cache[ $slug ] = $id ? get_permalink( $id ) : home_url( '/' );

    return $cache[ $slug ];
}

/**
 * One hero counter: the figure as of today, plus how to render it.
 *
 * The editor stores a measured value, the date it was measured and a daily
 * increment, so the page keeps counting without anyone touching the admin.
 * The result is rounded DOWN to the displayed precision on purpose: at 0.1m
 * steps 2,790,000 still reads "2.7m" and only becomes "2.8m" once it is
 * genuinely past 2.8m, which is what the client asked for.
 *
 * @return array{value:float,decimals:int,suffix:string,text:string}|null
 */
function steelplast_hero_stat( $index ) {
    $base = steelplast_get_field_default_lang( "hero_stat_{$index}_base" );
    if ( $base === false || $base === null || $base === '' ) {
        return null;
    }

    $per_day = (float) steelplast_get_field_default_lang( "hero_stat_{$index}_per_day" );
    $since   = steelplast_get_field_default_lang( "hero_stat_{$index}_since" );
    $format  = steelplast_get_field_default_lang( "hero_stat_{$index}_format" ) ?: 'plain';

    $raw = (float) $base;

    if ( $per_day && $since ) {
        $tz    = wp_timezone();
        $start = DateTimeImmutable::createFromFormat( 'Ymd|', (string) $since, $tz );
        $today = new DateTimeImmutable( 'today', $tz );

        // A base date in the future means the figure has not started growing yet.
        if ( $start && $start < $today ) {
            $raw += $per_day * (int) $start->diff( $today )->format( '%a' );
        }
    }

    // [ divisor, decimals, unit pattern ] — the pattern is translated because
    // both the unit and its spacing differ: 10.9M, 10,9 млн, 10,9 Mio.
    $formats = [
        'millions'  => [ 1000000, 1, steelplast_t( 'steelplast/home/hero', 'format_millions', '%sM' ) ],
        'thousands' => [ 1000,    0, steelplast_t( 'steelplast/home/hero', 'format_thousands', '%sK' ) ],
        'plain'     => [ 1,       0, '%s' ],
    ];
    [ $divisor, $decimals, $unit ] = $formats[ $format ] ?? $formats['plain'];

    $step  = $divisor / pow( 10, $decimals );   // smallest visible increment
    $value = floor( $raw / $step ) * $step / $divisor;

    // Only the decimal mark is localised. The figures never reach the
    // thousands, and WordPress's Polish thousands separator is wrong anyway.
    global $wp_locale;
    $point = $wp_locale->number_format['decimal_point'] ?? '.';

    return [
        'value'    => $value,
        'decimals' => $decimals,
        'unit'     => $unit,
        'point'    => $point,
        'text'     => sprintf( $unit, number_format( $value, $decimals, $point, '' ) ),
    ];
}

if ( function_exists( 'icl_get_languages' ) || defined( 'ICL_SITEPRESS_VERSION' ) ) {
    add_filter( 'icl_show_translate_link', '__return_false' );
    add_filter( 'wpml_show_footer_language_selector', '__return_false' );
    add_filter( 'wpml_footer_language_selector', '__return_false' );

    // x-default is for visitors whose language the site lacks — foreign
    // buyers, whom English serves better than the Ukrainian original.
    add_filter( 'wpml_hreflangs', function ( $items ) {
        if ( isset( $items['en'] ) ) {
            $items['x-default'] = $items['en'];
        }
        return $items;
    } );
    remove_action( 'wp_footer', array( 'SitePress', 'footer_language_selector' ) );

    add_action( 'wp_footer', function () {
        echo '<style>
            #wpml-footer-language-switcher,
            .wpml-ls-statics-footer,
            .wpml-ls-legacy-list-horizontal,
            .wpml-ls-legacy-dropdown,
            .otgs-development-site-notice,
            .otgs-is-showing-dev-site-notice,
            #otgs-development-site-notice { display: none !important; }
        </style>';
    }, 999 );
}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function steelplast_post_thumbnail() {
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        return;
    }

    if ( is_singular() ) :
        ?>

        <div class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div><!-- .post-thumbnail -->

    <?php else : ?>

        <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php
                the_post_thumbnail(
                    'post-thumbnail',
                    array(
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
            ?>
        </a>

        <?php
    endif; // End is_singular().
}

/**
 * Estimated reading time for a post, in whole minutes (minimum 1).
 * Uses a unicode-aware word split so Cyrillic content is counted correctly.
 */
function steelplast_reading_time( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $content = wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $post_id ) ) );
    $words   = preg_split( '/\s+/u', trim( $content ), -1, PREG_SPLIT_NO_EMPTY );

    return max( 1, (int) ceil( count( $words ) / 200 ) );
}

// =============================================
// Language Switcher
// =============================================

function steelplast_language_switcher() {
    if ( ! function_exists( 'icl_get_languages' ) ) {
        echo '<span class="sp-lang">UA</span>';
        return;
    }

    $languages = icl_get_languages( 'skip_missing=0' );
    if ( empty( $languages ) ) return;

    $current_lang = reset( $languages ); // fallback: перша мова
    foreach ( $languages as $lang ) {
        if ( $lang['active'] ) {
            $current_lang = $lang;
            break;
        }
    }

    // "UK" reads as the United Kingdom to the English-speaking visitors who
    // most need the switcher, so Ukrainian is labelled by its country code.
    $label = function ( $code ) {
        return 'uk' === $code ? 'UA' : strtoupper( $code );
    };

    $current_code = esc_html( $label( $current_lang['language_code'] ) );
    ?>
    <div class="sp-lang sp-has-dropdown">
        <button type="button" class="sp-lang__toggle sp-dropdown__toggle" aria-expanded="false" aria-haspopup="true">
            <?php if ( ! empty( $current_lang['country_flag_url'] ) ) : ?>
                <img src="<?php echo esc_url( $current_lang['country_flag_url'] ); ?>" alt="" width="18" height="14" aria-hidden="true">
            <?php endif; ?>
            <?php echo $current_code; ?>
            <svg class="sp-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" aria-hidden="true" focusable="false">
                <path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <ul class="sp-lang__dropdown" role="menu">
            <?php foreach ( $languages as $lang ) : ?>
                <li role="none">
                    <a href="<?php echo esc_url( $lang['url'] ); ?>" role="menuitem" lang="<?php echo esc_attr( $lang['language_code'] ); ?>" <?php echo $lang['active'] ? 'aria-current="true"' : ''; ?>>
                        <?php if ( ! empty( $lang['country_flag_url'] ) ) : ?>
                            <img src="<?php echo esc_url( $lang['country_flag_url'] ); ?>" alt="" width="18" height="14" aria-hidden="true">
                        <?php endif; ?>
                        <?php echo esc_html( $label( $lang['language_code'] ) ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}

// =============================================
// Nav Walker — dropdown support
// =============================================

class SteelPlast_Nav_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item         = $data_object;
        $has_children = in_array( 'menu-item-has-children', (array) $item->classes, true );

        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'sp-nav__item';
        if ( $has_children ) {
            $classes[] = 'sp-has-dropdown';
        }
        $class_names = implode( ' ', array_filter( array_map( 'esc_attr', $classes ) ) );

        $output .= '<li class="' . $class_names . '">';

        if ( $has_children && 0 === $depth ) {
            // Render as button so dropdown is keyboard-accessible
            $output .= '<button type="button" class="sp-dropdown__toggle" aria-expanded="false" aria-haspopup="true">';
            $output .= esc_html( $item->title );
            $output .= '<svg class="sp-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" aria-hidden="true" focusable="false">';
            $output .= '<path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>';
            $output .= '</svg>';
            $output .= '</button>';
        } else {
            $url          = ! empty( $item->url ) ? esc_url( $item->url ) : '#';
            $aria_current = ( $item->current ) ? ' aria-current="page"' : '';
            // Flag the home link explicitly — under WPML with language
            // directories its path (e.g. "/en/") is a prefix of every other
            // page's path, so the JS active-state matcher needs an exact
            // match here instead of the usual "starts with" match. Compare
            // paths only (not full URLs) so scheme/host differences don't
            // cause a false negative.
            $item_path  = untrailingslashit( (string) wp_parse_url( $item->url, PHP_URL_PATH ) );
            $home_path  = untrailingslashit( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ) );
            $is_home    = $item_path && $item_path === $home_path;
            $home_attr  = $is_home ? ' data-nav-home="1"' : '';
            $output    .= '<a href="' . $url . '"' . $aria_current . $home_attr . '>';
            $output    .= esc_html( $item->title );
            $output    .= '</a>';
        }
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="sp-nav__dropdown" role="menu">';
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</ul>';
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}

/**
 * Fallback when no menu is assigned to 'primary' location.
 * Shows nothing — menu must be configured in WP Admin → Appearance → Menus.
 * WPML handles translations per language automatically.
 */
function steelplast_fallback_nav() {
    if ( current_user_can( 'manage_options' ) ) {
        printf(
            '<p class="nav-fallback-notice"><a href="%s">%s</a></p>',
            esc_url( admin_url( 'nav-menus.php' ) ),
            esc_html__( 'Призначте меню для локації «Primary»', 'steelplast' )
        );
    }
}