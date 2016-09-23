<template>
	<div class="row">
	    <input type="text" name="" placeholder="search ...">
	</div>
	<div class="row small-up-1 medium-up-1 large-up-1" style="border-radius: 4px;">
	  	<div class="column" v-for="train in trainings">
		  	<div style="padding-left: 44px;">
			  	<h4>{{train.name}}</h4>
			  	<span>{{train.description}}</span>

			  	<img class="ft-train-img" v-bind:src="train.avatar_url"/>

			  	<a v-if="train.selected" @click="toggle(train)" class="success button">
					<i class="fa fa-check"></i>
				</a>
				<a v-else @click="toggle(train)" class="warning button">
					<i class="fa fa-times"></i>
				</a>

				<div class="row tr-teacher-box" v-for="photo in train.photos">
					<div class="small-2 training column">
						<img v-bind:src="photo.url"/>
					</div>
					<div class="small-10 training-text column">
						Jeffrey Way
					</div>
				</div>


				<ul>
					<li v-for="teacher in train.teachers">
						#{{teacher.username}}
					</li>
				</ul>

				<div class="row small-up-3 medium-4 large-up-5">
					<div class="column" v-for="photo in train.photos">
						<img style="height:100%; width:100%;" v-bind:src="photo.url" />
						<label>{{photo.url}}</label>
					</div>
				</div>
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
				trainings : [],
				filterBy : 'all',
			}			
		},

		created : function () {
			this.getTrainings();
		},

		ready : function () {
			
		},
	
		methods : {
			// This method should implement all context using as a save-callback 
			getData : function () {
				this.filterBy = "selected";
				return this.filteredTrainings;
			},

			getTrainings: function() {
				var ids = this.$tools.arrayBy(this.selected, 'id');
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/training?data=' + this.$tools.transformParameters({
					selected : ids,
			    })).then((response) => 
				{
					this.trainings = response.data.result;
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

			toggle : function (train) {
				train.selected = !train.selected;
			},
		},

		computed : {
			filteredTrainings : function () {
		        return this.trainings.filter(this.filterByType);
		    },
		}		
	}
</script>
<style>

.tr-teacher-box {
	overflow: hidden;
    padding: 10px 0;
    color: #aecaec;
}

.training-text {
	padding-left: 10px;
    padding-top: 5px;
}

.training img {
    height: 40px;
    width: 40px;
    border-radius: 150px;
    -webkit-border-radius: 150px;
    -moz-border-radius: 150px;
}
</style>