<?php
/**
 * About page — [02] Our advantages, 8-card grid (dark background).
 * Usage: get_template_part( 'template-parts/section-about-advantages' );
 *
 * @package SteelPlast
 */

$label = steelplast_t( 'steelplast/about/advantages', 'label', 'Our advantages' );
$title = steelplast_t(
    'steelplast/about/advantages',
    'title',
    "We combine modern technology, team experience\nand quality control at every stage of production."
);

$cards = [
    [
        'title' => steelplast_t( 'steelplast/about/advantages-cards', 'card_1_title', 'Full production cycle' ),
        'desc'  => steelplast_t( 'steelplast/about/advantages-cards', 'card_1_desc', 'We perform the full range of work — from engineering design and documentation to manufacturing the finished product.' ),
    ],
    [
        'title' => steelplast_t( 'steelplast/about/advantages-cards', 'card_2_title', 'Modern equipment' ),
        'desc'  => steelplast_t( 'steelplast/about/advantages-cards', 'card_2_desc', 'We use high-precision machinery and technology that ensure stable quality and accuracy of every part.' ),
    ],
    [
        'title' => steelplast_t( 'steelplast/about/advantages-cards', 'card_3_title', 'Experienced team' ),
        'desc'  => steelplast_t( 'steelplast/about/advantages-cards', 'card_3_desc', 'Every project is handled by qualified engineers, designers and technologists with years of experience.' ),
    ],
    [
        'title' => steelplast_t( 'steelplast/about/advantages-cards', 'card_4_title', 'Individual approach' ),
        'desc'  => steelplast_t( 'steelplast/about/advantages-cards', 'card_4_desc', 'We develop solutions that take into account technical requirements, production specifics and the client\'s goals.' ),
    ],
    [
        'title' => steelplast_t( 'steelplast/about/advantages-cards', 'card_5_title', 'Quality control' ),
        'desc'  => steelplast_t( 'steelplast/about/advantages-cards', 'card_5_desc', 'We inspect products at every stage of production, guaranteeing compliance with technical standards.' ),
    ],
    [
        'title' => steelplast_t( 'steelplast/about/advantages-cards', 'card_6_title', 'Flexible production' ),
        'desc'  => steelplast_t( 'steelplast/about/advantages-cards', 'card_6_desc', 'We work with single orders and prototypes as well as with large-scale serial batches.' ),
    ],
    [
        'title' => steelplast_t( 'steelplast/about/advantages-cards', 'card_7_title', 'On-time delivery' ),
        'desc'  => steelplast_t( 'steelplast/about/advantages-cards', 'card_7_desc', 'Optimized production processes allow us to complete orders within agreed deadlines without any loss of quality.' ),
    ],
    [
        'title' => steelplast_t( 'steelplast/about/advantages-cards', 'card_8_title', 'Reliable partnership' ),
        'desc'  => steelplast_t( 'steelplast/about/advantages-cards', 'card_8_desc', 'We build long-term relationships with clients, ensuring open communication and a responsible approach to every project.' ),
    ],
];
?>

<section class="sp-about-advantages" aria-labelledby="sp-about-advantages-title">
    <div class="content-wrapper">

        <header class="sp-about-advantages__header" data-sp-animate>
            <p class="sp-section-label sp-section-label--dark-bg">
                <span class="sp-section-label__index" aria-hidden="true">[02]</span>
                <?php echo esc_html( $label ); ?>
            </p>
            <h2 class="sp-about-advantages__title sp-section-title" id="sp-about-advantages-title">
                <?php echo esc_html( $title ); ?>
            </h2>
        </header>

        <div class="sp-about-advantages__grid" role="list" data-sp-animate-group>
            <?php foreach ( $cards as $i => $card ) : $n = $i + 1; ?>
                <article class="sp-about-advantages__card" role="listitem" data-sp-animate>
                    <span class="sp-about-advantages__card-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>
                    <h3 class="sp-about-advantages__card-title"><?php echo esc_html( $card['title'] ); ?></h3>
                    <p class="sp-about-advantages__card-desc"><?php echo esc_html( $card['desc'] ); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
