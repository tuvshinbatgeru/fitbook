<template>
	<div class="row small-up-2 medium-up-3 large-up-4 small-centered">
		<div class="column" v-for="current in plans" style="border: 1px solid #222222; margin-left: 5px; margin-right:5px; ">
			<div class="row">
				<img :src="current.plan[0].pinned_photos[0].url" />
			</div>
			<div class="row" style="background-color:#fff">
				<h4>{{current.plan[0].name}}</h4>
				<p>{{current.plan[0].description}}</p>
				<a href="/plan/1">more ...</a>
			</div>
			<div class="row small-up-4">
				<div class="columns">
					<p>{{current.plan[0].create_at}}</p>
				</div>
				<div class="columns">
					<p>5 comments</p>
				</div>
				<div class="columns">
					<p>112 notes</p>
				</div>
				<div class="columns">
					<p>Share</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props : {
			id : { 
				required: true,
			},
		},

		created: function () {
		    this.getPlans();
		},

		data : function () {
			return {
				plans : [],
			}
		},

		methods : {
			getPlans: function() {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan/widget?type=loyalty').then((response) => 
				{
					debugger;
					this.plans = response.data.result;
				}, (response) => {

				});			   
			},
		}
	}
</script>

<style>
	
</style>