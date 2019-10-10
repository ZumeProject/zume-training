jQuery(document).ready(function(){
  if( '#panel2' === window.location.hash  ) {
    get_groups()
  }
  if( '#panel3' === window.location.hash  ) {
    get_progress()
  }
})


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

function get_groups() {
  let div = jQuery('#group-list')
  div.empty()

  let groups = [ // @todo make an ajax call
    {
      title: 'Group 1'
    },
    {
      title: 'Group 2'
    }
  ]

  jQuery.each(groups, function(i,v) {
    div.append(`
<div class="cell group-section border-bottom padding-bottom-2 margin-bottom-2">
    <div class="grid-x grid-padding-x">
       <div class="cell">
       <h2>${v.title}</h2></div>
      <div class="cell small-4">
          Sessions<br>
          &#9724; Session 1<br>
          &#9724; Session 2<br>
          &#9724; Session 3<br>
          &#9724; Session 4<br>
          &#9724; Session 5<br>
          &#9724; Session 6<br>
          &#9723; Session 7<br>
          &#9723; Session 8<br>
          &#9723; Session 9<br>
          &#9723; Session 10<br>
      </div>
      <div class="cell small-4">
          <div class="grid-y">
                <div class="cell padding-bottom-1">
                    Members<br>
                    <select><option>16</option></select><br>
                </div>
                <div class="cell">
                    Members List (optional)<br>
                    Name email@email.com <br>
                    Name email@email.com <br>
                    Name email@email.com <br>
                    Name email@email.com <br>
                    Name email@email.com <br>
                    Name email@email.com <br>
                    <i class="fi-plus"></i> add
                </div>
          </div>
          
          
      </div>
      <div class="cell small-4">
          Location<br>
          <i class="fi-plus"></i> add
      </div>
    </div>
</div>

      
    `)
  })
}

function get_progress() {
  let div = jQuery('#progress-stats')
  div.empty()


div.append(`
<div class="cell">
    <div class="grid-y">
       <div class="cell">
            <div class="grid-x grid-padding-x grid-padding-y center">
                <div class="cell small-3">
                    <div class="circle-background">29</div>
                </div>
                <div class="cell small-3">
                    <div class="circle-background">21</div>
                </div>
                <div class="cell small-3">
                    <div class="circle-background">13</div>
                </div>
                <div class="cell small-3 center">
                    <div class="circle-background">6</div>
                </div>
            </div>
        </div>
       <div class="cell">list</div>
       <div class="cell">description</div>
    </div>
</div>
      
`)
}


