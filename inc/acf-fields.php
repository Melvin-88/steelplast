<?php
/**
 * ACF field group definitions
 * Registered in code — portable across environments, no DB dependency.
 */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

// =============================================
// Home Page — Hero video
// =============================================

acf_add_local_field_group( [
    'key'    => 'group_home_hero',
    'title'  => 'Home — Hero Video',
    'fields' => [
        [
            'key'           => 'field_hero_video',
            'label'         => 'Hero background video (MP4)',
            'name'          => 'hero_video',
            'type'          => 'file',
            'return_format' => 'url',
            'mime_types'    => 'mp4',
            'instructions'  => 'Upload an MP4 file. Recommended: 1920×1080, compressed for web.',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'front-page.php',
            ],
        ],
    ],
    'menu_order' => -10,
    'position'   => 'normal',
    'style'      => 'default',
] );

// =============================================
// All pages — Hero background image
// =============================================

acf_add_local_field_group( [
    'key'    => 'group_page_hero',
    'title'  => 'Page — Hero Image',
    'fields' => [
        [
            'key'           => 'field_page_hero_image',
            'label'         => 'Hero background image',
            'name'          => 'page_hero_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'large',
            'mime_types'    => 'jpg,jpeg,png,webp',
            'instructions'  => 'Recommended: 1920×600px or wider. Used as page header background.',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'page',
            ],
            [
                'param'    => 'page_template',
                'operator' => '!=',
                'value'    => 'front-page.php',
            ],
        ],
    ],
    'menu_order' => -10,
    'position'   => 'normal',
    'style'      => 'default',
] );

// =============================================
// Contacts Page
// =============================================

acf_add_local_field_group( [
    'key'    => 'group_contacts_page',
    'title'  => 'Contacts Page',
    'fields' => [

        // Intro text
        [
            'key'   => 'field_contact_intro',
            'label' => 'Intro text',
            'name'  => 'contact_intro',
            'type'  => 'textarea',
            'rows'  => 3,
        ],

        // ---- Emails (2 slots — labels via WPML) ----
        [ 'key' => 'field_email_1_address', 'label' => 'Email 1', 'name' => 'email_1_address', 'type' => 'text' ],
        [ 'key' => 'field_email_2_address', 'label' => 'Email 2', 'name' => 'email_2_address', 'type' => 'text' ],

        // ---- Phones (3 slots — labels via WPML) ----
        [ 'key' => 'field_phone_1_number', 'label' => 'Phone 1', 'name' => 'phone_1_number', 'type' => 'text' ],
        [ 'key' => 'field_phone_2_number', 'label' => 'Phone 2', 'name' => 'phone_2_number', 'type' => 'text' ],
        [ 'key' => 'field_phone_3_number', 'label' => 'Phone 3', 'name' => 'phone_3_number', 'type' => 'text' ],

        // Google Maps embed URL
        [
            'key'          => 'field_contact_map_url',
            'label'        => 'Google Maps embed URL',
            'name'         => 'contact_map_url',
            'type'         => 'text',
            'instructions' => 'Paste the src URL from Google Maps → Share → Embed a map.',
        ],

    ],
    'location' => [
        [
            [
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'page-templates/page-contacts.php',
            ],
        ],
    ],
    'menu_order' => 0,
    'position'   => 'normal',
    'style'      => 'default',
] );

// =============================================
// Home Page — Services section images
// =============================================

acf_add_local_field_group( [
    'key'    => 'group_home_services',
    'title'  => 'Home — Services Images',
    'fields' => [
        [
            'key'           => 'field_services_card_1_image',
            'label'         => 'Card 1 — Metal Processing',
            'name'          => 'services_card_1_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'           => 'field_services_card_2_image',
            'label'         => 'Card 2 — Plastic Casting',
            'name'          => 'services_card_2_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'           => 'field_services_card_3_image',
            'label'         => 'Card 3 — Laser Cutting',
            'name'          => 'services_card_3_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'           => 'field_services_card_4_image',
            'label'         => 'Card 4 — Stamping (side image)',
            'name'          => 'services_card_4_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'           => 'field_services_card_5_image',
            'label'         => 'Card 5 — Powder Coating',
            'name'          => 'services_card_5_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'front-page.php',
            ],
        ],
    ],
    'menu_order'            => 0,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
] );

// =============================================
// Home Page — About Preview section images
// =============================================

acf_add_local_field_group( [
    'key'    => 'group_home_about_preview',
    'title'  => 'Home — About Preview Images',
    'fields' => [
        [
            'key'           => 'field_sp_about_image_1',
            'label'         => 'Photo 1 (top, left chevron)',
            'name'          => 'sp_about_image_1',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'           => 'field_sp_about_image_2',
            'label'         => 'Photo 2 (middle, right chevron)',
            'name'          => 'sp_about_image_2',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'           => 'field_sp_about_image_3',
            'label'         => 'Photo 3 (bottom, left chevron)',
            'name'          => 'sp_about_image_3',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'front-page.php',
            ],
        ],
    ],
    'menu_order'            => 20,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
] );

// =============================================
// Quality Page — section images & downloadable files
// =============================================

acf_add_local_field_group( [
    'key'    => 'group_quality_page',
    'title'  => 'Quality Page — Images & Files',
    'fields' => [
        // [01] Equipment cards
        [
            'key'           => 'field_quality_equipment_card_1_image',
            'label'         => 'Equipment card 1 — image',
            'name'          => 'quality_equipment_card_1_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'           => 'field_quality_equipment_card_2_image',
            'label'         => 'Equipment card 2 — image',
            'name'          => 'quality_equipment_card_2_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'           => 'field_quality_equipment_card_3_image',
            'label'         => 'Equipment card 3 — image',
            'name'          => 'quality_equipment_card_3_image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],

        // [03] Reliability
        [
            'key'           => 'field_quality_reliability_image',
            'label'         => 'Reliability section — image',
            'name'          => 'quality_reliability_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'large',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],

        // [04] ISO certification
        [
            'key'           => 'field_quality_cert_image',
            'label'         => 'Certification section — image',
            'name'          => 'quality_cert_image',
            'type'          => 'image',
            'return_format' => 'array',
            'preview_size'  => 'large',
            'mime_types'    => 'jpg,jpeg,png,webp',
        ],
        [
            'key'           => 'field_quality_cert_file_1',
            'label'         => 'Certificate file — ISO 9001 (PDF)',
            'name'          => 'quality_cert_file_1',
            'type'          => 'file',
            'return_format' => 'array',
            'mime_types'    => 'pdf',
        ],
        [
            'key'           => 'field_quality_cert_file_2',
            'label'         => 'Certificate file — Technical specifications (PDF)',
            'name'          => 'quality_cert_file_2',
            'type'          => 'file',
            'return_format' => 'array',
            'mime_types'    => 'pdf',
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'page-templates/template-quality.php',
            ],
        ],
    ],
    'menu_order'            => 0,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
] );
