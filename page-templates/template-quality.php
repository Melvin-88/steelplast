<?php
/**
 * Template Name: Quality
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();
?>

<main id="primary" class="sp-main page-quality">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => steelplast_t( 'steelplast/quality/hero', 'title', 'Production and Quality: Standards You Can Trust' ),
        'height' => 440,
    ] );
    ?>

    <?php get_template_part( 'template-parts/section-quality-equipment' ); ?>

    <?php
    get_template_part( 'template-parts/section-collaboration', null, [
        'label_index' => '[02]',
        'label'       => steelplast_t( 'steelplast/quality/steps', 'label', 'Quality Management System' ),
        'title'       => steelplast_t( 'steelplast/quality/steps', 'title', "Our quality management system\ncovers the entire product lifecycle" ),
        'desc'        => [
            steelplast_t( 'steelplast/quality/steps', 'desc_1', 'We have structured our approach so that quality is controlled at every stage — from raw material intake to the finished, shipped product.' ),
        ],
        'steps' => [
            [
                'tag'   => steelplast_t( 'steelplast/quality/steps', 'step_1_tag', '01' ),
                'title' => steelplast_t( 'steelplast/quality/steps', 'step_1_title', 'Unified processing control' ),
                'text'  => steelplast_t( 'steelplast/quality/steps', 'step_1_text', 'Every processing stage is monitored under a single quality control protocol, from raw material to finished part.' ),
            ],
            [
                'tag'   => steelplast_t( 'steelplast/quality/steps', 'step_2_tag', '02' ),
                'title' => steelplast_t( 'steelplast/quality/steps', 'step_2_title', 'Dedicated controller' ),
                'text'  => steelplast_t( 'steelplast/quality/steps', 'step_2_text', 'A dedicated quality controller is assigned to each production batch, ensuring full accountability.' ),
            ],
            [
                'tag'   => steelplast_t( 'steelplast/quality/steps', 'step_3_tag', '03' ),
                'title' => steelplast_t( 'steelplast/quality/steps', 'step_3_title', 'Careful testing' ),
                'text'  => steelplast_t( 'steelplast/quality/steps', 'step_3_text', 'Finished products undergo thorough testing before shipment to confirm compliance with specifications.' ),
            ],
        ],
    ] );
    ?>

    <?php get_template_part( 'template-parts/section-quality-reliability' ); ?>

    <?php get_template_part( 'template-parts/section-quality-certification' ); ?>

    <?php get_template_part( 'template-parts/section-news' ); ?>

    <?php get_template_part( 'template-parts/section-contact' ); ?>

</main>

<?php
get_footer();
