<template>
    <svg version="1.1" width="750" height="120">
        <custom-hexagon
        	v-for="activity in hexagons"
        	:bg-color="calcColor(activity.duration)" 
        	:length.sync="length" 
        	:cord-x="activity.x" 
        	:cord-y="activity.y"
        	:item="activity"
        	@hovered="onHexagonHover">
        </custom-hexagon>
    </svg>
</template>

<script>
	import CustomHexagon from './CustomHexagon.vue';

	export default {
		props : {
			year : {	
				
			},

			data : {

			},

			userId : {
				required : true,
			}
		},

		data () {
			return {
				days : 365,
				weekCount : 52,
				hexagons : [],
				activities : [],
				length : 8
			}
		},

		created : function () {
			this.getActivities()
		},

		methods : {
			getActivities : function () {

				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.userId + '/activity?year=' + this.year).then(res => {
				  	this.activities = res.data.result
				  	this.draw()
				}).catch(err => {

				});
			},

			onHexagonHover : function (activity) {
				alert(activity.label + '-ны өдөр ' + activity.duration + ' минут хичээллэсэн.')
			},

			onHexagonClick : function (activity) {

			},
			
			draw : function () {
				this.calcDays(this.year);
				this.calcWeeks(this.year);
				this.calcData();
			},


			calcDays : function (year) {
				this.days = Vue.moment((year + 1) + '-01-01').diff(Vue.moment(year + '-01-01'), 'days')
			},

			calcWeeks : function (year) {
				this.weekCount = Vue.moment(year + '-01-01').weeksInYear()
			},

			calcColor : function (duration) {
				debugger
				if (duration == 0) return "#eeeeee"
				if (duration > 0 && duration < 60) return "#d6e685"
				if (duration > 60 && duration < 120) return "#8cc665"
				if (duration > 120 && duration < 180) return "#44a340"
				return "#1e6823"
			},

			calcData : function () {
				this.hexagons = []

				var start = Vue.moment(this.year + '-01-01')
				var row = start.day() == 0 ? 6 : start.day() - 1;
				var column = 0

				for(var i = 0; i < this.days; i ++)
				{
					if(row == 7) {
						column ++
						row = 0
					}

					var date = Vue.moment(this.year + '-01-01').add(i, 'days').format('YYYY/MM/DD');

					var activity = _.find(this.activities, function (current) {
						return Vue.moment(current.start_time).format("YYYY/MM/DD") == date
					})

					this.hexagons.push({
						'x' : column * this.length * 1.7, 
						'y' : row * this.length * 2 + (column % 2 == 0 ? this.length : 0),
						'label' : date,
						'duration' : activity ? activity.duration : 0,
					})

					row ++
				}
			},
		},

		components : {
			CustomHexagon
		}

	}
</script>