<template>
    <div class="row content--search">
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
                    <div class="small-1 columns member--order">
                        <a class="member--order-up" @click="upperOrder(member)" v-show="member.pivot.view_order != 1"><i class="fa fa-caret-up"></i></a>
                        <span class="member--order-count">{{member.pivot.view_order}}</span>
                        <a class="member--order-down" @click="downOrder(member)" v-show="member.pivot.view_order != maxViewOrder"><i class="fa fa-caret-down"></i></a>  
                    </div>
                    <div class="small-9 columns member--list">
                        <img v-bind:src="member.avatar_url" height="40" width="40" />
                        <span>{{member.first_name}}</span>
                        {{member.last_name}}
                    </div>
                    <div class="small-2 columns ">
                        <a @click="rejectRequest(member)" class="button alert member--button"><i class="fa fa-trash-o"></i></a>   
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
            this.init();
        },

        data : function () {
            return {
                members : [],
                maxViewOrder : 0,
            }
        },

        ready : function () {
            this.$watch('type', function () {
                debugger;
                this.init();
            })
        },

        methods : {
            init : function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/members/' + this.type).then((response) => 
                {
                    this.members = response.data.result;
                    this.maxViewOrder = response.data.max_id;
                }, (response) => {

                });
            },

            upperOrder : function (member) {
                var upper = this.findByViewOrder(member.pivot.view_order - 1);

                member.pivot.view_order --;
                if(upper) upper.pivot.view_order ++;

                this.toggleOrder('upper', member, upper);
            },

            downOrder : function (member) {
                var down = this.findByViewOrder(member.pivot.view_order + 1);
                member.pivot.view_order ++;
                if(down) down.pivot.view_order --;
                this.toggleOrder('down', member, down);
            },

            toggleOrder : function (type, first, second) {
                this.$http.post(this.$env.get('APP_URI') + 
                    'api/club/' + 
                    this.id + 
                    '/teacher/' + 
                    first.id + '/' + 
                    second.id + '?type=' + type).then(res => {
                        
                }).catch(err => {
                    
                });
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
<style lang="scss">
.content--search {
    background-color: #aecaec;
}
</style>