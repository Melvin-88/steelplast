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
            'menu-1' => esc_html__( 'Primary', 'steelplast' ),
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
    wp_enqueue_style(
        'steelplast-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'steelplast-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array( 'steelplast-google-fonts' ),
        STEELPLAST_VERSION
    );

    wp_enqueue_script( 'steelplast-navigation', get_template_directory_uri() . '/js/navigation.js', array(), STEELPLAST_VERSION, true );
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