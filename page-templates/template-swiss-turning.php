<?php
/**
 * Template Name: Токарні верстати швейцарського типу
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();
?>

<main id="primary" class="site-main page-swiss-turning">
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
