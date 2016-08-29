<template>
    <div class="row" v-for="club in clubs">
        <div class="small-4 columns">
            <!-- <img class="float-right" src="/images/users/teacher_example.jpg" style="height:30px; width: 30px;" /> -->
        </div>
        <div class="small-4 columns">
            <p class="float-left">{{club.full_name}}</p>
        </div>
        <div class="small-4 columns">
            <a v-bind:class="club.state"  
               class="button-follow float-right"
               @click="toggleState(club)">{{$t(club.state)}}</a>
        </div>
    </div>
</template>

<script>
    export default {
        
        props: { 
            id : {},
        },

        created : function () {
            this.getFollowedClubs();
        },

        ready : function () {

        },

        data() {
            return {
                clubs : [],
            }
        },

        methods : {
            getFollowedClubs : function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/user/' +  this.id + '/followed').then(res => {
                    this.clubs = res.data.data; 
                    /*debugger;

                    for(var i = 0; i < this.clubs.length; i ++) {
                        this.clubs[i]["state"] = "following";
                    }*/

                }).catch(err => {
                });
            },

            toggleState : function (club) {

                this.$http.post(this.$env.get('APP_URI') + 'api/club/' + club.id + '/follow').then(res => {
                  club.state = res.data.type;
                }).catch(err => {
                  club.state = "following";
                });
            }
        },

        locales: {
            en: { 
                follow : 'Follow',
                unfollow : 'Following',
            },
            mn : {
                follow : 'Дагах',
                unfollow : 'Дагсан',
            },
        }
    }
</script>
<style lang="scss">
    .button-follow {
        line-height: 24px;
        padding: 0 9px;
        font-size: 16px;
        border-radius: 4px;
        border-style: solid;
        border-width: 1px solid ;
        font-weight: 600;
        outline: none;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 50%;
        -webkit-appearance: none;
    }

    .button-follow.unfollow {
            background-color: #5fcf80;
            color: #fff;
    }

    .button-follow.follow {
            background-color: #fff;
            color: #222222;
    }
</style>