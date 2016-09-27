<template>
    <div class="row small-up-1 large-up-2">
        <div class="columns" v-for="current in plans">
        <h3>{{current.plan[0].name}}</h3>
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
</template>

<script>
    export default {
        
        props: { 
            id : {},
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
            }
        },

        methods : {
            loyaltyAdded : function(loyalty) {
                this.plans.push(loyalty);
            },

            getLoyaltyPlans : function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?type=loyalty').then(res => {
                    this.plans = res.data.result;
                }).catch(err => {

                });
            },
        },
    }
</script>
