<template>
	<div class="row">
		<ul>
			<li v-for="adjustment in adjustments">
				<div class="row">
					<img style="height:32px; width:32px;" :src="adjustment.avatar_url"/>
					<p>{{adjustment.first_name}} {{adjustment.last_name}}</p>
					<label>{{adjustment.pivot.created_at | moment "from"}}</label>
					<component :before="adjustment.pivot.before" 
							   :after="adjustment.pivot.after"
							   :is="type">						
					</component>
				</div>
			</li>
		</ul>
	</div>
</template>

<script>
	import TrainingAdjustment from '../adjustments/TrainingAdjustment.vue';
	import PlanAdjustment from '../adjustments/PlanAdjustment.vue';

	export default {
		props : {
			id : {},
			type : {
				type : String,
				required : true,
				default : '',
			}
		},

		data() {
			return {
				adjustments : [],
			}
		},

		created : function () {
			this.getAdjustments();
		},

		methods : {
			getAdjustments : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/training/' + this.id + '/adjustments').then(res => {
					debugger;
				  this.adjustments = res.data.result;
				}).catch(err => {
				});
			}
		},

		components : {
			TrainingAdjustment, PlanAdjustment
		}
	}
</script>

<style>
</style>