<template>
    <svg version="1.1" width="750" height="120" style="position: relative;">
        <custom-hexagon
        	v-for="activity in hexagons"
        	:bg-color="calcColor(activity.duration)" 
        	:length.sync="length" 
        	:cord-x="activity.x" 
        	:cord-y="activity.y"
        	:item="activity"
        	@hovered="onHexagonHover"
        	@mouseout="onHexagonMouseOut"
        	@clicked="onHexagonClick">
        </custom-hexagon>
        
        <div v-if="showHexagonTooltip" class="Hexagon__tooltip" 
        	:style="'top:' + (hoveredActivity.y - 28) + 'px; left:' + (hoveredActivity.x - 40) + 'px'">
        		{{hexagonTooltipContent}}
        </div>
        
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
				length : 8,
				showHexagonTooltip : false ,
				hexagonTooltipContent : '',
				hoveredActivity : null,
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
				this.hoveredActivity = activity

				this.hexagonTooltipContent = activity.label + '-ны өдөр '

				if(activity.duration > 0)
					this.hexagonTooltipContent += activity.duration + ' минут хичээллэсэн.'
				else 
					this.hexagonTooltipContent += 'хичээллээгүй байна.'

				this.showHexagonTooltip = true
			},

			onHexagonMouseOut : function () {
				this.showHexagonTooltip = false
			},

			onHexagonClick : function (activity) {
				debugger
				this.$dispatch('_hexagonclicked', activity)
			},
			
			draw : function () {
				this.calcDays(this.year)
				this.calcWeeks(this.year)
				this.calcData()
			},

			calcDays : function (year) {
				this.days = Vue.moment((year + 1) + '-01-01').diff(Vue.moment(year + '-01-01'), 'days')
			},

			calcWeeks : function (year) {
				this.weekCount = Vue.moment(year + '-01-01').weeksInYear()
			},

			calcColor : function (duration) {
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
				var items = []

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

					items.push({
						'x' : column * this.length * 1.7, 
						'y' : row * this.length * 2 + (column % 2 == 0 ? this.length : 0),
						'label' : date,
						'duration' : activity ? activity.duration : 0,
					})

					row ++
				}

				this.hexagons = items
			},
		},

		components : {
			CustomHexagon
		}

	}
</script>
<style lang="scss">
	.Hexagon__tooltip {
		padding: 3px 8px; 
		white-space: nowrap;
		background-color: #3f4652; 
		color: #fff;
		border-radius: 3px;
		font-size: 11px;
		position: absolute;
		&:after {
			content: '';
			width: 0; 
			height: 0; 
			border-left: 5px solid transparent;
			border-right: 5px solid transparent;
		  	border-top: 5px solid #3f4652;
			position: absolute;
			top: 100%;
			left: 104px;
		}
	}
</style>