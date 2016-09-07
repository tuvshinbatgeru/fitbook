<template>
    <h3>Primary Plan</h3>

    <div class="row">
        Percentage of lolloloasdsadfsdfl
    </div>
</template>

<script>
    export default {
        
        props: { 
            id : {},
        },

        created : function () {
            this.getPrimaryPlan();
        },

        data() {
            return {
                plans : [],
            }           
        },

        ready : function () {

        },

        methods : {
            getPrimaryPlan : function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?type=primary').then(res => {
                    this.plans = res.data.result;
                }).catch(err => {

                });
            },
        },
    }
</script>
