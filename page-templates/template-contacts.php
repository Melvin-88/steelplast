<?php
/**
 * Template Name: Contacts
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();
?>

<main id="primary" class="sp-main sp-contacts-page">
    <?php get_template_part( 'template-parts/section-contact', null, array( 'heading' => 'h1' ) ); ?>
</main>

<?php
get_footer();
