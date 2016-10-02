<template>
	<div class="notification row text-center" style="padding: 10px; font-size: 12px;">
		<a :href="'/' + notification.data.club_id + '/edit'">
			{{notification.data.club_short_name}} - Teacher Request
		</a>
		<br>

		<img v-lazy="notification.data.image_url" style="height:32px; width:32px;" />
		<a :href="'/users/' + notification.data.username">
			{{notification.data.user_first_name}} {{notification.data.user_last_name}}
		</a>
		
		<p>{{notification.data.description}}</p>
		<p>{{notification.data.recieved_at.date | moment "from" }}</p>

		<a>Mark as read</a>
	</div>
	<hr>
</template>

<script>
	export default {
		props: {
			notification : {
				required : true
			},
		},
		
		methods : {
			goToResult : function () {

			}
		},
	}
</script>
<style lang="scss">

</style>