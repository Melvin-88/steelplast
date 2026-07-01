<?php
/**
 * The template for displaying all single posts
 *
 * @package SteelPlast
 */

get_header();

while ( have_posts() ) :
    the_post();

    $post_id      = get_the_ID();
    $reading_time = steelplast_reading_time( $post_id );
    $tags         = get_the_tags( $post_id );
    $news_url     = home_url( '/news/' );

    // Dedicated, high-resolution cover image for the large header area — separate from
    // the featured image (used for the news card thumbnail) to avoid stretching a small
    // image and losing quality. Same image for every language.
    $cover_image = steelplast_get_field_default_lang( 'post_cover_image', $post_id );
    $has_cover   = ! empty( $cover_image ) || has_post_thumbnail( $post_id );
    ?>

    <main id="primary" class="sp-main sp-single-post">

        <div class="sp-single-post__cover<?php echo $has_cover ? '' : ' sp-single-post__cover--no-image'; ?>">
            <?php if ( $cover_image ) : ?>
                <img
                    class="sp-single-post__cover-img"
                    src="<?php echo esc_url( $cover_image['url'] ); ?>"
                    width="<?php echo esc_attr( $cover_image['width'] ); ?>"
                    height="<?php echo esc_attr( $cover_image['height'] ); ?>"
                    alt="<?php echo esc_attr( ! empty( $cover_image['alt'] ) ? $cover_image['alt'] : the_title_attribute( array( 'echo' => false ) ) ); ?>"
                    loading="eager"
                    decoding="async"
                    fetchpriority="high"
                >
                <div class="sp-single-post__cover-overlay" aria-hidden="true"></div>
            <?php elseif ( $has_cover ) : ?>
                <?php
                the_post_thumbnail(
                    'large',
                    array(
                        'class'         => 'sp-single-post__cover-img',
                        'alt'           => the_title_attribute( array( 'echo' => false ) ),
                        'loading'       => 'eager',
                        'decoding'      => 'async',
                        'fetchpriority' => 'high',
                    )
                );
                ?>
                <div class="sp-single-post__cover-overlay" aria-hidden="true"></div>
            <?php endif; ?>

            <div class="sp-single-post__cover-content content-wrapper">
                <h1 class="sp-single-post__title"><?php the_title(); ?></h1>
            </div>
        </div>

        <div class="sp-single-post__wrap-outer">
            <div class="content-wrapper sp-single-post__wrap">

                <div class="sp-single-post__header">
                    <a href="<?php echo esc_url( $news_url ); ?>" class="sp-single-post__back sp-btn sp-btn--ghost sp-btn--sm sp-btn--on-light">
                        <span class="sp-btn__icon" aria-hidden="true">&larr;</span>
                        <?php echo esc_html( steelplast_t( 'steelplast/news/single', 'back_label', 'Back to news' ) ); ?>
                    </a>
                </div>

                <div class="sp-single-post__layout">

                    <aside class="sp-single-post__sidebar">

                        <div class="sp-single-post__meta">
                            <span class="sp-single-post__meta-label">
                                <?php echo esc_html( steelplast_t( 'steelplast/news/single', 'date_label', 'Date created' ) ); ?>
                            </span>
                            <span class="sp-single-post__meta-value"><?php echo esc_html( get_the_date() ); ?></span>
                        </div>

                        <div class="sp-single-post__meta">
                            <span class="sp-single-post__meta-label">
                                <?php echo esc_html( steelplast_t( 'steelplast/news/single', 'read_time_label', 'Reading time' ) ); ?>
                            </span>
                            <span class="sp-single-post__meta-value">
                                <?php
                                printf(
                                    esc_html( steelplast_t( 'steelplast/news/single', 'read_time_value', '%d minutes' ) ),
                                    (int) $reading_time
                                );
                                ?>
                            </span>
                        </div>

                        <?php if ( $tags && ! is_wp_error( $tags ) ) : ?>
                            <div class="sp-single-post__meta">
                                <span class="sp-single-post__meta-label">
                                    <?php echo esc_html( steelplast_t( 'steelplast/news/single', 'tags_label', 'Tags' ) ); ?>
                                </span>
                                <span class="sp-single-post__meta-value">
                                    <?php
                                    $tag_links = array_map(
                                        function ( $tag ) {
                                            return sprintf(
                                                '<a href="%s" class="sp-single-post__tag">%s</a>',
                                                esc_url( get_tag_link( $tag ) ),
                                                esc_html( $tag->name )
                                            );
                                        },
                                        $tags
                                    );
                                    echo wp_kses_post( implode( ', ', $tag_links ) );
                                    ?>
                                </span>
                            </div>
                        <?php endif; ?>

                    </aside>

                    <div class="sp-single-post__content entry-content">
                        <?php the_content(); ?>
                    </div>

                </div>

            </div>
        </div>

        <?php get_template_part( 'template-parts/section-contact' ); ?>

    </main>

    <?php
endwhile;

get_footer();
