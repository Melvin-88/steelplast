<?php
/**
 * About page — [01] Who we are, with Europe map graphic.
 * Usage: get_template_part( 'template-parts/section-about-intro' );
 *
 * @package SteelPlast
 */

$label = steelplast_t( 'steelplast/about/intro', 'label', 'Who we are' );
$title = steelplast_t( 'steelplast/about/intro', 'title', 'A Ukrainian full-cycle manufacturer with 10+ years of experience' );
$desc = [
    steelplast_t( 'steelplast/about/intro', 'desc_1', 'We specialize in metalworking, mold production, metal stamping and plastic injection molding.' ),
    steelplast_t( 'steelplast/about/intro', 'desc_2', 'We help businesses turn ideas into a finished product, providing a complete manufacturing process — from engineering design and mold development to serial production and delivery of the finished goods to the client.' ),
    steelplast_t( 'steelplast/about/intro', 'desc_3', 'Our facility is equipped with modern high-precision machinery, including CNC turning and milling machines, EDM systems, injection molding machines and stamping presses. This allows us to deliver projects of any complexity while maintaining the highest standards of quality and precision.' ),
];
?>

<section class="sp-about-intro" aria-labelledby="sp-about-intro-title">

    <div class="content-wrapper">
        <div class="sp-about-intro__content">
            <p class="sp-section-label sp-section-label--light-bg">
                <span class="sp-section-label__index" aria-hidden="true">[01]</span>
                <?php echo esc_html( $label ); ?>
            </p>

            <h2 class="sp-about-intro__title sp-section-title" id="sp-about-intro-title">
                <?php echo esc_html( $title ); ?>
            </h2>

            <div class="sp-about-intro__desc">
                <?php foreach ( $desc as $paragraph ) : ?>
                    <p class="sp-section-desc"><?php echo esc_html( $paragraph ); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</section>
