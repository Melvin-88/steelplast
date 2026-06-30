<?php
/**
 * Post card component — reusable across news section and archive page.
 *
 * @package SteelPlast
 *
 * Pass $args via get_template_part() fourth argument:
 *   'post_id' (int)    — WP post ID, defaults to current post in loop
 *   'heading'  (string) — heading tag, defaults to 'h3'
 */

$post_id = $args['post_id'] ?? get_the_ID();
$heading  = $args['heading']  ?? 'h3';

$title    = get_the_title( $post_id );
$excerpt  = get_the_excerpt( $post_id );
$link     = get_permalink( $post_id );
$date_raw = get_the_date( 'd.m.Y', $post_id );

$thumb_id  = get_post_thumbnail_id( $post_id );
$thumb_src = $thumb_id
    ? wp_get_attachment_image_src( $thumb_id, 'large' )
    : null;

$read_more_label = steelplast_t( 'steelplast/post-card', 'read_more', 'Read more' );
?>

<article class="sp-post-card" aria-label="<?php echo esc_attr( $title ); ?>">

    <a class="sp-post-card__image-wrap" href="<?php echo esc_url( $link ); ?>" tabindex="-1" aria-hidden="true">
        <?php if ( $thumb_src ) : ?>
            <img
                class="sp-post-card__image"
                src="<?php echo esc_url( $thumb_src[0] ); ?>"
                width="<?php echo esc_attr( $thumb_src[1] ); ?>"
                height="<?php echo esc_attr( $thumb_src[2] ); ?>"
                alt="<?php echo esc_attr( $title ); ?>"
                loading="lazy"
                decoding="async"
            >
        <?php else : ?>
            <div class="sp-post-card__image sp-post-card__image--placeholder" aria-hidden="true"></div>
        <?php endif; ?>

        <time class="sp-post-card__date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d', $post_id ) ); ?>">
            <?php echo esc_html( $date_raw ); ?>
        </time>
    </a>

    <div class="sp-post-card__body">
        <<?php echo esc_attr( $heading ); ?> class="sp-post-card__title">
            <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a>
        </<?php echo esc_attr( $heading ); ?>>

        <?php if ( $excerpt ) : ?>
            <p class="sp-post-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
        <?php endif; ?>

        <a
            class="sp-btn sp-btn--ghost sp-btn--md sp-btn--full sp-btn--on-light"
            href="<?php echo esc_url( $link ); ?>"
        >
            <span class="sp-btn__icon" aria-hidden="true">↳</span>
            <?php echo esc_html( $read_more_label ); ?>
        </a>
    </div>

</article>
