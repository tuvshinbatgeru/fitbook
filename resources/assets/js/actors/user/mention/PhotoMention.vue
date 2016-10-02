<template>
	<h4>{{mention.mentioned.ext}}</h4>
	<img style="height:50px; width:50px;" :src="mention.mentioned.url"/>

	<a>Mark as read</a>

</template>

<script>
	export default {
		props: {
			mention : {
				required : true
			},
		},
		
		methods : {

		},
	}
</script>
<style>
</style>