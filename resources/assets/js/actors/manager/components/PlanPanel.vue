<template>
  <div>
      <ul class="tabs">
        <li class="tab s3"><a @click="setPlanType(1)" class="active">{{$t('plan')}} (1)</a></li>
        <li class="tab s3"><a @click="setPlanType(2)">{{$t('loyalty')}} (1)</a></li>
      </ul>
  </div>  

  <div class="row">
    <div class="small-10 columns">
      <input type="text" name="search" placeholder="search ...">
    </div>
    <div class="small-2 columns">
      <div class="small-2 columns">
            <a @click="showTraining = true" class="button success">
                <i class="fa fa-pencil-square-o">                       
                </i>
            </a>
      </div>
    </div>
  </div>

  <custom-modal
    :id = "id"
    type = "Club"
    title = "Trainings"
    usage = "_training-chooser"
    :items = "trainings"
    :show.sync = "showTraining"
    save-callback = "choosedTrainings"
    context = "trainings">
  </custom-modal>

</template>

<script>

  export default {
    props: { 
      id : {},
    },

    data() {
      return {
        planType : 1,
        panels : [],
        showTraining : false,
      }
    },

    created : function () {
        this.getPanels();
    },

    ready : function () {
      $('ul.tabs').tabs();
    },

    methods : {
        getPanels: function () {
                         
        },

        setPlanType : function (type) {
            this.planType = type;
        }
    },

    components : {
        
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