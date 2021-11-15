_ = _ || window.lodash // make sure lodash is defined so plugins like gutenberg don't break it.
const i18n = zumeTraining.translations;

/**
 * PANEL LOADER
 */
jQuery(document).ready(function($){

  if( ! window.location.hash || '#panel1' === window.location.hash ) {
    console.log(zumeTraining)
    show_panel1()
  }
  if( '#panel2' === window.location.hash  ) {
    if ( ! zumeTraining.logged_in ) {
      show_panel1()
    }

    console.log(zumeTraining)
    get_groups()
  }
  if( '#panel3' === window.location.hash  ) {
    if ( ! zumeTraining.logged_in ) {
      show_panel1()
    }

    console.log(zumeTraining)
    get_progress()
  }
  if( '#panel4' === window.location.hash  ) {
    if ( ! zumeTraining.logged_in ) {
      show_panel1()
    }

    console.log(zumeTraining)
    get_coach_request()
  }
  // click listener for submenu
  jQuery('#top-full-menu-div a').on('click',function() {
    console.log(window.location.hash)
    if( '#panel1' === this.hash ) {
      show_panel1()
    }
    if( '#panel2' === this.hash  ) {
      get_groups()
    }
    if( '#panel3' === this.hash  ) {
      get_progress()
    }
    if( '#panel4' === this.hash  ) {
      get_coach_request()
    }
  })

  write_network_tab()
})


/**
 * COURSE PANEL
 */
// listeners
jQuery(document).ready(function(){

  jQuery('.hide-extra').show();
  jQuery('#extra_button').removeClass('hollow')

  if ( getCookie( 'extra' ) === "on") {
    jQuery('#extra_button').removeClass('hollow')
    jQuery('.hide-extra').show();
  } else if ( getCookie( 'extra' ) === "off" ){
    jQuery('#extra_button').addClass('hollow')
    jQuery('.hide-extra').hide();
  }
  if ( getCookie( 'columns' ) === "single") {
    jQuery('#column_button').removeClass('hollow')
    jQuery('.session').removeClass('medium-6')
  }
})
function show_panel1() {
  jQuery('.hide-for-load').removeClass('hide-for-load')
}
// functions
function toggle_column() {
  let item = jQuery('#column_button')
  if ( item.hasClass("hollow") ) {
    item.removeClass('hollow')
    jQuery('.session').removeClass('large-6')
    setCookie('columns', 'single', 30)
  } else {
    item.addClass('hollow')
    jQuery('.session').addClass('large-6')
    setCookie('columns', 'double', 30)
  }
}
function toggle_extra() {
  let item = jQuery('#extra_button')
  if ( item.hasClass("hollow") ) {
    item.removeClass('hollow')
    jQuery('.hide-extra').show();
    setCookie('extra', 'on', 30)
  } else {
    item.addClass('hollow')
    jQuery('.hide-extra').hide();
    setCookie('extra', 'off', 30)
  }
}
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

/**
 * GROUP PANEL
 */
function get_groups() {
  let groups = zumeTraining.groups


  if ( groups.length > 0 ) {
    let div = jQuery('#group-list')
    div.empty()
    jQuery.each(groups, function(i,v) {
      if ( v.closed !== true ) {
        div.append(`
    <div class="cell group-section border-bottom padding-bottom-2 margin-bottom-2">
      <div class="grid-x grid-padding-x">
        <div class="cell padding-bottom-1 group-name medium-6"  id="group_name_${_.escape( v.key )}"><!--Full width top --></div><div class="hide-for-small-only medium-6"></div>
        <div class="cell medium-2 padding-bottom-1 "> <!-- Column 1 -->
           <div class="grid-y" id="session_list_${_.escape( v.key )}"><!-- Session List --></div>
        </div> <!-- Column 1 -->
        <div class="cell medium-4">
            <div class="grid-y">
                  <div class="cell column-header">${_.escape( i18n.str.x1 )}<!-- Members --></div>
                  <div class="cell padding-bottom-1">
                      <select class="member-count" onchange="save_member_count('${_.escape( v.key )}', ${_.escape( i )})" id="member_count_${_.escape( v.key )}"><!-- member count --></select>
                  </div>
                  <div class="cell column-header">${_.escape( i18n.str.x2 )}<!-- Members List (optional) --></div>
                  <div class="cell">
                      <div class="grid-y" id="member_list_${_.escape( v.key )}"><!-- member list --></div>
                  </div>
                  <div class="cell add-member" id="add_member_${_.escape( v.key )}"><!-- add member area --></div>
            </div>
        </div> <!-- Column 2 -->
        <div class="cell medium-4"> <!-- Column 3 -->
            <div class="grid-y">
                <div class="cell">
                  <span class="column-header">${_.escape( i18n.str.x3 )}<!-- Location --></span>
                </div>
                <div class="cell" id="map_${_.escape( v.key )}"><!-- Map Section--></div>
                <div class="cell" id="add_location_${_.escape( v.key )}"><!-- Add Location Field --></div>
            </div>
        </div> <!-- Column 3 -->
        <div class="cell medium-2">
              <div class="grid-y" id="meta_column_${_.escape( v.key )}"><!-- Meta column buttons --></div>
        </div> <!-- Column 4 -->
      </div>
  </div>`)

        /* load features per group */
        write_group_name(v.key, i )
        write_member_count( v.key, v )
        write_session_progress( v.key, i )
        write_members_list( v.key, i )
        write_member_list_button( v.key, i )
        write_location_add_button( v.key, i )
        write_meta_column( v.key, i )
        write_member_list_hover_delete( v.key, i )

      }/* end if closed */}) /* end .each loop*/

    /** ARCHIVE LIST */
    let archive_exists = false
    jQuery.each(groups, function(i,v) {
      if ( v.closed === true ) {
        archive_exists = true
      }
    })
    if ( archive_exists ) {
      write_view_archive_button()
    }
  } /* if not empty */

  // load listeners for group tab
  jQuery(document).ready(function(){
    write_add_group_button()
    write_invitation_list()
  })

}

// functions
function write_group_name( key, i ) {
  jQuery('#group_name_'+key).empty().html(`<h2 onclick="edit_group_name('${_.escape( key )}', ${_.escape( i )})">${_.escape( zumeTraining.groups[i].group_name)}</h2>`)
}
function edit_group_name( key, i ) {
  jQuery('#group_name_'+key).empty().html(`
    <div class="input-group">
      <input class="input-group-field" type="text" id="edit_group_name_${_.escape( key )}" value="${_.escape( zumeTraining.groups[i].group_name )}">
      <div class="input-group-button">
        <input type="button" class="button" onclick="save_group_name('${_.escape( key )}', ${_.escape( i )})" value="${_.escape( i18n.str.x6 )/*Save*/}">
      </div>
      <div class="input-group-button">
        <input type="button" class="button hollow" onclick="write_group_name('${_.escape( key )}', ${_.escape( i )} )" value="${_.escape( i18n.str.x7 )/*Cancel*/}">
      </div>
    </div>
  `) /* end html */
  jQuery('#edit_group_name_'+key).focus()
}
function save_group_name( key, i ) {
  let new_name = jQuery('#edit_group_name_'+key).val()
  if ( new_name ) {
    jQuery('#save-group').prop('disabled')

    API.update_group( key, _.escape( new_name ), 'group_name' )

    zumeTraining.groups[i].group_name = _.escape( new_name )

  }
  write_group_name( key, i )
}

function write_session_progress( key, i ) {
  let div = jQuery('#session_list_'+key)
  let group = zumeTraining.groups[i]

  div.empty().append(`
  <div class="cell"><i class="g-session-icon" id="s1${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 1)"></i> <a href="${get_course_url_with_params(1, _.escape( i ) )}">${_.escape( i18n.sessions[1] )}<!--Session 1--></a></div>
  <div class="cell"><i class="g-session-icon" id="s2${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 2)"></i> <a href="${get_course_url_with_params(2, _.escape( i ) )}">${_.escape( i18n.sessions[2] )}<!--Session 2--></a></div>
  <div class="cell"><i class="g-session-icon" id="s3${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 3)"></i> <a href="${get_course_url_with_params(3, _.escape( i ) )}">${_.escape( i18n.sessions[3] )}<!--Session 3--></a></div>
  <div class="cell"><i class="g-session-icon" id="s4${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 4)"></i> <a href="${get_course_url_with_params(4, _.escape( i ) )}">${_.escape( i18n.sessions[4] )}<!--Session 4--></a></div>
  <div class="cell"><i class="g-session-icon" id="s5${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 5)"></i> <a href="${get_course_url_with_params(5, _.escape( i ) )}">${_.escape( i18n.sessions[5] )}<!--Session 5--></a></div>
  <div class="cell"><i class="g-session-icon" id="s6${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 6)"></i> <a href="${get_course_url_with_params(6, _.escape( i ) )}">${_.escape( i18n.sessions[6] )}<!--Session 6--></a></div>
  <div class="cell"><i class="g-session-icon" id="s7${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 7)"></i> <a href="${get_course_url_with_params(7, _.escape( i ) )}">${_.escape( i18n.sessions[7] )}<!--Session 7--></a></div>
  <div class="cell"><i class="g-session-icon" id="s8${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 8)"></i> <a href="${get_course_url_with_params(8, _.escape( i ) )}">${_.escape( i18n.sessions[8] )}<!--Session 8--></a></div>
  <div class="cell"><i class="g-session-icon" id="s9${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 9)"></i> <a href="${get_course_url_with_params(9, _.escape( i ) )}">${_.escape( i18n.sessions[9] )}<!--Session 9--></a></div>
  <div class="cell"><i class="g-session-icon" id="s10${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 10)"></i> <a href="${get_course_url_with_params(10, _.escape( i ) )}">${_.escape( i18n.sessions[10] )}<!--Session 10--></a></div>
  `)

  let x = 1
  while ( x < 11) {
    if( group['session_'+x] ) {
      jQuery('#s'+x+key).addClass('complete')
    }
    x++;
  }
}
function save_session_status( key, i, session_number ) {

  if ( isOwner(key,i)) {
    // pre-toggle assuming success
    let item = jQuery('#s'+session_number+key)
    if ( item.hasClass("complete") ) {
      item.removeClass('complete')
    } else {
      item.addClass('complete')
    }

    API.update_group( key, session_number, 'session_complete' )
      .fail(function(e){
      // if fail, reverse toggle
      if ( item.hasClass("complete") ) {
        item.removeClass('complete')
      } else {
        item.addClass('complete')
      }
      alert(`${i18n.str.x4}`)/*Connection to server failed. Try again.*/
      conole.log('update group session status fail')
      console.log(e)
    })
  }

}
function write_member_count( key, group ) {
    let list = ''
    let i = 1
    if ( group.members > 0 ){
      list += '<option value="'+_.escape( group.members )+'" selected>'+_.escape( group.members )+'</option>'
    }
    while ( i < 30) {
      list += '<option value="'+_.escape( i )+'"';
      list += '>'+ _.escape( i ) +'</option>'
      i++;
    }

    jQuery('#member_count_' + key ).empty().append(list)
}
function save_member_count( key, i ) {
  let count = jQuery('#member_count_'+key).val()

  if ( count ) {
    if ( zumeTraining.groups[i].coleaders_accepted.length > count ) {
      count = zumeTraining.groups[i].coleaders_accepted.length
    }
    API.update_group( key, _.escape( count ), 'members' )
      .done(function(data)
      {
        zumeTraining.groups[i].members = _.escape( count )
      })
  }
}
function write_members_list( key, i ) {
  let div = jQuery('#member_list_'+key)
  let verified
  div.empty()
  jQuery.each( zumeTraining.groups[i].coleaders, function(ib,v) {
    if ( v !== undefined ) {
      div.append(`<div class="cell member">${_.escape( v )} <span class="delete" onclick="delete_member_list_item( '${_.escape( key )}', ${_.escape( i )}, ${_.escape( ib )}, '${_.escape( v )}' )">${i18n.str.x95/*delete*/}</span></div>`)
    }
  })
}
function edit_new_member_list( key, i ) {
  jQuery('#add_member_'+key).empty().append(`
  <hr>
  <input type="text" placeholder="email" id="email_${_.escape( key )}" />
  <button type="button" class="button small" onclick="save_new_member('${_.escape( key )}', ${_.escape( i )})">${_.escape( i18n.str.x6 )/*Save*/}</button>
  <button type="button" class="button small hollow" onclick="write_member_list_button('${_.escape( key )}', ${_.escape( i )})">${_.escape( i18n.str.x7 )/*Cancel*/}</button>
  `)
  jQuery('#email_'+key).focus()
}
function write_member_list_button( key, i ) {
  if ( isOwner( key, i ) ) {
    jQuery('#add_member_'+key).empty().append(`
    <button type="button" class="button clear" onclick="edit_new_member_list('${_.escape( key )}', ${_.escape( i )})"><i class="fi-plus"></i> ${_.escape( i18n.str.x8 )/*add*/}</button>
  `)
  }
}
function save_new_member( key, i ) {
  let email = jQuery('#email_' + key).val()

  if ( email && _.indexOf( zumeTraining.groups[i].coleaders, email ) < 0 ) {
    API.update_group( key, email, 'coleaders_add' )

    zumeTraining.groups[i].coleaders[zumeTraining.groups[i].coleaders.length++] = _.escape( email )
  }

  write_members_list(key, i)
  write_member_list_button( key, i )
  write_member_list_hover_delete( key, i )
}
function write_member_list_hover_delete( key, i ) {
  if ( isOwner(key,i)) {
    jQuery('.member').hover( function(){jQuery(this).children(".delete").show()}, function(){jQuery(this).children(".delete").hide()})
  }
}
function delete_member_list_item( key, i, ib, email ) {
  if ( email ) {
    API.update_group( key, email, 'coleaders_delete' )

    delete zumeTraining.groups[i].coleaders[ib]
  }
  write_members_list(key, i)
  write_member_list_button( key, i )
  write_member_list_hover_delete( key, i )
}


function add_location_lookup_map( key, i ) {
  let div =  jQuery('#training-modal-content')
  if ( typeof mapboxgl !== undefined ) {
    div.empty()
  }

  jQuery.when(
    jQuery.getScript( "https://api.mapbox.com/mapbox-gl-js/v1.1.0/mapbox-gl.js?ver=1.1.0" ),
    jQuery.getScript( "https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.0/mapbox-gl-geocoder.min.js" ),
    jQuery.Deferred(function( deferred ){
      jQuery( deferred.resolve );
    })
  ).done(function(){
    load_mapbox( key, i )
  });

  jQuery('#training-modal').foundation('open')

  function load_mapbox( key, i) {
    div.empty()
    div.append(`<link rel="stylesheet" id="mapbox-gl-css-css" href="https://api.mapbox.com/mapbox-gl-js/v1.1.0/mapbox-gl.css?ver=1.1.0" type="text/css" media="all">`)
    div.append(`<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.0/mapbox-gl-geocoder.css" type="text/css">`)
    div.append(`<style>.mapboxgl-ctrl-top-right.mapboxgl-ctrl{width:100% !important;margin:10px !important;}</style>
      <div class="grid-x grid-padding-y">
        <div class="cell center padding-vertical-0">${_.escape( i18n.str.x9 )/*Zoom, click, or search for your location.*/}<br><button type="button" onclick="activate_geolocation()" class="button tiny primary-button-hollow margin-top-1">${_.escape( i18n.str.x10 )/*find you current location*/}</button> </div>
        <div class="cell"><div class="map" id='map' style="width:100%;height:400px;"></div></div>
        <div class="cell center">
          <button type="button" onclick="save_new_location( '${_.escape( key )}', ${_.escape( i )} )" id="result_display" class="button primary-button-hollow">${_.escape( i18n.str.x6 )/*find you current location*/}</button> <img src="${zumeTraining.theme_uri}/assets/images/spinner.svg" alt="spinner" class="spinner" style="width: 22px;display:none;" />
        </div>
      </div>
    `)
    /***********************************
     * Map
     ***********************************/
    mapboxgl.accessToken = zumeTraining.map_key;
    var map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [-20, 30],
      zoom: 1
    });


    /***********************************
     * Click
     ***********************************/
    map.on('click', function (e) {
      console.log(e)

      let lng = e.lngLat.lng
      let lat = e.lngLat.lat
      window.active_lnglat = [lng,lat]

      // add marker
      if ( window.active_marker ) {
        window.active_marker.remove()
      }
      window.active_marker = new mapboxgl.Marker()
        .setLngLat(e.lngLat )
        .addTo(map);

      jQuery('#result_display').html(`${_.escape( i18n.str.x11 )/*Save Clicked Location*/}`)

      window.current_search_result = {
        lng: lng,
        lat: lat,
        action: 'click',
        level: 'lnglat',
        label: 'lnglat',
        source: 'user',
        grid_id: '',
        context: false,
      }
    });

    /***********************************
     * Search
     ***********************************/
    var geocoder = new MapboxGeocoder({
      accessToken: mapboxgl.accessToken,
      types: 'country region district locality neighborhood address place',
      mapboxgl: mapboxgl
    });
    map.addControl(geocoder);
    geocoder.on('result', function(e) { // respond to search
      console.log(e)
      if ( window.active_marker ) {
        window.active_marker.remove()
      }
      window.active_marker = new mapboxgl.Marker()
        .setLngLat(e.result.center)
        .addTo(map);
      geocoder._removeMarker()

      jQuery('#result_display').html(`${i18n.str.x12/*Save Searched Location*/}`)

      window.current_search_result = {
        lng: ( e.result.center[0] || '' ),
        lat: ( e.result.center[1] || '' ),
        action: 'search',
        level: ( e.result.place_type[0] || '' ),
        label: e.result.place_name || '',
        source: 'user',
        grid_id: '',
        context: ( e.result.context || false ),
      }
    })

    /***********************************
     * Geolocate Browser
     ***********************************/
    let userGeocode = new mapboxgl.GeolocateControl({
      positionOptions: {
        enableHighAccuracy: true
      },
      marker: {
        color: 'orange'
      },
      trackUserLocation: false,
      showUserLocation: false
    })
    map.addControl(userGeocode);
    userGeocode.on('geolocate', function(e) { // respond to search
      console.log(e)
      if ( window.active_marker ) {
        window.active_marker.remove()
      }

      let lat = e.coords.latitude
      let lng = e.coords.longitude

      window.active_lnglat = [lng,lat]
      window.active_marker = new mapboxgl.Marker()
        .setLngLat([lng,lat])
        .addTo(map);

      jQuery('#result_display').html(`${i18n.str.x13/*Save Current Location*/}`)

      window.current_search_result = {
        lng: lng,
        lat: lat,
        action: 'geolocate',
        level: 'lnglat',
        label: 'lnglat',
        source: 'user',
        grid_id: '',
        context: false,
      }
    })

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      map.addControl(new mapboxgl.NavigationControl());
    }

  }
}
function activate_geolocation() {
  jQuery(".mapboxgl-ctrl-geolocate").click();
}
function save_new_location( key, i ) {
  if ( window.current_search_result === undefined || window.current_search_result === false ) {
    jQuery('#result_display').html(`${_.escape( i18n.str.x14 )/*You haven't selected anything yet. Click, search, or allow auto location.*/}`)
    return;
  }
  jQuery('.spinner').show()
  window.current_search_result['key'] = key

  API.update_location( window.current_search_result ).done(function(data){
    console.log(data)
    zumeTraining.groups = data // set new group data
    write_location_add_button( key, 0 ) // write new location section
    window.current_search_result = false // wipe search results
    jQuery('#training-modal').foundation('close') // close modal
  })

}
function write_location_add_button( key, i ) {
  let group = zumeTraining.groups[i]
  if ( group.location_grid_meta.lng && isOwner( key, i ) ) {
    jQuery('#add_location_'+_.escape( key ))
      .empty()
      .append(`<img width="400" src="https://api.mapbox.com/styles/v1/mapbox/streets-v9/static/pin-m-marker+0096ff(${_.escape( group.location_grid_meta.lng )},${_.escape( group.location_grid_meta.lat )})/${_.escape( group.location_grid_meta.lng )},${_.escape( group.location_grid_meta.lat )},${( _.escape( group.zoom ) || 6 )},0/400x250@2x?access_token=${_.escape( zumeTraining.map_key )}" alt="Mapbox Map" />`)
      .append(`<br>${group.location_grid_meta.label}`)
      .append(`<br><button type="button" class="button clear" onclick="add_location_lookup_map('${_.escape( key )}', ${_.escape( i )})"><i class="fi-plus"></i> ${_.escape( i18n.str.x15 )/*update*/}</button>`)
  }
  else if ( isOwner( key, i ) ) {
    jQuery('#add_location_'+_.escape( key )).empty().append(`
    <button type="button" class="button clear" onclick="add_location_lookup_map('${_.escape( key )}', ${_.escape( i )})"><i class="fi-plus"></i> ${_.escape( i18n.str.x8 )/*add*/}</button>
  `)
  }
}


function write_meta_column( key, i ) {
  if ( indexMismatch(key,i) ) {
    return false;
  }
  let div = jQuery('#meta_column_'+key)
  div.empty()

  if ( zumeTraining.groups[i].next_session > 10 ) {
    div.append(`<div class="cell center">${_.escape( i18n.str.x16 )/*Course Complete*/}</div>`)
  } else {
    div.append(`
      <div class="cell"><button type="button" onclick="open_session( ${_.escape( zumeTraining.groups[i].next_session )}, '${_.escape( key )}', ${_.escape( i )} );" class="button primary-button expanded">${_.escape( i18n.str.x17 )/*Next Session*/} ${_.escape( zumeTraining.groups[i].next_session )}</button><!-- Next session --></div>
     `)
  }
  // if owner of the group
  if ( isOwner( key, i ) ) {
    div.append(`<div class="cell center"><button type="button" class="button clear small" onclick="archive_group( '${_.escape( key )}', ${_.escape( i )} );">${_.escape( i18n.str.x18 )/*Archive*/}</button></div>`)
  }
  if ( zumeTraining.groups[i].public_key ) {
    div.append(`<div class="cell center"><span class="key-text">${_.escape( zumeTraining.groups[i].public_key )}</span></div>`)
  }

}
function get_course_url_with_params( session_number, i ) {
  if ( i === undefined ) {
    return _.escape( zumeTraining.site_urls.course ) + '?session=' + _.escape( session_number )
  } else {
    return _.escape( zumeTraining.site_urls.course ) + '?group=' + _.escape( zumeTraining.groups[i].foreign_key ) + '&session=' + _.escape( session_number )
  }
}
function open_session( session_number, key, i ) {
  if ( ! zumeTraining.logged_in ) {
    jQuery('#training-modal-content').empty().html(`
    <div class="grid-y padding-top-1 training">
        <div class="cell"><h2 class="center">${_.escape( i18n.str.x19 )/*Welcome to Session*/} ${_.escape( session_number )}</h2></div>
        <div class="cell callout primary-color margin-2">
            <div class="grid-x padding-right-2 padding-left-2 grid-padding-y" id="not-logged-in">
                <div class="cell center list-head"><h3>${_.escape( i18n.str.x20 )/*You're missing out*/} <br>${_.escape( i18n.str.x21 )/*Register Now!*/}</h3></div>
                <div class="cell list-reasons">
                    <ul>
                    <li>${_.escape( i18n.str.x22 )/*track your personal training progress*/}</li>
                    <li>${_.escape( i18n.str.x23 )/*access group planning tools*/}</li>
                    <li>${_.escape( i18n.str.x24 )/*connect with a coach*/}</li>
                    <li>${_.escape( i18n.str.x25 )/*add your effort to the global vision!*/}</li>
                    </ul>
                </div>
                <div class="cell center"><a href="${_.escape( zumeTraining.site_urls.register ) }" class="button expanded large secondary-button">${_.escape( i18n.str.x26 )/*Register for Free*/}</a><a href="${_.escape( zumeTraining.site_urls.login )}" type="submit" class="button clear padding-bottom-0">${_.escape( i18n.str.x27 )/*Login*/}</a></div>
            </div>
        </div>
        <div class="cell center margin-bottom-1"><a class="center button hollow" id="continue-to-session" onclick="continue_to_session( ${_.escape( session_number )} )" >${_.escape( i18n.str.x28 )/*Continue*/}</a>  <span class="spinner" style="display: none;"><img src="${zumeTraining.theme_uri}/spinner.svg" style="width:30px;height:30px;" alt="spinner" /></span></div>
    </div>
  `)
  } else if ( key /** logged in */) {
    window.location = get_course_url_with_params( session_number, i )
    return;
  } else { /* no key */

    let list = ''
    jQuery.each(zumeTraining.groups, function(i,v){
      if ( v.closed !== true ) {
        list += '<option value="'+_.escape( i )+'">'+_.escape( v.group_name )+'</option>'
      }
    })
    list += '<option>------------</option><option value="none">'+_.escape( i18n.str.x29 )/*Not Leading a Group*/+'</option><option value="create_new">'+_.escape( i18n.str.x30 )/*Create New Group*/+'</option>'

    jQuery('#training-modal-content').empty().html(`
      <div class="grid-y padding-top-1 grid-padding-y training">
        <div class="cell"><h2 class="center">${_.escape( i18n.str.x31 )/*Session*/} ${_.escape( session_number )}</h2></div>
        <div class="cell center">
        ${_.escape( i18n.str.x32 )/*Which group are you leading?*/}<br>
          <select onchange="check_group_selection(${_.escape( session_number )})" id="group_selection">${list}</select><br>
          <div id="create_new_group"></div>
        </div>
        <div class="cell center margin-bottom-1" id="continue_button">
          <button type="submit" class="center button large" id="continue-to-session" onclick="continue_to_session(${_.escape( session_number )} )">${_.escape( i18n.str.x28 )/*Continue*/}</button> <span class="spinner" style="display: none;"><img src="${zumeTraining.theme_uri}/spinner.svg" style="width:30px;height:30px;" alt="spinner" /></span>
        </div>

      </div>
    `)

  }

  jQuery('#training-modal').foundation('open')
}
function check_group_selection( session_number ){
  let item = jQuery('#group_selection')
  let new_div = jQuery('#create_new_group')
  let button = jQuery('#continue_button')

  if ( item.val() === 'create_new' ) {
    console.log('create new')
    new_div.empty().append(`
    <hr>
    <div class="grid-x">
      <div class="cell center" id="new-group">
          <input type="text" class="input-group-field add-group-input" placeholder="${_.escape( i18n.str.x94 )/*Group Name*/}" title="${_.escape( i18n.str.x94 )/*Group Name*/}" name="group_name" id="group_name" /> <br>
          <input type="number" placeholder="${_.escape( i18n.str.x33 )/*Number of Members*/}" title="${_.escape( i18n.str.x33 )/*Number of Members*/}" class="input-group-field add-group-input" name="members" /> <br>
          <button type="button" class="button" onclick="save_new_group_and_continue(${_.escape( session_number )})">${_.escape( i18n.str.x6 )/*Save*/}</button>
          <button type="button" class="button hollow" onclick="open_session(${_.escape( session_number )})">${_.escape( i18n.str.x7 )/*Cancel*/}</button>
      </div>
  </div>
  `)
    button.hide()
  } else {
    new_div.empty()
    button.show()
  }
}
function save_new_group_and_continue( session_number ) {
  let group_name = jQuery('#new-group input[name=group_name]').val()
  let members = jQuery('#new-group input[name=members]').val()

  if ( group_name && members ) {
    API.create_group( _.escape( group_name ), _.escape( members ) )
      .done(function(data) {
        zumeTraining.groups = data
        window.location = get_course_url_with_params( session_number, 0 )
      })
      .fail(function(e){
        alert(`${i18n.str.x4/*Connection to server failed. Try again.*/}`)
        console.log('error making new group')
        console.log(e)
      })
  }
}
function continue_to_session( session_number ) {
  jQuery('.spinner').show()

  if ( ! zumeTraining.logged_in ) {
    window.location = get_course_url_with_params( session_number )
  } else {
    let item = jQuery('#group_selection').val()
    if( item === 'none' || item === 'create_new' ) {
      window.location = get_course_url_with_params( session_number )
    } else {
      window.location = get_course_url_with_params( session_number, item )
    }
  }
}

function write_add_group_button() {
  jQuery('#add_group_container').html(`<button class="button primary-button-hollow small add-group-button" type="button"><i class="fi-plus"></i> ${_.escape( i18n.str.x93 )/*Add Group*/}</button>`)
  jQuery('.add-group-button').on('click', function(){

    jQuery(this).parent().empty().html(`
    <div class="grid-x">
        <div class="cell input-group" id="new-group">
            <input type="text" class="input-group-field add-group-input" placeholder="${_.escape( i18n.str.x34 )/*Group Name*/}" title="${_.escape( i18n.str.x34 )/*Group Name*/}" name="group_name" id="group_name" />
            <input type="number" placeholder="${_.escape( i18n.str.x33 )/*Number of Members*/}" title="${_.escape( i18n.str.x33 )/*Number of Members*/}" class="input-group-field add-group-input" min="1" max="500" name="members" />
            <div class="input-group-button">
            <button type="button" class="button" id="save-group"  onclick="save_new_group()">${_.escape( i18n.str.x6 )/*Save*/}</button>
            </div>
            <div class="input-group-button">
            <button type="button" class="button hollow" onclick="write_add_group_button()">${_.escape( i18n.str.x7 )/*Cancel*/}</button>
            </div>
        </div>
    </div>
    `)
    jQuery('#group_name').focus()
  })
}
function save_new_group() {
  let group_name = jQuery('#new-group input[name=group_name]').val()
  let members = jQuery('#new-group input[name=members]').val()

  if ( members > 300 ) {
    members = 300
  }
  if ( members < 1 ) {
    members = 1
  }

  if ( group_name && members ) {
    jQuery('#save-group').attr("disabled", true)

    API.create_group( _.escape( group_name ), _.escape( members ) )
      .done(function(data) {
        zumeTraining.groups = data
        write_add_group_button()
        get_groups()
      })
      .fail(function(e){
        write_add_group_button()
        jQuery('#add_group_container').append(`
    <br>${_.escape( i18n.str.x35 )/*Group addition failed. Try again.*/}`)
      })

    if (typeof window.movement_logging !== "undefined") {
      window.movement_logging({
        "action": "starting_group",
        "category": "leading",
        "data-language_code": zumeTraining.current_language,
        "data-language_name": zumeTraining.current_language_name,
        "data-note": "is creating a new training group!"
      })
    }
  }
}

function write_invitation_list() {
  let div = jQuery('#invitation-list')
  div.empty()
  if ( zumeTraining.invitations.length > 0 ) {

    div.empty().append(`<div class="grid-x grid-padding-y margin-1">`)

    jQuery.each(zumeTraining.invitations, function(i,v) {
      div.append(`
      <div class="cell session-boxes padding-1 margin-bottom-1">
            <p class="center padding-bottom-1">
                <strong>${_.escape( v.owner )}</strong> ${_.escape( i18n.str.x36 )/*invites you to join*/} <strong>${_.escape( v.group_name )}</strong>
            </p>
            <p class="center">
              <button type="button" onclick="save_invitation_response( '${_.escape( v.key )}', 'accepted' )" class="button">${_.escape( i18n.str.x37 )/*Accept*/}</button>
              <button type="button" onclick="save_invitation_response( '${_.escape( v.key )}', 'declined' )" class="button hollow">${_.escape( i18n.str.x38 )/*Decline*/}</button>
            </p>
        </div>
      `)
    })
    div.append(`<hr></div>`)
  }
}
function save_invitation_response( key, answer ) {
  API.update_group( key, answer, 'coleader_invitation_response' ).done(function(data){
    console.log(data)
    if ( data ) {
      zumeTraining.groups = data.groups
      zumeTraining.invitations = data.invitations
      get_groups()
      write_invitation_list()
    }
  })
    .fail(function(e){
      console.log('failed to accept')
      console.log(e)
    })

  if (typeof window.movement_logging !== "undefined") {
    if ( 'accepted' === answer ) {
      window.movement_logging({
        "action": "building_group",
        "category": "leading",
        "data-language_code": zumeTraining.current_language,
        "data-language_name": zumeTraining.current_language_name,
        "data-note": "is building a training group!"
      })
    }
  }
}

function archive_group( key, i, verified ) {
  if ( ! isOwner(key,i) ) {
    return false;
  }

  if ( verified ) {
    API.update_group( key, 'closed', 'archive_group' ).done(function(data) {
      zumeTraining.groups = data
      get_groups()
    })
      .fail(function(e){
        console.log(e)
      })
  } else {
    jQuery('#training-modal-content').empty().append(`
    <div class="grid-x grid-padding-y training">
        <div class="cell center">
            ${_.escape( i18n.str.x39 )/*Are you sure you want to archive this group?*/}
        </div>
        <div class="cell center">
        <button type="button" class="center button primary-button" onclick="archive_group( '${_.escape( key )}', ${_.escape( i )}, 1 )" data-close aria-label="Close modal">${_.escape( i18n.str.x92 )/*Archive*/}</button>
        <button type="button" class="center button primary-button-hollow" data-close aria-label="Close modal">${_.escape( i18n.str.x7 )/*Cancel*/}</button>
        </div>
    </div>
  `)
    jQuery('#training-modal').foundation('open')
  }
}
function write_view_archive_button() {
  let div = jQuery('#archive-list')
  div.empty()
  div.append(`
  <div class="grid-x padding-top-2">
    <div class="cell center"><button type="button" class="button primary-button-hollow" onclick="open_archive_groups()" >${_.escape( i18n.str.x40 )/*Show Archived Groups*/}</button> </div>
  </div>
  `)
}
function open_archive_groups() {
  let list = ''
  jQuery.each( zumeTraining.groups, function(i,v) {
    if ( v.closed === true ) {
      list += ''+ `<tr id="archive_${_.escape( v.key )}"><td>${_.escape( v.group_name )}</td><td><button type="button" class="button clear padding-bottom-0" onclick="activate_group('${_.escape( v.key )}', ${_.escape( i )})">${_.escape( i18n.str.x41 )/*Re-Activate*/}</button></td><td><button type="button" class="button alert clear padding-bottom-0" onclick="delete_group('${_.escape( v.key )}', ${_.escape( i )} )">${_.escape( i18n.str.x42 )/*Delete Forever*/}</button></td></tr>`
    }
  })
  jQuery('#training-modal-content').empty().append(`
  <div class="grid-x training">
        <div class="cell"><h2>${_.escape( i18n.str.x43 )/*Archived Groups*/}</h2><hr></div>
        <div class="cell">
            <table>${list}</table>
        </div>
        <div class="cell center margin-bottom-1"><button type="button" class="center button primary-button-hollow" data-close aria-label="Close modal">${_.escape( i18n.str.x44 )/*Close*/}</button></div>
    </div>
  `)

  jQuery('#training-modal').foundation('open')
}
function activate_group( key, i ) {
  if ( ! isOwner(key,i) ) {
    return false;
  }

  API.update_group( key, 'activate', 'activate_group' ).done(function(data) {
    zumeTraining.groups = data
    get_groups()
    open_archive_groups()
  })
    .fail(function(e){
      console.log(e)
    })
}
function delete_group( key, i, verified ) {
  if ( ! isOwner(key,i) ) {
    return false;
  }

  if ( verified ) {
    API.update_group( key, 'delete', 'delete_group' ).done(function(data) {
      zumeTraining.groups = data
      get_groups()
      open_archive_groups()
    })
      .fail(function(e){
        console.log('delete_group error')
        console.log(e)
      })
  } else {
    jQuery('#training-modal-content').empty().append(`
    <div class="grid-x grid-padding-y training">
        <div class="cell center">
            ${_.escape( i18n.str.x45 )/*Are you sure you want to delete this group?*/}
        </div>
        <div class="cell center">${_.escape( zumeTraining.groups[i].group_name )}</div>
        <div class="cell center">
        <button type="button" class="center button primary-button" onclick="delete_group( '${_.escape( key )}', ${_.escape( i )}, 1 )" >${_.escape( i18n.str.x46 )/*Delete Forever*/}</button>
        <button type="button" class="center button primary-button-hollow" onclick="open_archive_groups()">${_.escape( i18n.str.x7 )/*Cancel*/}</button>
        </div>
    </div>
  `)
    jQuery('#training-modal').foundation('open')
  }
}

/** Tests if current user is owner */
function isOwner( key, i ) {
  if ( indexMismatch(key,i) ) {
    return false;
  }
  if ( parseInt( zumeTraining.current_user_id ) !== parseInt( zumeTraining.groups[i].owner ) ) {
    return false;
  }
  return true;
}
/** Tests if key and index are the referring to the same array */
function indexMismatch( key, i) {
  if ( zumeTraining.groups[i].key !== key ) {
    return true;
  }
  return false;
}


/**
 * PROGRESS PANEL
 */
function get_progress() {
  let div = jQuery('#progress-stats')
  div.empty()

div.append(`
<div class="cell">
    <div class="grid-y">
        <div class="cell center padding-1">
            <span class="hide-for-small-only" style="position:absolute; right:15px;"><a onclick="load_host_description()" class="help-question-mark">?</a></span>
            <h2 class="padding-bottom-0">${_.escape( i18n.str.x47 )/*Progress*/}</h2>
            <span class="h2-caption">${_.escape( i18n.str.x48 )/*32 Tools and Concepts*/}</span>
        </div>
       <div class="cell clickable" onclick="load_host_description()">
            <div class="grid-x grid-padding-x grid-padding-y center">
                <div class="cell small-3">
                    <div class="progress-stat-title">${_.escape( i18n.str.x49 )/*Heard*/}</div>
                    <div class="circle-background" id="h_total">0</div>
                </div>
                <div class="cell small-3">
                    <div class="progress-stat-title" onclick="load_host_description()" >${_.escape( i18n.str.x50 )/*Obeyed*/}</div>
                    <div class="circle-background" id="o_total">0</div>
                </div>
                <div class="cell small-3">
                    <div class="progress-stat-title" onclick="load_host_description()" >${_.escape( i18n.str.x51 )/*Shared*/}</div>
                    <div class="circle-background" id="s_total">0</div>
                </div>
                <div class="cell small-3 center">
                    <div class="progress-stat-title" onclick="load_host_description()" >${_.escape( i18n.str.x52 )/*Trained*/}</div>
                    <div class="circle-background" id="t_total">0</div>
                </div>
            </div>
        </div>
        <div class="cell clickable" onclick="load_host_description()">
             <div class="grid-x">
                <div class="cell small-3"><div class="grid-x"><div class="cell small-6"></div><div class="cell small-6 v-line h-line"></div></div></div>
                <div class="cell small-3"><div class="grid-x"><div class="cell small-6 h-line"></div><div class="cell small-6 v-line h-line"></div></div></div>
                <div class="cell small-3"><div class="grid-x"><div class="cell small-6 h-line"></div><div class="cell small-6 v-line h-line"></div></div></div>
                <div class="cell small-3"><div class="grid-x"><div class="cell small-6 h-line"></div><div class="cell small-6 v-line"></div></div></div>
            </div>
            <div class="grid-x">
                <div class="cell"><div class="grid-x"><div class="cell small-6"></div><div class="cell small-6 v-line"></div></div></div>
                <div class="cell center padding-1 hide-for-small-only"><i class="p-icon-style-only complete"></i> ${_.escape( i18n.str.x49 )/*Heard*/} <i class="p-icon-style-only complete"></i> ${_.escape( i18n.str.x50 )/*Obeyed*/} <i class="p-icon-style-only complete"></i> ${_.escape( i18n.str.x51 )/*Shared*/} <i class="p-icon-style-only complete"></i> ${_.escape( i18n.str.x52 )/*Trained*/}</div>
                <div class="cell padding-bottom-1 hide-for-small-only"><div class="grid-x"><div class="cell small-6"></div><div class="cell small-6 v-line"></div></div></div>
                <div class="cell center"><i class="p-icon-style-only complete"></i><i class="p-icon-style-only complete"></i><i class="p-icon-style-only complete"></i><i class="p-icon-style-only complete"></i></div>
            </div>
        </div>
       <div class="cell padding-1"><hr></div>
       <div class="cell center padding-bottom-1">
          <h2>${_.escape( i18n.str.x53 )/*Checklist*/}</h2>
          <span class="h2-caption">${_.escape( i18n.str.x91 )/*Click the circles and check off your progress on each of the concepts.*/}</span><br>
          <span class="h2-caption"><i class="p-icon-style-only complete"></i> ${_.escape( i18n.str.x49 )/*Heard*/} <i class="p-icon-style-only complete"></i> ${_.escape( i18n.str.x50 )/*Obeyed*/} <i class="p-icon-style-only complete"></i> ${_.escape( i18n.str.x51 )/*Shared*/} <i class="p-icon-style-only complete"></i> ${_.escape( i18n.str.x52 )/*Trained*/}</span>
       </div>
       <div class="cell padding-top-1">
            <div class="grid-x grid-padding-x">
                <div class="cell medium-1 hide-for-small-only"></div>
                  <div class="cell medium-5">
                      <div class="grid-x grid-padding-x progress-list">
                          <div class="cell p-session-separator">
                          ${_.escape( zumeTraining.translations.sessions[1] )}
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[1] )}">${_.escape( zumeTraining.translations.titles[1] )}</a></span>
                            <i class="p-icon" id="1h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="1o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="1s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="1t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[1] )}">${_.escape( zumeTraining.translations.titles[1] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[2] )}">${_.escape( zumeTraining.translations.titles[2] )}</a></span>
                            <i class="p-icon" id="2h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="2o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="2s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="2t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[2] )}">${_.escape( zumeTraining.translations.titles[2] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[3] )}">${_.escape( zumeTraining.translations.titles[3] )}</a></span>
                            <i class="p-icon" id="3h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="3o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="3s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="3t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[3] )}">${_.escape( zumeTraining.translations.titles[3] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[4] )}">${_.escape( zumeTraining.translations.titles[4] )}</a></span>
                            <i class="p-icon" id="4h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="4o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="4s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="4t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[4] )}">${_.escape( zumeTraining.translations.titles[4] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[5] )}">${_.escape( zumeTraining.translations.titles[5] )}</a></span>
                            <i class="p-icon" id="5h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="5o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="5s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="5t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[5] )}">${_.escape( zumeTraining.translations.titles[5] )}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[2] )}</a>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[6] )}">${_.escape( zumeTraining.translations.titles[6] )}</a></span>
                            <i class="p-icon" id="6h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="6o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="6s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="6t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[6] )}">${_.escape( zumeTraining.translations.titles[6] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[7] )}">${_.escape( zumeTraining.translations.titles[7] )}</a></span>
                            <i class="p-icon" id="7h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="7o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="7s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="7t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[7] )}">${_.escape( zumeTraining.translations.titles[7] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[8] )}">${_.escape( zumeTraining.translations.titles[8] )}</a></span>
                          <i class="p-icon" id="8h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="8o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="8s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="8t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[8] )}">${_.escape( zumeTraining.translations.titles[8] )}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[3] )}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[9] )}">${_.escape( zumeTraining.translations.titles[9] )}</a></span>
                          <i class="p-icon" id="9h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="9o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="9s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="9t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[9] )}">${_.escape( zumeTraining.translations.titles[9] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[10] )}">${_.escape( zumeTraining.translations.titles[10] )}</a></span>
                          <i class="p-icon" id="10h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="10o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="10s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="10t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[10] )}">${_.escape( zumeTraining.translations.titles[10] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[11] )}">${_.escape( zumeTraining.translations.titles[11] )}</a></span>
                          <i class="p-icon" id="11h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="11o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="11s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="11t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[11] )}">${_.escape( zumeTraining.translations.titles[11] )}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[4] )}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[12] )}">${_.escape( zumeTraining.translations.titles[12] )}</a></span>
                          <i class="p-icon" id="12h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="12o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="12s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="12t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[12] )}">${_.escape( zumeTraining.translations.titles[12] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[13] )}">${_.escape( zumeTraining.translations.titles[13] )}</a></span>
                          <i class="p-icon" id="13h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="13o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="13s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="13t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[13] )}">${_.escape( zumeTraining.translations.titles[13] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[14] )}">${_.escape( zumeTraining.translations.titles[14] )}</a></span>
                          <i class="p-icon" id="14h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="14o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="14s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="14t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[14] )}">${_.escape( zumeTraining.translations.titles[14] )}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[15] )}">${_.escape( zumeTraining.translations.titles[15] )}</a></span>
                          <i class="p-icon" id="15h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="15o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="15s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="15t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[15] )}">${_.escape( zumeTraining.translations.titles[15] )}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[16] )}">${_.escape( zumeTraining.translations.titles[16] )}</a></span>
                          <i class="p-icon" id="16h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="16o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="16s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="16t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[16] )}">${_.escape( zumeTraining.translations.titles[16] )}</a></span>
                          </div>
                            <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[5] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[17] )}">${_.escape( zumeTraining.translations.titles[17] )}</a></span>
                        <i class="p-icon" id="17h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="17o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="17s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="17t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[17] )}">${_.escape( zumeTraining.translations.titles[17] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[18] )}">${_.escape( zumeTraining.translations.titles[18] )}</a></span>
                        <i class="p-icon" id="18h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="18o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="18s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="18t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[18] )}">${_.escape( zumeTraining.translations.titles[18] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[19] )}">${_.escape( zumeTraining.translations.titles[19] )}</a></span>
                        <i class="p-icon" id="19h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="19o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="19s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="19t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[19] )}">${_.escape( zumeTraining.translations.titles[19] )}</a></span>
                        </div>
                      </div>
                  </div>
                  <div class="cell medium-5">
                    <div class="grid-x grid-padding-x progress-list">
                        <div class="cell p-session-separator session-6-column-top">
                          ${_.escape( zumeTraining.translations.sessions[6] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[20] )}">${_.escape( zumeTraining.translations.titles[20] )}</a></span>
                        <i class="p-icon" id="20h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="20o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="20s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="20t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[20] )}">${_.escape( zumeTraining.translations.titles[20] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[21] )}">${_.escape( zumeTraining.translations.titles[21] )}</a></span>
                        <i class="p-icon" id="21h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="21o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="21s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="21t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[21] )}">${_.escape( zumeTraining.translations.titles[21] )}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[7] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[22] )}">${_.escape( zumeTraining.translations.titles[22] )}</a></span>
                        <i class="p-icon" id="22h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="22o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="22s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="22t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[22] )}">${_.escape( zumeTraining.translations.titles[22] )}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[8] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[23] )}">${_.escape( zumeTraining.translations.titles[23] )}</a></span>
                        <i class="p-icon" id="23h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="23o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="23s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="23t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[23] )}">${_.escape( zumeTraining.translations.titles[23] )}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[9] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[24] )}">${_.escape( zumeTraining.translations.titles[24] )}</a></span>
                        <i class="p-icon" id="24h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="24o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="24s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="24t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[24] )}">${_.escape( zumeTraining.translations.titles[24] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[25] )}">${_.escape( zumeTraining.translations.titles[25] )}</a></span>
                        <i class="p-icon" id="25h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="25o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="25s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="25t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[25] )}">${_.escape( zumeTraining.translations.titles[25] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[26] )}">${_.escape( zumeTraining.translations.titles[26] )}</a></span>
                        <i class="p-icon" id="26h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="26o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="26s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="26t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[26] )}">${_.escape( zumeTraining.translations.titles[26] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[27] )}">${_.escape( zumeTraining.translations.titles[27] )}</a></span>
                        <i class="p-icon" id="27h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="27o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="27s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="27t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[27] )}">${_.escape( zumeTraining.translations.titles[27] )}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[10] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[28] )}">${_.escape( zumeTraining.translations.titles[28] )}</a></span>
                        <i class="p-icon" id="28h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="28o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="28s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="28t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[28] )}">${_.escape( zumeTraining.translations.titles[28] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[29] )}">${_.escape( zumeTraining.translations.titles[29] )}</a></span>
                        <i class="p-icon" id="29h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="29o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="29s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="29t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[29] )}">${_.escape( zumeTraining.translations.titles[29] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[30] )}">${_.escape( zumeTraining.translations.titles[30] )}</a></span>
                        <i class="p-icon" id="30h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="30o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="30s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="30t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[30] )}">${_.escape( zumeTraining.translations.titles[30] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[31] )}">${_.escape( zumeTraining.translations.titles[31] )}</a></span>
                        <i class="p-icon" id="31h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="31o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="31s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="31t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[31] )}">${_.escape( zumeTraining.translations.titles[31] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[32] )}">${_.escape( zumeTraining.translations.titles[32] )}</a></span>
                        <i class="p-icon" id="32h" title="${_.escape( i18n.str.x49 )/*Heard*/}"></i><i class="p-icon" id="32o" title="${_.escape( i18n.str.x50 )/*Obeyed*/}"></i><i class="p-icon" id="32s" title="${_.escape( i18n.str.x51 )/*Shared*/}"></i><i class="p-icon" id="32t" title="${_.escape( i18n.str.x52 )/*Trained*/}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[32] )}">${_.escape( zumeTraining.translations.titles[32] )}</a></span>
                        </div>
                    </div>
                  </div>
                  <div class="cell medium-1 hide-for-small-only"></div>
            </div>
        </div>
        <div class="cell padding-2"></div>
    </div> <!-- grid-y -->
</div> <!-- cell -->
`)
  load_progress()
  listen_progress_item()
  load_progress_totals()

  jQuery("a[href='']").addClass('no-link') // mute links that have no corresponding page.
}
function listen_progress_item() {
  jQuery('.p-icon').on( 'click', function(){
    let item = jQuery(this)
    if ( item.hasClass("complete") ) {
      item.removeClass('complete')

      API.update_progress( item.attr('id'), 'off' )

      zumeTraining.progress[item.attr('id')] = ''

      load_progress_totals()
    } else {
      item.addClass('complete')

      API.update_progress( item.attr('id'), 'on' )

      zumeTraining.progress[item.attr('id')] = Date.now()

      load_progress_totals()
    }
  })
}
function load_progress() {
  jQuery.each( zumeTraining.progress, function(i,v) {
      if ( v ) {
        jQuery('#'+i).addClass('complete')
      }
  })
}
function load_progress_totals() {
  let total = {
    'h': 0,
    'o': 0,
    's': 0,
    't': 0,
  }
  jQuery.each( zumeTraining.progress, function(i,v) {
    if ( v ) {
      total[i.charAt(i.length - 1)]++
    }
  })
  jQuery('#h_total').html(total['h'])
  jQuery('#o_total').html(total['o'])
  jQuery('#s_total').html(total['s'])
  jQuery('#t_total').html(total['t'])
}
function load_host_description() {
  jQuery('#training-modal-content').empty().html(`
<style>.p-icon-help {
        border: 1px solid #00aeff;
        border-radius: 50%;
        background-color: #00aeff;
        width: 20px;
        height: 20px;
        margin:0 3px;
        display: inline-block;
        vertical-align: middle;
    }</style>
    <p><strong>${_.escape( i18n.str.x54 )/*Progress Overview*/}</strong></p>
    <p>${_.escape( i18n.str.x55 )/*There are 32 concepts and tools in Zúme training. Each concept or tool is intended to be practiced personally and trained into others. Use the progression of "heard", "obeyed", "shared", and "trained" as a way of tracking your mastery of the disciple-making training.*/}</p>
    <p><strong>${_.escape( i18n.str.x56 )/*Definitions*/}</strong></p>
    <table>
    <tr><td style="white-space: nowrap"><i class="p-icon-help"></i> ${_.escape( i18n.str.x49 )/*Heard*/}</td><td>${_.escape( i18n.str.x57 )/*"Heard" means you gained awareness. You have moved from not knowing about a tool or concept to knowing about it.*/}</td></tr>
    <tr><td style="white-space: nowrap"><i class="p-icon-help"></i> ${_.escape( i18n.str.x50 )/*Obeyed*/}</td><td>${_.escape( i18n.str.x58 )/*"Obeyed" means you took personal action to practice or apply a concept or tool. Obeying with tools might look like beginning to use them with others, while obeying with concepts might look like changing thinking or priorities.*/}</td></tr>
    <tr><td style="white-space: nowrap"><i class="p-icon-help"></i> ${_.escape( i18n.str.x51 )/*Shared*/}</td><td>${_.escape( i18n.str.x59 )/*"Shared" means you helped someone else hear. This step is essential to truly understanding the concept or tool and preparing you to train others.*/}</td></tr>
    <tr><td style="white-space: nowrap"><i class="p-icon-help"></i> ${_.escape( i18n.str.x52 )/*Trained*/}</td><td>${_.escape( i18n.str.x60 )/*"Trained" means you coached someone else to hear, obey and share. More than sharing knowledge with someone, you have helped them become a sharer of the tool or concept.*/}</td></tr>
</table>
  `)

  jQuery('#training-modal').foundation('open')
}

/************
 * Send Coaching Request
 ************/

function get_coach_request() {

    jQuery('#coach-request').empty().html(`

    <div class="grid-x" id="coaching-request-form-section">
        <div class="cell">
        <h2 class="primary-color hide-for-small-only request-form" id="coach-modal-title">${_.escape( i18n.str.x61 )/*Connect Me to a Coach*/}</h2>
            <hr class="hide-for-small-only request-form">

                <div class="grid-x grid-padding-x" >

                    <dv class="cell medium-6">
                        <i class="fi-torsos-all secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span class="coach-title">${_.escape( i18n.str.x62 )/*Coaches*/}</span>
                        <p class="coach-body">${_.escape( i18n.str.x63 )/*Our network of volunteer coaches are people like you, people who are passionate about loving God, loving others, and obeying the Great Commission.*/}</p>
                    </dv>

                    <div class="cell medium-6">
                        <i class="fi-compass secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span class="coach-title">${_.escape( i18n.str.x64 )/*Advocates*/}</span>
                        <p class="coach-body">${_.escape( i18n.str.x65 )/*A coach is someone who will come alongside you as you implement the Zúme tools and training.*/}</p>
                    </div>

                    <div class="cell medium-6">
                        <i class="fi-map secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span class="coach-title">${_.escape( i18n.str.x66 )/*Local*/}</span>
                        <p class="coach-body">${_.escape( i18n.str.x67 )/*On submitting this request, we will do our best to connect you with a coach near you.*/}</p>
                    </div>

                    <div class="cell medium-6">
                        <i class="fi-dollar secondary-color coach-icon" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span class="coach-title">${_.escape( i18n.str.x68 )/*It's Free*/}</span>
                        <p class="coach-body">${_.escape( i18n.str.x69 )/*Coaching is free. You can opt out at any time.*/}</p>
                    </div>

                </div>
                <div id="already-submitted"></div>
                <div id="form-container"></div>

        </div>
    </div>
  `)

  // check if already submitted coaching request
  write_request_form()

  if ( zumeTraining.user_profile_fields.zume_global_network ) {
    write_coaching_status()
  }

}

function write_request_form() {
  let fields = zumeTraining.user_profile_fields
  if ( ! zumeTraining.logged_in ) {
    window.location = `${zumeTraining.site_urls.login}`
  } else { /* logged in */

  let location_grid_meta_label = ''
  if (fields.location_grid_meta) {
    window.location_grid_meta = fields.location_grid_meta
    window.mapbox_results = false
    location_grid_meta_label = fields.location_grid_meta.label
  } else {
    window.location_grid_meta = false
    window.mapbox_results = false
    location_grid_meta_label = ''
  }

  let languages = ''
    jQuery.each( zumeTraining.languages, function( i, v ){
      languages += '<option value="'+v.code+'">'+v.enDisplayName + ' - ' + v.nativeName+'</option>'
    })

  jQuery('#form-container').empty().html(`
  <form id="coaching-request-form" data-abide>
      <div data-abide-error class="alert callout" style="display: none;">
          <p><i class="fi-alert"></i> ${_.escape( i18n.str.x70 )/*There are some errors in your form.*/}</p>
      </div>
      <table class="request-form">
          <tr style="vertical-align: top;">
              <td>
                  <label for="zume_full_name">${_.escape( i18n.str.x71 )/*Name*/}</label>
              </td>
              <td>
                  <input type="text"
                         placeholder="${_.escape( i18n.str.x72 )/*First and last name*/}"
                         aria-describedby="${_.escape( i18n.str.x72 )/*First and last name*/}"
                         class="profile-input"
                         id="zume_full_name"
                         name="zume_full_name"
                         value="${_.escape(fields.name)}"
                         required />
              </td>
          </tr>
          <tr>
              <td style="vertical-align: top;">
                  <label for="zume_phone_number">${_.escape( i18n.str.x73 )/*Phone Number*/}</label>
              </td>
              <td>
                  <input type="tel"
                         placeholder="111-111-1111"
                         class="profile-input"
                         id="zume_phone_number"
                         name="zume_phone_number"
                         value="${_.escape(fields.phone)}"
                         required
                  />
              </td>
          </tr>
          <tr>
              <td style="vertical-align: top;">
                  <label for="user_email">${_.escape( i18n.str.x74 )/*Email*/}</label>
              </td>
              <td>
                  <input type="text"
                         class="profile-input"
                         placeholder="name@email.com"
                         id="user_email"
                         name="user_email"
                         value="${_.escape(fields.email)}"
                         required
                         readonly
                  />
                  <span class="form-error">
                     ${_.escape( i18n.str.x75 )/*Email is required.*/}
                  </span>
              </td>
          </tr>

          <tr>
              <td style="vertical-align: top;">
                  <label for="validate_address">
                      ${_.escape( i18n.str.x76 )/*City*/}
                  </label>
              </td>
              <td>
                <div class="input-group">
                    <input type="text"
                           placeholder="${_.escape( i18n.str.x77 )/*What is your city or state or postal code?*/}"
                           class="profile-input input-group-field"
                           id="validate_address"
                           name="validate_address"
                           value="${_.escape(location_grid_meta_label)}"
                           onkeyup="validate_timer(jQuery(this).val())"
                           required
                    />
                    <div class="input-group-button">
                        <button class="button hollow" id="spinner_button" style="display:none;"><img src="${zumeTraining.theme_uri}/assets/images/spinner.svg" alt="spinner" style="width: 18px;" /></button>
                    </div>
                </div>

                <div id="possible-results">
                    <input type="radio" style="display:none;" name="zume_user_address" id="zume_user_address" value="current" checked/>
                </div>
            </td>
          </tr>
          <tr>
              <td style="vertical-align: top;">
                  <label>${_.escape( i18n.str.x78 )/*How should we contact you?*/}</label>
              </td>
              <td>
                  <fieldset>
                      <input id="zume_contact_preference1" name="zume_contact_preference" class="zume_contact_preference" type="radio" value="email" checked data-abide-ignore>
                      <label for="zume_contact_preference1">${_.escape( i18n.str.x74 )/*Email*/}</label>
                      <input id="zume_contact_preference2" name="zume_contact_preference" class="zume_contact_preference" type="radio" value="text" data-abide-ignore>
                      <label for="zume_contact_preference2">${_.escape( i18n.str.x79 )/*Text*/}</label>
                      <input id="zume_contact_preference3" name="zume_contact_preference" class="zume_contact_preference" type="radio" value="phone" data-abide-ignore>
                      <label for="zume_contact_preference3">${_.escape( i18n.str.x80 )/*Phone*/}</label>
                      <input id="zume_contact_preference4" name="zume_contact_preference" class="zume_contact_preference" type="radio" value="whatsapp" data-abide-ignore>
                      <label for="zume_contact_preference4">${_.escape( i18n.str.x81 )/*WhatsApp*/}</label>
                      <input id="zume_contact_preference5" name="zume_contact_preference" class="zume_contact_preference" type="radio" value="other" data-abide-ignore>
                      <label for="zume_contact_preference6">${_.escape( i18n.str.x82 )/*Other*/}</label>
                  </fieldset>
              </td>
          </tr>
          <tr>
              <td style="vertical-align: top;">
                  <label for="zume_affiliation_key">Language Preference</label>
              </td>
              <td>
                  <select id="language_preference">
                    <option value="${zumeTraining.current_language}">${zumeTraining.current_language_name}</option>
                    <option disabled>----</option>
                    ${languages}
                  </select>
              </td>
          </tr>
          <tr>
              <td style="vertical-align: top;">
                  <label for="zume_affiliation_key">${_.escape( i18n.str.x83 )/*Affiliation Notes*/}</label>
              </td>
              <td>
                  <input type="text" value="${fields.affiliation_key}"
                         id="zume_affiliation_key"
                         name="zume_affiliation_key" placeholder="" />
              </td>
          </tr>
          <tr>
              <td style="vertical-align: top;">
                  <label for="zume_coaching_preference">${_.escape( i18n.str.x96 )/*Affiliation Notes*/}</label>
              </td>
              <td>
                  <fieldset>
                      <label>
                          <input name="zume_coaching_preference" class="zume_coaching_preference" type="checkbox" value="coaching" checked data-abide-ignore>
                          <span id="zume_coaching_preference_coaching">${_.escape( i18n.str.x97 )/*I want to be coached.*/}</span>
                      </label>
                      <label>
                          <input name="zume_coaching_preference" class="zume_coaching_preference" type="checkbox" value="technical_assistance" data-abide-ignore>
                          <span id="zume_coaching_preference_technical_assistance">${_.escape( i18n.str.x98 )/*I need technical assistance.*/}</span>
                      </label>
                      <label>
                          <input name="zume_coaching_preference" class="zume_coaching_preference" type="checkbox" value="advice_on_implementation" data-abide-ignore>
                          <span id="zume_coaching_preference_advice_on_implementation">${_.escape( i18n.str.x99 )/*I've gone through the training but need advice on implementation.*/}</span>
                      </label>
                      <label>
                          <input name="zume_coaching_preference" class="zume_coaching_preference" type="checkbox" value="content_question" data-abide-ignore>
                          <span id="zume_coaching_preference_content_question">${_.escape( i18n.str.x100 )/*I have a question about the content that I need to talk to somebody else about.*/}</span>
                      </label>
                      <label>
                          <input name="zume_coaching_preference" class="zume_coaching_preference" type="checkbox" value="group_started" data-abide-ignore>
                          <span id="zume_coaching_preference_group_started">${_.escape( i18n.str.x101 )/*I have a group started and need to know where do I go next.*/}</span>
                      </label>
                      <label style="display: flex; align-items:center">
                          <input name="zume_coaching_preference" class="zume_coaching_preference" type="checkbox" value="other" data-abide-ignore style="margin-bottom:2px;margin-top:0">
                          <div style="margin-inline-end:10px; margin-inline-start: 2px">
                            <span id="zume_coaching_preference_other">${_.escape( i18n.str.x102 )/*Other.*/}:</span>
                          </div>
                          <input name="zume_coaching_preference_other_text" id="zume_coaching_preference_other_text" type="text" style="display:inline-block; margin-bottom: 0">
                      </label>
                  </fieldset>
              </td>
        </tr>
      </table>
      <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
          <strong>${_.escape( i18n.str.x90 )/*Oh snap!*/}</strong>
      </div>
      <div class="cell request-form">
           <p>${_.escape( i18n.str.x84 )/*On submitting this request, we will do our best to connect you with a coach near you.*/}</p>
          <button class="button" type="button" onclick="load_form_validator()" id="submit_request">${_.escape( i18n.str.x85 )/*Submit*/}</button> <span id="request_spinner"></span>
      </div>
  </form>
  `)

    jQuery('.request-form').show()

    var elem = new Foundation.Abide(jQuery('#coaching-request-form'))

    let validate_address_textbox = jQuery('#validate_address')

    validate_address_textbox.keyup(function () {
      check_address()
    });

    validate_address_textbox.on('keypress', function (e) {
      if (e.which === 13) {
        validate_user_address_v4(validate_address_textbox.val())
        clear_timer()
      }
    });

    jQuery(document)
      .on("formvalid.zf.abide", function (ev, frm) {
        send_coaching_request()
      })
  }
}

function write_coaching_status() {
  let fields = zumeTraining.user_profile_fields.zume_global_network
  jQuery('#already-submitted').empty().html(`
  <hr>
  <h3 class="center">${_.escape( i18n.str.x86 )/*You have requested coaching.*/}</h3>
  <hr>
  `)
}

// delay location lookup
window.validate_timer_id = '';
function validate_timer(user_address) {
  // clear previous timer
  clear_timer()

  // toggle buttons
  jQuery('#validate_address_button').hide()
  jQuery('#spinner_button').show()

  // set timer
  window.validate_timer_id = setTimeout(function(){
    // call geocoder
    validate_user_address_v4(user_address)
    // toggle buttons back
    jQuery('#validate_address_button').show()
    jQuery('#spinner_button').hide()
  }, 1500);
}
function clear_timer() {
  clearTimeout(window.validate_timer_id);
}
// end delay location lookup

function validate_user_address_v4(user_address){

  if ( user_address.length < 1 ) {
    return;
  }

  let root = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
  let settings = '.json?types=country,region,postcode,district,place,locality,neighborhood,address&limit=6&access_token='
  let key = zumeTraining.map_key

  let url = root + encodeURI( user_address ) + settings + key

  jQuery.get( url, function( data ) {

    let possible_results = jQuery('#possible-results')
    possible_results.empty().append(`<fieldset id="multiple-results"></fieldset>`)
    let multiple_results = jQuery('#multiple-results')

    if( data.features.length < 1 ) {
      multiple_results.empty().append(`${_.escape( i18n.str.x87 )/*No location matches found. Try a less specific address.*/}`)
    }

    // Set globals
    // console.log(data)
    window.location_grid_meta = false
    window.mapbox_results = data

    // loop results
    jQuery.each( data.features, function( index, value ) {
      let checked = ''
      if( index === 0 ) {
        checked = 'checked'
      }
      multiple_results.append( `<input type="radio" name="zume_user_address" id="zume_user_address${_.escape( index )}" value="${_.escape( value.id )}" ${_.escape( checked )} /><label for="zume_user_address${_.escape( index )}">${_.escape( value.place_name )}</label><br>`)
    })

    // add responsive click event to populate text area, if selection is clicked. Expected user feedback.
    jQuery('#multiple-results input').on('click', function( ) {
      let selected_id = jQuery(this).val()
      jQuery.each( window.mapbox_results.features, function(i,v) {
        if ( v.id === selected_id ) {
          jQuery('#validate_address').val(_.escape( v.place_name ))
        }
      })
    })

    // enable save button if not already enabled
    jQuery('#submit_request').removeAttr('disabled')

  }); // end get request
} // end validate_user_address

function load_form_validator() {
  jQuery('#coaching-request-form').foundation('validateForm');
}
function check_address(key) {

  let fields = zumeTraining.user_profile_fields
  let default_address = ''
  if ( fields.location_grid_meta ) {
    default_address = fields.location_grid_meta.label
  }
  let val_address = jQuery('#validate_address').val()
  let results_address = jQuery('#multiple-results').length

  if (val_address === default_address) // exactly same values
  {
    jQuery('#submit_request').removeAttr('disabled')
  }
  else if (results_address) // check if fieldset exists by validation
  {
    jQuery('#submit_request').removeAttr('disabled')
  }
  else if (val_address.length === 0) // check if fieldset exists by validation
  {
    jQuery('#submit_request').removeAttr('disabled')
  }
  else {
    jQuery('#submit_request').attr('disabled', 'disabled')
  }
}


function send_coaching_request() {
  jQuery('#submit_request').prop('disabled', true )
  let spinner = jQuery('#request_spinner')
  spinner.html( `<img src="${zumeTraining.theme_uri}/assets/images/spinner.svg" style="width: 40px; vertical-align:top; margin-left: 5px;" alt="spinner" />` )

  let name = jQuery('#zume_full_name').val()
  let phone = jQuery('#zume_phone_number').val()
  let email = jQuery('#user_email').val()
  let preference = jQuery('input.zume_contact_preference:checked').val()
  let language_preference = jQuery('#language_preference').val()
  let affiliation_key = jQuery('#zume_affiliation_key').val()
  let coaching_preferences = [];
  jQuery('.zume_coaching_preference:checked').each((i,v)=>{
    let value = jQuery(v).val()
    let text = jQuery('#zume_coaching_preference_' + value).text()
    if ( value === "other"){
       text += ' ' + jQuery('#zume_coaching_preference_other_text').val();
    }
    coaching_preferences.push( text )
  })

  /**************/
  // Get address
  let location_grid_meta = false // base is false
  let selection_id = jQuery('#possible-results input:checked').val()

  // check if location grid
  if ( window.location_grid_meta && selection_id === 'current' ) {
    location_grid_meta = window.location_grid_meta
  }
  // check if mapbox results
  else if ( window.mapbox_results ) {
      // loop through features
      jQuery.each( window.mapbox_results.features, function(i,v) {
        if ( v.id === selection_id ) {
          location_grid_meta = {
            lng: v.center[0],
            lat: v.center[1],
            level: v.place_type[0],
            label: v.place_name,
            source: 'user',
            grid_id: false
          }
        }
      })
  }
  /**************/

  let data = {
    "name": name,
    "phone": phone,
    "email": email,
    "location_grid_meta": location_grid_meta,
    "language_preference": language_preference,
    "preference": preference,
    "affiliation_key": affiliation_key,
    "coaching_preference": coaching_preferences.join(',\n'),
  }

  API.coaching_request( data ).done( function(data) {
    console.log('postsend')
    console.log(data)
    jQuery('#coaching-request-form').hide()
    write_coaching_status()
  })
    .fail(function(e){
      console.log('coach_request error')
      console.log(e)
      spinner.empty().html( `${i18n.str.x88/*Oops. Something went wrong. Try again!*/}`)
    })

  if (typeof window.movement_logging !== "undefined") {
    window.movement_logging({
      "action": "coaching",
      "category": "joining",
      "data-language_code": zumeTraining.current_language,
      "data-language_name": zumeTraining.current_language_name,
      "data-note": "is requesting coaching from Zúme coaches!"
    })
  }
}

/**************************************************/
// Network Links
/**************************************************/
function write_network_tab() {
  if ( zumeTraining.zume_network_sites ) {
    jQuery('#training-tabs').append(`
        <li class="tabs-button float-right">
           <button type="button" class="hide-for-small-only" onclick="open_network_links()">
                ${_.escape( i18n.str.x89 )/*Zúme Network*/}
           </button>
           <button type="button" class="show-for-small-only" onclick="open_network_links()">
                <i class="fi-torsos-all"></i>
           </button>
       </li>`)
  }
}
function open_network_links() {
  let list = ''
  jQuery.each( zumeTraining.zume_network_sites, function(i,v) {
    list += '<li><a href="'+_.escape( v.siteurl )+'">' + _.escape( v.blogname ) + '</a></li>'
  })

  jQuery('#training-modal-content').empty().html(`
    <div class="grid-x training">
        <div class="cell">
            <h2 class="center">${i18n.str.x89/*Zúme Network*/}</h2>
            <hr>
            <ul class="center" style="list-style:none;">${list}</ul>

            <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

    </div>
  `)

  jQuery('#training-modal').foundation('open')
}



/**
 * REST API
 */
window.API = {

  update_progress: (key, state) => makeRequest('POST', 'progress/update', { key: key, state: state }),

  update_group: ( key, value, item ) => makeRequest('POST', 'groups/update', { key: key, value: value, item: item }),

  create_group: ( group_name, members ) => makeRequest('POST', 'groups/create', { name: group_name, members: members }),

  update_location: ( data ) => makeRequest('POST', 'locations/update', data ),

  coaching_request: ( data ) => makeRequest('POST', 'coaching_request', data ),

}
function makeRequest (type, url, data, base = 'zume/v4/') {
  const options = {
    type: type,
    contentType: 'application/json; charset=utf-8',
    dataType: 'json',
    url: url.startsWith('http') ? url : `${zumeTraining.root}${base}${url}`,
    beforeSend: xhr => {
      xhr.setRequestHeader('X-WP-Nonce', zumeTraining.nonce);
    }
  }

  if (data) {
    options.data = JSON.stringify(data)
  }

  return jQuery.ajax(options)
}
function handleAjaxError (err) {
  if (_.get(err, "statusText") !== "abortPromise" && err.responseText){
    console.trace("error")
    console.log(err)
    // jQuery("#errors").append(err.responseText)
  }
}
jQuery(document).ajaxComplete((event, xhr, settings) => {
  if (_.get(xhr, 'responseJSON.data.status') === 401) {
    window.location.replace(zumeTraining.site_urls.login);
  }
}).ajaxError((event, xhr) => {
  handleAjaxError(xhr)
})
