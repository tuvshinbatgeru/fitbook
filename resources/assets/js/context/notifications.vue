<template>
	<ul class="tabs">
	    <li class="tab s3">
	    	<a @click="getNotifications()" class="active" href="#notifications">
	    		All
	    	</a>
	    </li>
	    <li class="tab s3">
	    	<a @click="getMentions()" href="#mentions">Mentions</a>
	    </li>
	</ul>

	<div id="notifications">
		<ul v-show="notifications.length != 0">
			<components :notification="notification" 
						:is="notificationComponentFilter(notification)" 
						v-for="notification in notifications">
			</components>
		</ul>
		<h3 v-show="notifications.length == 0">There is no notification received !</h3>
	</div>
	
	<div id="mentions">
		<h3>Mentions</h3>
	</div>
</template>

<script>

	import NewPlanNotification from '../actors/user/notification/NewPlanNotification.vue';
	
	export default {
		props: {
			userId : {},
		},
		
		data() {
			return {
				notifications : [],
				mentions : [],
			}			
		},

		created : function () {
			this.getNotifications();
		},

		ready : function () {
			$('ul.tabs').tabs();
		},
	
		methods : {
			notificationComponentFilter : function (notification) {
				switch (notification.type) {
					case "App\\Notifications\\NewPlan" : 
						return "new-plan-notification";
					break;
				}
			},

			getNotifications : function () {
				debugger;
				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.userId + '/notifications').then(res => {
				  	debugger;
				  	if(res.data.code == 0) {
				  		this.notifications = res.data.result;
				  	}
				}).catch(err => {
				  
				});
			},

			getMentions : function () {
			},

			markAsRead : function (item) {

			}
		},

		components : {
			NewPlanNotification,
		}
	}
</script>
<style>
</style>