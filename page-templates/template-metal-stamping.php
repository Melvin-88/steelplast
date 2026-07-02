<?php
/**
 * Template Name: Metal Stamping
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();

$ctx = 'steelplast/service-metal-stamping/specs';

$specs_cards = [
    [
        'title'    => steelplast_t( $ctx, 'card_1_title', 'Materials' ),
        'subtitle' => steelplast_t( $ctx, 'card_1_subtitle', 'We stamp:' ),
        'blocks'   => [
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_1_item_1', 'Low-carbon steel' ),
                    steelplast_t( $ctx, 'card_1_item_2', 'Stainless steel' ),
                    steelplast_t( $ctx, 'card_1_item_3', 'Galvanized steel' ),
                    steelplast_t( $ctx, 'card_1_item_4', 'Aluminum' ),
                    steelplast_t( $ctx, 'card_1_item_5', 'Copper' ),
                    steelplast_t( $ctx, 'card_1_item_6', 'Brass' ),
                ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_1_note', 'Sheet thickness from 0.15 to 5 mm.' ),
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_2_title', 'Stamping Operations' ),
        'subtitle' => steelplast_t( $ctx, 'card_2_subtitle', 'Core operations' ),
        'blocks'   => [
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_1_title', 'Cutting' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_1_item_1', 'Blanking' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_2', 'Piercing' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_3', 'Trimming' ),
                ],
            ],
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_2_title', 'Forming' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_2_item_1', 'Bending' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_2', 'Deep drawing' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_3', 'Embossing' ),
                ],
            ],
        ],
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_3_title', 'Equipment & Quality Control' ),
        'subtitle' => steelplast_t( $ctx, 'card_3_subtitle', 'Precision you can rely on' ),
        'blocks'   => [
            [
                'type'  => 'stat',
                'value' => '100',
                'suffix' => steelplast_t( $ctx, 'card_3_stat_suffix', 'tons' ),
                'label' => steelplast_t( $ctx, 'card_3_stat_label', 'Maximum pressing force' ),
            ],
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_3_item_1', 'Crank pneumatic presses' ),
                    steelplast_t( $ctx, 'card_3_item_2', 'Incoming material inspection' ),
                    steelplast_t( $ctx, 'card_3_item_3', 'Die wear monitoring' ),
                    steelplast_t( $ctx, 'card_3_item_4', 'First-article inspection' ),
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
                'value'  => '5',
                'suffix' => steelplast_t( $ctx, 'card_4_stat_suffix', 'business days' ),
                'label'  => steelplast_t( $ctx, 'card_4_stat_label', 'Production starts from' ),
            ],
            [
                'type'  => 'badges',
                'label' => steelplast_t( $ctx, 'card_4_badges_label', 'We accept files in:' ),
                'items' => [ 'DWG', 'DXF', 'STEP', 'IGES' ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_4_note', 'No drawing yet? Our engineers can help prepare documentation and a 3D model for production.' ),
    ],
];
?>

<main id="primary" class="sp-main page-metal-stamping">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => steelplast_t( 'steelplast/service-metal-stamping/hero', 'title', 'Metal Stamping: Precision Sheet Metal Parts' ),
        'height' => 440,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-specs', null, [
        'label'  => steelplast_t( 'steelplast/service-metal-stamping/specs', 'label', 'Technical Parameters' ),
        'title'  => steelplast_t( 'steelplast/service-metal-stamping/specs', 'title', 'Steel Plast delivers a full cycle of metal stamping — from your drawing to a finished part' ),
        'desc'   => [
            steelplast_t( 'steelplast/service-metal-stamping/specs', 'desc_1', 'We work with both one-off orders and serial production, keeping quality consistent at every stage.' ),
            steelplast_t( 'steelplast/service-metal-stamping/specs', 'desc_2', 'Metal stamping shapes flat sheet metal into finished parts using dies and presses — one of the fastest and most cost-effective ways to produce components in volume. Alongside proven cutting and forming processes, we maintain a stable process, tight tolerances, and a skilled team capable of stamping parts of complex geometry.' ),
        ],
        'cards'  => $specs_cards,
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-service-content', null, [
        'label'  => steelplast_t( 'steelplast/service-metal-stamping/content', 'label', 'Cutting & Forming' ),
        'title'  => steelplast_t( 'steelplast/service-metal-stamping/content', 'title', 'Sheet Metal Cutting and Forming Services' ),
        'intro'  => steelplast_t( 'steelplast/service-metal-stamping/content', 'intro', 'Steel Plast operates a fleet of stamping presses for cutting and forming sheet metal parts — from small brackets to structural components. Whatever your drawing calls for, our engineers select the tooling and press setup that deliver the best precision and turnaround time.' ),
        'topics' => [
            [
                'heading'    => steelplast_t( 'steelplast/service-metal-stamping/content', 'topic_1_heading', 'Sheet Metal Cutting' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-metal-stamping/content', 'topic_1_p1', 'Blanking and piercing separate the part outline from the sheet metal strip and create internal features — holes, slots, and cutouts — in a single stroke of the press. This process is fast and repeatable, making it ideal for both prototype runs and high-volume production of flat components.' ),
                    steelplast_t( 'steelplast/service-metal-stamping/content', 'topic_1_p2', 'We also perform trimming and shearing to finish part edges to the exact profile specified in your drawing, keeping burr height and edge quality consistent across the full production batch.' ),
                ],
            ],
            [
                'heading'    => steelplast_t( 'steelplast/service-metal-stamping/content', 'topic_2_heading', 'Sheet Metal Forming' ),
                'paragraphs' => [
                    steelplast_t( 'steelplast/service-metal-stamping/content', 'topic_2_p1', 'Bending reshapes flat blanks into brackets, channels, and enclosures using precision-ground dies, while deep drawing pulls sheet metal into cups, housings, and other three-dimensional shapes without cutting the material.' ),
                    steelplast_t( 'steelplast/service-metal-stamping/content', 'topic_2_p2', 'Embossing adds ribs, louvers, and other reinforcing features directly into the sheet, increasing part stiffness without extra material or a separate assembly step.' ),
                ],
            ],
        ],
    ] );
    ?>

    <?php
    get_template_part( 'template-parts/section-about-preview', null, [
        'tag' => steelplast_t( 'steelplast/service-metal-stamping/about', 'tag', '[03] About us' ),
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
