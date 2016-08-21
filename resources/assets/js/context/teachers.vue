<template>
	<div class="row">
	    <input type="text" name="" placeholder="search ...">
	</div>
	<div class="row small-up-3 medium-up-4 large-up-5" style="background-color:#2d3339; border-radius: 4px;">
	  	<div class="column ft-teacher-column" style="position: relative;" v-for="teacher in teachers">
		  	<div style="padding-left: 44px;">
			  	<h4>{{teacher.username}}</h4>
			  	<span>Tuvshinbat Gansukh</span>

			  	<img class="ft-teacher-img" v-bind:src="teacher.avatar_url"/>

			  	<a v-if="teacher.selected" @click="toggle(teacher)" class="success button">
					<i class="fa fa-check"></i>
				</a>
				<a v-else @click="toggle(teacher)" class="warning button">
					<i class="fa fa-times"></i>
				</a>
			</div>
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

.ft-teacher-img {
	transition: box-shadow 200ms ease-in-out;
    position: absolute;
    top: 50%;
    left: 0;
    width: 32px;
    height: 32px;
    border-radius: 32px;
    display: block;
    margin-top: -16px;
}

.ft-teacher-column {
	color: #fff;
}	

</style>