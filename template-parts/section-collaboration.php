<?php
/**
 * Collaboration section — how we work (4 steps).
 * Usage: get_template_part( 'template-parts/section-collaboration' );
 *
 * @package SteelPlast
 */
?>

<section class="sp-collab" aria-labelledby="sp-collab-title">
    <div class="content-wrapper">

        <div class="sp-collab__header">
            <p class="sp-section-label sp-section-label--dark-bg">
                <span class="sp-section-label__index" aria-hidden="true">[04]</span>
                <?php echo esc_html( steelplast_t( 'steelplast/collaboration/header', 'collab_label', 'Collaboration' ) ); ?>
            </p>
            <h2 class="sp-collab__title sp-section-title" id="sp-collab-title">
                <?php echo esc_html( steelplast_t( 'steelplast/collaboration/header', 'collab_title', "We don't just fulfill orders —\nwe solve problems" ) ); ?>
            </h2>
            <div class="sp-collab__desc">
                <p class="sp-section-desc"><?php echo esc_html( steelplast_t( 'steelplast/collaboration/header', 'collab_desc_1', 'We build partnerships on reliability, precision, and meeting deadlines. We work with businesses of all sizes, offering flexible manufacturing solutions — from individual parts to serial production.' ) ); ?></p>
                <p class="sp-section-desc"><?php echo esc_html( steelplast_t( 'steelplast/collaboration/header', 'collab_desc_2', 'We provide support at every stage: from processing the technical specification to quality control of finished products.' ) ); ?></p>
            </div>
        </div>

        <ol class="sp-collab__steps" aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/collaboration/steps', 'steps_aria', 'How we work' ) ); ?>">

            <li class="sp-collab__step sp-collab__step--1">
                <span class="sp-collab__step-tag">
                    <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_1_tag', 'Step 1' ) ); ?>
                </span>
                <div class="sp-collab__step-content">
                    <h3 class="sp-collab__step-title">
                        <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_1_title', 'Submit a request' ) ); ?>
                    </h3>
                    <p class="sp-collab__step-text">
                        <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_1_text', 'Send a request via the website or contact us directly. Briefly describe the task and requirements for the product.' ) ); ?>
                    </p>
                </div>
            </li>

            <li class="sp-collab__step sp-collab__step--2">
                <span class="sp-collab__step-tag">
                    <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_2_tag', 'Step 2' ) ); ?>
                </span>
                <div class="sp-collab__step-content">
                    <h3 class="sp-collab__step-title">
                        <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_2_title', 'Consultation and agreement' ) ); ?>
                    </h3>
                    <p class="sp-collab__step-text">
                        <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_2_text', 'We discuss technical details, materials, timelines and finalize the specification before production begins.' ) ); ?>
                    </p>
                </div>
            </li>

            <li class="sp-collab__step sp-collab__step--3">
                <span class="sp-collab__step-tag">
                    <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_3_tag', 'Step 3' ) ); ?>
                </span>
                <div class="sp-collab__step-content">
                    <h3 class="sp-collab__step-title">
                        <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_3_title', 'Production' ) ); ?>
                    </h3>
                    <p class="sp-collab__step-text">
                        <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_3_text', 'We manufacture products according to approved parameters with quality control at every stage.' ) ); ?>
                    </p>
                </div>
            </li>

            <li class="sp-collab__step sp-collab__step--4">
                <span class="sp-collab__step-tag">
                    <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_4_tag', 'Step 4' ) ); ?>
                </span>
                <div class="sp-collab__step-content">
                    <h3 class="sp-collab__step-title">
                        <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_4_title', 'Delivery of finished products' ) ); ?>
                    </h3>
                    <p class="sp-collab__step-text">
                        <?php echo esc_html( steelplast_t( 'steelplast/collaboration/steps', 'step_4_text', 'We organize packaging and delivery of finished products within agreed timelines.' ) ); ?>
                    </p>
                </div>
            </li>

        </ol>

    </div>
</section>
