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

<a class="sp-skip" href="#primary"><?php echo esc_html( steelplast_t( 'steelplast/global/a11y', 'skip_link', 'Skip to content' ) ); ?></a>

<header id="masthead" class="sp-header" role="banner">
    <div class="sp-header__inner sp-wrap">

        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sp-header__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' — ' . steelplast_t( 'steelplast/global/a11y', 'home_link', 'home page' ) ); ?>">
            <picture>
                <source
                    media="(max-width: 768px)"
                    srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-mark.svg' ); ?>"
                    width="40"
                    height="40"
                >
                <img
                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-header.svg' ); ?>"
                    alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
                    width="160"
                    height="40"
                    loading="eager"
                >
            </picture>
        </a>

        <!-- Primary navigation -->
        <nav id="site-navigation" class="sp-header__nav" aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/global/a11y', 'primary_menu', 'Main menu' ) ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'container'      => false,
                'menu_class'     => 'sp-nav__list',
                'walker'         => new SteelPlast_Nav_Walker(),
                'fallback_cb'    => 'steelplast_fallback_nav',
            ) );
            ?>
        </nav>

        <!-- Actions: contacts / language / CTA -->
        <div class="sp-header__actions">
            <a href="<?php echo esc_url( steelplast_page_url( 'контакти' ) ); ?>" class="sp-header__contacts<?php echo is_page_template( 'page-templates/page-contacts.php' ) ? ' current-menu-item' : ''; ?>">
                <?php echo esc_html( steelplast_t( 'steelplast/global/header', 'contacts', 'Contact' ) ); ?>
            </a>

            <?php steelplast_language_switcher(); ?>

            <a href="<?php echo esc_url( steelplast_page_url( 'контакти' ) ); ?>" class="sp-btn sp-btn--outline sp-btn--sm" data-sp-modal-open="quick-contact">
                <?php echo esc_html( steelplast_t( 'steelplast/global/header', 'cta', 'Get in touch' ) ); ?>
            </a>
        </div>

        <!-- Burger (mobile) -->
        <button type="button" class="sp-header__burger" aria-expanded="false" aria-controls="site-navigation" aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/global/a11y', 'open_menu', 'Open menu' ) ); ?>">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>
</header>

<div id="page" class="sp-site">
