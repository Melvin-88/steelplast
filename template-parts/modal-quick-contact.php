<?php
/**
 * Quick-contact modal — rendered once, sitewide (see footer.php).
 * Open it from anywhere by adding `data-sp-modal-open="quick-contact"`
 * to any link or button (see header.php CTA, single.php for examples).
 *
 * @package SteelPlast
 */
?>

<div class="sp-modal" data-sp-modal="quick-contact" aria-hidden="true">
    <div class="sp-modal__overlay" data-sp-modal-close></div>

    <div class="sp-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="sp-modal-quick-contact-title">
        <button
            type="button"
            class="sp-modal__close"
            data-sp-modal-close
            aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/global/modal-contact', 'close_aria', 'Close' ) ); ?>"
        >
            <span aria-hidden="true">&times;</span>
        </button>

        <h2 id="sp-modal-quick-contact-title" class="sp-modal__title">
            <?php echo esc_html( steelplast_t( 'steelplast/global/modal-contact', 'title', 'Get in touch' ) ); ?>
        </h2>
        <p class="sp-modal__desc">
            <?php echo esc_html( steelplast_t( 'steelplast/global/modal-contact', 'desc', 'Leave your contact details and we will get back to you shortly.' ) ); ?>
        </p>

        <?php get_template_part( 'template-parts/contact-form', null, [ 'uid' => 'sp-contact-modal' ] ); ?>
    </div>
</div>
