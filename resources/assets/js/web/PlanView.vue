<script>
	import AddSubscriptions from '../context/AddSubscriptions.vue'; 

	export default {

		props: { 
			plan : {}
		},

		ready : function () {
			this.plan = JSON.parse(this.plan);
		},

		data () {
			return {
				showSubscription : false,
				showComments : false,
			}
		},

		events : {
		    'saveSubscription' : function($response) {
		        this.saveSubscription($response);
		    },
		},

		methods : {

			toggleHearth : function () {
				this.$http.post(this.$env.get('APP_URI') + 'plan/' + this.plan.id + '/reaction?action_type=HeartAction').then(res => {
					this.plan.hearth_count += res.data.type? 1 : -1;
				}).catch(err => {

				});
			},

			setSubscription : function (type) {
				this.showSubscription = type;
			}, 

			saveSubscription : function($response) {
				debugger;
				this.$http.post(this.$env.get('APP_URI') + 'subscriptions?data=' + $response.data.param).then(res => {
					this.showSubscription = false;  	
				}).catch(err => {
				  	
				});
			},
		},

		created : function () {

		},

		ready : function () {
			
		},

		components : {
			AddSubscriptions
		},
	}
</script>