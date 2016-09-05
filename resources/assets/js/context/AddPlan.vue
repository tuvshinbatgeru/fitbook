<template>
	<custom-modal
		:id = "id"
		type = "Club"
		title = "Trainings"
		usage = "_training-chooser"
		:items = "trainings"
		:show.sync = "showTraining"
		save-callback = "choosedTrainings"
		context = "trainings">
	</custom-modal>

	<form method="POST">
		<photo-slider></photo-slider>

		<div class="row">
		  <fieldset class="large-6 columns">
		    <legend>Plan schedule</legend>
		    <input type="radio" name="schedule" value="Daily" id="schDaily" required><label for="schDaily">Daily</label>
		    <input type="radio" name="schedule" value="Weakly" id="schWeakly"><label for="schWeakly">Weakly</label>
		    <input type="radio" name="schedule" value="Monthly" id="schMonthly"><label for="schMonthly">Monthly</label>
		    <input type="radio" name="schedule" value="Yearly" id="schYearly"><label for="schYearly">Yearly</label>
		  </fieldset>
		  <fieldset class="large-6 columns">
		    <legend>Duration</legend>
		    <input type="number" name="length" value="1">
		  </fieldset>
		</div>
		<div class="row">
			<div class="small-4 medium-4 column">
				<p>
			      <label for="test5">Trainerless</label>
			      <input type="checkbox" id="trainerless" name="trainerless"/>
			    </p>
			</div>
			<div class="small-4 medium-4 column">
				<label>Start
					<input type="date" class="datepicker">
				</label>
			</div>
			<div class="small-4 medium-4 column">
				<label>Finish
					<input type="date" class="datepicker">
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
				        <input type="text" name="name" v-model="name" placeholder="fill training name">
				    </label>	
				</div>

				<div class="small-12 medium-6 column">
					<label>Description
				        <textarea type="text" name="description" v-model="description" placeholder="Description ...">
				        </textarea>
				    </label>
				</div>
			</div>
			<div class="row">
				<div class="small-12 medium-6 column">
					<label>Price
				        <input type="number" name="price" v-model="name" placeholder="Plan price ...">
				    </label>	
				</div>

				<div class="small-12 medium-6 column">
					<label>Description
				        <textarea type="text" name="description" v-model="description" placeholder="Description ...">
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
						<input type="number" :disabled="!trainerless" name="trainercount">
					</label>
				</div>
  		  </div>
		</div>

		<div id="trainer">
		    <div class="row">
		    	<div class="small-12 column" style="height:100px">
		    		<a @click="showTraining = true" class="button success">
		    			<span class="fa fa-plus"></span>
		    		</a>
		    	</div>
			</div>
		</div>
	</form>
</template>
<script>

	import PhotoSlider from '../actors/application/components/PhotoSlider.vue';

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
				price : 0,
				teachers : [],
				services : [],
				clubservices : [],
				showTraining : false,
				isLoading : false,
			}
		},
		
		created : function () {
			this.getClubServices();
		},

		ready : function () {
			$('ul.tabs').tabs();

			/*$('.datepicker').pickadate({
			    firstDay: 1,
			    selectMonths: true, // Creates a dropdown to control month
			    selectYears: 1
			});*/
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
				 	debugger;
				}).catch(err => {

				});
			},

			getData : function() {
				return this.$tools.transformParameters({
					club_id : this.id,
					name : this.name,
					description : this.description,
					pictures : this.$tools.collectionBy(this.pictures, "id|url"),
					teachers : this.$tools.collectionBy(this.teachers, "id"),
			    });
			},

			limitText : function(count) {
				return "ба " + count + " бусад"; 
			},

			choosedTrainings : function($response) {
				this.teachers = $response.data;
				this.showTeachers = false;
			},
			
			triggerPictureBtn : function () {
				this.showFileManager = true;
			},

			deleteTeacher : function(teacher) {
				this.teachers.$remove(teacher);
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
		},

		components : {
			PhotoSlider
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