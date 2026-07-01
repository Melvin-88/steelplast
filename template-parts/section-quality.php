<?php
/**
 * Quality section — [03] with 4 certification cards.
 * Usage: get_template_part( 'template-parts/section-quality' );
 *
 * @package SteelPlast
 */

$quality_page = get_page_by_path( 'quality' );
$quality_url  = $quality_page ? get_permalink( $quality_page ) : '';

// Fixed set of evergreen certification claims — an icon communicates each
// one more reliably than a photo (there is no meaningful photo of a
// "Zero-Defect Policy"), and never falls back to an empty placeholder.
$cards = [
    [
        'title' => steelplast_t( 'steelplast/quality/cards', 'card_1_title', 'IATF 16949 Certified' ),
        'desc'  => steelplast_t( 'steelplast/quality/cards', 'card_1_desc',  'International automotive quality management standard applied at every production stage.' ),
        // Shield + checkmark — certified compliance
        'icon'  => '<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 3l9 3.5v6c0 6.5-4 10.5-9 12.5-5-2-9-6-9-12.5v-6L14 3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M10 14l3 3 5-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    ],
    [
        'title' => steelplast_t( 'steelplast/quality/cards', 'card_2_title', 'ISO 9001 Certified' ),
        'desc'  => steelplast_t( 'steelplast/quality/cards', 'card_2_desc',  'Confirmed quality management system ensuring consistent product excellence.' ),
        // Medal / rosette — certification seal
        'icon'  => '<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="14" cy="11" r="7" stroke="currentColor" stroke-width="1.6"/><path d="M14 8.3l1.1 2.3 2.5.4-1.8 1.8.4 2.5-2.2-1.2-2.2 1.2.4-2.5-1.8-1.8 2.5-.4L14 8.3z" fill="currentColor"/><path d="M10.5 17.3l-1.5 6.7 5-2.5 5 2.5-1.5-6.7" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>',
    ],
    [
        'title' => steelplast_t( 'steelplast/quality/cards', 'card_3_title', '6-Stage Control' ),
        'desc'  => steelplast_t( 'steelplast/quality/cards', 'card_3_desc',  'Multi-step inspection from raw material intake to finished product shipment.' ),
        // Ascending bars — staged process
        'icon'  => '<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 21h6v-4H4v4zM11 21h6v-9h-6v9zM18 21h6v-14h-6v14z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>',
    ],
    [
        'title' => steelplast_t( 'steelplast/quality/cards', 'card_4_title', 'Zero-Defect Policy' ),
        'desc'  => steelplast_t( 'steelplast/quality/cards', 'card_4_desc',  'Numerous client awards for outstanding quality and exceptional production results.' ),
        // Trophy — awards and recognition
        'icon'  => '<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 4h10v6a5 5 0 0 1-10 0V4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 6H6a3 3 0 0 0 3 5M19 6h3a3 3 0 0 1-3 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M14 15v3M10 22h8M11 22c0-2 1-3 3-3s3 1 3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    ],
];
?>

<section class="sp-quality" aria-labelledby="sp-quality-title">
    <div class="content-wrapper">

        <div class="sp-quality__layout">

            <div class="sp-quality__left">
                <p class="sp-section-label sp-section-label--light-bg">
                    <span class="sp-section-label__index" aria-hidden="true">[03]</span>
                    <?php echo esc_html( steelplast_t( 'steelplast/quality/header', 'label', 'Quality of products' ) ); ?>
                </p>

                <h2 class="sp-quality__title sp-section-title" id="sp-quality-title">
                    <?php echo esc_html( steelplast_t( 'steelplast/quality/header', 'title', 'High product quality' ) ); ?>
                </h2>

                <p class="sp-quality__desc sp-section-desc">
                    <?php echo esc_html( steelplast_t( 'steelplast/quality/header', 'desc', 'In accordance with IATF and ISO 9001 standards. Numerous client awards for Outstanding Quality and exceptional production results.' ) ); ?>
                </p>

                <?php if ( $quality_url ) : ?>
                <div class="sp-quality__cta-wrap">
                    <a href="<?php echo esc_url( $quality_url ); ?>"
                       class="sp-btn sp-btn--primary sp-btn--md sp-btn--on-light"
                       aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/quality/header', 'cta_aria', 'Learn more about our quality standards' ) ); ?>">
                        <span class="sp-btn__icon" aria-hidden="true">↳</span>
                        <?php echo esc_html( steelplast_t( 'steelplast/quality/header', 'cta_text', 'Learn more' ) ); ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <div class="sp-quality__grid" role="list"
                 aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/quality/cards', 'grid_aria', 'Quality certifications' ) ); ?>">

                <?php foreach ( $cards as $card ) : ?>
                <article class="sp-quality__card" role="listitem">

                    <div class="sp-quality__card-header">
                        <div class="sp-quality__card-icon" aria-hidden="true">
                            <?php echo $card['icon']; // phpcs:ignore -- fixed inline SVG markup, not user input ?>
                        </div>
                        <h3 class="sp-quality__card-title"><?php echo esc_html( $card['title'] ); ?></h3>
                    </div>

                    <div class="sp-quality__card-body">
                        <p class="sp-quality__card-desc"><?php echo esc_html( $card['desc'] ); ?></p>
                    </div>

                </article>
                <?php endforeach; ?>

            </div>

        </div>

    </div>
</section>
