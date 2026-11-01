<?php
/**
 * Service page — long-form SEO text block, split into topic columns.
 * Sits between the "Technical Parameters" cards and the "About us" teaser to
 * break up two consecutive dark sections and give room for more descriptive,
 * keyword-rich copy about the service.
 * Usage: get_template_part( 'template-parts/section-service-content', null, $args );
 * Args (all optional — default to CNC Milling & Turning content):
 *   'label_index' (string) e.g. '[02]'
 *   'label'       (string) section label text
 *   'title'       (string) H2 title
 *   'intro'       (string) intro paragraph shown above the topic columns
 *   'topics'      (array)  each item: [ 'heading' => ..., 'paragraphs' => [ ... ] ]
 *
 * @package SteelPlast
 */

$ctx = 'steelplast/service-cnc-machining/content';

$label_index = $args['label_index'] ?? '[02]';
$label       = $args['label']       ?? steelplast_t( $ctx, 'label', 'CNC Milling & Turning' );
$title       = $args['title']       ?? steelplast_t( $ctx, 'title', 'CNC Milling and Turning Services' );
$intro       = $args['intro']       ?? steelplast_t( $ctx, 'intro', 'Steel Plast operates a fleet of CNC milling and turning machines, which allows us to machine parts of virtually any geometry — from flat brackets to complex rotational parts. Whatever your drawing requires, our engineers select the process, tooling and setup that deliver the best precision and the shortest lead times.' );

$topics = $args['topics'] ?? [
    [
        'heading'    => steelplast_t( $ctx, 'topic_1_heading', 'CNC Milling' ),
        'paragraphs' => [
            steelplast_t( $ctx, 'topic_1_p1', 'Our CNC machining centers mill material from a solid workpiece to produce flat surfaces, pockets, slots and complex 3D contours with high precision. Multi-axis milling lets us machine undercuts and curved surfaces in a single setup, which shortens lead times and keeps dimensions consistent across the entire part.' ),
            steelplast_t( $ctx, 'topic_1_p2', 'CNC milling is our core technology for producing housings, brackets, plates and mold components. We machine both prototypes and production batches at high speed.' ),
        ],
    ],
    [
        'heading'    => steelplast_t( $ctx, 'topic_2_heading', 'CNC Turning' ),
        'paragraphs' => [
            steelplast_t( $ctx, 'topic_2_p1', 'CNC turning rotates the workpiece against a cutting tool to produce cylindrical and other rotational shapes — shafts, bushings, flanges, pins and threaded parts. Our machines perform external and internal turning, threading, grooving and parting off in a single cycle, minimizing the number of setups.' ),
            steelplast_t( $ctx, 'topic_2_p2', 'Finished parts are widely used in the automotive industry, industrial equipment and fasteners, where round geometry and axial precision matter most. We manufacture parts from steel, stainless steel, aluminum, copper and brass, and can combine turning with subsequent milling for parts that need both round and flat features.' ),
        ],
    ],
];
?>

<section class="sp-service-content" aria-labelledby="service-content-title">
    <div class="content-wrapper">

        <div class="sp-service-content__header" data-sp-animate>
            <p class="sp-section-label sp-section-label--light-bg">
                <span class="sp-section-label__index" aria-hidden="true"><?php echo esc_html( $label_index ); ?></span>
                <?php echo esc_html( $label ); ?>
            </p>
            <h2 class="sp-service-content__title sp-section-title" id="service-content-title">
                <?php echo esc_html( $title ); ?>
            </h2>
            <?php if ( $intro ) : ?>
                <p class="sp-service-content__intro sp-section-desc"><?php echo esc_html( $intro ); ?></p>
            <?php endif; ?>
        </div>

        <div class="sp-service-content__grid" data-sp-animate-group>
            <?php foreach ( $topics as $topic ) : ?>
                <div class="sp-service-content__topic" data-sp-animate>
                    <h3 class="sp-service-content__topic-heading"><?php echo esc_html( $topic['heading'] ); ?></h3>
                    <?php foreach ( $topic['paragraphs'] as $paragraph ) : ?>
                        <p class="sp-service-content__topic-text"><?php echo esc_html( $paragraph ); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
