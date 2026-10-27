<?php
/**
 * Template Name: Mold & Die Manufacturing
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();

$ctx = 'steelplast/service-mold-manufacturing/specs';

$specs_cards = [
    [
        'title'    => steelplast_t( $ctx, 'card_1_title', 'Mold & Die Types' ),
        'subtitle' => steelplast_t( $ctx, 'card_1_subtitle', 'We manufacture:' ),
        // За таблицею картка розбита на два списки: типи прес-форм і типи штампів.
        // Колишні пункти item_1 / item_2 стали заголовками груп.
        'blocks'   => [
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_1_item_1', 'Injection molds' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_1_group_1_item_1', 'Single-cavity molds' ),
                    steelplast_t( $ctx, 'card_1_group_1_item_2', 'Multi-cavity molds' ),
                    steelplast_t( $ctx, 'card_1_group_1_item_3', 'Two-plate & three-plate molds' ),
                    steelplast_t( $ctx, 'card_1_group_1_item_4', 'Hot-runner molds' ),
                    steelplast_t( $ctx, 'card_1_group_1_item_5', 'Overmolding molds' ),
                    steelplast_t( $ctx, 'card_1_item_3', 'Prototype molds' ),
                    steelplast_t( $ctx, 'card_1_item_5', 'Insert molds for embedded components' ),
                ],
            ],
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_1_item_2', 'Stamping dies' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_1_group_2_item_1', 'Blanking dies' ),
                    steelplast_t( $ctx, 'card_1_group_2_item_2', 'Bending dies' ),
                    steelplast_t( $ctx, 'card_1_group_2_item_3', 'Forming dies' ),
                    steelplast_t( $ctx, 'card_1_group_2_item_4', 'Drawing dies' ),
                    steelplast_t( $ctx, 'card_1_group_2_item_5', 'Combination dies' ),
                ],
            ],
        ],
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_2_title', 'Manufacturing Processes' ),
        'subtitle' => steelplast_t( $ctx, 'card_2_subtitle', 'Core operations' ),
        'blocks'   => [
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_1_title', 'Machining' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_1_item_1', '3-axis & 5-axis CNC milling' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_2', 'CNC turning' ),
                    // Електроерозію перенесено з «Фінішної обробки»; ключ лишений, щоб не втратити переклади.
                    steelplast_t( $ctx, 'card_2_group_2_item_1', 'Wire & sinker EDM' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_3', 'Grinding' ),
                ],
            ],
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_2_title', 'Finishing' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_2_item_4', 'Bench fitting' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_2', 'Polishing' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_5', 'Assembly' ),
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
                    steelplast_t( $ctx, 'card_3_item_1', 'Incoming material inspection' ),
                    steelplast_t( $ctx, 'card_3_item_2', 'Trial shots & sampling' ),
                    steelplast_t( $ctx, 'card_3_item_3', 'In-process inspection' ),
                    steelplast_t( $ctx, 'card_3_item_4', 'High-precision mechanical and optical measuring instruments' ),
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
                'value'  => steelplast_t( $ctx, 'card_4_stat_value', 'from 1' ),
                'suffix' => steelplast_t( $ctx, 'card_4_stat_suffix', 'month' ),
                'label'  => steelplast_t( $ctx, 'card_4_stat_label', 'Lead time starts from' ),
            ],
            [
                'type'  => 'badges',
                'label' => steelplast_t( $ctx, 'card_4_badges_label', 'We accept files in:' ),
                'items' => [ 'DWG', 'DXF', 'STEP', 'IGES' ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_4_note', 'We also provide mold and die maintenance and repair for tooling already in production.' ),
    ],
];
?>

<main id="primary" class="sp-main page-mold-manufacturing">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => steelplast_t( 'steelplast/service-mold-manufacturing/hero', 'title', 'Mold & Die Manufacturing' ),
        'height' => 440,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-specs', null, [
        'label'  => steelplast_t( 'steelplast/service-mold-manufacturing/specs', 'label', 'Technical Parameters' ),
        'title'  => steelplast_t( 'steelplast/service-mold-manufacturing/specs', 'title', 'Steel Plast delivers a full cycle of mold and die manufacturing — from your drawing to finished tooling' ),
        'desc'   => [
            steelplast_t( 'steelplast/service-mold-manufacturing/specs', 'desc_1', 'We work with both one-off tooling orders and long production programs, keeping quality consistent at every stage.' ),
            steelplast_t( 'steelplast/service-mold-manufacturing/specs', 'desc_2', 'Every injection mold and stamping die is designed and built in-house, from steel selection to trial samples. Alongside proven CNC machining and EDM processes, we maintain a stable process, tight tolerances, and a skilled tool shop team capable of building tooling of complex geometry.' ),
        ],
        'cards'  => $specs_cards,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-content', null, [
        'label'  => steelplast_t( 'steelplast/service-mold-manufacturing/content', 'label', 'Tooling Design & Manufacturing' ),
        'title'  => steelplast_t( 'steelplast/service-mold-manufacturing/content', 'title', 'Injection Mold and Stamping Die Manufacturing' ),
        'intro'  => steelplast_t( 'steelplast/service-mold-manufacturing/content', 'intro', 'Steel Plast designs and manufactures custom tooling in-house, which gives us full control over lead time, precision, and cost. Depending on the part geometry, our engineers select the mold structure, steel grade, and machining strategy that deliver a reliable, long-lasting tool.' ),
        'topics' => [
            [
                'heading'    => steelplast_t( 'steelplast/service-mold-manufacturing/content', 'topic_1_heading', 'Injection Mold Manufacturing' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-mold-manufacturing/content', 'topic_1_p1', 'Mold manufacturing starts with the technical specification — a feasibility study and a review of your drawings or a sample of the required part. Next come mold design and 3D modeling, and the choice of steel grade to match the required tool life. Then metal machining: milling and drilling, wire and sinker EDM, and grinding. The cycle closes with polishing of the molding surfaces and assembly of the tooling.' ),
                    steelplast_t( 'steelplast/service-mold-manufacturing/content', 'topic_1_p2', 'Trial shots and sampling validate the mold before it goes into series production, confirming that dimensions, surface finish, and cycle time match the part specification.' ),
                ],
            ],
            [
                'heading'    => steelplast_t( 'steelplast/service-mold-manufacturing/content', 'topic_2_heading', 'Stamping Die Manufacturing' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-mold-manufacturing/content', 'topic_2_p1', 'Stamping dies are engineered for the specific sheet metal operation — blanking, piercing, bending, or deep drawing. They are built from hardened tool steel to withstand high-volume production runs.' ),
                    steelplast_t( 'steelplast/service-mold-manufacturing/content', 'topic_2_p2', 'We machine die components on CNC milling and EDM equipment, then fit, heat-treat, and polish the tooling to extend die life and keep part quality consistent across the full production run.' ),
                ],
            ],
        ],
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-about-preview', null, [
        'tag' => steelplast_t( 'steelplast/service-mold-manufacturing/about', 'tag', '[03] About us' ),
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
