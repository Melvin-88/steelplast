<?php
/**
 * SteelPlast functions and definitions
 *
 * @package SteelPlast
 */

if ( ! defined( 'STEELPLAST_VERSION' ) ) {
    define( 'STEELPLAST_VERSION', '1.0.0' );
}

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

    // Pass available WPML languages to JS for browser language detection
    if ( function_exists( 'icl_get_languages' ) ) {
        $wpml_langs     = icl_get_languages( 'skip_missing=0' );
        $langs_for_js   = array();
        $default_url    = home_url( '/' );

        foreach ( $wpml_langs as $lang ) {
            $langs_for_js[ strtolower( $lang['language_code'] ) ] = $lang['url'];
            if ( $lang['default_locale'] || $lang['language_code'] === 'en' ) {
                $default_url = $lang['url'];
            }
        }

        wp_localize_script( 'steelplast-header', 'steelplastLangs', array(
            'available'  => $langs_for_js,
            'defaultUrl' => $default_url,
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'steelplast_scripts' );

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
 */
add_filter( 'icl_show_translate_link', '__return_false' );
add_filter( 'wpml_show_footer_language_selector', '__return_false' );
add_action( 'wp_footer', function () {
    echo '<style>
        #wpml-footer-language-switcher,
        .wpml-ls-statics-footer,
        .wpml-ls-legacy-list-horizontal,
        .wpml-ls-legacy-dropdown,
        .wpml-ls,
        .otgs-development-site-notice,
        .otgs-is-showing-dev-site-notice,
        #otgs-development-site-notice,
        [class*="development-site"],
        [id*="development-site"] { display: none !important; }
    </style>';
}, 999 );

// Remove WPML footer language switcher widget completely
add_filter( 'wpml_footer_language_selector', '__return_false' );
remove_action( 'wp_footer', array( 'SitePress', 'footer_language_selector' ) );

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
        echo '<span class="lang-switcher">UA</span>';
        return;
    }

    $languages = icl_get_languages( 'skip_missing=0' );
    if ( empty( $languages ) ) return;

    $current = '';
    $others  = array();

    foreach ( $languages as $lang ) {
        if ( $lang['active'] ) {
            $current = strtoupper( $lang['language_code'] );
        } else {
            $others[] = $lang;
        }
    }

    $current_lang = null;
    foreach ( $languages as $lang ) {
        if ( $lang['active'] ) {
            $current_lang = $lang;
            break;
        }
    }
    ?>
    <div class="lang-switcher has-dropdown">
        <button class="lang-switcher__toggle dropdown-toggle" aria-expanded="false" aria-haspopup="true">
            <?php if ( ! empty( $current_lang['country_flag_url'] ) ) : ?>
                <img src="<?php echo esc_url( $current_lang['country_flag_url'] ); ?>" alt="" width="18" height="14" aria-hidden="true">
            <?php endif; ?>
            <?php echo esc_html( strtoupper( $current_lang['language_code'] ?? $current ) ); ?>
            <svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" aria-hidden="true" focusable="false">
                <path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <ul class="lang-dropdown" role="menu">
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
        $classes[] = 'nav-item';
        if ( $has_children ) {
            $classes[] = 'has-dropdown';
        }
        $class_names = implode( ' ', array_filter( array_map( 'esc_attr', $classes ) ) );

        $output .= '<li class="' . $class_names . '">';

        if ( $has_children && 0 === $depth ) {
            // Render as button so dropdown is keyboard-accessible
            $output .= '<button class="dropdown-toggle" aria-expanded="false" aria-haspopup="true">';
            $output .= esc_html( $item->title );
            $output .= '<svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" aria-hidden="true" focusable="false">';
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
        $output .= '<ul class="header-dropdown" role="menu">';
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</ul>';
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}

/**
 * Fallback nav when no menu is assigned — shows static links.
 */
function steelplast_fallback_nav() {
    $items = array(
        array( 'url' => home_url( '/' ),           'label' => 'Головна' ),
        array( 'url' => home_url( '/services/' ),   'label' => 'Послуги', 'children' => array(
            array( 'url' => home_url( '/services/cnc-machining/' ),        'label' => 'Механічна обробка металу на верстатах з ЧПУ' ),
            array( 'url' => home_url( '/services/cnc-milling/' ),          'label' => 'Фрезерні верстати з ЧПУ' ),
            array( 'url' => home_url( '/services/cnc-turning/' ),          'label' => 'Токарні верстати з приводним інструментом' ),
            array( 'url' => home_url( '/services/swiss-turning/' ),        'label' => 'Токарні верстати швейцарського типу' ),
        ) ),
        array( 'url' => home_url( '/about/' ),      'label' => 'Про нас' ),
        array( 'url' => home_url( '/faq/' ),        'label' => 'FAQ' ),
        array( 'url' => home_url( '/quality/' ),    'label' => 'Якість' ),
        array( 'url' => home_url( '/news/' ),       'label' => 'Новини' ),
    );

    echo '<ul class="header-nav__list">';
    foreach ( $items as $item ) {
        $has_children = ! empty( $item['children'] );
        $li_class     = $has_children ? ' class="nav-item has-dropdown"' : ' class="nav-item"';
        echo '<li' . $li_class . '>';

        if ( $has_children ) {
            echo '<button class="dropdown-toggle" aria-expanded="false" aria-haspopup="true">';
            echo esc_html( $item['label'] );
            echo '<svg class="chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" aria-hidden="true" focusable="false">';
            echo '<path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>';
            echo '</svg></button>';
            echo '<ul class="header-dropdown" role="menu">';
            foreach ( $item['children'] as $child ) {
                echo '<li><a href="' . esc_url( $child['url'] ) . '">' . esc_html( $child['label'] ) . '</a></li>';
            }
            echo '</ul>';
        } else {
            $aria = ( home_url( '/' ) === trailingslashit( $item['url'] ) && is_front_page() ) ? ' aria-current="page"' : '';
            echo '<a href="' . esc_url( $item['url'] ) . '"' . $aria . '>' . esc_html( $item['label'] ) . '</a>';
        }

        echo '</li>';
    }
    echo '</ul>';
}