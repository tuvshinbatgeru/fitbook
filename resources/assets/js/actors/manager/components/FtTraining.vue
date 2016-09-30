<template>
	<div class="column" style="font-size:12px;">
		<a @click="editTraining()">Edit</a>
		<a @click="deleteTraining()">Delete</a>
		<a @click="showHistory()">
			<span class="fa fa-history"></span> {{item.histories_count}}
		</a>
		<div class="ft-pinned">
            <img v-lazy="item.pinned_photos[0].url"
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

            <span class="fa fa-cog" style="color: #3f4652;"></span>
            <strong>{{item.genres_count}}</strong>
        </div>
	</div>
</template>

<script>
	export default {
		props: {
			item : {}
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
</style>