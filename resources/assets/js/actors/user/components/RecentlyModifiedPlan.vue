<template>
    <div class="large-12 columns">
        <div class="row plan-section">
            <div class="plan-section-title">
                {{$t('activity.recently')}}
            </div>
            <div class="result-length">
                (About 120 results)
            </div>
        </div>

        <horizontal-slide :slide-width="258" :step="1" :items="items">
                
        </horizontal-slide>
    </div>
</template>

<script>
    export default {
        
        props: { 
            id : {},
        },

        data () {
            return {
                items : []
            }
        },

        created : function () {
            this.getRecentlyAddedPlans()
        },

        methods : {
            getRecentlyAddedPlans : function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/plan/recently').then(res => {
                    this.items = res.data.result.data
                    this.setContext()
                }).catch(err => {
                  
                });
            },

            setContext : function () {
                _.forEach(this.items, function (obj) {
                    if(obj.planable_type == 'App\\PrimaryPlan') {
                        obj.context = 'primary-plan-context'
                    } 

                    if(obj.planable_type == 'App\\LoyaltyPlan') {
                        obj.context = 'loyalty-plan-context'
                    }
                })
            }
        },
    }
</script>
