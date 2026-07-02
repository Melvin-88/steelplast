<?php
/**
 * Template part: Home — Services section
 */

// Images are the same for every language — always read from the
// default-language post (see steelplast_get_field_default_lang()).
$img_ids = [
    1 => steelplast_get_field_default_lang( 'services_card_1_image' ) ?: 0,
    2 => steelplast_get_field_default_lang( 'services_card_2_image' ) ?: 0,
    3 => steelplast_get_field_default_lang( 'services_card_3_image' ) ?: 0,
    4 => steelplast_get_field_default_lang( 'services_card_4_image' ) ?: 0,
    5 => steelplast_get_field_default_lang( 'services_card_5_image' ) ?: 0,
];

$section_label = steelplast_t( 'steelplast/home/services', 'section_label', 'Our Services' );
$title         = steelplast_t( 'steelplast/home/services', 'title',         'Modern equipment, manufacturing precision and quality control' );
$description   = steelplast_t( 'steelplast/home/services', 'description',   'Individual approach to every project, official contracts, staged payments and constant communication' );
$cta_label     = steelplast_t( 'steelplast/home/services', 'cta_label',     'Learn more' );

// Metal Processing card links to the CNC Machining service page, once created
$metal_page = get_page_by_path( 'механічна-обробка' );
$metal_url  = $metal_page ? get_permalink( $metal_page ) : '#';

// Row 1 — 3 cards with image + text
$services_row1 = [
    [
        'id'       => 'metal',
        'title'    => steelplast_t( 'steelplast/home/services', 'card_1_title', 'Metal Processing' ),
        'desc'     => steelplast_t( 'steelplast/home/services', 'card_1_desc',  'High-precision CNC metal machining for parts of any complexity.' ),
        'image_id' => $img_ids[1],
        'url'      => $metal_url,
    ],
    [
        'id'       => 'plastic',
        'title'    => steelplast_t( 'steelplast/home/services', 'card_2_title', 'Plastic Casting' ),
        'desc'     => steelplast_t( 'steelplast/home/services', 'card_2_desc',  'Manufacturing plastic products by injection molding on modern thermoplastic machines.' ),
        'image_id' => $img_ids[2],
    ],
    [
        'id'       => 'laser',
        'title'    => steelplast_t( 'steelplast/home/services', 'card_3_title', 'Laser Metal Cutting' ),
        'desc'     => steelplast_t( 'steelplast/home/services', 'card_3_desc',  'High-precision laser metal cutting for parts of any complexity.' ),
        'image_id' => $img_ids[3],
    ],
];

// Row 2 — stamping (text-only card) data
$stamping_title   = steelplast_t( 'steelplast/home/services', 'card_4_title', 'Stamping' );
$stamping_desc    = steelplast_t( 'steelplast/home/services', 'card_4_desc',  'STEELPLAST manufactures stamped components for various industrial sectors.' );
$stamping_cap     = steelplast_t( 'steelplast/home/services', 'card_4_cap',   'Manufacturing capabilities:' );
$stamping_bullets = [
    steelplast_t( 'steelplast/home/services', 'card_4_bullet_1', 'Sheet metal processing 0.15–5 mm thick' ),
    steelplast_t( 'steelplast/home/services', 'card_4_bullet_2', 'Crank pneumatic presses' ),
    steelplast_t( 'steelplast/home/services', 'card_4_bullet_3', 'Maximum pressing force — up to 100 t' ),
];

// Row 2 — painting card (image + text)
$painting = [
    'id'       => 'painting',
    'title'    => steelplast_t( 'steelplast/home/services', 'card_5_title', 'Powder Coating' ),
    'desc'     => steelplast_t( 'steelplast/home/services', 'card_5_desc',  'Powder coating of metal products ensuring uniform and durable finish.' ),
    'image_id' => $img_ids[5],
];

$stamping_image_id = $img_ids[4];
?>

<section class="sp-services" aria-labelledby="services-title">
    <div class="sp-wrap">

        <header class="sp-services__header">
            <p class="sp-section-label sp-section-label--light-bg">
                <span class="sp-section-label__index" aria-hidden="true">[01]</span>
                <?php echo esc_html( $section_label ); ?>
            </p>
            <h2 id="services-title" class="sp-services__title sp-section-title"><?php echo esc_html( $title ); ?></h2>
            <p class="sp-services__description sp-section-desc"><?php echo esc_html( $description ); ?></p>
        </header>

        <!-- Single 3-column grid: row 1 (3 cards) + row 2 (wide card span-2 + 1 card) -->
        <div class="sp-services__grid">

            <?php foreach ( $services_row1 as $service ) :
                // Only show the CTA once the service has a real page to link to —
                // an empty href="#" would just jump to the top of the page.
                get_template_part( 'template-parts/component-image-card', null, [
                    'id'        => $service['id'],
                    'title'     => $service['title'],
                    'desc'      => $service['desc'],
                    'image_id'  => $service['image_id'],
                    'cta_label' => ! empty( $service['url'] ) ? $cta_label : '',
                    'cta_href'  => $service['url'] ?? '',
                ] );
            endforeach; ?>

            <!-- Stamping — wide card: spans 2 columns, image left + text right -->
            <article class="sp-services__card sp-services__card--wide" data-service="stamping">

                <div class="sp-services__card-image sp-services__card-image--side">
                    <?php if ( $stamping_image_id ) : ?>
                        <?php echo wp_get_attachment_image( $stamping_image_id, 'large', false, [
                            'loading' => 'lazy',
                            'class'   => 'sp-services__card-img',
                        ] ); ?>
                    <?php else : ?>
                        <div class="sp-services__card-image-placeholder" aria-hidden="true"></div>
                    <?php endif; ?>
                </div>

                <div class="sp-services__card-inner">
                    <div class="sp-services__card-body">
                        <h3 class="sp-services__card-title"><?php echo esc_html( $stamping_title ); ?></h3>
                        <p class="sp-services__card-desc"><?php echo esc_html( $stamping_desc ); ?></p>
                        <p class="sp-services__card-cap"><?php echo esc_html( $stamping_cap ); ?></p>
                        <ul class="sp-services__card-bullets">
                            <?php foreach ( $stamping_bullets as $bullet ) : ?>
                                <li><?php echo esc_html( $bullet ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="sp-services__card-footer">
                        <a href="#" class="sp-btn sp-btn--ghost sp-btn--md sp-btn--full" aria-label="<?php echo esc_attr( $stamping_title ); ?> — <?php echo esc_attr( $cta_label ); ?>">
                            <span><?php echo esc_html( $cta_label ); ?></span>
                            <span class="sp-btn__icon" aria-hidden="true">↳</span>
                        </a>
                    </div>
                </div>

            </article>

            <!-- Powder Coating card -->
            <?php get_template_part( 'template-parts/component-image-card', null, [
                'id'        => $painting['id'],
                'title'     => $painting['title'],
                'desc'      => $painting['desc'],
                'image_id'  => $painting['image_id'],
                'cta_label' => $cta_label,
            ] ); ?>

        </div><!-- /.sp-services__grid -->

    </div>
</section>
