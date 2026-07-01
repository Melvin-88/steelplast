<?php
/**
 * Quality page — [03] Reliability built into every product.
 * Usage: get_template_part( 'template-parts/section-quality-reliability' );
 *
 * @package SteelPlast
 */

// Same image for every language — always read from the default-language post
$image = steelplast_get_field_default_lang( 'quality_reliability_image' );

$title = steelplast_t( 'steelplast/quality/reliability', 'title', 'Reliability built into every product' );

$bullets = [
    [
        'title' => steelplast_t( 'steelplast/quality/reliability', 'bullet_1_title', 'Longevity' ),
        'desc'  => steelplast_t( 'steelplast/quality/reliability', 'bullet_1_desc', 'Premium raw materials and anti-corrosion technologies guarantee a long service life, even in demanding conditions.' ),
    ],
    [
        'title' => steelplast_t( 'steelplast/quality/reliability', 'bullet_2_title', 'Compliance with standards' ),
        'desc'  => steelplast_t( 'steelplast/quality/reliability', 'bullet_2_desc', 'Our products meet national and international technical regulations (DSTU / ISO).' ),
    ],
    [
        'title' => steelplast_t( 'steelplast/quality/reliability', 'bullet_3_title', "Manufacturer's warranty" ),
        'desc'  => steelplast_t( 'steelplast/quality/reliability', 'bullet_3_desc', 'We take full responsibility for every shipped product and provide an official warranty.' ),
    ],
];
?>

<section class="sp-quality-reliability" aria-labelledby="quality-reliability-title">
    <div class="content-wrapper">

        <div class="sp-quality-reliability__header">

            <div class="sp-quality-reliability__intro-col">
                <p class="sp-section-label sp-section-label--light-bg">
                    <span class="sp-section-label__index" aria-hidden="true">[03]</span>
                    <?php echo esc_html( steelplast_t( 'steelplast/quality/reliability', 'label', 'Uncompromising Quality Control' ) ); ?>
                </p>
                <h2 id="quality-reliability-title" class="sp-quality-reliability__title sp-section-title">
                    <?php echo esc_html( $title ); ?>
                </h2>
            </div>

            <div class="sp-quality-reliability__text-col">
                <p class="sp-quality-reliability__intro sp-section-desc">
                    <?php echo esc_html( steelplast_t( 'steelplast/quality/reliability', 'intro', "We understand that the stability of your operations depends on our components, so we don't compromise on quality." ) ); ?>
                </p>
                <ul class="sp-quality-reliability__bullets">
                    <?php foreach ( $bullets as $bullet ) : ?>
                        <li class="sp-quality-reliability__bullet">
                            <span class="sp-quality-reliability__bullet-title"><?php echo esc_html( $bullet['title'] ); ?></span>
                            <span class="sp-quality-reliability__bullet-desc"><?php echo esc_html( $bullet['desc'] ); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>

        <?php if ( $image ) : ?>
            <div class="sp-quality-reliability__image">
                <img
                    src="<?php echo esc_url( $image['url'] ); ?>"
                    width="<?php echo esc_attr( $image['width'] ); ?>"
                    height="<?php echo esc_attr( $image['height'] ); ?>"
                    alt="<?php echo esc_attr( ! empty( $image['alt'] ) ? $image['alt'] : $title ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            </div>
        <?php endif; ?>

    </div>
</section>
