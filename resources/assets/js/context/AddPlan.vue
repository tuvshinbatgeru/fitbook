<template>
	<custom-modal 
		:id = "id" 
		type = "User"
		title ="Photo chooser" 
		usage = "_photo-chooser" 
		multiple = "true"
		:items = "pictures"
		:show.sync = "showFileManager"
		save-callback = "choosedPictures"
		context = "fileManager">
	</custom-modal>

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
				<label>Trainerless
					<input type="checkbox" name="trainerless">
				</label>
			</div>
			<div class="small-4 medium-4 column">
				<label>Start
					<input type="number" name="trainercount">
				</label>
			</div>
			<div class="small-4 medium-4 column">
				<label>Finish
					<input type="number" name="trainercount">
				</label>
			</div>
		</div>

		<ul class="tabs" data-tabs id="plan-tabs">
		  <li class="tabs-title is-active"><a href="#main" aria-selected="true">Info</a></li>
		  <li class="tabs-title "><a href="#trainer">Trainer</a></li>
	    </ul>

	     <div class="tabs-content" data-tabs-content="plan-tabs">
		  <div class="tabs-panel is-active" id="main">
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
					<label>Trainerless
						<input type="checkbox" v-model="trainerless" name="trainerless">
					</label>
				</div>
				<div class="small-12 medium-6 column">
					<label>Trainer Count
						<input type="number" :disabled="!trainerless" name="trainercount">
					</label>
				</div>
			</div>
		  </div>
		  <div class="tabs-panel is-active" id="trainer">
		    <div class="row">
		    	<div class="small-12 column" style="height:100px">
		    		<a @click="showTraining = true" class="button success">
		    			<span class="fa fa-plus"></span>
		    		</a>
		    	</div>
			</div>
		  </div>
		</div>
	</form>
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
				name : '',
				description : '',
				trainerless : false,
				price : 0,
				teachers : [],
				pictures : [],
				services : [],
				showFileManager : false,
				showTraining : false,
			}
		},
		
		ready : function () {
			var tab = new Foundation.Tabs($('#plan-tabs'));
		},

		events : {
			'choosedTrainings' : function($response) {
				this.choosedTrainings($response);
			},

			'choosedPictures' : function($response) {
				this.choosedPictures($response);
			},
		},

		methods : {
			getData : function() {
				return this.$tools.transformParameters({
					club_id : this.id,
					name : this.name,
					description : this.description,
					pictures : this.$tools.collectionBy(this.pictures, "id|url"),
					teachers : this.$tools.collectionBy(this.teachers, "id"),
			    });
			},

			choosedTrainings : function($response) {
				this.teachers = $response.data;
				this.showTeachers = false;
			},
			
			triggerPictureBtn : function () {
				this.showFileManager = true;
			},

			choosedPictures : function($response) {
				this.pictures = $response.data;
				this.showFileManager = false;
			},

			deletePhoto : function(photo) {
				this.pictures.$remove(photo);				
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
		}
	}
</script>