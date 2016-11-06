<script>
	import Pageable from '../actors/application/mixins/Pageable'
	import UserFollowing from '../actors/user/components/UserFollowing.vue'
	import Timeline from '../components/Timeline.vue'
	import Activity from '../actors/user/components/Activity.vue'
	import UserHome from '../actors/user/components/UserHome.vue'
	import FileManager from '../context/FileManager.vue';
	import CustomHexagon from '../actors/application/svg/CustomHexagon.vue';

	export default {
		mixins : [Pageable],
		props: { 
			submenu : { default : 'user-home'},
			user : {}
		},

		data () {
			return {
				showNotifications : false,
				showFollowing : false,
				following_count : 0,
				editCover : false, 
				showCoverPhoto : false,
				coverPhoto : {},
				duplicatePhoto : null,
			}
		},

		created : function () {
			this.getFollowingCount()
			this.getCoverPhoto()
		},
		
		ready : function () {
			$('ul.user-tab').tabs();
		},

		/*filters : {
			coverFilter : function(coverPhoto) {
				if(coverPhoto instanceof Object) {
					return coverPhoto.url
				}
				return this.coverPhoto
			}
		},*/

		events : {
			'chooseCover' : function ($response) {
				var photo = $response.data;

				if(photo.length > 0) {
					this.coverPhoto = photo[0]
					this.editCover = true
				}

				this.showCoverPhoto = false
			}
		},

		methods : {

			changeCover : function () {
				this.showCoverPhoto = true
			},

			cancelCoverChange : function () {
				this.editCover = false
				this.coverPhoto = this.duplicatePhoto
			},

			saveCoverChange : function () {
				var viewPort = this.$refs.covercropper.getViewPort()

				this.$http.post(this.$env.get('APP_URI') + 'api/user/cover?photoId=' + this.coverPhoto.id + 
					'&top='+ viewPort.top +'&left=' + viewPort.left).then(res => {
					this.coverPhoto = res.data.result
					this.coverPhoto.pivot = {
						'top' : viewPort.top,
						'left' : viewPort.left,
					}

					this.duplicatePhoto = this.coverPhoto

					this.editCover = false
				}).catch(err => {
					this.editCover = false
				});
			},

			getFollowingCount : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.user.id + '/following/count').then(res => {
				  	this.following_count = res.data.result
				}).catch(err => {

				});
			},

			getCoverPhoto : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.user.id + '/cover').then(res => {
				  	if(res.data.code == 0) {
				  		this.coverPhoto = res.data.result
				  		this.duplicatePhoto = res.data.result
				  		return
				  	}

				  	this.coverPhoto = this.$env.get('APP_URI') + 'images/site/default_cover.jpg'
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
            UserFollowing, Timeline, Activity, UserHome, FileManager, CustomHexagon
        }
	}
</script>