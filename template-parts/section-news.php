<?php
/**
 * News section — homepage block (3 latest posts).
 * Usage: get_template_part( 'template-parts/section-news' );
 *
 * @package SteelPlast
 */

$news_query = new WP_Query( [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'no_found_rows'  => true,
] );

if ( ! $news_query->have_posts() ) {
    return;
}

$archive_url = home_url( '/news/' );
?>

<section class="sp-news" aria-labelledby="sp-news-title">
    <div class="content-wrapper">

        <div class="sp-news__header">
            <div class="sp-news__header-left">
                <p class="sp-section-label sp-section-label--light-bg">
                    <span class="sp-section-label__index" aria-hidden="true">[05]</span>
                    <?php echo esc_html( steelplast_t( 'steelplast/news/header', 'news_label', 'Articles & News' ) ); ?>
                </p>
                <h2 class="sp-news__title sp-section-title sp-section-title--dark" id="sp-news-title">
                    <?php echo esc_html( steelplast_t( 'steelplast/news/header', 'news_title', "Stay up to date\nwith company news" ) ); ?>
                </h2>
                <p class="sp-section-desc sp-section-desc--dark sp-news__desc">
                    <?php echo esc_html( steelplast_t( 'steelplast/news/header', 'news_desc', 'Follow company news, production updates, and completed projects.' ) ); ?>
                </p>
            </div>

            <a
                class="sp-btn sp-btn--primary sp-btn--md sp-news__all-btn"
                href="<?php echo esc_url( $archive_url ); ?>"
            >
                <span class="sp-btn__icon" aria-hidden="true">↳</span>
                <?php echo esc_html( steelplast_t( 'steelplast/news/header', 'news_all_btn', 'All articles' ) ); ?>
            </a>
        </div>

        <div class="sp-news__grid">
            <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
                <?php get_template_part( 'template-parts/post-card', null, [ 'post_id' => get_the_ID() ] ); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    </div>
</section>
