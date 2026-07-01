<?php
/**
 * Quality page — [04] ISO certification, with downloadable certificate files.
 * Usage: get_template_part( 'template-parts/section-quality-certification' );
 *
 * @package SteelPlast
 */

// Same image/files for every language — always read from the default-language post
$image = steelplast_get_field_default_lang( 'quality_cert_image' );

$title         = steelplast_t( 'steelplast/quality/certification', 'title', 'Quality assurance: ISO certification' );
$download_label = steelplast_t( 'steelplast/quality/certification', 'download_label', 'Download file' );

$downloads = [];

$file_1 = steelplast_get_field_default_lang( 'quality_cert_file_1' );
if ( ! empty( $file_1['url'] ) ) {
    $downloads[] = [
        'label' => steelplast_t( 'steelplast/quality/certification', 'file_1_label', 'ISO 9001 Certificate' ),
        'url'   => $file_1['url'],
    ];
}
$file_2 = steelplast_get_field_default_lang( 'quality_cert_file_2' );
if ( ! empty( $file_2['url'] ) ) {
    $downloads[] = [
        'label' => steelplast_t( 'steelplast/quality/certification', 'file_2_label', 'Technical specifications and quality passports' ),
        'url'   => $file_2['url'],
    ];
}
?>

<section class="sp-quality-cert" aria-labelledby="quality-cert-title">
    <div class="content-wrapper sp-quality-cert__inner">

        <div class="sp-quality-cert__content">
            <p class="sp-section-label sp-section-label--dark-bg">
                <span class="sp-section-label__index" aria-hidden="true">[04]</span>
                <?php echo esc_html( steelplast_t( 'steelplast/quality/certification', 'label', 'ISO Certificates' ) ); ?>
            </p>
            <h2 id="quality-cert-title" class="sp-quality-cert__title sp-section-title">
                <?php echo esc_html( $title ); ?>
            </h2>
            <p class="sp-quality-cert__desc sp-section-desc">
                <?php echo esc_html( steelplast_t( 'steelplast/quality/certification', 'desc', 'We confirm our high standard of management and production safety not just in words, but in practice. Steel Plast regularly undergoes independent audits to ensure compliance with strict global regulations.' ) ); ?>
            </p>

            <?php if ( $downloads ) : ?>
                <div class="sp-quality-cert__downloads">
                    <?php foreach ( $downloads as $file ) : ?>
                        <div class="sp-quality-cert__download">
                            <span class="sp-quality-cert__download-label">
                                <span class="sp-quality-cert__download-icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 1.5h5.5L13 5v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2.5a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                                        <path d="M9.5 1.5V5H13" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span><?php echo esc_html( $file['label'] ); ?></span>
                            </span>
                            <a
                                class="sp-btn sp-btn--outline sp-btn--sm"
                                href="<?php echo esc_url( $file['url'] ); ?>"
                                download
                                target="_blank"
                                rel="noopener"
                                aria-label="<?php echo esc_attr( $download_label . ' — ' . $file['label'] ); ?>"
                            >
                                <?php echo esc_html( $download_label ); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( $image ) : ?>
            <div class="sp-quality-cert__image">
                <img
                    src="<?php echo esc_url( $image['url'] ); ?>"
                    width="<?php echo esc_attr( $image['width'] ); ?>"
                    height="<?php echo esc_attr( $image['height'] ); ?>"
                    alt="<?php echo esc_attr( ! empty( $image['alt'] ) ? $image['alt'] : $title ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            </div>
        <?php endif; ?>

    </div>
</section>
