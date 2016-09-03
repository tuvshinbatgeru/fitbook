<template>
  <div class="row small-up-3">
    <div class="column">
      <a @click="setRegistrationType('plan-panel')" class="button success">{{$t('plan')}} ({{plan_count}})</a>
      <a @click="setRegistrationType('training-panel')" class="button success">{{$t('training')}} ({{training_count}})</a>
      <a @click="setRegistrationType('service-panel')" class="button success">{{$t('service')}} ({{service_count}})</a>
    </div>
  </div>

  <component :id="clubid" 
             :is="type">
  </component>
  
</template>

<script>

  import PlanPanel from '.././components/PlanPanel.vue';
  import TrainingPanel from '.././components/TrainingPanel.vue';
  import ServicePanel from '.././components/ServicePanel.vue';

  export default {
    props: { 
      clubid : {},
      type : {
        default : 'training-panel'
      },
    },

    data() {
      return {
        submenu : 'request-members',
        plan_count : 0,
        training_count : 0,
        service_count : 0,
      }
    },

    created: function () {
        this.init();
    },

    methods : {
        init: function () {
            /*this.$http.get(this.$env.get('APP_URI') + 'api/club/edit/' + this.clubid + '/members?type=' + this.memberType).then((response) => 
            {
                this.request_count = response.data.requests_count;
                this.member_count = response.data.members_count;
                this.archive_count = response.data.archive_count;
            }, (response) => {

            });     */   
        },

        setRegistrationType : function (type) {
            this.type = type;
        },
    },

    components : {
        PlanPanel, TrainingPanel, ServicePanel
    },

    locales: {
        en: { 
            plan : 'Plan',
            training : 'Training',
            service : 'Service',
        },
        mn : {
            plan : 'Хөтөлбөр',
            training : 'Хичээл',
            service : 'Үйлчилгээ',
        },
    }
  }
</script>
  
<style lang="scss">
</style>