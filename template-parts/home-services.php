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

// Every card links to its real service page under the Services nav dropdown
$stamping_page = get_page_by_path( 'штампування-металу' );
$stamping_url  = $stamping_page ? get_permalink( $stamping_page ) : '';

$plastic_page = get_page_by_path( 'лиття-пластмас' );
$plastic_url  = $plastic_page ? get_permalink( $plastic_page ) : '';

$mold_page = get_page_by_path( 'прес-форми-та-штампи' );
$mold_url  = $mold_page ? get_permalink( $mold_page ) : '';

$mechanical_page = get_page_by_path( 'механічна-обробка' );
$mechanical_url  = $mechanical_page ? get_permalink( $mechanical_page ) : '';

$tooling_page = get_page_by_path( 'технологічне-оснащення' );
$tooling_url  = $tooling_page ? get_permalink( $tooling_page ) : '';

// Row 1 — 3 cards with image + text
$services_row1 = [
    [
        'id'       => 'stamping',
        'title'    => steelplast_t( 'steelplast/home/services', 'card_1_title', 'Metal Stamping' ),
        'desc'     => steelplast_t( 'steelplast/home/services', 'card_1_desc',  'Precision sheet metal stamping — blanking, bending and deep drawing — for parts from 0.15 to 5 mm thick.' ),
        'image_id' => $img_ids[1],
        'url'      => $stamping_url,
    ],
    [
        'id'       => 'plastic',
        'title'    => steelplast_t( 'steelplast/home/services', 'card_2_title', 'Plastic Injection Molding' ),
        'desc'     => steelplast_t( 'steelplast/home/services', 'card_2_desc',  'Injection molding of technical plastics on modern thermoplastic machines, from prototypes to volume production.' ),
        'image_id' => $img_ids[2],
        'url'      => $plastic_url,
    ],
    [
        'id'       => 'mold',
        'title'    => steelplast_t( 'steelplast/home/services', 'card_3_title', 'Mold & Die Manufacturing' ),
        'desc'     => steelplast_t( 'steelplast/home/services', 'card_3_desc',  'In-house design and manufacture of injection molds and stamping dies, built to your part from steel selection to trial shots.' ),
        'image_id' => $img_ids[3],
        'url'      => $mold_url,
    ],
];

// Row 2 — mechanical machining (wide card, this is the flagship service — it
// gets the larger card slot instead of Metal Stamping)
$mechanical_title   = steelplast_t( 'steelplast/home/services', 'card_4_title', 'Mechanical Machining' );
$mechanical_desc    = steelplast_t( 'steelplast/home/services', 'card_4_desc',  'Full-cycle CNC turning and milling for metal parts of any complexity — from a single prototype to serial production.' );
$mechanical_cap     = steelplast_t( 'steelplast/home/services', 'card_4_cap',   'Manufacturing capabilities:' );
$mechanical_bullets = [
    steelplast_t( 'steelplast/home/services', 'card_4_bullet_1', 'CNC turning and milling in a single process chain' ),
    steelplast_t( 'steelplast/home/services', 'card_4_bullet_2', 'Structural, tool and stainless steel, aluminum, brass, titanium' ),
    steelplast_t( 'steelplast/home/services', 'card_4_bullet_3', 'Machining tolerance up to ±0.005 mm' ),
];

// Row 2 — custom tooling & fixtures card (image + text)
$tooling = [
    'id'       => 'tooling',
    'title'    => steelplast_t( 'steelplast/home/services', 'card_5_title', 'Custom Tooling & Fixtures' ),
    'desc'     => steelplast_t( 'steelplast/home/services', 'card_5_desc',  'Assembly jigs, inspection gauges and welding fixtures, designed and built in-house to fit your exact process.' ),
    'image_id' => $img_ids[5],
];

$mechanical_image_id = $img_ids[4];
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

            <!-- Mechanical Machining — wide card: spans 2 columns, image left + text right.
                 This is the flagship service, so it takes the larger card slot. -->
            <article class="sp-services__card sp-services__card--wide" data-service="mechanical">

                <div class="sp-services__card-image sp-services__card-image--side">
                    <?php if ( $mechanical_image_id ) : ?>
                        <?php echo wp_get_attachment_image( $mechanical_image_id, 'large', false, [
                            'loading' => 'lazy',
                            'class'   => 'sp-services__card-img',
                        ] ); ?>
                    <?php else : ?>
                        <div class="sp-services__card-image-placeholder" aria-hidden="true"></div>
                    <?php endif; ?>
                </div>

                <div class="sp-services__card-inner">
                    <div class="sp-services__card-body">
                        <h3 class="sp-services__card-title"><?php echo esc_html( $mechanical_title ); ?></h3>
                        <p class="sp-services__card-desc"><?php echo esc_html( $mechanical_desc ); ?></p>
                        <p class="sp-services__card-cap"><?php echo esc_html( $mechanical_cap ); ?></p>
                        <ul class="sp-services__card-bullets">
                            <?php foreach ( $mechanical_bullets as $bullet ) : ?>
                                <li><?php echo esc_html( $bullet ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php if ( $mechanical_url ) : ?>
                    <div class="sp-services__card-footer">
                        <a href="<?php echo esc_url( $mechanical_url ); ?>" class="sp-btn sp-btn--ghost sp-btn--md sp-btn--full" aria-label="<?php echo esc_attr( $mechanical_title ); ?> — <?php echo esc_attr( $cta_label ); ?>">
                            <span><?php echo esc_html( $cta_label ); ?></span>
                            <span class="sp-btn__icon" aria-hidden="true">↳</span>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

            </article>

            <!-- Custom Tooling & Fixtures card -->
            <?php get_template_part( 'template-parts/component-image-card', null, [
                'id'        => $tooling['id'],
                'title'     => $tooling['title'],
                'desc'      => $tooling['desc'],
                'image_id'  => $tooling['image_id'],
                'cta_label' => ! empty( $tooling_url ) ? $cta_label : '',
                'cta_href'  => $tooling_url,
            ] ); ?>

        </div><!-- /.sp-services__grid -->

    </div>
</section>
