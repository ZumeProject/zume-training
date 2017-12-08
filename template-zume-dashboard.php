<?php
/*
Template Name: Zúme Dashboard
*/

$zume_current_lang = zume_current_language();

get_header();

?>

<div id="content">

    <div id="inner-content" class="grid-x">

        <div id="main" class="cell" role="main">

            <!-- First Row -->
            <div class="grid-x grid-margin-x" data-equalizer data-equalize-on="large" id="test-eq">
                <div class="large-1 cell"></div>
                <div class="large-7 cell">

                    <div class="callout" data-equalizer-watch>

                        <ul id="groups-list" class="item-list">
                            <li class="block">
                                <h2 class="center">Your Groups</h2>
                            </li>

                            <!-- Group Row -->
                            <li class="block">
                                <div class="grid-x grid-margin-x">
                                    <div class="large-6 cell">
                                        <h3><a data-open="group1">Group Name 1</a></h3>
                                        <p class="text-gray">
                                            Meeting Time: Monday at 6pm<br>
                                            Members: 6<br>
                                            Address: 1501 W. Highlands Ranch, CO 80126<br>
                                            Status: Active
                                        </p>

                                        <button class="small" data-open="group1"><i class="fi-pencil hollow"></i> edit</button>
                                    </div>
                                    <div class="large-6 cell">
                                        <ul class="pagination" role="navigation" aria-label="Pagination">
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=1'; ?>">1</a></li>
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=2'; ?>">2</a></li>
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=3'; ?>">3</a></li>
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=4'; ?>">4</a></li>
                                            <li class=""><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=5'; ?>">5</a></li>
                                            <li class=""><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=6'; ?>">6</a></li>
                                            <li class=""><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=7'; ?>">7</a></li>
                                            <li class=""><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=8'; ?>">8</a></li>
                                            <li class=""><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=9'; ?>">9</a></li>
                                            <li class=""><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=10'; ?>">10</a></li>
                                        </ul>

                                        <div class="button-group">
                                            <a href="" class="button hollow">Start Next Session #</a>
                                        </div>

                                    </div>
                                </div>
                            </li>

                            <!-- Group Row -->
                            <li class="block">
                                <div class="grid-x grid-margin-x">
                                    <div class="large-6 cell">
                                        <h3><a data-open="group2">Group Name 2</a></h3>
                                        <p class="text-gray">
                                            Meeting Time: <i class="fi-x warning"></i><br>
                                            Members: <i class="fi-x warning"></i> <br>
                                            Address: 1501 W. Highlands Ranch, CO 80126<br>
                                            Status: Active
                                        </p>
                                        <button class="small" data-open="group2"><i class="fi-pencil hollow"></i> edit</button>
                                    </div>
                                    <div class="large-6 cell">
                                        <ul class="pagination" role="navigation" aria-label="Pagination">
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=1'; ?>">1</a></li>
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=2'; ?>">2</a></li>
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=3'; ?>">3</a></li>
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=4'; ?>">4</a></li>
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=5'; ?>">5</a></li>
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=6'; ?>">6</a></li>
                                            <li class="current"><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=7'; ?>">7</a></li>
                                            <li class=""><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=8'; ?>">8</a></li>
                                            <li class=""><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=9'; ?>">9</a></li>
                                            <li class=""><a href="<?php echo zume_get_posts_translation_url( 'course', $zume_current_lang ) . '/?group=23&session=10'; ?>">10</a></li>
                                        </ul>

                                        <div class="button-group">
                                            <a href="" class="button hollow">Start Next Session #</a>
                                        </div>

                                    </div>
                                </div>
                            </li>
                        </ul>

                        <div class="grid-x grid-margin-x">
                            <div class="large-8 large-offset-2 cell center">
                                <p><strong>You do not currently have a group.</strong></p>
                                <p>You will need at least four people gathered together to start each new session.
                                    Please start a group below. If you intended to join someone else's group, please return
                                    to the invitation they
                                    sent and use the link provided to be automatically added to that group.</p>
                            </div>
                        </div>

                        <p class="center">
                            <button class="button hollow" data-open="create">Start New Group</button>
                        </p>

                    </div>
                </div>

                <div class="large-3 cell dashboard-messages">
                    <div class="callout" data-equalizer-watch>
                        <h2 class="center">Your Coach</h2>
                    </div>
                </div>
                <div class="large-1 cell"></div>
            </div>

        </div>

    </div>

</div>

<!-- Create a New Group Modal -->
<div class="small reveal" id="create" data-reveal>
    <h1>Create Group</h1>
    <form action="" method="post" >
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <label for="group_name">Group Name</label>
                <input type="text" value="" name="group_name" id="group_name" required/>
            </div>
            <div class="cell">
                <label for="group_members">Number of Participants</label>
                <input type="text" value="" name="group_members" id="group_members" required/>
            </div>
            <div class="cell">
                <label for="group_meeting_time">Planned Meeting Time</label>
                <input type="text" value="" name="group_meeting_time" id="group_meeting_time" required/>
            </div>
            <div class="cell">
                <label for="group_address">Address</label>
                <input type="text" value="" name="group_address" id="group_address" required/>
            </div>
            <div class="cell">
                <p class="text-small">Is this group active?</p>
                <div class="switch large">
                    <input class="switch-input" id="yes-no" type="checkbox" name="exampleSwitch">
                    <label class="switch-paddle" for="yes-no">
                        <span class="show-for-sr">Is this group active?</span>
                        <span class="switch-active" aria-hidden="true">Yes</span>
                        <span class="switch-inactive" aria-hidden="true">No</span>
                    </label>
                </div>
            </div>
            <div class="cell">
                <br>
                <button type="submit" class="button" >Submit</button>
            </div>
        </div>

        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </form>
</div>

<!-- Edit current groups section -->
<div class="small reveal" id="group1" data-reveal>
    <h1>Edit Group</h1>
    <form action="" method="post" >
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <label for="group_name">Group Name</label>
                <input type="text" value="Group Name 1" name="group_name" id="group_name" required/>
            </div>
            <div class="cell">
                <label for="group_members">Number of Participants</label>
                <input type="text" value="6" name="group_members" id="group_members" required/>
            </div>
            <div class="cell">
                <label for="group_meeting_time">Planned Meeting Time</label>
                <input type="text" value="Mondays 6pm" name="group_meeting_time" id="group_meeting_time" required/>
            </div>
            <div class="cell">
                <label for="group_address">Address</label>
                <input type="text" value="9134 Woodland Dr., Highlands Ranch, CO 80120" name="group_address" id="group_address" required/>
            </div>
            <div class="cell">
                <label for="group_status">Is this group active?</label>
                <input type="checkbox" value="" name="group_status" id="group_status" class="xx-large" required/>
            </div>
            <div class="cell">
                <br>
                <button type="submit" class="button" >Submit</button>
            </div>
        </div>

        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </form>
</div>

<div class="small reveal" id="group2" data-reveal>
    <h1>Edit Group</h1>
    <form action="" method="post" >
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <label for="group_name">Group Name</label>
                <input type="text" value="Group 2" name="group_name" id="group_name" required/>
            </div>
            <div class="cell">
                <label for="group_members">Number of Participants</label>
                <input type="text" value="" name="group_members" id="group_members" required/>
            </div>
            <div class="cell">
                <label for="group_meeting_time">Planned Meeting Time</label>
                <input type="text" value="" name="group_meeting_time" id="group_meeting_time" required/>
            </div>
            <div class="cell">
                <label for="group_address">Address</label>
                <input type="text" value="Hollywood Blvd, CA" name="group_address" id="group_address" required/>
            </div>
            <div class="cell">
                <label for="group_status">Is this group active?</label>
                <input type="checkbox" value="" name="group_status" id="group_status" class="xx-large" required/>
            </div>
            <div class="cell">
                <br>
                <button type="submit" class="button" >Submit</button>
            </div>
        </div>

        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </form>
</div>


<?php get_footer(); ?>

