<script>

	//global context
	import Notifications from '../../../context/notifications.vue';

	export default {
		props: { 
			user : { 
				required : true
			},
		},

		data () {
			return {
				showNotifications : false,
			}
		},
		
		components : {
            Notifications
        }
	}
</script>