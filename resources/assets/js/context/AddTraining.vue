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

	  <div class="row">
	  	<div class="small-12 columns">
	  		<img :src="pinnedPic">
	  	</div>		
	  </div>
	  <div class="row">
	  	<waterfall 
			align="center"  
			:watch="pictures" 
			:line-gap="50"
	        :min-line-gap="100"
	        :max-line-gap="220"
	        :single-max-width="300">
		  <waterfall-slot 
		  	v-for="photo in pictures" 
		  	:width="photo.ratio * 50" 
		  	move-class="item-move"
	        transition="wf"
		  	height="50" 
		  	:order="$index">

		  	<div>
			    <img v-bind:src="photo.url"
			    	 style="height:100%; width:100%"/>

			    	 <a @click="setPinnedPhoto(photo)">Pin</a>
			    	 <a @click="deletePhoto(photo)">Delete</a>
			</div>
		  </waterfall-slot>
		</waterfall>
		<div class="figure">
            <div class="figcaption" style="opacity:1;">
                <a @click="showFileManager = true" class="btn-floating red" style="left: 25%;">
                	<i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
	  </div>


	  <ul class="tabs">
        <li class="tab s3"><a class="active" href="#main">{{ $t("info") }}</a></li>
        <li class="tab s3"><a href="#teacher">{{ $t("teacher") }}</a></li>
	  </ul>
		  <div id="main">
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
		  <div id="teacher">
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
	</form>
</template>
<script>
	var Waterfall = require('vue-waterfall')

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
				pinnedPhoto : null,
			}
		},
		
		ready : function () {
			$('ul.tabs').tabs();
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
					pictures : this.$tools.collectionBy(this.pictures, "id|url|pinned"),
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
				if(this.pictures.length > 0) {
					this.pinnedPhoto = this.pictures[0];
					this.pinnedPhoto.pinned = true;
				}
				this.showFileManager = false;
			},

			setPinnedPhoto : function(photo) {
			
				photo.pinned = true;

			    if(this.pinnedPhoto && photo != this.pinnedPhoto) {
					this.pinnedPhoto.pinned = false;
				}

				this.pinnedPhoto = photo;
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

			filterPinnedPic : function (obj) {
				return obj.pinned;
			},
		},

		computed : {
			pinnedPic : function () {
				var pinned = this.pictures.filter(this.filterPinnedPic);
				return pinned.length == 0 ? this.$env.get('APP_URI') + 'images/site/back.jpg' : pinned[0].url;
			}
		},

		components : {
			'waterfall': Waterfall.waterfall,
    		'waterfall-slot': Waterfall.waterfallSlot,
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