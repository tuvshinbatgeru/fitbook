<script>
	import ClubDashboard from '.././actors/manager/menus/ClubDashboard.vue';
	import ClubMembers from '.././actors/manager/menus/ClubMembers.vue';
	import ClubRegistration from '.././actors/manager/menus/ClubRegistration.vue';
	import ClubTemplate from '.././actors/manager/menus/ClubTemplate.vue';
	import PlanPanel from '.././actors/manager/components/PlanPanel.vue';
	import TrainingPanel from '.././actors/manager/components/TrainingPanel.vue';
	import ServicePanel from '.././actors/manager/components/ServicePanel.vue';
	import AllMembers from '.././actors/manager/components/AllMembers.vue';

	export default {

		props: { 
			clubid : {},
			selectedMenu : { default : 'club-registration'},
			content : {default : 'training-panel'},
		},

		data () {
			return {
				requests_count : { default : 0 },
				members_count : { default : 0 },
				subMenu : 1,
			}
		},

		created : function () {
			this.init();
		},

		ready : function () {
			
		},

		events: {
			'member-changed' : function ($request) {
				this.subMenu = $request.content;
				this.$broadcast('_MemberTypeChanged', this.subMenu);
			},

			'content-changed' : function($request) {
				this.content = $request.content;
			},

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

				switch(this.selectedMenu) {
					case 'club-registration':
						this.content = 'training-panel';
						break;
					case 'club-members':
						this.content = 'all-members';
						break;
					case 'club-dashboard':
						this.content = 'training-panel';
						break;
					default : 
						this.content = 'all-members';
				}
			},
		},

		components : {
			ClubDashboard, ClubMembers, 
			ClubRegistration, ClubTemplate, PlanPanel, 
			TrainingPanel, ServicePanel, AllMembers
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