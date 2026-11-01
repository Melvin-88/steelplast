<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package SteelPlast
 */
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php echo esc_html( steelplast_t( 'steelplast/global/not-found', 'title', 'Nothing found' ) ); ?></h1>
    </header>

    <div class="page-content">
        <?php if ( is_search() ) : ?>
            <p><?php echo esc_html( steelplast_t( 'steelplast/global/not-found', 'search_none', 'Sorry, nothing matched your search. Please try different keywords.' ) ); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php echo esc_html( steelplast_t( 'steelplast/global/not-found', 'none', "We can't find what you're looking for. Perhaps searching can help." ) ); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</section>