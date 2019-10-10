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
       <div class="cell padding-bottom-3">
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
       <div class="cell">
            <div class="grid-x grid-padding-x">
                  <div class="cell medium-6">
                    <div class="grid-y">
                        <div class="cell">
                        ${zumeTraining.translations.titles[1]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[2]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[3]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[4]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[5]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[6]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[7]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[8]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[9]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[10]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[11]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[12]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[13]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[14]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[15]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[16]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[17]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[18]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[19]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[20]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[21]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[22]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[23]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[24]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[25]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[26]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[27]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[28]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[29]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[30]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[31]}
                        </div>
                        <div class="cell">
                        ${zumeTraining.translations.titles[32]}
                        </div>
                        
                        
                    </div>
                  </div>
                  <div class="cell medium-6">
                    HEARD<br>
                    "Heard" means gain knowledge. You have moved from not knowing about a tool or concept to knowing about it.<br>
                    OBEYED<br>
                    "Obeyed" means taking personal action. Obeying with tools might look like beginning to use them with others, while obeying with concepts might look like changing thinking or priorities.<br>
                    SHARED<br>
                    "Shared" means you helped someone else hear. This step is essential to truly understanding the concept or tool and preparing you to train others.<br>
                    TRAINED<br>
                    "Trained" means to coach someone else to obey and share. More than sharing knowledge, you have helped them become a sharer of the tool or concept.<br>
                  </div>
            </div>
        </div>
       
    </div>
</div>
      
`)
}


