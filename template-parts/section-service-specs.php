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

$label_index = $args['label_index'] ?? '[01]';
$label       = $args['label']       ?? steelplast_t( $ctx, 'label', 'Technical Parameters' );
$title       = $args['title']       ?? steelplast_t( $ctx, 'title', "Steel Plast delivers a full cycle of CNC metal machining — from your drawing to a finished part" );
$desc        = $args['desc']        ?? [
    steelplast_t( $ctx, 'desc_1', 'We work with both one-off orders and serial production, keeping quality consistent at every stage.' ),
    steelplast_t( $ctx, 'desc_2', 'CNC metal machining relies on computer numerical control — the foundation of modern precision manufacturing. Alongside proven turning and milling processes, we maintain a stable process, tight tolerances, and a skilled team capable of machining parts of complex geometry.' ),
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
        'note' => steelplast_t( $ctx, 'card_1_note', 'From small precision parts to large-format workpieces.' ),
    ],
    [
        'title'    => steelplast_t( $ctx, 'card_2_title', 'Machining Types' ),
        'subtitle' => steelplast_t( $ctx, 'card_2_subtitle', 'Core operations' ),
        'blocks'   => [
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_1_title', 'Turning' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_1_item_1', 'OD & ID turning' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_2', 'Threading' ),
                    steelplast_t( $ctx, 'card_2_group_1_item_3', 'Grooving & parting' ),
                ],
            ],
            [
                'type'    => 'group',
                'heading' => steelplast_t( $ctx, 'card_2_group_2_title', 'Milling' ),
                'items'   => [
                    steelplast_t( $ctx, 'card_2_group_2_item_1', 'Facing' ),
                    steelplast_t( $ctx, 'card_2_group_2_item_2', 'Slotting & pocketing' ),
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
                'value' => '±0.005 mm',
                'label' => steelplast_t( $ctx, 'card_3_stat_label', 'Machining tolerance' ),
            ],
            [
                'type'  => 'bullets',
                'items' => [
                    steelplast_t( $ctx, 'card_3_item_1', 'Incoming material inspection' ),
                    steelplast_t( $ctx, 'card_3_item_2', 'Part geometry control' ),
                    steelplast_t( $ctx, 'card_3_item_3', 'Calibrated tooling' ),
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
                'value'  => '3',
                'suffix' => steelplast_t( $ctx, 'card_4_stat_suffix', 'business days' ),
                'label'  => steelplast_t( $ctx, 'card_4_stat_label', 'Production starts from' ),
            ],
            [
                'type'  => 'badges',
                'label' => steelplast_t( $ctx, 'card_4_badges_label', 'We accept files in:' ),
                'items' => [ 'DWG', 'DXF', 'STEP', 'IGES' ],
            ],
        ],
        'note' => steelplast_t( $ctx, 'card_4_note', "No drawing yet? Our engineers can help prepare documentation and a 3D model for production." ),
    ],
];
?>

<section class="sp-service-specs" aria-labelledby="service-specs-title">
    <div class="content-wrapper">

        <div class="sp-service-specs__header">
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

        <div class="sp-service-specs__grid">
            <?php foreach ( $cards as $i => $card ) : $n = $i + 1; ?>
                <article class="sp-service-specs__card">
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
                                            <?php echo esc_html( $block['value'] ); ?><?php if ( ! empty( $block['suffix'] ) ) : ?><span class="sp-service-specs__stat-suffix"><?php echo esc_html( $block['suffix'] ); ?></span><?php endif; ?>
                                        </span>
                                        <span class="sp-service-specs__stat-label"><?php echo esc_html( $block['label'] ); ?></span>
                                    </div>
                                    <?php break;

                                case 'badges': ?>
                                    <?php if ( ! empty( $block['label'] ) ) : ?>
                                        <p class="sp-service-specs__badges-label"><?php echo esc_html( $block['label'] ); ?></p>
                                    <?php endif; ?>
                                    <div class="sp-service-specs__badges">
                                        <?php foreach ( $block['items'] as $badge ) : ?>
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
