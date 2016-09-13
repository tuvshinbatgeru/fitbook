<template>
	<form method="POST" action="/subscriptions" style="padding:10px;">
		<div class="row">
	  		<label>{{$t("user")}}</label>
		    <multiselect 
		    	:options="users" 
		    	:selected="user" 
		    	:multiple="false"
		    	select-label='сонгох'
		    	selected-label='сонгосон'	
		    	deselect-label='устгах'
		    	label="username"
		    	key="id" 
		    	id="user"
		    	:loading="userLoading",
		    	@search-change="userSearch",
		    	@update="setUser",
		    	placeholder="хайх ...">
		    		<span slot="noResult">Илэрц алга ...</span>
		  	</multiselect>
	  	</div>
	  	<div class="row">
	  		<label>{{$t("user")}}</label>
		    <multiselect 
		    	:options="plans" 
		    	:selected="plan" 
		    	:multiple="false"
		    	select-label='сонгох'
		    	selected-label='сонгосон'	
		    	deselect-label='устгах'
		    	label="name"
		    	key="id" 
		    	id="plan"
		    	:loading="planLoading",
		    	@search-change="planSearch",
		    	@update="setPlan",
		    	placeholder="хайх ...">
		    		<span slot="noResult">Илэрц алга ...</span>
		  	</multiselect>
	  	</div>
	  	<div class="row">
			<div class="small-6 column">
				<label>Start
					<input type="text" id="start_date" v-model="startDate"/>
				</label>
			</div>
			<div class="small-6 column">
				<label>Finish
					<input type="text" id="finish_date" v-model="finishDate">
				</label>
			</div>
		</div>
	</form>
</template>
<script>

	export default {
		props: { 
			clubId : {},
			plan: {
				default : null,
			},
			user : {
				default : null,
			},
			startDate : {},
			finishDate : {},
		},

		data () {
			return {
				userLoading : false,
				planLoading : false,
				plans : [],
				users : [],
			}
		},
		
		created : function () {

		},

		ready : function () {
			$('#start_date').datetimepicker({
                    format: 'DD/MM/YYYY'
            });

			$('#finish_date').datetimepicker({
                    format: 'DD/MM/YYYY'
            });
		},

		methods : {
			getData : function () {
				/*this.$dispatch('startLoading');*/
				return {
					param : this.$tools.transformParameters({
						userId : this.user.id,
						planId : this.plan.id,
						clubId : this.clubId,
						startDate : this.startDate,
						finishDate : this.finishDate,
				    })
				}
			},

			validate : function () {
				if(!this.user) {
					this.$root.$refs.toast.showMessage("Please. Choose user");
					return false;
				}

				if(!this.plan) {
					this.$root.$refs.toast.showMessage("Please. Choose plan");
					return false;
				}

				return true;
			},

			userSearch : function (query) {
				if (query.length === 0) {
				    this.users = [];
				    this.user = null;
				    return;				
				}
				
				this.userLoading = true
				this.$http.get(this.$env.get('APP_URI') + 'api/users?query=' + query).then(res => {
					this.users = res.data.result;
					this.userLoading = false;
				}).catch(err => {
					this.userLoading = false;
				});
			},

			setUser : function (newUser) {
				this.user = newUser;
			},

			planSearch : function (query) {
				if (query.length === 0) {
				    this.plans = [];
				    this.plan = null;
				    return;				
				}
				
				this.planloading = true
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.clubId + '/plan/simple?q=' + query).then(res => {
					this.plans = res.data.result;
					this.planloading = false;
				}).catch(err => {
					this.planloading = false;
				});
			},

			setPlan : function (selecetedPlan) {
				this.plan = selecetedPlan;
			}
		},
	}
</script>