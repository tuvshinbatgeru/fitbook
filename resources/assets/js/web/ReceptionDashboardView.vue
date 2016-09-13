<script>
	export default {

		props: { 
			clubId : {},
		},

		data () {
			return {
				onlineUsers : [], 
				userLoading : false,
				userCalloutLoading : false,
				userCalloutBlank : true,
				users : [],
				user: null,
				plans : [],
			}
		},

		created : function () {
			this.init();
		},

		ready : function () {
			
		},

		methods : {
			init : function () {
				this.getOnlineUsers();
			},

			getOnlineUsers: function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.clubId + '/online').then(res => {
					this.onlineUsers = res.data.result;
					debugger;
				}).catch(err => {
				});
			},

			userSearch : function (query) {
				if (query.length === 0) {
				    this.users = [];
				    this.user = null;
				    this.userCalloutBlank = true;
				    return;				
				}
				
				this.userLoading = true;
				this.$http.get(this.$env.get('APP_URI') + 'api/users?query=' + query).then(res => {
					this.users = res.data.result;
					this.userLoading = false;
				}).catch(err => {
					this.userLoading = false;
				});
			},

			setUser : function (newUser) {
				this.user = newUser;
				this.userCalloutBlank = false;
				this.userCalloutLoading = true;
				this.getUserPlans();
			},

			getOutUser : function (user) {
				this.$http.post(this.$env.get('APP_URI') + 'api/user/' + user.id + '/outuser?subscriptionId=' 
					+ user.pivot.subscription_id + '&clubId=' + this.clubId
					+ '&startTime=' + user.pivot.start_time).then(res => {
					this.onlineUsers.pop(user);
					this.$root.$refs.toast.showMessage(res.data.message);
				}).catch(err => {
					this.$root.$refs.toast.showMessage(err.data.message);
				});
			},

			getInUser : function (subscriptionId) {
				this.$http.post(this.$env.get('APP_URI') + 'api/user/' + this.user.id + '/inuser?subscriptionId=' 
					+ subscriptionId + '&clubId=' + this.clubId).then(res => {

					debugger;

					res.data.result.pivot = new Object;
					res.data.result.pivot.start_time = res.data.start_time.date;
					res.data.result.pivot.subscription_id = subscriptionId;

					this.onlineUsers.push(res.data.result);

					this.users = [];
				    this.user = null;
				    this.userCalloutBlank = true;

					this.$root.$refs.toast.showMessage(res.data.message);
				}).catch(err => {
					this.$root.$refs.toast.showMessage(err.data.message);
				});
			},

			getUserPlans : function () {

				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.user.id + 
					'/subscriptions?clubId=' + this.clubId + '&active'
				).then(res => {
				  	this.plans = res.data.result;
				  	this.userCalloutLoading = false;
				}).catch(err => {
					this.userCalloutLoading = false;
				});
				
			}
		},

		components : {

		},
	}
</script>