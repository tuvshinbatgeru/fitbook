<template>
  <div>
      <ul class="tabs">
        <li class="tab s3"><a @click="setSubMenu('request-members')" class="active">{{$t('plan')}} ({{request_count}})</a></li>
        <li class="tab s3"><a @click="setSubMenu('current-members')">{{$t('loyalty')}} ({{member_count}})</a></li>
      </ul>
  </div>  

  <div class="small-9 text-center small-centered columns">
      <!-- <component :id="clubid" 
                 :type="memberType" 
                 :is="submenu">
      </component> -->
  </div>
</template>

<script>

  export default {
    props: { 
      id : {},
    },

    data() {
      return {
        
      }
    },

    created: function () {
        this.init();
    },

    methods : {
        init: function () {
                  
        },
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