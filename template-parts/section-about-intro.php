<?php
/**
 * About page — [01] Who we are, with Europe map graphic.
 * Usage: get_template_part( 'template-parts/section-about-intro' );
 *
 * @package SteelPlast
 */

$label = steelplast_t( 'steelplast/about/intro', 'label', 'Steel Plast is' );
$title = steelplast_t( 'steelplast/about/intro', 'title', 'Modern manufacturing for the light engineering industry' );
$desc = [
    steelplast_t( 'steelplast/about/intro', 'desc_1', 'We bring the key manufacturing processes together in one place: metalworking, mold making, metal stamping and plastic injection molding. We take a project on at any stage — from the initial idea and engineering design through to the start of series production and the finished goods.' ),
    steelplast_t( 'steelplast/about/intro', 'desc_2', 'A full cycle inside a single plant means fewer links in the chain, more control and a clear result at every stage.' ),
    steelplast_t( 'steelplast/about/intro', 'desc_3', 'Our facility is equipped with modern high-precision machinery, including CNC turning, milling and EDM machines, injection molding machines and stamping presses. This lets us deliver projects of any complexity while holding to the highest standards of quality and precision.' ),
];
?>

<section class="sp-about-intro" aria-labelledby="sp-about-intro-title">

    <div class="content-wrapper">
        <div class="sp-about-intro__content" data-sp-animate>
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
