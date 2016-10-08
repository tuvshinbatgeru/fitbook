<template>
	<div class="column" style="font-size:12px;">
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
		<div class="ft-pinned">
            <img :id="'training-' + item.id + '-img'"
            	 v-lazy="item.pinned_photos[0].url"
                 :style = "{ 
                        top: -1 * parseInt((item.pinned_photos[0].pivot.top_percentage * 300 * item.pinned_photos[0].ratio) / 100) + 'px'
                 }" />    
        </div>
        <span>{{item.created_at | moment "from"}}</span>
		<h3>{{item.name}}</h3>
		{{{item.description}}}	
		<div class="row text-center">
            <span class="fa fa-user-md" style="color: red;"></span>
            <strong>{{item.teachers_count}}</strong>
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
 			new Foundation.Dropdown($('#training-history-' + this.item.id));	
 		},

		methods : {
			deleteTraining : function () {
				this.$dispatch('deleteTraining', this.item);
			},

			editTraining : function () {
				this.$dispatch('editTraining', this.item);
			},

			showHistory : function () {

			}

		},

		components : {
 			AdjustmentHistories,
  		}		  		
	}
</script>
<style>
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