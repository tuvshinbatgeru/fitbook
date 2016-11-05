<template>

	<custom-modal 
		:id = "id" 
		type = "User"
		title_en = "Photo chooser"
		title ="Зураг сонгох" 
		usage = "_photo-chooser" 
		multiple = "true"
		:show.sync = "showFileManager"
		save-callback = "choosedPictures">
		<div slot="body">
			<components v-ref:context :multiple="true" :selected.sync="pictures" is="file-manager">
			</components>
		</div>
	</custom-modal>

	<custom-cropper :ratio="258 / 192" 
                :editable="true"
                :image.sync="pinnedPic">
	</custom-cropper>  

	<div class="row">
	  	<waterfall 
			align="left"  
			:watch="pictures" 
			line="h"
			:line-gap="50"
	        :min-line-gap="50"
	        :max-line-gap="220">
		  <waterfall-slot 
		  	v-for="photo in pictures" 
		  	height="50"
		  	:width="50 / photo.ratio" 
		  	move-class="item-move"
	        transition="wf"
		  	:order="$index">
		  	<div class="photo-container">
			    <img v-bind:src="photo.url"
			    	 style="height:100%; width:100%"/>
		    	 <div style="position:absolute; top: 10px;">
			    	 <a @click="setPinnedPhoto(photo)">Pin</a>
			    	 <a @click="deletePhoto(photo)">Delete</a>
		    	 </div>
			</div>
		  </waterfall-slot>
		</waterfall>
		<div class="figure">
                <a @click="showFileManager = true" class="figcaption float-center">
                	<i class="fa fa-camera"></i>
                </a>
        </div>
	</div>
</template>

<script>
	import FileManager from '../../../context/FileManager.vue';

	var Waterfall = require('vue-waterfall')

	export default {
		props : {
			pictures : { 
				default: () => [],
			},
		},

		data() {
			return {
				showFileManager : false,
				pinned : null,
				pinnedPhoto : null,
			}
		},

		events : {
			'choosedPictures' : function($response) {
				this.choosedPictures($response);
			},
		},

		methods : {
			setPhotos : function(photos) {
				this.pictures = photos;

				var pinned = _.filter(this.pictures, function(o) { 
					return o.pivot.pinned == 'Y'; 
				});

				this.setPinnedPhoto(pinned[0]);				
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

			filterPinnedPic : function (obj) {
				return obj.pinned;
			},
		},

		computed : {
			pinnedPic : function () {
				return this.pinnedPhoto == null ? this.$env.get('APP_URI') + 'images/site/back.jpg' : this.pinnedPhoto;
			}
		},

		components : {
			'waterfall': Waterfall.waterfall,
    		'waterfall-slot': Waterfall.waterfallSlot,
    		FileManager
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

<style lang="scss">

/* $container : 100%; */

.photo-container {
    top: 5px;
    left: 5px;
    right: 5px;
    bottom: 5px;
    font-size: 1.2em;
}

.pinned	{
	  &:hover {
	    cursor: move;
	  }
}	
</style>