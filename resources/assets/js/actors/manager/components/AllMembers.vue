<template>
    <div class="widget-content float-center">
        <h3>Teachers</h3>
      <div class="content--container float-center">
        <div>
            <ul class="tabs">
              <li class="tab s3"><a @click="setSubMenu('request-members')" class="active">{{$t('request')}} ({{request_count}})</a></li>
              <li class="tab s3"><a @click="setSubMenu('current-members')">{{$t('current')}} ({{member_count}})</a></li>
              <li class="tab s3"><a @click="setSubMenu('archive-members')">{{$t('archive')}} ({{archive_count}})</a></li>
            </ul>
        </div>  

        <div class="small-12 text-center small-centered columns">
            <component :id="id" 
                       :type.sync="memberType" 
                       :is="submenu">
            </component>
        </div>
      </div>
    </div>
</template>

<script>

  import ArchiveMembers from '../components/ArchiveMembers.vue';
  import CurrentMembers from '../components/CurrentMembers.vue';
  import RequestMembers from '../components/RequestMembers.vue';

  export default {
    props: { 
      id : {},
      type : {},
      memberType : { default: 1 },
    },

    data() {
      return {
          request_count : 0,
          member_count : 0,
          archive_count : 0,
          submenu : 'request-members',
      }
    },

    created: function () {
        this.init();
    },

    ready : function () {
        $('ul.tabs').tabs();
        this.$on('_MemberTypeChanged', (memberType) => {
            this.memberType = memberType;
        });
    },

    events: {
      'accept-request' : function($request) {
        this.decreaseRequests();
        this.member_count ++;
      },

      'reject-request' : function($request) {
        this.decreaseRequests();
      }
    },

    methods : {
        init: function () {
            debugger;
            this.$http.get(this.$env.get('APP_URI') + 'api/club/edit/' + this.clubid + '/members?type=' + this.memberType).then((response) => 
            {
                this.request_count = response.data.requests_count;
                this.member_count = response.data.members_count;
                this.archive_count = response.data.archive_count;
            }, (response) => {

            });        
        },

        getMenuToType : function () {
           switch(this.submenu) {
              case "request-members" : 
                return 0;
              case "current-members" : 
                return 1;
           }
        },

        setMembersType : function (type) {
            this.memberType = type;
            //this.init();
        },

        setSubMenu : function (menu) {
            this.submenu = menu;
        },

        decreaseRequests : function() {
            this.request_count --;
        },
    },

    components : {
        ArchiveMembers,
        CurrentMembers,
        RequestMembers
    },

    locales: {
        en: { 
            teacher : 'Teachers',
            manager : 'Managers',
            reception : 'Receptions',
            request : 'Requests',
            current : 'Active Members',
            archive : 'Archive',
        },
        mn : {
            teacher : 'Багш',
            manager : 'Менежер',
            reception : 'Ресепшэн',
            request : 'Хүсэлтүүд',
            current : 'Идэвхтэй гишүүд',
            archive : 'Архив',
        },
    }
  }
</script>
