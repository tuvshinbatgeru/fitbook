<template>
    <recently-modified-plan :id="id"></recently-modified-plan>
    <recommended-plan :id="id"></recommended-plan>
    <nearby-plan :id="id"></nearby-plan>
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
