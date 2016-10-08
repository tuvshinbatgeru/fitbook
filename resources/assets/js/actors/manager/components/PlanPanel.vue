<template>
  <div class="widget-content">
    <div class="content--header">
      <h3>{{$t('plan')}}</h3>
    </div>
    <div class="content--container">
      <div class="content--back">
        <ul class="tabs content--tabs">
          <li class="tab s3"><a @click="setContent('primary-plan')" class="active">{{$t('general')}} (1)</a></li>
          <li class="tab s3"><a @click="setContent('loyalty-plan')">{{$t('loyalty')}} (1)</a></li>
        </ul>
        <div class="row content--search plan--content">
          <div class="small-10 columns">
            <input type="text" v-model="search"  placeholder="search ...">
          </div>
          <div class="small-2 columns">
            <a @click="showAddPlan = true" class="button success">
                <i class="fa fa-pencil-square-o"></i>
            </a>
          </div>
        </div>
        <div class="row">
            <ul class="dropdown menu sortby--menu" data-dropdown-menu v-foundation-dropdown-menu>
                <li class="is-dropdown-submenu-parent">
                    <a>{{$t(orderBy)}}</a>
                    <ul class="menu">
                      <div class="arrow"></div>
                      <li><a @click="setOrderBy('newest')" class="sortby--selected">{{$t('newest')}}</a></li>
                      <li><a @click="setOrderBy('oldest')">{{$t('oldest')}}</a></li>
                      <li><a @click="setOrderBy('heart')">{{$t('heart')}}</a></li>
                      <li><a @click="setOrderBy('price')">{{$t('price')}}</a></li>
                      <li><a @click="setOrderBy('max')">{{$t('max')}}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <custom-modal 
            :id = "id"
            v-ref:addpl
            type = "Club"
            title = "Add Plan" 
            usage = "_add-plan" 
            :show.sync = "showAddPlan"
            save-callback = "savePlan"
            validateable = 'Y'
            context = "AddPlan"
            >
        </custom-modal>

        <component :id="id" 
                   :order-by.sync="orderBy"
                   :search-text.sync="search"
                   :is="content">
        </component>
      </div>
    </div>
  </div>
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
        orderBy : 'newest',
        showAddPlan : false,
        search : '',
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
        setOrderBy : function (order) {
            this.orderBy = order;
            this.$broadcast('_orderchanged', this.orderBy);
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

                this.$refs.addpl.loading = false;
                this.$root.$refs.toast.showMessage(res.data.message);
            }).catch(err => {
                this.$refs.addpl.loading = false;
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
            general: 'General',
            loyalty : 'Loyalty',
            newest : 'NEWEST',
            oldest : 'OLDEST',
            price : 'PRICE',
            max : 'MAX',
            heart : 'HEART',
        },
        mn : {
            plan : 'Хөтөлбөр',
            general: 'Үндсэн',
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