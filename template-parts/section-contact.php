<?php
/**
 * Reusable contact form section.
 * Usage: get_template_part( 'template-parts/section-contact' );
 * Args:  array( 'heading' => 'h1' )  — default h2
 *
 * The form is intentionally identical on every page (same fields, same
 * title/description) — do not add per-page overrides here.
 *
 * @package SteelPlast
 */

static $sp_contact_instance = 0;
$sp_contact_instance++;
$uid         = 'sp-contact-' . $sp_contact_instance;
$heading_tag = ( ! empty( $args['heading'] ) && in_array( strtolower( (string) $args['heading'] ), array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) ) ? strtolower( (string) $args['heading'] ) : 'h2';
?>

<section class="sp-contact-section" aria-labelledby="<?php echo esc_attr( $uid . '-title' ); ?>">
    <div class="content-wrapper">
        <div class="sp-contact-section__inner">

            <div class="sp-contact-section__bg" aria-hidden="true">
                <img
                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/contact-bg.png' ); ?>"
                    alt=""
                    width="1440"
                    height="600"
                    loading="lazy"
                >
            </div>

            <div class="sp-contact-section__text" data-sp-animate>
                <<?php echo esc_attr( $heading_tag ); ?> class="sp-contact-section__title sp-section-title" id="<?php echo esc_attr( $uid . '-title' ); ?>">
                    <?php echo esc_html( steelplast_t( 'steelplast/contacts/hero', 'contact_hero_title', 'Still have questions?' ) ); ?>
                </<?php echo esc_attr( $heading_tag ); ?>>
                <p class="sp-contact-section__desc sp-section-desc">
                    <?php echo esc_html( steelplast_t( 'steelplast/contacts/hero', 'contact_hero_desc', 'Leave your request and we will contact you within 2 hours.' ) ); ?>
                </p>
            </div>

            <div class="sp-contact-section__form-wrap" data-sp-animate>
                <?php get_template_part( 'template-parts/contact-form', null, [ 'uid' => $uid ] ); ?>
            </div>

        </div>
    </div>
</section>
