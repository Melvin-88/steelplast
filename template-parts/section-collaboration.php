<?php
/**
 * Collaboration / staircase-steps section — reused across pages with a variable step count.
 * Usage: get_template_part( 'template-parts/section-collaboration', null, $args );
 * Args (all optional — default to the home page "Collaboration" content, 4 steps):
 *   'label_index' (string) e.g. '[04]'
 *   'label'       (string) section label text
 *   'title'       (string) H2 title — use "\n" for a manual line break
 *   'desc'        (array)  paragraphs shown under the title
 *   'steps'       (array)  each item: [ 'tag' => ..., 'title' => ..., 'text' => ... ]
 *
 * @package SteelPlast
 */

$label_index = $args['label_index'] ?? '[04]';
$label       = $args['label']       ?? steelplast_t( 'steelplast/collaboration/header', 'collab_label', 'Collaboration' );
$title       = $args['title']       ?? steelplast_t( 'steelplast/collaboration/header', 'collab_title', 'LET\'S BUILD SOMETHING THAT WORKS.' );
$desc        = $args['desc']        ?? [
    steelplast_t( 'steelplast/collaboration/header', 'collab_desc_1', 'You come to us with an idea, a drawing or a specific production task — we help you find the way to a finished product. We support the project, launch production and scale it up.' ),
];
$steps       = $args['steps'] ?? [
    [
        'tag'   => steelplast_t( 'steelplast/collaboration/steps', 'step_1_tag', 'Stage 1' ),
        'title' => steelplast_t( 'steelplast/collaboration/steps', 'step_1_title', 'YOUR REQUEST' ),
        'text'  => steelplast_t( 'steelplast/collaboration/steps', 'step_1_text', 'Submit a request via the website or contact us directly. Briefly describe the task and your product requirements.' ),
    ],
    [
        'tag'   => steelplast_t( 'steelplast/collaboration/steps', 'step_2_tag', 'Stage 2' ),
        'title' => steelplast_t( 'steelplast/collaboration/steps', 'step_2_title', 'A SOLUTION FOR YOUR PROJECT' ),
        'text'  => steelplast_t( 'steelplast/collaboration/steps', 'step_2_text', 'We discuss the technical specification before production begins.' ),
    ],
    [
        'tag'   => steelplast_t( 'steelplast/collaboration/steps', 'step_3_tag', 'Stage 3' ),
        'title' => steelplast_t( 'steelplast/collaboration/steps', 'step_3_title', 'PRODUCTION LAUNCH' ),
        'text'  => steelplast_t( 'steelplast/collaboration/steps', 'step_3_text', 'We manufacture products to the approved requirements, with quality control at every stage.' ),
    ],
    [
        'tag'   => steelplast_t( 'steelplast/collaboration/steps', 'step_4_tag', 'Stage 4' ),
        'title' => steelplast_t( 'steelplast/collaboration/steps', 'step_4_title', 'FINISHED PRODUCT' ),
        'text'  => steelplast_t( 'steelplast/collaboration/steps', 'step_4_text', 'We arrange packaging and delivery of finished products within the agreed timeframe.' ),
    ],
];

$steps_count = count( $steps );
$steps_class = 'sp-collab__steps' . ( 4 !== $steps_count ? ' sp-collab__steps--count-' . $steps_count : '' );
?>

<section class="sp-collab" aria-labelledby="sp-collab-title">
    <div class="content-wrapper">

        <div class="sp-collab__header" data-sp-animate>
            <p class="sp-section-label sp-section-label--dark-bg">
                <span class="sp-section-label__index" aria-hidden="true"><?php echo esc_html( $label_index ); ?></span>
                <?php echo esc_html( $label ); ?>
            </p>
            <?php // white-space: pre-line keeps every newline, so nothing may sit between the tag and the text. ?>
            <h2 class="sp-collab__title sp-section-title" id="sp-collab-title"><?php
                echo esc_html( $title );
            ?></h2>
            <div class="sp-collab__desc">
                <?php foreach ( $desc as $paragraph ) : ?>
                    <p class="sp-section-desc"><?php echo esc_html( $paragraph ); ?></p>
                <?php endforeach; ?>
            </div>
        </div>

        <ol class="<?php echo esc_attr( $steps_class ); ?>" aria-label="<?php echo esc_attr( steelplast_t( 'steelplast/collaboration/steps', 'steps_aria', 'How we work' ) ); ?>">

            <?php foreach ( $steps as $i => $step ) : $n = $i + 1; ?>
                <li class="sp-collab__step sp-collab__step--<?php echo esc_attr( $n ); ?>">
                    <span class="sp-collab__step-tag">
                        <?php echo esc_html( $step['tag'] ); ?>
                    </span>
                    <div class="sp-collab__step-content">
                        <h3 class="sp-collab__step-title">
                            <?php echo esc_html( $step['title'] ); ?>
                        </h3>
                        <p class="sp-collab__step-text">
                            <?php echo esc_html( $step['text'] ); ?>
                        </p>
                    </div>
                </li>
            <?php endforeach; ?>

        </ol>

    </div>
</section>
