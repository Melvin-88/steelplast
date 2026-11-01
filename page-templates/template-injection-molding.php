<?php
/**
 * Template Name: Plastic Injection Molding
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();

$ctx = 'steelplast/service-injection-molding/specs';

$specs_cards = [
    [
        'title'    => steelplast_t( $ctx, 'card_1_title', 'Materials' ),
        'subtitle' => steelplast_t( $ctx, 'card_1_subtitle', 'We mold:' ),
        'blocks'   => [
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_1_item_1', 'Polypropylene (PP)' ),
                    steelplast_t( $ctx, 'card_1_item_2', 'ABS' ),
                    steelplast_t( $ctx, 'card_1_item_3', 'Polyamide (PA6, PA66)' ),
                    steelplast_t( $ctx, 'card_1_item_4', 'Polycarbonate (PC)' ),
                    steelplast_t( $ctx, 'card_1_item_5', 'Polyethylenes (LDPE, HDPE)' ),
                    steelplast_t( $ctx, 'card_1_item_6', 'TPE / TPU / TPV' ),
                    steelplast_t( $ctx, 'card_1_item_7', 'PS / HIPS' ),
                    steelplast_t( $ctx, 'card_1_item_8', 'POM' ),
                    steelplast_t( $ctx, 'card_1_item_9', 'SAN' ),
                    steelplast_t( $ctx, 'card_1_item_10', 'PVC' ),
                ],
            ],
        ],
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_2_title', 'Molding Processes' ),
        'subtitle' => steelplast_t( $ctx, 'card_2_subtitle', 'Core capabilities' ),
        // Обидва заголовки груп прибрані за таблицею, тож список став суцільним.
        // Ключі лишені як були, щоб не втратити наявні переклади.
        'blocks'   => [
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_2_group_1_item_1', 'Single-component molding' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_2', 'Insert molding' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_3', 'Overmolding' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_1', 'Molding with mold temperature control' ),
                ],
            ],
        ],
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_3_title', 'Precision & Quality Control' ),
        'subtitle' => steelplast_t( $ctx, 'card_3_subtitle', 'Dimensional stability we guarantee' ),
        'blocks'   => [
            [
                'type'  => 'stat',
                'value' => '±0.05 mm',
                'label' => steelplast_t( $ctx, 'card_3_stat_label', 'Molding tolerance' ),
            ],
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_3_item_1', 'Incoming resin inspection' ),
                    steelplast_t( $ctx, 'card_3_item_2', 'Shrinkage & warpage control' ),
                    steelplast_t( $ctx, 'card_3_item_3', 'First-shot validation' ),
                    steelplast_t( $ctx, 'card_3_item_4', 'Production to a part check-list' ),
                ],
            ],
        ],
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_4_title', 'Equipment & Terms' ),
        'subtitle' => steelplast_t( $ctx, 'card_4_subtitle', 'Fast & reliable' ),
        'blocks'   => [
            [
                'type'   => 'stat',
                'value'  => '35–400',
                'suffix' => steelplast_t( $ctx, 'card_4_stat_suffix', 'tons' ),
                'label'  => steelplast_t( $ctx, 'card_4_stat_label', 'Clamping force range' ),
            ],
            [
                'type'   => 'stat',
                'value'  => '20–1200',
                'suffix' => steelplast_t( $ctx, 'card_4_stat2_suffix', 'cm³' ),
                'label'  => steelplast_t( $ctx, 'card_4_stat2_label', 'Shot volume' ),
            ],
            [
                // Габарити не вміщаються у 40px цифру stat-блоку, тож ідуть рядком.
                'type' => 'text',
                'text' => steelplast_t( $ctx, 'card_4_dimensions', 'Mold size: 250×200 mm to 750×1200 mm' ),
            ],
            [
                'type'  => 'badges',
                'label' => steelplast_t( $ctx, 'card_4_badges_label', 'We accept files in:' ),
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_4_note', 'No mold yet? We design and manufacture the injection mold in-house — from 3D model to first shot.' ),
    ],
];
?>

<main id="primary" class="sp-main page-injection-molding">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => steelplast_t( 'steelplast/service-injection-molding/hero', 'title', 'Plastic Injection Molding' ),
        'height' => 440,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-specs', null, [
        'label'  => steelplast_t( 'steelplast/service-injection-molding/specs', 'label', 'Technical Parameters' ),
        'title'  => steelplast_t( 'steelplast/service-injection-molding/specs', 'title', 'Steel Plast delivers a full cycle of plastic injection molding — from material selection to the finished part' ),
        'desc'   => [
            steelplast_t( 'steelplast/service-injection-molding/specs', 'desc_2', 'Injection molding is a process in which molten plastic is injected under pressure into a mold cavity by an injection molding machine. For large volumes it is the most cost-effective way to produce plastic parts, unlike 3D printing.' ),
        ],
        'cards'  => $specs_cards,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-content', null, [
        'label'  => steelplast_t( 'steelplast/service-injection-molding/content', 'label', 'Molding Capabilities' ),
        'title'  => steelplast_t( 'steelplast/service-injection-molding/content', 'title', 'Injection Molding Process and Capabilities' ),
        'intro'  => steelplast_t( 'steelplast/service-injection-molding/content', 'intro', 'Steel Plast operates a modern fleet of injection molding machines, giving us the flexibility to produce plastic parts — from small precision components to large housings. Whatever your drawing calls for, our engineers select the material, the process, and the mold design that deliver the best precision and turnaround time.' ),
        'topics' => [
            [
                'heading'    => steelplast_t( 'steelplast/service-injection-molding/content', 'topic_1_heading', 'Injection Molding' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-injection-molding/content', 'topic_1_p1', 'Injection molding melts plastic granules and injects them under pressure into a mold cavity, where the part cools and solidifies before ejection. This process is fast, repeatable, and cost-effective at scale, making it the standard choice for producing plastic components in volumes from a few hundred to millions of parts.' ),
                    steelplast_t( 'steelplast/service-injection-molding/content', 'topic_1_p2', 'We control every injection cycle — melt temperature, injection speed, and clamping force — to keep dimensional stability and cycle repeatability consistent across the full production run.' ),
                ],
            ],
            [
                'heading'    => steelplast_t( 'steelplast/service-injection-molding/content', 'topic_2_heading', 'Insert Molding' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-injection-molding/content', 'topic_2_p1', 'Overmolding and insert molding embed a metal or plastic insert directly into the part during the injection cycle, combining materials in a single component without a separate assembly step.' ),
                    steelplast_t( 'steelplast/service-injection-molding/content', 'topic_2_p2', 'Overmolding — a finished plastic part is placed into a mold and overmolded with another polymer. This combines the properties of both materials in a single part.' ),
                ],
            ],
        ],
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-about-preview', null, [
        'tag' => steelplast_t( 'steelplast/service-injection-molding/about', 'tag', '[03] About us' ),
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
