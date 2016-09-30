<template>
	<form method="POST" accept="">
	  <photo-slider v-ref:pslider>
	  </photo-slider>
	  <div class="row">
	  		<label>{{$t("genre")}}</label>
		    <multiselect 
		    	:options="sysgenres" 
		    	:selected.sync="genres" 
		    	:multiple="true"
		    	:clear-on-select="false" 
		    	:close-on-select="false" 
		    	select-label='сонгох'
		    	selected-label='сонгосон'	
		    	deselect-label='устгах'
		    	:limit="5"
		    	label="name" 
		    	@update="updateGenres"
		    	:limit-text="limitText"
		    	key="id" 
		    	placeholder="хайх ...">
		    		<span slot="noResult">Илэрц алга ...</span>
		    </multiselect>
	  </div>

	  <ul class="tabs">
        <li class="tab s3"><a class="active" href="#main">{{ $t("info") }}</a></li>
        <li class="tab s3"><a href="#teacher">{{ $t("teacher") }}</a></li>
	  </ul>
	  <div id="main" style="padding-bottom:70px;">
	    <div class="row">
		    <div class="medium-6 columns">
		      <label>{{ $t("name") }}
		        <input type="text" name="name" v-model="name" placeholder="">
		      </label>
		    </div>
		    <div class="small-12 columns">
		      <label>{{ $t("description") }}
		      	<custom-editor v-ref:tdescription></custom-editor>
		      </label>
		    </div>
		</div>
	  </div>
	  <div id="teacher">
	  	<teacher-slider v-ref:tslider :id="id" :selected.sync="trainings"></teacher-slider>
	  </div>
	</form>
</template>

<script>
	import PhotoSlider from '../actors/application/components/PhotoSlider.vue';
	import TeacherSlider from '../actors/application/components/TeacherSlider.vue';

	export default {
		props: { 
			id : {},
			training : {}
		},

		data() {
			return {
				name : '',
				description : '',
				sysgenres : [],
				genres : null,
			}
		},

		created : function () {
			this.getGenres();
		},
		
		ready : function () {
			$('ul.tabs').tabs();
			$('.dropdown-button').dropdown({
			      inDuration: 300,
			      outDuration: 225,
			      constrain_width: false, // Does not change width of dropdown to that of the activator
			      hover: true, // Activate on hover
			      gutter: 0, // Spacing from edge
			      belowOrigin: false, // Displays dropdown below the button
			      alignment: 'left' // Displays dropdown with edge aligned to the left of button
			    }
			);

			if(this.training) {
				this.setData();
			}
		},

		methods : {
			setData : function () {
				this.name = this.training.name;
				this.$refs.tdescription.setHtml(this.training.description);
				this.$refs.tslider.setTeachers(this.training.teachers);
				this.genres = this.training.genres;
				this.$refs.pslider.setPhotos(this.training.photos);			
			},
			getData : function() {
				this.$dispatch('startLoading');
				return {
					teachers : this.$refs.tslider.teachers,
					pinned_photo : this.$refs.pslider.pinnedPhoto,
					param : this.$tools.transformParameters({
						id : this.training ? this.training.id : null,
						club_id : this.id,
						name : this.name,
						description : this.$refs.tdescription.getHTML(),
						crop : this.$refs.pslider.getViewPort(),
						pictures : this.$tools.collectionBy(this.$refs.pslider.pictures, "id|url|pinned"),
						teachers : this.$tools.arrayBy(this.$refs.tslider.teachers, "id"),
						genres : this.$tools.arrayBy(this.genres, "id"), 
			    	})
				};
			},

			validate : function () {

				if(!this.name.trim()) {
					this.$root.$refs.toast.showMessage("Please. Fill the name of training");
					return false;
				}

				if(!this.genres || this.genres.length == 0) {
					this.$root.$refs.toast.showMessage("Please. Choose at least one genre");
					return false;
				}

				if(!this.$refs.tslider.teachers || this.$refs.tslider.teachers.length == 0) {
					this.$root.$refs.toast.showMessage("Please. Choose at least one teacher");
					return false;	
				}

				return true;
			},

			getGenres : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/genre').then(res => {
					this.sysgenres = res.data.result;
				}).catch(err => {

				});
			}, 

			limitText : function(count) {
				return "ба " + count + " бусад"; 
			},

			updateGenres : function (genres) {
				this.genres = genres;
			}
		},

		components : {
			PhotoSlider, TeacherSlider
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
	    		genre : 'Genre',
	    	},
	    	mn : {
	    		info : 'Инфо',
	    		photos : 'Зураг оруулах',
	    		teacher : 'Багш сонгох',
	    		name : 'Хичээлийн нэр',
	    		description : 'Тайлбар',
	    		name_watermark : 'нэр ...',
	    		description_watermark : 'тайлбар ...',
	    		genre : 'Төрөл',
	    	},
	    }
	}
</script>
<style lang="scss">
</style>