<script>
	import FileManager from '../context/FileManager.vue';
	
	export default {
		props: { 
			title : { default : 'test' },
			user : {}
		},

		data() {
			return {
				showFileManager : false
			}
		},
		
		created : function () {

		},

		events : {
			'chooseAvatar' : function($response) {
				this.chooseAvatar($response);
			}
		},

		methods : {
			uploadAvatar : function (event) {
				event.preventDefault()
				this.showFileManager = true; 
			},

			chooseAvatar : function($response) {
				var photo = $response.data;
				if(photo.length > 0) {
					this.$http.post(this.$env.get('APP_URI') + 'api/user/avatar/' + photo[0].id).then(res => {
						this.user.avatar_url = res.data.avatar;	
						this.showFileManager = false;
					}).catch(err => {
						this.showFileManager = false;
					});
				}
				
				
			}
		}, 

		components : {
			FileManager
		}	
	}
</script>