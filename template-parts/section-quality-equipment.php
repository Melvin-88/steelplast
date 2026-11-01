<?php
/**
 * Quality page — [01] Equipment & process overview (3 image cards).
 * Reuses the "sp-services" card style/component shared with the home page Services section.
 * Usage: get_template_part( 'template-parts/section-quality-equipment' );
 *
 * @package SteelPlast
 */

// Images are the same for every language — always read from the
// default-language post (see steelplast_get_field_default_lang()).
$cards = [
    [
        'id'       => 'equipment',
        'title'    => steelplast_t( 'steelplast/quality/equipment', 'card_1_title', 'Modern Equipment Fleet' ),
        'desc'     => steelplast_t( 'steelplast/quality/equipment', 'card_1_desc', 'Our production equipment is regularly upgraded in line with the highest manufacturing standards.' ),
        'image_id' => steelplast_get_field_default_lang( 'quality_equipment_card_1_image' ) ?: 0,
    ],
    [
        'id'       => 'automation',
        'title'    => steelplast_t( 'steelplast/quality/equipment', 'card_2_title', 'Process Automation' ),
        'desc'     => steelplast_t( 'steelplast/quality/equipment', 'card_2_desc', 'Automated processes minimize human error and maintain consistent quality in every production batch.' ),
        'image_id' => steelplast_get_field_default_lang( 'quality_equipment_card_2_image' ) ?: 0,
    ],
    [
        'id'       => 'team',
        'title'    => steelplast_t( 'steelplast/quality/equipment', 'card_3_title', 'Highly Qualified Team' ),
        'desc'     => steelplast_t( 'steelplast/quality/equipment', 'card_3_desc', 'Our engineers and operators have many years of experience in precision manufacturing.' ),
        'image_id' => steelplast_get_field_default_lang( 'quality_equipment_card_3_image' ) ?: 0,
    ],
];
?>

<section class="sp-services" aria-labelledby="quality-equipment-title">
    <div class="content-wrapper">

        <header class="sp-services__header" data-sp-animate>
            <p class="sp-section-label sp-section-label--light-bg">
                <span class="sp-section-label__index" aria-hidden="true">[01]</span>
                <?php echo esc_html( steelplast_t( 'steelplast/quality/equipment', 'section_label', 'Production' ) ); ?>
            </p>
            <h2 id="quality-equipment-title" class="sp-services__title sp-section-title">
                <?php echo esc_html( steelplast_t( 'steelplast/quality/equipment', 'title', 'Our Own Modern Production Facility' ) ); ?>
            </h2>
            <p class="sp-services__description sp-section-desc">
                <?php echo esc_html( steelplast_t( 'steelplast/quality/equipment', 'description', 'Our own modern production facility allows us to deliver projects of any complexity, from series products to custom orders built to client drawings.' ) ); ?>
            </p>
        </header>

        <div class="sp-services__grid" data-sp-animate-group>
            <?php foreach ( $cards as $card ) : ?>
                <?php get_template_part( 'template-parts/component-image-card', null, $card ); ?>
            <?php endforeach; ?>
        </div>

    </div>
</section>
