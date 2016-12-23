<template>
    <div class="row plan-container">
        <recently-modified-plan :id="id"></recently-modified-plan>
        <recommended-plan :id="id"></recommended-plan>
        <nearby-plan :id="id"></nearby-plan>
    </div>
</template>

<script>
    import RecentlyModifiedPlan from './RecentlyModifiedPlan.vue'
    import RecommendedPlan from './RecommendedPlan.vue'
    import NearbyPlan from './NearbyPlan.vue'

    export default {
        
        props: { 
            id : {},
        },

        data () {
            return {

            }
        },

        created : function () {
            
        },

        ready : function () {

        },

        methods : {
            
        },

        components : {
            RecentlyModifiedPlan, RecommendedPlan, NearbyPlan
        }
    }
</script>
<style lang="scss">
.plan-container {
    background-color: #f4f4f4;
}
</style>