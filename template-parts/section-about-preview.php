<?php
/**
 * Template part: About Preview section (Home page)
 *
 * @package SteelPlast
 */

$tag     = steelplast_t( 'steelplast/home/about-preview', 'tag',         '[02] About us' );
$title   = steelplast_t( 'steelplast/home/about-preview', 'title',       'WE ENGINEER<br>PRECISION' );
$desc    = steelplast_t( 'steelplast/home/about-preview', 'description', 'SteelPlast is a full-cycle manufacturer specialising in injection mold design, mold production, and high-volume plastic part manufacturing. Over 15 years of engineering precision.' );
$btn_txt = steelplast_t( 'steelplast/home/about-preview', 'button',      'Learn more about us' );

$about_page = get_page_by_path( 'about' );
$about_url  = $about_page ? get_permalink( $about_page->ID ) : home_url( '/about/' );

// Images are the same for every language — always read from the
// default-language post (see steelplast_get_field_default_lang()).
$img1_id = steelplast_get_field_default_lang( 'sp_about_image_1' );
$img2_id = steelplast_get_field_default_lang( 'sp_about_image_2' );
$img3_id = steelplast_get_field_default_lang( 'sp_about_image_3' );

$img1_url = $img1_id ? wp_get_attachment_image_url( $img1_id, 'large' ) : '';
$img2_url = $img2_id ? wp_get_attachment_image_url( $img2_id, 'large' ) : '';
$img3_url = $img3_id ? wp_get_attachment_image_url( $img3_id, 'large' ) : '';
?>

<section class="sp-about-preview" aria-label="<?php esc_attr_e( 'About us preview', 'steelplast' ); ?>">
    <div class="sp-about-preview__inner content-wrapper">

        <!-- Left column -->
        <div class="sp-about-preview__content">
            <span class="sp-about-preview__tag"><?php echo esc_html( $tag ); ?></span>
            <h2 class="sp-section-title sp-about-preview__title"><?php echo wp_kses( $title, [ 'br' => [] ] ); ?></h2>
            <p class="sp-section-desc sp-about-preview__desc"><?php echo esc_html( $desc ); ?></p>
            <a href="<?php echo esc_url( $about_url ); ?>" class="sp-btn sp-btn--outline sp-about-preview__btn">
                <?php echo esc_html( $btn_txt ); ?>
            </a>
        </div>

        <!-- Right column: 3 chevron-clipped images (decorative) -->
        <div class="sp-about-preview__images" aria-hidden="true">

            <?php if ( $img1_url ) : ?>
            <!-- Image 1 — left-pointing chevron -->
            <div class="sp-about-preview__shape sp-about-preview__shape--1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 372 408" aria-hidden="true" focusable="false">
                    <defs>
                        <clipPath id="sp-about-clip-1" clipPathUnits="userSpaceOnUse">
                            <path d="M28.6286 154.92C-9.54286 176.74 -9.54286 231.26 28.6286 253.08L286.157 400.319C324.271 422.138 372 394.878 372 351.239V56.7613C372 13.1224 324.271 -14.138 286.157 7.68146L28.6286 154.92Z"/>
                        </clipPath>
                    </defs>
                    <image
                        href="<?php echo esc_url( $img1_url ); ?>"
                        x="0" y="0"
                        width="372" height="408"
                        preserveAspectRatio="xMidYMid slice"
                        clip-path="url(#sp-about-clip-1)"
                    />
                </svg>
            </div>
            <?php endif; ?>

            <?php if ( $img2_url ) : ?>
            <!-- Image 2 — right-pointing chevron -->
            <div class="sp-about-preview__shape sp-about-preview__shape--2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 374 413" aria-hidden="true" focusable="false">
                    <defs>
                        <clipPath id="sp-about-clip-2" clipPathUnits="userSpaceOnUse">
                            <path d="M345.217 156.819C383.594 178.906 383.594 234.094 345.217 256.181L86.3044 405.224C47.9852 427.311 0 399.717 0 355.543V57.4569C0 13.2832 47.9852 -14.3113 86.3044 7.7756L345.217 156.819Z"/>
                        </clipPath>
                    </defs>
                    <image
                        href="<?php echo esc_url( $img2_url ); ?>"
                        x="0" y="0"
                        width="374" height="413"
                        preserveAspectRatio="xMidYMid slice"
                        clip-path="url(#sp-about-clip-2)"
                    />
                </svg>
            </div>
            <?php endif; ?>

            <?php if ( $img3_url ) : ?>
            <!-- Image 3 — left-pointing chevron -->
            <div class="sp-about-preview__shape sp-about-preview__shape--3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 372 412" aria-hidden="true" focusable="false">
                    <defs>
                        <clipPath id="sp-about-clip-3" clipPathUnits="userSpaceOnUse">
                            <path d="M28.6286 156.439C-9.54286 178.472 -9.54286 233.528 28.6286 255.561L286.157 404.243C324.271 426.277 372 398.749 372 354.682V57.3178C372 13.251 324.271 -14.2766 286.157 7.75677L28.6286 156.439Z"/>
                        </clipPath>
                    </defs>
                    <image
                        href="<?php echo esc_url( $img3_url ); ?>"
                        x="0" y="0"
                        width="372" height="412"
                        preserveAspectRatio="xMidYMid slice"
                        clip-path="url(#sp-about-clip-3)"
                    />
                </svg>
            </div>
            <?php endif; ?>

        </div>

    </div>
</section>
