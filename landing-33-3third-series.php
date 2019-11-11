<?php
/*
Template Name: 33 - 3/3 Series
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 10;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 32;
        set_query_var( 'tool_number', absint( $tool_number ) );
        ?>

        <!-- Wrappers -->
        <div id="content" class="grid-x grid-padding-x training"><div id="inner-content" class="cell">

                <!------------------------------------------------------------------------------------------------>
                <!-- Title section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                    <div class="medium-2 small-1 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="medium-8 small-10 cell center">

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/zume_images/V5.1/1Waving1Not.svg" width="200px" />

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
                                <div class="cell content-large center">
                                    <a href="">HOPE SERIES [FOR SEEKERS]</a><br>
                                    <a href="">SIGNS OF JOHN [FOR SEEKERS]</a><br>
                                    <a href="">START TRACK: THE FIRST 8 MEETINGS</a><br>
                                    <hr>
                                </div>
                            </div>

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <div class="grid-x grid-padding-y">
                                        <div class="cell">
                                            HOPE SERIES [FOR SEEKERS]
                                        </div>
                                        <div class="cell">
                                            Use the following passages for the “LOOK UP” portion of your group. Your group may need more than one meeting for some of the passages.
                                        </div>
                                        <div class="cell inset">
                                            <ol>
                                                <li>Hope for the sinner: Luke 18:9-14</li>
                                                <li>Hope for the poor: Luke 12:13-34</li>
                                                <li>Hope for the runaway: Luke 15:11-32</li>
                                                <li>Hope for the lost: Luke 19:1-10</li>
                                                <li>Hope for the grieving: John 11:1-44</li>
                                                <li>Hope for the seeker: John 3:1-21</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="cell content-large">
                                    <div class="grid-x grid-padding-y">
                                        <div class="cell">
                                            SIGNS OF JOHN [FOR SEEKERS]
                                        </div>
                                        <div class="cell">
                                            Use the following passages for the
                                            “LOOK UP” portion of your group. Your group
                                            may need more than one meeting for some of
                                            the passages.
                                        </div>
                                        <div class="cell inset">
                                            <ol>
                                                <li>Turning of water into wine: John 2:1-12</li>
                                                <li>Healing of the royal official’s son: John 4:46-54</li>
                                                <li>Healing of the paralytic: John 5:1-17</li>
                                                <li>Feeding of the five thousand: John 6:1-14</li>
                                                <li>Walking on water: John 6:15-25</li>
                                                <li>Healing of the man born blind: John 9:1-41</li>
                                                <li>Raising Lazarus from the dead: John 11:1-46</li>
                                            </ol>
                                        </div>
                                        <div class="cell"><hr></div>
                                    </div>
                                </div>


                                <div class="cell content-large">

                                    <p>START TRACK: THE FIRST 8 MEETINGS</p>
                                    <p>This is appropriate for people who are already
                                        Christians but have not been in this type
                                        of group before. The practice portion is
                                        guided and generic for these 8 sessions.
                                        Individualized practice is begun in subsequent
                                        meetings.</p>
                                    <p>1. TELL YOUR STORY</p>
                                    <p>LOOK UP: Mark 5:1-20. Pay particular
                                        attention to verses 18-20.</p>
                                    <p>PRACTICE: Practice telling your story-
                                        You will need to prepare your story and be
                                        prepared to share it with people when you
                                        tell them about Jesus. Here is how you can
                                        tell your story:</p>
                                    <ul>
                                        <li>Talk about your life before following
                                            Jesus-Describe your feelings [pain,
                                            loneliness], questions [what happens
                                            after death?], or struggles you had
                                            before following Jesus.
                                        </li>
                                        <li>Talk about how you became a follower
                                            of Jesus-Tell them about Jesus! The
                                            essential story of Jesus is: We have all
                                            offended God with our sins. We will die
                                            because of our sins. But we are saved
                                            from death when we put our faith in
                                            Jesus, who died for our sins, was buried,
                                            and raised from the dead.
                                        </li>
                                        <li>Talk about your life after following
                                            Jesus-Tell them about how Jesus
                                            changed your life. Tell of the joy, peace,
                                            and forgiveness Jesus gave.
                                        </li>
                                        <li>Invite a response-Your story should ask
                                            for a response. End with a question that
                                            will help you discover the person’s level
                                            of spiritual interest. Ask something like:
                                        “Would you like to know how you can
                                            be forgiven?” or “Would you like God to
                                            change your life?”
                                        </li>
                                        <li>Keep it Brief [3 minutes or less]-Your story
                                            should be short and interesting. Do not be
                                            boring and do not talk so long that the
                                            listener loses interest.
                                        </li>
                                        <li>Practice telling your story with someone
                                            in your group.
                                        </li>
                                        <li>Choose 5 people to tell. Pray. Ask God to
                                            show you which 5 people you know to
                                            whom He wants you to tell your story to
                                            this week.
                                        </li>
                                    </ul>


                                    <p>2. TELL JESUS’ STORY</p>
                                    <p>LOOK UP: 1 Corinthians 15:1-8, Romans 3:23,
                                        Romans 6:23</p>
                                    <p>PRACTICE: Have everyone in your group
                                        practice telling Jesus’ story using the
                                        Evangecube or use another simple method.
                                        Tell your story and Jesus’ story to 5 people
                                        this week. Do this every week.</p>
                                    <p>3. FOLLOW & FISH</p>
                                    <p>LOOK UP: Mark 1:16-20</p>
                                    <p>PRACTICE: Make a List-Get a blank piece of
                                        paper and write the names of 100 people that
                                        you know [family, friends, neighbors, co-workers
                                        or school mates] who need to hear about
                                        Jesus. Tell your story and Jesus’ story to 5
                                        people this week. Do this every week.</p>
                                    <p>4. BAPTISM</p>
                                    <p>LOOK UP: Romans 6:3-4; Acts 8:26-40</p>
                                    <p>PRACTICE: Find nearby water [bathtub, pool,
                                        river, lake] and baptize all new believers. Continue
                                        to immediately baptize people as they
                                        become believers. To learn more about baptism,
                                        see Acts 2:37-41, 8:5-13, 8:36-38, 9:10-19,
                                        10:47-48, 16:13-15, 16:27-34, Acts 18:5-9 and 1
                                        Corinthians 1:10-17, Acts 19:1-5, Acts 22:14-17.
                                        Tell your story and Jesus’ story to 5 people
                                        this week. Do this every week.</p>
                                    <p>5. THE BIBLE</p>
                                    <p>LOOK UP: 2 Timothy 3:14-16</p>
                                    <p>PRACTICE: Memorize and recite the 7 Bible
                                        study questions [questions 1-7 in the Simple
                                        Meeting Format].
                                        Tell your story and Jesus’ story to 5 people
                                        this week. Do this every week.</p>
                                    <p>6. TALK WITH GOD</p>
                                    <p>LOOK UP: Matthew 6:9-13</p>
                                    <p>PRACTICE: Use your hand to learn how to
                                        talk with God. As a group pray through Jesus’
                                        prayer in Matthew 6:9-13 using your hand as
                                        a guide.</p>
                                    <li>1. Palm = Relationship. As the palm is the
                                        foundation for our fingers and thumb, time
                                        alone with God is the foundation for our
                                        personal relationship with him. “Our Father
                                        in heaven…” [Matthew 6:9]
                                    </li>
                                    <li>2. Thumb = Worship. Our thumb reminds us
                                        that we must worship God before we ask for
                                        anything. “…may your name be holy.”
                                        [Matthew 6:9]
                                    </li>
                                    <li>3. First Finger = Surrender. Next we
                                        surrender our lives, plans, family, finances,
                                        work, future, everything. “May your kingdom
                                        come, your will be done…” [Matthew 6:10]
                                    </li>
                                    <li>4. Middle Finger = Ask. Then we ask God to
                                        meet our needs. “Give us this day our daily
                                        bread.” [Matthew 6:11]
                                    </li>
                                    <li>5. Fourth Finger = Forgive. Now we ask
                                        God to forgive our sins, and we must forgive
                                        others. “Forgive us as we forgive others.”
                                        [Matthew 6:12]
                                    </li>
                                    <li>6. Little Finger= Protect. Then we ask
                                        protection. “Let us not yield to temptation,
                                        but deliver us from the evil one.”
                                        [Matthew 6:13]
                                    </li>
                                    <li>7. Thumb [Again] = Worship. And we end just
                                        as we began – we worship Almighty God – “
                                        Yours is the kingdom and the power and the
                                        glory forever. Amen.” [Matthew 6:13].
                                    </li>
                                    <p>Tell your story and Jesus’ story to 5 people
                                        this week. Do this every week.</p>
                                    <p>7. HARD TIMES</p>
                                    <p>LOOK UP: Acts 5:17-42; Matthew 5:43-44</p>
                                    <p>PRACTICE: Share with the group about a
                                        difficulty you have faced because of your
                                        new faith; consider difficulties you may face;
                                        role play how you will respond – with
                                        boldness and love – as Jesus teaches. Pray
                                        as needs come up. Pray for each person after
                                        they share. Tell your story and Jesus’ story
                                        to 5 people this week. Do this every week.</p>
                                    <p>8. BECOME A CHURCH</p>
                                    <p>LOOK UP: Acts 2:42-47, 1 Corinthians 11:23-
                                        34</p>
                                    <p>PRACTICE: Discuss what your group needs to
                                        do to become like the church described in the
                                        passages. As a group, on a blank paper, draw
                                        a dotted line circle representing your own
                                        group. Above it, list 3 numbers: the number
                                        regularly attending [stick figure], the number
                                        believing in Jesus [cross] and the
                                        number baptized after believing [water].</p>

                                    <p>If your group has committed to be a church,
                                        make the dotted line circle solid. If you regularly
                                        practice each of the following elements
                                        then draw a picture of the elements inside
                                        your circle. If you do not do the element or
                                        you wait for an outsider to come do it, then
                                        draw the element outside the circle.</p>

                                    <ol>
                                        <li>1. Commitment to be a church: solid
                                            line instead of dotted line.
                                        </li>
                                        <li>2. Baptism-water</li>
                                        <li>3. Bible-book</li>
                                        <li>4. Commemorate Jesus w/bread and
                                            water-cup
                                        </li>
                                        <li>5. Fellowship-heart</li>
                                        <li>6. Giving and ministry-money sign</li>
                                        <li>7. Prayer-praying hands</li>
                                        <li>8. Praise-raised hands</li>
                                        <li>9. Telling people about Jesus-friend
                                            holding hands with a friend
                                        </li>
                                        <li>10. he led to faith</li>
                                        <li>11. Leaders-two smiling faces</li>
                                    </ol>

                                    <p>What is your group missing that would help
                                        make it a healthy church?</p>
                                    <p>Tell your story and Jesus’ story to 5 people
                                        this week. Do this every week.</p>

                                    <p>WHERE NEXT?</p>
                                    <p>Go through the 3/3 Discover Track or 3/3
                                        Strengthen Track or select a book of the
                                        Bible like John or Mark [choose only one
                                        story per meeting].</p>
                                </div>

                                <div class="cell content-large">
                                    DISCOVER SERIES
                                    [For Groups That Need Bible
                                    Background & Familiarity]
                                    Use the following passages for the
                                    “LOOK UP” portion of your group. Your group
                                    may need more than one meeting for some of
                                    the passages.
                                    Discover God-who is God and what He is like
                                    1. Creation-Genesis 1
                                    2. Creation of People-Genesis 2
                                    3. Disobedience of People-Genesis 3
                                    4. Noah and the Flood-Genesis 6:5-8:14
                                    5. God’s Promise with Noah-Genesis
                                    8:15-9:17
                                    6. God Speaks to Abraham-Genesis
                                    12:1-7; 15:1-6
                                    7. David becomes King of Abraham’s
                                    Descendants-1 Samuel 16:1-13; 2
                                    Samuel 7:1-28
                                    8. King David and Bathsheba-2 Samuel
                                    11: 1-27
                                    9. Nathan’s Story-2 Samuel 12:1-25
                                    10. God Promises Savior will come-Isaiah 53
                                    Discover Jesus-who is Jesus and why
                                    He came
                                    1. Savior born-Matthew 1:18-25
                                    2. Jesus’ Baptism-Matthew 3:7-9, 13-15
                                    3. Crazy Man Healed-Mark 5:1-20
                                    4. Jesus never Loses Sheep-John 10:1-30
                                    5. Jesus Heals the Blind-Luke 18:31-42
                                    6. Jesus and Zaccheus-Luke 19:1-9
                                    7. Jesus and Matthew-Matthew 9:9-13
                                    8. Jesus is the Only Way-John 14:1-15
                                    9. Holy Spirit Coming-John 16:5-15
                                    10. Last Dinner-Luke 22:14-20
                                    11. Arrest and Trial-Luke 22:47-53; 23:13-24
                                    12. Execution-Luke 23:33-56
                                    13. Jesus is Alive-Luke 24:1-7, 36-47;
                                    Acts 1:1-11
                                    14. Believing and Doing-Philippians 3:3-9
                                    STRENGTHEN SERIES
                                    [For New Believers Or Groups That Need Discipling
                                    Focus]
                                    Jesus Says-learn to obey the basic
                                    commands of Jesus. Keep sharing Jesus with
                                    people on your list.
                                    1.1 Learn and do-John 14:15-21!
                                    1.2 Repent. Believe. Follow. Mark 1:14-17,
                                    Ephesians 2:1-10
                                    1.3 Be baptized-Matthew 28:19,
                                    Acts 8:26-38
                                    1.4 Love God. Love People-Luke 10:25-37
                                    Jesus Also Says-learn to obey the basic
                                    commands of Jesus. Keep sharing Jesus with
                                    people on your list.


                                    2.1 Talk with God-Matthew 6:9-13. Learn
                                    and practice Jesus’ model prayer
                                    2.2 Remember and Commemorate
                                    Jesus-Luke 22:14-20, 1 Corinthians
                                    11:23-32
                                    2.3 Give-Acts 4:32-37
                                    2.4 Pass it on-Matthew 28:18-20
                                    Follow as I follow-Make disciples. Pass on to
                                    others what you have learned. Teach these
                                    people to pass it on too.
                                    3.1 Find a Disciple-2 Timothy 1:1-14
                                    3.2 Pass it on-2 Timothy 2:1-4, 14-16
                                    3.3 Teach them to teach others-2 Timothy
                                    3:1-17 3.4 Hard times-2 Timothy 4:1-22
                                    Multiply your 3/3 Group-Gather your
                                    disciples into new groups.
                                    4.1 Get Started and make a plan-Luke
                                    10:1-11. Listen to Jesus’ instructions as
                                    you start a new group.
                                    4.2 Gather Together-Acts 2:14-47
                                    4.3 Person of Peace-Mark 5:1-20, 6:53-56.
                                    Look for people willing to share their
                                    story about Jesus. Start a group with
                                    that person & their friends & family.
                                    4.4 Who is ready -Matthew 13:1-9, 18-23
                                    Lead-learn how to lead a 3/3 group.
                                    5.1 Model [lead like this]-John 13:1-17
                                    5.2 Model [don’t lead like this]-3 John 5-14
                                    5.3 Assist-Mark 4:35-41
                                    5.4 Watch-Luke 10:1-11, 17, 20
                                    5.5 Leave-Matthew 25:14-30
                                    Go: local-learn how to reach your
                                    local community.
                                    6.1 Go: local-Acts 1:1-8
                                    6.2 Help the poor. Share the good news-
                                    Luke 7:11-23
                                    6.3 Go where God sends-Acts 10:9-48
                                    6.4 Go with a plan-Acts 13:1-3, 32-33, 38-39;
                                    4:21-23, 26-27
                                    Go: global-learn how to reach the ends
                                    of the earth.
                                    7.1 Go: global-Acts 1:1-8, Matthew 28:19-20
                                    7.2 Go where God sends-Acts 8:26-38
                                    7.3 God loves every people group-John
                                    4:4-30, 39-417.4 Go with a plan-Acts
                                    13:1-3, 32-33, 38-39; 14:21-23,26-27
                                    Remember the basics. Learn what to do
                                    when you meet.
                                    8.1 Jesus is First-Philippians 2:1-11
                                    8.2 Talk with God-Matthew 6:9-13
                                    8.3 Community-Hebrews 10:23-25
                                    8.4 The Bible-2 Timothy 3:10-17
                                    Commit-learn to stay strong and keep
                                    following Jesus.
                                    9.1 Disobedience-Jonah 1
                                    9.2 Commit-Jonah 2
                                    9.3 Obey-Jonah 3
                                    9.4 Obey all the way-Jonah 4
                                    9.5 Use it or Lose it-Matthew 25:14-30
                                    WHERE NEXT?
                                    Choose your own Bible passages and keep
                                    meeting. Use the same questions and group
                                    meeting format. Don’t stop meeting.

                                </div>
                            </div>
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


                <!------------------------------------------------------------------------------------------------>
                <!-- Transcription section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x">
                    <div class="large-2 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="large-8 small-12 cell">

                        <div class="grid-x grid-margin-x grid-margin-y">
                            <div class="large-12 cell content-large center">
                                <h3 class="center"><?php echo esc_html__( 'Video Transcript', 'zume' ) ?></h3>
                            </div>
                            <div class="large-12 cell content-large">

                                <?php the_content(); ?>

                            </div>
                        </div>

                    </div>


                    <div class="large-2 cell"></div><!-- Side spacer -->
                </div> <!-- grid-x -->

            </div> <!-- end #inner-content --></div> <!-- end #content -->

        <?php get_template_part( "parts/content", "modal" ); ?>

        <?php
    endwhile;
endif;
get_footer();
