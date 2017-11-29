<?php


function bp_remove_group_step_settings($array)
{

    $array = array(
        'group-details' => array(
            'name' => _x('Details', 'Group screen nav', 'buddypress'),
            'position' => 0
        )
    );

    return $array;
}

add_filter('groups_create_group_steps', 'bp_remove_group_step_settings', 10, 1);


if (!defined('BP_INVITE_ANYONE_SLUG'))
    define('BP_INVITE_ANYONE_SLUG', 'invite-anyone');


if (function_exists('bp_is_active') && bp_is_active('groups')) :

    function group_urls($group_id)
    {
        $token = groups_get_groupmeta($group_id, "group_token");
        $know_more_url = get_site_url() . "/?group-id=" . $group_id . "&zgt=" . $token;
        $sign_up_url = get_site_url() . "/register/?group-id=" . $group_id . "&zgt=" . $token;
        return array("know_more" => $know_more_url, "sign_up" => $sign_up_url);
    }


    class Invite_By_URL extends BP_Group_Extension
    {
        /**
         * Your __construct() method will contain configuration options for
         * your extension, and will pass them to parent::init()
         */

        function __construct()
        {
            $args = array(
                'slug' => 'group_invite_by_url',
                'name' => 'Invite Your Friends',
                "visibility" => "private",
                "show_tab" => 'members',
                "access" => "members",
                'screens' => array(

                    "admin" => array(
                        "enabled" => false
                    )
                ),

            );
            parent::init($args);
        }

        function get_invite_anyone_email_link($group_id)
        {
            return bp_loggedin_user_domain() . BP_INVITE_ANYONE_SLUG . '/invite-new-members/group-invites/' . $group_id;
        }

        function display($group_id = NULL)
        {
            $this->settings_screen($group_id);
        }

        function invite_message($group, $sign_up_url, $know_more_url)
        {
            $message = "Hey,

I just signed up for a 9-week online training course, called Zúme Training. It teaches ordinary men and women, like ourselves, how to make disciples who make more disciples. In order to start the training, I need at least 3 other people to gather in-person with me each week.

You can check out the course at $know_more_url

To accept the invitation to join my Zúme Training group \"" . $group->name . "\", click on this link: $sign_up_url

After you click on the link, it will ask you to create an account. Then you will be joined to our group. When we have at least four people ready to gather together, we can begin going through Zúme Training.

Let's learn how God can use people like us to change the world together,

[Insert your name here]";

            return $message;
        }


        function create_screen_save($group_id = NULL)
        {
            $group = groups_get_group($group_id);

            if (isset($_POST["redirect_invite"]) && $_POST["redirect_invite"] == "yes") {
                bp_core_redirect(bp_get_group_permalink($group) . "group_invite_by_email/");
            } else {
                bp_core_redirect("/dashboard");
            }
        }


        function invite_options($sign_up_url, $group, $know_more_url)
        {
            ?>
            <h2 id="invite-options" class="group-invite-hearer-with-text-under" style="margin-top:15px">To invite people you have 3
                options:</h2>
            <p>Invite 3-11 friends, Zúme requires at least 4 people to be present to start each session.</p>

            <h3 class="group-invite-header group-invite-hearer-with-text-under"><strong>Option 1: </strong></h3>
            <span class="group-invite-header-side-text">
        Write your own message.
      </span>
            <p> Simply include this link and send it by email or any method you wish.</p>
            <textarea readonly rows=1 style="cursor: text"><?php echo $know_more_url ?></textarea>

            <h3 class="group-invite-header"><strong>Option 2: </strong></h3>
            <span class="group-invite-header-side-text">Use our email template.</span>
            <?php $invite_message = $this->invite_message($group, $sign_up_url, $know_more_url); ?>
            <textarea readonly rows=15 style="cursor: text"><?php echo $invite_message?></textarea>
            <p>
                <a class="button" href="mailto:?body=<?php echo rawurlencode($invite_message); ?>">Create this email in default email app</a>
            </p>


            <?php
        }

        function create_screen($group_id = NULL)
        {
            global $bp;
            if ($group_id > 0) {


                $group = groups_get_group($group_id);
                $urls = group_urls($group_id);
                $know_more_url = $urls["know_more"];
                $sign_up_url = $urls["sign_up"];

                $this->invite_options($sign_up_url, $group, $know_more_url);
                ?>
                <h3 class="group-invite-header"><strong>Option 3:</strong></h3><span
                        class="group-invite-header-side-text">Have the email come from Zúme.</span>
                <p>
                    <input id="redirect_invite" class="checkbox-custom" name="redirect_invite" value="yes"
                           type="checkbox">
                    <label for="redirect_invite" class="checkbox-custom-label">
                        Check this box if you would like the invitation email to come from Zúme.
                        After you click "Finish" you will be redirected to the next page where you can add your friend's
                        email addresses.
                    </label>
                </p>
                <style>h1.page-title{display:none;} #group-create-tabs{border-bottom:1px solid #eaeaea;}</style>
                <?php
            }
        }


        /**
         * settings_screen() is the catch-all method for displaying the content
         * of the edit, create, and Dashboard admin panels
         */
        function settings_screen($group_id = NULL)
        {
            global $bp;
            if ($group_id > 0) {

                $group = groups_get_group($group_id);
                $urls = group_urls($group_id);
                $know_more_url = $urls["know_more"];
                $sign_up_url = $urls["sign_up"];


                $this->invite_options($sign_up_url, $group, $know_more_url)
                ?>
                <h3 class="group-invite-header"><strong>Option 3:</strong></h3><span
                        class="group-invite-header-side-text">Have the email come from Zúme.</span>
                <p>
                    Click <strong><a style="font-size: 14pt ;"
                                     href="<?php echo bp_get_group_permalink($group) . "group_invite_by_email/" ?>">here</a></strong>
                    if you would like the invitation email to come from Zúme.
                    You can add your friend's email addresses on the next page.
                </p>

                <?php
            }
        }


    }

    class Invite_By_Email extends BP_Group_Extension
    {
        /**
         * Your __construct() method will contain configuration options for
         * your extension, and will pass them to parent::init()
         */
        function __construct()
        {
            $args = array(
                'slug' => 'group_invite_by_email',
                'name' => 'Group Invite By Email',
                'screens' => array(
                    "create" => array(
                        "enabled" => false
                    ),
                    "admin" => array(
                        "enabled" => false
                    )
                ),
                'show_tab' => 'noone'
            );
            parent::init($args);
        }


        function display($group_id = NULL)
        {
            $this->settings_screen($group_id);
        }


        function settings_screen_save($group_id = NULL)
        {

            update_option("save_group_email", $_POST);

        }


        function settings_screen($group_id = NULL)
        {
            global $bp;


            $group = groups_get_group($group_id);
            $urls = group_urls($group_id);
            $know_more_url = $urls["know_more"];
            $sign_up_url = $urls["sign_up"];
            $current_user = wp_get_current_user();

            $message = "";
            $subject = "";

            ?>
            <form id="invite_by_email" action="/wp-admin/admin-post.php" method="post">
                <h4>Invite Friends to <?php echo $group->name ?></h4>

                <ol id="invite-anyone-steps">
                    <li>
                        <div class="manual-email">
                            <p>
                                <?php _e('Enter email addresses below, one per line.', 'zume_project') ?>
                                <textarea name="invite_by_email_addresses" rows="15" cols="10"
                                          class="invite-anyone-email-addresses"
                                          id="invite-by-email-addresses"></textarea>
                            </p>
                        </div>
                    </li>

                    <!--              <li>-->
                    <!--                    <label for="invite-anyone-custom-subject">-->
                    <?php //_e( '(optional) Customize the subject line of the invitation email.', 'zume_project' )
                    ?><!--</label>-->
                    <!--                    <textarea name="invite_anyone_custom_subject" id="invite-anyone-custom-subject" rows="1" cols="10" >-->
                    <?php //echo esc_textarea( invite_anyone_invitation_subject( $subject ) )
                    ?><!--</textarea>-->
                    <!--              </li>-->
                    <!--              <li>-->
                    <!--                    <label for="invite-anyone-custom-message">-->
                    <?php //_e( '(optional) Customize the text of the invitation.', 'zume_project' )
                    ?><!--</label>-->
                    <!--                    <p class="description">-->
                    <?php //_e( 'The message will also contain a custom footer containing links to accept the invitation or opt out of further email invitations from this site.', 'invite-anyone' )
                    ?><!--</p>-->
                    <!--                    <textarea name="invite_anyone_custom_message" id="invite-anyone-custom-message" cols="40" rows="15">-->
                    <?php //echo $message
                    ?><!--</textarea>-->
                    <!---->
                    <!--              </li>-->

                    <p>We will send an invitation to each email address to sign up to Zúme and join this group</p>

                    <?php wp_nonce_field('invite_by_email') ?>
                    <input type="hidden" name="action" value="group_invite_by_email">
                    <input type="hidden" name="group_id" value=" <?php echo esc_attr($group_id) ?>">
                    <input type="hidden" name="inviter_name"
                           value=" <?php echo esc_attr($current_user->display_name) ?>">
                    <input type="hidden" name="sign_up_url" value=" <?php echo esc_attr($sign_up_url) ?>">


                </ol>

                <div class="submit">
                    <input type="submit" name="invite-anyone-submit" id="invite-anyone-submit"
                           value="<?php _e('Send Invites', 'zume-project') ?> "/>
                </div>

            </form>
            <?php
        }
    }

    class Map_Tab extends BP_Group_Extension
    {
        /**
         * Your __construct() method will contain configuration options for
         * your extension, and will pass them to parent::init()
         */
        function __construct()
        {
            $args = array(
                'slug' => 'group-map',
                'name' => 'Map',
                "visibility" => "private",
                "show_tab" => 'members',
                "access" => "members",
                'screens' => array(
                    "admin" => array(
                        "enabled" => false
                    ),
                    "create" => array(
                        "enabled" => false
                    ),
                ),
            );
            parent::init($args);
        }

        function display($group_id = NULL)
        {
            $this->settings_screen($group_id);
        }


        function settings_screen_save($group_id = NULL)
        {
            update_option("group-map", $_POST);
        }


        function settings_screen($group_id = NULL)
        {
            if(empty(custom_field('tract'))) :
                echo 'You haven\'t yet set your locations. <a href="'.home_url('/groups/') . bp_get_current_group_slug().'/admin/edit-details/">Please set your census location under Manage->Details.</a>';
            else:
            ?>

            <input type="hidden" id="tract" name="tract" value="<?php echo custom_field('tract'); ?>" required/>
            <input type="hidden" id="lng" name="lng" value="<?php echo custom_field('lng'); ?>"  required/>
            <input type="hidden" id="lat" name="lat" value="<?php echo custom_field('lat'); ?>"  required/>
            <input type="hidden" id="state" name="state" value="<?php echo custom_field('state'); ?>"  required/>
            <input type="hidden" id="county" name="county" value="<?php echo custom_field('county'); ?>"  required/>

            <style>
                /* Always set the map height explicitly to define the size of the div
            * element that contains the map. */
                #map {
                    height: 475px;
                    width: 100%;
                }
                /* Optional: Makes the sample page fill the window. */
                html, body {
                    height: 100%;
                    margin: 0;
                    padding: 0;
                }
                #search-response {padding: 15px 0;}

            </style>

                <div id="search-response">Your current census tract is <strong><?php echo custom_field('tract'); ?></strong> as shown on the map below. <br>
                    </div>

            <div id="map"></div>
             <?php if (groups_is_user_admin( get_current_user_id(), $group_id )) : ?>
                <div style="padding:20px 0;">If this is not correct or you have changed location, please <a  href="<?php echo home_url('groups/'); echo bp_get_current_group_slug(); ?>/admin/edit-details/">update your new location in the Manage section.</a><br><a class="button large" href="<?php echo home_url('groups/'); echo bp_get_current_group_slug(); ?>/admin/edit-details/">Go to Edit</a> </div>
             <?php endif; ?>

            <script type="text/javascript">

                jQuery(document).ready(function() {

                    jQuery(window).load(function () {
                        var geoid = '<?php echo custom_field('tract'); ?>';
                        var lng = '<?php echo custom_field('lng'); ?>';
                        var lat = '<?php echo custom_field('lat'); ?>';
                        var state = '<?php echo custom_field('state'); ?>';
                        var county = '<?php echo custom_field('county'); ?>';


                        var restURL = '<?php echo get_rest_url(null, '/lookup/v1/tract/getmapbygeoid'); ?>';

                        jQuery.post( restURL, { geoid: geoid, lng: lng, lat: lat })
                            .done(function( data ) {

                                jQuery('#map').css('height', '475px');

                                var map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: data.zoom,
                                    center: {lng: data.lng, lat: data.lat},
                                    mapTypeId: 'terrain'
                                });

                                // Define the LatLng coordinates for the polygon's path.
                                var coords = [ data.coordinates ];

                                var tracts = [];

                                for (i = 0; i < coords.length; i++) {
                                    tracts.push(new google.maps.Polygon({
                                        paths: coords[i],
                                        strokeColor: '#FF0000',
                                        strokeOpacity: 0.5,
                                        strokeWeight: 2,
                                        fillColor: '',
                                        fillOpacity: 0.2
                                    }));

                                    tracts[i].setMap(map);
                                }

                            });
                    });


                    jQuery('button').click( function () {
                        jQuery('#spinner').prepend('<img src="<?php echo get_template_directory_uri(); ?>/assets/images/spinner.svg" style="height:30px;" />');

                        var address = jQuery('#address').val();
                        var restURL = '<?php echo get_rest_url(null, '/lookup/v1/tract/gettractmap'); ?>';
                        jQuery.post( restURL, { address: address })
                            .done(function( data ) {
                                jQuery('#spinner').html('');
                                jQuery('#search-button').html('Search Again?');
                                jQuery('#search-response').html('<p>Looks like you searched for <strong>' + data.formatted_address + '</strong>? <br>Therefore, <strong>' + data.geoid + '</strong> is most likely your census tract represented in the map below. </p>' );
                                jQuery('#map').css('height', '600px');

                                var map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: data.zoom,
                                    center: {lng: data.lng, lat: data.lat},
                                    mapTypeId: 'terrain'
                                });

                                // Define the LatLng coordinates for the polygon's path.
                                var coords = [ data.coordinates ];

                                var tracts = [];

                                for (i = 0; i < coords.length; i++) {
                                    tracts.push(new google.maps.Polygon({
                                        paths: coords[i],
                                        strokeColor: '#FF0000',
                                        strokeOpacity: 0.5,
                                        strokeWeight: 2,
                                        fillColor: '',
                                        fillOpacity: 0.2
                                    }));

                                    tracts[i].setMap(map);
                                }

                                jQuery('#tract').val(data.geoid);
                                jQuery('#lng').val(data.lng);
                                jQuery('#lat').val(data.lat);
                                jQuery('#state').val(data.state);
                                jQuery('#county').val(data.county);
                            });
                    });
                });
            </script>
            <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcddCscCo-Uyfa3HJQVe0JdBaMCORA9eY">
            </script>


            <?php
            endif;

        }

    }


    bp_register_group_extension('Map_Tab');
    bp_register_group_extension('Invite_By_URL');
    bp_register_group_extension('Invite_By_Email');
endif; // if ( bp_is_active( 'groups' ) )
