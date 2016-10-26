<component :user="{{Auth::user()}}" 
           is="main-header" 
           inline-template>
    <div class="site-header">
        <div class="site-header-container">
            <div class="site-header-item" style="width: 200px;">
                <div class="site-logo">
                  <a href="{{ URL::to('/users/' . Auth::user()->username) }}">
                    <img src="{{asset('images/site/logo-white.png')}}" />
                  </a>
                </div>
                <div class="site-header-title hide-for-small-only">
                    <label>
                        Fitbook
                    </label>
                </div>
            </div>
            <div class="site-header-search site-header-item">
                <div id="graph-search" class="site-search-input">
                  <typeahead @search-change="graphSearch"
                             :items.sync="graphResult"
                             :loading.sync="graphLoading"
                             :min-chars="1"
                             :context="'graph-' + searchType +'-result'"
                             placeholder="Клуб, Хөтөлбөр хайх ...">
                             <div slot="footer">
                                <div class="row text-center">
                                    <p style="color:#3f465;">See all results ...</p>
                                </div>
                             </div>
                  </typeahead>
                </div>
            </div>
            <div class="site-header-item" style="width: 120px;">
            </div>
            <div class="site-header-item" style="width: 40px;">
              <div class="site-header-notification">
                <a @click="showNotifications = true">
                  <i class="fa fa-bell-o"> </i>
                  <span class="alert badge" style="background: #ff5c2d">12</span>
                </a>
              </div>             
            </div>
            <div class="site-header-profile site-header-item">
              <div>  
                <img @click="showLogoutMenus = true" data-toggle="user-menu" class="header-profile-pic" src="{{Auth::user()->avatarSmall[0]->url}}" />
              </div>
            </div>
        </div>
  </div>
    <div class="dropdown-pane bottom" id="user-menu" data-dropdown data-close-on-click="true">
        <component v-if="showLogoutMenus" :user-id="user.id" is="logout-menus">
        </component>
    </div>
    <custom-modal 
        title = "Notifications" 
        usage = "_notifications" 
        :show.sync = "showNotifications"
        context = "notifications"
        >
        <div slot="body">
          <components v-ref:context :user-id="user.id" is="notifications">
              
          </components>
        </div>
    </custom-modal>
</component>

