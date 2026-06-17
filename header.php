<?php
/**
 * The header for our theme
 *
 * @package SteelPlast
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#primary"><?php esc_html_e( 'Skip to content', 'steelplast' ); ?></a>

<header id="masthead" class="site-header" role="banner">
    <div class="header-inner">

        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-logo" aria-label="<?php bloginfo( 'name' ); ?> — <?php esc_attr_e( 'головна сторінка', 'steelplast' ); ?>">
            <img
                src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-header.svg' ); ?>"
                alt="<?php bloginfo( 'name' ); ?>"
                width="160"
                height="40"
                loading="eager"
            >
        </a>

        <!-- Primary navigation -->
        <nav id="site-navigation" class="header-nav" aria-label="<?php esc_attr_e( 'Головне меню', 'steelplast' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'container'      => false,
                'menu_class'     => 'header-nav__list',
                'walker'         => new SteelPlast_Nav_Walker(),
                'fallback_cb'    => 'steelplast_fallback_nav',
            ) );
            ?>
        </nav>

        <!-- Actions: Контакти / мова / кнопка -->
        <div class="header-actions">
            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contacts' ) ) ); ?>" class="header-contacts">
                <?php esc_html_e( 'Контакти', 'steelplast' ); ?>
            </a>

            <?php steelplast_language_switcher(); ?>

            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contacts' ) ) ); ?>" class="btn-contact">
                <?php esc_html_e( "Зв'язатись", 'steelplast' ); ?>
            </a>
        </div>

        <!-- Burger (mobile) -->
        <button class="header-burger" aria-expanded="false" aria-controls="site-navigation" aria-label="<?php esc_attr_e( 'Відкрити меню', 'steelplast' ); ?>">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>
</header>

<div id="page" class="site">
