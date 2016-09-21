<template>
	<custom-modal
		:id = "id"
		type = "Club"
		title = "Trainings"
		usage = "_training-chooser"
		:selected = ""
		:items = "trainings"
		:show.sync = "showTraining"
		save-callback = "choosedTrainings"
		context = "trainings">
	</custom-modal>

	<form method="POST">
		<photo-slider v-ref:pslider></photo-slider>

		<div class="row">
			<div class="small-12 medium-9 column">
		  		<custom-button-group :data="bgroup" :value.sync="freq"></custom-button-group>
			</div>
			<div class="small-12 medium-3 column">
   	      		<label>Duration
		    		<input type="number" v-model="length">
		    	</label>
		  	</div>
		</div>

		<div class="row">
		    <multiselect 
		    	:options="clubservices" 
		    	:selected="services" 
		    	:multiple="true"
		    	:clear-on-select="false" 
		    	:close-on-select="false" 
		    	select-label='сонгох'
		    	selected-label='сонгосон'	
		    	deselect-label='устгах'
		    	:limit="1"
		    	@update="updateServices"
		    	label="name" 
		    	:limit-text="limitText"
		    	key="id" 
		    	placeholder="хайх ...">
		    		<span slot="noResult">Илэрц алга ...</span>
		    </multiselect>
		</div>

	    <ul class="tabs">
	        <li class="tab s3"><a class="active" href="#main">{{ $t("info") }}</a></li>
	        <li class="tab s3"><a href="#trainer">{{ $t("trainer") }}</a></li>
		</ul>

  	    <div id="main">
		  	<div class="row">
				<div class="small-12 medium-6 column">
					<label>PlanName
				        <input type="text" v-model="name" placeholder="fill training name">
				    </label>	
				</div>

				<div class="small-12 medium-6 column">
					<label>Description
				        <textarea type="text" v-model="description" placeholder="Description ...">
				        </textarea>
				    </label>
				</div>
			</div>
			<div class="row">
				<div class="small-12 medium-6 column">
					<p>
				      <input type="checkbox" v-model="trainerless" class="filled-in" id="trainerless"/>
				      <label for="trainerless">Trainerless</label>
				    </p>
				</div>
				<div class="small-12 medium-6 column">
					<label>Trainer Count
						<input type="number" :disabled="!trainerless" v-model="trainerCount">
					</label>
				</div>
  		  </div>

  		  <div class="row">
  		  	<div class="small-12 medium-6 column">
  		  		<a @click="isPrimary = true" class="button success">Primary</a>
  		  	</div>
  		  	<div class="small-12 medium-6 column">
  		  		<a @click="isPrimary = false" class="button success">Loyalty</a>
  		  	</div>
  		  </div>
  		  <div class="row">
			<div class="small-6 medium-6 column">
				<label>Start
					<input type="text" id="start_date" v-model="startDate"/>
				</label>
			</div>
			<div class="small-6 medium-6 column">
				<label v-show="isPrimary">Finish
					<input type="text" id="finish_date" v-model="finishDate">
				</label>

				<label v-show="!isPrimary">
					Until now
				</label>
			</div>
		  </div>
		  <div class="row">
			<div class="small-6 medium-6 column">
				<label>Price
					<input type="number" v-model="price">
				</label>
			</div>
			<div v-show="!isPrimary" class="small-6 medium-6 column">
				<label>Discount
					<input type="number" v-model="discount">
				</label>
			</div>
		  </div>
		</div>

		<div id="trainer">
		    <div class="row small-up-3 medium-up-4">
		    	<div class="columns" v-for="train in trainings">
		    		{{train.name}}
		    	</div>
		    	<div class="columns">
		    		<a @click="showTraining = true" class="button success">
		    			<span class="fa fa-plus"></span>
		    		</a>
		    	</div>
			</div>
			<div class="row small-up-3 medium-up-4 large-up-5">
				<teacher-slider v-ref:tslider :id="id" :teachers.sync="teachers"></teacher-slider>
				<div>
					<a @click="showTeacher = true" class="fa fa-save">+</a>
				</div>
			</div>
		</div>

		<div class="row" style="height:50px"></div>
		<div class="row"></div>
	</form>
</template>
<script>

	import PhotoSlider from '../actors/application/components/PhotoSlider.vue';
	import TeacherSlider from '../actors/application/components/TeacherSlider.vue';

	export default {
		props: { 
			id : {},
			type: {},
			selected : {}
		},

		data() {
			return {
				name : '',
				description : '',
				trainerless : false,
				trainerCount : 0,
				freq : 3,
				length : 1,
				isPrimary : true,
				price : 0,
				discount : 0,
				teachers : [],
				trainings : [],
				services : [],
				clubservices : [],
				showTraining : false,
				showTeacher : false,
				isLoading : false,
				startDate : null,
				finishDate : null,
				bgroup : [],
			}
		},
		
		created : function () {
			this.getClubServices();
			this.bgroup = [{
					name : 'Daily',
					value : 1,
				}, {
					name : 'Weakly',
					value : 2,
				}, {
					name : 'Monthly',
					value : 3,
				}, {
					name : 'Yearly',
					value : 4,
				}
			];
		},

		ready : function () {
			$('ul.tabs').tabs();
			$('#start_date').datetimepicker({
                    format: 'DD/MM/YYYY'
            });

			$('#finish_date').datetimepicker({
                    format: 'DD/MM/YYYY'
            });
		},

		events : {
			'choosedTrainings' : function($response) {
				this.choosedTrainings($response);
			},
		},

		methods : {
			getClubServices : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/service').then(res => {
				 	this.clubservices = res.data.result;
				}).catch(err => {

				});
			},

			getData : function() {
				this.$dispatch('startLoading');

				return {
					teachers : this.teachers,
					trainings : this.trainings,
					services : this.services,
					pinned_photo : this.$refs.pslider.pinnedPhoto,
					param : this.$tools.transformParameters({
						club_id : this.id,
						name : this.name,
						description : this.description,
						freq : this.freq,
						length : this.length,
						startDate : this.startDate,
						finishDate : this.finishDate,
						trainerless : this.trainerless,
						trainerCount : this.trainerCount,
						isPrimary : this.isPrimary,
						price : this.price,
						discount : this.discount,
						teachers : this.$tools.arrayBy(this.teachers,'id'),
						trainings : this.$tools.arrayBy(this.trainings,'id'),
						services : this.$tools.arrayBy(this.services,'id'),
						pictures : this.$tools.collectionBy(this.$refs.pslider.pictures, "id|url|pinned"),
				    })
				}
			},

			limitText : function(count) {
				return "ба " + count + " бусад"; 
			},

			choosedTrainings : function($response) {
				this.trainings = $response.data;

				for(var i = 0; i < this.trainings.length; i++)
				{
					for(var j = 0; j < this.trainings[i].teachers.length; j++)
					{
						if(!this.containsTeachers(this.trainings[i].teachers[j]))
							this.teachers.push(this.trainings[i].teachers[j]);
					}
				}

				debugger;
				this.showTraining = false;
			},
			
			deleteTeacher : function(teacher) {
				this.teachers.$remove(teacher);
			},

			updateServices : function (services) {
				this.services = services;
			},

			validate : function () {
				if(!this.name.trim()) {
					this.$root.$refs.toast.showMessage("Please. Fill the name of training");
					return false;
				}

				if(!this.description.trim()) {
					this.$root.$refs.toast.showMessage("Please. Fill the description of training");
					return false;
				}

				return true;
			},

			containsTeachers : function(data) {
				var found = false;
				for(var i = 0; i < this.teachers.length; i++) {
				    if (this.teachers[i].id == data.id) {
				        found = true;
				        break;
				    }
				}
				return found;
			}
		},

		components : {
			PhotoSlider, TeacherSlider
		},

		locales: {
	        en: { 
	        	info : 'Info',
	    		photos : 'Add photos',
	    		trainer : 'Add training',
	    		name : 'Training name',
	    		description : 'Description',
	    		name_watermark : 'name ...',
	    		description_watermark : 'description ...',
	    	},
	    	mn : {
	    		info : 'Инфо',
	    		photos : 'Зураг оруулах',
	    		trainer : 'Хичээл сонгох',
	    		name : 'Хичээлийн нэр',
	    		description : 'Тайлбар',
	    		name_watermark : 'нэр ...',
	    		description_watermark : 'тайлбар ...',
	    	},
	    }
	}
</script>
<style lang="scss">
</style>