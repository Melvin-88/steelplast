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
                    steelplast_t( $ctx, 'card_1_item_5', 'Retaining rings and spring rings' ),
                ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_1_note', 'Wire diameter from 0.4 to 2.5 mm; 0.5 to 2.0 mm for compression and extension springs.' ),
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
                    // Довгий пункт стоїть останнім: у дві колонки він переносився на
                    // другий рядок і розганяв відступ між сусідніми пунктами.
                    steelplast_t( $ctx, 'card_2_group_1_item_3', 'Rings, hooks and clips' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_2', 'Custom wire forms' ),
                ],
            ],
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_2_title', 'Post-Processing' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_2_item_2', 'Heat treatment' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_3', 'Electroplating or powder coating' ),
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
                'value' => steelplast_t( $ctx, 'card_3_stat_value', '±0.05 mm' ),
                'label' => steelplast_t( $ctx, 'card_3_stat_label', 'Geometry repeatability' ),
            ],
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_3_item_1', 'Spring wire' ),
                    steelplast_t( $ctx, 'card_3_item_2', 'Stainless steel' ),
                    steelplast_t( $ctx, 'card_3_item_3', 'Galvanized and low-carbon wire' ),
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
                'value'  => steelplast_t( $ctx, 'card_4_stat_value', 'from 7' ),
                'suffix' => steelplast_t( $ctx, 'card_4_stat_suffix', 'business days' ),
                'label'  => steelplast_t( $ctx, 'card_4_stat_label', 'Lead time' ),
            ],
            [
                'type'  => 'badges',
                'label' => steelplast_t( $ctx, 'card_4_badges_label', 'Accepted file formats:' ),
                'items' => [ 'PDF', 'JPG', 'PNG' ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_4_note', 'No drawing? Send us a sample part, and we\'ll reproduce its geometry.' ),
    ],
];
?>

<main id="primary" class="sp-main page-wire-products">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => steelplast_t( 'steelplast/service-wire-products/hero', 'title', 'Springs and Wire Products' ),
        'height' => 440,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-specs', null, [
        'label' => steelplast_t( $ctx, 'label', 'Technical Specifications' ),
        'title' => steelplast_t( $ctx, 'title', 'Steel Plast manufactures springs and bent wire products — from your drawing or sample to a finished batch' ),
        'desc'  => [
            steelplast_t( $ctx, 'desc_1', 'We produce small and medium batches, keeping the geometry identical on every part in the batch.' ),
            steelplast_t( $ctx, 'desc_2', 'A spring is rarely an off-the-shelf item: wire diameter, coil pitch, working load and installation dimensions are set by your assembly. We do the coiling, bending and heat treatment in-house, so the geometry is adapted to the part, not the other way around.' ),
        ],
        'cards' => $specs_cards,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-content', null, [
        'label'  => steelplast_t( 'steelplast/service-wire-products/content', 'label', 'Springs & Wire' ),
        'title'  => steelplast_t( 'steelplast/service-wire-products/content', 'title', 'Springs and Bent Wire Products for Industrial and Household Use' ),
        'intro'  => steelplast_t( 'steelplast/service-wire-products/content', 'intro', 'A spring is rarely a stand-alone product — it works inside a lock, a furniture mechanism, a household appliance or an agricultural assembly, and it determines how long the entire assembly will last. We make such parts in small and medium batches, to a drawing or a sample.' ),
        'topics' => [
            [
                'heading'    => steelplast_t( 'steelplast/service-wire-products/content', 'topic_1_heading', 'Custom Springs' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-wire-products/content', 'topic_1_p1', 'We coil compression, extension and torsion springs from wire 0.4 to 2 mm in diameter. Our calculations start from how the part works in the assembly: working load, travel, mounting diameters and the number of cycles it has to withstand.' ),
                    steelplast_t( 'steelplast/service-wire-products/content', 'topic_1_p2', 'After coiling, every spring is stress-relieved by heat treatment — this step determines whether the part will keep its specified load after thousands of cycles.' ),
                    steelplast_t( 'steelplast/service-wire-products/content', 'topic_1_p3', 'These springs work in furniture and lock mechanisms, household appliances, agricultural assemblies and machinery assemblies: wherever a part has to compress and return to its original shape thousands of times.' ),
                ],
            ],
            [
                'heading'    => steelplast_t( 'steelplast/service-wire-products/content', 'topic_2_heading', 'Bent Wire Products' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-wire-products/content', 'topic_2_p1', 'Rings, clips, hooks, retainers, wire frames and baskets — custom wire forms made to your drawing.' ),
                    steelplast_t( 'steelplast/service-wire-products/content', 'topic_2_p2', 'Finished products can be supplied with electroplating or powder coating, depending on where the part will work: indoors, in a humid environment or outdoors.' ),
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
