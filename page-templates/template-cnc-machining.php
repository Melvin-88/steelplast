<?php
/**
 * Template Name: CNC Machining
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();
?>

<main id="primary" class="sp-main page-cnc-machining">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => steelplast_t( 'steelplast/service-cnc-machining/hero', 'title', 'CNC Metal Machining: Precision Milling & Turning' ),
        'height' => 440,
    ] );
    ?>

    <?php get_template_part( 'template-parts/section-service-specs' ); ?>

    <?php get_template_part( 'template-parts/section-service-content' ); ?>

    <?php
    get_template_part( 'template-parts/section-about-preview', null, [
        'tag' => steelplast_t( 'steelplast/service-cnc-machining/about', 'tag', '[03] About us' ),
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-quality', null, [
        'label_index' => '[04]',
    ] );
    ?>

    <?php get_template_part( 'template-parts/section-contact' ); ?>

</main>

<?php
get_footer();
