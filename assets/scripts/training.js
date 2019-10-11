jQuery(document).ready(function(){
  if( '#panel2' === window.location.hash  ) {
    get_groups()
  }
  if( '#panel3' === window.location.hash  ) {
    get_progress()
    progress_icons_listener()
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
                <div class="cell medium-1 hide-for-small-only"></div>
                  <div class="cell medium-5">
                      <div class="grid-x grid-padding-x progress-list">
                          <div class="cell p-session-separator">
                          ${zumeTraining.translations.sessions[1]}
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[1]}">${zumeTraining.translations.titles[1]}</a></span> 
                            <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[1]}">${zumeTraining.translations.titles[1]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[2]}">${zumeTraining.translations.titles[2]}</a></span>
                            <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[2]}">${zumeTraining.translations.titles[2]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[3]}">${zumeTraining.translations.titles[3]}</a></span>
                            <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[3]}">${zumeTraining.translations.titles[3]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[4]}">${zumeTraining.translations.titles[4]}</a></span>
                            <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[4]}">${zumeTraining.translations.titles[4]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[5]}">${zumeTraining.translations.titles[5]}</a></span>
                            <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[5]}">${zumeTraining.translations.titles[5]}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[2]}</a>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[6]}">${zumeTraining.translations.titles[6]}</a></span>
                            <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[6]}">${zumeTraining.translations.titles[6]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[7]}">${zumeTraining.translations.titles[7]}</a></span>
                            <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[7]}">${zumeTraining.translations.titles[7]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[8]}">${zumeTraining.translations.titles[8]}</a></span>
                          <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[8]}">${zumeTraining.translations.titles[8]}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[3]}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[9]}">${zumeTraining.translations.titles[9]}</a></span>
                          <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[9]}">${zumeTraining.translations.titles[9]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[10]}">${zumeTraining.translations.titles[10]}</a></span>
                          <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[10]}">${zumeTraining.translations.titles[10]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[11]}">${zumeTraining.translations.titles[11]}</a></span>
                          <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[11]}">${zumeTraining.translations.titles[11]}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[4]}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[12]}">${zumeTraining.translations.titles[12]}</a></span>
                          <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[12]}">${zumeTraining.translations.titles[12]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[13]}">${zumeTraining.translations.titles[13]}</a></span>
                          <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[13]}">${zumeTraining.translations.titles[13]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[14]}">${zumeTraining.translations.titles[14]}</a></span>
                          <i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[14]}">${zumeTraining.translations.titles[14]}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[15]}">${zumeTraining.translations.titles[15]}</a></span>
                          <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[15]}">${zumeTraining.translations.titles[15]}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[16]}">${zumeTraining.translations.titles[16]}</a></span>
                          <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[16]}">${zumeTraining.translations.titles[16]}</a></span>
                          </div>
                            <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[5]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[17]}">${zumeTraining.translations.titles[17]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[17]}">${zumeTraining.translations.titles[17]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[18]}">${zumeTraining.translations.titles[18]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[18]}">${zumeTraining.translations.titles[18]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[19]}">${zumeTraining.translations.titles[19]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[19]}">${zumeTraining.translations.titles[19]}</a></span>
                        </div>
                      </div>
                  </div>
                  <div class="cell medium-5">
                    <div class="grid-x grid-padding-x progress-list">
                        <div class="cell p-session-separator session-6-column-top">
                          ${zumeTraining.translations.sessions[6]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[20]}">${zumeTraining.translations.titles[20]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[20]}">${zumeTraining.translations.titles[20]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[21]}">${zumeTraining.translations.titles[21]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[21]}">${zumeTraining.translations.titles[21]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[7]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[22]}">${zumeTraining.translations.titles[22]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[22]}">${zumeTraining.translations.titles[22]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[8]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[23]}">${zumeTraining.translations.titles[23]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[23]}">${zumeTraining.translations.titles[23]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[9]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[24]}">${zumeTraining.translations.titles[24]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[24]}">${zumeTraining.translations.titles[24]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[25]}">${zumeTraining.translations.titles[25]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[25]}">${zumeTraining.translations.titles[25]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[26]}">${zumeTraining.translations.titles[26]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[26]}">${zumeTraining.translations.titles[26]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[27]}">${zumeTraining.translations.titles[27]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[27]}">${zumeTraining.translations.titles[27]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[10]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[28]}">${zumeTraining.translations.titles[28]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[28]}">${zumeTraining.translations.titles[28]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[29]}">${zumeTraining.translations.titles[29]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[29]}">${zumeTraining.translations.titles[29]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[30]}">${zumeTraining.translations.titles[30]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[30]}">${zumeTraining.translations.titles[30]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[31]}">${zumeTraining.translations.titles[31]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[31]}">${zumeTraining.translations.titles[31]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[32]}">${zumeTraining.translations.titles[32]}</a></span>
                        <i class="p-icon "></i><i class="p-icon"></i><i class="p-icon"></i><i class="p-icon"></i> 
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[32]}">${zumeTraining.translations.titles[32]}</a></span>
                        </div>
                    </div>
                  </div>
                  <div class="cell medium-1 hide-for-small-only"></div>
            </div>
        </div>
       
    </div>
</div>
      
`)
  progress_icons_listener()
}

jQuery(document).ready(function(){
  progress_icons_listener()
})
function progress_icons_listener() {
  jQuery('.p-icon').on( 'click', function(){
    let item = jQuery(this)
    if ( item.hasClass("complete") ) {
      item.removeClass('complete')
    } else {
      item.addClass('complete')
    }
  })
}


