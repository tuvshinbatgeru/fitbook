<template>
	<div class="row">
		Activity - {{date}}

		<div v-show="activities.length == 0">
			{{$t('noEntry')}}
		</div>

		<div v-else v-for="activity in activities">
			<h4>{{activity.club.short_name}} {{activity.plan.name}}</h4>
			<span>{{activity.pivot.start_time | moment 'hh:mm'}}</span>
			<span>{{activity.pivot.finish_time | moment 'hh:mm'}}</span>
			<span>{{activity.pivot.duration}}</span>
			<hr>
		</div>
		
	</div>
</template>
<script>
	export default {
		props : {
			userId : {
				required : true
			},
			date : {
				required : true
			}
		},

		data () {
			return {
				activities : [],
			}
		},

		created : function () {
			this.getActivity()
		},

		methods : {
			getActivity : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.userId + '/activity/detail?date=' + 
					Vue.moment(this.date).format('YYYY-MM-DD')
					+ "&until=" + Vue.moment(this.date).add(1, 'days').format('YYYY-MM-DD')).then(res => {
				  	this.activities = res.data.result
				}).catch(err => {

				});
			}
		},

		watch : {
			date : function (oldValue, newValue) {
				this.getActivity()
			}
		},

		locales : {
			en : {
				noEntry : "You have no entry in this day.",
			}, 
			mn : {
				noEntry : "Та энэ өдөр хичээллээгүй байна.",
			}	
		}
	}
</script>
<style>
</style>