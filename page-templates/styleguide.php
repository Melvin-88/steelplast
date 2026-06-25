<?php
/**
 * Template Name: Style Guide
 * Template Post Type: page
 */

if ( ! current_user_can( 'edit_posts' ) ) {
    wp_die( esc_html__( 'Access denied. You must be logged in as an editor.', 'steelplast' ) );
}

get_header();
?>

<main class="sp-main sp-sg">
    <div class="sp-sg__header">
        <div class="content-wrapper">
            <p class="sp-sg__badge">Design System</p>
            <h1 class="sp-sg__title">SteelPlast Style Guide</h1>
            <p class="sp-sg__subtitle">Colors · Typography · Buttons · Components</p>
        </div>
    </div>

    <div class="content-wrapper sp-sg__body">

        <!-- ========== COLORS ========== -->
        <section class="sp-sg__section" id="sg-colors">
            <h2 class="sp-sg__section-title">Colors</h2>
            <div class="sp-sg__colors">

                <div class="sp-sg__swatch">
                    <div class="sp-sg__swatch-block" style="background:#6de2f7;"></div>
                    <div class="sp-sg__swatch-info">
                        <span class="sp-sg__swatch-name">Accent</span>
                        <span class="sp-sg__swatch-hex">#6de2f7</span>
                        <span class="sp-sg__swatch-var">$color-accent</span>
                    </div>
                </div>

                <div class="sp-sg__swatch">
                    <div class="sp-sg__swatch-block" style="background:#f6f6f6;"></div>
                    <div class="sp-sg__swatch-info">
                        <span class="sp-sg__swatch-name">Pure White</span>
                        <span class="sp-sg__swatch-hex">#f6f6f6</span>
                        <span class="sp-sg__swatch-var">$color-pure-white</span>
                    </div>
                </div>

                <div class="sp-sg__swatch">
                    <div class="sp-sg__swatch-block" style="background:#8a8a8a;"></div>
                    <div class="sp-sg__swatch-info">
                        <span class="sp-sg__swatch-name">Dark Grey</span>
                        <span class="sp-sg__swatch-hex">#8a8a8a</span>
                        <span class="sp-sg__swatch-var">$color-dark-grey</span>
                    </div>
                </div>

                <div class="sp-sg__swatch">
                    <div class="sp-sg__swatch-block" style="background:#96c2e8;"></div>
                    <div class="sp-sg__swatch-info">
                        <span class="sp-sg__swatch-name">Soft Blue</span>
                        <span class="sp-sg__swatch-hex">#96c2e8</span>
                        <span class="sp-sg__swatch-var">$color-soft-blue</span>
                    </div>
                </div>

                <div class="sp-sg__swatch">
                    <div class="sp-sg__swatch-block" style="background:#6687ae;"></div>
                    <div class="sp-sg__swatch-info">
                        <span class="sp-sg__swatch-name">Steel Blue</span>
                        <span class="sp-sg__swatch-hex">#6687ae</span>
                        <span class="sp-sg__swatch-var">$color-steel-blue</span>
                    </div>
                </div>

                <div class="sp-sg__swatch">
                    <div class="sp-sg__swatch-block" style="background:#2d4266;"></div>
                    <div class="sp-sg__swatch-info">
                        <span class="sp-sg__swatch-name">Deep Blue</span>
                        <span class="sp-sg__swatch-hex">#2d4266</span>
                        <span class="sp-sg__swatch-var">$color-deep-blue</span>
                    </div>
                </div>

                <div class="sp-sg__swatch">
                    <div class="sp-sg__swatch-block" style="background:#121c2e;"></div>
                    <div class="sp-sg__swatch-info">
                        <span class="sp-sg__swatch-name">Dark Navy</span>
                        <span class="sp-sg__swatch-hex">#121c2e</span>
                        <span class="sp-sg__swatch-var">$color-dark-navy</span>
                    </div>
                </div>

                <div class="sp-sg__swatch">
                    <div class="sp-sg__swatch-block" style="background:#0f0f0f; border: 1px solid #333;"></div>
                    <div class="sp-sg__swatch-info">
                        <span class="sp-sg__swatch-name">Background</span>
                        <span class="sp-sg__swatch-hex">#0f0f0f</span>
                        <span class="sp-sg__swatch-var">$color-background</span>
                    </div>
                </div>

                <div class="sp-sg__swatch">
                    <div class="sp-sg__swatch-block" style="background:#090a0c; border: 1px solid #333;"></div>
                    <div class="sp-sg__swatch-info">
                        <span class="sp-sg__swatch-name">Black</span>
                        <span class="sp-sg__swatch-hex">#090a0c</span>
                        <span class="sp-sg__swatch-var">$color-black</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- ========== TYPOGRAPHY ========== -->
        <section class="sp-sg__section" id="sg-typography">
            <h2 class="sp-sg__section-title">Typography</h2>

            <div class="sp-sg__type-row">
                <div class="sp-sg__type-meta">
                    <span>H1</span>
                    <span>80px / 700 / 72px lh</span>
                </div>
                <div class="sp-sg__type-sample sp-sg__type-sample--clip">
                    <h1 style="font-size:80px;line-height:72px;font-weight:700;margin:0;">Steel</h1>
                </div>
            </div>

            <div class="sp-sg__type-row">
                <div class="sp-sg__type-meta">
                    <span>H2</span>
                    <span>64px / 700 / 64px lh</span>
                </div>
                <div class="sp-sg__type-sample sp-sg__type-sample--clip">
                    <h2 style="font-size:64px;line-height:64px;font-weight:700;margin:0;">Section Title</h2>
                </div>
            </div>

            <div class="sp-sg__type-row">
                <div class="sp-sg__type-meta">
                    <span>H3</span>
                    <span>40px / 600 / 40px lh</span>
                </div>
                <div class="sp-sg__type-sample">
                    <h3 style="font-size:40px;line-height:40px;font-weight:600;margin:0;">Card Heading</h3>
                </div>
            </div>

            <div class="sp-sg__type-row">
                <div class="sp-sg__type-meta">
                    <span>H4</span>
                    <span>36px / 600 / 40px lh</span>
                </div>
                <div class="sp-sg__type-sample">
                    <h4 style="font-size:36px;line-height:40px;font-weight:600;margin:0;">Sub-heading</h4>
                </div>
            </div>

            <div class="sp-sg__type-row">
                <div class="sp-sg__type-meta">
                    <span>H5</span>
                    <span>24px / 600 / 28px lh</span>
                </div>
                <div class="sp-sg__type-sample">
                    <h5 style="font-size:24px;line-height:28px;font-weight:600;margin:0;">Small Heading</h5>
                </div>
            </div>

            <div class="sp-sg__type-row">
                <div class="sp-sg__type-meta">
                    <span>Body Up</span>
                    <span>16px / 400 / 32px lh</span>
                </div>
                <div class="sp-sg__type-sample">
                    <p class="body-up" style="margin:0;">We manufacture precision injection molds and plastic components for industrial clients worldwide.</p>
                </div>
            </div>

            <div class="sp-sg__type-row">
                <div class="sp-sg__type-meta">
                    <span>Body</span>
                    <span>16px / 400 / 20px lh</span>
                </div>
                <div class="sp-sg__type-sample">
                    <p class="body" style="margin:0;">We manufacture precision injection molds and plastic components for industrial clients worldwide.</p>
                </div>
            </div>

            <div class="sp-sg__type-row">
                <div class="sp-sg__type-meta">
                    <span>Caption</span>
                    <span>12px / 400 / 12px lh</span>
                </div>
                <div class="sp-sg__type-sample">
                    <p class="caption" style="margin:0;">Navigation link · Label · Tag text</p>
                </div>
            </div>

            <div class="sp-sg__type-row">
                <div class="sp-sg__type-meta">
                    <span>Section Label</span>
                    <span>.sp-section-label</span>
                </div>
                <div class="sp-sg__type-sample">
                    <div class="sp-section-label sp-section-label--dark-bg">
                        <span class="sp-section-label__index">[01]</span>
                        <span>Our Services</span>
                    </div>
                </div>
            </div>

        </section>

        <!-- ========== SECTION TITLES ========== -->
        <section class="sp-sg__section" id="sg-section-titles">
            <h2 class="sp-sg__section-title">Section Title System</h2>

            <div class="sp-sg__preview sp-sg__preview--dark">
                <p class="sp-sg__preview-label">Dark background</p>
                <div class="sp-section-label sp-section-label--dark-bg" style="margin-bottom:16px;">
                    <span class="sp-section-label__index">[01]</span>
                    <span>Services</span>
                </div>
                <h2 class="sp-section-title" style="margin-bottom:16px;">Our Capabilities</h2>
                <p class="sp-section-desc" style="max-width:480px;">We design and manufacture high-precision injection molds for automotive, medical, and consumer industries.</p>
            </div>

            <div class="sp-sg__preview sp-sg__preview--light">
                <p class="sp-sg__preview-label" style="color:#090a0c;">Light background</p>
                <div class="sp-section-label sp-section-label--light-bg" style="margin-bottom:16px;">
                    <span class="sp-section-label__index">[02]</span>
                    <span>Quality</span>
                </div>
                <h2 class="sp-section-title" style="color:#090a0c;margin-bottom:16px;">Our Standards</h2>
                <p class="sp-section-desc" style="color:#090a0c;max-width:480px;">Every mold we produce goes through rigorous quality checks at every stage of production.</p>
            </div>

        </section>

        <!-- ========== BUTTONS ========== -->
        <section class="sp-sg__section" id="sg-buttons">
            <h2 class="sp-sg__section-title">Buttons — Dark Background</h2>

            <div class="sp-sg__preview sp-sg__preview--dark">
                <p class="sp-sg__preview-label">Primary</p>
                <div class="sp-sg__button-row">
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--primary sp-btn--sm">
                            <span class="sp-btn__icon" aria-hidden="true">↳</span> Small
                        </a>
                        <span class="sp-sg__button-name">--primary --sm</span>
                    </div>
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--primary sp-btn--md">
                            <span class="sp-btn__icon" aria-hidden="true">↳</span> Medium
                        </a>
                        <span class="sp-sg__button-name">--primary --md (default)</span>
                    </div>
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--primary sp-btn--lg">
                            <span>Large</span>
                            <span class="sp-btn__icon" aria-hidden="true">↵</span>
                        </a>
                        <span class="sp-sg__button-name">--primary --lg</span>
                    </div>
                    <div class="sp-sg__button-item" style="width:280px;">
                        <a href="#" class="sp-btn sp-btn--primary sp-btn--lg sp-btn--full">
                            <span>Full width</span>
                            <span class="sp-btn__icon" aria-hidden="true">↵</span>
                        </a>
                        <span class="sp-sg__button-name">--primary --lg --full</span>
                    </div>
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--primary sp-btn--md" aria-disabled="true" style="opacity:0.45;pointer-events:none;">Disabled</a>
                        <span class="sp-sg__button-name">disabled state</span>
                    </div>
                </div>

                <p class="sp-sg__preview-label" style="margin-top:32px;">Outline</p>
                <div class="sp-sg__button-row">
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--outline sp-btn--sm">Get in touch</a>
                        <span class="sp-sg__button-name">--outline --sm (header)</span>
                    </div>
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--outline sp-btn--md">Learn more</a>
                        <span class="sp-sg__button-name">--outline --md</span>
                    </div>
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--outline sp-btn--lg">Contact</a>
                        <span class="sp-sg__button-name">--outline --lg</span>
                    </div>
                </div>

                <p class="sp-sg__preview-label" style="margin-top:32px;">Ghost</p>
                <div class="sp-sg__button-row">
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--ghost sp-btn--sm">
                            <span class="sp-btn__icon" aria-hidden="true">↳</span> Small
                        </a>
                        <span class="sp-sg__button-name">--ghost --sm</span>
                    </div>
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--ghost sp-btn--md">
                            <span class="sp-btn__icon" aria-hidden="true">↳</span> Order service
                        </a>
                        <span class="sp-sg__button-name">--ghost --md (services cards)</span>
                    </div>
                    <div class="sp-sg__button-item" style="width:280px;">
                        <a href="#" class="sp-btn sp-btn--ghost sp-btn--md sp-btn--full">
                            <span class="sp-btn__icon" aria-hidden="true">↳</span> Order service
                        </a>
                        <span class="sp-sg__button-name">--ghost --md --full</span>
                    </div>
                </div>
            </div>

            <h2 class="sp-sg__section-title" style="margin-top:16px;">Buttons — Light Background</h2>

            <div class="sp-sg__preview sp-sg__preview--light">
                <p class="sp-sg__preview-label" style="color:#090a0c;">Primary on light</p>
                <div class="sp-sg__button-row">
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--primary sp-btn--sm sp-btn--on-light">
                            <span class="sp-btn__icon" aria-hidden="true">↳</span> Small
                        </a>
                        <span class="sp-sg__button-name" style="color:#666;">--primary --sm --on-light</span>
                    </div>
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--primary sp-btn--md sp-btn--on-light">
                            <span class="sp-btn__icon" aria-hidden="true">↳</span> Learn more
                        </a>
                        <span class="sp-sg__button-name" style="color:#666;">--primary --md --on-light (quality)</span>
                    </div>
                    <div class="sp-sg__button-item" style="width:280px;">
                        <button type="button" class="sp-btn sp-btn--primary sp-btn--lg sp-btn--full sp-btn--on-light">
                            <span>Send request</span>
                            <span class="sp-btn__icon" aria-hidden="true">↵</span>
                        </button>
                        <span class="sp-sg__button-name" style="color:#666;">--primary --lg --full --on-light (form)</span>
                    </div>
                </div>

                <p class="sp-sg__preview-label" style="color:#090a0c;margin-top:32px;">Outline on light</p>
                <div class="sp-sg__button-row">
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--outline sp-btn--sm sp-btn--on-light">Contact</a>
                        <span class="sp-sg__button-name" style="color:#666;">--outline --sm --on-light</span>
                    </div>
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--outline sp-btn--md sp-btn--on-light">Learn more</a>
                        <span class="sp-sg__button-name" style="color:#666;">--outline --md --on-light</span>
                    </div>
                </div>

                <p class="sp-sg__preview-label" style="color:#090a0c;margin-top:32px;">Ghost on light</p>
                <div class="sp-sg__button-row">
                    <div class="sp-sg__button-item">
                        <a href="#" class="sp-btn sp-btn--ghost sp-btn--md sp-btn--on-light">
                            <span class="sp-btn__icon" aria-hidden="true">↳</span> Order service
                        </a>
                        <span class="sp-sg__button-name" style="color:#666;">--ghost --md --on-light</span>
                    </div>
                </div>
            </div>

        </section>

        <!-- ========== SPACING ========== -->
        <section class="sp-sg__section" id="sg-spacing">
            <h2 class="sp-sg__section-title">Spacing Scale</h2>
            <div class="sp-sg__spacing-list">

                <?php
                $spacings = [
                    'xxs' => ['4px',  '$spacing-xxs'],
                    'xs'  => ['8px',  '$spacing-xs'],
                    'sm'  => ['12px', '$spacing-sm'],
                    'md'  => ['16px', '$spacing-md'],
                    'lg'  => ['24px', '$spacing-lg'],
                    'xl'  => ['64px', '$spacing-xl'],
                ];
                foreach ( $spacings as $key => $data ) :
                ?>
                <div class="sp-sg__spacing-row">
                    <span class="sp-sg__spacing-label"><?php echo esc_html( $data[1] ); ?></span>
                    <div class="sp-sg__spacing-bar" style="width:<?php echo esc_attr( $data[0] ); ?>;height:<?php echo esc_attr( $data[0] ); ?>;"></div>
                    <span class="sp-sg__spacing-value"><?php echo esc_html( $data[0] ); ?></span>
                </div>
                <?php endforeach; ?>

            </div>
        </section>

        <!-- ========== FOCUS / A11Y ========== -->
        <section class="sp-sg__section" id="sg-a11y">
            <h2 class="sp-sg__section-title">Focus &amp; Accessibility</h2>
            <div class="sp-sg__a11y-row">
                <a href="#" class="sp-sg__focus-demo">Tab to me — focus ring</a>
                <a href="#" class="sp-btn-contact sp-sg__focus-demo">Button focus</a>
            </div>
            <p class="sp-sg__note">Focus outline: 2px solid #6de2f7, offset 2px. Applied via <code>:focus-visible</code> only.</p>
        </section>

    </div><!-- /.sp-sg__body -->
</main>

<?php get_footer(); ?>
