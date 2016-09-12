<script>
	//application widgets load
	import HeaderDefault from '../actors/application/widgets/header/Default.vue';
	import TeacherDefault from '../actors/application/widgets/content/TeacherDefault.vue';
	import TrainingDefault from '../actors/application/widgets/content/TrainingDefault.vue';
	import PlanDefault from '../actors/application/widgets/content/PlanDefault.vue';

	export default {

		props: { 
			id : {},
		},

		created : function () {
			
		},

		ready : function () {
			
		},

		components : {
			PlanDefault, HeaderDefault, 
			TeacherDefault, TrainingDefault
		},
	}
</script>