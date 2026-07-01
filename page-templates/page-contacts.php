<?php
/**
 * Template Name: Contacts (Details)
 *
 * @package SteelPlast
 */

get_header();

$has_acf = function_exists( 'get_field' );

// Intro text is translatable copy — kept per-language.
$intro = $has_acf ? get_field( 'contact_intro' ) : '';

// Map, emails and phone numbers are the same for every language — always
// read from the default-language post (see steelplast_get_field_default_lang()).
$map_url = steelplast_get_field_default_lang( 'contact_map_url' );

// Email labels from WPML
$email_labels = [
    1 => steelplast_t( 'steelplast/contacts/page', 'email_1_label', 'General inquiries and orders' ),
    2 => steelplast_t( 'steelplast/contacts/page', 'email_2_label', 'Supply department' ),
];

// Build emails array — skip empty slots
$emails = [];
for ( $i = 1; $i <= 2; $i++ ) {
    $address_raw = steelplast_get_field_default_lang( "email_{$i}_address" );
    $address     = sanitize_email( $address_raw );
    if ( $address && is_email( $address ) ) {
        $emails[] = [
            'label'   => $email_labels[ $i ] ?? '',
            'address' => $address,
        ];
    }
}

// Phone labels from WPML
$phone_labels = [
    1 => steelplast_t( 'steelplast/contacts/page', 'phone_1_label', 'Sales department (consultations and orders)' ),
    2 => steelplast_t( 'steelplast/contacts/page', 'phone_2_label', 'Technical department (drawing questions)' ),
    3 => steelplast_t( 'steelplast/contacts/page', 'phone_3_label', 'Partner hotline' ),
];

// Build phones array — skip empty slots
$phones = [];
for ( $i = 1; $i <= 3; $i++ ) {
    $number = steelplast_get_field_default_lang( "phone_{$i}_number" );
    if ( $number ) {
        $phones[] = [
            'label'  => $phone_labels[ $i ] ?? '',
            'number' => $number,
        ];
    }
}

// Location — from WPML strings
$locations = [ [
    'label'   => steelplast_t( 'steelplast/contacts/page', 'location_label',   'Head office and production' ),
    'address' => steelplast_t( 'steelplast/contacts/page', 'location_address', "Avtobazivska St., 6\nPoltava, 36000\nPoltava region, Ukraine" ),
] ];
?>

<main id="main" class="sp-main sp-contacts-page" role="main">

    <section class="sp-contacts-page__hero">
        <div class="content-wrapper">
            <h1 class="sp-contacts-page__title"><?php echo esc_html( get_the_title() ); ?></h1>
            <?php if ( $intro ) : ?>
                <p class="sp-contacts-page__intro"><?php echo esc_html( $intro ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="sp-contacts-page__info" aria-label="<?php esc_attr_e( 'Contact information', 'steelplast' ); ?>">
        <div class="content-wrapper">
            <div class="sp-contacts-page__columns">

                <?php if ( ! empty( $emails ) ) : ?>
                    <div class="sp-contacts-page__col">
                        <h2 class="sp-contacts-page__col-title">
                            <?php echo esc_html( steelplast_t( 'steelplast/contacts/page', 'emails_heading', 'Email' ) ); ?>
                        </h2>
                        <ul class="sp-contacts-page__list">
                            <?php foreach ( $emails as $item ) : ?>
                                <li class="sp-contacts-page__item">
                                    <?php if ( $item['label'] ) : ?>
                                        <span class="sp-contacts-page__item-label"><?php echo esc_html( $item['label'] ); ?></span>
                                    <?php endif; ?>
                                    <a class="sp-contacts-page__item-value" href="mailto:<?php echo esc_attr( $item['address'] ); ?>">
                                        <?php echo esc_html( strtoupper( $item['address'] ) ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $phones ) ) : ?>
                    <div class="sp-contacts-page__col">
                        <h2 class="sp-contacts-page__col-title">
                            <?php echo esc_html( steelplast_t( 'steelplast/contacts/page', 'phones_heading', 'Phone' ) ); ?>
                        </h2>
                        <ul class="sp-contacts-page__list">
                            <?php foreach ( $phones as $item ) : ?>
                                <li class="sp-contacts-page__item">
                                    <?php if ( $item['label'] ) : ?>
                                        <span class="sp-contacts-page__item-label"><?php echo esc_html( $item['label'] ); ?></span>
                                    <?php endif; ?>
                                    <a class="sp-contacts-page__item-value" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $item['number'] ) ); ?>">
                                        <?php echo esc_html( $item['number'] ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $locations ) ) : ?>
                    <div class="sp-contacts-page__col">
                        <h2 class="sp-contacts-page__col-title">
                            <?php echo esc_html( steelplast_t( 'steelplast/contacts/page', 'locations_heading', 'Our locations' ) ); ?>
                        </h2>
                        <ul class="sp-contacts-page__list">
                            <?php foreach ( $locations as $item ) : ?>
                                <li class="sp-contacts-page__item">
                                    <?php if ( $item['label'] ) : ?>
                                        <span class="sp-contacts-page__item-label"><?php echo esc_html( $item['label'] ); ?></span>
                                    <?php endif; ?>
                                    <span class="sp-contacts-page__item-value">
                                        <?php echo nl2br( esc_html( $item['address'] ) ); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <?php // Set map language — replace embedded language code in pb parameter + add hl param
if ( $map_url ) {
    $map_lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : 'en';
    $map_lang = sanitize_key( strtolower( $map_lang ) );
    // Replace !1sXX or !1sXX-YY language codes inside the pb hash
    $map_url  = preg_replace( '/!1s[a-z]{2}(?:-[a-z]{2})?(?=[^a-z-])/', '!1s' . $map_lang, $map_url );
    $map_url  = add_query_arg( 'hl', $map_lang, $map_url );
}

if ( $map_url ) : ?>
        <section class="sp-contacts-page__map" aria-label="<?php esc_attr_e( 'Map', 'steelplast' ); ?>">
            <div class="content-wrapper">
                <iframe
                    class="sp-contacts-page__map-frame"
                    src="<?php echo esc_url( $map_url ); ?>"
                    width="100%"
                    height="480"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="<?php esc_attr_e( 'Location map', 'steelplast' ); ?>"
                ></iframe>
            </div>
        </section>
    <?php endif; ?>

</main>

<?php get_footer();
