_ = _ || window.lodash // make sure lodash is defined so plugins like gutenberg don't break it.
const { __, _x, _n, _nx } = wp.i18n;

/**
 * PANEL LOADER
 */
jQuery(document).ready(function(){
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
  })
})


/**
 * COURSE PANEL
 */
// listeners
jQuery(document).ready(function(){
  if ( getCookie( 'extra' ) === "on") {
    jQuery('#extra_button').removeClass('hollow')
    jQuery('.hide-extra').show();
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
    jQuery('.session').removeClass('medium-6')
    setCookie('columns', 'single', 30)
  } else {
    item.addClass('hollow')
    jQuery('.session').addClass('medium-6')
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
        <div class="cell padding-bottom-1 group-name small-6"  id="group_name_${_.escape( v.key )}"><!--Full width top --></div><div class="small-6"></div>
        <div class="cell small-2"> <!-- Column 1 -->
           <div class="grid-y" id="session_list_${_.escape( v.key )}"><!-- Session List --></div>
        </div> <!-- Column 1 -->
        <div class="cell small-4">
            <div class="grid-y">
                  <div class="cell column-header">${__('Members', 'zume')}</div>
                  <div class="cell padding-bottom-1">
                      <select class="member-count" onchange="save_member_count('${_.escape( v.key )}', ${_.escape( i )})" id="member_count_${_.escape( v.key )}"><!-- member count --></select>
                  </div>
                  <div class="cell column-header">${__('Members List (optional)', 'zume')}</div>
                  <div class="cell">
                      <div class="grid-y" id="member_list_${_.escape( v.key )}"><!-- member list --></div>
                  </div>
                  <div class="cell add-member" id="add_member_${_.escape( v.key )}"><!-- add member area --></div>
            </div>
        </div> <!-- Column 2 -->
        <div class="cell small-4"> <!-- Column 3 -->
            <div class="grid-y">
                <div class="cell">
                  <span class="column-header">${__('Location', 'zume')}</span>
                </div>
                <div class="cell" id="map_${_.escape( v.key )}"><!-- Map Section--></div>
                <div class="cell" id="add_location_${_.escape( v.key )}"><!-- Add Location Field --></div>
            </div>
        </div> <!-- Column 3 -->
        <div class="cell small-2">
              <div class="grid-y" id="meta_column_${_.escape( v.key )}"><!-- Meta column buttons --></div>
        </div> <!-- Column 4 -->
      </div>
  </div>
      `)

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
        <input type="button" class="button" onclick="save_group_name('${_.escape( key )}', ${_.escape( i )})" value="Save">
      </div>
      <div class="input-group-button">
        <input type="button" class="button hollow" onclick="write_group_name('${_.escape( key )}', ${_.escape( i )} )" value="Cancel">
      </div>
    </div>
  `) /* end html */
  jQuery('#edit_group_name_'+key).focus()
}
function save_group_name( key, i ) {
  let new_name = jQuery('#edit_group_name_'+key).val()
  if ( new_name ) {

    API.update_group( key, _.escape( new_name ), 'group_name' )

    zumeTraining.groups[i].group_name = _.escape( new_name )

  }
  write_group_name( key, i )
}

function write_session_progress( key, i ) {
  let div = jQuery('#session_list_'+key)
  let group = zumeTraining.groups[i]

  div.empty().append(`
  <div class="cell"><i class="g-session-icon" id="s1${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 1)"></i> <a href="${get_course_url_with_params(1, _.escape( i ) )}">${__('Session 1', 'zume')}</a></div>    
  <div class="cell"><i class="g-session-icon" id="s2${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 2)"></i> <a href="${get_course_url_with_params(2, _.escape( i ) )}">${__('Session 2', 'zume')}</a></div>    
  <div class="cell"><i class="g-session-icon" id="s3${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 3)"></i> <a href="${get_course_url_with_params(3, _.escape( i ) )}">${__('Session 3', 'zume')}</a></div>    
  <div class="cell"><i class="g-session-icon" id="s4${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 4)"></i> <a href="${get_course_url_with_params(4, _.escape( i ) )}">${__('Session 4', 'zume')}</a></div>    
  <div class="cell"><i class="g-session-icon" id="s5${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 5)"></i> <a href="${get_course_url_with_params(5, _.escape( i ) )}">${__('Session 5', 'zume')}</a></div>    
  <div class="cell"><i class="g-session-icon" id="s6${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 6)"></i> <a href="${get_course_url_with_params(6, _.escape( i ) )}">${__('Session 6', 'zume')}</a></div>    
  <div class="cell"><i class="g-session-icon" id="s7${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 7)"></i> <a href="${get_course_url_with_params(7, _.escape( i ) )}">${__('Session 7', 'zume')}</a></div>    
  <div class="cell"><i class="g-session-icon" id="s8${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 8)"></i> <a href="${get_course_url_with_params(8, _.escape( i ) )}">${__('Session 8', 'zume')}</a></div>    
  <div class="cell"><i class="g-session-icon" id="s9${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 9)"></i> <a href="${get_course_url_with_params(9, _.escape( i ) )}">${__('Session 9', 'zume')}</a></div>    
  <div class="cell"><i class="g-session-icon" id="s10${_.escape( key )}" onclick="save_session_status('${_.escape( key )}', ${_.escape( i )}, 10)"></i> <a href="${get_course_url_with_params(10, _.escape( i ) )}">${__('Session 10', 'zume')}</a></div>
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
      alert(`${__('Connection to server failed. Try again.', 'zume')}`)
      conole.log('update group session status fail')
      console.log(e)
    })
  }

}
function write_member_count( key, group ) {
    let list = ''
    let i = 1
    while ( i < 30) {
      list += '<option value="'+_.escape( i )+'"';
      if ( parseInt( group.members ) === i ) {
        list += ' selected'
      }
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
      verified = ''
      if ( _.indexOf( zumeTraining.groups[i].coleaders_accepted, v ) >= 0 ) {
        verified = `<i class="fi-check secondary-color" title="${__('Accepted invitation', 'zume')}"></i>`
      }
      div.append(`<div class="cell member">${_.escape( v )} ${verified} <span class="delete" onclick="delete_member_list_item( '${_.escape( key )}', ${_.escape( i )}, ${_.escape( ib )}, '${_.escape( v )}' )">${__('delete', 'zume')}</span></div>`)
    }
  })
}
function edit_new_member_list( key, i ) {
  jQuery('#add_member_'+key).empty().append(`
  <hr>
  <input type="text" placeholder="email" id="email_${_.escape( key )}" />
  <button type="button" class="button small" onclick="save_new_member('${_.escape( key )}', ${_.escape( i )})">${__('Save', 'zume')}</button> 
  <button type="button" class="button small hollow" onclick="write_member_list_button('${_.escape( key )}', ${_.escape( i )})">${__('Cancel', 'zume')}</button> 
  `)
  jQuery('#email_'+key).focus()
}
function write_member_list_button( key, i ) {
  if ( isOwner( key, i ) ) {
    jQuery('#add_member_'+key).empty().append(`
    <button type="button" class="button clear" onclick="edit_new_member_list('${_.escape( key )}', ${_.escape( i )})"><i class="fi-plus"></i> ${__('add', 'zume')}</button>
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
        <div class="cell center padding-vertical-0">${__('Zoom, click, or search for your location.', 'zume')}<br><button type="button" onclick="activate_geolocation()" class="button tiny primary-button-hollow margin-top-1">${__('find you current location', 'zume')}</button> </div>
        <div class="cell"><div class="map" id='map' style="width:100%;height:400px;"></div></div>
        <div class="cell center">
          <button type="button" onclick="save_new_location( '${_.escape( key )}', ${_.escape( i )} )" id="result_display" class="button primary-button-hollow">${__('Save', 'zume')}</button>
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

      jQuery('#result_display').html(`${__('Save Clicked Location', 'zume')}`)

      window.current_search_result = {
        lng: lng,
        lat: lat,
        action: 'click',
        level: 'lnglat',
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

      jQuery('#result_display').html(`${__('Save Searched Location', 'zume')}`)

      window.current_search_result = {
        lng: ( e.result.center[0] || false ),
        lat: ( e.result.center[1] || false ),
        action: 'search',
        level: ( e.result.place_type[0] || false ),
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

      jQuery('#result_display').html(`${__('Save Current Location', 'zume')}`)

      window.current_search_result = {
        lng: lng,
        lat: lat,
        action: 'geolocate',
        level: 'lnglat',
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
    jQuery('#result_display').html(`${__("You haven't selected anything yet. Click, search, or allow auto location.", 'zume')}`)
    return;
  }
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
  if ( group.lng && isOwner( key, i ) ) {
    jQuery('#add_location_'+_.escape( key ))
      .empty()
      .append(`<img width="400" src="https://api.mapbox.com/styles/v1/mapbox/streets-v9/static/pin-m-marker+0096ff(${_.escape( group.lng )},${_.escape( group.lat )})/${_.escape( group.lng )},${_.escape( group.lat )},${( _.escape( group.zoom ) || 6 )},0/400x250@2x?access_token=${_.escape( zumeTraining.map_key )}" alt="Mapbox Map" />`)
      .append(`<br><button type="button" class="button clear" onclick="add_location_lookup_map('${_.escape( key )}', ${_.escape( i )})"><i class="fi-plus"></i> ${__('update', 'zume')}</button>`)
  }
  else if ( isOwner( key, i ) ) {
    jQuery('#add_location_'+_.escape( key )).empty().append(`
    <button type="button" class="button clear" onclick="add_location_lookup_map('${_.escape( key )}', ${_.escape( i )})"><i class="fi-plus"></i> ${__('add', 'zume')}</button>
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
    div.append(`<div class="cell center">${__('Course Complete', 'zume')}</div>`)
  } else {
    div.append(`
      <div class="cell"><button type="button" onclick="open_session( ${_.escape( zumeTraining.groups[i].next_session )}, '${_.escape( key )}', ${_.escape( i )} );" class="button primary-button expanded">${__('Next Session', 'zume')} ${_.escape( zumeTraining.groups[i].next_session )}</button><!-- Next session --></div>
     `)
  }

  // if owner of the group
  if ( isOwner( key, i ) ) {
    div.append(`<div class="cell center"><button type="button" class="button clear small" onclick="archive_group( '${_.escape( key )}', ${_.escape( i )} );">${__('Archive', 'zume')}</button></div>`)
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
        <div class="cell"><h2 class="center">${__('Welcome to Session', 'zume')} ${_.escape( session_number )}</h2></div>
        <div class="cell callout primary-color margin-2">
            <div class="grid-x padding-right-2 padding-left-2 grid-padding-y" id="not-logged-in">
                <div class="cell center list-head"><h3>${__("You're missing out.", 'zume')} <br>${__('Register Now!', 'zume')}</h3></div> 
                <div class="cell list-reasons">
                    <ul>
                    <li>${__('track your personal training progress', 'zume')}</li>
                    <li>${__('access group planning tools', 'zume')}</li> 
                    <li>${__('connect with a coach', 'zume')}</li> 
                    <li>${__('add your effort to the global vision!', 'zume')}</li>
                    </ul>
                </div> 
                <div class="cell center"><a href="${_.escape( zumeTraining.site_urls.register ) }" class="button expanded large secondary-button">${__('Register for Free', 'zume')}</a><a href="${_.escape( zumeTraining.site_urls.login )}" type="submit" class="button clear padding-bottom-0">${__('Login', 'zume')}</a></div> 
            </div>
        </div>
        <div class="cell center margin-bottom-1"><a class="center button hollow" href="${_.escape( zumeTraining.site_urls.course )}?session=${_.escape( session_number )}">${__('Continue', 'zume')}</a></div>
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
    list += '<option>------------</option><option value="none">'+__('Not Leading a Group', 'zume')+'</option><option value="create_new">'+__('Create New Group', 'zume')+'</option>'

    jQuery('#training-modal-content').empty().html(`
      <div class="grid-y padding-top-1 grid-padding-y training">
        <div class="cell"><h2 class="center">${__('Session', 'zume')} ${_.escape( session_number )}</h2></div>
        <div class="cell center">
        ${__('Which group are you leading?', 'zume')}<br>
          <select onchange="check_group_selection(${_.escape( session_number )})" id="group_selection">${_.escape( list )}</select><br>
          <div id="create_new_group"></div>
        </div>
        <div class="cell center margin-bottom-1" id="continue_button">
          <button type="submit" class="center button large" onclick="continue_to_session(${_.escape( session_number )} )">${__('Continue', 'zume')}</button>
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
          <input type="text" class="input-group-field add-group-input" placeholder="${__('Group Name', 'zume')}" title="${__('Group Name', 'zume')}" name="group_name" id="group_name" /> <br>
          <input type="number" placeholder="${__('Number of Members', 'zume')}" title="${__('Number of Members', 'zume')}" class="input-group-field add-group-input" name="members" /> <br>
          <button type="button" class="button" onclick="save_new_group_and_continue(${_.escape( session_number )})">${__('Save', 'zume')}</button> 
          <button type="button" class="button hollow" onclick="open_session(${_.escape( session_number )})">${__('Cancel', 'zume')}</button>
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
        alert(`${__('Connection to server failed. Try again.', 'zume')}`)
        console.log('error making new group')
        console.log(e)
      })
  }
}
function continue_to_session( session_number ) {
  let item = jQuery('#group_selection').val()
  if( item === 'none' || item === 'create_new' ) {
    window.location = get_course_url_with_params( session_number )
  } else {
    window.location = get_course_url_with_params( session_number, item )
  }
}

function write_add_group_button() {
  jQuery('#add_group_container').html(`<button class="button primary-button-hollow small add-group-button" type="button"><i class="fi-plus"></i> ${__('Add Group', 'zume')}</button>`)
  jQuery('.add-group-button').on('click', function(){

    jQuery(this).parent().empty().html(`
    <div class="grid-x">
        <div class="cell input-group" id="new-group">
            <input type="text" class="input-group-field add-group-input" placeholder="${__('Group Name', 'zume')}" title="${__('Group Name', 'zume')}" name="group_name" id="group_name" />
            <input type="number" placeholder="${__('Number of Members', 'zume')}" title="${__('Number of Members', 'zume')}" class="input-group-field add-group-input" name="members" />
            <button type="button" class="button" onclick="save_new_group()">${__('Save', 'zume')}</button>
            <button type="button" class="button hollow" onclick="write_add_group_button()">${__('Cancel', 'zume')}</button>
        </div>
    </div>
    `)
    jQuery('#group_name').focus()
  })
}
function save_new_group() {
  let group_name = jQuery('#new-group input[name=group_name]').val()
  let members = jQuery('#new-group input[name=members]').val()

  if ( group_name && members ) {
    API.create_group( _.escape( group_name ), _.escape( members ) )
      .done(function(data) {
        zumeTraining.groups = data
        write_add_group_button()
        get_groups()
      })
      .fail(function(e){
        write_add_group_button()
        jQuery('#add_group_container').append(`
    <br>${__('Group addition failed. Try again.', 'zume')}`)
      })
  }
}

function write_invitation_list() {
  if ( zumeTraining.invitations.length > 0 ) {

    let div = jQuery('#invitation-list')
    div.empty().append(`<div class="grid-x grid-padding-y margin-1">`)

    jQuery.each(zumeTraining.invitations, function(i,v) {
      div.append(`
      <div class="cell session-boxes padding-1 margin-bottom-1">
            <p class="center padding-bottom-1">
                <strong>${_.escape( v.owner )}</strong> ${__('invites you to join', 'zume')} <strong>${_.escape( v.group_name )}</strong>
            </p>
            <p class="center">
              <button type="button" onclick="save_invitation_response( '${_.escape( v.key )}', 'accepted' )" class="button">${__('Accept', 'zume')}</button> 
              <button type="button" onclick="save_invitation_response( '${_.escape( v.key )}', 'declined' )" class="button hollow">${__('Decline', 'zume')}</button> 
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
            ${__('Are you sure you want to archive this group?', 'zume')}
        </div>
        <div class="cell center">
        <button type="button" class="center button primary-button" onclick="archive_group( '${_.escape( key )}', ${_.escape( i )}, 1 )" data-close aria-label="Close modal">${__('Archive', 'zume')}</button>
        <button type="button" class="center button primary-button-hollow" data-close aria-label="Close modal">${__('Cancel', 'zume')}</button>
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
    <div class="cell center"><button type="button" class="button primary-button-hollow" onclick="open_archive_groups()" >${__('Show Archived Groups', 'zume')}</button> </div>
  </div>
  `)
}
function open_archive_groups() {
  let list = ''
  jQuery.each( zumeTraining.groups, function(i,v) {
    if ( v.closed === true ) {
      list += ''+ `<tr id="archive_${_.escape( v.key )}"><td>${_.escape( v.group_name )}</td><td><button type="button" class="button clear padding-bottom-0" onclick="activate_group('${_.escape( v.key )}', ${_.escape( i )})">${__('Re-Activate', 'zume')}</button></td><td><button type="button" class="button alert clear padding-bottom-0" onclick="delete_group('${_.escape( v.key )}', ${_.escape( i )}} )">${__('Delete Forever', 'zume')}</button></td></tr>`
    }
  })
  jQuery('#training-modal-content').empty().append(`
  <div class="grid-x training">
        <div class="cell"><h2>${__('Archived Groups', 'zume')}</h2><hr></div>
        <div class="cell">
            <table>${list}</table>
        </div>
        <div class="cell center margin-bottom-1"><button type="button" class="center button primary-button-hollow" data-close aria-label="Close modal">${__('Close', 'zume')}</button></div>
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
            ${__('Are you sure you want to delete this group?', 'zume')}
        </div>
        <div class="cell center">${_.escape( zumeTraining.groups[i].group_name )}</div>
        <div class="cell center">
        <button type="button" class="center button primary-button" onclick="delete_group( '${_.escape( key )}', ${_.escape( i )}, 1 )" >${__('Delete Forever', 'zume')}</button>
        <button type="button" class="center button primary-button-hollow" onclick="open_archive_groups()">${__('Cancel', 'zume')}</button>
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
            <h2 class="padding-bottom-0">${__('Progress', 'zume')}</h2>
            <span class="h2-caption">${__('32 Tools and Concepts', 'zume')}</span>
        </div>
       <div class="cell clickable" onclick="load_host_description()">
            <div class="grid-x grid-padding-x grid-padding-y center">
                <div class="cell small-3">
                    <div class="progress-stat-title">${__('Heard', 'zume')}</div>
                    <div class="circle-background" id="h_total">0</div>
                </div>
                <div class="cell small-3">
                    <div class="progress-stat-title" onclick="load_host_description()" >${__('Obeyed', 'zume')}</div>
                    <div class="circle-background" id="o_total">0</div>
                </div>
                <div class="cell small-3">
                    <div class="progress-stat-title" onclick="load_host_description()" >${__('Shared', 'zume')}</div>
                    <div class="circle-background" id="s_total">0</div>
                </div>
                <div class="cell small-3 center">
                    <div class="progress-stat-title" onclick="load_host_description()" >${__('Trained', 'zume')}</div>
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
                <div class="cell center padding-1 hide-for-small-only"><i class="p-icon-style-only complete"></i> ${__('Heard', 'zume')} <i class="p-icon-style-only complete"></i> ${__('Obeyed', 'zume')} <i class="p-icon-style-only complete"></i> ${__('Shared', 'zume')} <i class="p-icon-style-only complete"></i> ${__('Trained', 'zume')}</div>
                <div class="cell padding-bottom-1 hide-for-small-only"><div class="grid-x"><div class="cell small-6"></div><div class="cell small-6 v-line"></div></div></div>
                <div class="cell center"><i class="p-icon-style-only complete"></i><i class="p-icon-style-only complete"></i><i class="p-icon-style-only complete"></i><i class="p-icon-style-only complete"></i></div>
            </div>
        </div>
       <div class="cell padding-1"><hr></div>
       <div class="cell center padding-bottom-1">
          <h2>${__('Checklist', 'zume')}</h2>
          <span class="h2-caption">${__('Click the circles and check off your progress on each of the concepts.', 'zume')}</span><br>
          <span class="h2-caption"><i class="p-icon-style-only complete"></i> ${__('Heard', 'zume')} <i class="p-icon-style-only complete"></i> ${__('Obeyed', 'zume')} <i class="p-icon-style-only complete"></i> ${__('Shared', 'zume')} <i class="p-icon-style-only complete"></i> ${__('Trained', 'zume')}</span>
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
                            <i class="p-icon" id="1h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="1o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="1s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="1t" title="${__('Trained', 'zume')}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[1] )}">${_.escape( zumeTraining.translations.titles[1] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[2] )}">${_.escape( zumeTraining.translations.titles[2] )}</a></span>
                            <i class="p-icon" id="2h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="2o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="2s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="2t" title="${__('Trained', 'zume')}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[2] )}">${_.escape( zumeTraining.translations.titles[2] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[3] )}">${_.escape( zumeTraining.translations.titles[3] )}</a></span>
                            <i class="p-icon" id="3h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="3o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="3s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="3t" title="${__('Trained', 'zume')}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[3] )}">${_.escape( zumeTraining.translations.titles[3] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[4] )}">${_.escape( zumeTraining.translations.titles[4] )}</a></span>
                            <i class="p-icon" id="4h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="4o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="4s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="4t" title="${__('Trained', 'zume')}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[4] )}">${_.escape( zumeTraining.translations.titles[4] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[5] )}">${_.escape( zumeTraining.translations.titles[5] )}</a></span>
                            <i class="p-icon" id="5h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="5o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="5s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="5t" title="${__('Trained', 'zume')}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[5] )}">${_.escape( zumeTraining.translations.titles[5] )}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[2] )}</a>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[6] )}">${_.escape( zumeTraining.translations.titles[6] )}</a></span>
                            <i class="p-icon" id="6h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="6o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="6s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="6t" title="${__('Trained', 'zume')}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[6] )}">${_.escape( zumeTraining.translations.titles[6] )}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[7] )}">${_.escape( zumeTraining.translations.titles[7] )}</a></span>
                            <i class="p-icon" id="7h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="7o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="7s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="7t" title="${__('Trained', 'zume')}"></i>
                            <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[7] )}">${_.escape( zumeTraining.translations.titles[7] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[8] )}">${_.escape( zumeTraining.translations.titles[8] )}</a></span>
                          <i class="p-icon" id="8h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="8o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="8s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="8t" title="${__('Trained', 'zume')}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[8] )}">${_.escape( zumeTraining.translations.titles[8] )}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[3] )}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[9] )}">${_.escape( zumeTraining.translations.titles[9] )}</a></span>
                          <i class="p-icon" id="9h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="9o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="9s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="9t" title="${__('Trained', 'zume')}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[9] )}">${_.escape( zumeTraining.translations.titles[9] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[10] )}">${_.escape( zumeTraining.translations.titles[10] )}</a></span>
                          <i class="p-icon" id="10h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="10o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="10s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="10t" title="${__('Trained', 'zume')}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[10] )}">${_.escape( zumeTraining.translations.titles[10] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[11] )}">${_.escape( zumeTraining.translations.titles[11] )}</a></span>
                          <i class="p-icon" id="11h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="11o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="11s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="11t" title="${__('Trained', 'zume')}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[11] )}">${_.escape( zumeTraining.translations.titles[11] )}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[4] )}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[12] )}">${_.escape( zumeTraining.translations.titles[12] )}</a></span>
                          <i class="p-icon" id="12h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="12o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="12s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="12t" title="${__('Trained', 'zume')}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[12] )}">${_.escape( zumeTraining.translations.titles[12] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[13] )}">${_.escape( zumeTraining.translations.titles[13] )}</a></span>
                          <i class="p-icon" id="13h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="13o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="13s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="13t" title="${__('Trained', 'zume')}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[13] )}">${_.escape( zumeTraining.translations.titles[13] )}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[14] )}">${_.escape( zumeTraining.translations.titles[14] )}</a></span>
                          <i class="p-icon" id="14h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="14o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="14s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="14t" title="${__('Trained', 'zume')}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[14] )}">${_.escape( zumeTraining.translations.titles[14] )}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[15] )}">${_.escape( zumeTraining.translations.titles[15] )}</a></span>
                          <i class="p-icon" id="15h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="15o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="15s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="15t" title="${__('Trained', 'zume')}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[15] )}">${_.escape( zumeTraining.translations.titles[15] )}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[16] )}">${_.escape( zumeTraining.translations.titles[16] )}</a></span>
                          <i class="p-icon" id="16h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="16o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="16s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="16t" title="${__('Trained', 'zume')}"></i>
                          <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[16] )}">${_.escape( zumeTraining.translations.titles[16] )}</a></span>
                          </div>
                            <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[5] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[17] )}">${_.escape( zumeTraining.translations.titles[17] )}</a></span>
                        <i class="p-icon" id="17h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="17o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="17s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="17t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[17] )}">${_.escape( zumeTraining.translations.titles[17] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[18] )}">${_.escape( zumeTraining.translations.titles[18] )}</a></span>
                        <i class="p-icon" id="18h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="18o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="18s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="18t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[18] )}">${_.escape( zumeTraining.translations.titles[18] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[19] )}">${_.escape( zumeTraining.translations.titles[19] )}</a></span>
                        <i class="p-icon" id="19h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="19o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="19s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="19t" title="${__('Trained', 'zume')}"></i>
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
                        <i class="p-icon" id="20h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="20o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="20s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="20t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[20] )}">${_.escape( zumeTraining.translations.titles[20] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[21] )}">${_.escape( zumeTraining.translations.titles[21] )}</a></span>
                        <i class="p-icon" id="21h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="21o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="21s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="21t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[21] )}">${_.escape( zumeTraining.translations.titles[21] )}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[7] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[22] )}">${_.escape( zumeTraining.translations.titles[22] )}</a></span>
                        <i class="p-icon" id="22h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="22o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="22s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="22t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[22] )}">${_.escape( zumeTraining.translations.titles[22] )}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[8] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[23] )}">${_.escape( zumeTraining.translations.titles[23] )}</a></span>
                        <i class="p-icon" id="23h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="23o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="23s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="23t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[23] )}">${_.escape( zumeTraining.translations.titles[23] )}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[9] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[24] )}">${_.escape( zumeTraining.translations.titles[24] )}</a></span>
                        <i class="p-icon" id="24h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="24o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="24s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="24t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[24] )}">${_.escape( zumeTraining.translations.titles[24] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[25] )}">${_.escape( zumeTraining.translations.titles[25] )}</a></span>
                        <i class="p-icon" id="25h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="25o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="25s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="25t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[25] )}">${_.escape( zumeTraining.translations.titles[25] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[26] )}">${_.escape( zumeTraining.translations.titles[26] )}</a></span>
                        <i class="p-icon" id="26h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="26o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="26s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="26t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[26] )}">${_.escape( zumeTraining.translations.titles[26] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[27] )}">${_.escape( zumeTraining.translations.titles[27] )}</a></span>
                        <i class="p-icon" id="27h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="27o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="27s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="27t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[27] )}">${_.escape( zumeTraining.translations.titles[27] )}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${_.escape( zumeTraining.translations.sessions[10] )}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[28] )}">${_.escape( zumeTraining.translations.titles[28] )}</a></span>
                        <i class="p-icon" id="28h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="28o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="28s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="28t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[28] )}">${_.escape( zumeTraining.translations.titles[28] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[29] )}">${_.escape( zumeTraining.translations.titles[29] )}</a></span>
                        <i class="p-icon" id="29h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="29o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="29s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="29t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[29] )}">${_.escape( zumeTraining.translations.titles[29] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[30] )}">${_.escape( zumeTraining.translations.titles[30] )}</a></span>
                        <i class="p-icon" id="30h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="30o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="30s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="30t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[30] )}">${_.escape( zumeTraining.translations.titles[30] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[31] )}">${_.escape( zumeTraining.translations.titles[31] )}</a></span>
                        <i class="p-icon" id="31h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="31o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="31s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="31t" title="${__('Trained', 'zume')}"></i>
                        <span class="hide-for-small-only"><a href="${_.escape( zumeTraining.urls[31] )}">${_.escape( zumeTraining.translations.titles[31] )}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${_.escape( zumeTraining.urls[32] )}">${_.escape( zumeTraining.translations.titles[32] )}</a></span>
                        <i class="p-icon" id="32h" title="${__('Heard', 'zume')}"></i><i class="p-icon" id="32o" title="${__('Obeyed', 'zume')}"></i><i class="p-icon" id="32s" title="${__('Shared', 'zume')}"></i><i class="p-icon" id="32t" title="${__('Trained', 'zume')}"></i>
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
    <p><strong>${__('Progress Overview', 'zume')}</strong></p>
    <p>${__('There are 32 concepts and tools in Zúme training. Each concept or tool is intended to be practiced personally and trained into others. Use the progression of "heard", "obeyed", "shared", and "trained" as a way of tracking your mastery of the disciple-making training.', 'zume')}</p>
    <p><strong>${__('Definitions', 'zume')}</strong></p>
    <table>
    <tr><td style="white-space: nowrap"><i class="p-icon-help"></i> ${__('Heard', 'zume')}</td><td>${__('"Heard" means you gained awareness. You have moved from not knowing about a tool or concept to knowing about it.', 'zume')}</td></tr>
    <tr><td style="white-space: nowrap"><i class="p-icon-help"></i> ${__('Obeyed', 'zume')}</td><td>${__('"Obeyed" means you took personal action to practice or apply a concept or tool. Obeying with tools might look like beginning to use them with others, while obeying with concepts might look like changing thinking or priorities.', 'zume')}</td></tr>
    <tr><td style="white-space: nowrap"><i class="p-icon-help"></i> ${__('Shared', 'zume')}</td><td>${__('"Shared" means you helped someone else hear. This step is essential to truly understanding the concept or tool and preparing you to train others.', 'zume')}</td></tr>
    <tr><td style="white-space: nowrap"><i class="p-icon-help"></i> ${__('Trained', 'zume')}</td><td>${__('"Trained" means you coached someone else to hear, obey and share. More than sharing knowledge with someone, you have helped them become a sharer of the tool or concept.', 'zume')}</td></tr>
</table>
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
