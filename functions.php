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

    // Scroll-reveal animations — lightweight, sitewide, no dependencies.
    $animations_js = get_template_directory() . '/assets/js/animations.js';
    wp_enqueue_script(
        'steelplast-animations',
        get_template_directory_uri() . '/assets/js/animations.js',
        array(),
        file_exists( $animations_js ) ? filemtime( $animations_js ) : STEELPLAST_VERSION,
        true
    );

    // Hero counters — front page only.
    if ( is_front_page() ) {
        $counter_js = get_template_directory() . '/assets/js/hero-counter.js';
        wp_enqueue_script(
            'steelplast-hero-counter',
            get_template_directory_uri() . '/assets/js/hero-counter.js',
            array(),
            file_exists( $counter_js ) ? filemtime( $counter_js ) : STEELPLAST_VERSION,
            true
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
    wp_localize_script( 'steelplast-contact', 'spContact', array(
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'flagsUrl1x' => get_template_directory_uri() . '/assets/img/flags.webp',
        'flagsUrl2x' => get_template_directory_uri() . '/assets/img/flags@2x.webp',
        'i18n'    => array(
            'nameRequired' => steelplast_t( 'steelplast/contacts/form', 'err_name_required', 'Please enter your name' ),
            'emailOrPhone' => steelplast_t( 'steelplast/contacts/form', 'err_email_or_phone', 'Please enter email or phone' ),
            'emailInvalid' => steelplast_t( 'steelplast/contacts/form', 'err_email_invalid', 'Invalid email address' ),
            'phoneInvalid' => steelplast_t( 'steelplast/contacts/form', 'err_phone_invalid', 'Enter full phone number' ),
            'serverError'  => steelplast_t( 'steelplast/contacts/form', 'err_server', 'Something went wrong. Please try again.' ),
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

// Collaboration JS — front page + any page using the collaboration/steps section
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_front_page() && ! is_page_template( 'page-templates/template-quality.php' ) ) return;
    $collab_js = get_template_directory() . '/assets/js/collaboration.js';
    wp_enqueue_script(
        'steelplast-collaboration',
        get_template_directory_uri() . '/assets/js/collaboration.js',
        array(),
        file_exists( $collab_js ) ? filemtime( $collab_js ) : STEELPLAST_VERSION,
        true
    );
} );

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
    icl_register_string( 'steelplast/global/header', 'contacts', 'Contacts' );
    icl_register_string( 'steelplast/global/header', 'cta',      'Get in touch' );

    // -- steelplast/global/footer --
    icl_register_string( 'steelplast/global/footer', 'description',  'We specialize in supplying high-quality components for the automotive, medical, household, electrical, furniture and construction industries.' );
    icl_register_string( 'steelplast/global/footer', 'menu_title',   'MENU' );
    icl_register_string( 'steelplast/global/footer', 'social_title', 'FOLLOW US' );
    icl_register_string( 'steelplast/global/footer', 'copyright',    'All rights reserved.' );
    // Social URLs are managed via Customizer → Site Settings → Social Media

    // -- steelplast/global/modal-contact -- quick-contact modal, triggerable
    // from any page via data-sp-modal-open="quick-contact" (see header CTA, single.php)
    icl_register_string( 'steelplast/global/modal-contact', 'title',      'Get in touch' );
    icl_register_string( 'steelplast/global/modal-contact', 'desc',       'Leave your contact details and we will get back to you shortly.' );
    icl_register_string( 'steelplast/global/modal-contact', 'close_aria', 'Close' );

    // -- steelplast/home/hero --
    icl_register_string( 'steelplast/home/hero', 'title',       'Design Manufacture Scale' );
    icl_register_string( 'steelplast/home/hero', 'description', 'STEELPLAST takes on the whole route — from concept to series production, whatever the complexity or scale.' );
    icl_register_string( 'steelplast/home/hero', 'stat_1_label', 'Plastic parts manufactured' );
    icl_register_string( 'steelplast/home/hero', 'stat_2_label', 'Metal parts manufactured' );
    icl_register_string( 'steelplast/home/hero', 'stat_3_label', 'Projects delivered in 2025/2026' );

    // -- steelplast/contacts/page --
    icl_register_string( 'steelplast/contacts/page', 'emails_heading',    'Email' );
    icl_register_string( 'steelplast/contacts/page', 'phones_heading',    'Phone' );
    icl_register_string( 'steelplast/contacts/page', 'locations_heading', 'Our locations' );
    icl_register_string( 'steelplast/contacts/page', 'location_label',   'Head office and production' );
    icl_register_string( 'steelplast/contacts/page', 'location_address', "Avtobazivska St., 2/9\nPoltava, 36000\nPoltava region, Ukraine" );

    // Email labels
    icl_register_string( 'steelplast/contacts/page', 'email_1_label', 'General inquiries and orders' );
    icl_register_string( 'steelplast/contacts/page', 'email_2_label', 'Supply department' );

    // Phone labels
    icl_register_string( 'steelplast/contacts/page', 'phone_1_label', 'Sales department (consultations and orders)' );
    icl_register_string( 'steelplast/contacts/page', 'phone_2_label', 'Technical department (drawing questions)' );
    icl_register_string( 'steelplast/contacts/page', 'phone_3_label', 'Partner hotline' );

    // -- steelplast/news/single --
    icl_register_string( 'steelplast/news/single', 'back_label',      'Back to news' );
    icl_register_string( 'steelplast/news/single', 'date_label',      'Date created' );
    icl_register_string( 'steelplast/news/single', 'read_time_label', 'Reading time' );
    icl_register_string( 'steelplast/news/single', 'read_time_value', '%d minutes' );
    icl_register_string( 'steelplast/news/single', 'tags_label',      'Tags' );

    // -- steelplast/news/header --
    icl_register_string( 'steelplast/news/header', 'news_label',   'Articles & News' );
    icl_register_string( 'steelplast/news/header', 'news_title',   "Stay up to date\nwith company news" );
    icl_register_string( 'steelplast/news/header', 'news_desc',    'Follow company news, production updates, and completed projects.' );
    icl_register_string( 'steelplast/news/header', 'news_all_btn', 'All articles' );

    // -- steelplast/news/archive --
    icl_register_string( 'steelplast/news/archive', 'filter_label',  'Categories' );
    icl_register_string( 'steelplast/news/archive', 'filter_all',    'All articles' );
    icl_register_string( 'steelplast/news/archive', 'archive_empty', 'No articles yet. Check back soon.' );

    // -- steelplast/post-card --
    icl_register_string( 'steelplast/post-card', 'read_more', 'Read more' );

    // -- steelplast/contacts/hero --
    icl_register_string( 'steelplast/contacts/hero', 'contact_hero_title', 'Still have questions?' );
    icl_register_string( 'steelplast/contacts/hero', 'contact_hero_desc',  'Leave your request and we will get in touch.' );

    // -- steelplast/contacts/form --
    icl_register_string( 'steelplast/contacts/form', 'contact_form_aria',         'Contact form' );
    icl_register_string( 'steelplast/contacts/form', 'field_name_placeholder',    'Your name' );
    icl_register_string( 'steelplast/contacts/form', 'field_email_placeholder',   'E-mail' );
    icl_register_string( 'steelplast/contacts/form', 'field_phone_placeholder',   'Phone' );
    icl_register_string( 'steelplast/contacts/form', 'field_comment_placeholder', 'Your message (optional)' );
    icl_register_string( 'steelplast/contacts/form', 'submit_label',              'Send request' );
    icl_register_string( 'steelplast/contacts/form', 'success_message',           'Thank you! We will contact you soon.' );
    icl_register_string( 'steelplast/contacts/form', 'err_name_required',         'Please enter your name' );
    icl_register_string( 'steelplast/contacts/form', 'err_email_or_phone',        'Please enter email or phone' );
    icl_register_string( 'steelplast/contacts/form', 'err_email_invalid',         'Invalid email address' );
    icl_register_string( 'steelplast/contacts/form', 'err_phone_invalid',         'Enter full phone number' );
    icl_register_string( 'steelplast/contacts/form', 'err_server',                'Something went wrong. Please try again.' );
    icl_register_string( 'steelplast/contacts/form', 'err_rate_limit',            'Too many requests. Please wait a moment.' );
    icl_register_string( 'steelplast/contacts/form', 'err_send_failed',           'Failed to send email. Please try again later.' );

    // -- steelplast/home/about-preview --
    icl_register_string( 'steelplast/home/about-preview', 'tag',         '[02] About us' );
    icl_register_string( 'steelplast/home/about-preview', 'title',       'We turn drawings into parts, and parts into series' );
    icl_register_string( 'steelplast/home/about-preview', 'description', 'STEELPLAST brings together CNC metal machining, mold design and manufacture, and series production of plastic components. 10+ years of building things that work.' );
    icl_register_string( 'steelplast/home/about-preview', 'button',      'Learn more about us' );

    // -- steelplast/home/services --
    icl_register_string( 'steelplast/home/services', 'section_label',   'Services' );
    icl_register_string( 'steelplast/home/services', 'title',           'Modern equipment, manufacturing precision and quality control' );
    icl_register_string( 'steelplast/home/services', 'cta_label',       'Learn more' );
    icl_register_string( 'steelplast/home/services', 'card_1_title',    'Metal Stamping' );
    icl_register_string( 'steelplast/home/services', 'card_1_desc',     'Sheet metal stamping — blanking, bending and drawing.' );
    icl_register_string( 'steelplast/home/services', 'card_2_title',    'Plastic Injection Molding' );
    icl_register_string( 'steelplast/home/services', 'card_2_desc',     'Plastic injection molding on modern machines — from prototypes to series production.' );
    icl_register_string( 'steelplast/home/services', 'card_3_title',    'Molds & Dies' );
    icl_register_string( 'steelplast/home/services', 'card_3_desc',     'Design and manufacture of molds and dies — from enquiry to finished product.' );
    icl_register_string( 'steelplast/home/services', 'card_4_title',    'CNC Metal Machining' );
    icl_register_string( 'steelplast/home/services', 'card_4_desc',     'CNC turning and milling for complex parts — from a single piece to series production.' );
    icl_register_string( 'steelplast/home/services', 'card_5_title',    'Custom Tooling' );
    icl_register_string( 'steelplast/home/services', 'card_5_desc',     'Assembly fixtures, inspection gauges and jigs, designed and built for your process.' );
    icl_register_string( 'steelplast/home/services', 'card_6_title',     'Springs & Wire Products' );
    icl_register_string( 'steelplast/home/services', 'card_6_desc',      'Made-to-order springs and formed wire parts, from a drawing or a sample.' );

    // -- steelplast/collaboration/header --
    icl_register_string( 'steelplast/collaboration/header', 'collab_label',   'Collaboration' );
    icl_register_string( 'steelplast/collaboration/header', 'collab_title',   "LET'S BUILD SOMETHING THAT HAS TO WORK." );
    icl_register_string( 'steelplast/collaboration/header', 'collab_desc_1',  'You come to us with an idea, a drawing or a specific production problem — we help you find the route to a finished product. We see the project through, start production and scale it.' );

    // -- steelplast/collaboration/steps --
    icl_register_string( 'steelplast/collaboration/steps', 'steps_aria',   'How we work' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_1_tag',   'Stage 1' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_1_title', 'YOUR ENQUIRY' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_1_text',  'Send a request via the website or contact us directly. Briefly describe the task and requirements for the product.' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_2_tag',   'Stage 2' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_2_title', 'A SOLUTION FOR YOUR PROJECT' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_2_text',  'We agree the technical specification before production begins.' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_3_tag',   'Stage 3' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_3_title', 'INTO PRODUCTION' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_3_text',  'We manufacture to the approved requirements, with quality control at every stage.' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_4_tag',   'Stage 4' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_4_title', 'FINISHED RESULT' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_4_text',  'We organize packaging and delivery of finished products within agreed timelines.' );

    // -- steelplast/quality/hero --
    icl_register_string( 'steelplast/quality/hero', 'title', 'Production and Quality: Standards You Can Trust' );

    // -- steelplast/quality/steps --
    icl_register_string( 'steelplast/quality/steps', 'label',        'Quality Management System' );
    icl_register_string( 'steelplast/quality/steps', 'title',        "Our quality management system\ncovers the entire product lifecycle" );
    icl_register_string( 'steelplast/quality/steps', 'desc_1',       'We have structured our approach so that quality is controlled at every stage — from raw material intake to the finished, shipped product.' );
    icl_register_string( 'steelplast/quality/steps', 'step_1_tag',   '01' );
    icl_register_string( 'steelplast/quality/steps', 'step_1_title', 'Unified processing control' );
    icl_register_string( 'steelplast/quality/steps', 'step_1_text',  'Every processing stage is monitored under a single quality control protocol, from raw material to finished part.' );
    icl_register_string( 'steelplast/quality/steps', 'step_2_tag',   '02' );
    icl_register_string( 'steelplast/quality/steps', 'step_2_title', 'Dedicated controller' );
    icl_register_string( 'steelplast/quality/steps', 'step_2_text',  'A dedicated quality controller is assigned to each production batch, ensuring full accountability.' );
    icl_register_string( 'steelplast/quality/steps', 'step_3_tag',   '03' );
    icl_register_string( 'steelplast/quality/steps', 'step_3_title', 'Careful testing' );
    icl_register_string( 'steelplast/quality/steps', 'step_3_text',  'Finished products undergo thorough testing before shipment to confirm compliance with specifications.' );

    // -- steelplast/quality/cards --
    icl_register_string( 'steelplast/quality/cards', 'card_1_title', 'IATF 16949 Certified' );
    icl_register_string( 'steelplast/quality/cards', 'card_1_desc',  'International automotive quality management standard applied at every production stage.' );
    icl_register_string( 'steelplast/quality/cards', 'card_2_title', 'ISO 9001 Certified' );
    icl_register_string( 'steelplast/quality/cards', 'card_2_desc',  'Confirmed quality management system ensuring consistent product excellence.' );
    icl_register_string( 'steelplast/quality/cards', 'card_3_title', '6-Stage Control' );
    icl_register_string( 'steelplast/quality/cards', 'card_3_desc',  'Multi-step inspection from raw material intake to finished product shipment.' );
    icl_register_string( 'steelplast/quality/cards', 'card_4_title', 'Zero-Defect Policy' );
    icl_register_string( 'steelplast/quality/cards', 'card_4_desc',  'Numerous client awards for outstanding quality and exceptional production results.' );
    icl_register_string( 'steelplast/quality/cards', 'grid_aria',    'Quality certifications' );

    // -- steelplast/quality/header --
    icl_register_string( 'steelplast/quality/header', 'label',    'Quality of products' );
    icl_register_string( 'steelplast/quality/header', 'title',    'Quality is not a separate stage. It is the basis of everything we make.' );
    icl_register_string( 'steelplast/quality/header', 'desc',     'In accordance with IATF and ISO 9001 standards. Numerous client awards for Outstanding Quality and exceptional production results.' );
    icl_register_string( 'steelplast/quality/header', 'cta_aria', 'Learn more about our quality standards' );
    icl_register_string( 'steelplast/quality/header', 'cta_text', 'Learn more' );

    // -- steelplast/quality/certification --
    icl_register_string( 'steelplast/quality/certification', 'title',          'Quality assurance: ISO certification' );
    icl_register_string( 'steelplast/quality/certification', 'download_label', 'Download file' );
    icl_register_string( 'steelplast/quality/certification', 'file_1_label',   'ISO 9001 Certificate' );
    icl_register_string( 'steelplast/quality/certification', 'file_2_label',   'Technical specifications and quality passports' );
    icl_register_string( 'steelplast/quality/certification', 'label',          'ISO Certificates' );
    icl_register_string( 'steelplast/quality/certification', 'desc',           'We confirm our high standard of management and production safety not just in words, but in practice. Steel Plast regularly undergoes independent audits to ensure compliance with strict global regulations.' );

    // -- steelplast/quality/reliability --
    icl_register_string( 'steelplast/quality/reliability', 'title',          'Reliability built into every product' );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_1_title', 'Longevity' );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_1_desc',  'Premium raw materials and anti-corrosion technologies guarantee a long service life, even in demanding conditions.' );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_2_title', 'Compliance with standards' );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_2_desc',  'Our products meet national and international technical regulations (DSTU / ISO).' );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_3_title', "Manufacturer's warranty" );
    icl_register_string( 'steelplast/quality/reliability', 'bullet_3_desc',  'We take full responsibility for every shipped product and provide an official warranty.' );
    icl_register_string( 'steelplast/quality/reliability', 'label',          'Uncompromising Quality Control' );
    icl_register_string( 'steelplast/quality/reliability', 'intro',          "We understand that the stability of your operations depends on our components, so we don't compromise on quality." );

    // -- steelplast/quality/equipment --
    icl_register_string( 'steelplast/quality/equipment', 'card_1_title',  'Modern equipment fleet' );
    icl_register_string( 'steelplast/quality/equipment', 'card_1_desc',   'Production machinery is regularly upgraded to keep pace with the highest manufacturing standards.' );
    icl_register_string( 'steelplast/quality/equipment', 'card_2_title',  'Process automation' );
    icl_register_string( 'steelplast/quality/equipment', 'card_2_desc',   'Automated processes reduce human error and keep quality consistent across every production run.' );
    icl_register_string( 'steelplast/quality/equipment', 'card_3_title',  'Highly qualified team' );
    icl_register_string( 'steelplast/quality/equipment', 'card_3_desc',   'Our engineers and operators bring extensive experience in precision manufacturing.' );
    icl_register_string( 'steelplast/quality/equipment', 'section_label', 'Professional Quality Control' );
    icl_register_string( 'steelplast/quality/equipment', 'title',         'Our own modern production facility' );
    icl_register_string( 'steelplast/quality/equipment', 'description',  'Our own modern production facility allows us to deliver projects of any complexity — from serial products to individual orders built from client drawings.' );

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
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_1_title', 'Separating operations' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_1_item_1', 'Blanking' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_1_item_2', 'Piercing' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_1_item_3', 'Trimming' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_2_title', 'Forming' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_2_item_1', 'Bending' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_2_item_2', 'Deep drawing' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_2_group_2_item_3', 'Embossing' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_title', 'Equipment & Quality Control' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_subtitle', 'Precision you can rely on' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_stat_suffix', 'tons' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_stat_label', 'Maximum pressing force' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_item_1', 'Crank pneumatic presses' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_item_2', 'Incoming material inspection' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_item_3', 'Die wear monitoring' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_3_item_4', 'First-article inspection' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_stat_suffix', 'business days' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_stat_label', 'Production starts from' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_badges_label', 'We accept files in:' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'card_4_note', 'No drawing yet? Our engineers can help prepare documentation and a 3D model for production.' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'label', 'Technical Parameters' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'title', 'Steel Plast delivers a full cycle of metal stamping — from your drawing to a finished part' );
    icl_register_string( 'steelplast/service-metal-stamping/specs', 'desc_2', 'Stamping forms sheet metal into finished parts using dedicated tooling — dies mounted on crank presses. It is one of the fastest and most cost-effective ways to produce parts in series.' );

    // -- steelplast/service-metal-stamping/hero --
    icl_register_string( 'steelplast/service-metal-stamping/hero', 'title', 'Metal Stamping' );

    // -- steelplast/service-metal-stamping/content --
    icl_register_string( 'steelplast/service-metal-stamping/content', 'label', 'Cutting & Forming' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'title', 'Sheet Metal Cutting and Forming Services' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'intro', 'Steel Plast operates a fleet of stamping presses for cutting and forming sheet metal parts — from small brackets to structural components. Depending on what the customer needs, we can make a dedicated die or run a die supplied by the client.' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_1_heading', 'Sheet Metal Cutting' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_1_p1', 'Blanking and piercing separate the part outline from the sheet metal strip and create internal features — holes, slots, and cutouts — in a single stroke of the press. This process is fast and repeatable, making it ideal for both prototype runs and high-volume production of flat components.' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_1_p2', 'We also perform trimming and shearing to finish part edges to the exact profile specified in your drawing, keeping burr height and edge quality consistent across the full production batch.' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_2_heading', 'Sheet Metal Forming' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_2_p1', 'Bending reshapes flat blanks into brackets, channels, and enclosures, while deep drawing forms sheet metal into cylinders, housings, and other three-dimensional shapes without cutting the material.' );
    icl_register_string( 'steelplast/service-metal-stamping/content', 'topic_2_p2', 'Embossing adds ribs, louvers, and other reinforcing features directly into the sheet, increasing part stiffness without extra material or a separate assembly step.' );

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
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_item_2', 'Stamping dies' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_item_3', 'Prototype molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_item_4', 'Multi-cavity production molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_item_5', 'Overmolding & insert molds' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_1_note', 'Single-cavity to multi-cavity production tooling.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_title', 'Manufacturing Processes' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_subtitle', 'Core operations' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_1_title', 'Machining' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_1_item_1', '3-axis & 5-axis CNC milling' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_1_item_2', 'CNC turning' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_1_item_3', 'Grinding' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_2_title', 'Finishing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_2_item_1', 'Wire & sinker EDM' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_2_item_2', 'Polishing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_2_group_2_item_3', 'Heat treatment' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_title', 'Precision & Quality Control' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_subtitle', 'Tolerances we guarantee' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_stat_label', 'Machining tolerance' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_item_1', 'Tool steel inspection' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_item_2', 'Trial shots & sampling' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_item_3', 'Dimensional verification' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_3_item_4', 'Coordinate measuring machines (CMM)' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_stat_suffix', 'business days' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_stat_label', 'Lead time starts from' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_badges_label', 'We accept files in:' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'card_4_note', 'We also provide mold and die maintenance and repair for tooling already in production.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'label', 'Technical Parameters' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'title', 'Steel Plast delivers a full cycle of mold and die manufacturing — from your drawing to a finished tool' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'desc_1', 'We work with both one-off tooling orders and long production programs, keeping quality consistent at every stage.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/specs', 'desc_2', 'Every injection mold and stamping die is designed and built in-house, from steel selection to trial shots. Alongside proven CNC machining and EDM processes, we maintain a stable process, tight tolerances, and a skilled tool shop team capable of building tooling of complex geometry.' );

    // -- steelplast/service-mold-manufacturing/hero --
    icl_register_string( 'steelplast/service-mold-manufacturing/hero', 'title', 'Mold & Die Manufacturing: Custom Tooling Built In-House' );

    // -- steelplast/service-mold-manufacturing/content --
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'label', 'Tooling Design & Manufacturing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'title', 'Injection Mold and Stamping Die Manufacturing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'intro', 'Steel Plast designs and manufactures custom tooling in-house — from injection molds to stamping dies — giving us full control over lead time, precision, and cost. Whatever your part geometry calls for, our engineers select the mold structure, steel grade, and machining strategy that deliver a reliable, long-lasting tool.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_1_heading', 'Injection Mold Manufacturing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_1_p1', 'We design and manufacture injection molds from 3D model to first trial shot, including cavity and core machining, runner and gate design, and cooling channel layout. Every mold is built to match your production volume — from single-cavity prototype tools to high-cavity-count production molds.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_1_p2', 'Trial shots and sampling validate the mold before it goes into series production, confirming that dimensions, surface finish, and cycle time meet your specification.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_2_heading', 'Stamping Die Manufacturing' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_2_p1', 'Stamping dies are engineered for the specific sheet metal operation — blanking, piercing, bending, or deep drawing — and built from hardened tool steel to withstand high-volume production runs.' );
    icl_register_string( 'steelplast/service-mold-manufacturing/content', 'topic_2_p2', 'We machine die components on CNC milling and EDM equipment, then fit, polish, and heat-treat the tooling to extend die life and keep part quality consistent across the full production run.' );

    // -- steelplast/service-mold-manufacturing/about --
    icl_register_string( 'steelplast/service-mold-manufacturing/about', 'tag', '[03] About us' );

    // -- steelplast/service-custom-tooling/specs --
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_title', 'Tooling Types' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_subtitle', 'We manufacture:' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_1', 'Assembly jigs & fixtures' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_2', 'Inspection & measuring gauges' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_3', 'Cutting tools' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_4', 'Welding fixtures' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_item_5', 'Custom test equipment' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_1_note', 'Built to your process, not off a catalog.' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_title', 'Design & Manufacturing Process' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_subtitle', 'Core operations' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_1_title', 'Design' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_1_item_1', 'Requirements review' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_1_item_2', '3D modeling' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_1_item_3', 'Design validation' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_2_title', 'Manufacturing' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_2_item_1', 'CNC milling & turning' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_2_item_2', 'Grinding' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_2_group_2_item_3', 'Assembly & calibration' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_title', 'Precision & Quality Control' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_subtitle', 'Tolerances we guarantee' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_stat_label', 'Machining tolerance' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_item_1', 'Calibration against reference standards' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_item_2', 'Repeatability testing' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_item_3', 'Material certification' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_3_item_4', 'Coordinate measuring machines (CMM)' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_stat_suffix', 'business days' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_stat_label', 'Production starts from' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_badges_label', 'We accept files in:' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'card_4_note', 'No drawing yet? Describe the task and our engineers will design the tooling from scratch.' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'label', 'Technical Parameters' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'title', 'Steel Plast builds custom tooling and fixtures — from your task to a finished piece of equipment' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'desc_1', 'We work with both one-off requests and equipment for full production lines, keeping quality consistent at every stage.' );
    icl_register_string( 'steelplast/service-custom-tooling/specs', 'desc_2', 'Some tasks can\'t be solved with an off-the-shelf tool. We design and manufacture jigs, fixtures, gauges, and other custom equipment in-house, matching your exact process instead of forcing your process to match a catalog part.' );

    // -- steelplast/service-custom-tooling/hero --
    icl_register_string( 'steelplast/service-custom-tooling/hero', 'title', 'Custom Tooling & Fixtures: Made-to-Order Equipment' );

    // -- steelplast/service-custom-tooling/content --
    icl_register_string( 'steelplast/service-custom-tooling/content', 'label', 'Custom Equipment' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'title', 'Custom Tooling and Fixtures for Non-Standard Tasks' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'intro', 'Some tasks can\'t be solved with an off-the-shelf tool — a fixture that holds an unusual part, a gauge that checks a feature no catalog instrument measures, or a jig that speeds up a repetitive assembly step. Steel Plast designs and builds this equipment in-house, matched exactly to your process.' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_1_heading', 'Jigs & Fixtures' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_1_p1', 'Assembly and welding fixtures hold parts in a fixed, repeatable position, removing manual alignment from your process and keeping cycle time and quality consistent across every operator and shift.' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_1_p2', 'We design fixtures around your existing workflow — including quick-change elements when a single fixture needs to support several part variants.' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_2_heading', 'Inspection & Measuring Gauges' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_2_p1', 'Custom gauges check features that standard measuring instruments can\'t reach or aren\'t built for — a specific bore pattern, a contoured surface, or a go/no-go check for a critical dimension.' );
    icl_register_string( 'steelplast/service-custom-tooling/content', 'topic_2_p2', 'Every gauge is calibrated against a reference standard and validated for repeatability before it goes into your quality control process.' );

    // -- steelplast/service-custom-tooling/about --
    icl_register_string( 'steelplast/service-custom-tooling/about', 'tag', '[03] About us' );

    // -- steelplast/service-wire-products/hero --
    icl_register_string( 'steelplast/service-wire-products/hero', 'title', 'Springs and Wire Products Made to Order' );

    // -- steelplast/service-wire-products/specs --
    icl_register_string( 'steelplast/service-wire-products/specs', 'label', 'Technical Parameters' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'title', 'Steel Plast manufactures springs and formed wire parts — from your drawing or sample to a finished batch' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'desc_1', 'We run small and medium batches, holding the same geometry on every part of the order.' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'desc_2', 'A spring is rarely a catalogue item: wire diameter, pitch, load and fitting dimensions are all dictated by your assembly. We coil, bend and heat-treat in-house, so the geometry follows the part instead of the other way round.' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_title', 'Spring Types' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_subtitle', 'We manufacture:' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_1', 'Compression springs' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_2', 'Extension springs' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_3', 'Torsion springs' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_4', 'Flat and shaped springs' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_item_5', 'Retaining and spring rings' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_1_note', 'Wire diameter from 0.3 to 4 mm.' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_title', 'Wire Products' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_subtitle', 'Core operations' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_1_title', 'Forming' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_1_item_1', 'Spring coiling' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_1_item_2', '2D and 3D wire bending' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_1_item_3', 'Rings, hooks and clips' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_2_title', 'Finishing' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_2_item_1', 'Resistance welding' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_2_item_2', 'Heat treatment and tempering' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_2_group_2_item_3', 'Electroplated or powder coating' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_title', 'Materials & Precision' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_subtitle', 'We work with' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_stat_label', 'Geometry repeatability' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_item_1', 'Spring wire' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_item_2', 'Stainless steel' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_item_3', 'Galvanised and low-carbon wire' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_3_item_4', 'Brass and bronze' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_stat_suffix', 'business days' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_stat_label', 'Production starts from' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_badges_label', 'We accept files in:' );
    icl_register_string( 'steelplast/service-wire-products/specs', 'card_4_note', 'No drawing? Send us a sample part and we will reproduce its geometry.' );

    // -- steelplast/service-wire-products/content --
    icl_register_string( 'steelplast/service-wire-products/content', 'label', 'Springs & Wire' );
    icl_register_string( 'steelplast/service-wire-products/content', 'title', 'Springs and Formed Wire Parts for Industry and Everyday Products' );
    icl_register_string( 'steelplast/service-wire-products/content', 'intro', 'A spring is rarely a product in itself — it works inside a lock, a furniture mechanism, a household appliance or an agricultural assembly, and how long that assembly lasts depends on it. We make parts like these in small and medium batches, to a drawing or to a sample.' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_1_heading', 'Made-to-Order Springs' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_1_p1', 'We coil compression, extension and torsion springs from wire between 0.3 and 4 mm. The calculation starts from how the part behaves in the assembly: working load, travel, fitting diameters and the number of cycles it has to survive.' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_1_p2', 'After coiling every spring is heat treated to relieve stress — that step is what decides whether it still holds its rated load after thousands of cycles.' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_2_heading', 'Formed Wire Parts' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_2_p1', 'Rings, clips, hooks, retainers, wire frames and baskets — 2D and 3D bending to your drawing. Closed contours are joined by resistance welding.' );
    icl_register_string( 'steelplast/service-wire-products/content', 'topic_2_p2', 'Finished parts can be delivered electroplated or powder coated, depending on where they will work: indoors, in a damp environment or outdoors.' );

    // -- steelplast/service-wire-products/about --
    icl_register_string( 'steelplast/service-wire-products/about', 'tag', '[03] About us' );


    // -- steelplast/faq/intro --
    icl_register_string( 'steelplast/faq/intro', 'title', 'Welcome to our FAQ section!
We want working with Steel Plast to be transparent and comfortable for you.' );
    icl_register_string( 'steelplast/faq/intro', 'desc', 'We\'ve gathered answers to the questions our clients ask most often about our products, orders and delivery.
If you can\'t find what you\'re looking for, our team is always ready to help you personally.' );

    // -- steelplast/faq/list --
    icl_register_string( 'steelplast/faq/list', 'q_1', 'What does Steel Plast manufacture?' );
    icl_register_string( 'steelplast/faq/list', 'a_1', 'We specialize in the full-cycle production of technical plastic components through injection molding, along with the design and manufacturing of custom injection molds. Our product range covers plastic and metal-plastic parts, packaging, enclosures and components for the automotive, household appliance, electrical, interior and construction industries.' );
    icl_register_string( 'steelplast/faq/list', 'q_2', 'Can you manufacture a custom mold for our project?' );
    icl_register_string( 'steelplast/faq/list', 'a_2', 'Yes. We design and manufacture custom injection molds in-house — from 3D modeling and CNC machining to trial shots and fine-tuning — matching the specifications and volumes of your project.' );
    icl_register_string( 'steelplast/faq/list', 'q_3', 'What is the minimum order quantity?' );
    icl_register_string( 'steelplast/faq/list', 'a_3', 'The minimum order quantity depends on the part\'s complexity, mold cost and material. We evaluate every request individually — send us your drawings and we will offer the most efficient production scenario.' );
    icl_register_string( 'steelplast/faq/list', 'q_4', 'What clamping force range do your injection molding machines cover?' );
    icl_register_string( 'steelplast/faq/list', 'a_4', 'Our injection molding machines cover a clamping force range from 25 to 800 tons, allowing us to produce parts of different sizes — from small precision components to larger housings and structural parts.' );
    icl_register_string( 'steelplast/faq/list', 'q_5', 'Which materials can you work with?' );
    icl_register_string( 'steelplast/faq/list', 'a_5', 'We work with a wide range of technical plastics (granules), including polypropylene, ABS, polyamide (PA6, PA66), polycarbonate and their reinforced or filled grades, selected to match your part\'s requirements.' );
    icl_register_string( 'steelplast/faq/list', 'q_6', 'Do you offer overmolding or insert molding?' );
    icl_register_string( 'steelplast/faq/list', 'a_6', 'Yes, we offer overmolding and insert molding, including 2K (two-component) injection, allowing us to combine materials or embed metal inserts directly during the injection cycle.' );
    icl_register_string( 'steelplast/faq/list', 'q_7', 'How do you ensure dimensional stability and low warpage?' );
    icl_register_string( 'steelplast/faq/list', 'a_7', 'Every mold and process is validated through trial shots and cavity-by-cavity measurement. We control shrinkage and warpage at the design stage and monitor dimensional stability throughout the entire injection cycle.' );
    icl_register_string( 'steelplast/faq/list', 'q_8', 'What is the average mold lifespan?' );
    icl_register_string( 'steelplast/faq/list', 'a_8', 'Mold lifespan (mold resource) depends on the tool steel, part geometry and production volume, and is confirmed for each project individually — we design every mold for reliable, repeatable output across its full service life.' );
    icl_register_string( 'steelplast/faq/list', 'q_9', 'What quality control stages does production go through?' );
    icl_register_string( 'steelplast/faq/list', 'a_9', 'Every batch passes through several quality control stages — incoming material inspection, in-process monitoring during the injection cycle, and final dimensional and visual inspection before shipment, in line with ISO 9001.' );
    icl_register_string( 'steelplast/faq/list', 'q_10', 'How can I place an order?' );
    icl_register_string( 'steelplast/faq/list', 'a_10', 'Send us your drawings or reference samples via the form on our Contacts page or by email — our team will review the details and get back to you with production options within 2 hours.' );

    // -- steelplast/service-injection-molding/specs --
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_title', 'Materials' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_subtitle', 'We mold:' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_1', 'Polypropylene (PP)' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_2', 'ABS' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_3', 'Polyamide (PA6, PA66)' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_4', 'Polycarbonate (PC)' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_5', 'Reinforced & filled grades' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_item_6', 'TPE / TPU' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_1_note', 'From small precision components to large housings.' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_title', 'Molding Processes' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_subtitle', 'Core capabilities' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_1_title', 'Standard Injection' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_1_item_1', 'Single-component molding' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_1_item_2', 'Insert molding' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_1_item_3', 'Overmolding' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_2_title', 'Advanced' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_2_item_1', '2K (two-component) injection' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_2_group_2_item_2', 'Gas-assisted injection' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_title', 'Precision & Quality Control' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_subtitle', 'Dimensional stability we guarantee' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_stat_label', 'Molding tolerance' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_item_1', 'Incoming resin inspection' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_item_2', 'Shrinkage & warpage control' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_item_3', 'First-shot validation' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_3_item_4', 'Coordinate measuring machines (CMM)' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_title', 'Equipment & Terms' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_stat_suffix', 'tons' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_stat_label', 'Clamping force range' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_badges_label', 'We accept files in:' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'card_4_note', 'No mold yet? We design and manufacture the injection mold in-house — from 3D model to first shot.' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'label', 'Technical Parameters' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'title', 'Steel Plast delivers a full cycle of plastic injection molding — from your drawing to a finished part' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'desc_1', 'We work with both one-off orders and serial production, keeping quality consistent at every stage.' );
    icl_register_string( 'steelplast/service-injection-molding/specs', 'desc_2', 'Injection molding melts technical plastics and injects them into a mold cavity — the most efficient way to produce plastic parts at volume. Alongside proven molding processes, we maintain a stable process, tight tolerances, and a skilled team capable of molding parts of complex geometry.' );

    // -- steelplast/service-injection-molding/hero --
    icl_register_string( 'steelplast/service-injection-molding/hero', 'title', 'Plastic Injection Molding: Precision Technical Parts' );

    // -- steelplast/service-injection-molding/content --
    icl_register_string( 'steelplast/service-injection-molding/content', 'label', 'Molding Capabilities' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'title', 'Injection Molding Process and Capabilities' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'intro', 'Steel Plast operates a fleet of injection molding machines, giving us the flexibility to produce technical plastic parts of virtually any geometry — from small precision components to large housings. Whatever your drawing calls for, our engineers select the material, process, and mold design that deliver the best precision and turnaround time.' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_1_heading', 'Injection Molding' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_1_p1', 'Injection molding melts plastic granules and injects them under pressure into a mold cavity, where the part cools and solidifies before ejection. This process is fast, repeatable, and cost-effective at scale, making it the standard choice for producing plastic components in volumes from a few hundred to millions of parts.' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_1_p2', 'We control every injection cycle — melt temperature, injection speed, and clamping force — to keep dimensional stability and cycle repeatability consistent across the full production run.' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_2_heading', 'Overmolding & 2K Molding' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_2_p1', 'Overmolding and insert molding embed a metal or plastic insert directly into the part during the injection cycle, combining materials in a single component without a separate assembly step.' );
    icl_register_string( 'steelplast/service-injection-molding/content', 'topic_2_p2', '2K (two-component) injection molds two different materials or colors into one part in a single cycle — commonly used for soft-touch grips, seals, and multi-color housings.' );

    // -- steelplast/service-injection-molding/about --
    icl_register_string( 'steelplast/service-injection-molding/about', 'tag', '[03] About us' );

    // -- steelplast/about/intro --
    icl_register_string( 'steelplast/about/intro', 'label', 'Steel Plast is' );
    icl_register_string( 'steelplast/about/intro', 'title', 'Modern manufacturing for the light engineering industry' );
    icl_register_string( 'steelplast/about/intro', 'desc_1', 'We bring the key manufacturing processes together in one place: metalworking, mold making, metal stamping and plastic injection molding. We take a project on at any stage — from the initial idea and engineering design through to the start of series production and the finished goods.' );
    icl_register_string( 'steelplast/about/intro', 'desc_2', 'A full cycle inside a single plant means fewer links in the chain, more control and a clear result at every stage.' );
    icl_register_string( 'steelplast/about/intro', 'desc_3', 'Our facility is equipped with modern high-precision machinery, including CNC turning, milling and EDM machines, injection molding machines and stamping presses. This lets us deliver projects of any complexity while holding to the highest standards of quality and precision.' );

    // -- steelplast/about/audience --
    icl_register_string( 'steelplast/about/audience', 'label', 'Why choose us' );
    icl_register_string( 'steelplast/about/audience', 'title', 'Who We Manufacture For' );
    icl_register_string( 'steelplast/about/audience', 'desc_1', 'Our clients are manufacturing companies, machine-building businesses, design bureaus, startups, furniture and construction product manufacturers, and other companies that need quality metal or plastic components.' );
    icl_register_string( 'steelplast/about/audience', 'desc_2', 'We believe successful production starts with a reliable partnership. That is why Steel Plast is not just a contractor, but a team that takes responsibility for the result and helps clients deliver on their most demanding manufacturing tasks.' );

    // -- steelplast/about/advantages --
    icl_register_string( 'steelplast/about/advantages', 'label', 'Our advantages' );
    icl_register_string( 'steelplast/about/advantages', 'title', 'We combine modern technology, team experience
and quality control at every stage of production.' );

    // -- steelplast/about/advantages-cards --
    icl_register_string( 'steelplast/about/advantages-cards', 'card_1_title', 'Full production cycle' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_1_desc', 'We perform the full range of work — from engineering design and documentation to manufacturing the finished product.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_2_title', 'Modern equipment' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_2_desc', 'We use high-precision machinery and technology that ensure stable quality and accuracy of every part.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_3_title', 'Experienced team' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_3_desc', 'Every project is handled by qualified engineers, designers and technologists with years of experience.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_4_title', 'Individual approach' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_4_desc', 'We develop solutions that take into account technical requirements, production specifics and the client\'s goals.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_5_title', 'Quality control' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_5_desc', 'We inspect products at every stage of production, guaranteeing compliance with technical standards.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_6_title', 'Flexible production' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_6_desc', 'We work with single orders and prototypes as well as with large-scale serial batches.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_7_title', 'On-time delivery' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_7_desc', 'Optimized production processes allow us to complete orders within agreed deadlines without any loss of quality.' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_8_title', 'Reliable partnership' );
    icl_register_string( 'steelplast/about/advantages-cards', 'card_8_desc', 'We build long-term relationships with clients, ensuring open communication and a responsible approach to every project.' );

    // -- steelplast/about/equipment --
    icl_register_string( 'steelplast/about/equipment', 'label', 'Our equipment' );
    icl_register_string( 'steelplast/about/equipment', 'title', 'Modern manufacturing requires modern technology' );
    icl_register_string( 'steelplast/about/equipment', 'desc', 'That is why SteelPlast uses high-precision automated equipment that lets us deliver products of the highest quality.' );

    // -- steelplast/about/equipment-cards --
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_title', 'Swiss-type automatic lathe' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_lead', 'What it does:' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_bullet_1', 'Produces small, highly precise parts — pins, shafts, screws, and components for medical devices, watches and electronics.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_bullet_2', 'They can turn, mill, drill and thread.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_1_bullet_3', 'Runs fully automatically without an operator — just load the bar stock and the machine handles the rest.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_2_title', 'Crank stamping presses' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_2_desc_1', 'A crank stamping press is a machine that forms, bends, cuts and draws metal by compression force.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_2_desc_2', 'Its main advantages: productivity, energy efficiency and high repeatability.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_3_title', 'Injection molding machines' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_3_lead', 'How does it work?' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_3_desc_1', 'Plastic granules are fed into the machine, melted down to a liquid state and injected under high pressure into the mold.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_4_title', 'Wire-cut and sinker EDM machines' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_4_desc_1', 'An EDM, or electrical discharge machine, works metal not with a cutter or a mill but with an electric spark that erodes it to micron precision.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_title', '5-axis CNC milling machines' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_lead', 'What it does:' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_bullet_1', 'Mills, drills and cuts complex shapes.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_bullet_2', 'They produce 3D surfaces, blades, housings and other complex parts.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_5_bullet_3', 'Works with metal, plastic and composite materials.' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_6_title', 'CNC turn-mill machines' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_6_lead', 'What they do:' );
    icl_register_string( 'steelplast/about/equipment-cards', 'card_6_bullet_1', 'Turning, milling, drilling, threading — every operation without a re-setup!' );

    // -- steelplast/service-cnc-machining/specs --
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'label', 'Technical Parameters' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'title', 'Steel Plast delivers a full cycle of CNC metal machining — from your drawing to a finished part' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'desc_1', 'We work with both one-off orders and serial production, keeping quality consistent at every stage.' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'desc_2', 'CNC metal machining relies on computer numerical control — the foundation of modern precision manufacturing. Alongside proven turning and milling processes, we maintain a stable process, tight tolerances, and a skilled team capable of machining parts of complex geometry.' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_title', 'Materials' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_subtitle', 'We machine:' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_1', 'Structural steel' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_2', 'Tool steel' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_3', 'Stainless steel' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_4', 'Aluminum' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_5', 'Brass' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_6', 'Copper' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_item_7', 'Titanium' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_1_note', 'Parts from Ø0.5 mm.' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_title', 'Machining Types' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_subtitle', 'Core operations' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_1_title', 'Turning' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_1_item_1', 'OD & ID turning' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_1_item_2', 'Threading' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_1_item_3', 'Grooving & parting' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_title', 'Milling' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_item_1', 'Facing' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_item_2', 'Slotting & pocketing' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_item_3', 'Complex contours' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_2_group_2_item_4', '3D milling' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_title', 'Precision & Quality Control' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_subtitle', 'Tolerances we guarantee' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_stat_label', 'Machining tolerance' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_item_1', 'Incoming material inspection' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_item_2', 'Part geometry control' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_item_3', 'Calibrated tooling' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_3_item_4', 'Optical measuring devices' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_title', 'Lead Time & Terms' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_subtitle', 'Fast & reliable' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_stat_value', 'from 2' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_stat_suffix', 'weeks' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_stat_label', 'Project start' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_badges_label', 'We accept files in:' );
    icl_register_string( 'steelplast/service-cnc-machining/specs', 'card_4_note', 'No drawing yet? Our engineers can help prepare documentation and a 3D model for production.' );

    // -- steelplast/service-cnc-machining/content --
    icl_register_string( 'steelplast/service-cnc-machining/content', 'label', 'CNC Milling & Turning' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'title', 'CNC Milling and CNC Turning Services' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'intro', 'Steel Plast operates a fleet of CNC milling and turning centers, giving us the flexibility to machine parts of virtually any geometry — from flat brackets to complex rotational components. Whatever your drawing calls for, our engineers select the process, tooling, and setup that deliver the best precision and turnaround time.' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_1_heading', 'CNC Milling' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_1_p1', 'Our CNC machining centers mill material from a solid workpiece to produce flat surfaces, pockets, slots, and complex 3D contours with high accuracy. Multi-axis milling lets us machine undercuts and curved geometries in a single setup, which shortens lead times and keeps dimensions consistent across the whole part.' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_1_p2', 'CNC milling is our core process for housings, brackets, plates, and mold components. We machine both prototypes and production batches at high throughput.' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_2_heading', 'CNC Turning' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_2_p1', 'CNC turning rotates the workpiece against a cutting tool to produce cylindrical and other rotational shapes — shafts, bushings, flanges, pins, and threaded parts. Our lathes handle external and internal turning, threading, grooving, and parting-off in a single cycle, which minimizes the number of setups.' );
    icl_register_string( 'steelplast/service-cnc-machining/content', 'topic_2_p2', 'Finished parts are common in automotive, industrial equipment, and fastener applications where round geometry and axial precision matter most. We machine parts from steel, stainless steel, aluminum, copper, and brass, and can combine turning with subsequent milling for parts that need both round and flat features.' );
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

    // [ divisor, decimals, suffix ]
    $formats = [
        'millions'  => [ 1000000, 1, 'm' ],
        'thousands' => [ 1000,    0, 'k' ],
        'plain'     => [ 1,       0, ''  ],
    ];
    [ $divisor, $decimals, $suffix ] = $formats[ $format ] ?? $formats['plain'];

    $step  = $divisor / pow( 10, $decimals );   // smallest visible increment
    $value = floor( $raw / $step ) * $step / $divisor;

    return [
        'value'    => $value,
        'decimals' => $decimals,
        'suffix'   => $suffix,
        'text'     => number_format( $value, $decimals, '.', '' ) . $suffix,
    ];
}

if ( function_exists( 'icl_get_languages' ) || defined( 'ICL_SITEPRESS_VERSION' ) ) {
    add_filter( 'icl_show_translate_link', '__return_false' );
    add_filter( 'wpml_show_footer_language_selector', '__return_false' );
    add_filter( 'wpml_footer_language_selector', '__return_false' );
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

    $current_code = esc_html( strtoupper( $current_lang['language_code'] ) );
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
                        <?php echo esc_html( strtoupper( $lang['language_code'] ) ); ?>
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