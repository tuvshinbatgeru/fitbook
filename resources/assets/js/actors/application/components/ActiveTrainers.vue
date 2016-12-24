<template>
	<ul class="active-people">
		<li v-for="trainer in trainers">
			<a>
				<img :src="trainer.avatar_url" width="25"  height="25" />
			</a>
		</li>
	</ul>
</template>
<script>
	export default {
		props : {
			clubId : {
				required : true
			},
		},

		data () {
			return {
				trainers : [],
			}
		},

		created : function () {
			this.getActiveTrainers()
		},

		methods : {
			getActiveTrainers: function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.clubId + '/active/trainers').then(res => {
				  this.trainers = res.data.result
				}).catch(err => {
				});
			}
		}
	}
</script>