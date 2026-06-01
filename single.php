<?php
/**
 * The template for displaying all single posts
 *
 * @package SteelPlast
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
            <?php the_post_navigation(); ?>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_sidebar();
get_footer();