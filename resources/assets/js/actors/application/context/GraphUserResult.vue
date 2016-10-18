<template>
	<div class="Typeahead__content row">
		<div class="small-3 columns">
			<img :src="avatar" 
				 style="height:32px; width:32px; border-radius: 32px;" 
				 class="text-right" />	
		</div>
		<div class="small-9 columns">
			<div class="row text-left">
				<span class="name" v-text="item.username"></span>
		    	<span class="screen-name" v-text="item.first_name"></span>	
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
		avatar : function () {
			return this.item.avatar_small.length == 0 ? this.$env.get('APP_URI') + 'images/test_person.jpg' : this.item.avatar_small[0].url;
		}
	}
}
</script>
<style>

.Typeahead__content span {
    display: block;
    color: #2c3e50;
}

</style>
