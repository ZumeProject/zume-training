
jQuery(document).ready( function() {
    jQuery('#validate_address_button').click(function() {
        validate_user_address( jQuery('#validate_address').val() )
    });
})

function validate_user_address(user_address){
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
            if( data.results.length > 1 ) {

                jQuery('#map').empty()
                jQuery('#validate_address_button').val('Validate Another?')

                jQuery('#possible-results').empty().append('<fieldset id="multiple-results"><legend>We found these matches:</legend></fieldset>')


                jQuery.each( data.results, function( index, value ) {
                    let checked = ''
                    if( index === 0 ) {
                        checked = 'checked'
                    }
                    jQuery('#multiple-results').append( '<input type="radio" name="zume_user_address" id="zume_user_address'+index+'" value="'+value.formatted_address+'" '+checked+' /><label for="zume_user_address'+index+'">'+value.formatted_address+'</label><br>')
                })
            }
            else
            {
                jQuery('#map').empty()
                jQuery('#possible-results').empty().append('<fieldset id="multiple-results"><legend>We found this match. Is this correct? If not validate another.</legend><input type="radio" name="zume_user_address" id="zume_user_address" value="'+data.results[0].formatted_address+'" checked/><label for="zume_user_address">'+data.results[0].formatted_address+'</label></fieldset>')
                jQuery('#submit_profile').removeAttr('disabled')
            }

        })
        .fail(function (err) {
            console.log("error")
            console.log(err)
            jQuery("#errors").append(err.responseText)
            jQuery('#map').empty()
            jQuery('#validate_address_button').val('Validate Another?')
            jQuery('#possible-results').empty().append('<fieldset id="multiple-results"><legend>We found no matching locations. Check your address and validate again.</legend></fieldset>')
        })
}

function validate_group_address(user_address, group_key){
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
            if( data.results.length > 1 ) {

                jQuery('#map'+group_key).empty()
                jQuery('#validate_address_button'+group_key).val('Validate Another?')

                jQuery('#possible-results'+group_key).empty().append('<fieldset id="multiple-results'+group_key+'"><legend>We found these matches:</legend></fieldset>')

                jQuery.each( data.results, function( index, value ) {
                    let checked = ''
                    if( index === 0 ) {
                        checked = 'checked'
                    }
                    jQuery('#multiple-results'+group_key).append( '<input type="radio" name="address" id="address'+index+'" value="'+value.formatted_address+'" '+checked+' /><label for="address'+index+'">'+value.formatted_address+'</label><br>')
                })
                jQuery('#submit_' + group_key).removeAttr('disabled')
            }
            else
            {
                jQuery('#map'+group_key).empty()
                jQuery('#validate_address_button'+group_key).val('Validate Another?')
                jQuery('#possible-results'+group_key).empty().append('<fieldset id="multiple-results'+group_key+'"><legend>We found this match. Is this correct?</legend><input type="radio" name="address" id="address" value="'+data.results[0].formatted_address+'" checked/><label for="address">'+data.results[0].formatted_address+'</label></fieldset>')
                jQuery('#submit_' + group_key).removeAttr('disabled')
            }

        })
        .fail(function (err) {
            console.log("error")
            console.log(err)
            jQuery("#errors").append(err.responseText)
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
    else {
        jQuery('#submit_' + key).attr('disabled', 'disabled')
    }
}


/* Support for adding coleaders */
function add_new_coleader( target ) {
    jQuery('#' + target ).append('<input type="email" value="" placeholder="email address" name="new_coleader[]" />')
}
