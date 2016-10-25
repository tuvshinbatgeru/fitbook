<template>
    <div class="Activity__Calendar">
        <custom-calendar :user-id="id" :year="2016">
            
        </custom-calendar>
    </div>

    <div class="row" v-for="activity in activities">
        <h3>{{activity.short_name}}</h3>
        <label>{{activity.pivot.duration}} min</label>

       
    </div>
</template>

<script>
    import CustomCalendar from '../actors/application/svg/CustomCalendar.vue';

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
            CustomCalendar
        }
    }
</script>
<style lang="scss">
    .Activity__Calendar {
        width: 100%;
        overflow-y: hidden;
        overflow-x: auto;
    }
</style>