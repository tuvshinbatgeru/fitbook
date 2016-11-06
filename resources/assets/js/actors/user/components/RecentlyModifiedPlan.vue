<template>
    <div class="large-12 columns">
        <div class="row plan-section">
            <div class="plan-section-title">
                RECENTLY ADDED PLANS
            </div>
            <div class="result-length">
                (About 120 results)
            </div>
        </div>

        <horizontal-slide :slide-width="258" :step="1" :items="items">
            
        </horizontal-slide>
    </div>
    <!-- <h3>Recently Added plans</h3> -->

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
            
        },

        ready : function () {
            this.items.push({
                'label' : 'slide1'
            }, {
                'label' : 'slide2'
            }, {
                'label' : 'slide3'
            }, {
                'label' : 'slide4'
            }, {
                'label' : 'slide5'
            }, {
                'label' : 'slide6'
            }, {
                'label' : 'slide7'
            }, {
                'label' : 'slide8'
            })
        },

        methods : {
            
        },
    }
</script>
