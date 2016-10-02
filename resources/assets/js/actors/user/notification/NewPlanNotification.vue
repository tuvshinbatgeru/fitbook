<template>
	<div class="notification">
		<h4>{{notification.data.name}}</h4>
		<label>{{notification.data.club_short_name}}</label>
		<p>{{notification.data.description}}</p>
		<p>{{notification.data.release_date.date | moment "from" }}</p>

		<a>Mark as read</a>
	</div>
</template>

<script>
	export default {
		props: {
			notification : {
				required : true
			},
		},
		
		methods : {

		},
	}
</script>
<style>
</style>