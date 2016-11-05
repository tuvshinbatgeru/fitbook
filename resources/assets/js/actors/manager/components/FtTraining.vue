<template>
	<div class="column FtTraining">
		<a @click="editTraining()">Edit</a>
		<a @click="deleteTraining()">Delete</a>
		<a>
 			<span class="fa fa-history"></span> 
 			<a @click="showTrainingHistory = true" :data-toggle="'training-history-' + item.id">{{item.histories_count}}</a>
 
 			<div class="dropdown-pane bottom" v-bind:id="'training-history-' + item.id" data-dropdown data-close-on-click="true">
 		        <div v-if="showTrainingHistory">
 		        	<adjustment-histories :id="item.id" type='training-adjustment'>
 		        		
 		        	</adjustment-histories>
 		        </div>
 		    </div>
  		</a>
        <custom-cropper :ratio="920 / 280" 
                :editable="false"
                :image="item.pinned_photos | imageFilter">
		</custom-cropper>      
        <span>{{item.created_at | moment "from"}}</span>
		<h3>{{item.name}}</h3>
		{{{item.description}}}	
		<div class="row text-center">

			<custom-selection-list 
				:limit="2" 
				:total="item.teachers_count"
				:items="item.first_two_teachers"
				:item-text="itemText"
				@clicked="allTeachers"
				:limit-before="teacherLimitBefore"
				:limit-after="teacherLimitAfter">
			</custom-selection-list>

        </div>
        <ul class="small-12 medium-6 column">
            <li class="training--genre" v-for="genre in item.genres">
             	<span>
             		{{genre.name}}
             	</span>
            </li>
       </ul>
	</div>
</template>

<script>
	import AdjustmentHistories from '../../application/components/AdjustmentHistories.vue';	

	export default {
		props: {
			item : {}
		},

		data () {
 			return {
 				showTrainingHistory : false,
 			}
 		},

 		ready : function () {
 			new Foundation.Dropdown($('#training-history-' + this.item.id))	
 		},

 		filters : {
 			imageFilter : function (photos) {

 				if(photos.length > 0) {
 					return photos[0]
 				}

 				return this.$env.get('APP_URI') + 'images/site/default_photo.jpg'
 			} 
 		},

		methods : {
			deleteTraining : function () {
				this.$dispatch('deleteTraining', this.item);
			},

			editTraining : function () {
				this.$dispatch('editTraining', this.item);
			},

			showHistory : function () {

			},

			allTeachers : function () {
				this.$dispatch('allTeachers', this.item);
			},

			teacherLimitBefore : function() {
				return this.$t('and');
			},

			teacherLimitAfter : function() {
				return this.$t('other');
			},

			itemText : function (item) {
				return '<a href="/users/' + item.username + '">' + item.first_name + ' ' + item.last_name + '</a> ';
			}
		},

		components : {
 			AdjustmentHistories,
  		},

  		locales : {
  			en : {
  				and : 'and ',
  				other : ' others teachers',

  			},

  			mn : {
  				and : 'ба бусад ',
  				other : ' багш нар'
  			}
  		} 		
	}
</script>
<style>
.FtTraining {
	width:200px !important; 
	font-size: 12px;
}

.ft-pinned {
	width:300px; 
	height:100px; 
	overflow: hidden;
} 

.ft-pinned img {
	width: 100%;
	position: relative;
	max-height: none;
}

.training--genre {
 	float: left;
 	margin-left: 5px;
 }
 
 .training--genre span{
 	padding: 4px;
 	background-color: #aecaec;
 	color: #3f4652;
 	border-radius: 4px;
 }
</style>