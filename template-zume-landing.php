<?php
/*
Template Name: Zúme - How to Follow Template
*/
$current_language = zume_current_language();
$alt_video = zume_alt_video( $current_language );

$values = get_post_custom( $post->ID );

?>

<?php get_header(); ?>

<style>
    #page-content a {
        text-decoration: underline !important;
    }
    .accordion-title {
        border: none !important;

    }
    #page-content h3 {
        padding-top: 0;
        padding-bottom: 0;
    }
    .accordion-title::before {
        top: inherit !important;
        margin-top: inherit !important;
        font-size: 3rem;
    }
    .accordion li {
        border-top: 1px #e6e6e6 solid;
    }
    .accordion-content {
        border: 0;
    }
    .flex-video, .responsive-embed {
        margin-bottom:0 !important;
    }
</style>
<script type="application/javascript">
    jQuery(document).ready(function() {
        let open_modal = function( id ) {
            let pieces = jQuery('#pieces-content')
            let lang = '<?php echo esc_attr( $current_language ) ?>'
            pieces.html(`<span><img src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/spinner.svg' ?>" width="30px;"></span>`)

            jQuery.ajax({
                type: "POST",
                data: JSON.stringify({id: id, lang: lang, strings: { wtv: '<?php esc_html_e( 'Watch This Video', 'zume' ) ?>', ay: '<?php esc_html_e( 'Ask Yourself', 'zume' ) ?>', d: '<?php esc_html_e( 'Download Free Guidebook', 'zume' ) ?>', lra: '<?php esc_html_e( "Listen and Read Along", 'zume' ) ?>' } }),
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                url: '<?php echo esc_url_raw( rest_url() ) ?>zume/v4/piece',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', '<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ) ?>' );
                },
            })
                .done(function (data) {
                    pieces.html(data)

                    let challenge_content = jQuery('#challenge-content').html()
                    jQuery('#invitation-footer').append(challenge_content)
                })

            let selection = jQuery('a[data-value='+id+']')
            let title = selection.html()
            let action = selection.data('tool')
            window.movement_logging({
                "action": action,
                "category": "studying",
                "data-language_code": "<?php echo esc_attr( $current_language ) ?>",
                "data-language_name": "<?php echo esc_html( zume_get_english_language_name( $current_language ) ) ?>",
                "data-session": "",
                "data-tool": action,
                "data-title": title,
                "data-group_size": "1",
                "data-note": "is studying"
            })

            jQuery('#pieces-wrapper').foundation('open')
        }
        jQuery('.open-modal').on('click', function() {
            open_modal( jQuery(this).data('value') )
        })
    })

</script>
<div id="page-content" class="padding-top-1">

    <div class="grid-x grid-padding-x">
        <div class="cell medium-2"></div>

        <div class="cell medium-8"><!-- center column -->

            <div class="grid-x grid-margin-x vertical-padding"> <!-- center grid -->

                <div class="cell">

                    <!-- Logo -->
                    <div class="cell center padding-bottom-1">
                        <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                        <img src="<?php the_post_thumbnail_url( 'full' ) ?>" style="max-height: 100px; max-width: 400px;" alt="logo" />
                        <?php endif; ?>
                    </div>

                    <!-- title -->
                    <h1 class="primary-color-text center padding-bottom-2">
                        <strong><?php
                            echo ( isset( $values['zume_landing_h1'][0] ) && ! empty( $values['zume_landing_h1'][0] ) ) ? esc_html( $values['zume_landing_h1'][0] ) : esc_html__( "How to Follow Jesus", 'zume' )  // phpcs:ignore ?></strong>
                    </h1>

                    <!-- pre video content -->
                    <div class="center">
                    <?php if ( isset( $values['zume_post_video_content'][0] ) && $values['zume_post_video_content'][0] === 'remove' ) : ?>

                    <?php elseif ( isset( $values['zume_post_video_content'][0] ) && empty( $values['zume_post_video_content'][0] ) ) : ?>
                        <p><?php esc_html_e( "Watch this important video explaining the 4 relationships of your new life.", 'zume' ) ?></p>
                    <?php else : ?>
                       <p><?php echo nl2br( esc_html( $values['zume_pre_video_content'][0] ) ) ?></p>
                    <?php endif; ?>
                    </div>

                    <!-- video -->
                    <?php if ( isset( $values['zume_landing_show_video'][0] ) && $values['zume_landing_show_video'][0] === 'yes' ) : ?>
                        <div class="center small-video">
                            <?php if ( $alt_video ) : ?>
                                <div class="alt-video-section">
                                    <video style="border: 1px solid lightgrey;" controls>
                                        <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/68.mp4' ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            <?php elseif ( ! empty( Zume_Course::get_video_by_key( '68' ) ) ) : ?>
                                <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '68' ) ) ?>" width="640" height="360"
                                        frameborder="0"
                                        allow="autoplay; fullscreen"
                                        webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                </iframe>
                            <?php else : ?>
                                <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '10' ) ) ?>#t=1m" width="640" height="360"
                                        frameborder="0"
                                        allow="autoplay; fullscreen"
                                        webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                </iframe>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <br>

                    <!-- post video content -->
                    <div class="center">
                            <?php if ( isset( $values['zume_post_video_content'][0] ) && $values['zume_post_video_content'][0] === 'remove' ) : ?>

                            <?php elseif ( isset( $values['zume_post_video_content'][0] ) && empty( $values['zume_post_video_content'][0] ) ) : ?>
                            <p class="center"><strong><?php esc_html_e( "Bookmark this page as a future resource!", 'zume' ) ?></strong></p><br>

                            <p><?php esc_html_e( "The sections below, will teach you what it means to be a follower (disciple) of Jesus.", 'zume' ) ?></p>
                        <?php else : ?>
                            <p><?php echo nl2br( esc_html( $values['zume_post_video_content'][0] ) ) ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- list -->
                    <?php zume_landing_list_template( $values['zume_landing_list_template'][0] ?? '' ) ?>

                </div> <!-- cell -->

            </div> <!-- center grid-->

            <?php /** Not logged in */ if ( ! is_user_logged_in() ) : ?>

                <div class="training margin-top-3 margin-bottom-3" id="challenge-content">
                    <div class="grid-x padding-2 landing-part" style="border-color:lightgrey;">
                        <div class="cell center"><h2><?php echo esc_html__( "You're missing out.", 'zume' ) ?> <?php echo esc_html__( "Register Now!", 'zume' ) ?></h2></div>
                        <div class="cell list-reasons">
                            <ul>
                                <li><?php echo esc_html__( "connect with a coach", 'zume' ) ?></li>
                                <li><?php echo esc_html__( "track your personal training progress", 'zume' ) ?></li>
                                <li><?php echo esc_html__( "access group planning tools", 'zume' ) ?></li>
                            </ul>
                        </div>
                        <div class="cell center">
                            <a href="<?php echo esc_url( zume_register_url() ) ?>" class="button large secondary-button" id="pieces-registration" style="padding-right:2em;padding-left:2em;"><?php echo esc_html__( "Register for Free", 'zume' ) ?></a><br>
                            <a href="<?php echo esc_url( zume_login_url() ) ?>" class="button clear" id="pieces-login"><?php echo esc_html__( "Login", 'zume' ) ?></a>
                        </div>
                        <div class="cell"><hr></div>
                        <div class="cell center">
                            <p style="max-width:500px; margin:1em auto;"><?php echo esc_html__( "Zúme uses an online training platform to equip participants in basic disciple-making and simple church planting multiplication principles, processes, and practices.", 'zume' ) ?></p>
                            <p><a class="button primary-button-hollow large" id="pieces-see-training" href="<?php echo esc_url( zume_training_url() ) ?>"><?php echo esc_html__( "See Entire Training", 'zume' ) ?></a></p>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div> <!-- center column -->

        <div class="cell medium-2"></div>

    </div>

</div> <!-- end #inner-content -->

<!-- Goals of the Zume Project -->
<div style="background-color:#323A68;">
    <div class="page-content">
        <div class="grid-x grid-margin-x grid-margin-y grid-padding vertical-padding" >
            <div class="medium-2 cell"></div>
            <div class="cell medium-8" style="color: white;">
                <h3 class="secondary center" style="color: white;"><?php esc_html_e( 'Zúme Training', 'zume' ) ?></h3>
                <p>
                    <?php esc_html_e( 'Zúme means yeast in Greek. In Matthew 13:33, Jesus is quoted as saying, "The Kingdom of Heaven is like a woman who took yeast and mixed it into a large amount of flour until it was all leavened." This illustrates how ordinary people, using ordinary resources, can have an extraordinary impact for the Kingdom of God. Zúme aims to equip and empower ordinary believers to saturate the globe with multiplying disciples in our generation.', 'zume' ) ?>
                </p>
                <p>
                    <?php esc_html_e( 'Zúme uses an online training platform to equip participants in basic disciple-making and simple church planting multiplication principles, processes, and practices.', 'zume' ) ?>
                </p>
                <p class="center"><br><a href="<?php echo esc_url( zume_training_url( $current_language ) ) ?>" class="button secondary-button large"><?php esc_html_e( "About Zúme Training", 'zume' ) ?></a> </p>
            </div>
            <div class="medium-2 cell"></div>
        </div>
    </div>
</div>

<div class="reveal large" id="pieces-wrapper" data-reveal data-v-offset="20">
    <div id="pieces-content"></div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">Close &times;</span>
    </button>
</div>

<?php get_footer(); ?>

<?php
/**
 * Template Variations
 */


function zume_landing_list_template( $list_template = 'full' ){
    switch ( $list_template ){
        case 'leading_yourself':
            ?>
            <ul class="accordion" data-accordion data-multi-expand="true">

                <li class="accordion-item is-active" data-accordion-item>
                    <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "Leading Yourself", 'zume' ) ?></h3></a>

                    <div class="accordion-content" data-tab-content>
                        <div class="inset">
                            <strong><?php esc_html_e( 'Principles', 'zume' ) ?></strong>
                            <p>
                                <strong><a data-value="20737" data-tool="6" id="consumer-vs-producer-lifestyle" class="open-modal"><?php esc_html_e( "Consumer vs Producer Lifestyle", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "You'll discover the four main ways God makes everyday followers more like Jesus.", 'zume' ) ?>
                            </p>
                            <strong><?php esc_html_e( 'Practices', 'zume' ) ?></strong>
                            <p>
                                <strong><a data-value="20733" data-tool="4" id="soaps-bible-reading" class="open-modal"><?php esc_html_e( "SOAPS Bible Reading", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "A tool for daily Bible study that helps you understand, obey, and share God’s Word.", 'zume' ) ?>
                            </p>
                        </div>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>
                    <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "Leading Your Group", 'zume' ) ?></h3></a>

                    <div class="accordion-content" data-tab-content>

                        <div class="inset">
                            <strong><?php esc_html_e( 'Principles', 'zume' ) ?></strong>
                            <p>
                                <strong><a data-value="20751" data-tool="20" id="faithfulness-is-better-than-knowledge" class="open-modal"><?php esc_html_e( "Faithfulness is Better Than Knowledge", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "It's important what disciples know — but it's much more important what they DO with what they know.", 'zume' ) ?>
                            </p>
                            <strong><?php esc_html_e( 'Practices', 'zume' ) ?></strong>
                            <p>
                                <strong><a data-value="20752" data-tool="21" id="3-3-group-meeting-pattern" class="open-modal"><?php esc_html_e( "3/3 Group Meeting Pattern", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "A 3/3 Group is a way for followers of Jesus to meet, pray, learn, grow, fellowship and practice obeying and sharing what they've learned. In this way, a 3/3 Group is not just a small group but a Simple Church.", 'zume' ) ?>
                            </p>

                        </div>

                    </div><!-- accordion-item -->
                </li>


                <li class="accordion-item " data-accordion-item>
                    <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "Leading Your Group Leaders", 'zume' ) ?></h3></a>

                    <div class="accordion-content" data-tab-content>
                        <div class="inset">
                            <strong><?php esc_html_e( 'Principles', 'zume' ) ?></strong>
                            <p>
                                <strong><a data-value="20753" data-tool="22" id="training-cycle-for-maturing-disciples" class="open-modal"><?php esc_html_e( "Training Cycle for Maturing Disciples", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Learn the training cycle and consider how it applies to disciple making.", 'zume' ) ?>
                            </p>
                            <strong><?php esc_html_e( 'Practices', 'zume' ) ?></strong>
                            <p>
                                <strong><a data-value="20759" data-tool="28" id="coaching-checklist" class="open-modal"><?php esc_html_e( "Coaching Checklist", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "A powerful tool you can use to quickly assess your own strengths and vulnerabilities when it comes to making disciples who multiply.", 'zume' ) ?>
                            </p>
                        </div>
                    </div>
                </li>


                <li class="accordion-item" data-accordion-item>
                    <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "Leading Your Community Leaders", 'zume' ) ?></h3></a>

                    <div class="accordion-content" data-tab-content>
                        <div class="inset">
                            <strong><?php esc_html_e( 'Principles', 'zume' ) ?></strong>
                            <p>
                                <strong><a data-value="20757" data-tool="25" id="pace-of-multiplication-matters" class="open-modal"><?php esc_html_e( "Pace of Multiplication Matters", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Multiplying matters and multiplying quickly matters even more. See why pace matters.", 'zume' ) ?>
                            </p>
                            <strong><?php esc_html_e( 'Practices', 'zume' ) ?></strong>
                            <p>
                                <strong><a data-value="20761" data-tool="30" id="peer-mentoring-group" class="open-modal"><?php esc_html_e( "Peer Mentoring Groups", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "This is a group that consists of people who are leading and starting 3/3 Groups. It also follows a 3/3 format and is a powerful way to assess the spiritual health of God’s work in your area.", 'zume' ) ?>
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
            <?php
            break;



        case 'full':
        default:
            ?>
            <ul class="accordion" data-accordion>

                <li class="accordion-item" data-accordion-item>

                    <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "What is a follower of Jesus?", 'zume' ) ?></h3></a>

                    <div class="accordion-content" data-tab-content>
                        <div class="inset">
                            <p>
                                <strong><a data-value="20730" data-tool="1" id="god-uses-ordinary-people" class="open-modal"><?php esc_html_e( "God Uses Ordinary People", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "You'll see how God uses ordinary people doing simple things to make a big impact.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20731" data-tool="2" id="simple-definition-of-disciple-and-church" class="open-modal"><?php esc_html_e( "Simple Definition of Disciple and Church", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Discover the essence of being a disciple, making a disciple, and what is the church.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20744" data-tool="13" id="vision-casting-the-greatest-blessing"  class="open-modal"><?php esc_html_e( "Vision Casting the Greatest Blessing", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Learn a simple pattern of making not just one follower of Jesus but entire spiritual families who multiply for generations to come.", 'zume' ) ?>
                            </p>

                        </div>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>

                    <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "What are the activities of a follower of Jesus?", 'zume' ) ?></h3></a>

                    <div class="accordion-content" data-tab-content>
                        <p>
                            <strong><a data-value="20737" data-tool="6" id="consumer-vs-producer-lifestyle" class="open-modal"><?php esc_html_e( "Consumer vs Producer Lifestyle", 'zume' ) ?></a></strong><br>
                            <?php esc_html_e( "You'll discover the four main ways God makes everyday followers more like Jesus.", 'zume' ) ?>
                        </p>

                        <h4><?php esc_html_e( "Prayer", 'zume' ) ?></h4>
                        <div class="inset">
                            <p>
                                <strong><a data-value="20732" data-tool="3" id="spiritual-breathing-is-hearing-and-obeying-god" class="open-modal"><?php esc_html_e( "Spiritual Breathing is Hearing and Obeying God", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Being a disciple means we hear from God and we obey God.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20738" data-tool="7" id="how-to-spend-an-hour-in-prayer"  class="open-modal"><?php esc_html_e( "How to Spend an Hour in Prayer", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "See how easy it is to spend an hour in prayer.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20749" data-tool="19" id="the-bless-prayer-pattern" class="open-modal"><?php esc_html_e( "The BLESS Prayer Pattern", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Practice a simple mnemonic to remind you of ways to pray for others.", 'zume' ) ?>
                            </p>
                        </div>


                        <h4><?php esc_html_e( "Bible Reading", 'zume' ) ?></h4>
                        <div class="inset">
                            <p>
                                <strong><a data-value="20733" data-tool="4" id="soaps-bible-reading" class="open-modal"><?php esc_html_e( "SOAPS Bible Reading", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "A tool for daily Bible study that helps you understand, obey, and share God’s Word.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a  data-value="20751" data-tool="20" id="faithfulness-is-better-than-knowledge" class="gmo open-modal"><?php esc_html_e( "Faithfulness is Better Than Knowledge", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "It's important what disciples know — but it's much more important what they DO with what they know.", 'zume' ) ?>
                            </p>
                        </div>


                        <h4><?php esc_html_e( "Community", 'zume' ) ?></h4>
                        <div class="inset">
                            <p>
                                <strong><a data-value="20752" data-tool="21" id="3-3-group-meeting-pattern" class="open-modal"><?php esc_html_e( "3/3 Group Meeting Pattern", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "A 3/3 Group is a way for followers of Jesus to meet, pray, learn, grow, fellowship and practice obeying and sharing what they've learned. In this way, a 3/3 Group is not just a small group but a Simple Church.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20735" data-tool="5" id="accountability-groups" class="open-modal"><?php esc_html_e( "Accountability Groups", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "A tool for two or three people of the same gender to meet weekly and encourage each other in areas that are going well and reveal areas that need correction.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20758" data-tool="26" id="always-part-of-two-churches" class="open-modal"><?php esc_html_e( "Always Part of Two Churches", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Learn how to obey Jesus' commands by going AND staying.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20747" data-tool="16" id="the-lords-supper-and-how-to-lead-it" class="open-modal"><?php esc_html_e( "The Lord’s Supper and How To Lead It", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "It’s a simple way to celebrate our intimate connection and ongoing relationship with Jesus. Learn a simple way to celebrate.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20742" data-tool="11" id="baptism-and-how-to-do-it" class="open-modal"><?php esc_html_e( "Baptism and How To Do It", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the Father and of the Son and of the Holy Spirit…” Learn how to put this into practice.", 'zume' ) ?>
                            </p>
                        </div>


                        <h4><?php esc_html_e( "Sacrifice and Suffering", 'zume' ) ?></h4>
                        <div class="inset">
                            <p>
                                <strong><a data-value="20740" data-tool="9" id="the-kingdom-economy" class="open-modal"><?php esc_html_e( "The Kingdom Economy", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Learn how God's economy is different from the world's. God invests more in those who are faithful with what they've already been given.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20746" data-tool="15" id="eyes-to-see-where-the-kingdom-isnt" class="open-modal"><?php esc_html_e( "Eyes to See Where The Kingdom Isn’t", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Begin to see where God’s Kingdom isn’t. These are usually the places where God wants to work the most.", 'zume' ) ?>
                            </p>

                        </div>

                    </div><!-- accordion-item -->
                </li>


                <li class="accordion-item" data-accordion-item>

                    <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "How do I obey Jesus and help others become followers with me?", 'zume' ) ?></h3></a>

                    <div class="accordion-content" data-tab-content>
                        <p>
                            <em><?php esc_html_e( 'Then Jesus came to them and said, "All authority in heaven and on earth has been given to me. Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit, and teaching them to obey everything I have commanded you. And surely I am with you always, to the very end of the age."', 'zume' ) ?></em>
                            (<a href="https://www.biblegateway.com/passage/?search=Matthew+28%3A18-20&version=NIV"><?php esc_html_e( "Matthew 28:18-20", 'zume' ) ?></a>)
                        </p>
                        <div class="inset">

                            <h4><?php esc_html_e( "Teaching others to obey and follow Jesus with you", 'zume' ) ?> <br></h4>
                            <div class="inset">

                                <p>
                                    <strong><a data-value="20745" data-tool="14" id="duckling-discipleship-leading-immediately" class="open-modal"><?php esc_html_e( "Duckling Discipleship – Leading Immediately", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "Learn what ducklings have to do with disciple-making", 'zume' ) ?>
                                </p>
                                <p>
                                    <strong><a data-value="20753" data-tool="22" id="training-cycle-for-maturing-disciples" class="open-modal"><?php esc_html_e( "Training Cycle for Maturing Disciples", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "Learn the training cycle and consider how it applies to disciple making.", 'zume' ) ?>
                                </p>
                                <p>
                                    <strong><a data-value="20756" data-tool="24" id="expect-non-sequential-growth" class="open-modal"><?php esc_html_e( "Expect Non-Sequential Growth", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "See how disciple making doesn't have to be linear. Multiple things can happen at the same time.", 'zume' ) ?>
                                </p>
                                <p>
                                    <strong><a data-value="20757" data-tool="25" id="pace-of-multiplication-matters" class="open-modal"><?php esc_html_e( "Pace of Multiplication Matters", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "Multiplying matters and multiplying quickly matters even more. See why pace matters.", 'zume' ) ?>
                                </p>
                            </div>

                            <h4><?php esc_html_e( "Speaking to people YOU KNOW about Jesus", 'zume' ) ?></h4>
                            <div class="inset">
                                <p>
                                    <strong><a data-value="20739" data-tool="8" id="relational-stewardship-list-of-100" class="open-modal"><?php esc_html_e( "Relational Stewardship – List of 100", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "A tool designed to help you be a good steward of your relationships.", 'zume' ) ?>
                                </p>
                                <p>
                                    <strong><a data-value="20741" data-tool="10" id="the-gospel-and-how-to-share-it" class="open-modal"><?php esc_html_e( "The Gospel and How to Share It", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "Learn a way to share God’s Good News from the beginning of humanity all the way to the end of this age.", 'zume' ) ?>
                                </p>
                                <p>
                                    <strong><a data-value="20743" data-tool="12" id="prepare-your-3-minute-testimony" class="open-modal"><?php esc_html_e( "Prepare Your 3-Minute Testimony", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "Learn how to share your testimony in three minutes by sharing how Jesus has impacted your life.", 'zume' ) ?>
                                </p>

                            </div>

                            <h4><?php esc_html_e( "Speaking to people YOU DON'T KNOW about Jesus", 'zume' ) ?></h4>
                            <div class="inset">
                                <p>
                                    <strong><a data-value="20750" data-tool="18" id="a-person-of-peace-and-how-to-find-one" class="open-modal"><?php esc_html_e( "A Person of Peace and How To Find One", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "Learn who a person of peace might be and how to know when you've found one.", 'zume' ) ?>
                                </p>
                                <p>
                                    <strong><a  data-value="20748" data-tool="17" id="prayer-walking-and-how-to-do-it" class="open-modal"><?php esc_html_e( "Prayer Walking and How To Do It", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "It’s a simple way to obey God’s command to pray for others. And it's just what it sounds like — praying to God while walking around!", 'zume' ) ?>
                                </p>
                            </div>

                        </div>
                    </div>
                </li>


                <li class="accordion-item" data-accordion-item>

                    <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "What if many friends, family, and others start following Jesus with me?", 'zume' ) ?></h3></a>

                    <div class="accordion-content" data-tab-content>
                        <div class="inset">
                            <p>
                                <strong><a data-value="20761" data-tool="30" id="peer-mentoring-group" class="open-modal"><?php esc_html_e( "Peer Mentoring Groups", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "This is a group that consists of people who are leading and starting 3/3 Groups. It also follows a 3/3 format and is a powerful way to assess the spiritual health of God’s work in your area.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20759" data-tool="28" id="coaching-checklist" class="open-modal"><?php esc_html_e( "Coaching Checklist", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "A powerful tool you can use to quickly assess your own strengths and vulnerabilities when it comes to making disciples who multiply.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20755" data-tool="55" id="leadership-cells" class="open-modal"><?php esc_html_e( "Leadership Cells", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "A Leadership Cell is a way someone who feels called to lead can develop their leadership by practicing serving.", 'zume' ) ?>
                            </p>
                            <p>
                                <strong><a data-value="20760" data-tool="29" id="leadership-in-networks" class="open-modal"><?php esc_html_e( "Leadership in Networks", 'zume' ) ?></a></strong><br>
                                <?php esc_html_e( "Learn how multiplying churches stay connected and live life together as an extended, spiritual family.", 'zume' ) ?>
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
            <?php
            break;
    }
}
