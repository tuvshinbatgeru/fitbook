<template>
  <div>
      <ul class="tabs">
        <li class="tab s3"><a @click="setContent('primary-plan')" class="active">{{$t('plan')}} (1)</a></li>
        <li class="tab s3"><a @click="setContent('loyalty-plan')">{{$t('loyalty')}} (1)</a></li>
      </ul>
  </div>  

  <component :id="id" :is="content">
      
  </component>


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

  <label>Select Menu
    <select>
      <option value="husker">All</option>
      <option value="starbuck">Starbuck</option>
      <option value="hotdog">Hot Dog</option>
      <option value="apollo">Apollo</option>
    </select>
  </label>

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
        savePlan : function($response) {
            this.$http.post(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?data=' + $response.data).then(res => {
                this.plans.push(res.data.result);
                this.showAddPlan = false;
                this.$root.$refs.toast.showMessage('Successfully add new plan.');
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
</style>