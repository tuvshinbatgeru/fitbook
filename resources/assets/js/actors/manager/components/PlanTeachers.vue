<template>
  <ul>
    <li class="row" v-for="teacher in teachers">
        <img :src="teacher.avatar_small | nullCheck" style="width:32px; height:32px; border-radius: 32px;" />
        <h4>{{teacher.first_name}} {{teacher.last_name}}</h4>
    </li>
  </ul>
</template>

<script>

  export default {
    props: { 
        id : {
            required : true
        },
    },

    data() {
      return {
          teachers : [],
      }
    },

    filters : {
        nullCheck : function (avatars) {
            return avatars.length == 0 ? this.$env.get('APP_URI') + '/images/test_person.jpg' : avatars[0].url;
        }
    },

    created: function () {
        this.getTeachers();
    },

    ready : function () {

    },

    methods : {
        getTeachers: function () {
            this.$http.get(this.$env.get('APP_URI') + 'api/plan/' + this.id + '/teachers').then((response) => 
            {
                this.teachers = response.data.result;
            }, (response) => {

            });        
        },
    }
  }
</script>
