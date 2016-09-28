<template>
    <div class="row small-up-1 large-up-2" style="font-size:12px;">
        <div class="columns" v-for="current in plans">
        <h3>{{current.plan[0].name}}</h3>
        {{current.plan[0].created_at | moment "from"}}
        <div class="heart is-active"></div> 
        <strong>{{current.plan[0].hearts_actions_count}}</strong>
        <p>{{{current.plan[0].description}}}</p>

        <div style="width:300px; height:100px; overflow: hidden;">
            <img v-lazy="current.plan[0].pinned_photos[0].url"
                 style="width: 100%;
    position: relative;
    max-height: none;" 
                 :style = "{ 
                        top: -1 * parseInt((current.plan[0].pinned_photos[0].pivot.top_percentage * 300 * current.plan[0].pinned_photos[0].ratio) / 100) + 'px'
                 }" />    
        </div>

        <label>{{current.before_price}}</label>
        off to 
        <label>{{current.plan[0].price}}</label>

        <ul v-for="teacher in current.plan[0].teachers">
            {{teacher.username}}
        </ul>
        <ul v-for="service in current.plan[0].services">
            {{service.name}}
        </ul>
        <ul v-for="train in current.plan[0].trainings">
            {{train.name}}
        </ul>
        </div>
    </div>
    <div class="row text-center" v-show="pageIndex < pageLast">
        <a class="button" @click="loadMore()">Load More ...</a>
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

        methods : {
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
        }
    }
</script>
