<template>
	<form id="uploader" method="POST" action="/upload" enctype="multipart/form-data">
		<div class="row small-up-5 medium-up-5 large-up-5" >
		     <a @click="typeFilter('all')" class="button success">All</a>
			 <a @click="typeFilter('training')" class="button success">Training</a>
			 <a @click="typeFilter('plan')" class="button success">Plan</a>
			 <a @click="typeFilter('profile')" class="button success">Profile</a>
			 <a @click="typeFilter('selected')" class="button success">Selected</a>
			 <span class="button success fileinput-button">
				<i class="fa fa-cloud"></i>
				<input id="fileupload" type="file" class="image button success" name="image[]" multiple>
			 </span>	
			 <circle-progress-bar v-if="percentage" :percentage="percentage">
			 	
			 </circle-progress-bar>
		</div>
	</form>
	
	<waterfall 
		align="center"  
		:watch="filteredFiles" 
		:line-gap="200"
        :min-line-gap="100"
        :max-line-gap="220"
        :single-max-width="300">
	  <waterfall-slot 
	  	v-for="file in filteredFiles" 
	  	width="160" 
	  	move-class="item-move"
        transition="wf"
	  	:height="file.ratio * 160" 
	  	:order="$index">
	  	<div class="thumb-img">
		    <img v-bind:src="file.url"/>
		</div>
		<div class="thumb-back">
			<ul>
				<li v-for="tag in file.tags">
					{{tag.name_en}}
				</li>
			</ul>

			<div class="thumb-check">
				<a v-if="file.selected" @click="toggle(file)" class="success button">
					<i class="fa fa-check"></i>
				</a>
				<a v-else @click="toggle(file)" class="warning button">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
	  </waterfall-slot>
	</waterfall>
</template>
<script>
	/*var uploader = require('blueimp-file-upload');*/
	var Waterfall = require('vue-waterfall')
	import CircleProgressBar from '../components/CircleProgressBar.vue';

	export default {

		props : {
			multiple : {
				default : false
			},
			selected : {
				default: () => []
			},
		},

		data() {
			return {
				files : [],
				actualSize: null,
				maxSize: null,
				type : 'all',
				isBusy: false,
				before : null,
				percentage: null,
			}			
		},

		created : function () {
			this.getFiles();
		},

		ready : function () {
			$.ajaxSetup({
		        headers:
		            { 'X-CSRF-TOKEN': $('#_token').attr('value') }
	        });

			$('#fileupload').fileupload({
		        url: '/upload',
		        dataType: 'json',
		        start: this.start,
		        done: this.done,
		        progressall: this.progress
		    }).prop('disabled', !$.support.fileInput)
		        .parent().addClass($.support.fileInput ? undefined : 'disabled');
		},
	
		methods : {
			getData : function () {
				this.type = "selected";
				return this.filteredFiles;
			},
			
			start : function (e) {
	        	$('#progress .progress-bar').css(
	                'width', 0 + '%'
	            );
			},

			done : function (e, response) {
				if(response.result.result == "failed")
				{
					var option = {
						message : response.result.errors.image,
					}

					this.$root.$refs.toast.showToast(option);
					
					return;
				}

		        this.files.push(response.result.data);
			},

			progress : function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
		        $('#progress .progress-bar').css(
		            'width',
		            progress + '%'
		        );
			},

			typeFilter : function (type) {
				if(!this.isBusy)
					this.type = type;
			},

			getFiles : function () {
				var maps = this.objectListToMap(this.selected);
				this.$http.get(this.$env.get('APP_URI') + 'api/user/files?selected=' + maps).then((response) => 
				{

					debugger;
					this.files = response.data.files;
					this.actualSize = response.data.actualSize;
					this.maxSize = response.data.maxSize;
					this.percentage = parseInt(this.actualSize * 100 / this.maxSize);
				}, (response) => {

				});	
			},

			objectListToMap : function (list) {
				var map = [];
				for (var i = 0; i < list.length; i++) {
					map.push(list[i].id);
				}
				return map;
			},

			filterByType : function (obj) {
				if(this.type == "all") return true;

				if(this.type == "selected" && obj.selected) return true;

				for(i = 0; i < obj.tags.length; i ++) {
					if(obj.tags[i].name_en == this.type) return true;
				}

				return false;
			},

			unselect : function () {
				this.before.selected = false;
			},

			toggle : function (photo) {
				photo.selected = !photo.selected;
				if(!this.multiple)
				{
					if(this.before && this.before != photo)
						this.unselect();
					this.before = photo;
				}
			},
		},

		events: {
            'wf-reflowed': function () {
		        this.isBusy = false
            }
        },


		computed : {
			filteredFiles : function () {
		        return this.files.filter(this.filterByType);
		    },
 		},

		components : {
			'waterfall': Waterfall.waterfall,
    		'waterfall-slot': Waterfall.waterfallSlot,
    		CircleProgressBar
		}
	}
</script>
<style lang="scss">

.thumb-img {
    position: absolute;
    top: 5px;
    left: 5px;
    right: 5px;
    bottom: 5px;
    font-size: 1.2em;
}

.vue-waterfall-slot:hover .thumb-back,
.vue-waterfall-slot:hover ~ .thumb-back {
    color: #fff;
    opacity: 1;
}

.thumb-back {
	opacity : 0;
	border-radius: 4px;
	background-color : rgba(0,0,0,.7);
	position: absolute;
    top: 5px;
    left: 5px;
    right: 5px;
    bottom: 5px;
    font-size: 1.2em;
}

.thumb-check {
	top: 50%;
	left: 50%;
}

.thumb-back ul {
	list-style-type: none;
}

.thumb-back ul li {
	color: #000;
	background-color: #fff;
	border-radius: 2px;
}

.thumb-img img {
	width: 100%; 
	height: 100%; 
	display:block;
	border-radius: 4px;
}

.fileinput-button {
    position: relative;
    overflow: hidden;
    display: inline-block;
}

.fileinput-button input {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    opacity: 0;
    -ms-filter: 'alpha(opacity=0)';
    font-size: 200px !important;
    direction: ltr;
    cursor: pointer;
}

.progress {
    height: 20px;
    margin-bottom: 20px;
    overflow: hidden;
    background-color: #f5f5f5;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
}

.progress-bar-success {
    background-color: #5fcf80 !important;
}

.progress-bar {
    float: left;
    width: 0;
    height: 100%;
    font-size: 12px;
    line-height: 20px;
    color: #fff;
    text-align: center;
    background-color: #428bca;
    -webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    -webkit-transition: width .6s ease;
    -o-transition: width .6s ease;
    transition: width .6s ease;
}

.item-move {
        transition: all .5s cubic-bezier(.55,0,.1,1);
        -webkit-transition: all .5s cubic-bezier(.55,0,.1,1);
}

.wf-transition {
  transition: opacity .3s ease;
  -webkit-transition: opacity .3s ease;
}

.wf-enter, .wf-leave{
  opacity: 0;
}

</style>