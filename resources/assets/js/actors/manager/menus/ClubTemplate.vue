<template>
	<div>
		<h3>Club Template</h3>
		<a @click="setType(1)" class="button success">
			Header
		</a>
		<a @click="setType(2)" class="button success">
			Content
		</a>
		<a @click="setType(3)" class="button success">
			Footer
		</a>

		<ul>
			<li v-for="widget in filteredWidgets">
				{{widget.name}}	
			</li>
		</ul>
	<div>
</template>

<script>
	export default {
		props: { 
			clubid : {},
		},

		data() {
			return {
				type : 1,
				widgets : [],
			}
		},

		created: function () {
			this.getWidgets();
		},

		methods : {
			getWidgets : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.clubid + '/widgets').then(res => {
					debugger;
					this.widgets = res.data;
				}).catch(err => {

				});
			},

			setType : function(type) {
				this.type = type;
			},

			filterByType : function (obj) {
				return obj.section_id == this.type;
			},
		},

		computed: {
		  filteredWidgets () {
		    return this.widgets.filter(this.filterByType);; 
		  }
		}
	}
</script>
	
<style>
</style>