<?php
/**
 * ACF field group definitions
 * Registered in code — portable across environments, no DB dependency.
 */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

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
    'menu_order'            => 10,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
] );
