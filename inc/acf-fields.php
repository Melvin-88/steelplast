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
