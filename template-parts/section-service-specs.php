<?php
/**
 * Service page — numbered "technical parameters" card grid (flexible, reused
 * across service pages with different content per card).
 * Usage: get_template_part( 'template-parts/section-service-specs', null, $args );
 * Args (all optional — default to CNC Machining page content):
 *   'label_index' (string) e.g. '[01]'
 *   'label'       (string) section label text
 *   'title'       (string) H2 title
 *   'desc'        (array)  paragraphs shown under the title
 *   'cards'       (array)  each item:
 *       'title'    (string)
 *       'subtitle' (string, optional)
 *       'blocks'   (array) each item is one of:
 *           [ 'type' => 'bullets', 'items' => [ ... ] ]
 *           [ 'type' => 'group', 'heading' => ..., 'items' => [ ... ] ]
 *           [ 'type' => 'stat', 'value' => ..., 'suffix' => (optional), 'label' => ... ]
 *           [ 'type' => 'badges', 'label' => ..., 'items' => [ ... ] ]
 *           [ 'type' => 'text', 'text' => ... ]
 *       'note'     (string, optional) small footnote under the card body
 *
 * @package SteelPlast
 */

$ctx = 'steelplast/service-cnc-machining/specs';

// Перелік форматів за замовчуванням — картка може не передавати 'items'.
// Пружини та вироби з дроту мають власний набір: там приймають креслення й фото.
$file_formats = [ 'STEP', 'PDF', 'x_t' ];

$label_index = $args['label_index'] ?? '[01]';
$label       = $args['label']       ?? steelplast_t( $ctx, 'label', 'Technical Specifications' );
$title       = $args['title']       ?? steelplast_t( $ctx, 'title', 'Steel Plast delivers the full cycle of CNC metal machining — from your drawing to the finished part' );
$desc        = $args['desc']        ?? [
    steelplast_t( $ctx, 'desc_1', 'We handle both one-off orders and series production, keeping quality consistent at every stage.' ),
    steelplast_t( $ctx, 'desc_2', 'CNC metal machining is based on computer numerical control — the foundation of modern precision manufacturing. Alongside proven turning and milling processes, we ensure a stable process and tight tolerances, backed by a team capable of machining parts with complex geometry.' ),
];

$cards = $args['cards'] ?? [
    [
        'title'    => steelplast_t( $ctx, 'card_1_title', 'Materials' ),
        'subtitle' => steelplast_t( $ctx, 'card_1_subtitle', 'We machine:' ),
        'blocks'   => [
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_1_item_1', 'Structural steel' ),
                    steelplast_t( $ctx, 'card_1_item_2', 'Tool steel' ),
                    steelplast_t( $ctx, 'card_1_item_3', 'Stainless steel' ),
                    steelplast_t( $ctx, 'card_1_item_4', 'Aluminum' ),
                    steelplast_t( $ctx, 'card_1_item_5', 'Brass' ),
                    steelplast_t( $ctx, 'card_1_item_6', 'Copper' ),
                    steelplast_t( $ctx, 'card_1_item_7', 'Titanium' ),
                ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_1_note', 'Part diameters from 0.5 mm.' ),
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_2_title', 'Machining Types' ),
        'subtitle' => steelplast_t( $ctx, 'card_2_subtitle', 'Core operations' ),
        'blocks'   => [
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_1_title', 'Turning' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_1_item_1', 'External and internal turning' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_2', 'Threading' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_3', 'Grooving and parting off' ),
                ],
            ],
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_2_title', 'Milling' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_2_item_1', 'Face milling' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_2', 'Slot and pocket milling' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_3', 'Complex contours' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_4', '3D milling' ),
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
                'value' => steelplast_t( $ctx, 'card_3_stat_value', '±0.005 mm' ),
                'label' => steelplast_t( $ctx, 'card_3_stat_label', 'Machining tolerance' ),
            ],
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_3_item_1', 'Incoming material inspection' ),
                    steelplast_t( $ctx, 'card_3_item_2', 'Part geometry inspection' ),
                    steelplast_t( $ctx, 'card_3_item_3', 'Calibrated tooling' ),
                    steelplast_t( $ctx, 'card_3_item_4', 'Optical measuring instruments' ),
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
                'value'  => steelplast_t( $ctx, 'card_4_stat_value', 'from 2' ),
                'suffix' => steelplast_t( $ctx, 'card_4_stat_suffix', 'weeks' ),
                'label'  => steelplast_t( $ctx, 'card_4_stat_label', 'Project launch' ),
            ],
            [
                'type'  => 'badges',
                'label' => steelplast_t( $ctx, 'card_4_badges_label', 'Accepted file formats:' ),
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_4_note', 'No drawing? Our engineers will help prepare the documentation and a 3D model for production.' ),
    ],
];
?>

<section class="sp-service-specs" aria-labelledby="service-specs-title">
    <div class="content-wrapper">

        <div class="sp-service-specs__header" data-sp-animate>
            <p class="sp-section-label sp-section-label--dark-bg">
                <span class="sp-section-label__index" aria-hidden="true"><?php echo esc_html( $label_index ); ?></span>
                <?php echo esc_html( $label ); ?>
            </p>
            <h2 class="sp-service-specs__title sp-section-title" id="service-specs-title">
                <?php echo esc_html( $title ); ?>
            </h2>
            <div class="sp-service-specs__desc">
                <?php foreach ( $desc as $paragraph ) : ?>
                    <p class="sp-section-desc"><?php echo esc_html( $paragraph ); ?></p>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="sp-service-specs__grid" data-sp-animate-group>
            <?php foreach ( $cards as $i => $card ) : $n = $i + 1; ?>
                <article class="sp-service-specs__card" data-sp-animate>
                    <span class="sp-service-specs__card-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>

                    <div class="sp-service-specs__card-head">
                        <h3 class="sp-service-specs__card-title"><?php echo esc_html( $card['title'] ); ?></h3>
                        <?php if ( ! empty( $card['subtitle'] ) ) : ?>
                            <p class="sp-service-specs__card-subtitle"><?php echo esc_html( $card['subtitle'] ); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="sp-service-specs__card-body">
                        <?php foreach ( $card['blocks'] as $block ) :
                            switch ( $block['type'] ) :
                                case 'bullets': ?>
                                    <ul class="sp-service-specs__bullets">
                                        <?php foreach ( $block['items'] as $item ) : ?>
                                            <li><?php echo esc_html( $item ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php break;

                                case 'group': ?>
                                    <p class="sp-service-specs__group-heading"><?php echo esc_html( $block['heading'] ); ?></p>
                                    <ul class="sp-service-specs__bullets">
                                        <?php foreach ( $block['items'] as $item ) : ?>
                                            <li><?php echo esc_html( $item ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php break;

                                case 'stat': ?>
                                    <div class="sp-service-specs__stat">
                                        <span class="sp-service-specs__stat-value">
                                            <?php echo esc_html( $block['value'] ); ?><?php if ( ! empty( $block['suffix'] ) ) : ?> <span class="sp-service-specs__stat-suffix"><?php echo esc_html( $block['suffix'] ); ?></span><?php endif; ?>
                                        </span>
                                        <span class="sp-service-specs__stat-label"><?php echo esc_html( $block['label'] ); ?></span>
                                    </div>
                                    <?php break;

                                case 'badges': ?>
                                    <?php if ( ! empty( $block['label'] ) ) : ?>
                                        <p class="sp-service-specs__badges-label"><?php echo esc_html( $block['label'] ); ?></p>
                                    <?php endif; ?>
                                    <div class="sp-service-specs__badges">
                                        <?php foreach ( $block['items'] ?? $file_formats as $badge ) : ?>
                                            <span class="sp-service-specs__badge"><?php echo esc_html( $badge ); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php break;

                                case 'text': ?>
                                    <p class="sp-service-specs__text"><?php echo esc_html( $block['text'] ); ?></p>
                                    <?php break;
                            endswitch;
                        endforeach; ?>
                    </div>

                    <?php if ( ! empty( $card['note'] ) ) : ?>
                        <p class="sp-service-specs__card-note"><?php echo esc_html( $card['note'] ); ?></p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
