<?php
/*
Template Name: GMO - Welcome to Zúme
*/
?>

<!doctype html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NLZSL6S');</script>
    <!-- End Google Tag Manager -->
    <script type="text/javascript" defer="defer" src="https://extend.vimeocdn.com/ga/75461893.js"></script>

    <meta charset="utf-8">

    <!-- Force IE to use the latest rendering engine available -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta class="foundation-mq">

    <!-- If Site Icon isn't set in customizer -->
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <!-- Icons & Favicons -->
        <link rel="icon" href="<?php echo esc_attr( get_theme_file_uri( 'favicon.png' ) ); ?>">
        <link href="<?php echo esc_attr( get_theme_file_uri( 'assets/images/apple-icon-touch.png' ) ); ?>" rel="apple-touch-icon" />
        <!--[if IE]>
        <link rel="shortcut icon" href="<?php echo esc_attr( get_theme_file_uri( 'favicon.ico' ) ); ?>">
        <![endif]-->
        <meta name="msapplication-TileColor" content="#f01d4f">
        <meta name="msapplication-TileImage" content="<?php echo esc_attr( get_theme_file_uri( 'assets/images/win8-tile-icon.png' ) ); ?>">
        <meta name="theme-color" content="#121212">
    <?php } ?>

    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>

</head>

<!-- Uncomment this line if using the Off-Canvas Menu -->

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NLZSL6S"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="off-canvas-wrapper">

    <?php get_template_part( 'parts/content', 'offcanvas' ); ?>

    <div class="off-canvas-content" data-off-canvas-content>

        <header class="header" role="banner">

            <!-- This navs will be applied to the topbar, above all content
                 To see additional nav styles, visit the /parts directory -->
            <?php get_template_part( 'parts/nav', 'offcanvas-topbar' ); ?>

        </header> <!-- end .header -->


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
            pieces.html(`<span><img src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/spinner.svg' ?>" width="30px;"></span>`)

            jQuery.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: '<?php echo esc_url_raw( rest_url() ) ?>zume/v4/piece/' + id,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', '<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ) ?>' );
                },
            })
                .done(function (data) {
                    pieces.html(data)
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

                    <h1 class="primary-color-text center padding-bottom-2">
                        <strong><?php esc_html_e( "Welcome to God’s Family!", 'zume' ) ?></strong>
                    </h1>

                    <div class="center">
                        <p><?php esc_html_e( "Watch this important video explaining the 4 relationships of your new life.", 'zume' ) ?></p>
                    </div>
                    <div class="center small-video">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/k6AYmR2nPSs?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>

                    <br>

                    <p class="center"><strong>Bookmark this page as a future resource!</strong></p><br>

                    <p>The sections below, will teach you what it means to be a follower (disciple) of Jesus.</p>

                    <ul class="accordion" data-accordion>

                        <li class="accordion-item" data-accordion-item>

                            <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "What is a follower of Jesus?", 'zume' ) ?></h3></a>

                            <div class="accordion-content" data-tab-content>
                                <div class="inset">
                                    <p>
                                        <strong><a data-value="20730" class="gmo open-modal"><?php esc_html_e( "God Uses Ordinary People", 'zume' ) ?></a></strong><br>
                                        <?php esc_html_e( "You'll see how God uses ordinary people doing simple things to make a big impact.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <strong><a data-value="20731" class="gmo open-modal"><?php esc_html_e( "Simple Definition of Disciple and Church", 'zume' ) ?></a></strong><br>
                                        <?php esc_html_e( "Discover the essence of being a disciple, making a disciple, and what is the church.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a data-value="20744" class="gmo open-modal"><strong><?php esc_html_e( "Vision Casting the Greatest Blessing", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "Learn a simple pattern of making not just one follower of Jesus but entire spiritual families who multiply for generations to come.", 'zume' ) ?>
                                    </p>

                                </div>
                            </div>
                        </li>

                        <li class="accordion-item" data-accordion-item>

                            <a href="#" class="accordion-title" style="text-decoration: none !important;"><h3><?php esc_html_e( "What are the activities of a follower of Jesus?", 'zume' ) ?></h3></a>

                            <div class="accordion-content" data-tab-content>
                                <p>
                                    <strong><a data-value="20737" class="gmo open-modal"><?php esc_html_e( "Consumer vs Producer Lifestyle", 'zume' ) ?></a></strong><br>
                                    <?php esc_html_e( "You'll discover the four main ways God makes everyday followers more like Jesus.", 'zume' ) ?>
                                </p>

                                <h4><?php esc_html_e( "Prayer", 'zume' ) ?></h4>
                                <div class="inset">
                                    <p>
                                        <strong><a data-value="20732" class="gmo open-modal"><?php esc_html_e( "Spiritual Breathing is Hearing and Obeying God", 'zume' ) ?></a></strong><br>
                                        <?php esc_html_e( "Being a disciple means we hear from God and we obey God.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <strong><a data-value="20738" class="gmo open-modal"><?php esc_html_e( "How to Spend an Hour in Prayer", 'zume' ) ?></a></strong><br>
                                        <?php esc_html_e( "See how easy it is to spend an hour in prayer.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a  data-value="20749" class="gmo open-modal"><strong><?php esc_html_e( "The BLESS Prayer Pattern", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "Practice a simple mnemonic to remind you of ways to pray for others.", 'zume' ) ?>
                                    </p>
                                </div>


                                <h4><?php esc_html_e( "Bible Reading", 'zume' ) ?></h4>
                                <div class="inset">
                                    <p>
                                        <a data-value="20733" class="gmo open-modal"><strong><?php esc_html_e( "SOAPS Bible Reading", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "A tool for daily Bible study that helps you understand, obey, and share God’s Word.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a  data-value="20751" class="gmo open-modal"><strong><?php esc_html_e( "Faithfulness is Better Than Knowledge", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "It's important what disciples know — but it's much more important what they DO with what they know.", 'zume' ) ?>
                                    </p>
                                </div>


                                <h4><?php esc_html_e( "Community", 'zume' ) ?></h4>
                                <div class="inset">
                                    <p>
                                        <a data-value="20752" class="gmo open-modal"><strong><?php esc_html_e( "3/3 Group Meeting Pattern", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "A 3/3 Group is a way for followers of Jesus to meet, pray, learn, grow, fellowship and practice obeying and sharing what they've learned. In this way, a 3/3 Group is not just a small group but a Simple Church.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a data-value="20735" class="gmo open-modal"><strong><?php esc_html_e( "Accountability Groups", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "A tool for two or three people of the same gender to meet weekly and encourage each other in areas that are going well and reveal areas that need correction.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a data-value="20758" class="gmo open-modal"><strong><?php esc_html_e( "Always Part of Two Churches", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "Learn how to obey Jesus' commands by going AND staying.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a data-value="20747" class="gmo open-modal"><strong><?php esc_html_e( "The Lord’s Supper and How To Lead It", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "It’s a simple way to celebrate our intimate connection and ongoing relationship with Jesus. Learn a simple way to celebrate.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a data-value="20742" class="gmo open-modal"><strong><?php esc_html_e( "Baptism and How To Do It", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the Father and of the Son and of the Holy Spirit…” Learn how to put this into practice.", 'zume' ) ?>
                                    </p>
                                </div>


                                <h4><?php esc_html_e( "Sacrifice and Suffering", 'zume' ) ?></h4>
                                <div class="inset">
                                    <p>
                                        <a data-value="20740" class="gmo open-modal"><strong><?php esc_html_e( "The Kingdom Economy", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "Learn how God's economy is different from the world's. God invests more in those who are faithful with what they've already been given.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a data-value="20746" class="gmo open-modal"><strong><?php esc_html_e( "Eyes to See Where The Kingdom Isn’t", 'zume' ) ?></strong></a><br>
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
                                            <a data-value="20745" class="gmo open-modal"><strong><?php esc_html_e( "Duckling Discipleship – Leading Immediately", 'zume' ) ?></strong></a><br>
                                            <?php esc_html_e( "Learn what ducklings have to do with disciple-making", 'zume' ) ?>
                                        </p>
                                        <p>
                                            <a data-value="20753" class="gmo open-modal"><strong><?php esc_html_e( "Training Cycle for Maturing Disciples", 'zume' ) ?></strong></a><br>
                                            <?php esc_html_e( "Learn the training cycle and consider how it applies to disciple making.", 'zume' ) ?>
                                        </p>
                                        <p>
                                            <a data-value="20756" class="gmo open-modal"><strong><?php esc_html_e( "Expect Non-Sequential Growth", 'zume' ) ?></strong></a><br>
                                            <?php esc_html_e( "See how disciple making doesn't have to be linear. Multiple things can happen at the same time.", 'zume' ) ?>
                                        </p>
                                        <p>
                                            <a data-value="20757" class="gmo open-modal"><strong><?php esc_html_e( "Pace of Multiplication Matters", 'zume' ) ?></strong></a><br>
                                            <?php esc_html_e( "Multiplying matters and multiplying quickly matters even more. See why pace matters.", 'zume' ) ?>
                                        </p>
                                    </div>

                                    <h4><?php esc_html_e( "Speaking to people YOU KNOW about Jesus", 'zume' ) ?></h4>
                                    <div class="inset">
                                        <p>
                                            <a data-value="20739" class="gmo open-modal"><strong><?php esc_html_e( "Relational Stewardship – List of 100", 'zume' ) ?></strong></a><br>
                                            <?php esc_html_e( "A tool designed to help you be a good steward of your relationships.", 'zume' ) ?>
                                        </p>
                                        <p>
                                            <a data-value="20741" class="gmo open-modal"><strong><?php esc_html_e( "The Gospel and How to Share It", 'zume' ) ?></strong></a><br>
                                            <?php esc_html_e( "Learn a way to share God’s Good News from the beginning of humanity all the way to the end of this age.", 'zume' ) ?>
                                        </p>
                                        <p>
                                            <a data-value="20743" class="gmo open-modal"><strong><?php esc_html_e( "Prepare Your 3-Minute Testimony", 'zume' ) ?></strong></a><br>
                                            <?php esc_html_e( "Learn how to share your testimony in three minutes by sharing how Jesus has impacted your life.", 'zume' ) ?>
                                        </p>

                                    </div>

                                    <h4><?php esc_html_e( "Speaking to people YOU DON'T KNOW about Jesus", 'zume' ) ?></h4>
                                    <div class="inset">
                                        <p>
                                            <a data-value="20750" class="gmo open-modal"><strong><?php esc_html_e( "A Person of Peace and How To Find One", 'zume' ) ?></strong></a><br>
                                            <?php esc_html_e( "Learn who a person of peace might be and how to know when you've found one.", 'zume' ) ?>
                                        </p>
                                        <p>
                                            <a data-value="20748" class="gmo open-modal"><strong><?php esc_html_e( "Prayer Walking and How To Do It", 'zume' ) ?></strong></a><br>
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
                                        <a  data-value="20761" class="gmo open-modal"><strong><?php esc_html_e( "Peer Mentoring Groups", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "This is a group that consists of people who are leading and starting 3/3 Groups. It also follows a 3/3 format and is a powerful way to assess the spiritual health of God’s work in your area.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a  data-value="20759" class="gmo open-modal"><strong><?php esc_html_e( "Coaching Checklist", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "A powerful tool you can use to quickly assess your own strengths and vulnerabilities when it comes to making disciples who multiply.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a data-value="20755" class="gmo open-modal"><strong><?php esc_html_e( "Leadership Cells", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "A Leadership Cell is a way someone who feels called to lead can develop their leadership by practicing serving.", 'zume' ) ?>
                                    </p>
                                    <p>
                                        <a data-value="20760" class="gmo open-modal"><strong><?php esc_html_e( "Leadership in Networks", 'zume' ) ?></strong></a><br>
                                        <?php esc_html_e( "Learn how multiplying churches stay connected and live life together as an extended, spiritual family.", 'zume' ) ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div> <!-- cell -->
                <div class="cell padding-vertical-1 center" style="border-top:1px solid lightgrey">
                    Zúme Training is a proud partner of the Godlife community.<br>
                    <img src="<?php echo esc_url( get_stylesheet_directory_uri() ) ?>/assets/images/godlife-logo-small.png"  alt="God life logo" />
                </div>
            </div> <!-- center grid-->

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
                <p class="center"><br><a href="/training" class="button secondary-button large">See the Zúme Training Course</a> </p>
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
