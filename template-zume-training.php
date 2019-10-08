<?php
/*
Template Name: Training
*/
get_header();
?>

<div id="training">
    <div  id="inner-content" class="grid-x padding-top-1">

        <?php if( ! is_user_logged_in() ) : ?>
        <div id="challenge" class="cell">
            <div class="grid-x ">
                <div class="large-1 cell"></div> <!-- side padding -->

                <!-- Center Column -->
                <div class="large-10 cell">

                    <div class="callout">
                        <div class="grid-x grid-padding-x">
                            <div class="cell hide-for-small-only medium-1"></div>
                            <div class="cell medium-7">
                                <p class="t-ad-message"><?php echo esc_html__("Plan your group, add members, track your progress, connect with a coach, and add your effort to the global vision!", 'zume' ) ?></p>
                            </div>
                            <div class="cell medium-4">
                                <a href="" class="button secondary large" style="color:white;border:0;"><?php echo esc_html__("Register Forever Free", 'zume' ) ?></a>
                            </div>
                        </div>
                    </div><!-- end #callout -->

                </div> <!-- end center column -->

                <div class="large-1 cell"></div> <!-- side padding -->
            </div>
        </div> <!-- end #challenge-->
        <?php endif; ?>

        <div id="course" class="cell">
            <div class="grid-x">
                <div class="large-1 cell"></div> <!-- side padding -->

                <div class="large-10 cell"><!-- Center Column -->

                    <div class="callout">
                        <div class="grid-x">
                            <div class="cell small-1"></div>
                            <div class="cell small-10 center text-uppercase">
                                <h1><?php echo esc_html__("Zúme Training", 'zume') ?></span></h1>
                                <p class="t-description"><?php echo esc_html__("10 Sessions, 2 hours each, for groups of 3 - 12", 'zume' ) ?></p>

                            </div>
                            <div class="cell small-1 align-right">
                                <a class="text-small" onclick="toggle_extra()">show/hide</a><br>
                                <i class="fi-list toggle-icons" onclick="toggle_columns(1)"></i> <i class="fi-thumbnails toggle-icons" onclick="toggle_columns(0)"></i>
                            </div>
                        </div>
                        <hr>
                        <div class="grid-x grid-padding-x grid-padding-y">

                            <!-- Session 1 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 1', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("God Uses Ordinary People", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php esc_html_e( "You'll see how God uses ordinary people doing simple things to make a big impact.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Teach Them to Obey", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php esc_html_e('Discover the essence of being a disciple, making a disciple, and what is the church.', 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Spiritual Breathing", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php esc_html_e('Being a disciple means we hear from God and we obey God.', 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("SOAPS Bible Reading", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php esc_html_e('A tool for daily Bible study that helps you understand, obey, and share God’s Word.', 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Accountability Groups", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php esc_html_e('A tool for two or three people of the same gender to meet weekly and encourage each other in areas that are going well and reveal areas that need correction.', 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Accountability groups", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("45 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 2 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 2', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Consumers vs Producers", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("You'll discover the four main ways God makes everyday followers more like Jesus.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Prayer Cycle", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__('See how easy it is to spend an hour in prayer.', 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Prayer Cycle", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("60 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Discuss - Prayer Cycle", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("List of 100", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__('A tool designed to help you be a good steward of your relationships.', 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Create List of 100", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("30 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 3 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 3', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Kingdom Economy", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Learn how God's economy is different from the world's. God invests more in those who are faithful with what they've already been given.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Discuss - Should every disciple share?", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("The Gospel", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Learn a way to share God’s Good News from the beginning of humanity all the way to the end of this age.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Sharing the Gospel", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("45 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Baptism", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__('Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the Father and of the Son and of the Holy Spirit…” Learn how to put this into practice.', 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 4 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 4', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("3-Minute Testimony", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Learn how to share your testimony in three minutes by sharing how Jesus has impacted your life.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Share your testimony", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("45 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Greatest Blessing", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__('Learn a simple pattern of making not just one follower of Jesus but entire spiritual families who multiply for generations to come.', 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Duckling Discipleship", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Learn what ducklings have to do with disciple-making.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Seeing Where God's Kingdom Isn't", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__('Begin to see where God’s Kingdom isn’t. These are usually the places where God wants to work the most.', 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("The Lord's Supper", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("It’s a simple way to celebrate our intimate connection and ongoing relationship with Jesus. Learn a simple way to celebrate.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Lord's Supper", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 5 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 5', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Prayer Walking", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("It’s a simple way to obey God’s command to pray for others. And it's just what it sounds like — praying to God while walking around!", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Person of Peace", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Learn who a person of peace might be and how to know when you've found one.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("BLESS Prayer", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Practice a simple mnemonic to remind you of ways to pray for others.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - BLESS Prayer", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Prayer Walking", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("90 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 6 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 6', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Faithfulness", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("It's important what disciples know — but it's much more important what they DO with what they know.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("3/3 Group Pattern", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("A 3/3 Group is a way for followers of Jesus to meet, pray, learn, grow, fellowship and practice obeying and sharing what they've learned. In this way, a 3/3 Group is not just a small group but a Simple Church.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("75 min", 'zume' ) ?>
                                    </div>

                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 7 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 7', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Training Cycle", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Learn the training cycle and consider how it applies to disciple making.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - 3/3 Group", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("90 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Discuss - 3/3 Group Experience", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 8 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 8', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Leadership Cells", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("A Leadership Cell is a way someone who feels called to lead can develop their leadership by practicing serving.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - 3/3 Group", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("90 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 9 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 9', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Non-Sequential", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("See how disciple making doesn't have to be linear. Multiple things can happen at the same time.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Pace", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Multiplying matters and multiplying quickly matters even more. See why pace matters.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Part of Two Churches", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Learn how to obey Jesus' commands by going AND staying.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("3-Month Plan", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Create and share your plan for how you will implement the Zúme tools over the next three months.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Create 3-Month Plan", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("60 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Discuss - Share 3-Month Plan with group", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("20 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 10 -->
                            <div class="cell small-12 medium-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-10"><h2><?php echo esc_html__( 'Session 10', 'zume' ) ?></h2></div>
                                    <div class="cell small-2 start">
                                        <a href="" class="button hollow"><?php echo esc_html__("Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Coaching Checklist", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("A powerful tool you can use to quickly assess your own strengths and vulnerabilities when it comes to making disciples who multiply.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Coaching Checklist Self-Assessment", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Leadership in Networks", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("Learn how multiplying churches stay connected and live life together as an extended, spiritual family.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Peer Mentoring Groups", 'zume' ) ?></a><br>
                                        <p class="t-description"><?php echo esc_html__("This is a group that consists of people who are leading and starting 3/3 Groups. It also follows a 3/3 format and is a powerful way to assess the spiritual health of God’s work in your area.", 'zume') ?></p>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Four Fields Tool", 'zume' ) ?></a><br>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10">
                                        <a href=""><?php echo esc_html__("Generation Mapping", 'zume' ) ?></a><br>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - 3/3 Peer Mentoring", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("60 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Four Fields", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Practice - Generation Mapping", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-10 t-activities hide-extra">
                                        <?php echo esc_html__("Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-2 t-length hide-extra">
                                        <?php echo esc_html__("5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end #callout -->

                </div> <!-- end center column -->

                <div class="large-1 cell"></div> <!-- side padding -->
            </div>
        </div> <!-- end #challenge-->
    </div> <!-- end #inner-content -->
</div> <!-- end #content -->

<?php

get_footer();
