<?php
/**
 * Template Name: About
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();
?>

<main id="primary" class="sp-main page-about">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => steelplast_t( 'steelplast/about/hero', 'title', 'About Steel Plast' ),
        'height' => 440,
    ] );
    ?>

    <?php get_template_part( 'template-parts/section-about-intro' ); ?>

    <?php get_template_part( 'template-parts/section-about-advantages' ); ?>

    <?php get_template_part( 'template-parts/section-about-audience' ); ?>

    <?php get_template_part( 'template-parts/section-about-equipment' ); ?>

    <?php get_template_part( 'template-parts/section-news' ); ?>

    <?php get_template_part( 'template-parts/section-contact' ); ?>

</main>

<?php
get_footer();
