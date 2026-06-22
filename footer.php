<?php
/**
 * The template for displaying the footer
 *
 * @package SteelPlast
 */
?>

<footer id="colophon" class="sp-footer" role="contentinfo">

    <div class="sp-footer__main sp-wrap">

        <!-- Col 1: Logo + description -->
        <div class="sp-footer__col sp-footer__col--brand">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sp-footer__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                <img
                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-footer.svg' ); ?>"
                    alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
                    width="180"
                    height="60"
                    loading="lazy"
                >
            </a>

            <div class="sp-footer__desc">
                <?php echo esc_html( steelplast_translate( 'footer_description', 'Ми спеціалізуємося на постачанні високоякісних компонентів для автомобільної, побутової, електротехнічної, інтер\'єрної та будівельної промисловості.' ) ); ?>
            </div>
        </div>

        <!-- Col 2: Nav menu -->
        <div class="sp-footer__col sp-footer__col--nav">
            <h3 class="sp-footer__col-title"><?php echo esc_html( steelplast_translate( 'footer_menu_title', 'МЕНЮ' ) ); ?></h3>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'container'      => 'nav',
                'container_class'=> 'sp-footer__nav',
                'menu_class'     => 'sp-footer__nav-list',
                'depth'          => 1,
                'fallback_cb'    => false,
            ) );
            ?>
        </div>

        <!-- Col 3: Links + language -->
        <div class="sp-footer__col sp-footer__col--connect">
            <h3 class="sp-footer__col-title"><?php echo esc_html( steelplast_translate( 'footer_social_title', 'СЛІДКУЙ ЗА НАМИ' ) ); ?></h3>
            <ul class="sp-footer__links">
                <li><a href="<?php echo esc_url( steelplast_translate( 'facebook_url', 'https://facebook.com' ) ); ?>" target="_blank" rel="noopener noreferrer">Facebook</a></li>
                <li><a href="<?php echo esc_url( steelplast_translate( 'linkedin_url', 'https://linkedin.com' ) ); ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a></li>
                <li><a href="<?php echo esc_url( steelplast_translate( 'instagram_url', 'https://instagram.com' ) ); ?>" target="_blank" rel="noopener noreferrer">Instagram</a></li>
            </ul>
            <div class="sp-footer__lang">
                <?php steelplast_language_switcher(); ?>
            </div>
        </div>

    </div>

    <div class="sp-footer__bottom">
        <div class="sp-wrap">
            <p class="sp-footer__copy">
                <?php
                printf(
                    esc_html__( '© %1$s %2$s. %3$s', 'steelplast' ),
                    esc_html( date_i18n( 'Y' ) ),
                    esc_html( get_bloginfo( 'name', 'display' ) ),
                    esc_html( steelplast_translate( 'footer_copyright', 'Всі права захищені.' ) )
                );
                ?>
            </p>
        </div>
        <div class="sp-footer__accent" aria-hidden="true"></div>
    </div>

</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
