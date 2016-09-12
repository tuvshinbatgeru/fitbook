<template>
	<form method="POST" action="/">
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
	</form>
</template>
<script>

	export default {
		props: { 
			clubId : {},
			planId: {},
			userId : {}
		},

		data () {
			return {
				userLoading : false,
				user : null,
				users : [],
			}
		},
		
		created : function () {
		},

		ready : function () {
			
		},

		methods : {
			userSearch : function (query) {
				if (query.length === 0) {
				    this.users = []
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
				this.user = newUser
			}
		},
	}
</script>