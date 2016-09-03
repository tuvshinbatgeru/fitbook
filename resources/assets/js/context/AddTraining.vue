<template>
	<form method="POST" accept="">

  	  <a class="dropdown-button" 
  	     href="#!" 
  	     data-activates="14" 
  	     data-constrainwidth="false">
            
      </a>

      <ul id="14" class="dropdown-content">
		  <li><a href="http://myapp.dev/things">Index</a></li>
		  <li><a href="http://myapp.dev/place/logs">Logs</a></li>
		  <li><a href="http://myapp.dev/place/create">Create Thing</a></li>
		  <li><a href="http://myapp.dev/things/manage">Very Long Menu Item That Should Overflow</a></li>
	  </ul>

	  <photo-slider v-ref:pslider></photo-slider>

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
	  	<teacher-slider v-ref:tslider :id="id"></teacher-slider>
	  </div>
	</form>
</template>

<script>
	import PhotoSlider from '../actors/application/components/PhotoSlider.vue';
	import TeacherSlider from '../actors/application/components/TeacherSlider.vue';

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
				services : [],
			}
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
		},

		methods : {
			getData : function() {
				return this.$tools.transformParameters({
					club_id : this.id,
					name : this.name,
					description : this.description,
					pictures : this.$tools.collectionBy(this.$refs.pslider.pictures, "id|url|pinned"),
					teachers : this.$tools.collectionBy(this.$refs.tslider.teachers, "id"),
			    });
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