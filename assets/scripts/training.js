function toggle_columns(i) {
  if ( i === 1 ) {
    jQuery('.session').removeClass('medium-6')
  } else {
    jQuery('.session').addClass('medium-6')
  }
}

function toggle_extra() {
  jQuery('.hide-extra').toggle();
}


