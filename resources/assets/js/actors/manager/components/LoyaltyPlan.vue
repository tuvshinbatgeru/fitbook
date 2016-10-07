<template>
    <div class="row small-up-1 large-up-2" style="font-size:12px;">
        <div class="columns" v-for="current in plans">

        <div class="row text-right">
            <a @click="editPlan(current)">Edit</a>
            <a @click="deletePlan(current)">Delete</a>
            <a @click="showHistory()" ></a>
        </div>

        <h3><a>{{current.name}}</a></h3>
        <span style="background-color:#3f4652; color:#fff; padding:5px; border-radius:5px;">{{current.frequency_type | freqFilter}}</span>
        <span style="background-color:#3f4652; color:#fff; padding:5px; border-radius:5px;">{{current.length}}</span>

        <div class="row text-center">
            {{current.created_at | moment "from"}}
            <span class="fa fa-heart" style="color: red;"></span>
            <strong>{{current.hearts_actions_count}}</strong>

            <span class="fa fa-comments-o" style="color: #3f4652;"></span>
            <strong>{{current.comments_count}}</strong>
        </div>
        
        <p>{{{current.description}}}</p>

        <div style="width:300px; height:100px; overflow: hidden;">
            <img v-lazy="current.pinned_photos[0].url"
                 style="width: 100%;
    position: relative;
    max-height: none;" 
                 :style = "{ 
                        top: -1 * parseInt((current.pinned_photos[0].pivot.top_percentage * 300 * current.pinned_photos[0].ratio) / 100) + 'px'
                 }" />    
        </div>

        <label>{{current.planable.before_price}}</label>
        off to 
        <label>{{current.price}}</label>

        <ul v-for="teacher in current.teachers">
            {{teacher.username}}
        </ul>
        <ul v-for="service in current.services">
            {{service.name}}
        </ul>
        </div>
    </div>
    <div class="row text-center" v-show="pageIndex < pageLast">
        <a class="button" @click="loadMore()">{{ $t("load") }}</a>
    </div>
</template>

<script>
    export default {
        
        props: { 
            id : {},
            orderBy : {
                required : true
            },
        },

        created : function () {
            this.getLoyaltyPlans();
        },

        ready : function () {
            this.$on('_planadded', this.loyaltyAdded);
        },

        data () {
            return {
                plans : [],
                pageIndex : 1,
                pageLast : 0,
            }
        },

        filters : {
            freqFilter : function (freq) {
                switch(freq) {
                    case 1 :
                        return "dayly";
                        break;
                    case 2 :
                        return "weakly";
                        break;
                    case 3 :
                        return "monthly";
                        break;
                    default : 
                        return "dayly";
                        break;
                }
                
            }
        },

        methods : {
            editPlan : function (plan) {
                this.$dispatch('editPlan', plan);
            },

            deletePlan : function(plan) {
                this.plans.$remove(plan);
            },

            loyaltyAdded : function(loyalty) {
                this.plans.push(loyalty);
            },

            loadMore : function () {
                this.pageIndex ++;
                this.getLoyaltyPlans();
            },

            getLoyaltyPlans : function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?type=loyalty&' + this.orderBy + '&page=' + this.pageIndex).then(res => {
                    this.plans = this.plans.concat(res.data.result.data);
                    this.pageLast = res.data.result.last_page;
                }).catch(err => {

                });
            },
        },

        watch: {
            orderBy : function (val, oldVal) {
                this.plans = [];
                this.pageIndex = 1;
                this.getLoyaltyPlans();
            },
        },

        locales: {
            en: { 
                load : 'Load More ...',
            },
            mn : {
                load : 'Цааш нь ...',
            },
        }
    }
</script>
