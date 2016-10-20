<template>
	<div class="Typeahead__content row">
		<div class="small-3 columns">
			<img :src="url" 
				 style="height:32px; width:32px; " 
				 class="text-right" />	
		</div>
		<div class="small-9 columns">
			<div class="row text-center">
				<span class="Typeahead__badge">
					PLAN
				</span>
			</div>
			<div class="row text-left Typeahead__content">
				<span class="name" v-text="item.searchable.name"></span>
		    	<span class="screen-name">{{{item.searchable.description}}}</span>	
	    	</div>
		</div>
	</div>
</template>
<script>
export default {
	props : {
		item : {
			required : true,
		}
	},

	computed : {
		url : function () {
			return this.item.searchable.graph.length == 0 ? this.$env.get('APP_URI') + 'images/test_person.jpg' : this.item.searchable.graph[0].url;
		}
	}
}
</script>
<style scoped>

.Typeahead__badge {
	background-color: #ff5c2d;
	padding: 5px;
	border-radius : 5px;
	color: white;
	font-weight: bold;
}

</style>
