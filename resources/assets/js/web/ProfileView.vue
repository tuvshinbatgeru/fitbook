<script>
	import UserFollowing from '../actors/user/components/UserFollowing.vue';
	import Timeline from '../components/Timeline.vue';
	import Activity from '../actors/user/components/Activity.vue';
	import UserHome from '../actors/user/components/UserHome.vue';

	export default {
		props: { 
			title : { default : 'test' },
			submenu : { default : 'user-home'},
			user : {}
		},

		data () {
			return {
				showNotifications : false,
				showFollowing : false,
				following_count : 3,
			}
		},

		created : function () {
			this.getFollowingCount()
		},
		
		ready : function () {
			$('ul.tabs').tabs();
		},

		methods : {
			getFollowingCount : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.user.id + '/following/count').then(res => {
				  	this.following_count = res.data.result
				}).catch(err => {

				});
			},

			setSubMenu : function(menu) {
				this.submenu = menu;
			},

			test : function () {
				alert('test');
			},

			toggleFollow : function (follow) {
				this.following_count += follow == "follow" ? -1 : +1
			}
		},

		components : {
            UserFollowing, Timeline, Activity, UserHome
        }
	}
</script>