<template>
	<div id="viewContainer" style="width:600px;height:200px;overflow:hidden;">
        <div id="draggableContainer" style="">
	        <img id="draggable" class="pinned" 
	        	 :src = "pinnedPic"
	             style="width:100%;height:684px;overflow:hidden;"/>
	    </div>
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
            <div class="figcaption" style="opacity:1;">
                <a @click="showFileManager = true" class="btn-floating red" style="left: 25%;">
                	<i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
	</div>
</template>

<script>
	export default {
		props : {
			pictures : { 
				default: () => [],
			},
		},

		data() {
			return {
				showFileManager : false,
			}
		},

		ready : function () {
			var dragContainerWidth = $("#viewContainer").innerWidth() + ($('#draggable').outerWidth() - $("#viewContainer").innerWidth()) * 2;
			var dragContainerHeight = $("#viewContainer").innerHeight() + ($('#draggable').outerHeight() - $("#viewContainer").innerHeight()) * 2;

			$("#draggableContainer").css("width",dragContainerWidth);
			$("#draggableContainer").css("height",dragContainerHeight);

			//set up position of draggable container according to view container and draggable size

			var dragContainerOffsetLeft = $("#viewContainer").offset().left + $("#viewContainer").outerWidth()/2 + $("#viewContainer").innerWidth()/2 - $('#draggable').outerWidth();
			var dragContainerOffsetTop = $("#viewContainer").offset().top + $("#viewContainer").outerHeight()/2 + $("#viewContainer").innerHeight()/2 - $('#draggable').outerHeight();

			$("#draggableContainer").offset({left:dragContainerOffsetLeft,top:dragContainerOffsetTop});

			//activate draggable
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

<style lang="scss">
</style>