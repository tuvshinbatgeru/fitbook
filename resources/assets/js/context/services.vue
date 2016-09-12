<template>
	<div class="row">
	    <input type="text" name="search" placeholder="search ...">
	</div>

	<div class="row" v-for="service in services">
		<div class="small-2 columns">
			<input type="checkbox" v-model="service.selected"/>
		</div>
		<div class="small-10 columns">
			{{service.name}}
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			id : {},
			type: {},
			selected : {}
		},
		
		data() {
			return {
				services : [],
				filterBy : 'all',
			}			
		},

		created : function () {
			this.getServices();
		},

		ready : function () {
			
		},
	
		methods : {
			// This method should implement all context using as a save-callback 
			getData : function() {
				return this.$tools.transformParameters({
					choosed : this.$tools.arrayBy(this.filteredServices, "id"),
			    });
			},

			getServices: function() {
				this.$http.get(this.$env.get('APP_URI') + 'api/service?data=' + 
					this.$tools.transformParameters({
						selected : this.$tools.collectionBy(this.selected, "id")
					})
				).then((response) => 
				{
					this.services = response.data.result;
				}, (response) => {

				});			   
			},

			filterByType : function (obj) {
				return obj.selected;
			},
		},

		computed : {
			filteredServices : function () {
		        return this.services.filter(this.filterByType);
		    },
		}		
	}
</script>
<style>

</style>