<?php
/**
 * Quality section — [03] with 4 certification cards.
 * Usage: get_template_part( 'template-parts/section-quality' );
 *
 * @package SteelPlast
 */

$quality_page = get_page_by_path( 'quality' );
$quality_url  = $quality_page ? get_permalink( $quality_page ) : '';

$cards = [
    [
        'key'   => 'card_1',
        'title' => steelplast_t( 'steelplast/quality/cards', 'card_1_title', 'IATF 16949 Certified' ),
        'desc'  => steelplast_t( 'steelplast/quality/cards', 'card_1_desc',  'International automotive quality management standard applied at every production stage.' ),
    ],
    [
        'key'   => 'card_2',
        'title' => steelplast_t( 'steelplast/quality/cards', 'card_2_title', 'ISO 9001 Certified' ),
        'desc'  => steelplast_t( 'steelplast/quality/cards', 'card_2_desc',  'Confirmed quality management system ensuring consistent product excellence.' ),
    ],
    [
        'key'   => 'card_3',
        'title' => steelplast_t( 'steelplast/quality/cards', 'card_3_title', '6-Stage Control' ),
        'desc'  => steelplast_t( 'steelplast/quality/cards', 'card_3_desc',  'Multi-step inspection from raw material intake to finished product shipment.' ),
    ],
    [
        'key'   => 'card_4',
        'title' => steelplast_t( 'steelplast/quality/cards', 'card_4_title', 'Zero-Defect Policy' ),
        'desc'  => steelplast_t( 'steelplast/quality/cards', 'card_4_desc',  'Numerous client awards for outstanding quality and exceptional production results.' ),
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

                <?php foreach ( $cards as $card ) :
                    $img_id = function_exists( 'get_field' ) ? get_field( 'quality_' . $card['key'] . '_image' ) : null;
                    // ACF may return an array (image object) or an integer (attachment ID)
                    if ( is_array( $img_id ) ) {
                        $img_id = $img_id['ID'] ?? ( $img_id['id'] ?? null );
                    }
                ?>
                <article class="sp-quality__card" role="listitem">

                    <div class="sp-quality__card-image">
                        <?php if ( $img_id ) : ?>
                            <?php echo wp_get_attachment_image( (int) $img_id, 'medium', false, [
                                'loading' => 'lazy',
                                'class'   => 'sp-quality__card-img',
                            ] ); ?>
                        <?php else : ?>
                            <div class="sp-quality__card-placeholder" aria-hidden="true"></div>
                        <?php endif; ?>
                    </div>

                    <div class="sp-quality__card-body">
                        <h3 class="sp-quality__card-title"><?php echo esc_html( $card['title'] ); ?></h3>
                        <p class="sp-quality__card-desc"><?php echo esc_html( $card['desc'] ); ?></p>
                    </div>

                </article>
                <?php endforeach; ?>

            </div>

        </div>

    </div>
</section>
