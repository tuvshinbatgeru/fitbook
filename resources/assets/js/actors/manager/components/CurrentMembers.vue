<template>
    <div class="row">
        <div class="small-10 columns">
             <input type="text" name="search" placeholder="search ...">
        </div>
        <div class="small-2 columns">
            <a class="button success">
                <i class="fa fa-pencil-square-o">
                         
                </i>
            </a>
        </div>
    </div>

    <form>
        <ul class="row">
            <li class="small-12" v-for="member in members | orderBy 'pivot.view_order'">
                <div class="row">
                    <div class="small-1 columns">
                        {{member.pivot.view_order}} 
                        <a @click="upperOrder(member)" v-show="member.pivot.view_order != 1">up</a>
                        <a @click="downOrder(member)" v-show="member.pivot.view_order != maxViewOrder">down</a>  
                    </div>
                    <div class="small-9 columns">
                        <img v-bind:src="member.avatar_url" height="40" width="40" />
                        {{member.first_name}}
                        {{member.last_name}}    
                    </div>
                    <div class="small-2 columns">
                        <a @click="rejectRequest(member)" class="button alert">X</a>   
                    </div>
                </div>
            </li>
        </ul>
    </form>
</template>

<script>
    export default {
        
        props: { 
            id : {},
            type : {},
        },

        created: function () {
            this.getMembers();
        },

        data : function () {
            return {
                members : [],
                maxViewOrder : 0,
            }
        },

        ready : function () {
            this.$on('_MemberTypeChanged', (memberType) => {
                this.type = memberType;
                this.getMembers();
            });
        },

        methods : {
            getMembers: function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/members/' + this.type).then((response) => 
                {
                    this.members = response.data;
                    this.maxViewOrder = 10;
                }, (response) => {

                });            
            },

            upperOrder : function (member) {
                var upper = this.findByViewOrder(member.pivot.view_order - 1);

                member.pivot.view_order --;
                if(upper) upper.pivot.view_order ++;

                
            },

            downOrder : function (member) {
                var down = this.findByViewOrder(member.pivot.view_order + 1);
                member.pivot.view_order ++;
                if(down) down.pivot.view_order --;
            },

            findByViewOrder : function (view_order) {
                for (var index in this.members) {
                    if(this.members[index].pivot.view_order == view_order) return this.members[index];
                }

                return null;
            },
        }
    }
</script>
