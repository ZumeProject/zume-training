_ = _ || window.lodash // make sure lodash is defined so plugins like gutenberg don't break it.
const i18n = zumeProfile.translations;


jQuery(document).ready( function() {
  write_profile()
})

function write_profile() {
  let fields = zumeProfile.user_profile_fields

  if ( ! zumeProfile.logged_in ) {
    // window.location = `${zumeProfile.site_urls.login}` // @todo
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


    jQuery('#profile').empty().html(`
    <h3 class="section-header">${_.escape( i18n.x1 )/*Your Profile*/}</h3>

    <style>.label-column { vertical-align: top; width: 100px; white-space: nowrap;}</style>
    <table class="hover stack" id="profile-fields">
        <tr style="vertical-align: top;">
            <td class="label-column">
                <label for="zume_full_name">${_.escape( i18n.x16 )/*Name*/}</label>
            </td>
            <td>
                <input type="text"
                       placeholder="${_.escape( i18n.x2 )/*First and last name*/}"
                       aria-describedby="${_.escape( i18n.x2 )/*First and last name*/}"
                       class="profile-input"
                       id="zume_full_name"
                       name="zume_full_name"
                       value="${_.escape( zumeProfile.user_profile_fields.name )}"
                       data-abide-ignore />
            </td>
        </tr>


        <tr>
            <td class="label-column">
                <label for="zume_phone_number">${_.escape( i18n.x3 )/*Phone*/}</label>
            </td>
            <td>
                <input type="tel"
                       placeholder="111-111-1111"
                       class="profile-input"
                       id="zume_phone_number"
                       name="zume_phone_number"
                       value="${_.escape( zumeProfile.user_profile_fields.phone )}"
                       data-abide-ignore
                />
            </td>
        </tr>
        
        <tr>
            <td class="label-column">
                <label for="user_email">${_.escape( i18n.x4 )/*Email*/}</label>
            </td>
            <td>
                <input type="text"
                       class="profile-input"
                       placeholder="name@email.com"
                       id="user_email"
                       name="user_email"
                       value="${_.escape( zumeProfile.user_profile_fields.email )}"
                       data-abide-ignore
                />
                <span class="form-error">
                  ${_.escape( i18n.x5 )/*This form is required.*/}
                </span>
            </td>
        </tr>
        
        <tr>
            <td class="label-column">
                <label for="validate_address">
                    ${_.escape( i18n.x6 )/*City*/}
                </label>
            </td>
            <td>
                <div class="input-group">
                    <input type="text"
                           placeholder="${_.escape( i18n.x7 )/*example: Denver, CO 80120*/}"
                           class="profile-input input-group-field"
                           id="validate_address"
                           name="validate_address"
                           value="${_.escape( location_grid_meta_label )}"
                           onkeyup="validate_timer(jQuery(this).val())"
                           data-abide-ignore
                    />
                    <div class="input-group-button">
                        <button class="button hollow" id="spinner_button" style="display:none;"><img src="${zumeProfile.theme_uri}/assets/images/spinner.svg" alt="spinner" style="width: 18px;" /></button>
                    </div>
                </div>

                <div id="possible-results">
                    <input type="radio" style="display:none;" name="zume_user_address" id="zume_user_address" value="current" checked/>
                </div>
            </td>
        </tr>
        
        <tr class="label-column">
            <td style="vertical-align: top;">
                <label for="zume_affiliation_key">${_.escape( i18n.x8 )/*Affiliation Key*/}</label>
            </td>
            <td>
                <input type="text" value="${_.escape( zumeProfile.user_profile_fields.affiliation_key )}"
                 id="zume_affiliation_key" name="zume_affiliation_key" />
            </td>
        </tr>

    </table>
    
    <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
        <strong>${_.escape( i18n.x9 )/*Oh snap!*/}</strong>
    </div>

<div class="grid-x">
  <div class="cell center">
      <button class="button" type="submit" onclick="load_form_validator()" id="submit_profile">${_.escape( i18n.x10 )/*Save*/}</button> <span id="request_spinner"></span>
  </div>
</div>
    
    <h3>${_.escape( i18n.x11 )/*Linked Accounts*/}</h3>
    <table class="hover stack">
    <tr id="facebook-row"  class="label-column" style="display: none;">
            <td style="vertical-align: top;">
                <label>${_.escape( i18n.x12 )/*Linked Facebook Account*/}</label>
            </td>
            <td>
                <div class="input-group">
                    <input class="input-group-field profile-input" type="text"
                           value="${_.escape( zumeProfile.user_profile_fields.facebook_sso_email )}" id="facebook_email" readonly />
                    <div class="input-group-button">
                        <button name="unlink_facebook" value="true" type="button" onclick="unlink_facebook_sso()"  class="button">${_.escape( i18n.x13 )/*Unlink*/}</button>
                    </div>
                </div>
            </td>
        </tr>
        
        <tr id="google-row"  class="label-column" style="display: none;">
            <td style="vertical-align: top;">
                <label for="google_email">${_.escape( i18n.x14 )/*Linked Google Account*/}</label>
            </td>
            <td>
                <div class="input-group">
                    <input class="input-group-field profile-input" type="text"
                           value="${_.escape( zumeProfile.user_profile_fields.google_sso_email )}" id="google_email" readonly />
                    <div class="input-group-button">
                        <button name="unlink_google" value="true" type="button" onclick="unlink_google_sso()" class="button">${_.escape( i18n.x13 )/*Unlink*/}</button>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    

    
  `)
  } /* end if */

  if ( zumeProfile.user_profile_fields.facebook_sso_email !== false ) {
    jQuery('#facebook-row').show()
  }
  if ( zumeProfile.user_profile_fields.google_sso_email !== false ) {
    jQuery('#google-row').show()
  }



  // listeners for geocoding text box
  let validate_address_textbox = jQuery('#validate_address')
  validate_address_textbox.keyup( function() {
    check_address()
  });
  validate_address_textbox.on('keypress',function(e) {
    if(e.which === 13) {
      validate_user_address_v4( validate_address_textbox.val() )
      clear_timer()
    }
  });

  // re-initiate foundation abide
  var elem = new Foundation.Abide(jQuery('#profile-fields'))

  // listener for abide form validation
  jQuery(document)
    .on("formvalid.zf.abide", function(ev,frm) {
      update_profile()
    })




}

// Delay lookup
window.validate_timer_id = '';
function validate_timer(user_address) {
  // clear previous timer
  clear_timer()

  // toggle buttons
  jQuery('#spinner_button').show()

  // set timer
  window.validate_timer_id = setTimeout(function(){
    // call geocoder
    validate_user_address_v4(user_address)
    // toggle buttons back
    jQuery('#spinner_button').hide()
  }, 1500);
}

function clear_timer() {
  clearTimeout(window.validate_timer_id);
}
// end Delay Lookup

function validate_user_address_v4(user_address){

  if ( user_address.length < 1 ) {
    return;
  }

  let root = 'https://api.mapbox.com/geocoding/v5/mapbox.places/'
  let settings = '.json?types=country,region,postcode,district,place,locality,neighborhood,address&limit=6&access_token='
  let key = zumeProfile.map_key

  let url = root + encodeURI( user_address ) + settings + key

  jQuery.get( url, function( data ) {

    let possible_results = jQuery('#possible-results')
    possible_results.empty().append(`<fieldset id="multiple-results"></fieldset>`)
    let multiple_results = jQuery('#multiple-results')

    if( data.features.length < 1 ) {
      multiple_results.empty().append(`${_.escape( i18n.x15 )/*No location matches found. Try a less specific address.*/}`)
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

    // enable ability to save
    jQuery('#submit_profile').removeAttr('disabled')

    // add responsive click event to populate text area, if selection is clicked. Expected user feedback.
    jQuery('#multiple-results input').on('click', function( ) {
      let selected_id = jQuery(this).val()
      jQuery.each( window.mapbox_results.features, function(i,v) {
        if ( v.id === selected_id ) {
          jQuery('#validate_address').val(_.escape( v.place_name ))
        }
      })
    })

  }); // end get request
} // end validate_user_address

// form validator
function load_form_validator() {
  jQuery('#profile-fields').foundation('validateForm');
}
function check_address() {
  let fields = zumeProfile.user_profile_fields
  let default_address = ''
  if ( fields.location_grid_meta ) {
    default_address = fields.location_grid_meta.label
  }
  let val_address = jQuery('#validate_address').val()
  let results_address = jQuery('#multiple-results').length

  if (val_address === default_address) // exactly same values
  {
    jQuery('#submit_profile').removeAttr('disabled')
  }
  else if (results_address) // check if fieldset exists by validation
  {
    jQuery('#submit_profile').removeAttr('disabled')
  }
  else if (val_address.length === 0) // check if fieldset exists by validation
  {
    jQuery('#submit_profile').removeAttr('disabled')
  }
  else {
    jQuery('#submit_profile').attr('disabled', 'disabled')
  }
}

function update_profile() {
  let spinner = jQuery('#request_spinner')
  spinner.html(`<img src="${zumeProfile.theme_uri}/assets/images/spinner.svg" alt="spinner" style="width: 40px; vertical-align:top; margin-left: 5px;" />`)

  let name = jQuery('#zume_full_name').val()
  let phone = jQuery('#zume_phone_number').val()
  let email = jQuery('#user_email').val()
  let affiliation_key = jQuery('#zume_affiliation_key').val()

  /**************/
  // Get address
  let location_grid_meta = '' // base is false
  let selection_id = jQuery('#possible-results input:checked').val()

  let validate_address = jQuery('#validate_address').val()
  if ( validate_address === '') {
    location_grid_meta = ''
  }
  // check if location grid
  else if ( window.location_grid_meta && selection_id === 'current' ) {
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
    "affiliation_key": affiliation_key
  }

  // console.log(data)

  jQuery.ajax({
    type: "POST",
    data: JSON.stringify(data),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    url: zumeProfile.root + 'zume/v4/update_profile',
    beforeSend: function(xhr) {
      xhr.setRequestHeader('X-WP-Nonce', zumeProfile.nonce);
    },
  })
    .done(function (response) {
      console.log('success response')
      console.log(response)
      location.reload();

    })
    .fail(function (err) {
      console.log(err)
    })
}


function unlink_facebook_sso() {
  jQuery.ajax({
    type: "POST",
    data: JSON.stringify({ type: 'facebook' } ),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    url: zumeProfile.root + 'zume/v4/unlink_profile',
    beforeSend: function(xhr) {
      xhr.setRequestHeader('X-WP-Nonce', zumeProfile.nonce);
    },
  })
    .done(function (response) {
      console.log('success response')
      console.log(response)
      location.reload();

    })
    .fail(function (err) {
      console.log(err)
    })

}
function unlink_google_sso() {

  jQuery.ajax({
    type: "POST",
    data: JSON.stringify({ type: 'google' }),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    url: zumeProfile.root + 'zume/v4/unlink_profile',
    beforeSend: function(xhr) {
      xhr.setRequestHeader('X-WP-Nonce', zumeProfile.nonce);
    },
  })
    .done(function (response) {
      console.log('success response')
      console.log(response)
      location.reload();

    })
    .fail(function (err) {
      console.log(err)
    })

}
