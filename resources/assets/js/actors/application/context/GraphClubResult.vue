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
					CLUB
				</span>
			</div>
			<div class="row text-left Typeahead__content">
				<span class="name" v-text="item.searchable.short_name"></span>
		    	<span class="screen-name" v-text="item.searchable.full_name"></span>	
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
			return this.$env.get('APP_URI') + 'images/1470464066.png';
		}
	}
}
</script>
<style scoped>

.Typeahead__badge {
	padding: 5px;
	border-radius : 5px;
	background-color: #1bb1b2;
	color: white;
	font-weight: bold;
}
</style>
