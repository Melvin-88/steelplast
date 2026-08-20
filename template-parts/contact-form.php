<?php
/**
 * Reusable contact form fields — shared by the full contact section
 * (template-parts/section-contact.php) and the quick-contact modal
 * (template-parts/modal-quick-contact.php). Same fields, same validation,
 * same AJAX endpoint everywhere — do not fork this per usage.
 * Usage: get_template_part( 'template-parts/contact-form', null, [ 'uid' => $uid ] );
 *
 * @package SteelPlast
 */

$uid = $args['uid'] ?? 'sp-contact';
?>

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

    <div class="sp-contact-form__actions">
        <button type="submit" class="sp-contact-btn sp-btn sp-btn--primary sp-btn--lg sp-btn--on-light">
            <span><?php echo esc_html( steelplast_t( 'steelplast/contacts/form', 'submit_label', 'Send request' ) ); ?></span>
            <span class="sp-btn__icon" aria-hidden="true">↵</span>
        </button>
    </div>

    <div class="sp-form-success" role="status" aria-live="polite" hidden>
        <?php echo esc_html( steelplast_t( 'steelplast/contacts/form', 'success_message', 'Thank you! We will contact you soon.' ) ); ?>
    </div>
</form>
