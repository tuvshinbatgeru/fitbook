<template>
	
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
					this.trainings = response.data.result;
				}, (response) => {

				});			   
			},
		}
	}
</script>

<style>
	
</style>