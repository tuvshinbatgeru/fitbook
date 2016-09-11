<template>
	<form method="POST" action="/">
		<div class="row">
	  		<label>{{$t("genre")}}</label>
		    <multiselect 
		    	:options="users" 
		    	:selected="user" 
		    	:multiple="false"
		    	:clear-on-select="false" 
		    	:close-on-select="true" 
		    	select-label='сонгох'
		    	selected-label='сонгосон'	
		    	deselect-label='устгах'
		    	label="name"
		    	id="user"
		    	:loading="userLoading",
		    	@search-change="userSearch",
		    	@update="setUser",
		    	:limit-text="limitText"
		    	key="id" 
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
				this.$http.get(this.$env.get('APP_URI') + 'api/user?query=' + query).then(res => {
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