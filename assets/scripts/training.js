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
                    <div class="progress-stat-title">Heard</div>
                    <div class="circle-background">29</div>
                    <div class="progress-description">"Heard" means gain knowledge. You have moved from not knowing about a tool or concept to knowing about it.</div>
                </div>
                <div class="cell small-3">
                    <div class="progress-stat-title">Obeyed</div>
                    <div class="circle-background">21</div>
                    <div class="progress-description">"Obeyed" means taking personal action. Obeying with tools might look like beginning to use them with others, while obeying with concepts might look like changing thinking or priorities.</div>
                </div>
                <div class="cell small-3">
                    <div class="progress-stat-title">Shared</div>
                    <div class="circle-background">13</div>
                    <div class="progress-description">"Shared" means you helped someone else hear. This step is essential to truly understanding the concept or tool and preparing you to train others.</div>
                </div>
                <div class="cell small-3 center">
                    <div class="progress-stat-title">Trained</div>
                    <div class="circle-background">6</div>
                    <div class="progress-description">"Trained" means to coach someone else to obey and share. More than sharing knowledge, you have helped them become a sharer of the tool or concept.</div>
                </div>
            </div>
        </div>
       <div class="cell">
            <div class="grid-x grid-padding-x">
                  <div class="cell medium-3 hide-for-small-only"></div>
                  <div class="cell medium-6">
                    <div class="grid-y progress-list">
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[1]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[2]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[3]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[4]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[5]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[6]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[7]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[8]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[9]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[10]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[11]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[12]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[13]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[14]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[15]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[16]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[17]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[18]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[19]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[20]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[21]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[22]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[23]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[24]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[25]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[26]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[27]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[28]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[29]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[30]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[31]}</span>
                        </div>
                        <div class="cell">
                        <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> <span>${zumeTraining.translations.titles[32]}</span>
                        </div>
                    </div>
                    <div class="cell medium-3 hide-for-small-only"></div>
                  </div>
            </div>
        </div>
       
    </div>
</div>
      
`)
}

jQuery(document).ready(function(){
  jQuery('.p-icon').on( 'click', function(){
    let item = jQuery(this)
    if ( item.hasClass("complete") ) {
      item.removeClass('complete')
    } else {
      item.addClass('complete')
    }
  })
})


