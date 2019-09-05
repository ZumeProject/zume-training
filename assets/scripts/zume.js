
jQuery(document).ready( function() {
    jQuery('#validate_address_button').click(function() {
        validate_user_address( jQuery('#validate_address').val() )
    });

    jQuery('#submit-new-form').submit(function() {
        jQuery('#submit_new').attr('disabled', 'disabled')
    })
})

function validate_user_address(user_address){
    jQuery('#map').empty()
    jQuery('#possible-results').empty().append('<span class="spinner"><img src="' + zumeMaps.theme_uri + '/assets/images/spinner.svg" style="height:20px;" /></span>')
    let data = {"address": user_address };
    return jQuery.ajax({
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: zumeMaps.root + 'zume/v1/locations/validate_address',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', zumeMaps.nonce);
        },
    })
        .done(function (data) { console.log(data)

            // check if multiple results
            if( data.features.length > 1 ) {

                jQuery('#map').empty()
                jQuery('#validate_address_button').val('Validate Another?')

                jQuery('#possible-results').empty().append('<fieldset id="multiple-results"><legend>We found these matches:</legend></fieldset>')

                jQuery.each( data.features, function( index, value ) {
                    let checked = ''
                    if( index === 0 ) {
                        checked = 'checked'
                    }
                    jQuery('#multiple-results').append( '<input type="radio" name="zume_user_address" id="zume_user_address'+index+'" value="'+value.place_name+'" '+checked+' /><label for="zume_user_address'+index+'">'+value.place_name+'</label><br>')
                })
            }
            else
            {
                jQuery('#map').empty()
                jQuery('#possible-results').empty().append('<fieldset id="multiple-results"><legend>We found this match. Is this correct? If not validate another.</legend><input type="radio" name="zume_user_address" id="zume_user_address" value="'+data.features[0].place_name+'" checked/><label for="zume_user_address">'+data.features[0].place_name+'</label></fieldset>')
            }
            jQuery('#submit_profile').removeAttr('disabled')

        })
        .fail(function (err) {
            console.log("error")
            console.log(err)
            jQuery('#map').empty()
            jQuery('#validate_address_button').val('Validate Another?')
            jQuery('#possible-results').empty().append('<fieldset id="multiple-results"><legend>We found no matching locations. Check your address and validate again.</legend></fieldset>')
            jQuery('#submit_profile').removeAttr('disabled')
        })

}

function validate_group_address(user_address, group_key){
    jQuery('#map'+group_key).empty()
    jQuery('#possible-results'+group_key).empty().append('<span class="spinner"><img src="' + zumeMaps.theme_uri + '/assets/images/spinner.svg" style="height:20px;" /></span>')
    let data = {"address": user_address };
    return jQuery.ajax({
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: zumeMaps.root + 'zume/v1/locations/validate_address',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', zumeMaps.nonce);
        },
    })
        .done(function (data) {

            // check if multiple results
            if( data.features.length > 1 ) {

                jQuery('#map'+group_key).empty()
                jQuery('#validate_address_button'+group_key).val('Validate Another?')

                jQuery('#possible-results'+group_key).empty().append('<fieldset id="multiple-results'+group_key+'"><legend>We found these matches:</legend></fieldset>')

                jQuery.each( data.features, function( index, value ) {
                    let checked = ''
                    if( index === 0 ) {
                        checked = 'checked'
                    }
                    jQuery('#multiple-results'+group_key).append( '<input type="radio" name="address" id="address'+index+'" value="'+value.place_name+'" '+checked+' /><label for="address'+index+'">'+value.place_name+'</label><br>')
                })

            }
            else
            {
                jQuery('#map'+group_key).empty()
                jQuery('#validate_address_button'+group_key).val('Validate Another?')
                jQuery('#possible-results'+group_key).empty().append('<fieldset id="multiple-results'+group_key+'"><legend>We found this match. Is this correct?</legend><input type="radio" name="address" id="address" value="'+data.features[0].place_name+'" checked/><label for="address">'+data.features[0].place_name+'</label></fieldset>')

            }
          jQuery('#submit_' + group_key).removeAttr('disabled')

        })
        .fail(function (err) {
            console.log("error")
            console.log(err)
            jQuery('#map'+group_key).empty()
            jQuery('#validate_address_button'+group_key).val('Validate Another?')
            jQuery('#possible-results'+group_key).empty().append('<fieldset id="multiple-results'+group_key+'"><legend>We found no matching locations. Check your address and validate again.</legend></fieldset>')
        })
}

function check_address(key) {

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


/* Support for adding coleaders */
function add_new_coleader( target ) {
    jQuery('#' + target ).append('<input type="email" value="" placeholder="email address" name="new_coleader[]" />')
}

function create_coleader( target ) {
    jQuery('#' + target ).append('<input type="email" value="" placeholder="email address" name="coleaders[]" />')
}

jQuery(document).ready( function() {
    jQuery( "li.coleader" ).hover(
        function() {
            let email = jQuery( this ).find( "input").val();
            let group_id = jQuery( this ).parent().attr('data-key');
            let li_id = jQuery(this).attr('id');
            jQuery( this ).append( jQuery( '<span > <a onclick="remove_coleader( \'' + email + '\',\'' + group_id + '\', \''+ li_id +'\')" style="color:red;">'+zumeMaps.translations.delete+'</a></span>' ) );
        }, function() {
            jQuery( this ).find( "span:last" ).remove();
        }
    );

    jQuery( "div.coleader-group" ).hover(
        function() {
            var remove = jQuery('span.coleader-remove-link');
            jQuery( this ).find( remove ).show();
        }, function() {
            var remove = jQuery('span.coleader-remove-link');
            jQuery( this ).find( remove ).hide();
        }
    );

    jQuery( "div.public_key" ).hover(
        function() {
            var remove = jQuery('span.public_key_change');
            jQuery( this ).find( remove ).show();
        }, function() {
            var remove = jQuery('span.public_key_change');
            jQuery( this ).find( remove ).hide();
        }
    );

    jQuery( "div#display-public-key" ).hover(
        function() {
            var remove = jQuery('span.display-public-key-unlink');
            jQuery( this ).find( remove ).show();
        }, function() {
            var remove = jQuery('span.display-public-key-unlink');
            jQuery( this ).find( remove ).hide();
        }
    );
})

function remove_coleader( email, group_id, li_id ) {
    let data = {"email": email, "group_id": group_id };
    return jQuery.ajax({
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: zumeMaps.root + 'zume/v1/coleaders_delete',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', zumeMaps.nonce);
        },
    })
        .done(function (data) {
            jQuery('#' + li_id ).remove();

        })
        .fail(function (err) {
            jQuery('#' + li_id ).append( '<span>'+zumeMaps.translations.failed_to_remove+'</span>' );
        })
}

function change_group_key( group_key ) {
    return jQuery.ajax({
        type: "POST",
        data: JSON.stringify({"group_key": group_key }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: zumeMaps.root + 'zume/v1/change_public_key',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', zumeMaps.nonce);
        },
    })
        .done(function (data) {
            jQuery('.' + group_key + '_public_key' ).html(data);

        })
        .fail(function (err) {
            jQuery('.' + group_key + '_public_key'  ).append( '<span>'+zumeMaps.translations.failed_to_change+'</span>' );
        })
}

function connect_plan_to_group( public_key ) {
    return jQuery.ajax({
        type: "POST",
        data: JSON.stringify({"public_key": public_key }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: zumeMaps.root + 'zume/v1/connect_plan_to_group',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', zumeMaps.nonce);
        },
    })
        .done(function (data) {
            jQuery('#display-group-name').html( data.group_name )
            jQuery('#add-public-key').hide();
            jQuery('#display-public-key').show();
            jQuery('.public-key-error').remove();
            jQuery('#unlink-three-month-plan').attr('onclick', 'unlink_three_month_plan(\''+data.key+'\')');
        })
        .fail(function (err) {
            jQuery( '#linked_group' ).append( '<span class="public-key-error">'+zumeMaps.translations.failed_to_change+'</span>' );
        })
}

function unlink_three_month_plan( group_key ) {

    return jQuery.ajax({
        type: "POST",
        data: JSON.stringify({"group_key": group_key }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: zumeMaps.root + 'zume/v1/unlink_plan_from_group',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', zumeMaps.nonce);
        },
    })
        .done(function (data) {
            jQuery('#add-public-key').show();
            jQuery('#display-public-key').hide();
        })
        .fail(function (err) {
            jQuery( '#linked_group' ).append( '<span>'+zumeMaps.translations.failed_to_change+'</span>' );
        })
}

function print_element(divId) {
    var content = document.getElementById(divId).innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=800');

    mywindow.document.write('<html><head><title>'+zumeMaps.translations.print_copyright+'</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(content);
    mywindow.document.write('<div>'+zumeMaps.translations.print_copyright+'</div>');
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}


function send_coaching_request() {
    let spinner = jQuery('#request_spinner')
    spinner.html('<img src="'+ zumeMaps.theme_uri +'/assets/images/spinner.svg" style="width: 40px; vertical-align:top; margin-left: 5px;" />')

    let name = jQuery('#zume_full_name').val()
    let phone = jQuery('#zume_phone_number').val()
    let email = jQuery('#user_email').val()
    let address = jQuery('#address_profile').val()
    let preference = jQuery('#zume_contact_preference').val()
    let affiliation_key = jQuery('#zume_affiliation_key').val()

    let data = {
        "zume_full_name": name,
        "zume_phone_number": phone,
        "user_email": email,
        "address_profile": address,
        "zume_contact_preference": preference,
        "zume_affiliation_key": affiliation_key
    }
    console.log(data)

    jQuery.ajax({
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: zumeMaps.root + 'zume/v1/send_coaching_request',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', zumeMaps.nonce);
        },
    })
        .done(function (data) {
            console.log(data)
            jQuery('#coach-modal-title').empty().html(zumeMaps.translations.we_got_it)
            jQuery('#coaching-request-form-section').empty().html("<div class='grid-x'><div class='cell center'><p>"+ zumeMaps.translations.we_got_it_message+"</p></div></div>")
        })
        .fail(function (err) {
            console.log("error")
            console.log(err)
            spinner.empty().html( '&nbsp;Oops. Something went wrong. Try again!')
        })
}
