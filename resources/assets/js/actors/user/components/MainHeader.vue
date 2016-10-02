<script>

	//global context
	import Notifications from '../../../context/notifications.vue';
	import LogoutMenus from './LogoutMenus.vue';

	export default {
		props: { 
			user : { 
				required : true
			},
		},

		data () {
			return {
				showNotifications : false,
				showLogoutMenus : false,
			}
		},

		created : function () {

		},
		
		components : {
            Notifications, LogoutMenus
        }
	}
</script>