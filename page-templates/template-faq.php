<?php
/**
 * Template Name: FAQ
 * Template Post Type: page
 *
 * @package SteelPlast
 */

get_header();

$intro_title = steelplast_t( 'steelplast/faq/intro', 'title', 'We want working with Steel Plast to be transparent and easy for you.' );
$intro_desc  = steelplast_t( 'steelplast/faq/intro', 'desc', "Here you'll find answers to the questions our clients ask most often: about our products, orders and delivery.\nIf you can't find what you need, our team is always ready to help you personally." );

$faq_items = [
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_1', 'What does Steel Plast manufacture?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_1', 'We specialize in CNC metal machining (turning and milling) and in producing engineering plastic parts by injection molding, as well as designing and manufacturing injection molds. We offer machined metal parts, plastic and metal-plastic products, packaging, housings and components for the automotive, industrial, electrical, medical, agricultural, aerospace and construction industries.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_2', 'Can you make an injection mold for our project?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_2', 'Yes. We design and build injection molds in-house: from 3D modeling and CNC machining to trial shots and fine-tuning, in line with your project\'s specifications and volumes.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_3', 'What is the minimum order quantity?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_3', 'The minimum order quantity depends on the complexity of the part, the cost of the mold and the material. We review every request individually. Send us your drawing, and we will propose the optimal production scenario.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_4', 'What clamping force range do your injection molding machines cover?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_4', 'Our injection molding machines cover a clamping force range of 35 to 400 metric tons, which allows us to produce parts of various sizes, from small precision components to large housings and structural parts.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_5', 'What materials do you work with?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_5', 'We work with a wide range of engineering plastics (pellets): polypropylene (PP), ABS, polyamide (PA6, PA66), polycarbonate (PC), polyethylenes (LDPE, HDPE), TPE / TPU / TPV, PS / HIPS, POM, SAN and PVC, as well as their reinforced and filled grades, selected to suit the requirements of your part.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_6', 'Do you offer two-component molding or insert molding?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_6', 'Yes, we offer two-component (2K) molding and insert molding, which allow us to combine materials or embed metal inserts directly during the molding cycle.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_7', 'How do you ensure dimensional stability and minimal warpage?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_7', 'Every mold and process is validated through trial shots and part-by-part measurement. We control shrinkage and warpage from the design stage and monitor dimensional stability throughout the entire molding cycle.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_8', 'What is the typical service life of a mold?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_8', 'Mold service life depends on the tool steel grade, part geometry and production volume, and is confirmed individually for each project. We design every mold for reliable, repeatable production throughout its entire service life.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_9', 'What quality control stages does production go through?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_9', 'Every batch goes through several inspection stages: incoming material inspection, in-process monitoring during the molding cycle, and final dimensional and visual inspection before shipment, in accordance with ISO 9001.' ),
    ],
    [
        'q' => steelplast_t( 'steelplast/faq/list', 'q_10', 'How do I place an order?' ),
        'a' => steelplast_t( 'steelplast/faq/list', 'a_10', 'Send us your drawings or samples via the form on our Contact page or by email. Our team will review the details and get back to you with production options within 2 hours. We accept files in STEP, PDF and x_t formats.' ),
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

            <div class="sp-faq__intro" data-sp-animate>
                <h2 id="faq-intro-title" class="sp-faq__intro-title sp-section-title">
                    <?php echo wp_kses( nl2br( esc_html( $intro_title ) ), [ 'br' => [] ] ); ?>
                </h2>
                <?php // white-space: pre-line keeps every newline, so nothing may sit between the tag and the text. ?>
                <p class="sp-faq__intro-desc sp-section-desc"><?php
                    echo wp_kses( nl2br( esc_html( $intro_desc ) ), [ 'br' => [] ] );
                ?></p>
            </div>

            <div class="sp-faq__grid" data-sp-animate-group>
                <?php foreach ( $faq_items as $index => $item ) :
                    $n         = $index + 1;
                    $is_open   = ( 0 === $index );
                    $answer_id  = 'faq-answer-' . $n;
                    $question_id = 'faq-question-' . $n;
                    ?>
                    <div class="sp-faq__item<?php echo $is_open ? ' is-open' : ''; ?>" data-faq-item data-sp-animate>
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
