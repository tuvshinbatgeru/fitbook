<script>
	import ClubDashboard from '.././actors/manager/menus/ClubDashboard.vue';
	import ClubMembers from '.././actors/manager/menus/ClubMembers.vue';
	import ClubTemplate from '.././actors/manager/menus/ClubTemplate.vue';
	import PlanPanel from '.././actors/manager/components/PlanPanel.vue';
	import TrainingPanel from '.././actors/manager/components/TrainingPanel.vue';
	import ServicePanel from '.././actors/manager/components/ServicePanel.vue';
	import AllMembers from '.././actors/manager/components/AllMembers.vue';

	//SUB MENU
	import HeaderPreview from '.././actors/manager/components/preview/HeaderPreview.vue';
	import ContentPreview from '.././actors/manager/components/preview/ContentPreview.vue';
	import FooterPreview from '.././actors/manager/components/preview/FooterPreview.vue';

	export default {

		props: { 
			clubid : {},
			selectedMenu : { default : 'club-registration'},
			content : { default : 'training-panel' },
		},

		data () {
			return {
				requests_count : { default : 0 },
				members_count : { default : 0 },
				subMenu : 1,
			}
		},

		created : function () {
			this.init()
		},

		ready : function () {
			
		},

		events: {
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

			getDefaultContent : function (menu) {
				switch (menu) {
					case "club-template" : 
						return "header-preview"
					default : 
						return ""
				}
			},

			setWithSubMenu : function (menu) {
				this.$root.$refs.loader.show = true
				this.selectedMenu = menu
				this.content = this.getDefaultContent(this.selectedMenu)
			},

			setMenu : function(menu) {
				this.$root.$refs.loader.show = true
				this.selectedMenu = menu;
				this.setSubMenu();
				this.content = this.selectedMenu;
			},
			
			setSubMenu : function() {
				switch(this.selectedMenu) {
					case 'teacher-panel':
						this.subMenu = 1;
						this.selectedMenu = 'all-members';
						break;
					case 'reception-panel':
						this.subMenu = 2;
						this.selectedMenu = 'all-members';
						break;
					case 'manager-panel':
						this.subMenu = 3;
						this.selectedMenu = 'all-members';
						break;
				}
			},
		},

		components : {
			ClubDashboard, ClubMembers, 
			ClubTemplate, PlanPanel, 
			TrainingPanel, ServicePanel, AllMembers,
			HeaderPreview, ContentPreview, FooterPreview
		},

		locales: {
	        en: { 
	            dashboard : 'Dashboard',
	            members : 'Members',
	            registration : 'Registration',
	            template : 'Template',
	            teacher : 'Teachers',
	            manager : 'Managers',
	            reception : 'Receptions',
	            plan : 'Plan',
	            training : 'Training',
	            service : 'Service',
	        },
	        mn : {
	            dashboard : 'Хяналт',
	            members : 'Гишүүнчлэл',
	            registration : 'Бүртгэл',
	            template : 'Загвар',
	            teacher : 'Багш',
	            manager : 'Менежер',
	            reception : 'Ресепшэн',
	            plan : 'Хөтөлбөр',
	            training : 'Хичээл',
	            service : 'Үйлчилгээ',
	        },
	    }
	}
</script>