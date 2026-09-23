<?php
/**
 * The template for displaying front page
 *
 * @package SteelPlast
 * Template Name: Front Page
 */

get_header();

// Same video for every language — always read from the default-language post
$video_url = steelplast_get_field_default_lang( 'hero_video' );
if ( ! $video_url ) {
    $video_url = get_template_directory_uri() . '/assets/video/hero.mp4';
}

$hero_title       = steelplast_t( 'steelplast/home/hero', 'title',       'BUILD FOR<br>REPEATABILITY' );
$hero_description = steelplast_t( 'steelplast/home/hero', 'description', 'STEELPLAST is a team that turns ideas into finished products. We provide a full production cycle: from mold design and manufacturing to serial part production.' );

// Figures come from the admin and grow on their own; see steelplast_hero_stat().
$stat_labels = [
    1 => steelplast_t( 'steelplast/home/hero', 'stat_1_label', 'Cycle repeatability' ),
    2 => steelplast_t( 'steelplast/home/hero', 'stat_2_label', 'Mold resource' ),
    3 => steelplast_t( 'steelplast/home/hero', 'stat_3_label', 'Quality control stages' ),
];

$stats = [];
foreach ( $stat_labels as $i => $label ) {
    $stat = steelplast_hero_stat( $i );
    if ( $stat ) {
        $stats[] = $stat + [ 'label' => $label ];
    }
}
?>

<main id="primary" class="sp-main">

    <section class="sp-hero" aria-label="<?php esc_attr_e( 'Hero section', 'steelplast' ); ?>">

        <video
            class="sp-hero__video"
            src="<?php echo esc_url( $video_url ); ?>"
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
            aria-hidden="true"
        ></video>

        <div class="sp-hero__overlay" aria-hidden="true"></div>

        <div class="sp-hero__inner">

            <div class="sp-hero__content">
                <h1 class="sp-hero__title"><?php echo wp_kses( $hero_title, [ 'br' => [] ] ); ?></h1>
                <p class="sp-hero__description"><?php echo esc_html( $hero_description ); ?></p>
            </div>

            <div class="sp-hero__stats" aria-label="<?php esc_attr_e( 'Key statistics', 'steelplast' ); ?>">
                <?php foreach ( $stats as $stat ) : ?>
                    <div class="sp-hero__stat">
                        <?php // The final figure is in the markup, so it is correct without JS. ?>
                        <span class="sp-hero__stat-value"
                            data-sp-count="<?php echo esc_attr( $stat['value'] ); ?>"
                            data-sp-count-decimals="<?php echo esc_attr( $stat['decimals'] ); ?>"
                            data-sp-count-suffix="<?php echo esc_attr( $stat['suffix'] ); ?>"
                        ><?php echo esc_html( $stat['text'] ); ?></span>
                        <span class="sp-hero__stat-divider" aria-hidden="true"></span>
                        <span class="sp-hero__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </section>

    <?php get_template_part( 'template-parts/home-services' ); ?>

    <?php get_template_part( 'template-parts/section-about-preview' ); ?>

    <?php // Card 1 (IATF 16949) is not shown on the home page; the three that
    // remain sit in a single row rather than wrapping to a second one.
    get_template_part( 'template-parts/section-quality', null, [
        'exclude' => [ 1 ],
        'columns' => 3,
    ] ); ?>

    <?php get_template_part( 'template-parts/section-collaboration' ); ?>

    <?php get_template_part( 'template-parts/section-news' ); ?>

    <?php get_template_part( 'template-parts/section-contact' ); ?>

</main>

<?php
get_footer();