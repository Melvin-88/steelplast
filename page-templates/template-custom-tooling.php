<?php
/**
 * Template Name: Custom Tooling & Fixtures
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();

$ctx = 'steelplast/service-custom-tooling/specs';

$specs_cards = [
    [
        'title'    => steelplast_t( $ctx, 'card_1_title', 'Tooling Types' ),
        'subtitle' => steelplast_t( $ctx, 'card_1_subtitle', 'We manufacture:' ),
        'blocks'   => [
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_1_item_1', 'Assembly jigs & fixtures' ),
                    steelplast_t( $ctx, 'card_1_item_2', 'Inspection & measuring gauges' ),
                    steelplast_t( $ctx, 'card_1_item_3', 'Cutting tools' ),
                    steelplast_t( $ctx, 'card_1_item_4', 'Welding fixtures' ),
                    steelplast_t( $ctx, 'card_1_item_5', 'Custom test equipment' ),
                ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_1_note', 'Built to your process, not off a catalog.' ),
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_2_title', 'Design & Manufacturing Process' ),
        'subtitle' => steelplast_t( $ctx, 'card_2_subtitle', 'Core operations' ),
        'blocks'   => [
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_1_title', 'Design' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_1_item_1', 'Requirements review' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_2', '3D modeling' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_3', 'Design validation' ),
                ],
            ],
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_2_title', 'Manufacturing' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_2_item_1', 'CNC milling & turning' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_2', 'Grinding' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_3', 'Assembly & calibration' ),
                ],
            ],
        ],
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_3_title', 'Precision & Quality Control' ),
        'subtitle' => steelplast_t( $ctx, 'card_3_subtitle', 'Tolerances we guarantee' ),
        'blocks'   => [
            [
                'type'  => 'stat',
                'value' => '±0.005 mm',
                'label' => steelplast_t( $ctx, 'card_3_stat_label', 'Machining tolerance' ),
            ],
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_3_item_1', 'Calibration against reference standards' ),
                    steelplast_t( $ctx, 'card_3_item_2', 'Repeatability testing' ),
                    steelplast_t( $ctx, 'card_3_item_3', 'Material certification' ),
                    steelplast_t( $ctx, 'card_3_item_4', 'Coordinate measuring machines (CMM)' ),
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
                'value'  => '10',
                'suffix' => steelplast_t( $ctx, 'card_4_stat_suffix', 'business days' ),
                'label'  => steelplast_t( $ctx, 'card_4_stat_label', 'Production starts from' ),
            ],
            [
                'type'  => 'badges',
                'label' => steelplast_t( $ctx, 'card_4_badges_label', 'We accept files in:' ),
                'items' => [ 'DWG', 'DXF', 'STEP', 'IGES' ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_4_note', 'No drawing yet? Describe the task and our engineers will design the tooling from scratch.' ),
    ],
];
?>

<main id="primary" class="sp-main page-custom-tooling">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => steelplast_t( 'steelplast/service-custom-tooling/hero', 'title', 'Custom Tooling & Fixtures: Made-to-Order Equipment' ),
        'height' => 440,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-specs', null, [
        'label'  => steelplast_t( 'steelplast/service-custom-tooling/specs', 'label', 'Technical Parameters' ),
        'title'  => steelplast_t( 'steelplast/service-custom-tooling/specs', 'title', 'Steel Plast builds custom tooling and fixtures — from your task to a finished piece of equipment' ),
        'desc'   => [
            steelplast_t( 'steelplast/service-custom-tooling/specs', 'desc_1', 'We work with both one-off requests and equipment for full production lines, keeping quality consistent at every stage.' ),
            steelplast_t( 'steelplast/service-custom-tooling/specs', 'desc_2', "Some tasks can't be solved with an off-the-shelf tool. We design and manufacture jigs, fixtures, gauges, and other custom equipment in-house, matching your exact process instead of forcing your process to match a catalog part." ),
        ],
        'cards'  => $specs_cards,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-content', null, [
        'label'  => steelplast_t( 'steelplast/service-custom-tooling/content', 'label', 'Custom Equipment' ),
        'title'  => steelplast_t( 'steelplast/service-custom-tooling/content', 'title', 'Custom Tooling and Fixtures for Non-Standard Tasks' ),
        'intro'  => steelplast_t( 'steelplast/service-custom-tooling/content', 'intro', "Some tasks can't be solved with an off-the-shelf tool — a fixture that holds an unusual part, a gauge that checks a feature no catalog instrument measures, or a jig that speeds up a repetitive assembly step. Steel Plast designs and builds this equipment in-house, matched exactly to your process." ),
        'topics' => [
            [
                'heading'    => steelplast_t( 'steelplast/service-custom-tooling/content', 'topic_1_heading', 'Jigs & Fixtures' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-custom-tooling/content', 'topic_1_p1', 'Assembly and welding fixtures hold parts in a fixed, repeatable position, removing manual alignment from your process and keeping cycle time and quality consistent across every operator and shift.' ),
                    steelplast_t( 'steelplast/service-custom-tooling/content', 'topic_1_p2', 'We design fixtures around your existing workflow — including quick-change elements when a single fixture needs to support several part variants.' ),
                ],
            ],
            [
                'heading'    => steelplast_t( 'steelplast/service-custom-tooling/content', 'topic_2_heading', 'Inspection & Measuring Gauges' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-custom-tooling/content', 'topic_2_p1', "Custom gauges check features that standard measuring instruments can't reach or aren't built for — a specific bore pattern, a contoured surface, or a go/no-go check for a critical dimension." ),
                    steelplast_t( 'steelplast/service-custom-tooling/content', 'topic_2_p2', 'Every gauge is calibrated against a reference standard and validated for repeatability before it goes into your quality control process.' ),
                ],
            ],
        ],
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-about-preview', null, [
        'tag' => steelplast_t( 'steelplast/service-custom-tooling/about', 'tag', '[03] About us' ),
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
