<?php
/**
 * About page — [04] Our equipment, 6-slot card grid (dark background).
 * Photos are optional per card (falls back to a gradient placeholder) —
 * not every machine is guaranteed to have a photo uploaded yet.
 * Usage: get_template_part( 'template-parts/section-about-equipment' );
 *
 * @package SteelPlast
 */

$label = steelplast_t( 'steelplast/about/equipment', 'label', 'Our equipment' );
$title = steelplast_t( 'steelplast/about/equipment', 'title', 'Modern manufacturing requires modern technology' );
$desc  = steelplast_t( 'steelplast/about/equipment', 'desc', 'That is why SteelPlast uses high-precision automated equipment that lets us deliver products of the highest quality.' );

// Photos are the same for every language — always read from the default-language post
$cards = [
    [
        'title'   => steelplast_t( 'steelplast/about/equipment-cards', 'card_1_title', 'Swiss-type automatic lathe' ),
        'lead'    => steelplast_t( 'steelplast/about/equipment-cards', 'card_1_lead', 'What it does:' ),
        'bullets' => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_1_bullet_1', 'Produces small, highly precise parts — pins, shafts, screws, and components for medical devices, watches and electronics.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_1_bullet_2', 'They can turn, mill, drill and thread.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_1_bullet_3', 'Runs fully automatically without an operator — just load the bar stock and the machine handles the rest.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_1_image' ) ?: 0,
    ],
    [
        'title' => steelplast_t( 'steelplast/about/equipment-cards', 'card_2_title', 'Crank stamping presses' ),
        'desc'  => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_2_desc_1', 'A crank stamping press is a machine that forms, bends, cuts and draws metal by compression force.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_2_desc_2', 'Its main advantages: productivity, energy efficiency and high repeatability.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_2_image' ) ?: 0,
    ],
    [
        'title' => steelplast_t( 'steelplast/about/equipment-cards', 'card_3_title', 'Injection molding machines' ),
        'lead'  => steelplast_t( 'steelplast/about/equipment-cards', 'card_3_lead', 'How does it work?' ),
        'desc'  => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_3_desc_1', 'Plastic granules are fed into the machine, melted down to a liquid state and injected under high pressure into the mold.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_3_image' ) ?: 0,
    ],
    [
        'title' => steelplast_t( 'steelplast/about/equipment-cards', 'card_4_title', 'Wire-cut and sinker EDM machines' ),
        'desc'  => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_4_desc_1', 'An EDM, or electrical discharge machine, works metal not with a cutter or a mill but with an electric spark that erodes it to micron precision.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_4_image' ) ?: 0,
    ],
    [
        'title'   => steelplast_t( 'steelplast/about/equipment-cards', 'card_5_title', '5-axis CNC milling machines' ),
        'lead'    => steelplast_t( 'steelplast/about/equipment-cards', 'card_5_lead', 'What it does:' ),
        'bullets' => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_5_bullet_1', 'Mills, drills and cuts complex shapes.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_5_bullet_2', 'They produce 3D surfaces, blades, housings and other complex parts.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_5_bullet_3', 'Works with metal, plastic and composite materials.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_5_image' ) ?: 0,
    ],
    [
        'title'   => steelplast_t( 'steelplast/about/equipment-cards', 'card_6_title', 'CNC turn-mill machines' ),
        'lead'    => steelplast_t( 'steelplast/about/equipment-cards', 'card_6_lead', 'What they do:' ),
        'bullets' => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_6_bullet_1', 'Turning, milling, drilling, threading — every operation without a re-setup!' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_6_image' ) ?: 0,
    ],
];

?>

<section class="sp-about-equipment" aria-labelledby="sp-about-equipment-title">
    <div class="content-wrapper">

        <header class="sp-about-equipment__header" data-sp-animate>
            <p class="sp-section-label sp-section-label--dark-bg">
                <span class="sp-section-label__index" aria-hidden="true">[04]</span>
                <?php echo esc_html( $label ); ?>
            </p>
            <h2 class="sp-about-equipment__title sp-section-title" id="sp-about-equipment-title">
                <?php echo esc_html( $title ); ?>
            </h2>
            <p class="sp-about-equipment__desc sp-section-desc">
                <?php echo esc_html( $desc ); ?>
            </p>
        </header>

        <div class="sp-about-equipment__grid" role="list" data-sp-animate-group>
            <?php foreach ( $cards as $i => $card ) : $n = $i + 1; ?>
                <article class="sp-about-equipment__card" role="listitem" data-sp-animate>

                    <div class="sp-about-equipment__card-header">
                        <span class="sp-about-equipment__card-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>
                        <h3 class="sp-about-equipment__card-title"><?php echo esc_html( $card['title'] ); ?></h3>
                    </div>

                    <?php // Every photo is stored cropped to the 4/3 card frame, so it just fills it. ?>
                    <div class="sp-about-equipment__card-media">
                        <?php if ( ! empty( $card['image_id'] ) ) : ?>
                            <?php echo wp_get_attachment_image( (int) $card['image_id'], 'large', false, [
                                'loading' => 'lazy',
                                'class'   => 'sp-about-equipment__card-img',
                            ] ); ?>
                        <?php else : ?>
                            <div class="sp-about-equipment__card-placeholder" aria-hidden="true"></div>
                        <?php endif; ?>
                    </div>

                    <div class="sp-about-equipment__card-body">
                        <?php if ( ! empty( $card['lead'] ) ) : ?>
                            <p class="sp-about-equipment__card-lead"><?php echo esc_html( $card['lead'] ); ?></p>
                        <?php endif; ?>

                        <?php if ( ! empty( $card['bullets'] ) ) : ?>
                            <ul class="sp-about-equipment__card-bullets">
                                <?php foreach ( $card['bullets'] as $bullet ) : ?>
                                    <li><?php echo esc_html( $bullet ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php elseif ( ! empty( $card['desc'] ) ) : ?>
                            <?php foreach ( $card['desc'] as $paragraph ) : ?>
                                <p class="sp-about-equipment__card-desc"><?php echo esc_html( $paragraph ); ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
