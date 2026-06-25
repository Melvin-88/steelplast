<?php
/**
 * Theme Customizer — global site settings
 * Admin → Appearance → Customize → Site Settings
 *
 * @package SteelPlast
 */

// =============================================
// Register settings & controls
// =============================================

add_action( 'customize_register', 'steelplast_customizer_register' );

function steelplast_customizer_register( WP_Customize_Manager $wp_customize ) {

    // -----------------------------------------
    // Panel: Site Settings
    // -----------------------------------------
    $wp_customize->add_panel( 'steelplast_site_settings', array(
        'title'    => __( 'Site Settings', 'steelplast' ),
        'priority' => 30,
    ) );

    // =========================================
    // Section: Contacts
    // =========================================
    $wp_customize->add_section( 'steelplast_contacts', array(
        'title' => __( 'Contacts', 'steelplast' ),
        'panel' => 'steelplast_site_settings',
    ) );

    $contact_fields = array(
        'site_phone'   => array( 'label' => __( 'Phone', 'steelplast' ),   'type' => 'text' ),
        'site_email'   => array( 'label' => __( 'Email', 'steelplast' ),   'type' => 'email' ),
        'site_address' => array( 'label' => __( 'Address', 'steelplast' ), 'type' => 'textarea' ),
    );

    foreach ( $contact_fields as $key => $args ) {
        if ( 'site_email' === $key ) {
            $sanitize = 'sanitize_email';
        } elseif ( 'site_address' === $key ) {
            $sanitize = 'sanitize_textarea_field';
        } else {
            $sanitize = 'sanitize_text_field';
        }
        $wp_customize->add_setting( $key, array(
            'default'           => '',
            'sanitize_callback' => $sanitize,
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $args['label'],
            'section' => 'steelplast_contacts',
            'type'    => $args['type'],
        ) );
    }

    // =========================================
    // Section: Contact Form
    // =========================================
    $wp_customize->add_section( 'steelplast_contact_form', array(
        'title'       => __( 'Contact Form', 'steelplast' ),
        'description' => __( 'Settings for the contact form submissions.', 'steelplast' ),
        'panel'       => 'steelplast_site_settings',
    ) );

    // Email where form submissions are sent
    $wp_customize->add_setting( 'contact_form_email', array(
        'default'           => get_option( 'admin_email' ),
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'contact_form_email', array(
        'label'       => __( 'Notification email', 'steelplast' ),
        'description' => __( 'Form submissions will be sent to this address. Defaults to the site admin email.', 'steelplast' ),
        'section'     => 'steelplast_contact_form',
        'type'        => 'email',
    ) );

    // Optional CC email
    $wp_customize->add_setting( 'contact_form_email_cc', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'contact_form_email_cc', array(
        'label'       => __( 'CC email (optional)', 'steelplast' ),
        'description' => __( 'Send a copy to this address as well.', 'steelplast' ),
        'section'     => 'steelplast_contact_form',
        'type'        => 'email',
    ) );

    // =========================================
    // Section: Social Media
    // =========================================
    $wp_customize->add_section( 'steelplast_social', array(
        'title' => __( 'Social Media', 'steelplast' ),
        'panel' => 'steelplast_site_settings',
    ) );

    $social_fields = array(
        'social_facebook'  => 'Facebook',
        'social_linkedin'  => 'LinkedIn',
        'social_instagram' => 'Instagram',
        'social_youtube'   => 'YouTube',
    );

    foreach ( $social_fields as $key => $label ) {
        $wp_customize->add_setting( $key, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $label,
            'section' => 'steelplast_social',
            'type'    => 'url',
        ) );
    }
}

// =============================================
// Helper: get theme mod with fallback
// steelplast_mod( 'social_facebook' )
// =============================================

function steelplast_mod( $key, $fallback = '' ) {
    return get_theme_mod( $key, $fallback );
}

// =============================================
// Schema.org LocalBusiness — injected in <head>
// Feeds Google Knowledge Panel, rich results
// =============================================

add_action( 'wp_head', 'steelplast_schema_local_business', 5 );

function steelplast_schema_local_business() {
    // Yoast SEO outputs its own Organization schema — avoid duplicates
    if ( defined( 'WPSEO_VERSION' ) ) {
        return;
    }

    $phone   = steelplast_mod( 'site_phone' );
    $email   = steelplast_mod( 'site_email' );
    $address = steelplast_mod( 'site_address' );

    $social_urls = array_filter( array(
        steelplast_mod( 'social_facebook' ),
        steelplast_mod( 'social_linkedin' ),
        steelplast_mod( 'social_instagram' ),
        steelplast_mod( 'social_youtube' ),
    ) );

    $schema = array(
        '@context' => 'https://schema.org',
        '@type'    => 'ManufacturingBusiness',
        'name'     => get_bloginfo( 'name' ),
        'url'      => home_url( '/' ),
        'logo'     => get_template_directory_uri() . '/assets/img/logo-header.svg',
    );

    if ( $phone )   $schema['telephone']   = $phone;
    if ( $email )   $schema['email']       = $email;
    if ( $address ) $schema['address']     = array(
        '@type'           => 'PostalAddress',
        'streetAddress'   => $address,
    );
    if ( ! empty( $social_urls ) ) {
        $schema['sameAs'] = array_values( $social_urls );
    }

    printf(
        '<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT )
    );
}
