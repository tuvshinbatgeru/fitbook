<script>
	import AddSubscriptions from '../context/AddSubscriptions.vue'; 

	export default {

		props: { 
			
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
			setSubscription : function (type) {
				this.showSubscription = type;
			}, 

			saveSubscription : function($response) {
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