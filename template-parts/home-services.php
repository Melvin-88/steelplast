<?php
/**
 * Template part: Home — Services section
 */

// Images are the same for every language — always read from the
// default-language post (see steelplast_get_field_default_lang()).
$img_ids = [];
for ( $i = 1; $i <= 6; $i++ ) {
    $img_ids[ $i ] = steelplast_get_field_default_lang( "services_card_{$i}_image" ) ?: 0;
}

$section_label = steelplast_t( 'steelplast/home/services', 'section_label', 'Our Services' );
$title         = steelplast_t( 'steelplast/home/services', 'title',         'Modern equipment, manufacturing precision and quality control' );
$cta_label     = steelplast_t( 'steelplast/home/services', 'cta_label',     'Learn more' );

// One card per service page, all the same shape. Slugs are the default-language
// ones; steelplast_page_url() resolves them to the language being rendered.
$services = [
    [
        'id'    => 'stamping',
        'slug'  => 'штампування-металу',
        'title' => steelplast_t( 'steelplast/home/services', 'card_1_title', 'Metal Processing' ),
        'desc'  => steelplast_t( 'steelplast/home/services', 'card_1_desc',  'High-precision CNC metal machining for parts of any complexity.' ),
        'image' => $img_ids[1],
    ],
    [
        'id'    => 'plastic',
        'slug'  => 'лиття-пластмас',
        'title' => steelplast_t( 'steelplast/home/services', 'card_2_title', 'Plastic Casting' ),
        'desc'  => steelplast_t( 'steelplast/home/services', 'card_2_desc',  'Manufacturing plastic products by injection molding on modern thermoplastic machines.' ),
        'image' => $img_ids[2],
    ],
    [
        'id'    => 'molds',
        'slug'  => 'прес-форми-та-штампи',
        'title' => steelplast_t( 'steelplast/home/services', 'card_3_title', 'Laser Metal Cutting' ),
        'desc'  => steelplast_t( 'steelplast/home/services', 'card_3_desc',  'High-precision laser metal cutting for parts of any complexity.' ),
        'image' => $img_ids[3],
    ],
    [
        'id'    => 'machining',
        'slug'  => 'механічна-обробка',
        'title' => steelplast_t( 'steelplast/home/services', 'card_4_title', 'Stamping' ),
        'desc'  => steelplast_t( 'steelplast/home/services', 'card_4_desc',  'STEELPLAST manufactures stamped components for various industrial sectors.' ),
        'image' => $img_ids[4],
    ],
    [
        'id'    => 'tooling',
        'slug'  => 'технологічне-оснащення',
        'title' => steelplast_t( 'steelplast/home/services', 'card_5_title', 'Powder Coating' ),
        'desc'  => steelplast_t( 'steelplast/home/services', 'card_5_desc',  'Powder coating of metal products ensuring uniform and durable finish.' ),
        'image' => $img_ids[5],
    ],
    [
        'id'    => 'wire',
        'slug'  => 'пружини-та-вироби-з-дроту',
        'title' => steelplast_t( 'steelplast/home/services', 'card_6_title', 'Springs & Wire Products' ),
        'desc'  => steelplast_t( 'steelplast/home/services', 'card_6_desc',  'Made-to-order springs and formed wire parts, from a drawing or a sample.' ),
        'image' => $img_ids[6],
    ],
];
?>

<section class="sp-services" aria-labelledby="services-title">
    <div class="sp-wrap">

        <header class="sp-services__header" data-sp-animate>
            <p class="sp-section-label sp-section-label--light-bg">
                <span class="sp-section-label__index" aria-hidden="true">[01]</span>
                <?php echo esc_html( $section_label ); ?>
            </p>
            <h2 id="services-title" class="sp-services__title sp-section-title"><?php echo esc_html( $title ); ?></h2>
        </header>

        <div class="sp-services__grid" data-sp-animate-group>

            <?php foreach ( $services as $service ) :
                get_template_part( 'template-parts/component-image-card', null, [
                    'id'        => $service['id'],
                    'title'     => $service['title'],
                    'desc'      => $service['desc'],
                    'image_id'  => $service['image'],
                    'cta_label' => $cta_label,
                    'cta_href'  => steelplast_page_url( $service['slug'] ),
                ] );
            endforeach; ?>

        </div><!-- /.sp-services__grid -->

    </div>
</section>
