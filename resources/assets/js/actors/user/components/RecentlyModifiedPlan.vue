<template>
    <div class="row">
        <div class="large-12 columns" style="background-color: #fff;">
            <div class="row plan-section">
                <div class="plan-section-title">
                    RECENTLY ADDED
                </div>
            </div>

            <horizontal-slide :slide-width="247" :step="1" :items="items">
                
            </horizontal-slide>

            <div class="row" style="position: relative;padding: 10px 30px;">
                <div style="width: 25%;display: inline-block;">
                    
                </div>
            </div>
        </div>
        <div class="large-12 columns" style="height: 500px; background-color: #202b30;">

        </div>
        <div class="large-12 columns" style="height: 500px; background-color: #f2f2f2;">
        </div>
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
