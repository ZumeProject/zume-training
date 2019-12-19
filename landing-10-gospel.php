<?php
/*
Template Name: 10 - Gospel
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 3;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 10;
        set_query_var( 'tool_number', absint( $tool_number ) );

        $args = Zume_V4_Pieces::vars( $tool_number );
        $image_url = $args['image_url'] ?? '';
        ?>

        <!-- Wrappers -->
        <div id="content" class="grid-x grid-padding-x training"><div  id="inner-content" class="cell">

                <!------------------------------------------------------------------------------------------------>
                <!-- Title section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                    <div class="medium-2 small-1 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="medium-8 small-10 cell center">

                        <img src="<?php echo esc_url( $image_url ) ?>" alt="<?php the_title(); ?>"  style="height:225px;" />

                        <h1>
                            <strong><?php the_title(); ?></strong>
                        </h1>
                        <span class="sub-caption">
                            <a onclick="open_session(<?php echo esc_attr( $session_number ); ?>)"><?php echo esc_html__( 'This concept can be found in session', 'zume' ) ?> <?php echo esc_html( $session_number ) ?></a>
                        </span>
                    </div>

                    <div class="medium-2 small-1 cell"></div><!-- Side spacer -->
                </div>


                <!------------------------------------------------------------------------------------------------>
                <!-- Unique page content section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x ">
                    <div class="large-2 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="large-8 small-12 cell" id="training-content">
                        <section>

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "There are many ways to share God’s story.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "The best way will depend on the person you’re sharing with and their view of the world and their life experiences. God uses hearts willing to share to work on hearts willing to hear.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "One way to share God’s Story is by explaining what’s happened from God’s Creation to His Judgement at the end of this age.", 'zume' ) ?></p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 10 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_10' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '10' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div> <!-- grid-x -->


                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "Here is God’s Story of Good News -", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "In the beginning, God made the whole world and everything in it. He created the FIRST MAN and the FIRST WOMAN. He placed them in a beautiful garden. He made them PART OF HIS FAMILY and had a CLOSE RELATIONSHIP with them. He created them to LIVE FOREVER. There was no such thing as death.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Even in this perfect place, man rebelled against God and brought SIN and SUFFERING into the world. God BANISHED man from the garden. The relationship between man and God was BROKEN. Now man would have to face DEATH.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Over many hundreds of years, God kept sending MESSENGERS into the world. They reminded man of his sin but also told him of God’s FAITHFULNESS and PROMISE to send a SAVIOR into the world. The Savior would RESTORE the close relationship between God and Man. The Savior would RESCUE man from death. The Savior would give ETERNAL LIFE and be with man forever. ", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "God loves us so much that when the time was right, He sent His Son into the world to be that Savior. Jesus was God’s Son. He was born into the world through a virgin. He lived a perfect life. He never sinned. Jesus taught people about God. He performed many miracles showing His great power. He cast out many demons. He healed many people. He made the blind see. He made the deaf hear. He made the lame walk. Jesus even raised the dead. Many religious leaders were THREATENED and JEALOUS of Jesus. They wanted Him killed. Since He never sinned, Jesus did not have to die. But He CHOSE to die as a SACRIFICE for all of us. His painful death covered up the sins of mankind. After this, Jesus was buried in a tomb.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "God saw the SACRIFICE Jesus made and accepted it. God showed His acceptance by raising Jesus from the dead on the third day. God said that if we BELIEVE and RECEIVE Jesus’ sacrifice for our sins -- If we TURN AWAY from our sins and FOLLOW Jesus, God CLEANS US from all sin and WELCOMES us back into His family. God sends the HOLY SPIRIT to live inside us and make us able to follow Jesus.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "We are BAPTIZED in water to show and seal this restored relationship. As a symbol of death we are buried beneath the water. As a symbol of new life we are raised out of the water to follow Jesus. When Jesus rose from the dead, He spent 40 days on earth. Jesus taught His followers to go everywhere and tell the good news of His salvation to everyone around the world.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Jesus said - Go and MAKE DISCIPLES of all nations, BAPTIZING them in the name of the Father, Son and Holy Spirit; and TEACHING them to obey all I have commanded. I will be with you always - even to the end of this age.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Jesus was then TAKEN UP before their eyes into heaven. One day, Jesus will COME AGAIN in the same way He left. He will PUNISH FOREVER those who did not love and obey Him. He will RECEIVE and REWARD FOREVER those who did love and obey Him. We will LIVE FOREVER with Him in a New Heaven and on a New Earth.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "I BELIEVED and RECEIVED the sacrifice Jesus made for my sins. He has made me clean and restored me as part of God’s family. He loves me, and I love Him and will live with Him forever in His kingdom. God loves you and wants you to receive this gift, as well. Would you like to do that right now?", 'zume' ) ?></p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol>
                                        <li><?php esc_html_e( 'What do you learn about mankind from this story?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'What do you learn about God?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'Do you think it would be easier or harder to share God\'s Story by telling a story like this?', 'zume' ) ?></li>
                                    </ol>
                                </div>
                            </div> <!-- grid-x -->

                        </section>
                    </div>

                    <div class="large-2 cell"></div><!-- Side spacer -->
                </div> <!-- grid-x -->

                <!------------------------------------------------------------------------------------------------>
                <!-- Share section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x ">
                    <div class="large-2 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="large-8 small-12 cell">

                        <?php get_template_part( 'parts/content', 'share' ); ?>

                    </div>
                    <div class="large-2 cell"></div><!-- Side spacer -->
                </div> <!-- grid-x -->

            </div> <!-- end #inner-content --></div> <!-- end #content -->

        <?php get_template_part( "parts/content", "modal" ); ?>

        <?php
    endwhile;
endif;
get_footer();
