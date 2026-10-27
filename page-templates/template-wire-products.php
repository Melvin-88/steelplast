<?php
/**
 * Template Name: Springs & Wire Products
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();

$ctx = 'steelplast/service-wire-products/specs';

$specs_cards = [
    [
        'title'    => steelplast_t( $ctx, 'card_1_title', 'Spring Types' ),
        'subtitle' => steelplast_t( $ctx, 'card_1_subtitle', 'We manufacture:' ),
        'blocks'   => [
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_1_item_1', 'Compression springs' ),
                    steelplast_t( $ctx, 'card_1_item_2', 'Extension springs' ),
                    steelplast_t( $ctx, 'card_1_item_3', 'Torsion springs' ),
                    steelplast_t( $ctx, 'card_1_item_4', 'Flat and shaped springs' ),
                    steelplast_t( $ctx, 'card_1_item_5', 'Retaining and spring rings' ),
                ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_1_note', 'Wire diameter from 0.3 to 4 mm.' ),
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_2_title', 'Wire Products' ),
        'subtitle' => steelplast_t( $ctx, 'card_2_subtitle', 'Core operations' ),
        'blocks'   => [
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_1_title', 'Forming' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_1_item_1', 'Spring coiling' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_2', '2D and 3D wire bending' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_3', 'Rings, hooks and clips' ),
                ],
            ],
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_2_title', 'Finishing' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_2_item_1', 'Resistance welding' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_2', 'Heat treatment and tempering' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_3', 'Electroplated or powder coating' ),
                ],
            ],
        ],
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_3_title', 'Materials & Precision' ),
        'subtitle' => steelplast_t( $ctx, 'card_3_subtitle', 'We work with' ),
        'blocks'   => [
            [
                'type'  => 'stat',
                'value' => '±0,05 mm',
                'label' => steelplast_t( $ctx, 'card_3_stat_label', 'Geometry repeatability' ),
            ],
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_3_item_1', 'Spring wire' ),
                    steelplast_t( $ctx, 'card_3_item_2', 'Stainless steel' ),
                    steelplast_t( $ctx, 'card_3_item_3', 'Galvanised and low-carbon wire' ),
                    steelplast_t( $ctx, 'card_3_item_4', 'Brass and bronze' ),
                ],
            ],
        ],
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_4_title', 'Lead Time & Terms' ),
        'subtitle' => steelplast_t( $ctx, 'card_4_subtitle', 'Fast & reliable' ),
        'blocks'   => [
            [
                'type'   => 'stat',
                'value'  => '7',
                'suffix' => steelplast_t( $ctx, 'card_4_stat_suffix', 'business days' ),
                'label'  => steelplast_t( $ctx, 'card_4_stat_label', 'Production starts from' ),
            ],
            [
                'type'  => 'badges',
                'label' => steelplast_t( $ctx, 'card_4_badges_label', 'We accept files in:' ),
                'items' => [ 'DWG', 'DXF', 'STEP', 'PDF' ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_4_note', 'No drawing? Send us a sample part and we will reproduce its geometry.' ),
    ],
];
?>

<main id="primary" class="sp-main page-wire-products">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => steelplast_t( 'steelplast/service-wire-products/hero', 'title', 'Springs and Wire Products Made to Order' ),
        'height' => 440,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-specs', null, [
        'label' => steelplast_t( $ctx, 'label', 'Technical Parameters' ),
        'title' => steelplast_t( $ctx, 'title', 'Steel Plast manufactures springs and formed wire parts — from your drawing or sample to a finished batch' ),
        'desc'  => [
            steelplast_t( $ctx, 'desc_1', 'We run small and medium batches, holding the same geometry on every part of the order.' ),
            steelplast_t( $ctx, 'desc_2', 'A spring is rarely a catalogue item: wire diameter, pitch, load and fitting dimensions are all dictated by your assembly. We coil, bend and heat-treat in-house, so the geometry follows the part instead of the other way round.' ),
        ],
        'cards' => $specs_cards,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-content', null, [
        'label'  => steelplast_t( 'steelplast/service-wire-products/content', 'label', 'Springs & Wire' ),
        'title'  => steelplast_t( 'steelplast/service-wire-products/content', 'title', 'Springs and Formed Wire Parts for Industry and Everyday Products' ),
        'intro'  => steelplast_t( 'steelplast/service-wire-products/content', 'intro', 'A spring is rarely a product in itself — it works inside a lock, a furniture mechanism, a household appliance or an agricultural assembly, and how long that assembly lasts depends on it. We make parts like these in small and medium batches, to a drawing or to a sample.' ),
        'topics' => [
            [
                'heading'    => steelplast_t( 'steelplast/service-wire-products/content', 'topic_1_heading', 'Made-to-Order Springs' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-wire-products/content', 'topic_1_p1', 'We coil compression, extension and torsion springs from wire between 0.3 and 4 mm. The calculation starts from how the part behaves in the assembly: working load, travel, fitting diameters and the number of cycles it has to survive.' ),
                    steelplast_t( 'steelplast/service-wire-products/content', 'topic_1_p2', 'After coiling every spring is heat treated to relieve stress — that step is what decides whether it still holds its rated load after thousands of cycles.' ),
                ],
            ],
            [
                'heading'    => steelplast_t( 'steelplast/service-wire-products/content', 'topic_2_heading', 'Formed Wire Parts' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-wire-products/content', 'topic_2_p1', 'Rings, clips, hooks, retainers, wire frames and baskets — 2D and 3D bending to your drawing. Closed contours are joined by resistance welding.' ),
                    steelplast_t( 'steelplast/service-wire-products/content', 'topic_2_p2', 'Finished parts can be delivered electroplated or powder coated, depending on where they will work: indoors, in a damp environment or outdoors.' ),
                ],
            ],
        ],
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-about-preview', null, [
        'tag' => steelplast_t( 'steelplast/service-wire-products/about', 'tag', '[03] About us' ),
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-quality', null, [
        'label_index' => '[04]',
    ] );
    ?>

    <?php get_template_part( 'template-parts/section-contact' ); ?>

</main>

<?php
get_footer();
