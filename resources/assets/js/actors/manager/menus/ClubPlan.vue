<template>
	<div>
		<h3>Club Plan</h3>
		<a @click="showAddPlan = true" class="button success">
				<i class="fa fa-pencil-square-o"></i>
		</a>

		<p>
	      <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
	      <label for="filled-in-box">Filled in</label>
	    </p>
    
		<custom-modal 
			:id = "clubid"
			type = "Club"
			title = "Add Plan" 
			usage = "_add-plan" 
			:show.sync = "showAddPlan"
			save-callback = "savePlan"
			validateable = 'Y'
			context = "AddPlan"
			>
		</custom-modal>
	<div>
</template>

<script>
	export default {
		props: { 
			clubid : {},
		},

		data() {
			return {
				plans : null,
				showAddPlan : false,
			}
		},

		created : function () {
			this.getPlans();
		},

		methods : {
			getPlans : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.clubid + '/plan').then(res => {
				  this.plans = res.data.result;
				}).catch(err => {
				});
			},

			savePlan : function($response) {

				this.$http.post(this.$env.get('APP_URI') + 'api/club/' + this.clubid + '/training?data=' + $response.data).then(res => {
				}).catch(err => {

				});

				this.showAddPlan = false;
				this.$root.$refs.toast.showMessage('Successfully add new plan.');
			}
		},
	}
</script>
	
<style>
</style>