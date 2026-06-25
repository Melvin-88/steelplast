<?php
/**
 * The template for displaying front page
 *
 * @package SteelPlast
 * Template Name: Front Page
 */

get_header();

$video_url = get_template_directory_uri() . '/assets/video/hero.mp4';

$hero_title       = steelplast_t( 'steelplast/home/hero', 'title',       'BUILD FOR<br>REPEATABILITY' );
$hero_description = steelplast_t( 'steelplast/home/hero', 'description', 'STEELPLAST is a team that turns ideas into finished products. We provide a full production cycle: from mold design and manufacturing to serial part production.' );

$stats = [
    [
        'value' => '98.7%',
        'label' => steelplast_t( 'steelplast/home/hero', 'stat_1_label', 'Cycle repeatability' ),
    ],
    [
        'value' => '120k',
        'label' => steelplast_t( 'steelplast/home/hero', 'stat_2_label', 'Mold resource' ),
    ],
    [
        'value' => '6x',
        'label' => steelplast_t( 'steelplast/home/hero', 'stat_3_label', 'Quality control stages' ),
    ],
];
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
                        <span class="sp-hero__stat-value"><?php echo esc_html( $stat['value'] ); ?></span>
                        <span class="sp-hero__stat-divider" aria-hidden="true"></span>
                        <span class="sp-hero__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </section>

    <?php get_template_part( 'template-parts/home-services' ); ?>

    <?php get_template_part( 'template-parts/section-contact' ); ?>

</main>

<?php
get_footer();