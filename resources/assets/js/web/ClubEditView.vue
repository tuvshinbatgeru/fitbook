<script>
	import ClubDashboard from '.././menus/manager/ClubDashboard.vue';
	import ClubMembers from '.././menus/manager/ClubMembers.vue';
	import ClubRequests from '.././menus/manager/ClubRequests.vue';
	import ClubTraining from '.././menus/manager/ClubTraining.vue';
	import ClubLoyalty from '.././menus/manager/ClubLoyalty.vue';
	import ClubTemplate from '.././menus/manager/ClubTemplate.vue';
	import autocomplete from '.././components/autocomplete.vue';

	export default {

		props: { 
			clubid : {},
			selectedMenu : { default : 'club-template'},
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
			ClubDashboard, ClubMembers, ClubRequests, 
			ClubTraining, ClubLoyalty, autocomplete, 
			ClubTemplate
		}
	}
</script>