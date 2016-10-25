<template>
  <div>
      <ul class="tabs content--tabs">
        <li class="tab s3"><a @click="setContent('primary-plan')" class="active">{{$t('general')}} ({{general_count}})</a></li>
        <li class="tab s3"><a @click="setContent('loyalty-plan')">{{$t('loyalty')}} ({{loyalty_count}})</a></li>
      </ul>
  </div>  

  <div class="row content--search plan--content">
    <div class="small-10 columns">
    
    </div>
    <div class="small-2 columns">
      <div class="small-2 columns">
            <a @click="addPlan()" class="button success">
                <i class="fa fa-pencil-square-o">                       
                </i>
            </a>
      </div>
    </div>
     
  </div>

  <plan-select-collection v-ref:filters @update="planFilterChanged">
  </plan-select-collection>

  <custom-modal title = "Teachers" :show.sync="showTeachers">
    <div slot="body">
      <plan-teachers :id="currentPlan.id"></plan-teachers>
    </div>
  </custom-modal>

  <custom-modal 
      :id = "id"
      v-ref:addpl
      type = "Club"
      title = "Add Plan" 
      usage = "_add-plan" 
      :show.sync = "showAddPlan"
      save-callback = "savePlan"
      validateable = 'Y'
      >
      <div slot="body">
        <components v-ref:context 
                    :id="id" 
                    is="add-plan"
                    :plan="currentPlan">
            
        </components>
      </div>
  </custom-modal>

  <custom-callout :loading.sync="planLoader" :spinner-color="'#5fcf80'" type="callout__base">
    <div slot="content">
      <component :id="id" :is="content">
      </component>    
    </div>
  </custom-callout>
  
</template>

<script>
  import PrimaryPlan from './PrimaryPlan.vue';
  import LoyaltyPlan from './LoyaltyPlan.vue';
  import PlanSelectCollection from '../../application/components/PlanSelectCollection.vue';
  import AddPlan from '../../../context/AddPlan.vue';
  import PlanTeachers from './PlanTeachers.vue';

  export default {
    props: { 
      id : {},
    },

    data() {
      return {
        planType : 1,
        content : 'primary-plan',
        planLoader : false,
        plans : [],
        showAddPlan : false,
        showTeachers : false,
        search : '',
        dateOption : {},
        dateSelection : null,
        currentPlan : null,
        general_count : 0,
        loyalty_count : 0,
      }
    },

    created : function () {
        this.init();
    },

    ready : function () {
        $('ul.tabs').tabs();
    },

    events : {
        'planLoaderStart' : function() {
            this.planLoader = true;
        },

        'planLoaderStop' : function() {
            this.planLoader = false;
        },

        'savePlan' : function($response) {
            this.methodType == "add" ? this.savePlan($response) : this.updatePlan($response);
        },

        'editPlan' : function($response) {
            this.currentPlan = $response;
            this.editPlan($response.id);
        }, 

        'allTeachers' : function($response) {
            this.currentPlan = $response;
            this.showTeachers = true;
        }
    },

    methods : {
        planFilterChanged : function (filters) {
            this.$broadcast('_filtered', filters);
        },

        init : function () {
            this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan/count').then(res => {

                this.general_count = res.data.general_count;
                this.loyalty_count = res.data.loyalty_count;

            }).catch(err => {
              console.log(err);
            });
        },

        setOrderBy : function (order) {
            this.orderBy = order;
            this.$broadcast('_orderchanged', this.orderBy);
        },

        addPlan : function() {
            this.methodType = 'add';
            this.currentPlan = null;
            this.showAddPlan = true;
        },

        editPlan : function(id) {
          this.$http.get(this.$env.get('APP_URI') + 'api/plan/' + id + '/edit').then(res => {
              this.methodType = 'edit';
              this.currentPlan = res.data.result;
              this.showAddPlan = true;
          }).catch(err => {
            console.log(err);
          });
        },

        updatePlan : function ($response) {
            this.$http.post(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?data=' + $response.data.param).then(res => {
                
                if(res.data.code == 0) {
                    var current = res.data.result;
                    var pinned_photos = [];
                    pinned_photos.push($response.data.pinned_photo);

                    current.plan.pinned_photos = pinned_photos;
                    current.plan.first_two_teachers = $response.data.teachers;
                    current.plan.teachers_count = $response.data.teachers.length;
                    current.plan.services = $response.data.services;
                    current.plan.trainings = $response.data.trainings;


                    this.showAddPlan = false;
                }

                this.$refs.addpl.loading = false;
                this.$root.$refs.toast.showMessage(res.data.message);
            }).catch(err => {
                this.$refs.addpl.loading = false;
                this.$root.$refs.toast.showMessage('Server side error!.');
            });
        },

        savePlan : function($response) {
            this.$http.post(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?data=' + $response.data.param).then(res => {

                this.$refs.addpl.loading = false;
                this.$root.$refs.toast.showMessage(res.data.message);
                this.showAddPlan = false;

                if(res.data.code == 0) {
                    this.$refs.filters.setNewestFilterOn();
                }
                
            }).catch(err => {
                this.$refs.addpl.loading = false;
                this.$root.$refs.toast.showMessage('Server side error!.');
            });
        },

        increasePlanCount : function (type) {
            if(type == "'App\\PrimaryPlan'") {
                this.general_count ++;
                return;
            }

            this.loyalty_count ++;
        },

        setContent : function (content) {
            this.$refs.filters.resetFilter();
            this.content = content;
        }
    },

    components : {
        PrimaryPlan, LoyaltyPlan, PlanSelectCollection, AddPlan, PlanTeachers
    },

    locales: {
        en: { 
            date : 'Date',
            plan : 'Plan',
            general: 'General',
            loyalty : 'Loyalty',
            newest : 'NEWEST',
            oldest : 'OLDEST',
            price : 'PRICE',
            max : 'MAX',
            heart : 'HEART',
        },
        mn : {
            date : 'Хугацаа',
            general: 'Үндсэн',
            plan : 'Хөтөлбөр',
            loyalty : 'Урамшуулал',
            newest : 'Шинэ',
            oldest : 'Хуучин',
            price : 'Үнэ',
            max : 'MAX',
            heart : 'Таалагдсан',
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

.plan--content{
  color: inherit;
  input{
    margin: 0 !important;
  }
  .button{
    margin: 0;
  }
}
.sortby--menu{
  font-size:12px;
  ul{
    margin-top:10px;
    background-color:#F2F5F8;
    border-radius:4px;
  }
  .sortby--selected{
    font-weight:bold;
    color: #3f4652;
  }
}

</style>