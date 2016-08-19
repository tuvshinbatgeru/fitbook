<template>
	<div class="row">
	    <input type="text" name="" placeholder="search ...">
	</div>
	<div class="row small-up-2 medium-up-3 large-up-4">
	  	<div class="column" v-for="teacher in teachers">
		  	<div>
		  		{{teacher.username}}
		  	</div>
		  	<div :style="{'background-image': 'url(' + teacher.avatar_url + ')'}"
		  		  style="height: 80px; width: 80px;">
		  	</div>

		  	<a v-if="teacher.selected" @click="toggle(teacher)" class="success button">
				<i class="fa fa-check"></i>
			</a>
			<a v-else @click="toggle(teacher)" class="warning button">
				<i class="fa fa-times"></i>
			</a>
	  	</div>
	</div>
</template>

<script>
	export default {
		props: {
			id : {},
			type: {},
			selected : {}
		},
		
		data() {
			return {
				teachers : [],
				filterBy : 'all',
			}			
		},

		created : function () {
			this.getTeachers();
		},

		ready : function () {
			
		},
	
		methods : {
			// This method should implement all context using as a save-callback 
			getData : function () {
				this.filterBy = "selected";
				return this.filteredTeachers;
			},

			getTeachers: function() {
				var maps = this.objectListToMap(this.selected);
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/teacher?selected=' + maps).then((response) => 
				{
					this.teachers = response.data;
				}, (response) => {

				});			   
			},

			filterByType : function (obj) {
				if(this.filterBy == "all") return true;

				if(this.filterBy == "selected") 
				{
					if(obj.selected)
						return true;
				}

				return false;
			},

			objectListToMap : function (list) {
				var map = [];
				for (var i = 0; i < list.length; i++) {
					map.push(list[i].id);
				}
				return map;
			},

			toggle : function (teacher) {
				teacher.selected = !teacher.selected;
			},
		},

		computed : {
			filteredTeachers : function () {
		        return this.teachers.filter(this.filterByType);
		    },
		}		
	}
</script>
<style>
</style>