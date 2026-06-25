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

    // Contact form JS — on Contacts page and front page
    if ( is_page_template( 'page-templates/template-contacts.php' ) || is_front_page() ) {
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

// Collaboration JS — front page only
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_front_page() ) return;
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
 * Pre-register all WPML strings so they appear in String Translation
 * without requiring a frontend page visit.
 */
add_action( 'init', function () {
    if ( ! function_exists( 'icl_register_string' ) ) {
        return;
    }

    $strings = [
        // Hero
        'steelplast/home/hero' => [
            'title'       => 'BUILD FOR<br>REPEATABILITY',
            'description' => 'STEELPLAST is a team that turns ideas into finished products. We provide a full production cycle: from mold design and manufacturing to serial part production.',
            'stat_1_label' => 'Cycle repeatability',
            'stat_2_label' => 'Mold resource',
            'stat_3_label' => 'Quality control stages',
        ],
        // Services
        'steelplast/home/services' => [
            'section_label'  => 'Our Services',
            'title'          => 'Modern equipment, manufacturing precision and quality control',
            'description'    => 'Individual approach to every project, official contracts, staged payments and constant communication',
            'cta_label'      => 'Learn more',
            'card_1_title'   => 'Metal Processing',
            'card_1_desc'    => 'High-precision CNC metal machining for parts of any complexity.',
            'card_2_title'   => 'Plastic Casting',
            'card_2_desc'    => 'Manufacturing plastic products by injection molding on modern thermoplastic machines.',
            'card_3_title'   => 'Laser Metal Cutting',
            'card_3_desc'    => 'High-precision laser metal cutting for parts of any complexity.',
            'card_4_title'   => 'Stamping',
            'card_4_desc'    => 'STEELPLAST manufactures stamped components for various industrial sectors.',
            'card_4_cap'     => 'Manufacturing capabilities:',
            'card_4_bullet_1' => 'Sheet metal processing 0.15–5 mm thick',
            'card_4_bullet_2' => 'Crank pneumatic presses',
            'card_4_bullet_3' => 'Maximum pressing force — up to 100 t',
            'card_5_title'   => 'Powder Coating',
            'card_5_desc'    => 'Powder coating of metal products ensuring uniform and durable finish.',
        ],
    ];

    foreach ( $strings as $context => $items ) {
        foreach ( $items as $name => $default ) {
            icl_register_string( $context, $name, $default );
        }
    }
} );

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
            $url        = ! empty( $item->url ) ? esc_url( $item->url ) : '#';
            $aria_current = ( $item->current ) ? ' aria-current="page"' : '';
            $output    .= '<a href="' . $url . '"' . $aria_current . '>';
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