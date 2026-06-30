<?php
/**
 * Inner page hero — background image from ACF field `page_hero_image`.
 * Usage: get_template_part( 'template-parts/page-hero' );
 *
 * @package SteelPlast
 *
 * Optional $args:
 *   'title'  (string) — heading shown over image; defaults to current page title
 *   'height' (int)    — CSS height in px; defaults to 440
 */

$image  = function_exists( 'get_field' ) ? get_field( 'page_hero_image' ) : null;
$title  = $args['title']  ?? get_the_title();
$height = $args['height'] ?? 440;
?>

<div
    class="sp-page-hero<?php echo $image ? '' : ' sp-page-hero--no-image'; ?>"
    style="--sp-page-hero-height: <?php echo esc_attr( $height ); ?>px"
    role="img"
    aria-label="<?php echo esc_attr( $image['alt'] ?? $title ); ?>"
>
    <?php if ( $image ) : ?>
        <img
            class="sp-page-hero__img"
            src="<?php echo esc_url( $image['url'] ); ?>"
            width="<?php echo esc_attr( $image['width'] ); ?>"
            height="<?php echo esc_attr( $image['height'] ); ?>"
            alt=""
            aria-hidden="true"
            loading="eager"
            decoding="async"
            fetchpriority="high"
        >
    <?php endif; ?>

    <div class="sp-page-hero__overlay" aria-hidden="true"></div>

    <?php if ( $title ) : ?>
        <div class="sp-page-hero__content content-wrapper">
            <h1 class="sp-page-hero__title"><?php echo esc_html( $title ); ?></h1>
        </div>
    <?php endif; ?>
</div>
