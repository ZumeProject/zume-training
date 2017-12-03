<?php

/**
 * Zúme Course Core
 *
 * @class Disciple_Tools_Admin_Menus
 * @version    0.1
 * @since 0.1
 * @package    Disciple_Tools
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Zume_Course {

	/**
	 * Disciple_Tools_Admin_Menus The single instance of Disciple_Tools_Admin_Menus.
	 * @var    object
	 * @access  private
	 * @since    0.1
	 */
	private static $_instance = null;

	/**
	 * Main Zume_Course Instance
	 *
	 * Ensures only one instance of Disciple_Tools_Admin_Menus is loaded or can be loaded.
	 *
	 * @since 0.1
	 * @static
	 * @return Zume_Course instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	} // End instance()

	private $session_nine_labels = array();

	/**
	 * Constructor function.
	 * @access  public
	 * @since   0.1
	 */
	public function __construct() {
		add_shortcode( 'session_nine_plan', array( $this, 'session_nine_plan' ) );
		add_action( "admin_post_session_nine_plan", array( $this, "session_nine_plan_submit" ) );
		$this->session_nine_labels = array(
			"I will share My Story [Testimony] and God’s Story [the Gospel] with the following individuals:",
			"I will invite the following people to begin an Accountability Group with me:",
			"I will challenge the following people to begin their own Accountability Groups and train them how to do it:",
			"I will invite the following people to begin a 3/3 Group with me:",
			"I will challenge the following people to begin their own 3/3 Groups and train them how to do it:",
			"I will invite the following people to participate in a 3/3 Hope or Discover Group [see Appendix]:",
			"I will invite the following people to participate in Prayer Walking with me:",
			"I will equip the following people to share their story and God’s Story and make a List of 100 of the people in their relational network:",
			"I will challenge the following people to use the Prayer Cycle tool on a periodic basis:",
			"I will use the Prayer Cycle tool once every [days / weeks / months].",
			"I will Prayer Walk once every [days / weeks / months].",
			"I will invite the following people to be part of a Leadership Cell that I will lead:",
			"I will encourage the following people to go through this Zúme Training course:",
			"Other commitments:"
		);
	} // End __construct()

	/**
	 * Zúme Pre Content Load
	 * @access  public
	 * @since   0.1
	 */
	public function zume_pre_content_load() {

		/*** VARIABLES ***/

		// Set variables
		$user_id  = get_current_user_id();
		$meta_key = 'zume_active_group';

		// Set variable for session
		if ( isset( $_GET['id'] ) ) {
			$zume_session = $_GET['id'];
		} else {
			$zume_session = '1';
		}

		$group_id = '';

		if ( isset( $_GET['group_id'] ) && ! empty( $_GET['group_id'] ) ) {
			if ( groups_is_user_member( $user_id, $_GET['group_id'] ) ) {
				$group_id = $_GET['group_id'];
			}
		}
		if ( empty( $group_id ) && ! empty( $_POST[ $meta_key ] ) ) {
			if ( groups_is_user_member( $user_id, $_POST[ $meta_key ] ) ) {
				$group_id = $_POST[ $meta_key ];
			}
		}
		$group_id_user_meta = get_user_meta( $user_id, $meta_key, true );
		if ( empty( $group_id ) && $group_id_user_meta ) {
			if ( groups_is_user_member( $user_id, $group_id_user_meta ) ) {
				$group_id = $group_id_user_meta;
			}
		}

		//look at user's buddy press groups
		if ( empty( $group_id ) || ( empty( $_POST[ $meta_key ] ) && isset( $_GET["switch_zume_group"] ) ) ) {
			$user_groups = bp_get_user_groups( $user_id, array( 'is_admin' => null, 'is_mod' => null, ) );
			if ( count( $user_groups ) == 1 ) {
				$group_id = $user_groups[0]->group_id;
			} elseif ( count( $user_groups ) > 1 ) {
				echo 'More than one group<br>';
				echo '<form action=""  method="POST" >Which group do you prefer?<br>';

				foreach ( $user_groups as $agroup ) {

					// Get group name from group id
					$group_id   = $agroup->group_id;
					$group      = groups_get_group( $group_id ); // gets group object
					$group_name = $group->name;

					// Create radio button
					echo '<div class="radio">';
					echo '<label><input type="radio" name="' . $meta_key . '" value="' . $group_id . '">' . $group_name . ' </label>';
					echo '</div>';

				}

				echo '<button type="submit" class="btn button">Select</button>';
				echo '</form>';

				return;
			}
		}

		if ( empty( $group_id ) ) {
			//user has no group.
			echo '<h3>You do not have a group selected.</h3> 
					<p>To create or select one go here: <a href="' . get_site_url() . '/dashboard">Dashboard</a></p>
					<p>To see the Zúme course overview go here: <a href="' . get_site_url() . '/overview">Overview</a></p>';
			if ( isset( $_GET['group_id'] ) ) {
				$group = groups_get_group( $_GET['group_id'] );
				echo 'To see the page of the group in the link and request membership click: <a href="' . bp_get_group_permalink( $group ) . '">Here</a></p>';
			}

			return;
		} else {
			// Update or Add meta value with new_group_id
			update_user_meta( $user_id, $meta_key, $group_id );

			// Load Zúme content with variables
			$this->content_loader( $zume_session, $group_id );
		}

		/**
		 * Create switch group link
		 */
		$user_groups = bp_get_user_groups( $user_id, array(
			'is_admin' => null,
			'is_mod'   => null,
		) ); // Check for number of groups

		// Check to select group
		if ( count( $user_groups ) > 1 ) {
			if ( get_user_meta( $user_id, $meta_key, true ) ) {

				$group_id   = get_user_meta( $user_id, $meta_key, true );
				$group      = groups_get_group( $group_id ); // gets group object
				$group_name = $group->name;

				echo '<div class="row columns"><div class="small-centered center"><br><br>(' . $group_name . ')<br><a href="' . get_permalink() . '?id=' . $zume_session . '&switch_zume_group=true" >switch group</a></div></div>';
			}
		}
	}

	/**
	 * Zúme Content Loader
	 * @return mixed
	 */
	public function content_loader( $session = '1', $group_id ) {

		// Check for highest session completed and redirect
		$next_session = zume_group_next_session( $group_id );
		if ( ! is_null( $next_session ) && $session > $next_session ) {
			$session = $next_session;
		}

		echo $this->zume_course_loader( $session, $group_id );

	}

	/**
	 * Pulls the content from the pages database
	 * @return string
	 */
	public function zume_course_loader( $session, $group_id ) {

		$session_title = 'Session ' . $session . ' Course';
		$page_object   = get_page_by_title( $session_title, OBJECT, 'page' );

		$session  = (int) $session;
		$group_id = (int) $group_id;

		$prev_link = null;
		$next_link = null;
		if ( $session > 1 ) {
			$prev_link = '?id=' . ( $session - 1 ) . '&group_id=' . $group_id;
		}
		$group_next_session = zume_group_next_session( $group_id );
		if ( ! is_null( $group_next_session ) && ( $session + 1 ) <= $group_next_session ) {
			$next_link = '?id=' . ( $session + 1 ) . '&group_id=' . $group_id;
		}

		if ( ! empty( $page_object ) || ! empty( $page_object->post_content ) ) {

			$session_title = "Session $session";
			if ( $session == 10 ) {
				$session_title = "Session 10 — Advanced Training";
			}

			$html = '';
			$html .= $this->jquery_steps( $group_id, $session );
			$html .= '<div class="row columns center">';
			if ( ! is_null( $prev_link ) ) {
				$html .= '<a href="' . esc_attr( $prev_link ) . '" title="Previous session"><span class="chevron chevron--left"><span>Previous session</span></span></a> ';
			}
			$html .= '<h2 style="color: #21336A; display: inline">' . $session_title . '</h2>';
			if ( ! is_null( $next_link ) ) {
				$html .= ' <a href="' . esc_attr( $next_link ) . '" title="Next session"><span class="chevron chevron--right"><span>Next session</span></span></a>';
			}
			$html .= '</div>';
			$html .= '<br><div id="session' . $session . '-' . $group_id . '" class="course-steps">';

			if ( zume_group_highest_session_completed( $group_id ) < $session ) {
				$html .= $this->attendance_step( $group_id, $session );
			} // add attendance as the first step

			$post_content = $page_object->post_content . '';
			$post_content = str_replace( "[session_nine_plan]", $this->session_nine_plan(), $post_content );

			$html .= $post_content;
			$html .= '</div>';

			$html .= '<div class="js-group-info" data-group-permalink="' . esc_attr( bp_get_group_permalink( groups_get_group( $group_id ) ) ) . '"></div>';

			return $html;
		} else {
			return 'Please republish "' . $session_title . '" with content for this section in the pages administration area.';
		}
	}

	/**
	 * Enqueue scripts and styles
	 * @return mixed
	 */
	public function zume_scripts_enqueue() {
//		wp_register_script( 'jquery-steps', get_stylesheet_directory_uri() . '/includes/js/jquery.steps.js', array('jquery'), NULL, true );
//		wp_enqueue_script( 'jquery-steps' );
	}

	/**
	 * Get the name of a group by a supplied group id
	 * @return string
	 */
	public function zume_get_group_name( $group_id ) {
		$group = groups_get_group( $group_id ); // gets group object

		return $group->name;
	}

	/**
	 * Jquery Steps with configuration
	 * @return mixed
	 */
	public function jquery_steps( $group_id, $session_number ) {

		// Create variables
		$visited   = true;
		$completed = false;
		$last_step = null;

		$root = home_url( "/wp-json/" );

		$nonce                   = wp_create_nonce( 'wp_rest' );
		$dashboard_complete      = home_url( "/dashboard/" );
		$dashboard_complete_next = home_url( "/zume-training/" ) . '?group_id=' . $group_id . '&id=' . $session_number . '&wp_nonce=' . $nonce;
		$success                 = __( 'Session Complete! Congratulations!', 'zume' );
		$failure                 = __( 'Could not track your progress. Yikes. Tell us and we will tell our geeks to get on it!', 'zume' );

		// Get list of members attending the group
//        $group_members_result = groups_get_group_members( $args = array('group_id' => $group_id, 'exclude_admins_mods' => false) );
//        $group_members_result = '';
		$group_members = array();
//        foreach(  $group_members_result['members'] as $member ) {
//            $group_members[] = $member->ID;
//        }
//        $group_members_ids = implode(", ", $group_members);
		// end Get list of members

		// Create Javascript HTML
		$html = '';
		$html .= '<script>
                    jQuery(document).ready(function() {
                        jQuery("';

		$html .= '#session' . $session_number . '-' . $group_id; // Create selector

		$html .= '").steps({
                    headerTag: "h3",
                    bodyTag: "section",
                    transitionEffect: "fade",
                    saveState: true,
                    autofocus: true,';

		if ( $completed ) {
			$html .= 'enableAllSteps: true,';
		} elseif ( $visited && $last_step != null ) {
			$html .= 'startIndex: ' . $last_step . ',';
		}

		// Fire record creation on step change

		if ( zume_group_highest_session_completed( $group_id ) < $session_number ) {
			$html .= 'onStepChanging: function (event, currentIndex, newIndex) {
                       
                       if (currentIndex === 0) { /* check attendance requirement */
                            var n = jQuery( "input:checked" ).length;
                            if ( n < 4 ) {
                            return false;
                            }
                       }
                       return true;
                       
                    },
                    
                    ';
		}// end html block

		// Fire record creation on step change
		$html .= 'onStepChanged: function (event, currentIndex, priorIndex) {
        
                        if (currentIndex === 1 && priorIndex === 0) { /* record attendance */
                            
                            var members = ' . json_encode( $group_members ) . ';
                            var session = \'' . $session_number . '\';
                            var group_id = \'' . $group_id . '\';
                        
                            var data = {
                                members: members,
                                session: session,
                                group_id: group_id
                            };
                        
                            jQuery.ajax({
                            method: "POST",
                            url: \'' . $root . '\' + \'zume/v1/attendance/log\',
                            data: data,
                            dataType: "json",
                            beforeSend: function ( xhr ) {
                                xhr.setRequestHeader( \'X-WP-Nonce\', \'' . $nonce . '\' );
                            },
                            error : function( jqXHR, textStatus, errorThrown ) {
                                console.log( jqXHR.responseText );
                                
                            }
                
                        });
                        }
                       
                       var title = "Group-" + "' . $group_id . '" + " Step-" + currentIndex + " Session-" + "' . $session_number . '" ;
                       var status = \'publish\';
                       
                       var data = {
                            title: title,
                            status: status
                        }; 
                       
                       jQuery.ajax({
                            method: "POST",
                            url: \'' . $root . '\' + \'wp/v2/steplog\',
                            data: data,
                            dataType: "json",
                            beforeSend: function ( xhr ) {
                                xhr.setRequestHeader( \'X-WP-Nonce\', \'' . $nonce . '\' );
                            },
                            error : function( jqXHR, textStatus, errorThrown ) {
                                console.log( jqXHR.responseText );
                                alert( \'' . $failure . '\' );
                            }
                
                        });
                    },
                    
                    '; // end html block

		// Fire a session completed record creation
		$html .= '  onFinishing: function (event, currentIndex) {

                       var title = "Group-" + "' . $group_id . '" + " Step-Complete" + " Session-" + "' . $session_number . '" ;
                       var excerpt = "' . $session_number . '";
                       var status = \'publish\';
                       
                       var data = {
                            title: title,
                            excerpt: excerpt,
                            status: status
                        }; 
                       
                       jQuery.ajax({
                            method: "POST",
                            url: \'' . $root . '\' + \'wp/v2/steplog\',
                            data: data,
                            dataType: "json",
                            beforeSend: function ( xhr ) {
                                xhr.setRequestHeader( \'X-WP-Nonce\', \'' . $nonce . '\' );
                            },
                            success : function( response ) {
                                
                                window.location.replace("' . $dashboard_complete . '"); 
                            },
                            error : function( jqXHR, textStatus, errorThrown ) {
                                console.log( jqXHR.responseText );
                                alert( \'' . $failure . '\' );
                            }
                
                        });

                    },
                    
                    '; // end html block

		$html .= "  titleTemplate: '<span class=\"number\">#index#</span> #title#'";


		$html .= '    });
                    });
        
                </script>
                '; // end html block

		return $html;
	}

	public function attendance_step( $group_id, $session ) {

		$html = '';
		$html .= '<h3></h3>
                    <section>

                    <div class="row block">
                        <div class="step-title">WHO\'S WITH YOU?</div> <!-- step-title -->
                    </div> <!-- row -->
                    <!-- Activity Block  -->
                    <div class="row "><div class="small-12 medium-6 small-centered columns">
                        ';

		$html .= $this->get_attendance_list( $group_id, $session );

		$html .= '</div></div> <!-- row --> </section>';

		return $html;
	}

	public function get_attendance_list( $group_id, $session ) {
		$html = '';
		$html .= '<style>
                    li.attendance-list {padding:10px;}
                    li#count {text-align:center;}
        </style>';

		if ( bp_group_has_members( array(
			'group_id'   => $group_id,
			'group_role' => array( 'admin', 'mod', 'member' )
		) ) ) :
			$html .= '<ul id="attendance-list" style="list-style-type: none;">';


			while ( bp_group_members() ) : bp_group_the_member();

				$html .= '<li class="attendance-list"><div class="switch" style="width:100px; float:right;">
                          <input class="switch-input" id="member-' . bp_get_group_member_id() . '" type="checkbox" name="' . bp_get_group_member_id() . '">
                          <label class="switch-paddle" for="member-' . bp_get_group_member_id() . '">
                            <span class="show-for-sr">' . bp_get_group_member_name() . '</span>
                          </label>
                          </div>' . bp_get_group_member_name() . '</li>';


			endwhile;
			$html .= '<li id="count"></li>';
			$html .= '</ul>';
		endif;

		$html .= "  <script>
  
                        jQuery(document).ready(function () {
                            
                            var countChecked = function() {
                                var n = jQuery( \"input:checked\" ).length;
                                
                                if( n < 4 ) { 
                                    var missing = 4 - n;  
                                    if (missing === 1) {
                                        jQuery( '#count' ).text( missing + ' more is needed!' );
                                    } else {
                                        jQuery( '#count' ).text( missing + ' more are needed!' );
                                    }
                                } else {
                                    jQuery( '#count' ).text( '' );
                                }
                            };
                            countChecked();
 
                            jQuery( \"input[type=checkbox]\" ).on( \"click\", countChecked );
                            
                        });
    
                    </script>
        ";

		return $html;

	}


	function session_nine_plan( $attr = null ) {
		$form = '<form id="session_nine_plan" action="/wp-admin/admin-post.php" method="post">';
		foreach ( $this->session_nine_labels as $index => $label ) {
			$form = $form . '<label style="font-size:16px">' . $label . '</label>';
			$form = $form . '<textarea name="field_' . $index . '"></textarea>';
		}

		$form = $form . wp_nonce_field( 'session_nine_plan' ) . '
		<input type="hidden" name="action" value="session_nine_plan">
		<input class="button" type="submit" name="submit" value="submit">
		</form>
		';

		return $form;
	}


	/**
	 * Gets all coaches in a particular group, returns an array of integers
	 * @return array
	 */
	function zume_get_coach_ids_in_group( $group_id ) {
		if ( is_numeric( $group_id ) ) {
			$group_id = (int) $group_id;
		} else {
			throw new Exception( "group_id argument should be an integer or pass the is_numeric test: " . $group_id );
		}
		global $wpdb;
		$results = $wpdb->get_results( "SELECT wp_usermeta.user_id FROM wp_bp_groups_members INNER JOIN wp_usermeta ON wp_usermeta.user_id=wp_bp_groups_members.user_id WHERE group_id = '$group_id' AND meta_key = 'wp_capabilities' AND meta_value LIKE '%coach%'", ARRAY_A );
		$rv      = [];
		foreach ( $results as $result ) {
			$rv[] = (int) $result["user_id"];
		}

		return $rv;
	}

	function session_nine_plan_submit() {
		if ( isset( $_POST["_wpnonce"] ) && wp_verify_nonce( $_POST["_wpnonce"], 'session_nine_plan' ) ) {
			$user         = wp_get_current_user();
			$user_id      = get_current_user_id();
			$group_id     = get_user_meta( $user_id, "zume_active_group", true );
			$group        = groups_get_group( $group_id );
			$fields       = [];
			$email_fields = "--------------------------------- \n";
			foreach ( $_POST as $key => $value ) {
				if ( strpos( $key, 'field_' ) !== false ) {
					$index            = str_replace( "field_", "", $key );
					$label            = $this->session_nine_labels[ (int) $index ];
					$fields[ $label ] = $value;
					$email_fields     .= '- ' . str_replace( "_", " ", $label ) . "\n";
					$email_fields     .= '> ' . $value . "\n\n";
				}
			}


			$key = "group_" . $group_id . "-session_9";
			update_user_meta( $user_id, $key, $fields );


			$args = array(
				'tokens' => array(
					"three_month_plan" => $email_fields
				)
			);
			bp_send_email( 'your_three_month_plan', $user_id, $args );

			$coaches = $this->zume_get_coach_ids_in_group( $group_id );

			$user_plan = "--------------------------------- \n";
			$user_plan .= "Here is the plan for: " . ( isset( $user->display_name ) ? $user->display_name : "[user]" ) . ", in group: " . $group->name . "\n";
			$user_plan .= $email_fields;
			$args      = array(
				'tokens' => array(
					"three_month_plan" => $user_plan
				)
			);
			foreach ( $coaches as $coach_id ) {
				bp_send_email( 'your_three_month_plan', $coach_id, $args );
			}
			bp_core_add_message( "Your plan was submitted successfully" );
		}

		return wp_redirect( $_POST["_wp_http_referer"] );
	}

	public static function get_course_content_1() {
		?>

        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">WELCOME TO ZÚME</div>
                <!-- step-title -->
            </div><!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">DOWNLOAD</div>
                <div class="activity-description well">

                    You will be able to follow along on a digital PDF for this session, but please make sure that each
                    member of your group has a printed copy of the materials for future sessions.

                </div>
                <div class="activity-description"><a class="button" style="background-color: #21336a; color: white;"
                                                     href="/wp-content/uploads/zume-guide-4039811470.pdf"
                                                     target="_blank" rel="noopener"><img
                                class="alignnone size-full wp-image-1321"
                                src="https://zumeproject.com/wp-content/uploads/download.png" alt="Download" width="29"
                                height="26"/> GUIDEBOOK</a></div>
            </div>
            <!-- row -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">GROUP PRAYER (5min)</div>

                <!-- Activity Block -->
                <div class="row block single">
                    <div class="activity-description well">

                        Begin with prayer. Spiritual insight and transformation is not possible without the Holy Spirit.
                        Take time as a group to invite Him to guide you over this session.

                    </div>
                </div>
                <!-- row -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">WATCH AND DISCUSS (15min)</div>
                <!-- step-title -->

            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">God uses ordinary people doing simple things to make a big impact.
                    Watch this video on how God works.
                </div>
            </div>

            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/fe3w7ebpl4.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_fe3w7ebpl4"></div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Welcome.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Welcome</a></p>
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">If Jesus intended every one of His followers to obey His Great
                    Commission, why do so few actually make disciples?
                </div>
            </div>
            <!-- row -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">WATCH AND DISCUSS (15min)</div>
                <!-- step-title -->

            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">What is a disciple? And how do you make one? How do you teach a
                    follower of Jesus to do what He told us in His Great Commission &#8212; to obey all of His commands?
                </div>
            </div>

            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/pzq41gvam6.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_pzq41gvam6"></div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Teach_Them_to_Obey.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Teach Them to Obey</a></p>
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol class="rectangle-list">
                        <li>When you think of a church, what comes to mind?</li>
                        <li>What's the difference between that picture and what's described in the video as a "Simple
                            Church"?
                        </li>
                        <li>Which one do you think would be easier to multiply and why?</li>
                    </ol>
                </div>
            </div>
            <!-- row -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">WATCH AND DISCUSS (15min)</div>
                <!-- step-title -->

            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">We breathe in. We breathe out. We're alive. Spiritual Breathing is
                    like that, too.
                </div>
            </div>
            <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/67sh299w6m.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_67sh299w6m"></div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Spiritual_Breathing.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Spiritual Breathing</a>
                    </p>
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol class="rectangle-list">
                        <li>Why is it essential to learn to hear and recognize God's voice?</li>
                        <li>Is hearing and responding to the Lord really like breathing? Why or why not?</li>
                    </ol>
                </div>
            </div>
            <!-- row -->

        </section>
        <h3></h3>
        <section>
            <div class="row block">
                <div class="step-title">LISTEN AND READ ALONG (3min)</div>
                <!-- step-title -->

            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">

                    S.O.A.P.S. BIBLE READING<br><br>

                    Hearing from God regularly is a key element in our personal relationship with Him, and in our
                    ability to stay obediently engaged in what He is doing around us.

                    Find the "S.O.A.P.S. Bible Reading" section in your Zúme Guidebook and listen to the audio overview.

                </div>
            </div>
            <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/i5fwo662go.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_i5fwo662go"></div>
                    <p class="center"><a href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_SOAPS.pdf"
                                         target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: SOAPS</a></p>
                </div>
            </div>
            <!-- row -->
        </section>
        <h3></h3>
        <section>
            <div class="row block">
                <div class="step-title">LISTEN AND READ ALONG (3min)</div>
                <!-- step-title -->

            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">

                    ACCOUNTABILITY GROUPS<br><br>

                    The Bible tells us that every follower of Jesus will one day be held accountable for what we do and
                    say and think. Accountability Groups are a great way to get ready!

                    Find the "Accountability Groups" section in your Zúme Guidebook, and listen to the audio below.

                </div>
            </div>
            <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/1zl3h2clam.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_1zl3h2clam"></div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Accountability_Groups.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Accountability Groups</a>
                </div>
            </div>
            <!-- row -->
        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">PRACTICE (45min)</div>
                <!-- step-title -->

            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">BREAK UP</div>
                <div class="activity-description">Break into groups of two or three people of the same gender.</div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">

                    Spend the next 45 minutes working together through Accountability Questions - List 2 in the
                    "Accountability Groups" section of your
                    <a class="btn btn-large next-step zume-purple uppercase bg-white font-zume-purple big-btn btn-wide"
                       href="/wp-content/uploads/zume-guide-4039811470.pdf" target="_blank" rel="noopener"><i
                                class="glyphicon glyphicon-download-alt"></i> Zúme Guidebook</a>.

                </div>
            </div>
            <!-- row -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">LOOKING FORWARD</div>
                <!-- step-title -->
                <div class="center"><br>Congratulations! You've completed Session 1. <br> Below are next steps to take
                    in preparation for the next session.
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">OBEY</div>
                <div class="activity-description">Begin practicing the S.O.A.P.S. Bible reading between now and your
                    next meeting. Focus on Matthew 5-7, read it at least once a day. Keep a daily journal using the
                    S.O.A.P.S. format.
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">Spend time asking God who He might want you to start an Accountability
                    Group with using the tools you've learned in this session. Share this person’s name with the group
                    before you go. Reach out to that person about starting an Accountabilty Group and meeting with you
                    weekly.
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">PRAY</div>
                <div class="activity-description">Pray that God helps you be obedient to Him and invite Him to work in
                    you and those around you!
                </div>
            </div>
            <!-- row -->

        </section>

		<?php
	}

	public static function get_course_content_2() {
		?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WELCOME BACK!
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>DOWNLOAD</span></div>
                <div class="activity-description">Does everyone have a printed copy of the Zúme Guidebook? If not,
                    please be sure that someone can download the Guidebook and that everyone has access to some paper
                    and a pen or pencil.
                    <br><br>
                    <a href="/wp-content/uploads/zume-guide-4039811470.pdf"
                       class="btn btn-large next-step zume-purple uppercase bg-white font-zume-purple big-btn btn-wide"
                       target="_blank"><i class="glyphicon glyphicon-download-alt"></i> <span> GUIDEBOOK</span></a>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>CHECK-IN</span></div>
                <div class="activity-description">Before getting started, take some time to check-in.<br><br>At the end
                    of the last session, everyone in your group was challenged in two ways: <br><br>
                    <ol>
                        <li>You were asked to begin practicing the S.O.A.P.S. Bible reading method and keeping a daily
                            journal.
                        </li>
                        <li>You were encouraged to reach out to someone about starting an Accountability Group.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRAY</span></div>
                <div class="activity-description">Ask if anyone in the group has specific needs they'd like the group to
                    pray for. Ask someone to pray and ask God to help in the areas the group shared. Be sure to thank
                    God that He promises in His Word to listen and act when His people pray. And, as always, ask God's
                    Holy Spirit to lead your time, together.
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">If we want to make disciples who multiply &#8212; spiritual producers
                    and not just consumers &#8212; then we need to learn and share four main ways God makes everyday
                    followers more like Jesus:<br><br>
                    <ul>
                        <li>Prayer</li>
                        <li>Scripture</li>
                        <li>Body Life</li>
                        <li>Persecution and Suffering</li>
                    </ul>
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/degdhfsycm.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_degdhfsycm">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Producers_vs_Consumers.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Producers vs Consumers</a>
                    </p>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Of the four areas detailed above (prayer, God's Word, etc.), which ones do you already
                            practice?
                        </li>
                        <li> Which ones do you feel unsure about?</li>
                        <li> How ready do you feel when it comes to training others?</li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="row block">
                <div class="step-title">
                    LISTEN AND READ ALONG (2min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">ZÚME TOOLKIT - PRAYER CYCLE<br><br>
                    The Bible tells us that prayer is our chance to speak to and hear from the same God who created
                    us!<br><br>Find the "Prayer Cycle" section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/1995yry849.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_1995yry849">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Prayer_Cycle.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts:Prayer Cycle</a></p>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    PRACTICE THE PRAYER CYCLE (60min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">LEAVE</div>
                <div class="activity-description">Spend the next 60 minutes in prayer individually, using the exercises
                    in "The Prayer Cycle" section of the Zúme Guidebook as a guide.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">RETURN</div>
                <div class="activity-description">Set a time for the group to return and reconnect. Be sure to add a few
                    extra minutes for everyone to both find a quiet place to pray and to make their way back to the
                    group.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>What is your reaction to spending an hour in prayer?</li>
                        <li>How do you feel?</li>
                        <li>Did you learn or hear anything?</li>
                        <li>What would life be like if you made this kind of prayer a regular habit?</li>
                    </ol>
                </div>
            </div>
            <!-- row -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- LISTEN AND READ ALONG -->
            <div class="row block">
                <div class="step-title">
                    LISTEN AND READ ALONG (3min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">ZÚME TOOLKIT - LIST OF 100<br><br>God has already given us the
                    relationships we need to “Go and make disciples.” These are our family, friends, neighbors,
                    co-workers and classmates &#8212; people we’ve known all our lives or maybe just met.<br><br>
                    Being good stewards of these relationships is the first step in multiplying disciples. Start by
                    making a list.<br><br>
                    Find the "List of 100" section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/pzcavp72zy.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_pzcavp72zy">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_List_of_100.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: List of 100</a></p>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">PROJECT (30min)</div>

                <!-- Activity Block  -->
                <div class="row block single">
                    <div class="activity-description well well-lg">CREATE YOUR OWN LIST OF 100<br><br>Have everyone in
                        your group take the next 30 minutes to fill out their own inventory of relationships using the
                        form in the "List of 100" section in your Zúme Guidebook. 
                    </div>
                </div> <!-- row -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING FORWARD
                </div> <!-- step-title -->
                <div class="center"><br>Congratulations on finishing Session 2! <br> Below are next steps to take in
                    preparation for the next session.
                </div>

            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">OBEY</div>
                <div class="activity-description">Spend time this week praying for five people from your List of 100
                    that you marked as an "Unbeliever" or "Unknown." Ask God to prepare their hearts to be open to His
                    story.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">Ask God who He wants you to share the List of 100 tool with. Share
                    this person's name with the group before you go and reach out to them before the next session.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">PRAY</div>
                <div class="activity-description">Pray that God help you be obedient to Him and invite Him to work in
                    you and those around you!
                </div>
            </div> <!-- row -->
        </section>
		<?php
	}

	public static function get_course_content_3() {
		?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING BACK
                </div> <!-- step-title -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>CHECK-IN</span></div>
                <div class="activity-description">Before getting started, take some time to check-in.<br><br>At the end
                    of the last session, everyone in your group was challenged in two ways: <br><br>
                    <ol>
                        <li>You were asked to pray for five people from your List of 100 that you marked as an
                            "Unbeliever" or "Unknown."
                        </li>
                        <li>You were encouraged to share how to make a List of 100 with someone.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRAY</span></div>
                <div class="activity-description">Pray and thank God for the results and invite His Holy Spirit to lead
                    your time together.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>OVERVIEW</span></div>
                <div class="activity-description">In this session, you’ll learn how God’s Spiritual Economy works and
                    how God invests more in those who are faithful with what they've already been given. You'll also
                    learn two more tools for making disciples &#8212; sharing God’s Story from Creation to Judgement and
                    Baptism.<br><br>Then, when you're ready, get started!
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">In this broken world, people feel rewarded when they take, when they
                    receive and when they gain more than those around them. But God's Spiritual Economy is different
                    &#8212; God invests more in those who are faithful with what they've already been given.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/63g4lcmbjf.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_63g4lcmbjf">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Spiritual_Economy.pdf"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Spiritual Economy</a></p>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">What are some differences you see between God's Spiritual Economy and
                    our earthly way of getting things done?
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    READ AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">Jesus said, “You will receive power when the Holy Spirit comes upon
                    you. And you will be my witnesses, telling people about me everywhere &#8212; in Jerusalem,
                    throughout Judea, in Samaria, and to the ends of the earth.”<br><br>
                    Jesus believed in His followers so much, He trusted them to tell His story. Then He sent them around
                    the world to do it. Now, He’s sending us.<br><br>
                    There’s no one “best way” to tell God’s story (also called The Gospel), because the best way will
                    depend on who you’re sharing with. Every disciple should learn to tell God’s Story in a way that’s
                    true to scripture and connects with the audience they’re sharing with.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>What comes to mind when you hear God's command to be His "witness" and to tell His story?
                        </li>
                        <li> Why do you think Jesus chose ordinary people instead of some other way to share His Good
                            News?
                        </li>
                        <li>What would it take for you to feel more comfortable sharing God's Story?</li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">One way to share God’s Good News is by telling God’s Story from
                    Creation to Judgement &#8212; from the beginning of humankind all the way to the end of this age.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/0qq5iq8b2i.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_0qq5iq8b2i">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Creation_to_Judgement.pdf"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Creation to Judgement</a>
                    </p>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>What do you learn about mankind from this story?</li>
                        <li>What do you learn about God?</li>
                        <li>Do you think it would be easier or harder to share God's Story by telling a story like
                            this?
                        </li>
                    </ol>
                </div>
            </div> <!-- row -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">PRACTICE SHARING GOD'S STORY (45min)</div>

                <div class="row block single">
                    <!-- Activity Block  -->
                    <div class="activity-description well">Break into groups of two or three people and spend the next
                        45 minutes practicing telling God's Story using the Activity instructions on page 13 of your
                        Zúme Guidebook.
                    </div>
                </div>
                <!-- row -->

        </section>
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    READ AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">ZÚME TOOLKIT - BAPTISM<br><br>
                    Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the Father and of
                    the Son and of the Holy Spirit…”<br><br>
                    Find the "Baptism" section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/v8p5mbpdp5.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_v8p5mbpdp5">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Baptism.pdf"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Baptism</a></p>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Have you ever baptized someone?</li>
                        <li>Would you even consider it?</li>
                        <li> If the Great Commission is for every follower of Jesus, does that mean every follower is
                            allowed to baptize others? Why or why not?
                        </li>
                    </ol>
                </div>
            </div> <!-- row -->
            <div class="row block single">
                <div class="activity-description well">IMPORTANT REMINDER &#8212; Have you been baptized? If not, then
                    we encourage you to plan this before even one more session of this training. Invite your group to be
                    a part of this important day when you celebrate saying "yes" to Jesus.
                </div>
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING FORWARD
                </div> <!-- step-title -->
                <div class="center"><br>Congratulations on finishing Session 3! <br> Below are next steps to take in
                    preparation for the next session.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">OBEY</div>
                <div class="activity-description">Spend time this week practicing God's Story, and then share it with at
                    least one person from your List of 100 that you marked as "Unbeliever" or "Unknown."
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">Ask God who He wants you to train to use the Creation to Judgment
                    story (or some other way to share God's Story). Share this person's name with the group before you
                    go.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">PRAY</div>
                <div class="activity-description">Pray that God help you be obedient to Him and invite Him to work in
                    you and those around you!
                </div>
            </div> <!-- row -->
            <div class="row block single">
                <div class="activity-description well">IMPORTANT REMINDER - Your group will be celebrating the Lord's
                    Supper next session. Be sure to remember the supplies (bread and wine / juice).
                </div>
            </div>
        </section>
		<?php
	}

	public static function get_course_content_4() {
		?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING BACK
                </div> <!-- step-title -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>CHECK-IN</span></div>
                <div class="activity-description">At the end of the last session, everyone in your group was challenged
                    in two ways:<br><br>
                    <ol>
                        <li>You were asked to share God’s Story with at least one person from your List of 100 that you
                            marked as "Unbeliever" or "Unknown."
                        </li>
                        <li>You were encouraged to train someone to use the Creation to Judgement story (or some other
                            way to share God’s Story) with someone.
                        </li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRAY</span></div>
                <div class="activity-description">Pray and thank God for the results and invite His Holy Spirit to lead
                    your time together.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>OVERVIEW</span></div>
                <div class="activity-description">In this session, you'll learn how God's plan is for every follower to
                    multiply! You’ll discover how disciples multiply far and fast when they start to see where God’s
                    Kingdom isn’t. And, you'll learn another great tool for inviting others into God's family is as
                    simple as telling our story.<br><br>Then, when you're ready, get started!
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- LISTEN AND READ ALONG -->

            <div class="row block">
                <div class="step-title">
                    LISTEN AND READ ALONG (3min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">ZÚME TOOLKIT - 3-MINUTE TESTIMONY<br><br>As followers of Jesus, we are
                    “witnesses" for Him, because we “testify” about the impact Jesus has had on our lives. Your story of
                    your relationship with God is called your Testimony. It's powerful, and it's something no one can
                    share better than you.<br><br>Find the "3-Minute Testimony" section in your Zúme Guidebook, and
                    listen to the audio below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/kwhpgugafp.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_kwhpgugafp">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Testimony.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Testimony</a></p>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    PRACTICE SHARING YOUR TESTIMONY (45min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block single">
                <div class="activity-description well">Break into groups of two or three and and spend the next 45
                    minutes practicing sharing your Testimony using the Activity instructions on page 15 of your Zúme
                    Guidebook.
                </div>
            </div> <!-- row -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">What is God's greatest blessing for His children? Making disciples who
                    multiply! <br><br>What if you could learn a simple pattern for making not just one follower of Jesus
                    but entire spiritual families who multiply for generations to come?
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/qbfpcb1ta8.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_qbfpcb1ta8">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Greatest_Blessing.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Greatest Blessing</a></p>
                </div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Is this the pattern you were taught when you first began to follow Jesus? If not, what was
                            different?
                        </li>
                        <li>After you came to faith, how long was it before you began to disciple others?</li>
                        <li> What do you think would happen if new followers started sharing and discipling others,
                            immediately?
                        </li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">What do ducklings have to do with disciple making? They lead and
                    follow at the same time.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/5c15dgdv3d.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_5c15dgdv3d">&nbsp;</div>
                    <p class="center"><a href="https://zumeproject.com/wp-content/uploads/Duckling-discipleship.pdf"
                                         target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Duckling Discipleship</a>
                    </p>
                </div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>What is one area of discipleship (reading/understanding the Bible, praying, sharing God's
                            Story, etc.) that you want to learn more about? Who is someone that could help you learn?
                        </li>
                        <li> What is one area of discipleship that you feel you could share with others? Who is someone
                            that you could share with?
                        </li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">Have you ever stopped to think about where God's Kingdom... isn't?<br><br>Have
                    you ever visited a home or a neighborhood or even a city where it seemed as if God was just...
                    missing? These are usually the places where God wants to work the most.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/aii2k283nk.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_aii2k283nk">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Eyes_to_See.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Eyes to See</a></p>
                </div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Who are you more comfortable sharing with &#8212; people you already know or people you
                            haven't met, yet?
                        </li>
                        <li>Why do you think that is?</li>
                        <li>How could you get better at sharing with people you're less comfortable with?</li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="row block">
                <div class="step-title">
                    LISTEN AND READ ALONG (3min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">ZÚME TOOLKIT - THE LORD'S SUPPER<br><br>Jesus said, “I am the living
                    bread that came down from heaven. Whoever eats this bread will live forever. This bread is my flesh,
                    which I will give for the life of the world.”<br><br>Find "The Lord's Supper" section in your Zúme
                    Guidebook, and listen to the audio below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/t3xr5w43av.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_t3xr5w43av">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Lord_s_Supper.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Lord's Supper</a></p>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    PRACTICE THE LORD'S SUPPER (10min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block single">
                <div class="activity-description well">Spend the next 10 minutes celebrating The Lord's Supper with your
                    group using the pattern on page 15 of your Zúme Guidebook.
                </div>
            </div> <!-- row -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING FORWARD
                </div> <!-- step-title -->
                <div class="center"><br>Congratulations on finishing Session 4! <br> Below are next steps to take in
                    preparation for the next session.
                </div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">OBEY</div>
                <div class="activity-description">Spend time this week practicing your 3-Minute Testimony, and then
                    share it with at least one person from your List of 100 that you marked as "Unbeliever" or
                    "Unknown."
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">Ask God who He wants you to train with the 3-Minute Testimony tool.
                    Share this person's name with the group before you go.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">PRAY</div>
                <div class="activity-description">Pray that God help you be obedient to Him and invite Him to work in
                    you and those around you!
                </div>
            </div> <!-- row -->
        </section>
		<?php
	}

	public static function get_course_content_5() {
		?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING BACK
                </div> <!-- step-title -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>CHECK-IN</span></div>
                <div class="activity-description">At the end of the last session, everyone in your group was challenged
                    in two ways: <br><br>
                    <ol>
                        <li>You were asked to share your 3-Minute Testimony with at least one person on your List of
                            100.
                        </li>
                        <li>You were encouraged to train someone else with the 3-Minute Testimony tool.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRAY</span></div>
                <div class="activity-description">Pray and thank God for the results and invite His Holy Spirit to lead
                    your time together.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>OVERVIEW</span></div>
                <div class="activity-description">In this session, you’ll learn how Prayer Walking is a powerful way to
                    prepare a neighborhood for Jesus, and you'll learn a simple but powerful pattern for prayer that
                    will help you meet and make new disciples along the way.
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="row block">
                <div class="step-title">
                    LISTEN AND READ ALONG (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">ZÚME TOOLKIT - PRAYER WALKING<br><br>Prayer Walking is a simple way to
                    obey God’s command to pray for others. And it's just what it sounds like &#8212; praying to God
                    while walking around!<br><br>Find the "Prayer Walking" section in your Zúme Guidebook, and listen to
                    the audio below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/ltxoicq440.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_ltxoicq440">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Prayer_Walking.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Prayer Walking</a></p>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">Disciple-making can be rapidly advanced by finding a person of peace,
                    even in a place where followers of Jesus are few and far between. How do you know when you have
                    found a person of peace and what do you when you find them?
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/zhzf9v1g92.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_zhzf9v1g92">&nbsp;</div>
                    <p class="center"><a href="https://zumeproject.com/wp-content/uploads/Person-of-Peace.pdf"
                                         target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Person of Peace</a></p>
                </div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Can someone who has a "bad reputation" (like the Samaritan woman or the demon-possessed man
                            in the Gadarenes) really be a Person of Peace? Why or why not?
                        </li>
                        <li>What is a community or segment of society near you that seems to have little (or no) Kingdom
                            presence? How could a Person of Peace (someone who is OPEN, HOSPITABLE, KNOWS OTHERS and
                            SHARES) accelerate the spread of the Gospel in that community?
                        </li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>


        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    PRACTICE THE B.L.E.S.S. PRAYER (15min)

                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block single">
                <div class="activity-description well">Break into groups of two or three and spend the next 15 minutes
                    practicing the B.L.E.S.S. Prayer using the pattern on page 17 of your Zúme Guidebook. Practice
                    praying the five areas of the B.L.E.S.S. Prayer for someone AND practice how you would train others
                    to understand and use the B.L.E.S.S. Prayer, too.
                </div>
            </div> <!-- row -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    PRACTICE PRAYER WALKING (60-90min)

                </div> <!-- row --><!-- Activity Block  -->
                <div class="row block">
                    <div class="activity-title">ACTIVITY</div>
                    <div class="activity-description">Break into groups of two or three and go out into the community to
                        practice Prayer Walking. <br><br>Choosing a location can be as simple as walking outside from
                        where you are now, or you could plan to go to a specific destination. <br><br>Go as God leads,
                        and plan on spending 60-90 minutes on this activity.
                    </div>
                </div> <!-- row -->
                <!-- Step Title -->
                <div class="row block">
                    <div class="step-title">
                        LOOKING FORWARD
                    </div> <!-- step-title -->
                    <div class="center">


                        <br> The session ends with a prayer walking activity. <br> Read through the Obey, Share, and
                        Pray sections, below, before you head out!
                    </div>
                </div> <!-- row -->
                <!-- Activity Block  -->
                <div class="row block">
                    <div class="activity-title">OBEY</div>
                    <div class="activity-description">Spend time this week practicing Prayer Walking by going out alone
                        or with a small group at least once.
                    </div>
                </div> <!-- row -->
                <!-- Activity Block  -->
                <div class="row block">
                    <div class="activity-title">SHARE</div>
                    <div class="activity-description">Spend time asking God who He might want you to share the Prayer
                        Walking tool with before your group meets again. Share this person’s name with the group before
                        you go.
                    </div>
                </div> <!-- row -->
                <!-- Activity Block  -->
                <div class="row block">
                    <div class="activity-title">PRAY</div>
                    <div class="activity-description">Before you go out on your Prayer Walking activity, be sure to pray
                        with your group to end your time together. Thank God that He loves the lost, the last and the
                        least &#8212; including us! Ask Him to prepare your heart and the heart of those you'll meet
                        during your walk to be open to His work.
                    </div>
                </div> <!-- row -->
        </section>
		<?php
	}

	public static function get_course_content_6() {
		?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING BACK
                </div> <!-- step-title -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>CHECK-IN</span></div>
                <div class="activity-description">At the end of the last session, everyone in your group was challenged
                    in two ways: <br><br>
                    <ol>
                        <li>You were asked to spend some time Prayer Walking</li>
                        <li>You were encouraged to share the Prayer Walking tool with someone else.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRAY</span></div>
                <div class="activity-description">Pray and thank God for the results, ask Him to help when you find it
                    hard to obey, and invite His Holy Spirit to lead your time together.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>OVERVIEW</span></div>
                <div class="activity-description">In this session, you’ll learn how God uses faithful followers &#8212;
                    even if they're brand new &#8212; much more than ones with years of knowledge and training who just
                    won't obey. And you'll get a first look at a way to meet together that helps disciples multiply even
                    faster.
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">When we help multiply disciples, we need to make sure we're
                    reproducing the right things. It's important what disciples know &#8212; but it's much more
                    important what they DO with what they know.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/yk0i0eserm.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_yk0i0eserm">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Faithfulness.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Faithfulness</a></p>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">Think about God's commands that you already know. How "faithful" are
                    you in terms of obeying and sharing those things?
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="row block">
                <div class="step-title">
                    LISTEN AND READ ALONG (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">ZÚME TOOLKIT - 3/3 GROUPS FORMAT<br><br>Jesus said, “Where two or
                    three have gathered together in My name, I am there in their midst.”<br><br>Find the "3/3 Group
                    Format" section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/xnhyl1o17z.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_xnhyl1o17z">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_3_3_Group.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: 3/3 Group</a></p>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Did you notice any differences between a 3/3 Group and a Bible Study or Small Group you've
                            been a part of (or have heard about) in the past? If so, how would those differences impact
                            the group?
                        </li>
                        <li>Could a 3/3 Group be considered a Simple Church? Why or why not?</li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    MODEL 3/3 GROUP
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">A 3/3 Group is a way for followers of Jesus to meet, pray, learn,
                    grow, fellowship and practice obeying and sharing what they've learned. In this way a 3/3 Group is
                    not just a small group but a Simple Church.<BR><BR> In the following video, you'll see a model 3/3
                    Group meet together and practice this format.<br><br>Find the "3/3 Groups Format" section in your
                    Zúme Guidebook, and watch the video below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/s4shprhr4l.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_s4shprhr4l">&nbsp;</div>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING FORWARD
                </div> <!-- step-title -->
                <div class="center"><br>Congratulations on finishing Session 6! <br> Below are next steps to take in
                    preparation for the next session.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">OBEY</div>
                <div class="activity-description">Spend time this week practicing Faithfulness by obeying and sharing at
                    least one of God's commands that you already know.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">Think about what you have heard and learned about Faithfulness in this
                    session, and ask God who He wants you to share it with. Share this person’s name with the group
                    before you go.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">PRAY</div>
                <div class="activity-description">Thank God for His Faithfulness &#8212; for fulfilling every promise
                    He's ever made. Ask Him to help you and your group become even more Faithful to Him.
                </div>
            </div> <!-- row -->
        </section>
		<?php
	}

	public static function get_course_content_7() {
		?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING BACK
                </div> <!-- step-title -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>CHECK-IN</span></div>
                <div class="activity-description">At the end of the last session, everyone in your group was challenged
                    in two ways: <br><br>
                    <ol>
                        <li>You were asked to practice Faithfulness by obeying and sharing one of God's commands.</li>
                        <li>You were encouraged to share the importance of Faithfulness with someone else.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRAY</span></div>
                <div class="activity-description">Pray and thank God for the group's commitment to faithfully following
                    Jesus and invite God's Holy Spirit to lead your time together.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>OVERVIEW</span></div>
                <div class="activity-description">In this session, you’ll learn a Training Cycle that helps disciples go
                    from one to many and turns a mission into a movement. You'll also practice the 3/3 Groups Format and
                    learn how the way you meet can impact the way you multiply.
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">Have you ever learned how to ride a bicycle? Have you ever helped
                    someone else learn? If so, chances are you already know the Training Cycle.<br><br>Find the
                    "Training Cycle" section in your Zúme Guidebook. When you're ready, watch this video, and then
                    discuss the questions below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/ziw8qxj7zj.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_ziw8qxj7zj">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Training_Cycle.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Training Cycle</a></p>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Have you ever been a part of a Training Cycle?</li>
                        <li> Who did you train? Or who trained you?</li>
                        <li>Could the same person be at different parts of the Training Cycle while learning different
                            skills?
                        </li>
                        <li>What would it look like to train someone like that?</li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    PRACTICE AND DISCUSS (90min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRACTICE</span></div>
                <div class="activity-description">Have your entire group spend the next 90 minutes practicing the 3/3
                    Groups Format using the pattern on pages 19-20 in your Zúme Guidebook.<br><br>
                    <ul>
                        <li>LOOK BACK - Use last week's Session Challenges to practice "Faithfulness" in the Look Back
                            section.
                        </li>
                        <li>LOOK UP - Use Mark 5:1-20 as your group's reading passage and answer questions 1-4 during
                            the Look Up section.
                        </li>
                        <li>LOOK FORWARD - Use questions 5, 6, and 7 in the Look Forward section to develop how you will
                            Obey, Train and Share.
                        </li>
                    </ul>
                    <br>
                    REMEMBER - Each section should take about 1/3 (or 30 minutes) of your practice time.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>DISCUSS</span></div>
                <div class="activity-description">
                    <ol>
                        <li>What did you like best about the 3/3 Group? Why?</li>
                        <li> What was the most challenging? Why?</li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING FORWARD
                </div> <!-- step-title -->
                <div class="center"><br>Congratulations on finishing Session 7! <br> Below are next steps to take in
                    preparation for the next session.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">OBEY</div>
                <div class="activity-description">Spend time this week obeying, training, and sharing based on the
                    commitments you've made during your 3/3 Group practice.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">Pray and ask God who He wants you to share the 3/3 Group format with
                    before your group meets again. Share this person’s name with the group before you go.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">PRAY</div>
                <div class="activity-description">Thank God that He loves us enough to invite us into His most important
                    work &#8212; growing His family!
                </div>
            </div> <!-- row -->
        </section>
		<?php
	}

	public static function get_course_content_8() {
		?>
        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING BACK
                </div> <!-- step-title -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>CHECK-IN</span></div>
                <div class="activity-description">Before getting started, take some time to check-in.<br><br>At the end
                    of the last session, everyone in your group was challenged in two ways: <br><br>
                    <ol>
                        <li>You were asked to practice obeying, training, and sharing based on your commitments during
                            3/3 Group practice.
                        </li>
                        <li>You were encouraged to share the 3/3 Group Format with someone else.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRAY</span></div>
                <div class="activity-description">Pray and thank God for giving your group the energy, the focus and the
                    faithfulness to come so far in this training. Ask God to have His Holy Spirit remind everyone in the
                    group that they can do nothing without Him!
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>OVERVIEW</span></div>
                <div class="activity-description">In this session, you’ll learn how Leadership Cells prepare followers
                    in a short time to become leaders for a lifetime. You'll learn how serving others is Jesus' strategy
                    for leadership. And you'll spend time practicing as a 3/3 Group, again.
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">Jesus said, “Whoever wishes to become great among you shall be your
                    servant.”
                    <br><br>
                    Jesus radically reversed our understanding of leadership by teaching us that if we feel called to
                    lead, then we are being called to serve. A Leadership Cell is a way someone who feels called to lead
                    can develop their leadership by practicing serving.
                    <br><br>
                    Find the "Leadership Cells" section in your Zúme Guidebook. When you're ready, watch and discuss
                    this video.
                </div>
            </div> <!-- row -->
            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/lnr64mh2bg.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_lnr64mh2bg">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Leadership_Cells.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Leadership Cells</a></p>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Is there a group of followers of Jesus you know that are already meeting or would be willing
                            to meet and form a Leadership Cell to learn Zúme Training?
                        </li>
                        <li> What would it take to bring them together?</li>
                    </ol>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    PRACTICE A 3/3 GROUP SESSION (90min)
                </div> <!-- step-title --><br>
                <div class="center"><!-- row -->

                    <!-- Activity Block  -->
                    <div class="row block">
                        <div class="activity-title"><span>PRACTICE</span></div>
                        <div class="activity-description">Have your entire group spend the next 90 minutes practicing
                            the 3/3 Groups Format using the pattern on pages 19-20 in your Zúme Guidebook.<br><br>
                            <ul>
                                <li>LOOK BACK - Use last session’s Obey, Train, and Share challenges to check-in with
                                    each other.
                                </li>
                                <li>LOOK UP - Use Acts 2:42-47 as your group’s reading passage and answer questions 1-
                                    4.
                                </li>
                                <li>LOOK FORWARD - Use questions 5, 6, and 7 to develop how you will Obey, Train and
                                    Share.
                                </li>
                            </ul>
                            <br>
                            REMEMBER - Each section should take about 1/3 (or 30 minutes) of your practice time.
                        </div>
                    </div> <!-- row -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING FORWARD
                </div> <!-- step-title -->
                <div class="center"><br>Congratulations! You've completed Session 8. <br> Below are next steps to take
                    in preparation for the next session.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">OBEY</div>
                <div class="activity-description">Spend time again this week obeying, sharing, and training based on the
                    commitments you've made during this session's 3/3 Group practice.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">Pray and ask God who He wants you to share the Leadership Cell tool
                    with before your group meets again. Share this person’s name with the group before you go.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">PRAY</div>
                <div class="activity-description">Thank God for sending Jesus to show us that real leaders are real
                    servants. Thank Jesus for showing us the greatest service possible is giving up our own lives for
                    others.
                </div>
            </div> <!-- row -->
        </section>

		<?php
	}

	public static function get_course_content_9() {
		?>

        <!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">LOOKING BACK</div>
                <!-- step-title -->
                <div class="center">
                    Welcome back to Zúme Training!
                </div>
            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">CHECK-IN</div>
                <div class="activity-description">

                    Before getting started, take some time to check-in.

                    At the end of the last session, everyone in your group was challenged in two ways:
                    <ol>
                        <li>You were asked to practice Obeying, Training, and Sharing based on your commitments during
                            last session's 3/3 Group practice.
                        </li>
                        <li>You were encouraged to share the Leadership Cells tool with someone else.</li>
                    </ol>
                    Take a few moments to see how your group did this week.

                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">PRAY</div>
                <div class="activity-description">Pray and thank God that His ways are not our ways and His thoughts are
                    not our thoughts. Ask Him to give each member of your group the mind of Christ — always focused on
                    His Father's work. Ask the Holy Spirit to lead your time together and make it the best session yet.
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">OVERVIEW</div>
                <div class="activity-description">In this session, you’ll learn how linear patterns hold back kingdom
                    growth and how Non-Sequential thinking helps you multiply disciples. You'll discover how much time
                    matters in disciple-making and how to accelerate Pace. You’ll learn how followers of Jesus can be a
                    Part of Two Churches to help turn faithful, spiritual families into a growing city-wide body of
                    believers. Finally, you'll learn how a simple 3-Month Plan can focus your efforts and multiply your
                    effectiveness in growing God's family exponentially.
                </div>
            </div>
            <!-- row -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">WATCH AND DISCUSS (15min)</div>
                <!-- step-title -->

            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">When people think about disciples multiplying, they often think of it
                    as a step-by-step process. The problem with that is — that's not how it works best!
                </div>
            </div>
            <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/1rydt7j3ds.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_1rydt7j3ds"></div>
                </div>
                <p class="center"><a
                            href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Non_Sequential.pdf"
                            target="_blank" rel="noopener"><img class="alignnone size-thumbnail wp-image-3274"
                                                                style="vertical-align: text-bottom;"
                                                                src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png"
                                                                alt="" width="35" height="35"/> Zúme Video Scripts:
                        Non-Sequential</a></p>

            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>What is the most exciting idea you heard in this video? Why?</li>
                        <li>What is the most challenging idea? Why?</li>
                    </ol>
                </div>
            </div>
            <!-- row -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">WATCH AND DISCUSS (15min)</div>
                <!-- step-title -->

            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">Multiplying matters and multiplying quickly matters even more. Pace
                    matters because where we all spend our eternity — an existence that outlasts time — is determined in
                    the very short time we call “life."
                </div>
            </div>
            <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/42tm77n9aq.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_42tm77n9aq"></div>
                </div>
                <p class="center"><a href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Pace.pdf"
                                     target="_blank" rel="noopener"><img class="alignnone size-thumbnail wp-image-3274"
                                                                         style="vertical-align: text-bottom;"
                                                                         src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png"
                                                                         alt="" width="35" height="35"/> Zúme Video
                        Scripts: Pace</a></p>

            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Why is pace important?</li>
                        <li>What do you need to change in your thinking, your actions, or your attitude to be better
                            aligned with God's priority for pace?
                        </li>
                        <li>What is one thing you can do starting this week that will make a difference?</li>
                    </ol>
                </div>
            </div>
            <!-- row -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">WATCH AND DISCUSS (15min)</div>
                <!-- step-title -->

            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">Jesus taught us that we are to stay close — to live as a small,
                    spiritual family, to love and give our lives to one another, to celebrate and suffer — together.
                    However, Jesus also taught us to leave our homes and loved ones behind and be willing to go anywhere
                    — and everywhere — to share and start new spiritual families.

                    So how can we do both?

                    When you're ready, watch the video below and discuss the question that follows.
                </div>
            </div>
            <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/nna7r761vo.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_nna7r761vo"></div>
                </div>
                <p class="center"><a
                            href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Two_Churches.pdf"
                            target="_blank" rel="noopener"><img class="alignnone size-thumbnail wp-image-3274"
                                                                style="vertical-align: text-bottom;"
                                                                src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png"
                                                                alt="" width="35" height="35"/> Zúme Video Scripts: Two
                        Churches</a></p>

            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">What are some advantages of maintaining a consistent spiritual family
                    that gives birth to new ones that grow and multiply instead of continually growing a family and
                    splitting it in order to grow?
                </div>
            </div>
            <!-- row -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">CREATE A 3-MONTH PLAN (30min)</div>
                <!-- step-title -->
                <div class="center">

                    <!-- row -->

                    <!-- Activity Block -->
                    <div class="row block">
                        <div class="activity-title">OVERVIEW</div>
                        <div class="activity-description">In His Bible, God says, "I know the plans I have for you,
                            plans to prosper you and not to harm you, plans to give you hope and a future."

                            God makes plans, and He expects us to make plans, too. He teaches us through His Word and
                            His work to look ahead, see a better tomorrow, make a plan for how to get there, and then
                            prepare the resources we'll need on the way.

                            A 3-Month Plan is a tool you can use to help focus your attention and efforts and keep them
                            aligned with God's priorities for making disciples who multiply.

                            Spend the next 30 minutes praying over, reading through, and then completing the commitments
                            listed in the 3-Month Plan section in your Zúme Guidebook.
                        </div>
                    </div>
                    <!-- row -->
                    <!-- Activity Block -->
                    <div class="row block">
                        <div class="activity-title">PRAY</div>
                        <div class="activity-description">Ask God what He specifically wants you to do with the basic
                            disciple-making tools and techniques you have learned over these last nine sessions.
                            Remember His words about Faithfulness.
                        </div>
                    </div>
                    <!-- row -->
                    <!-- Activity Block -->
                    <div class="row block">
                        <div class="activity-title">LISTEN</div>
                        <div class="activity-description">Take at least 10 minutes to be as quiet as possible and listen
                            intently to what God has to say and what He chooses to reveal. Make an effort to hear His
                            voice.
                        </div>
                    </div>
                    <!-- row -->
                    <!-- Activity Block -->
                    <div class="row block">
                        <div class="activity-title">COMPLETE</div>
                        <div class="activity-description">Use the rest of your time to complete the 3-Month Plan
                            worksheet. You do not have to commit to every item, and there is room for other items not
                            already on the list. Do your best to align your commitments to what you have heard God
                            reveal to you about His will.
                        </div>
                    </div>
                    <!-- row -->

                </div>
            </div>
        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">ACTIVITY (30min)</div>
                <!-- step-title -->
                <div class="center">
                    SHARE YOUR PLAN AND PLAN AS A TEAM.
                </div>
            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">IN GROUPS OF TWO OR THREE (15 minutes)

                    Take turns sharing your 3-Month Plans with each other. Take time to ask questions about things you
                    might not understand about plans and how the others will meet their commitments. Ask them to do the
                    same for you and your plan.

                    Find a training partner(s) that is willing to check in with you to report on progress and challenges
                    and ask questions after 1, 2, 3, 4, 6, 8 and 12 weeks. Commit to doing the same for them.
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">IN YOUR FULL TRAINING GROUP (15 minutes)

                    Discuss and develop a group plan for starting at least two new 3/3 Groups or Zúme Training Groups in
                    your area. Remember, your goal is start Simple Churches that multiply. 3/3 Groups and Zúme Training
                    Groups are two ways to do that.

                    Discuss and decide whether these new Groups will be connected to an existing local church or network
                    or whether you’ll start a new network out of your Zúme Training Group.
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">CONNECT</div>
                <div class="activity-description">CONNECT WITH YOUR COACH

                    Make sure all group members know how to contact the Zúme Coach that’s been assigned to your group in
                    case anyone has questions or needs more training. Remember to share your 3-Month Plan with your
                    Coach, so they understand your goals.

                    Discuss any other locations where members of your group could help launch new 3/3 Groups or Zúme
                    Training Groups.

                    Be sure to pray as a group and ask God for His favor to bring about all the good work possible out
                    of these plans and commitments.
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">SEND</div>
                <div class="activity-description">

                    SUBMIT YOUR 3-MONTH PLAN

                    Any individual in your group can go login right now (if you’re not already) and send your 3-month
                    plan to your coach by filling out this webform. We will also email you a digital copy of your plan.

                    Feel feel free to contact your coach to discuss your plan or ask questions at any time.
                    <div style="text-align: center;">
                        <button class="button show-session-9-form" style="font-size: 20px;">Fill in my 3-Month Plan
                        </button>
                    </div>
                    <div class="session-9-plan-form" style="display: none;">[session_nine_plan]</div>
                </div>
            </div>
            <!-- row -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="row block">
                <div class="step-title">LOOKING FORWARD</div>
                <!-- step-title -->
                <div class="center">
                    Congratulations! You've completed Session 9.
                </div>
            </div>
            <!-- row -->

            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">You may not know it, but you now have more practical training on
                    starting simple churches and making disciples who multiply than many pastors and missionaries around
                    the world!

                    Watch the following video and celebrate all that you've learned!
                </div>
            </div>
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/h3znainxm9.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_h3znainxm9"></div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Completion_of_Training.pdf"
                                target="_blank" rel="noopener"><img class="alignnone size-thumbnail wp-image-3274"
                                                                    style="vertical-align: text-bottom;"
                                                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png"
                                                                    alt="" width="35" height="35"/> Zúme Video Scripts:
                            Completion of Training</a></p>

                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">OBEY</div>
                <div class="activity-description">Set aside time on your calendar each week to continue to work on your
                    3-Month Plan, and plan check-ins with your training partner at the end of week 1, 2, 3, 4, 6, 8, and
                    12. Each time you're together, ask about their results and share yours, making sure you're both
                    working through your plans.

                    Prayerfully consider continuing as an ongoing spiritual family committed to multiplying disciples.
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">SHARE</div>
                <div class="activity-description">Pray and ask God who He would have you share Zúme Training with by
                    launching a Leadership Cell of future Zúme Training leaders.
                </div>
            </div>
            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">PRAY</div>
                <div class="activity-description">Be sure to pray with your group before you end your time together.
                    Thank God that He has created and gifted you with exactly the right talents to make a difference in
                    His kingdom. Ask Him for wisdom to use the strengths He has given you and to find other followers
                    who help cover your weaknesses. Pray that He would make you fruitful and multiply — this was His
                    plan from the very beginning. Pray that God help you be obedient to Him and invite Him to work in
                    you and those around you!
                </div>
            </div>
            <!-- row -->

            <!-- row -->
            <!-- Activity Block -->
            <div class="row block">
                <div class="activity-title">BONUS</div>
                <div class="activity-description">Check out <a href="https://www.2414now.net" target="_blank">www.2414now.net</a>
                    and join the global coalition praying and working together to start kingdom movement engagements in
                    every unreached people and place by 2025.
                </div>
            </div>
            <!-- row -->

            <!-- row -->
            <!-- Activity Block -->

        </section>
		<?php
	}

	public static function get_course_content_10() {
		?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    LOOKING BACK
                </div> <!-- step-title -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>CHECK-IN</span></div>
                <div class="activity-description">Before getting started, take some time to check-in.<br><br>At the end
                    of the last session, everyone in your group was challenged in two ways: <br><br>
                    <ol>
                        <li>You were asked to prayerfully consider continuing as an ongoing spiritual family committed
                            to multiplying disciples.
                        </li>
                        <li>You were encouraged to share Zúme Training by launching a Leadership Cell of future Zúme
                            Training leaders.
                        </li>
                    </ol>
                    Take a few moments to see how your group has been doing with these items and their 3-Month Plans
                    since you've last met.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRAY</span></div>
                <div class="activity-description">Pray and thank God that He is faithful to complete His good work in
                    us. Ask Him to give your group clear heads and open hearts to the great things He wants to do in and
                    through you. Ask the Holy Spirit to lead your time together and thank Him for His faithfulness, too.
                    He got you through!
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>OVERVIEW</span></div>
                <div class="activity-description">In this advanced training session, you’ll take a look at how you can
                    level-up your Coaching Strengths with a quick checklist assessment. You’ll learn how Leadership in
                    Networks allows a growing group of small churches to work together to accomplish even more. And
                    you’ll learn how to develop Peer Mentoring Groups that take leaders to a whole new level of growth.
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    ACTIVITY (10min)
                </div> <!-- step-title -->
                <div class="center"><br>ASSESS YOURSELF USING THE COACHING CHECKLIST.</div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">ASSESS</div>
                <div class="activity-description">The Coaching Checklist is a powerful tool you can use to quickly
                    assess your own strengths and vulnerabilities when it comes to making disciples who multiply. It's
                    also a powerful tool you can use to help others &#8212; and others can use to help you.<br><br>
                    Find the Coaching Checklist section in your Zúme Guidebook, and take this quick (5-minutes or less)
                    self-assessment:<br><br>
                    <ol>
                        <li>Read through the Disciple Training Tools in the far left column of the Checklist.</li>
                        <li>Mark each one of the Training Tools, using the following method:
                            <ul>
                                <li> If you're unfamiliar or don't understand the Tool &#8212; check the BLACK column
                                </li>
                                <li>If you're somewhat familiar but still not sure about the Tool &#8212; check the RED
                                    column
                                </li>
                                <li>If you understand and can train the basics on the Tool &#8212; check the YELLOW
                                    column
                                </li>
                                <li>If you feel confident and can effectively train the Tool &#8212; check the GREEN
                                    column
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">
                    <ol>
                        <li>Which Training Tools did you feel you would be able to train well?</li>
                        <li>Which ones made you feel vulnerable as a trainer?</li>
                        <li> Are there any Training Tools that you would add or subtract from the Checklist? Why?</li>
                    </ol>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block single">
                <div class="activity-description well">REMEMBER &#8212; Be sure to share your Coaching Checklist results
                    with your Zúme Coach and/or your training partner or other mentor. If you're helping coach or mentor
                    someone, share this tool to help assess which areas need your attention and training.
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">WATCH</div>
                <div class="activity-description">What happens to churches as they grow and start new churches that
                    start new churches? How do they stay connected and live life together as an extended, spiritual
                    family? They become a network!
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/h9bg4ij6hs.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_h9bg4ij6hs">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Leadership_in_Networks.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Leadership in Networks</a>
                    </p>
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">DISCUSS</div>
                <div class="activity-description">Are there advantages when networks of simple churches are connected by
                    deep, personal relationships? What are some examples that come to mind?
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="row block">
                <div class="step-title">
                    LISTEN AND READ ALONG (3min)
                </div> <!-- step-title -->
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title">READ</div>
                <div class="activity-description">ZÚME TOOLKIT - PEER MENTORING GROUPS<br><br>Making disciples who make
                    disciples means making leaders who make leaders. How do you develop stronger leaders? By teaching
                    them how to love one another better. Peer Mentoring Groups help leaders love deeper.<br><br>Find the
                    Peer Mentoring Groups section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- row -->

            <!-- Video block -->
            <div class="row block">
                <div class="small-12 small-centered medium-9 columns">
                    <script src="//fast.wistia.com/embed/medias/82s2l4gpq8.jsonp" async></script>
                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                    <div class="wistia_embed wistia_async_82s2l4gpq8">&nbsp;</div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Peer_Mentoring_Groups.pdf"
                                target="_blank"><img
                                    src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png" alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Peer Mentoring Groups</a>
                    </p>
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title">
                    PRACTICE (60min)
                </div> <!-- step-title -->
                <div class="center"><br>Practice peer mentoring groups. Spend the next 60 minutes practicing the Peer
                    Mentoring Groups format. Find the Peer Mentoring Groups section in your Zúme Training Guide, and
                    follow these steps.
                </div>
            </div> <!-- row -->

            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>GROUPS</span></div>
                <div class="activity-description">Break into groups of two or three and work through the 3/3 sections of
                    the Peer Mentoring Group format. Peer Mentoring is something that happens once a month or once a
                    quarter and takes some time for the whole group to participate, so you will not have time for
                    everyone to experience the full mentoring process in this session.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block">
                <div class="activity-title"><span>PRACTICE</span></div>
                <div class="activity-description">To practice, choose one person in your group to be the "mentee" for
                    this session and have the other members spend time acting as Peer Mentors by working through the
                    suggested questions list and providing guidance and encouragement for the Mentee's work.<br><br>

                    By the time you're finished, everyone should have a basic understanding of asking and answering.
                </div>
            </div> <!-- row -->
            <!-- Activity Block  -->
            <div class="row block single">
                <div class="activity-description well">REMEMBER - Spend time studying the Four Fields Diagnostic Diagram
                    and Generational Map in the Peer Mentoring Groups section of your Zúme Training Guide. Make sure
                    everyone in your group has a basic understanding of these tools before asking the suggested
                    questions.
                </div>
            </div> <!-- row -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="row block">
                <div class="step-title" style="text-transform: uppercase">
                    CONGRATULATIONS ON COMPLETEING ZÚME TRAINING!
                </div> <!-- step-title -->
                <div class="center">

                    <div class="row block">
                        <div class="activity-title"><span>WATCH</span></div>
                        <div class="activity-description">
                            You and your group are now ready to take leadership to a new level!
                            Here are a few more steps to help you KEEP growing!
                        </div>
                    </div>

                    <div class="row block">
                        <div class="small-12 small-centered medium-9 columns">
                            <script src="//fast.wistia.com/embed/medias/h3znainxm9.jsonp" async></script>
                            <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                            <div class="wistia_embed wistia_async_h3znainxm9">&nbsp;</div>
                            <p class="center"><a
                                        href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Completion_of_Training.pdf"
                                        target="_blank"><img
                                            src="https://zumeproject.com/wp-content/uploads/download-icon-150x150.png"
                                            alt="" width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                            style="vertical-align: text-bottom"/> Zúme Video Scripts: Completion of
                                    Training</a></p>
                        </div>
                    </div>
                    <!-- row -->
                    <!-- Activity Block -->
                    <div class="row block">
                        <div class="activity-title"><span>GROW</span></div>
                        <div class="activity-description">
                            <p style="text-transform: uppercase">Grow as a disciple by putting your faith to work</p>
                            <p>
                                Consider registering online for reminders, coaching resources, and to become connected
                                with others who are using the same sort of ministry approach. You can do this at
                                ZumeProject.com.
                            </p>
                        </div>
                    </div>

                    <div class="row block">
                        <div class="activity-title"><span>ACT</span></div>
                        <div class="activity-description">
                            <div class="congratulations-more">
                                <button class="button js-congratulations-more-button" data-item="learn-more"><span>
                <div class="congratulations-icon congratulations-icon-learn-more"></div>
                <span>Learn More</span>
            </span></button>
                                <button class="button js-congratulations-more-button" data-item="invite"><span>
                <div class="congratulations-icon congratulations-icon-invite"></div>
                <span>Invite my friends</span>
            </span></button>
                                <button class="button js-congratulations-more-button" data-item="coordinator"><span>
                <div class="congratulations-icon congratulations-icon-coordinator"></div>
                <span>Become a county coordinator</span>
            </span></button>
                                <button class="button js-congratulations-more-button" data-item="map"><span>
                <div class="congratulations-icon congratulations-icon-map"></div>
                <span>Map my neighborhood</span>
            </span></button>
                                <button class="button js-congratulations-more-button" data-item="language"><span>
                <div class="congratulations-icon congratulations-icon-language"></div>
                <span>Fund translation of Zúme</span>
            </span></button>
                                <button class="button js-congratulations-more-button" data-item="contact-coach"><span>
                <div class="congratulations-icon congratulations-icon-contact-coach"></div>
                <span>Contact my coach</span>
            </span></button>
                                <button class="button js-congratulations-more-button" data-item="share"><span>
                <div class="congratulations-icon congratulations-icon-share"></div>
                <span>Share on Social Media</span>
            </span></button>
                                <button class="button js-congratulations-more-button" data-item="champion"><span>
                <div class="congratulations-icon congratulations-icon-champion"></div>
                <span>Champion Zúme on Social Media</span>
            </span></button>
                                <button class="button js-congratulations-more-button" data-item="join-2414"><span>
                <div class="congratulations-icon congratulations-icon-learn-more"></div>
                <span>Join 2414</span>
            </span></button>
                            </div>

                            <div class="congratulations-more__text js-congratulations-more-item" data-item="learn-more"
                                 hidden>
                                <p>
                                    Find additional information on some of the multiplication concepts at
                                    <a href="http://metacamp.org/multiplication-concepts/" target="_blank">
                                        http://metacamp.org/multiplication-concepts/
                                    </a>
                                    or ask questions about specific resources by e-mailing
                                    <a href="mailto:info@zumeproject.com">info@zumeproject.com</a>.
                                </p>
                                <p class="center">
                                    <a class="button" href="http://metacamp.org/multiplication-concepts/"
                                       target="_blank">Learn more</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="invite"
                                 hidden>
                                <p>
                                    You can put what you know to work by helping spread the word about Zúme Training and
                                    inviting others to go through training, too. We make it easy to invite friends
                                    through
                                    email, Facebook, Twitter, Snapchat and other social sites, but we can't invite your
                                    friends for you.
                                </p>
                                <div class="js-congratulations-more-invite-button"></div>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="coordinator"
                                 hidden>
                                <p>
                                    One of the ways you can put what you know to work is by becoming a county
                                    coordinator,
                                    that is someone who can help connect groups as they get started in your area. If
                                    you’re
                                    the kind of person who likes to help people go and grow, this might be a way God can
                                    use
                                    your gifts to do even more. Let us know by sending an e-mail to
                                    <a href="mailto:info@zumeproject.com">info@zumeproject.com</a>.
                                </p>
                                <p class="center">
                                    <a class="button" href="/dashboard/#your-coaches">Contact my coach</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="map" hidden>
                                <p>
                                    We are working with
                                    <a href="http://www.mappingcenter.org"
                                       target="_blank">http://www.mappingcenter.org</a>
                                    to try to provide you with free information on the residents within your census
                                    tract in
                                    order to help you more effectively reach it. "Stay tuned" for more information. If
                                    you do
                                    not have relationships within your census tract and are looking for ways to connect
                                    with
                                    your neighbors, you might consider the Mapping Your Neighborhood program for
                                    disaster
                                    preparedness. You can find information and downloadable resources at
                                    <a href="http://mil.wa.gov/emergency-management-division/preparedness/map-your-neighborhood"
                                       target="_blank">
                                        http://mil.wa.gov/emergency-management-division/preparedness/map-your-neighborhood
                                    </a>.
                                </p>
                                <p class="center">
                                    <a class="button" href="http://www.mappingcenter.org/" target="_blank">Map my
                                        neighborhood</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="language"
                                 hidden>
                                <p>
                                    As Zúme Training grows, sessions will soon be available in 34 more languages. As we
                                    bring
                                    those trainings online, we’ll send you information on people in your neighborhood
                                    that
                                    speak those languages, so you can share something that’s built just for them. You
                                    can
                                    help fund the translation of the Zúme Training into additional languages by donating
                                    at
                                    <a href="https://big.life/donate" target="_blank">https://big.life/donate</a> and
                                    designating the gift for the Zúme Project with a note about the language you would
                                    like
                                    to fund.
                                </p>
                                <p class="center">
                                    <a class="button" href="https://big.life/donate" target="_blank">Fund translation of
                                        Zúme</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item"
                                 data-item="contact-coach" hidden>
                                <p class="center">
                                    <a class="button" href="/dashboard/#your-coaches">Contact my coach</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="share"
                                 hidden>
                                <p class="center">
                                    <a class="button" href="https://www.facebook.com/zumeproject" target="_blank">Facebook
                                        page</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="champion"
                                 hidden>
                                <p>
                                    Contact us at <a href="mailto:info@zumeproject.com">info@zumeproject.com</a> if you
                                    are
                                    interested in serving as a social media moderator for Zúme.
                                </p>
                                <p class="center">
                                    <a class="button" href="mailto:info@zumeproject.com">Contact us</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="join-2414"
                                 hidden>
                                <p>
                                    Check out <a href="https://www.2414now.net" target="_blank">www.2414now.net</a> and
                                    join
                                    the global coalition praying and working together to start kingdom movement
                                    engagements
                                    in every unreached people and place by 2025.
                                </p>
                                <p class="center">
                                    <a class="button" href="https://www.2414now.net" target="_blank">Join 2414</a>
                                </p>


                            </div>
                        </div>
        </section>
		<?php
	}

}
