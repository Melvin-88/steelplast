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
$desc  = steelplast_t( 'steelplast/about/equipment', 'desc', "That's why Steel Plast uses high-precision equipment that allows us to perform a wide range of metalworking and manufacturing tasks while maintaining the highest quality standards." );

// Photos are the same for every language — always read from the default-language post
$cards = [
    [
        'title'   => steelplast_t( 'steelplast/about/equipment-cards', 'card_1_title', 'Swiss-type automatic lathe' ),
        'lead'    => steelplast_t( 'steelplast/about/equipment-cards', 'card_1_lead', 'What it does:' ),
        'bullets' => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_1_bullet_1', 'Produces small, highly precise parts — pins, shafts, screws, and components for medical devices, watches and electronics.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_1_bullet_2', 'Can turn, mill, drill and thread — all in a single pass.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_1_bullet_3', 'Runs fully automatically without an operator — just load the bar stock and the machine handles the rest.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_1_image' ) ?: 0,
    ],
    [
        'title' => steelplast_t( 'steelplast/about/equipment-cards', 'card_2_title', 'Crank stamping presses' ),
        'desc'  => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_2_desc_1', 'A crank stamping press is a machine that shapes metal using the force of impact.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_2_desc_2', 'It transforms a flat metal sheet into a finished part — press, strike, and the shape is ready.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_2_image' ) ?: 0,
    ],
    [
        'title' => steelplast_t( 'steelplast/about/equipment-cards', 'card_3_title', 'Injection molding machines' ),
        'lead'  => steelplast_t( 'steelplast/about/equipment-cards', 'card_3_lead', 'How does it work?' ),
        'desc'  => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_3_desc_1', 'Plastic granules are fed in, melted down to a liquid state inside the machine, and then injected under high pressure into a mold.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_3_image' ) ?: 0,
    ],
    [
        'title' => steelplast_t( 'steelplast/about/equipment-cards', 'card_4_title', 'Wire-cut and sinker EDM machines' ),
        'desc'  => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_4_desc_1', 'An EDM machine is a machine that cuts metal... using electricity!' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_4_desc_2', 'Not with a cutting tool or a mill — but with an electric spark that erodes metal with micron-level precision.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_4_image' ) ?: 0,
    ],
    [
        'title'   => steelplast_t( 'steelplast/about/equipment-cards', 'card_5_title', '5-axis CNC milling machines' ),
        'lead'    => steelplast_t( 'steelplast/about/equipment-cards', 'card_5_lead', 'What it does:' ),
        'bullets' => [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_5_bullet_1', 'Mills, drills and cuts complex shapes.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_5_bullet_2', 'Produces 3D surfaces, blades, housings and mold cavities.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_5_bullet_3', 'Works with metal, plastic and composite materials.' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_5_bullet_4', 'Accuracy of up to 0.001 mm.' ),
        ],
        'image_id' => steelplast_get_field_default_lang( 'about_equipment_card_5_image' ) ?: 0,
    ],
];

// A 6th machine may be added later — the ACF image field and grid layout
// already support it, only a new $cards entry needs to be appended above.
$card_6_image = steelplast_get_field_default_lang( 'about_equipment_card_6_image' ) ?: 0;
$card_6_title = steelplast_t( 'steelplast/about/equipment-cards', 'card_6_title', 'CNC turn-mill machines (2023–2024)' );
if ( $card_6_title ) {
    $cards[] = [
        'title'   => $card_6_title,
        'lead'    => steelplast_t( 'steelplast/about/equipment-cards', 'card_6_lead', 'They can do it all:' ),
        'bullets' => array_filter( [
            steelplast_t( 'steelplast/about/equipment-cards', 'card_6_bullet_1', 'Turning, milling, drilling, threading — all on a single part, without stopping!' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_6_bullet_2', '' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_6_bullet_3', '' ),
            steelplast_t( 'steelplast/about/equipment-cards', 'card_6_bullet_4', '' ),
        ] ),
        'image_id' => $card_6_image,
    ];
}
?>

<section class="sp-about-equipment" aria-labelledby="sp-about-equipment-title">
    <div class="content-wrapper">

        <header class="sp-about-equipment__header">
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

        <div class="sp-about-equipment__grid" role="list">
            <?php foreach ( $cards as $i => $card ) : $n = $i + 1; ?>
                <article class="sp-about-equipment__card" role="listitem">

                    <div class="sp-about-equipment__card-header">
                        <span class="sp-about-equipment__card-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>
                        <h3 class="sp-about-equipment__card-title"><?php echo esc_html( $card['title'] ); ?></h3>
                    </div>

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
