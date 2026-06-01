<?php
/**
 * The template for displaying front page
 *
 * @package SteelPlast
 * Template Name: Front Page
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        // Hero section - can be managed via ACF or customizer
        if ( is_active_sidebar( 'hero-section' ) ) :
            dynamic_sidebar( 'hero-section' );
        else :
            ?>
            <section class="hero-section">
                <h1><?php bloginfo( 'name' ); ?></h1>
                <p><?php bloginfo( 'description' ); ?></p>
            </section>
            <?php
        endif;
        ?>

        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();