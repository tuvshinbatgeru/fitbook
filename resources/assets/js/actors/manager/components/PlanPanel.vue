<template>
  <div>
      <ul class="tabs">
        <li class="tab s3"><a @click="setContent('primary-plan')" class="active">{{$t('plan')}} (1)</a></li>
        <li class="tab s3"><a @click="setContent('loyalty-plan')">{{$t('loyalty')}} (1)</a></li>
      </ul>
  </div>  

  <div class="row">
    <div class="small-10 columns">
      <input type="text" name="search" placeholder="search ...">
    </div>
    <div class="small-2 columns">
      <div class="small-2 columns">
            <a @click="showAddPlan = true" class="button success">
                <i class="fa fa-pencil-square-o">                       
                </i>
            </a>
      </div>
    </div>
  </div>

  <div class="row">
      <ul class="dropdown menu" data-dropdown-menu v-foundation-dropdown-menu>
          <li class="is-dropdown-submenu-parent" style="background-color:#aecaec; border-radius:4px; font-size:12px;">
              <a style="color:#fff; font-weight:bold;">Sort By</a>
              
              <ul class="menu" style="margin-top:10px; background-color:#F2F5F8; border-radius:4px;">
                <div class="arrow"></div>
                <li><a>NEWEST</a></li>
                <li><a>OLDEST</a></li>
                <li><a>HEART</a></li>
                <li><a>PRICE</a></li>
                <li><a>SUBSCRIPTION COUNT</a></li>
              </ul>
          </li>
      </ul>
  </div>

  <custom-modal 
      :id = "id"
      type = "Club"
      title = "Add Plan" 
      usage = "_add-plan" 
      :show.sync = "showAddPlan"
      save-callback = "savePlan"
      validateable = 'Y'
      context = "AddPlan"
      >
  </custom-modal>

  <component :id="id" :is="content">
      
  </component>
</template>

<script>
  import PrimaryPlan from './PrimaryPlan.vue';
  import LoyaltyPlan from './LoyaltyPlan.vue';

  export default {
    props: { 
      id : {},
    },

    data() {
      return {
        planType : 1,
        content : 'primary-plan',
        plans : [],
        showAddPlan : false,
      }
    },

    created : function () {
        this.$broadcast('_planadded', null);
    },

    ready : function () {
      $('ul.tabs').tabs();
    },

    events : {
        'savePlan' : function($response) {
            this.savePlan($response);
        },
    },

    methods : {
        testBroadcast : function () {
            this.$broadcast('_planadded', null);
        },
        savePlan : function($response) {
            this.$http.post(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?data=' + $response.data.param).then(res => {
                
                if(res.data.code == 0) {
                    var current = res.data.result;
                    var pinned_photos = [];
                    pinned_photos.push($response.data.pinned_photo);

                    current.plan[0].pinned_photos = pinned_photos;

                    current.plan[0].teachers = $response.data.teachers;
                    current.plan[0].services = $response.data.services;
                    current.plan[0].trainings = $response.data.trainings;
                    this.$broadcast('_planadded', current);
                    this.showAddPlan = false;
                }

                this.$root.$refs.toast.showMessage(res.data.message);
            }).catch(err => {
                this.$root.$refs.toast.showMessage('Server side error!.');
            });
        },

        setContent : function (content) {
            this.content = content;
        }
    },

    components : {
        PrimaryPlan, LoyaltyPlan
    },

    locales: {
        en: { 
            plan : 'Plan',
            loyalty : 'Loyalty',
        },
        mn : {
            plan : 'Хөтөлбөр',
            loyalty : 'Урамшуулал',
        },
    }
  }
</script>
  
<style lang="scss">

.arrow {
    width: 0;
    height: 0;
    margin-top: -8px;
    margin-left: 15px;
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-bottom: 9px solid #F2F5F8;
}

</style>