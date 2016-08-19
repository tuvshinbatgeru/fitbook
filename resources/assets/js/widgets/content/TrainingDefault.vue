<template>
	<div class="row small-up-2 medium-up-3 large-up-4 small-centered">
		<div class="column" v-for="item in trainings" style="background-color:#222222; color:#fff;">
			<div>
				<h4>
					{{item.name}}
				</h4>
				{{item.description}}
			</div>

			<div class="row small-up-2 medium-up-3 large-up-4 small-centered">
				<div class="column" v-for="teacher in item.teachers">
					{{teacher.username}}
					<img height="100" width="100" v-bind:src="teacher.avatar_url"/>
				</div>
			</div>

			<div class="row small-up-2 medium-up-3 large-up-4 small-centered">
				<div class="column" v-for="photo in item.photos">
					<img height="400" width="400" v-bind:src="photo.url"/>
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
		    this.getTrainings();
		},

		data : function () {
			return {
				trainings : [],
			}
		},

		methods : {
			getTrainings: function() {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/training').then((response) => 
				{
					debugger;
					this.trainings = response.data.result;
				}, (response) => {

				});			   
			},
		}
	}
</script>

<style>
	
</style>