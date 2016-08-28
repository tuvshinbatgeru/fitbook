<template>
	<custom-modal 
		:id = "id" 
		type = "User"
		title_en = "Photo chooser"
		title ="Зураг сонгох" 
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
		title = "Багш сонгох"
		title_en = "Teacher chooser"
		usage = "_teacher-chooser"
		:items = "teachers"
		:show.sync = "showTeachers"
		save-callback = "choosedTeachers"
		context = "teachers">
	</custom-modal>

	<form method="POST" accept="">
		<ul class="tabs" data-tabs id="example-tabs">
		  <li class="tabs-title is-active"><a href="#main" aria-selected="true">{{ $t("info") }}</a></li>
		  <li class="tabs-title "><a href="#photos">{{ $t("photos") }}</a></li>
		  <li class="tabs-title"><a href="#teacher">{{ $t("teacher") }}</a></li>
	    </ul>

	  <div class="tabs-content" data-tabs-content="example-tabs">
		  <div class="tabs-panel is-active" id="main">
		    <div class="row">
			    <div class="medium-6 columns">
			      <label>{{ $t("name") }}
			        <input type="text" name="name" v-model="name" placeholder="">
			      </label>
			    </div>
			    <div class="medium-6 columns">
			      <label>{{ $t("description") }}
			        <textarea type="text" name="description" v-model="description" placeholder="">
			        </textarea>
			      </label>
			    </div>
			</div>
		  </div>
		  <div class="tabs-panel" id="teacher">
  	  		   <div class="picture-list">
			  	<div class="row small-up-2 medium-up-3 large-up-4">
			  		<br>
				  	<div class="column" v-for="teacher in teachers">
					  	<div class="figure">
		                    <img v-bind:src="teacher.avatar_url" alt="Jeffrey Way" height="120" width="120" style="border-radius:4px;">
		                    <div class="figcaption">
		                        <a @click="deleteTeacher(teacher)" class="btn-floating red" style="left: 25%;">
		                        	<i class="fa fa-trash"></i>
		                        </a>
		                    </div>
		                </div>
				  	</div>
				  	<div class="column">
					  	<div class="figure">
		                    <div class="figcaption" style="opacity:1;">
		                        <a @click="showTeachers = true" class="btn-floating red" style="left: 25%;">
		                        	<i class="fa fa-plus"></i>
		                        </a>
		                    </div>
		                </div>
				  	</div>
				</div>
			  </div>
		  </div>
		  <div class="tabs-panel" id="photos">
			  <div class="picture-list">
			  	<div class="row small-up-2 medium-up-3 large-up-4">
			  		<br>
				  	<div class="column" v-for="photo in pictures">
					  	<div class="figure">
		                    <img v-bind:src="photo.url" alt="Jeffrey Way" height="120" width="120" style="border-radius:4px;">
		                    <div class="figcaption">
		                        <a @click="deletePhoto(photo)" class="btn-floating red" style="left: 25%;">
		                        	<i class="fa fa-trash"></i>
		                        </a>
		                    </div>
		                </div>
				  	</div>
				  	<div class="column">
					  	<div class="figure">
		                    <div class="figcaption" style="opacity:1;">
		                        <a @click="triggerPictureBtn" class="btn-floating red" style="left: 25%;">
		                        	<i class="fa fa-plus"></i>
		                        </a>
		                    </div>
		                </div>
				  	</div>
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
				teachers : [],
				pictures : [],
				services : [],
				showFileManager : false,
				showTeachers : false,
			}
		},
		
		ready : function () {
			var tab = new Foundation.Tabs($('#example-tabs'));
		},

		events : {
			'choosedTeachers' : function($response) {
				this.choosedTeachers($response);
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

			choosedTeachers : function($response) {
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
		},

		locales: {
	        en: { 
	        	info : 'Info',
	    		photos : 'Add photos',
	    		teacher : 'Add teachers',
	    		name : 'Training name',
	    		description : 'Description',
	    		name_watermark : 'name ...',
	    		description_watermark : 'description ...',
	    	},
	    	mn : {
	    		info : 'Инфо',
	    		photos : 'Зураг оруулах',
	    		teacher : 'Багш сонгох',
	    		name : 'Хичээлийн нэр',
	    		description : 'Тайлбар',
	    		name_watermark : 'нэр ...',
	    		description_watermark : 'тайлбар ...',
	    	},
	    }
	}
</script>