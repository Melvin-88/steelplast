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

    // Contact form JS/CSS — only on pages that actually render
    // template-parts/section-contact.php. Keep this list in sync whenever a
    // page starts using that partial (grep -rn "section-contact" *.php page-templates/*.php template-parts/*.php single.php).
    $contact_form_templates = [
        'page-templates/template-contacts.php',
        'page-templates/template-quality.php',
        'page-templates/page-news.php',
    ];
    if ( is_front_page() || is_page_template( $contact_form_templates ) || is_singular( 'post' ) ) {
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
    }

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
    icl_register_string( 'steelplast/global/footer', 'description',  'We specialize in supplying high-quality components for the automotive, household, electrical, interior and construction industries.' );
    icl_register_string( 'steelplast/global/footer', 'menu_title',   'MENU' );
    icl_register_string( 'steelplast/global/footer', 'social_title', 'FOLLOW US' );
    icl_register_string( 'steelplast/global/footer', 'copyright',    'All rights reserved.' );
    // Social URLs are managed via Customizer → Site Settings → Social Media

    // -- steelplast/home/hero --
    icl_register_string( 'steelplast/home/hero', 'title',       'BUILD FOR<br>REPEATABILITY' );
    icl_register_string( 'steelplast/home/hero', 'description', 'STEELPLAST is a team that turns ideas into finished products. We provide a full production cycle: from mold design and manufacturing to serial part production.' );
    icl_register_string( 'steelplast/home/hero', 'stat_1_label', 'Cycle repeatability' );
    icl_register_string( 'steelplast/home/hero', 'stat_2_label', 'Mold resource' );
    icl_register_string( 'steelplast/home/hero', 'stat_3_label', 'Quality control stages' );

    // -- steelplast/contacts/page --
    icl_register_string( 'steelplast/contacts/page', 'emails_heading',    'Email' );
    icl_register_string( 'steelplast/contacts/page', 'phones_heading',    'Phone' );
    icl_register_string( 'steelplast/contacts/page', 'locations_heading', 'Our locations' );
    icl_register_string( 'steelplast/contacts/page', 'location_label',   'Head office and production' );
    icl_register_string( 'steelplast/contacts/page', 'location_address', "Avtobazivska St., 6\nPoltava, 36000\nPoltava region, Ukraine" );

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
    icl_register_string( 'steelplast/contacts/hero', 'contact_hero_desc',  'Leave your request and we will contact you within 2 hours.' );

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
    icl_register_string( 'steelplast/home/about-preview', 'title',       'WE ENGINEER<br>PRECISION' );
    icl_register_string( 'steelplast/home/about-preview', 'description', 'SteelPlast is a full-cycle manufacturer specialising in injection mold design, mold production, and high-volume plastic part manufacturing. Over 15 years of engineering precision.' );
    icl_register_string( 'steelplast/home/about-preview', 'button',      'Learn more about us' );

    // -- steelplast/home/services --
    icl_register_string( 'steelplast/home/services', 'section_label',   'Our Services' );
    icl_register_string( 'steelplast/home/services', 'title',           'Modern equipment, manufacturing precision and quality control' );
    icl_register_string( 'steelplast/home/services', 'description',     'Individual approach to every project, official contracts, staged payments and constant communication' );
    icl_register_string( 'steelplast/home/services', 'cta_label',       'Learn more' );
    icl_register_string( 'steelplast/home/services', 'card_1_title',    'Metal Processing' );
    icl_register_string( 'steelplast/home/services', 'card_1_desc',     'High-precision CNC metal machining for parts of any complexity.' );
    icl_register_string( 'steelplast/home/services', 'card_2_title',    'Plastic Casting' );
    icl_register_string( 'steelplast/home/services', 'card_2_desc',     'Manufacturing plastic products by injection molding on modern thermoplastic machines.' );
    icl_register_string( 'steelplast/home/services', 'card_3_title',    'Laser Metal Cutting' );
    icl_register_string( 'steelplast/home/services', 'card_3_desc',     'High-precision laser metal cutting for parts of any complexity.' );
    icl_register_string( 'steelplast/home/services', 'card_4_title',    'Stamping' );
    icl_register_string( 'steelplast/home/services', 'card_4_desc',     'STEELPLAST manufactures stamped components for various industrial sectors.' );
    icl_register_string( 'steelplast/home/services', 'card_4_cap',      'Manufacturing capabilities:' );
    icl_register_string( 'steelplast/home/services', 'card_4_bullet_1', 'Sheet metal processing 0.15–5 mm thick' );
    icl_register_string( 'steelplast/home/services', 'card_4_bullet_2', 'Crank pneumatic presses' );
    icl_register_string( 'steelplast/home/services', 'card_4_bullet_3', 'Maximum pressing force — up to 100 t' );
    icl_register_string( 'steelplast/home/services', 'card_5_title',    'Powder Coating' );
    icl_register_string( 'steelplast/home/services', 'card_5_desc',     'Powder coating of metal products ensuring uniform and durable finish.' );

    // -- steelplast/collaboration/header --
    icl_register_string( 'steelplast/collaboration/header', 'collab_label',   'Collaboration' );
    icl_register_string( 'steelplast/collaboration/header', 'collab_title',   "We don't just fulfill orders —\nwe solve problems" );
    icl_register_string( 'steelplast/collaboration/header', 'collab_desc_1',  'We build partnerships on reliability, precision, and meeting deadlines. We work with businesses of all sizes, offering flexible manufacturing solutions — from individual parts to serial production.' );
    icl_register_string( 'steelplast/collaboration/header', 'collab_desc_2',  'We provide support at every stage: from processing the technical specification to quality control of finished products.' );

    // -- steelplast/collaboration/steps --
    icl_register_string( 'steelplast/collaboration/steps', 'steps_aria',   'How we work' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_1_tag',   'Step 1' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_1_title', 'Submit a request' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_1_text',  'Send a request via the website or contact us directly. Briefly describe the task and requirements for the product.' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_2_tag',   'Step 2' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_2_title', 'Consultation and agreement' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_2_text',  'We discuss technical details, materials, timelines and finalize the specification before production begins.' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_3_tag',   'Step 3' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_3_title', 'Production' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_3_text',  'We manufacture products according to approved parameters with quality control at every stage.' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_4_tag',   'Step 4' );
    icl_register_string( 'steelplast/collaboration/steps', 'step_4_title', 'Delivery of finished products' );
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
    icl_register_string( 'steelplast/quality/header', 'title',    'High product quality' );
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
}
add_action( 'after_setup_theme', 'steelplast_register_wpml_strings' );

/**
 * Helper: get translated string by context + key.
 * Usage: steelplast_t( 'steelplast/home/hero', 'title', 'Default' )
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