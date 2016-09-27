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
		<ul v-show="mentions.length != 0">
			<components :mention="mention"
						:is="mentionComponentFilter(mention)"
						v-for="mention in mentions">
			</components>
		</ul>
		<h3 v-show="mentions.length == 0">There is no mention</h3>
	</div>
</template>

<script>

	import NewPlanNotification from '../actors/user/notification/NewPlanNotification.vue';
	import TeacherRequestRecievedNotification from '../actors/user/notification/TeacherRequestRecievedNotification.vue';

	import PhotoMention from '../actors/user/mention/PhotoMention.vue';
	import CommentMention from '../actors/user/mention/CommentMention.vue';
	
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
			mentionComponentFilter : function (mention) {
				switch (mention.mention_type) {
					case "App\\Photo" : 
						return "photo-mention";
					case "App\\Comment" :
						return "comment-mention";
					break;
				}
			},

			notificationComponentFilter : function (notification) {
				switch (notification.type) {
					case "App\\Notifications\\NewPlan" : 
						return "new-plan-notification";
					case "App\\Notifications\\TeacherRequestRecieved" :
					 	return "teacher-request-recieved-notification";
					break;
				}
			},

			getNotifications : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.userId + '/notifications').then(res => {
				  	debugger;
				  	if(res.data.code == 0) {
				  		this.notifications = res.data.result;
				  	}
				}).catch(err => {
				  
				});
			},

			getMentions : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.userId + '/mentions').then(res => {
				  	debugger;
				  	if(res.data.code == 0) {
				  		this.mentions = res.data.result;
				  	}
				}).catch(err => {
				  
				});
			},
		},

		components : {
			NewPlanNotification, TeacherRequestRecievedNotification,
			PhotoMention, CommentMention
		}
	}
</script>
<style lang="scss">
	$notification-hover-color: #aecaec;
	
	.notification {
		&:hover {
			background-color: $notification-hover-color;
			cursor: pointer;
		}
	}
</style>