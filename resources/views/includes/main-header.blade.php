<component :user="{{Auth::user()}}" 
           is="main-header" 
           inline-template>
    <div class="row">
      <div class="header">
        <div class="burger-container">
          <div id="burger">
            <div class="bar topBar"></div>
            <div class="bar btmBar"></div>
          </div>
        </div>

        <ul class="menu">
          <li class="menu-logo">
            <a>
              <img src="{{asset('images/site/logo-little-smooth.png')}}" />
            </a> 
          </li>
          <li class="menu-item"><a href="#">Watch</a></li>
          <li class="menu-item">
            <a @click="showNotifications = true">
              Notifications
            </a>
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
          </li>
        </ul>
      </div>
    </div>
</component>

