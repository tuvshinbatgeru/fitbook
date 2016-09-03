<template>

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

</template>

<script>

	export default {
		props : {
			id : {},
			teachers : { 
				default: () => []
			},
		},

		data() {
			return {
				showTeachers : false,
			}
		},

		events : {
			'choosedTeachers' : function($response) {
				this.choosedTeachers($response);
			},
		},

		methods : {
			choosedTeachers : function($response) {
				this.teachers = $response.data;
				this.showTeachers = false;
			},

			deleteTeacher : function(teacher) {
				this.teachers.$remove(teacher);
			},
		},

		components : {

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