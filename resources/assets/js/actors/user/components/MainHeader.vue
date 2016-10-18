<script>

	//global context
	import Notifications from '../../../context/notifications.vue';
	import LogoutMenus from './LogoutMenus.vue';
	import Typeahead from '../../../actors/application/components/Typeahead.vue';

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
				searchType : 'user',	
				graphResult : [],
				graphLoading : false,
			}
		},

		created : function () {

		},

		ready : function () {
			$('ul.tabs').tabs();
		},

		methods : {
			setType : function (type) {
				this.searchType = type;
				this.graphSearch();
			},

			graphSearch : function (query) {
				this.graphLoading = true;

				switch(this.searchType) {
					case "plan" : 
						this.planSearch(query);
						return;
					case "club" : 
						this.clubSearch(query);
						return;
					case "user" : 
						this.userSearch(query);
						return;
					default : 
						break;
				}
			},

			userSearch : function (query) {
				this.$http.get(this.$env.get('APP_URI') + 'test/search?q=' + query).then(res => {
			    	  	this.graphResult = res.data.result;
			    	  	this.graphLoading = false;
			    }).catch(err => {
			    	  	this.graphLoading = false;
			    });
			},

			planSearch : function (query) {

			},

			clubSearch : function (query) {

			},
		},
		
		components : {
            Notifications, LogoutMenus, Typeahead
        }
	}
</script>
<style lang="scss">

.twitter-typeahead {
	display: block !important;
	position: none !important;
}

.tt-open {
	width:100%;
}

.Graph__link .tt-cursor {
	.Graph__row {
		color : #3adb76 !important;	
	}
}

.Graph__row {
	font-size: 12px;
	background-color: #3f4652; 
	color: #FFF;

	&:hover {
        color: #3adb76;
    }
}


.Graph__suggestion {
	padding : 5px;
	border-radius: 4px;
}

</style>