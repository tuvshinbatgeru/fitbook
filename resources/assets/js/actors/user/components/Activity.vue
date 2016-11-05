<template>
    <div id="activity_calendar" class="Activity__Calendar">
        <custom-callout :loading.sync="timeIsCome" :spinner-color="'#5fcf80'" type="callout__base">
            <div slot="content">
              <custom-calendar :user-id="id" :year.sync="selectedYear">
              </custom-calendar>    
            </div>
        </custom-callout>
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
                timeIsCome : true,
            }
        },

        created : function () {
            this.selectedYear = Vue.moment().year()
            this.selectedDate = Vue.moment().format('YYYY/MM/DD')
        },

        ready : function () {
            this.resetUserActivity()
        },

        events : {
            '_hexagonclicked' : function (activity) {
                this.selectedDate = activity.label
            },
        },

        methods : {
            resetUserActivity : function () {
                setTimeout(
                    () => this.tick(),
                    1000
                )   
            },

            tick : function () {
                this.timeIsCome = false
            }
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
        text-align: center;
        height: 230px;
        overflow-y: hidden;
        overflow-x: auto;
        position: relative;
    }
</style>