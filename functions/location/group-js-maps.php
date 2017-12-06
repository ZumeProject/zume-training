<?php
/**
 * Custom functions that add the group address meta data to the buddy press
 * @source https://codex.buddypress.org/plugindev/how-to-edit-group-meta-tutorial/
 * @since 0.1
 */


/**
 * Gets the group meta data
 * @param string $meta_key
 * @return mixed
 */
function zume_custom_field($meta_key = '') {
    //get current group id and load meta_key value if passed. If not pass it blank
    return groups_get_groupmeta( bp_get_group_id(), $meta_key );
}

/**
 * Markup for the edit section of group details
 */
function zume_group_edit_fields_markup() {
    global $bp, $wpdb;
    ?>

    <input type="hidden" id="tract" name="tract" value="<?php echo esc_attr( zume_custom_field( 'tract' ) ); ?>" required/>
    <input type="hidden" id="lng" name="lng" value="<?php echo esc_attr( zume_custom_field( 'lng' ) ); ?>"  required/>
    <input type="hidden" id="lat" name="lat" value="<?php echo esc_attr( zume_custom_field( 'lat' ) ); ?>"  required/>
    <input type="hidden" id="state" name="state" value="<?php echo esc_attr( zume_custom_field( 'state' ) ); ?>"  required/>
    <input type="hidden" id="county" name="county" value="<?php echo esc_attr( zume_custom_field( 'county' ) ); ?>"  required/>

    <style>
        /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
        #map {
            height: 600px;
            width: 75%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>



    <label for="address">Search for a new tract to connect with your group.</label>
    <input id="address" type="text" name="address" value="" placeholder="1501 W. Mineral Ave, Littleton, CO 80120" style="width: 50%; display:inline;" required/> <button style="font-size:1.25em;" type="button">Search</button> <span id="spinner"></span>

    <div id="search-response"></div>
    <div id="map"></div>
    <p></p>



    <script type="text/javascript">

        jQuery(document).ready(function() {

            jQuery(window).load(function () {
                var geoid = '<?php echo esc_js( zume_custom_field( 'tract' ) ); ?>';
                var lng = '<?php echo esc_js( zume_custom_field( 'lng' ) ); ?>';
                var lat = '<?php echo esc_js( zume_custom_field( 'lat' ) ); ?>';
                var state = '<?php echo esc_js( zume_custom_field( 'state' ) ); ?>';
                var county = '<?php echo esc_js( zume_custom_field( 'county' ) ); ?>';


                var restURL = '<?php echo esc_js( get_rest_url( null, '/lookup/v1/tract/getmapbygeoid' ) ); ?>';

                jQuery.post( restURL, { geoid: geoid })
                    .done(function( data ) {

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

                    });
            });


            jQuery('button').click( function () {
                jQuery('#spinner').prepend('<img src="<?php echo esc_js( esc_attr( get_template_directory_uri() ) ); ?>/assets/images/spinner.svg" style="height:30px;" />');

                var address = jQuery('#address').val();
                var restURL = '<?php echo esc_js( get_rest_url( null, '/lookup/v1/tract/gettractmap' ) ); ?>';
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
                        var coords = [ [data.coordinates] ];

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
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        console.log( jqXHR.responseText );
                        alert("error");
                    });
            });
        });
    </script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcddCscCo-Uyfa3HJQVe0JdBaMCORA9eY">
    </script>


    <?php
}

/**
 * Markup for the create step of the group details
 */
function zume_group_create_fields_markup() {
    ?>

    <label for="address">Search for your census tract using your group meeting address. (required) (U.S. physical addresses only)</label>
    <input id="address" type="text" name="address" value="" placeholder="1501 W. Mineral Ave, Littleton, CO 80120" style="width: 50%; display:inline;" required/> <button style="font-size:1.25em;" type="button" id="search-button">Search</button> <span id="spinner"></span>


    <div id="search-response"></div>

    <style>
        /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
        #map {
            height: 200px;;
            width: 75%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .article-header {
            display:none;
        }
        #group-create-tabs{border-bottom:1px solid #eaeaea;}
    </style>
    <div id="map" ></div>

    <input type="hidden" id="tract" name="tract" value=""  required/>
    <input type="hidden" id="lng" name="lng" value=""  required/>
    <input type="hidden" id="lat" name="lat" value=""  required/>
    <input type="hidden" id="state" name="state" value=""  required/>
    <input type="hidden" id="county" name="county" value=""  required/>
    <input type="hidden" id="assigned_to" name="assigned_to" value="dispatch"  required/>


    <script type="text/javascript">

        jQuery(document).ready(function() {

            var map;
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 38.7767479, lng: -104.0954098},
                zoom: 3
            });
            jQuery('#group-creation-create').prop('disabled', true).addClass('button action');




            jQuery('button').click( function () {
                jQuery('#spinner').prepend('<img src="<?php echo esc_js( esc_attr( get_template_directory_uri() ) ); ?>/assets/images/spinner.svg" style="height:30px;" />');

                var address = jQuery('#address').val();
                var restURL = '<?php echo esc_js( get_rest_url( null, '/lookup/v1/tract/gettractmap' ) ); ?>';
                jQuery.post( restURL, { address: address })
                    .done(function( data ) {
                        jQuery('#spinner').html('');
                        jQuery('#search-button').html('Search Again?');
                        jQuery('#search-response').html('<p>Looks like you searched for <strong>' + data.formatted_address + '</strong>? <br>Therefore, <strong>' + data.geoid + '</strong> is most likely your census tract represented in the map below. </p>' );

                        jQuery('#map').css('height', '475px');

                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: data.zoom,
                            center: {lng: data.lng, lat: data.lat},
                            mapTypeId: 'terrain'
                        });

                        // Define the LatLng coordinates for the polygon's path.
//                        var coords = [ data.coordinates ];
                        var coords = [  ];

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
                        jQuery('#group-creation-create').prop('disabled', false);
                    });
            });
        });
    </script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcddCscCo-Uyfa3HJQVe0JdBaMCORA9eY">
    </script>


    <?php

}


/**
 * @param $group_id
 */
function zume_group_header_fields_save($group_id)
{
    global $bp, $wpdb;
    $plain_fields = array(
        'address',
    'tract',
    'lng',
    'lat',
    'state',
    'county',
    'assigned_to'
    );
    foreach ($plain_fields as $field) {
        $key = $field;
        if (isset( $_POST[$key] )) {
            $value = sanitize_text_field( wp_unslash( $_POST[$key] ) );
            groups_update_groupmeta( $group_id, $field, $value );
        }
    }
}

add_filter( 'bp_after_group_details_creation_step', 'zume_group_create_fields_markup' );
add_filter( 'bp_after_group_details_admin', 'zume_group_edit_fields_markup' );
add_action( 'groups_group_details_edited', 'zume_group_header_fields_save' );
add_action( 'groups_created_group', 'group_header_fields_save' );
