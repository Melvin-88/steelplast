<?php
/**
 * Reusable contact form section.
 * Usage: get_template_part( 'template-parts/section-contact' );
 * Args:  array( 'heading' => 'h1' )  — default h2
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

            <div class="sp-contact-section__text">
                <<?php echo esc_attr( $heading_tag ); ?> class="sp-contact-section__title" id="<?php echo esc_attr( $uid . '-title' ); ?>">
                    <?php echo esc_html( steelplast_t( 'steelplast/contacts/hero', 'contact_hero_title', 'Still have questions?' ) ); ?>
                </<?php echo esc_attr( $heading_tag ); ?>>
                <p class="sp-contact-section__desc">
                    <?php echo esc_html( steelplast_t( 'steelplast/contacts/hero', 'contact_hero_desc', 'Leave your request and we will contact you within 2 hours.' ) ); ?>
                </p>
            </div>

            <div class="sp-contact-section__form-wrap">
                <form
                    class="sp-contact-form"
                    id="<?php echo esc_attr( $uid . '-form' ); ?>"
                    method="post"
                    novalidate
                    aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/contacts/form', 'contact_form_aria', 'Contact form' ) ); ?>"
                >
                    <?php wp_nonce_field( 'sp_contact_form', 'sp_contact_nonce' ); ?>

                    <div class="sp-form-field" data-field="name">
                        <input
                            type="text"
                            name="sp_name"
                            class="sp-form-input"
                            placeholder="<?php echo esc_attr( steelplast_t( 'steelplast/contacts/form', 'field_name_placeholder', 'Your name' ) ); ?>"
                            aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/contacts/form', 'field_name_placeholder', 'Your name' ) ); ?>"
                            required
                            autocomplete="name"
                            maxlength="100"
                        >
                        <span class="sp-form-error" aria-live="polite"></span>
                    </div>

                    <div class="sp-form-field" data-field="email">
                        <input
                            type="email"
                            name="sp_email"
                            class="sp-form-input"
                            placeholder="<?php echo esc_attr( steelplast_t( 'steelplast/contacts/form', 'field_email_placeholder', 'E-mail' ) ); ?>"
                            aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/contacts/form', 'field_email_placeholder', 'E-mail' ) ); ?>"
                            autocomplete="email"
                            maxlength="150"
                        >
                        <span class="sp-form-error" aria-live="polite"></span>
                    </div>

                    <div class="sp-form-field" data-field="phone">
                        <input
                            type="tel"
                            name="sp_phone"
                            class="sp-form-input"
                            placeholder="<?php echo esc_attr( steelplast_t( 'steelplast/contacts/form', 'field_phone_placeholder', 'Phone' ) ); ?>"
                            aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/contacts/form', 'field_phone_placeholder', 'Phone' ) ); ?>"
                            autocomplete="tel"
                        >
                        <span class="sp-form-error" aria-live="polite"></span>
                    </div>

                    <div class="sp-form-field" data-field="comment">
                        <textarea
                            name="sp_comment"
                            class="sp-form-input sp-form-textarea"
                            placeholder="<?php echo esc_attr( steelplast_t( 'steelplast/contacts/form', 'field_comment_placeholder', 'Your message (optional)' ) ); ?>"
                            aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/contacts/form', 'field_comment_placeholder', 'Your message (optional)' ) ); ?>"
                            rows="1"
                            maxlength="1000"
                        ></textarea>
                        <span class="sp-form-error" aria-live="polite"></span>
                    </div>

                    <div class="sp-form-global-error" role="alert" aria-live="assertive"></div>

                    <button type="submit" class="sp-contact-btn">
                        <span class="sp-contact-btn__label">
                            <?php echo esc_html( steelplast_t( 'steelplast/contacts/form', 'submit_label', 'Send request' ) ); ?>
                        </span>
                        <span class="sp-contact-btn__icon" aria-hidden="true">↵</span>
                    </button>

                    <div class="sp-form-success" role="status" aria-live="polite" hidden>
                        <?php echo esc_html( steelplast_t( 'steelplast/contacts/form', 'success_message', 'Thank you! We will contact you soon.' ) ); ?>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
