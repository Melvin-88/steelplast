<?php
/**
 * The template for displaying the footer
 *
 * @package SteelPlast
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="content-wrapper">
            <div class="site-info">
                <?php
                printf(
                    esc_html__( '© %1$s %2$s. All rights reserved.', 'steelplast' ),
                    date_i18n( 'Y' ),
                    get_bloginfo( 'name', 'display' )
                );
                ?>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>

</body>
</html>