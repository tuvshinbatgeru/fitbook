<template>
  <div class="row small-up-3">
    <div class="column">
      <a @click="setMembersType(1)" class="button success">{{$t('teacher')}}</a>
      <a @click="setMembersType(2)" class="button success">{{$t('manager')}}</a>
      <a @click="setMembersType(3)" class="button success">{{$t('reception')}}</a>
    </div>
  </div>
</template>

<script>

  export default {
    props: { 
      clubid : {},
      type : { default : 1 },
    },

    data() {
      return {
        request_count : 0,
        member_count : 0,
        archive_count : 0,
      }
    },

    created: function () {
        this.init();
    },

    ready : function () {

    },

    methods : {
        init: function () {
            this.$http.get(this.$env.get('APP_URI') + 'api/club/edit/' + this.clubid + '/members?type=' + this.memberType).then((response) => 
            {
                this.request_count = response.data.requests_count;
                this.member_count = response.data.members_count;
                this.archive_count = response.data.archive_count;
            }, (response) => {

            });        
        },

        setMembersType : function (type) {
            this.type = type;
            this.$dispatch('member-changed', {
                content : this.type,
            });
        }
    },

    components : {
    },

    locales: {
        en: { 
            teacher : 'Teachers',
            manager : 'Managers',
            reception : 'Receptions',
        },
        mn : {
            teacher : 'Багш',
            manager : 'Менежер',
            reception : 'Ресепшэн',
        },
    }
  }
</script>
  
<style lang="scss">
</style>