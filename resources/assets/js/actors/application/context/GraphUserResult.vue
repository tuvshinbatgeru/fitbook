<template>
	<div class="Typeahead__content row">
		<div class="small-3 columns">
			<img :src="url" 
				 style="height:32px; width:32px; border-radius: 32px;" 
				 class="text-right" />	
		</div>
		<div class="small-9 columns">
			<div class="row text-center">
				<span class="Typeahead__badge">
					USER
				</span>
			</div>
			<div class="row text-left Typeahead__content">
				<span class="name" v-text="item.searchable.username"></span>
		    	<span class="screen-name" v-text="item.searchable.first_name"></span>	
	    	</div>
		</div>
	</div>
</template>
<script>
export default {
	props : {
		item : {
			required : true,
		},
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
	background-color: #99c93d;
	border-radius : 5px;
	padding: 5px;
	color: white;
	font-weight: bold;
}

</style>

<style>
.Typeahead__content {
	color: #3f4652;
}
</style>
