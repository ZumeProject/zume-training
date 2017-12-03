<?php

/**
 * Zume Coach Metabox
 *
 * @class Zume_Coach_Metabox
 * @version	0.1
 * @since 0.1
 * @package	Zume
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if (function_exists('bp_is_active') && bp_is_active('groups')) :

    class Coach_Assignment extends BP_Group_Extension
    {
        /**
         * Your __construct() method will contain configuration options for
         * your extension, and will pass them to parent::init()
         */
        public function __construct()
        {
            $args = array(
                'slug' => 'coach-assignment',
                'name' => 'Coach Assignment',
                "visibility" => "private",
                "show_tab" => 'noone',
                "access" => "loggedin",
                'screens' => array(
                    "admin" => array(
                        "enabled" => true,
                        "metabox_context" => 'side',
                    )
                ),
            );
            parent::init($args);
        }

        public function display($group_id = NULL)
        {
            echo 'display';

        }


        public function settings_screen_save($group_id = NULL)
        {
            $plain_fields = array(
                'assigned_to',
                // 'add_new_field', // You can add more fields here
            );
            foreach ($plain_fields as $field) {
                $key = $field;
                if (isset($_POST[$key])) {
                    $value = $_POST[$key];
                    groups_update_groupmeta($group_id, $field, $value);
                }
            }
        }


        public function settings_screen($group_id = NULL)
        {

            $assigned_to = '';
            $exclude_group = '';
            $exclude_user = '';
            $html = '';


            // Start drop down
            $html .= '<select name="assigned_to" id="assigned_to" class="edit-input">';

            // Set selected state
            if (isset($group_id)){
                $assigned_to = groups_get_groupmeta( $group_id, 'assigned_to', true);
            }

            if(empty( $assigned_to) || $assigned_to == 'dispatch' ) {
                // set default to dispatch
                $html .= '<option value="dispatch" selected>Dispatch</option>';
            }
            elseif ( !empty( $assigned_to ) ) { // If there is already a record
                $metadata = groups_get_groupmeta($group_id, 'assigned_to', true);
                $meta_array = explode('-', $metadata); // Separate the type and id
                $type = $meta_array[0]; // Build variables
                $id = $meta_array[1];

                // Build option for current value
                if ( $type == 'user') {
                    $value = get_user_by( 'id', $id);
                    $html .= '<option value="user-'.$id.'" selected>'.$value->display_name.'</option>';

                    // exclude the current id from the $results list
                    $exclude_user = "'exclude' => $id";
                } else {
                    $value = get_term( $id);
                    $html .= '<option value="team-'.$value->term_id.'" selected>'.$value->name.'</option>';

                    // exclude the current id from the $results list
                    $exclude_group = "'exclude' => $id";
                }

                $html .= '<option value="" disabled> --- Dispatch</option><option value="dispatch">Dispatch</option>'; // add dispatch to top of list

            }

            // Visually separate groups from users
            $html .= '<option value="" disabled> --- Coaches</option>';

            // Collect user list
            $args = array('role__in' => array('coach'), 'fields' => array('ID', 'display_name'), 'exclude' => $exclude_user );
            $results = get_users($args);

            // Loop user list
            foreach ($results as $value) {
                $html .= '<option value="user-'.$value->ID.'">'.$value->display_name.'</option>';
            }

            // Visually categorize groups
            $html .= '<option value="" disabled> --- Teams</option>';

            // Get groups list excluding current selection
            $results = get_terms( array( 'taxonomy' => 'user-group', 'hide_empty' => true, 'exclude' => $exclude_group ) );

            // Loop list of groups list
            foreach ($results as $value) {
                $html .= '<option value="group-'.$value->term_id.'">'.$value->name.'</option>';
            }

            // End drop down
            $html .= '</select>  ';

            $html .= '<button type="submit" name="submit" class="button" value="submit">Save</button>';

            echo $html;
        }

    }
    bp_register_group_extension('Coach_Assignment');

endif;