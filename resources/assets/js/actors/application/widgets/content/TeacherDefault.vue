<template>
	<div class="row small-up-2 medium-up-3 large-up-4 small-centered">
		<div class="column" v-for="teacher in teachers" style="background-color:#aecaec">
			<img height="100" width="100" v-bind:src="teacher.avatar_url"/>
			<div>
				<h4>
					{{teacher.username}}
				</h4>
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
		    this.getTeachers();
		},

		data : function () {
			return {
				teachers : [],
			}
		},

		methods : {
			getTeachers: function() {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/teacher').then((response) => 
				{
					this.teachers = response.data;
				}, (response) => {

				});			   
			},
		}
	}
</script>

<style>
	
</style>