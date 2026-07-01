<?php
/**
 * The template for displaying all pages
 *
 * @package SteelPlast
 */

get_header();
?>

<main id="primary" class="sp-main">

    <?php get_template_part( 'template-parts/page-hero' ); ?>

    <div class="content-wrapper sp-page-content">
        <?php while ( have_posts() ) : the_post(); ?>
            <h2 class="sp-page-content__title"><?php the_title(); ?></h2>
            <div class="sp-page-content__body">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>

</main>

<?php get_footer();
