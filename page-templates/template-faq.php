<?php
/**
 * Template Name: FAQ
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();

$intro_title = steelplast_t( 'steelplast/faq/intro', 'title', "Welcome to our FAQ section!\nWe want working with Steel Plast to be transparent and comfortable for you." );
$intro_desc  = steelplast_t( 'steelplast/faq/intro', 'desc', "We've gathered answers to the questions our clients ask most often about our products, orders and delivery.\nIf you can't find what you're looking for, our team is always ready to help you personally." );

$faq_items = [
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_1', 'What does Steel Plast manufacture?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_1', "We specialize in the full-cycle production of technical plastic components through injection molding, along with the design and manufacturing of custom injection molds. Our product range covers plastic and metal-plastic parts, packaging, enclosures and components for the automotive, household appliance, electrical, interior and construction industries." ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_2', 'Can you manufacture a custom mold for our project?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_2', 'Yes. We design and manufacture custom injection molds in-house — from 3D modeling and CNC machining to trial shots and fine-tuning — matching the specifications and volumes of your project.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_3', 'What is the minimum order quantity?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_3', 'The minimum order quantity depends on the part\'s complexity, mold cost and material. We evaluate every request individually — send us your drawings and we will offer the most efficient production scenario.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_4', 'What clamping force range do your injection molding machines cover?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_4', 'Our injection molding machines cover a clamping force range from 25 to 800 tons, allowing us to produce parts of different sizes — from small precision components to larger housings and structural parts.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_5', 'Which materials can you work with?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_5', 'We work with a wide range of technical plastics (granules), including polypropylene, ABS, polyamide (PA6, PA66), polycarbonate and their reinforced or filled grades, selected to match your part\'s requirements.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_6', 'Do you offer overmolding or insert molding?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_6', 'Yes, we offer overmolding and insert molding, including 2K (two-component) injection, allowing us to combine materials or embed metal inserts directly during the injection cycle.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_7', 'How do you ensure dimensional stability and low warpage?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_7', 'Every mold and process is validated through trial shots and cavity-by-cavity measurement. We control shrinkage and warpage at the design stage and monitor dimensional stability throughout the entire injection cycle.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_8', 'What is the average mold lifespan?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_8', 'Mold lifespan (mold resource) depends on the tool steel, part geometry and production volume, and is confirmed for each project individually — we design every mold for reliable, repeatable output across its full service life.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_9', 'What quality control stages does production go through?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_9', 'Every batch passes through several quality control stages — incoming material inspection, in-process monitoring during the injection cycle, and final dimensional and visual inspection before shipment, in line with ISO 9001.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_10', 'How can I place an order?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_10', 'Send us your drawings or reference samples via the form on our Contacts page or by email — our team will review the details and get back to you with production options within 2 hours.' ),
    ],
];
?>

<main id="primary" class="sp-main page-faq">

    <?php
    get_template_part( 'template-parts/page-hero', null, [
        'title'  => get_the_title(),
        'height' => 300,
    ] );
    ?>

    <section class="sp-faq sp-section" aria-labelledby="faq-intro-title">
        <div class="content-wrapper">

            <div class="sp-faq__intro">
                <h2 id="faq-intro-title" class="sp-faq__intro-title sp-section-title">
                    <?php echo wp_kses( nl2br( esc_html( $intro_title ) ), [ 'br' => [] ] ); ?>
                </h2>
                <p class="sp-faq__intro-desc sp-section-desc">
                    <?php echo wp_kses( nl2br( esc_html( $intro_desc ) ), [ 'br' => [] ] ); ?>
                </p>
            </div>

            <div class="sp-faq__grid">
                <?php foreach ( $faq_items as $index => $item ) :
                    $n         = $index + 1;
                    $is_open   = ( 0 === $index );
                    $answer_id  = 'faq-answer-' . $n;
                    $question_id = 'faq-question-' . $n;
                    ?>
                    <div class="sp-faq__item<?php echo $is_open ? ' is-open' : ''; ?>" data-faq-item>
                        <h3 class="sp-faq__question">
                            <button
                                type="button"
                                class="sp-faq__toggle"
                                id="<?php echo esc_attr( $question_id ); ?>"
                                aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
                                aria-controls="<?php echo esc_attr( $answer_id ); ?>"
                            >
                                <span class="sp-faq__toggle-text"><?php echo esc_html( $item['q'] ); ?></span>
                                <span class="sp-faq__icon" aria-hidden="true"></span>
                            </button>
                        </h3>
                        <div
                            class="sp-faq__answer-wrap"
                            id="<?php echo esc_attr( $answer_id ); ?>"
                            role="region"
                            aria-labelledby="<?php echo esc_attr( $question_id ); ?>"
                            aria-hidden="<?php echo $is_open ? 'false' : 'true'; ?>"
                        >
                            <div class="sp-faq__answer-inner">
                                <p class="sp-faq__answer-text"><?php echo esc_html( $item['a'] ); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <?php get_template_part( 'template-parts/section-contact' ); ?>

</main>

<?php
get_footer();
