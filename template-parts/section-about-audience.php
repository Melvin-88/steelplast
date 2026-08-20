<?php
/**
 * About page — [03] Who we help, with full-width photo below.
 * Usage: get_template_part( 'template-parts/section-about-audience' );
 *
 * @package SteelPlast
 */

// Same image for every language — always read from the default-language post
$image = steelplast_get_field_default_lang( 'about_audience_image' );

$label = steelplast_t( 'steelplast/about/audience', 'label', 'Why choose us' );
$title = steelplast_t( 'steelplast/about/audience', 'title', 'Who we help' );
$desc  = [
    steelplast_t( 'steelplast/about/audience', 'desc_1', 'Our clients are manufacturing companies, machine-building businesses, design bureaus, startups, furniture and construction product manufacturers, and other companies that need quality metal or plastic components.' ),
    steelplast_t( 'steelplast/about/audience', 'desc_2', 'We believe successful production starts with a reliable partnership. That is why Steel Plast is not just a contractor, but a team that takes responsibility for the result and helps clients deliver on their most demanding manufacturing tasks.' ),
];
?>

<section class="sp-about-audience" aria-labelledby="sp-about-audience-title">
    <div class="content-wrapper">

        <div class="sp-about-audience__header" data-sp-animate>

            <div class="sp-about-audience__intro-col">
                <p class="sp-section-label sp-section-label--light-bg">
                    <span class="sp-section-label__index" aria-hidden="true">[03]</span>
                    <?php echo esc_html( $label ); ?>
                </p>
                <h2 id="sp-about-audience-title" class="sp-about-audience__title sp-section-title">
                    <?php echo esc_html( $title ); ?>
                </h2>
            </div>

            <div class="sp-about-audience__text-col">
                <?php foreach ( $desc as $paragraph ) : ?>
                    <p class="sp-about-audience__desc sp-section-desc"><?php echo esc_html( $paragraph ); ?></p>
                <?php endforeach; ?>
            </div>

        </div>

        <?php if ( $image ) : ?>
            <div class="sp-about-audience__image" data-sp-animate>
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
