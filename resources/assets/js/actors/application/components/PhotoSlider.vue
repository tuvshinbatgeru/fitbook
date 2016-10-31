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

	<div id="viewContainer">
        <div id="draggableContainer" 
        	 :style="{ top: viewPort + 'px', bottom: viewPort + 'px' }">
	    </div>
	    <img id="draggable" 
	         class="pinned" 
	         :style="{ top: top + 'px'}"
	         :src = "pinnedPic"/>
	</div>

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
				viewPort : 0,
				top : 0,
			}
		},

		ready : function () {

			$('#draggable').draggable({
				axis: "y",
				containment:"#draggableContainer"
			});
		},

		events : {
			'choosedPictures' : function($response) {
				this.choosedPictures($response);
			},
		},

		methods : {
			getViewPort : function () {
				var top = $('#draggable').css('top');
				top = -1 * parseInt(top.split('px')[0]);
				return parseInt((top * 100) / (this.pinnedPhoto.ratio * 600));
			},

			setViewPort : function (width) {
				this.viewPort = width;
				$('#draggable').css('top', this.viewPort + 'px');
			},

			setPhotos : function(photos) {
				this.pictures = photos;

				var pinned = _.filter(this.pictures, function(o) { 
					return o.pivot.pinned == 'Y'; 
				});

				this.setPinnedPhoto(pinned[0]);				
			},

			choosedPictures : function($response) {
				debugger;
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

				this.setViewPort(this.pinnedPhoto == null ? -175 : (200 - this.pinnedPhoto.ratio * 600));

				return this.pinnedPhoto == null ? this.$env.get('APP_URI') + 'images/site/back.jpg' : this.pinnedPhoto.url;
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

#viewContainer {
	width: 600px;
	height: 200px;
	overflow:hidden;
	position: relative;
}

#draggableContainer {
	left: 0px; 
	right: 0px; 
	position: absolute;
}

#draggable {
	width:100%; 
	position:relative; 
	max-height:none;
	top: 0px;
}

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