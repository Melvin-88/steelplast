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
 * Enqueue scripts and styles.
 */
function steelplast_scripts() {
    wp_enqueue_style( 'steelplast-style', get_stylesheet_uri(), array(), STEELPLAST_VERSION );
    
    wp_enqueue_script( 'steelplast-navigation', get_template_directory_uri() . '/js/navigation.js', array(), STEELPLAST_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'steelplast_scripts' );

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