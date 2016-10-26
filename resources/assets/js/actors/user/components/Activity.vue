<template>
    <div class="Activity__Calendar">
        <custom-calendar :user-id="id" :year.sync="selectedYear">
            
        </custom-calendar>
    </div>

    <activity-detail :user-id="id" :date.sync="selectedDate">
        
    </activity-detail>

    <div class="row" v-for="activity in activities">
        <h3>{{activity.short_name}}</h3>
        <label>{{activity.pivot.duration}} min</label>

       
    </div>
</template>

<script>

    import CustomCalendar from '../../application/svg/CustomCalendar.vue'
    import ActivityDetail from './ActivityDetail.vue';

    export default {
        
        props: { 
            id : {},
        },

        data () {
            return {
                selectedDate : null,
                selectedYear : 0,
            }
        },

        created : function () {
            this.selectedYear = Vue.moment().year()
            this.selectedDate = Vue.moment().format('YYYY/MM/DD')
        },

        ready : function () {

        },

        events : {
            '_hexagonclicked' : function (activity) {
                this.selectedDate = activity.label
            },
        },

        methods : {
            
        },

        components : {
            CustomCalendar, 
            ActivityDetail
        }
    }
</script>
<style lang="scss">
    .Activity__Calendar {
        width: 100%;
        overflow-y: hidden;
        overflow-x: auto;
        position: relative;
    }
</style>