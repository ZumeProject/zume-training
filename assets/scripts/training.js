_ = _ || window.lodash // make sure lodash is defined so plugins like gutenberg don't break it.
// const { __, _x, _n, _nx } = wp.i18n;

jQuery(document).ready(function(){
  if( '#panel2' === window.location.hash  ) {
    console.log(zumeTraining)
    get_groups()
  }
  if( '#panel3' === window.location.hash  ) {
    console.log(zumeTraining)
    get_progress()
  }
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

  let div = jQuery('#group-list')
  div.empty()
  jQuery.each(groups, function(i,v) {
    div.append(`
  <div class="cell group-section border-bottom padding-bottom-2 margin-bottom-2">
    <div class="grid-x grid-padding-x">
       <div class="cell padding-bottom-1"><!--Full width top -->
        <h2>${v.group_name}</h2>
       </div>
      <div class="cell small-2"> <!-- Column 1 -->
         <div class="grid-y" id="session_list_${v.key}">
            <div class="cell"><a href=""><i class="g-session-icon" id="s1${v.key}"></i> Session 1</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon" id="s2${v.key}"></i> Session 2</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon" id="s3${v.key}"></i> Session 3</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon" id="s4${v.key}"></i> Session 4</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon" id="s5${v.key}"></i> Session 5</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon" id="s6${v.key}"></i> Session 6</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon" id="s7${v.key}"></i> Session 7</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon" id="s8${v.key}"></i> Session 8</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon" id="s9${v.key}"></i> Session 9</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon" id="s10${v.key}"></i> Session 10</a></div>
         </div>
      </div> <!-- Column 1 -->
      <div class="cell small-4">
          <div class="grid-y">
                <div class="cell column-header">Members</div>
                <div class="cell padding-bottom-1">
                    <select id="member_count_${v.key}"><!-- member count --></select>
                </div>
                <div class="cell column-header">Members List (optional)</div>
                <div class="cell">
                    <div class="grid-y" id="member_list_${v.key}"><!-- member list --></div>
                </div>
                <div class="cell add-member" id="add_member_${v.key}"><!-- add member area --></div>
          </div>
      </div> <!-- Column 2 -->
      <div class="cell small-4"> <!-- Column 3 -->
          <div class="grid-y">
              <div class="cell">
                <span class="column-header">Location</span>
              </div>
              <div class="cell" id="map_${v.key}"><!-- Map Section--></div>
              <div class="cell" id="add_location_${v.key}"><!-- Add Location Field --></div>
          </div>
      </div> <!-- Column 3 -->
      <div class="cell small-2">
            <div class="grid-y">
                <div class="cell"><button type="button" class="button small">Next Session</button></div>
                <div class="cell"><button type="button" class="button clear small">Archive</button></div>
                <div class="cell"><button type="button" class="button clear small">Delete</button></div>
            </div>
      </div> <!-- Column 4 -->
    </div>
</div>
    `)

    add_member_count( v.key, v )
    add_session_progress( v.key, v )
    add_members_list( v.key, v )
    load_member_add_button( v.key )
    load_location_add_button( v.key )

  }) /* end .each loop*/
}
// listeners
jQuery(document).ready(function(){
  jQuery('.member').hover( function(){jQuery(this).children().show()}, function(){jQuery(this).children().hide()})
})
// functions
function add_session_progress( key, group ) {
  let i = 1
  while ( i < 11) {
    if( group['session_'+i] ) {
      jQuery('#s'+i+key).addClass('complete')
    }
    i++;
  }
}
function add_member_count( key, group ) {
    let list = ''
    let i = 1
    while ( i < 30) {
      list += '<option value="'+i+'"';
      if ( parseInt( group.members ) === i ) {
        list += ' selected'
      }
      list += '>'+ i +'</option>'
      i++;
    }

    jQuery('#member_count_' + key ).empty().append(list)
}
function add_members_list( key, group ) {
  let div = jQuery('#member_list_'+key)
  div.empty()
  jQuery.each( group.coleaders, function(i,v) {
    div.append('<div class="cell member">'+v+' <span class="delete" onclick="">delete</span></div>')
  })
}
function add_member_fields( key ) {
  jQuery('#add_member_'+key).empty().append(`
  <hr>
  <input type="text" placeholder="nickname" id="name_${key}" />
  <input type="text" placeholder="email" id="email_${key}" />
  <button type="button" class="button small" onclick="save_new_member('${key}')">Save</button> 
  <button type="button" class="button small hollow" onclick="load_member_add_button('${key}')">Cancel</button> 
  `)
}
function load_member_add_button( key ) {
  jQuery('#add_member_'+key).empty().append(`
    <button type="button" class="button clear" onclick="add_member_fields('${key}')"><i class="fi-plus"></i> add</button>
  `)
}
function save_new_member( key ) {
  let name = jQuery('#name_' + key ).val()
  let email = jQuery('#email_' + key).val()

  // @todo add REST submit of new member
  console.log( name + ' ' + email )

  load_member_add_button( key )

}

function load_location_add_button( key ) {
  jQuery('#add_location_'+key).empty().append(`
    <button type="button" class="button clear" onclick="add_location_fields('${key}')"><i class="fi-plus"></i> new</button>
  `)
}
function add_location_fields( key ) {
  jQuery('#add_location_'+key).empty().append(`
  <div class="cell">
      <div class="input-group">
          <input type="text"
                 placeholder="example: 1000 Broadway, Denver, CO 80126"
                 class="profile-input input-group-field"
                 name="validate_address"
                 id="validate_address_${key}"
                 value=""
          />
          <div class="input-group-button">
              <input type="button" class="button"
                     onclick="validate_training_group_address( jQuery('#validate_address_${key}').val(), '${key}')"
                     value="Validate"
                     id="validate_address_buttonnew">
          </div>
      </div>
      <div class="possible-results-new" id="possible_results_${key}">
          <input type="hidden" name="address" id="address_new" value=""/>
      </div>
      <div class="location-result-buttons" id="location_result_buttons_${key}">
        <button type="button" class="button small" onclick="save_new_location('${key}')">Save</button> 
        <button type="button" class="button small hollow" onclick="load_location_add_button('${key}')">Cancel</button>
      </div>
    
  </div>
  `)
  jQuery('#validate_addressnew_'+key).keyup(function () {
    check_address( key )
  });
}
function validate_training_group_address(user_address, key ){
  jQuery('#map_'+key).empty()
  jQuery('#possible-results'+key).empty().append('<span class="spinner"><img src="' + zumeTraining.theme_uri + '/assets/images/spinner.svg" style="height:20px;" /></span>')
  let data = {"address": user_address };
  return jQuery.ajax({
    type: "POST",
    data: JSON.stringify(data),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    url: zumeTraining.root + 'zume/v1/locations/validate_address',
    beforeSend: function(xhr) {
      xhr.setRequestHeader('X-WP-Nonce', zumeTraining.nonce);
    },
  })
    .done(function (data) {
      // check if multiple results
      if( data.features.length > 1 ) {

        jQuery('#map_'+key).empty()
        jQuery('#validate_address_button'+key).val('Validate Another?')

        jQuery('#possible_results_'+key).empty().append('<fieldset id="multiple-results'+key+'"><legend>We found these matches:</legend></fieldset>')

        jQuery.each( data.features, function( index, value ) {
          let checked = ''
          if( index === 0 ) {
            checked = 'checked'
          }
          jQuery('#multiple-results'+key).append( '<input type="radio" name="address" id="address'+index+'" value="'+value.place_name+'" '+checked+' /><label for="address'+index+'">'+value.place_name+'</label><br>')
        })

        jQuery('#location_result_buttons_'+key).show()
      }
      else
      {
        jQuery('#map_'+key).empty()
        jQuery('#validate_address_button'+key).val('Validate Another?')
        jQuery('#possible-results'+key).empty().append('<fieldset id="multiple-results'+key+'"><legend>We found this match. Is this correct?</legend><input type="radio" name="address" id="address" value="'+data.features[0].place_name+'" checked/><label for="address">'+data.features[0].place_name+'</label></fieldset>')

      }
    })
    .fail(function (err) {
      console.log("error")
      console.log(err)
      jQuery('#map_'+key).empty()
      jQuery('#validate_address_button'+key).val('Validate Another?')
      jQuery('#possible-results'+key).empty().append('<fieldset id="multiple-results'+key+'"><legend>We found no matching locations. Check your address and validate again.</legend></fieldset>')
    })
}
function check_address( key ) {

  let val_address = jQuery('#validate_address' + key).val()
  let default_address = jQuery('#address_' + key).val()
  let results_address = jQuery('#multiple-results' + key).length

  if (val_address === default_address) // exactly same values
  {
    jQuery('#submit_' + key).removeAttr('disabled')
  }
  else if (results_address) // check if fieldset exists by validation
  {
    jQuery('#submit_' + key).removeAttr('disabled')
  }
  else if (val_address.length === 0) // check if fieldset exists by validation
  {
    jQuery('#submit_' + key).removeAttr('disabled')
  }
  else {
    jQuery('#submit_' + key).attr('disabled', 'disabled')
  }
}
function save_new_location( key ) {

  console.log('new location')
  console.log(key)

  load_location_add_button( key )
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
            <h2 class="padding-bottom-0">Training Progress</h2>
            <span class="h2-caption">31 Tools and Concepts</span>
        </div>
       <div class="cell">
            <div class="grid-x grid-padding-x grid-padding-y center">
                <div class="cell small-3">
                    <div class="progress-stat-title">Heard</div>
<!--                    <div class="progress-description">"Heard" means gain knowledge. You have moved from not knowing about a tool or concept to knowing about it.</div>-->
                    <div class="circle-background" id="h_total">0</div>
                </div>
                <div class="cell small-3">
                    <div class="progress-stat-title">Obeyed</div>
<!--                    <div class="progress-description">"Obeyed" means taking personal action. Obeying with tools might look like beginning to use them with others, while obeying with concepts might look like changing thinking or priorities.</div>-->
                    <div class="circle-background" id="o_total">0</div>
                </div>
                <div class="cell small-3">
                    <div class="progress-stat-title">Shared</div>
<!--                    <div class="progress-description">"Shared" means you helped someone else hear. This step is essential to truly understanding the concept or tool and preparing you to train others.</div>-->
                    <div class="circle-background" id="s_total">0</div>
                </div>
                <div class="cell small-3 center">
                    <div class="progress-stat-title">Trained</div>
<!--                    <div class="progress-description">"Trained" means to coach someone else to obey and share. More than sharing knowledge, you have helped them become a sharer of the tool or concept.</div>-->
                    <div class="circle-background" id="t_total">0</div>
                </div>
            </div>
        </div>
        <div class="cell">
             <div class="grid-x">
                <div class="cell small-3"><div class="grid-x"><div class="cell small-6"></div><div class="cell small-6 v-line h-line"></div></div></div>
                <div class="cell small-3"><div class="grid-x"><div class="cell small-6 h-line"></div><div class="cell small-6 v-line h-line"></div></div></div>
                <div class="cell small-3"><div class="grid-x"><div class="cell small-6 h-line"></div><div class="cell small-6 v-line h-line"></div></div></div>
                <div class="cell small-3"><div class="grid-x"><div class="cell small-6 h-line"></div><div class="cell small-6 v-line"></div></div></div>
            </div>
            <div class="grid-x">
                <div class="cell"><div class="grid-x"><div class="cell small-6"></div><div class="cell small-6 v-line"></div></div></div>
                <div class="cell center"><i class="p-icon complete"></i><i class="p-icon complete"></i><i class="p-icon complete"></i><i class="p-icon complete"></i></div>
            </div>
        </div>
       <div class="cell padding-1">
        <hr>
       </div>
       <div class="cell center padding-bottom-1">
          <h2>Tracking</h2>
          <span class="h2-caption">Check off your progress on each of the concepts.</span><br>
          <span class="h2-caption"><i class="p-icon complete"></i> Heard <i class="p-icon complete"></i> Obeyed <i class="p-icon complete"></i> Shared <i class="p-icon complete"></i> Trained</span>
       </div>
       <div class="cell padding-top-1">
            <div class="grid-x grid-padding-x">
                <div class="cell medium-1 hide-for-small-only"></div>
                  <div class="cell medium-5">
                      <div class="grid-x grid-padding-x progress-list">
                          <div class="cell p-session-separator">
                          ${zumeTraining.translations.sessions[1]}
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.urls[1]}">${zumeTraining.translations.titles[1]}</a></span> 
                            <i class="p-icon" id="1h"></i><i class="p-icon" id="1o"></i><i class="p-icon" id="1s"></i><i class="p-icon" id="1t"></i> 
                            <span class="hide-for-small-only"><a href="${zumeTraining.urls[1]}">${zumeTraining.translations.titles[1]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.urls[2]}">${zumeTraining.translations.titles[2]}</a></span>
                            <i class="p-icon" id="2h"></i><i class="p-icon" id="2o"></i><i class="p-icon" id="2s"></i><i class="p-icon" id="2t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.urls[2]}">${zumeTraining.translations.titles[2]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.urls[3]}">${zumeTraining.translations.titles[3]}</a></span>
                            <i class="p-icon" id="3h"></i><i class="p-icon" id="3o"></i><i class="p-icon" id="3s"></i><i class="p-icon" id="3t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.urls[3]}">${zumeTraining.translations.titles[3]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.urls[4]}">${zumeTraining.translations.titles[4]}</a></span>
                            <i class="p-icon" id="4h"></i><i class="p-icon" id="4o"></i><i class="p-icon" id="4s"></i><i class="p-icon" id="4t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.urls[4]}">${zumeTraining.translations.titles[4]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.urls[5]}">${zumeTraining.translations.titles[5]}</a></span>
                            <i class="p-icon" id="5h"></i><i class="p-icon" id="5o"></i><i class="p-icon" id="5s"></i><i class="p-icon" id="5t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.urls[5]}">${zumeTraining.translations.titles[5]}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[2]}</a>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.urls[6]}">${zumeTraining.translations.titles[6]}</a></span>
                            <i class="p-icon" id="6h"></i><i class="p-icon" id="6o"></i><i class="p-icon" id="6s"></i><i class="p-icon" id="6t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.urls[6]}">${zumeTraining.translations.titles[6]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.urls[7]}">${zumeTraining.translations.titles[7]}</a></span>
                            <i class="p-icon" id="7h"></i><i class="p-icon" id="7o"></i><i class="p-icon" id="7s"></i><i class="p-icon" id="7t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.urls[7]}">${zumeTraining.translations.titles[7]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.urls[8]}">${zumeTraining.translations.titles[8]}</a></span>
                          <i class="p-icon" id="8h"></i><i class="p-icon" id="8o"></i><i class="p-icon" id="8s"></i><i class="p-icon" id="8t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.urls[8]}">${zumeTraining.translations.titles[8]}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[3]}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.urls[9]}">${zumeTraining.translations.titles[9]}</a></span>
                          <i class="p-icon" id="9h"></i><i class="p-icon" id="9o"></i><i class="p-icon" id="9s"></i><i class="p-icon" id="9t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.urls[9]}">${zumeTraining.translations.titles[9]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.urls[10]}">${zumeTraining.translations.titles[10]}</a></span>
                          <i class="p-icon" id="10h"></i><i class="p-icon" id="10o"></i><i class="p-icon" id="10s"></i><i class="p-icon" id="10t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.urls[10]}">${zumeTraining.translations.titles[10]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.urls[11]}">${zumeTraining.translations.titles[11]}</a></span>
                          <i class="p-icon" id="11h"></i><i class="p-icon" id="11o"></i><i class="p-icon" id="11s"></i><i class="p-icon" id="11t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.urls[11]}">${zumeTraining.translations.titles[11]}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[4]}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.urls[12]}">${zumeTraining.translations.titles[12]}</a></span>
                          <i class="p-icon" id="12h"></i><i class="p-icon" id="12o"></i><i class="p-icon" id="12s"></i><i class="p-icon" id="12t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.urls[12]}">${zumeTraining.translations.titles[12]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.urls[13]}">${zumeTraining.translations.titles[13]}</a></span>
                          <i class="p-icon" id="13h"></i><i class="p-icon" id="13o"></i><i class="p-icon" id="13s"></i><i class="p-icon" id="13t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.urls[13]}">${zumeTraining.translations.titles[13]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.urls[14]}">${zumeTraining.translations.titles[14]}</a></span>
                          <i class="p-icon" id="14h"></i><i class="p-icon" id="14o"></i><i class="p-icon" id="14s"></i><i class="p-icon" id="14t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.urls[14]}">${zumeTraining.translations.titles[14]}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${zumeTraining.urls[15]}">${zumeTraining.translations.titles[15]}</a></span>
                          <i class="p-icon" id="15h"></i><i class="p-icon" id="15o"></i><i class="p-icon" id="15s"></i><i class="p-icon" id="15t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.urls[15]}">${zumeTraining.translations.titles[15]}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${zumeTraining.urls[16]}">${zumeTraining.translations.titles[16]}</a></span>
                          <i class="p-icon" id="16h"></i><i class="p-icon" id="16o"></i><i class="p-icon" id="16s"></i><i class="p-icon" id="16t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.urls[16]}">${zumeTraining.translations.titles[16]}</a></span>
                          </div>
                            <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[5]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[17]}">${zumeTraining.translations.titles[17]}</a></span>
                        <i class="p-icon" id="17h"></i><i class="p-icon" id="17o"></i><i class="p-icon" id="17s"></i><i class="p-icon" id="17t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[17]}">${zumeTraining.translations.titles[17]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[18]}">${zumeTraining.translations.titles[18]}</a></span>
                        <i class="p-icon" id="18h"></i><i class="p-icon" id="18o"></i><i class="p-icon" id="18s"></i><i class="p-icon" id="18t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[18]}">${zumeTraining.translations.titles[18]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[19]}">${zumeTraining.translations.titles[19]}</a></span>
                        <i class="p-icon" id="19h"></i><i class="p-icon" id="19o"></i><i class="p-icon" id="19s"></i><i class="p-icon" id="19t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[19]}">${zumeTraining.translations.titles[19]}</a></span>
                        </div>
                      </div>
                  </div>
                  <div class="cell medium-5">
                    <div class="grid-x grid-padding-x progress-list">
                        <div class="cell p-session-separator session-6-column-top">
                          ${zumeTraining.translations.sessions[6]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[20]}">${zumeTraining.translations.titles[20]}</a></span>
                        <i class="p-icon" id="20h"></i><i class="p-icon" id="20o"></i><i class="p-icon" id="20s"></i><i class="p-icon" id="20t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[20]}">${zumeTraining.translations.titles[20]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[21]}">${zumeTraining.translations.titles[21]}</a></span>
                        <i class="p-icon" id="21h"></i><i class="p-icon" id="21o"></i><i class="p-icon" id="21s"></i><i class="p-icon" id="21t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[21]}">${zumeTraining.translations.titles[21]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[7]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[22]}">${zumeTraining.translations.titles[22]}</a></span>
                        <i class="p-icon" id="22h"></i><i class="p-icon" id="22o"></i><i class="p-icon" id="22s"></i><i class="p-icon" id="22t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[22]}">${zumeTraining.translations.titles[22]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[8]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[23]}">${zumeTraining.translations.titles[23]}</a></span>
                        <i class="p-icon" id="23h"></i><i class="p-icon" id="23o"></i><i class="p-icon" id="23s"></i><i class="p-icon" id="23t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[23]}">${zumeTraining.translations.titles[23]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[9]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[24]}">${zumeTraining.translations.titles[24]}</a></span>
                        <i class="p-icon" id="24h"></i><i class="p-icon" id="24o"></i><i class="p-icon" id="24s"></i><i class="p-icon" id="24t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[24]}">${zumeTraining.translations.titles[24]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[25]}">${zumeTraining.translations.titles[25]}</a></span>
                        <i class="p-icon" id="25h"></i><i class="p-icon" id="25o"></i><i class="p-icon" id="25s"></i><i class="p-icon" id="25t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[25]}">${zumeTraining.translations.titles[25]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[26]}">${zumeTraining.translations.titles[26]}</a></span>
                        <i class="p-icon" id="26h"></i><i class="p-icon" id="26o"></i><i class="p-icon" id="26s"></i><i class="p-icon" id="26t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[26]}">${zumeTraining.translations.titles[26]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[27]}">${zumeTraining.translations.titles[27]}</a></span>
                        <i class="p-icon" id="27h"></i><i class="p-icon" id="27o"></i><i class="p-icon" id="27s"></i><i class="p-icon" id="27t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[27]}">${zumeTraining.translations.titles[27]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[10]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[28]}">${zumeTraining.translations.titles[28]}</a></span>
                        <i class="p-icon" id="28h"></i><i class="p-icon" id="28o"></i><i class="p-icon" id="28s"></i><i class="p-icon" id="28t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[28]}">${zumeTraining.translations.titles[28]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[29]}">${zumeTraining.translations.titles[29]}</a></span>
                        <i class="p-icon" id="29h"></i><i class="p-icon" id="29o"></i><i class="p-icon" id="29s"></i><i class="p-icon" id="29t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[29]}">${zumeTraining.translations.titles[29]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[30]}">${zumeTraining.translations.titles[30]}</a></span>
                        <i class="p-icon" id="30h"></i><i class="p-icon" id="30o"></i><i class="p-icon" id="30s"></i><i class="p-icon" id="30t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[30]}">${zumeTraining.translations.titles[30]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[31]}">${zumeTraining.translations.titles[31]}</a></span>
                        <i class="p-icon" id="31h"></i><i class="p-icon" id="31o"></i><i class="p-icon" id="31s"></i><i class="p-icon" id="31t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[31]}">${zumeTraining.translations.titles[31]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.urls[32]}">${zumeTraining.translations.titles[32]}</a></span>
                        <i class="p-icon" id="32h"></i><i class="p-icon" id="32o"></i><i class="p-icon" id="32s"></i><i class="p-icon" id="32t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.urls[32]}">${zumeTraining.translations.titles[32]}</a></span>
                        </div>
                    </div>
                  </div>
                  <div class="cell medium-1 hide-for-small-only"></div>
            </div>
        </div>
        <div class="cell padding-2">
            
        </div>
    </div> <!-- grid-y -->
</div> <!-- cell -->    
`)
  load_progress()
  progress_icons_listener()
  load_progress_totals()
}


function progress_icons_listener() {
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


/**
 * REST API
 *
 */
window.API = {

  update_progress: (key, state) => makeRequest('POST', 'progress/edit', { key: key, state: state }),

}
function makeRequest (type, url, data, base = 'zume/v1/') {
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
    window.location.replace('/login');
  }
}).ajaxError((event, xhr) => {
  handleAjaxError(xhr)
})
