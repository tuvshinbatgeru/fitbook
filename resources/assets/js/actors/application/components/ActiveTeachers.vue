<template>
	<ul class="active-people">
		<li v-for="teacher in teachers">
			<a>
				<img :src="teacher.avatar_url" width="25"  height="25" />
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
				teachers : [],
			}
		},

		created : function () {
			this.getActiveTeachers()
		},

		methods : {
			getActiveTeachers: function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.clubId + '/active/teachers').then(res => {
				  this.teachers = res.data.result
				}).catch(err => {
				});
			}
		}
	}
</script>