<template>
    <h3>Loyalty Plan</h3>

    <div class="row small-up-3 medium-up-4 large-up-4">
        <div class="columns" v-for="current in plans">
        <h3>{{current.plan[0].name}}</h3>
        <p>{{current.plan[0].description}}</p>

        <label>{{current.before_price}}</label>
        off to 
        <label>{{current.plan[0].price}}</label>
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

        data () {
            return {
                plans : [],
            }
        },

        ready : function () {

        },

        methods : {
            getLoyaltyPlans : function () {
                debugger;
                this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?type=loyalty').then(res => {
                    this.plans = res.data.result;
                }).catch(err => {

                });
            },
        },
    }
</script>
