<script>
	import ClubDashboard from '.././actors/manager/menus/ClubDashboard.vue';
	import ClubMembers from '.././actors/manager/menus/ClubMembers.vue';
	import ClubRegistration from '.././actors/manager/menus/ClubRegistration.vue';
	import ClubTemplate from '.././actors/manager/menus/ClubTemplate.vue';

	export default {

		props: { 
			clubid : {},
			selectedMenu : { default : 'club-registration'},
		},

		data () {
			return {
				requests_count : { default : 0 },
				members_count : { default : 0 },
			}
		},

		created : function () {
			this.init();
		},

		ready : function () {
			
		},

		events: {
			'accept-request' : function($request) {
				this.requests_count --;
				this.members_count ++;
			},

			'reject-request' : function($request) {
				this.requests_count --;
			}
		},

		methods : {
			init: function() {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/edit/' + this.clubid + '/index').then((response) => 
				{
					this.members_count = response.data.members_count;
					this.requests_count = response.data.requests_count;
				}, (response) => {

				});	
			},

			setMenu : function(menu) {
				this.selectedMenu = menu;
			},
		},

		components : {
			ClubDashboard, ClubMembers, 
			ClubRegistration, ClubTemplate
		},

		locales: {
	        en: { 
	            dashboard : 'Dashboard',
	            members : 'Members',
	            registration : 'Registration',
	            template : 'Template',
	        },
	        mn : {
	            dashboard : 'Хяналт',
	            members : 'Гишүүнчлэл',
	            registration : 'Бүртгэл',
	            template : 'Загвар',
	        },
	    }
	}
</script>