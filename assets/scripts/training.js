jQuery(document).ready(function(){
  if( '#panel2' === window.location.hash  ) {
    console.log(zumeTraining)
    get_groups()
  }
  if( '#panel3' === window.location.hash  ) {
    console.log(zumeTraining)
    get_progress()
    progress_icons_listener()
  }
})


function get_groups() {
  let div = jQuery('#group-list')
  div.empty()

  let groups = [ // @todo make an ajax call
    {
      owner               : 2,
      group_name          : 'Group 1',
      key                 : 'zume_group_98878234',
      public_key          : 'kdjsn',
      members             : 1,
      meeting_time        : '',
      address             : '',
      lng                 : '',
      lat                 : '',
      raw_location        : [],
      ip_address          : '',
      ip_lng              : '',
      ip_lat              : '',
      ip_raw_location     : [],
      created_date        : '',
      next_session        : 1,
      session_1           : false,
      session_1_complete  : '',
      session_2           : false,
      session_2_complete  : '',
      session_3           : false,
      session_3_complete  : '',
      session_4           : false,
      session_4_complete  : '',
      session_5           : false,
      session_5_complete  : '',
      session_6           : false,
      session_6_complete  : '',
      session_7           : false,
      session_7_complete  : '',
      session_8           : false,
      session_8_complete  : '',
      session_9           : false,
      session_9_complete  : '',
      session_10          : false,
      session_10_complete : '',
      last_modified_date  : '',
      closed              : false,
      coleaders           : [],
      coleaders_accepted  : [],
      coleaders_declined  : [],
      three_month_plans   : [],
      foreign_key         : ''
    },
    {
      owner               : 2,
      group_name          : 'Group 2',
      key                 : 'zume_group_98878234',
      public_key          : 'kdjsn',
      members             : 1,
      meeting_time        : '',
      address             : '',
      lng                 : '',
      lat                 : '',
      raw_location        : [],
      ip_address          : '',
      ip_lng              : '',
      ip_lat              : '',
      ip_raw_location     : [],
      created_date        : '',
      next_session        : 1,
      session_1           : false,
      session_1_complete  : '',
      session_2           : false,
      session_2_complete  : '',
      session_3           : false,
      session_3_complete  : '',
      session_4           : false,
      session_4_complete  : '',
      session_5           : false,
      session_5_complete  : '',
      session_6           : false,
      session_6_complete  : '',
      session_7           : false,
      session_7_complete  : '',
      session_8           : false,
      session_8_complete  : '',
      session_9           : false,
      session_9_complete  : '',
      session_10          : false,
      session_10_complete : '',
      last_modified_date  : '',
      closed              : false,
      coleaders           : [],
      coleaders_accepted  : [],
      coleaders_declined  : [],
      three_month_plans   : [],
      foreign_key         : ''
    }
  ]

  jQuery.each(groups, function(i,v) {
    div.append(`
<div class="cell group-section border-bottom padding-bottom-2 margin-bottom-2">
    <div class="grid-x grid-padding-x">
       <div class="cell"><!--Full width top -->
        <h2>${v.group_name}</h2>
       </div>
      <div class="cell small-4"> <!-- Column 1 -->
         <div class="grid-y">
            <div class="cell"><a href=""><i class="g-session-icon complete"></i> Session 1</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon"></i> Session 2</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon"></i> Session 3</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon"></i> Session 4</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon"></i> Session 5</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon"></i> Session 6</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon"></i> Session 7</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon"></i> Session 8</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon"></i> Session 9</a></div>    
            <div class="cell"><a href=""><i class="g-session-icon"></i> Session 10</a></div>    
         </div>
      </div>
      <div class="cell small-4"> <!-- Column 2 -->
          <div class="grid-y">
                <div class="cell column-header">
                    Members
                </div>
                <div class="cell padding-bottom-1">
                    <select><option>16</option></select><br>
                </div>
                <div class="cell column-header">
                    Members List (optional)
                </div>
                <div class="cell">
                    <div class="grid-y member-list">
                      <div class="cell">Name email@email.com</div>    
                      <div class="cell">Name email@email.com</div>    
                      <div class="cell">Name email@email.com</div>    
                    </div>
                </div>
                <div class="cell add-member">
                    <button type="button" class="button clear" onclick="add_member()"><i class="fi-plus"></i> add</button>
                </div>
          </div>
      </div>
      <div class="cell small-4"> <!-- Column 3 -->
          <div class="grid-y">
              <div class="cell">
                <span class="column-header">Location</span>
              </div>
               <div class="cell">
                
              </div>
              <div class="cell">
                <button type="button" class="button clear" onclick="add_location()"><i class="fi-plus"></i> add</button>
              </div>
          </div>
          
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
                            <i class="p-icon" id="1h"></i><i class="p-icon" id="1o"></i><i class="p-icon" id="1s"></i><i class="p-icon" id="1t"></i> 
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[1]}">${zumeTraining.translations.titles[1]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[2]}">${zumeTraining.translations.titles[2]}</a></span>
                            <i class="p-icon" id="2h"></i><i class="p-icon" id="2o"></i><i class="p-icon" id="2s"></i><i class="p-icon" id="2t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[2]}">${zumeTraining.translations.titles[2]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[3]}">${zumeTraining.translations.titles[3]}</a></span>
                            <i class="p-icon" id="3h"></i><i class="p-icon" id="3o"></i><i class="p-icon" id="3s"></i><i class="p-icon" id="3t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[3]}">${zumeTraining.translations.titles[3]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[4]}">${zumeTraining.translations.titles[4]}</a></span>
                            <i class="p-icon" id="4h"></i><i class="p-icon" id="4o"></i><i class="p-icon" id="4s"></i><i class="p-icon" id="4t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[4]}">${zumeTraining.translations.titles[4]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[5]}">${zumeTraining.translations.titles[5]}</a></span>
                            <i class="p-icon" id="5h"></i><i class="p-icon" id="5o"></i><i class="p-icon" id="5s"></i><i class="p-icon" id="5t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[5]}">${zumeTraining.translations.titles[5]}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[2]}</a>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[6]}">${zumeTraining.translations.titles[6]}</a></span>
                            <i class="p-icon" id="6h"></i><i class="p-icon" id="6o"></i><i class="p-icon" id="6s"></i><i class="p-icon" id="6t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[6]}">${zumeTraining.translations.titles[6]}</a></span>
                          </div>
                          <div class="cell ">
                            <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[7]}">${zumeTraining.translations.titles[7]}</a></span>
                            <i class="p-icon" id="7h"></i><i class="p-icon" id="7o"></i><i class="p-icon" id="7s"></i><i class="p-icon" id="7t"></i>
                            <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[7]}">${zumeTraining.translations.titles[7]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[8]}">${zumeTraining.translations.titles[8]}</a></span>
                          <i class="p-icon" id="8h"></i><i class="p-icon" id="8o"></i><i class="p-icon" id="8s"></i><i class="p-icon" id="8t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[8]}">${zumeTraining.translations.titles[8]}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[3]}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[9]}">${zumeTraining.translations.titles[9]}</a></span>
                          <i class="p-icon" id="9h"></i><i class="p-icon" id="9o"></i><i class="p-icon" id="9s"></i><i class="p-icon" id="9t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[9]}">${zumeTraining.translations.titles[9]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[10]}">${zumeTraining.translations.titles[10]}</a></span>
                          <i class="p-icon" id="10h"></i><i class="p-icon" id="10o"></i><i class="p-icon" id="10s"></i><i class="p-icon" id="10t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[10]}">${zumeTraining.translations.titles[10]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[11]}">${zumeTraining.translations.titles[11]}</a></span>
                          <i class="p-icon" id="11h"></i><i class="p-icon" id="11o"></i><i class="p-icon" id="11s"></i><i class="p-icon" id="11t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[11]}">${zumeTraining.translations.titles[11]}</a></span>
                          </div>
                          <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[4]}</a>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[12]}">${zumeTraining.translations.titles[12]}</a></span>
                          <i class="p-icon" id="12h"></i><i class="p-icon" id="12o"></i><i class="p-icon" id="12s"></i><i class="p-icon" id="12t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[12]}">${zumeTraining.translations.titles[12]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[13]}">${zumeTraining.translations.titles[13]}</a></span>
                          <i class="p-icon" id="13h"></i><i class="p-icon" id="13o"></i><i class="p-icon" id="13s"></i><i class="p-icon" id="13t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[13]}">${zumeTraining.translations.titles[13]}</a></span>
                          </div>
                          <div class="cell ">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[14]}">${zumeTraining.translations.titles[14]}</a></span>
                          <i class="p-icon" id="14h"></i><i class="p-icon" id="14o"></i><i class="p-icon" id="14s"></i><i class="p-icon" id="14t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[14]}">${zumeTraining.translations.titles[14]}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[15]}">${zumeTraining.translations.titles[15]}</a></span>
                          <i class="p-icon" id="15h"></i><i class="p-icon" id="15o"></i><i class="p-icon" id="15s"></i><i class="p-icon" id="15t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[15]}">${zumeTraining.translations.titles[15]}</a></span>
                          </div>
                          <div class="cell">
                          <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[16]}">${zumeTraining.translations.titles[16]}</a></span>
                          <i class="p-icon" id="16h"></i><i class="p-icon" id="16o"></i><i class="p-icon" id="16s"></i><i class="p-icon" id="16t"></i>
                          <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[16]}">${zumeTraining.translations.titles[16]}</a></span>
                          </div>
                            <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[5]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[17]}">${zumeTraining.translations.titles[17]}</a></span>
                        <i class="p-icon" id="17h"></i><i class="p-icon" id="17o"></i><i class="p-icon" id="17s"></i><i class="p-icon" id="17t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[17]}">${zumeTraining.translations.titles[17]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[18]}">${zumeTraining.translations.titles[18]}</a></span>
                        <i class="p-icon" id="18h"></i><i class="p-icon" id="18o"></i><i class="p-icon" id="18s"></i><i class="p-icon" id="18t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[18]}">${zumeTraining.translations.titles[18]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[19]}">${zumeTraining.translations.titles[19]}</a></span>
                        <i class="p-icon" id="19h"></i><i class="p-icon" id="19o"></i><i class="p-icon" id="19s"></i><i class="p-icon" id="19t"></i>
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
                        <i class="p-icon" id="20h"></i><i class="p-icon" id="20o"></i><i class="p-icon" id="20s"></i><i class="p-icon" id="20t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[20]}">${zumeTraining.translations.titles[20]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[21]}">${zumeTraining.translations.titles[21]}</a></span>
                        <i class="p-icon" id="21h"></i><i class="p-icon" id="21o"></i><i class="p-icon" id="21s"></i><i class="p-icon" id="21t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[21]}">${zumeTraining.translations.titles[21]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[7]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[22]}">${zumeTraining.translations.titles[22]}</a></span>
                        <i class="p-icon" id="22h"></i><i class="p-icon" id="22o"></i><i class="p-icon" id="22s"></i><i class="p-icon" id="22t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[22]}">${zumeTraining.translations.titles[22]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[8]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[23]}">${zumeTraining.translations.titles[23]}</a></span>
                        <i class="p-icon" id="23h"></i><i class="p-icon" id="23o"></i><i class="p-icon" id="23s"></i><i class="p-icon" id="23t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[23]}">${zumeTraining.translations.titles[23]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[9]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[24]}">${zumeTraining.translations.titles[24]}</a></span>
                        <i class="p-icon" id="24h"></i><i class="p-icon" id="24o"></i><i class="p-icon" id="24s"></i><i class="p-icon" id="24t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[24]}">${zumeTraining.translations.titles[24]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[25]}">${zumeTraining.translations.titles[25]}</a></span>
                        <i class="p-icon" id="25h"></i><i class="p-icon" id="25o"></i><i class="p-icon" id="25s"></i><i class="p-icon" id="25t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[25]}">${zumeTraining.translations.titles[25]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[26]}">${zumeTraining.translations.titles[26]}</a></span>
                        <i class="p-icon" id="26h"></i><i class="p-icon" id="26o"></i><i class="p-icon" id="26s"></i><i class="p-icon" id="26t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[26]}">${zumeTraining.translations.titles[26]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[27]}">${zumeTraining.translations.titles[27]}</a></span>
                        <i class="p-icon" id="27h"></i><i class="p-icon" id="27o"></i><i class="p-icon" id="27s"></i><i class="p-icon" id="27t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[27]}">${zumeTraining.translations.titles[27]}</a></span>
                        </div>
                        <div class="cell p-session-separator padding-top-1">
                          ${zumeTraining.translations.sessions[10]}</a>
                          </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[28]}">${zumeTraining.translations.titles[28]}</a></span>
                        <i class="p-icon" id="28h"></i><i class="p-icon" id="28o"></i><i class="p-icon" id="28s"></i><i class="p-icon" id="28t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[28]}">${zumeTraining.translations.titles[28]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[29]}">${zumeTraining.translations.titles[29]}</a></span>
                        <i class="p-icon" id="29h"></i><i class="p-icon" id="29o"></i><i class="p-icon" id="29s"></i><i class="p-icon" id="29t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[29]}">${zumeTraining.translations.titles[29]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[30]}">${zumeTraining.translations.titles[30]}</a></span>
                        <i class="p-icon" id="30h"></i><i class="p-icon" id="30o"></i><i class="p-icon" id="30s"></i><i class="p-icon" id="30t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[30]}">${zumeTraining.translations.titles[30]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[31]}">${zumeTraining.translations.titles[31]}</a></span>
                        <i class="p-icon" id="31h"></i><i class="p-icon" id="31o"></i><i class="p-icon" id="31s"></i><i class="p-icon" id="31t"></i>
                        <span class="hide-for-small-only"><a href="${zumeTraining.translations.urls[31]}">${zumeTraining.translations.titles[31]}</a></span>
                        </div>
                        <div class="cell">
                        <span class="show-for-small-only"><a href="${zumeTraining.translations.urls[32]}">${zumeTraining.translations.titles[32]}</a></span>
                        <i class="p-icon" id="32h"></i><i class="p-icon" id="32o"></i><i class="p-icon" id="32s"></i><i class="p-icon" id="32t"></i>
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
      console.log(item.attr('id') + ' removed')
    } else {
      item.addClass('complete')
      console.log(item.attr('id') + ' added')
    }
  })
}
function toggle_column() {
  let item = jQuery('#column_button')
  if ( item.hasClass("hollow") ) {
    item.removeClass('hollow')
    jQuery('.session').removeClass('medium-6')
    console.log('single')
  } else {
    item.addClass('hollow')
    jQuery('.session').addClass('medium-6')
    console.log('double')
  }
}
function toggle_extra() {
  let item = jQuery('#extra_button')
  if ( item.hasClass("hollow") ) {
    item.removeClass('hollow')
    jQuery('.hide-extra').show();
  } else {
    item.addClass('hollow')
    jQuery('.hide-extra').hide();
  }
}

function add_progress ( stage_id, concept_id ) {

}

function add_member() {
  jQuery('.add-member').empty().append(`
  <hr>
  <input type="text" placeholder="nickname" />
  <input type="text" placeholder="email" />
  <button type="button" class="button small" onclick="save_new_member()">Save</button> 
  `)
}
function save_new_member() {
  let i = jQuery('.add-member input[type=text]')
  jQuery.each()
  console.log(i)

  jQuery('.add-member').empty().append(`<button type="button" class="button clear" onclick="add_member()"><i class="fi-plus"></i> add</button>`)
}

function add_location() {

}


/*
$active_keys = [
'owner'               => get_current_user_id(),
'group_name'          => __( 'No Name', 'zume' ),
'key'                 => self::get_unique_group_key(),
'public_key'          => self::get_unique_public_key(),
'members'             => 1,
'meeting_time'        => '',
'address'             => '',
'lng'                 => '',
'lat'                 => '',
'raw_location'        => [],
'ip_address'          => '',
'ip_lng'              => '',
'ip_lat'              => '',
'ip_raw_location'     => [],
'created_date'        => current_time( 'mysql' ),
'next_session'        => '1',
'session_1'           => false,
'session_1_complete'  => '',
'session_2'           => false,
'session_2_complete'  => '',
'session_3'           => false,
'session_3_complete'  => '',
'session_4'           => false,
'session_4_complete'  => '',
'session_5'           => false,
'session_5_complete'  => '',
'session_6'           => false,
'session_6_complete'  => '',
'session_7'           => false,
'session_7_complete'  => '',
'session_8'           => false,
'session_8_complete'  => '',
'session_9'           => false,
'session_9_complete'  => '',
'session_10'          => false,
'session_10_complete' => '',
'last_modified_date'  => current_time( 'mysql' ),
'closed'              => false,
'coleaders'           => [],
'coleaders_accepted'  => [],
'coleaders_declined'  => [],
'three_month_plans'   => [],
'foreign_key'         => bin2hex( random_bytes( 40 ) ),
];
 */

