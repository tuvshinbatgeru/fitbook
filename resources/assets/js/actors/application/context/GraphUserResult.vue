<template>
	<div class="Typeahead__content">
		<h4>User</h4>
	    <img :src="item.avatar_url" style="height:32px; width:32px; border-radius: 32px;" />
	    <span class="name" v-text="item.username"></span>
	    <span class="screen-name" v-text="item.first_name"></span>
	</div>
</template>
<script>
export default {
	props : {
		item : {
			required : true,
		}
	},
}
</script>
<style>

.Typeahead__content span {
    display: block;
    color: #2c3e50;
}

</style>
