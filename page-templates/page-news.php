<?php
/**
 * Template Name: News Archive
 *
 * All news / articles listing with category filter and pagination.
 *
 * @package SteelPlast
 */

get_header();

$paged        = max( 1, get_query_var( 'paged' ) );
$current_cat  = isset( $_GET['cat'] ) ? absint( $_GET['cat'] ) : 0;

$query_args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'paged'          => $paged,
];

if ( $current_cat ) {
    $query_args['cat'] = $current_cat;
}

$news_query = new WP_Query( $query_args );

// Categories for filter tabs
$categories = get_categories( [
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
] );

$base_url = get_permalink();
?>

<main id="main" class="sp-main" role="main">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => get_the_title(),
        'height' => 440,
    ] );
    ?>

    <section class="sp-news-archive">
        <div class="content-wrapper">

            <?php if ( ! empty( $categories ) ) : ?>
                <nav class="sp-news-archive__filter" aria-label="<?php esc_attr_e( 'Filter by category', 'steelplast' ); ?>">
                    <span class="sp-news-archive__filter-label">
                        <?php echo esc_html( steelplast_t( 'steelplast/news/archive', 'filter_label', 'Categories' ) ); ?>
                    </span>
                    <div class="sp-news-archive__filter-tabs">
                        <a
                            href="<?php echo esc_url( $base_url ); ?>"
                            class="sp-news-archive__tab<?php echo ! $current_cat ? ' sp-news-archive__tab--active' : ''; ?>"
                        >
                            <?php echo esc_html( steelplast_t( 'steelplast/news/archive', 'filter_all', 'All articles' ) ); ?>
                        </a>
                        <?php foreach ( $categories as $cat ) : ?>
                            <a
                                href="<?php echo esc_url( add_query_arg( 'cat', $cat->term_id, $base_url ) ); ?>"
                                class="sp-news-archive__tab<?php echo ( $current_cat === $cat->term_id ) ? ' sp-news-archive__tab--active' : ''; ?>"
                            >
                                <?php echo esc_html( $cat->name ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </nav>
            <?php endif; ?>

            <?php if ( $news_query->have_posts() ) : ?>

                <div class="sp-news-archive__grid">
                    <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
                        <?php get_template_part( 'template-parts/post-card', null, [ 'post_id' => get_the_ID() ] ); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <?php if ( $news_query->max_num_pages > 1 ) : ?>
                    <nav class="sp-news-archive__pagination" aria-label="<?php esc_attr_e( 'Posts navigation', 'steelplast' ); ?>">
                        <?php
                        echo paginate_links( [
                            'base'      => add_query_arg( 'paged', '%#%', $base_url ),
                            'format'    => '',
                            'total'     => $news_query->max_num_pages,
                            'current'   => $paged,
                            'prev_text' => '←',
                            'next_text' => '→',
                        ] );
                        ?>
                    </nav>
                <?php endif; ?>

            <?php else : ?>

                <p class="sp-news-archive__empty">
                    <?php echo esc_html( steelplast_t( 'steelplast/news/archive', 'archive_empty', 'No articles yet. Check back soon.' ) ); ?>
                </p>

            <?php endif; ?>

        </div>
    </section>

    <?php get_template_part( 'template-parts/section-contact' ); ?>

</main>

<?php get_footer();
