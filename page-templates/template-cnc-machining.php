<?php
/**
 * Template Name: Механічна обробка металу на верстатах з ЧПУ
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();
?>

<main id="primary" class="site-main page-cnc-machining">
    <div class="content-wrapper">
        <?php while ( have_posts() ) : the_post(); ?>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();
