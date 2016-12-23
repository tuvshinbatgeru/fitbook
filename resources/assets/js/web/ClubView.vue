<script>
	//application widgets load
	import HeaderDefault from '../actors/application/widgets/header/Default.vue';
	import TeacherDefault from '../actors/application/widgets/content/TeacherDefault.vue';
	import TrainingDefault from '../actors/application/widgets/content/TrainingDefault.vue';
	import MemberDefault from '../actors/application/widgets/content/MemberDefault.vue';
	import PlanDefault from '../actors/application/widgets/content/PlanDefault.vue';

	export default {

		props: { 
			id : {
				required : true
			},
			menu : {
				required : true
			},
			isManager : {
				required : true
			}
		},

		data () {
			return {
				content : {}
			}
		},

		created : function () {
			this.setContent()
		},

		methods : {
			menuChanged: function (menu) {
				this.menu = menu
				this.setContent()
			},

			setContent: function () {
				switch(this.menu) {
					case "home" : 
						this.content = 'home-default'
						break
					case "plan" :
						this.content = 'plan-default'
						break	
					case "member" :
						this.content = 'member-default'
						break
					default : 
						this.content = 'home-default'
				} 
			}
		},

		components : {
			PlanDefault, HeaderDefault, 
			TeacherDefault, TrainingDefault, MemberDefault
		},
	}
</script>