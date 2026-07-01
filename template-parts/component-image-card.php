<?php
/**
 * Reusable image + title + description (+ optional CTA) card.
 * "sp-services" card style — shared between the home Services section and other pages (e.g. Quality).
 * Usage: get_template_part( 'template-parts/component-image-card', null, $args );
 * Args: id, title, desc, image_id, cta_label (optional — omit to render without a footer button), cta_href (default '#')
 *
 * @package SteelPlast
 */

$card_id   = $args['id']        ?? '';
$title     = $args['title']     ?? '';
$desc      = $args['desc']      ?? '';
$image_id  = $args['image_id']  ?? 0;
$cta_label = $args['cta_label'] ?? '';
$cta_href  = $args['cta_href']  ?? '#';
?>

<article class="sp-services__card sp-services__card--with-image" data-service="<?php echo esc_attr( $card_id ); ?>">

    <div class="sp-services__card-image">
        <?php if ( $image_id ) : ?>
            <?php echo wp_get_attachment_image( (int) $image_id, 'medium', false, [
                'loading' => 'lazy',
                'class'   => 'sp-services__card-img',
            ] ); ?>
        <?php else : ?>
            <div class="sp-services__card-image-placeholder" aria-hidden="true"></div>
        <?php endif; ?>
    </div>

    <div class="sp-services__card-body">
        <h3 class="sp-services__card-title"><?php echo esc_html( $title ); ?></h3>
        <p class="sp-services__card-desc"><?php echo esc_html( $desc ); ?></p>
    </div>

    <?php if ( $cta_label ) : ?>
        <div class="sp-services__card-footer">
            <a href="<?php echo esc_url( $cta_href ); ?>" class="sp-btn sp-btn--ghost sp-btn--md sp-btn--full" aria-label="<?php echo esc_attr( $title . ' — ' . $cta_label ); ?>">
                <span><?php echo esc_html( $cta_label ); ?></span>
                <span class="sp-btn__icon" aria-hidden="true">↳</span>
            </a>
        </div>
    <?php endif; ?>

</article>
