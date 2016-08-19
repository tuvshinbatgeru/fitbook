<template>
	<div class="top-bar hw-default-top-bar">
	  <div class="top-bar-left">
	    <ul class="menu ">
	      <li class="menu-text hw-default-logo">
	      	{{club.short_name}}</li>
	      <li><a href="#">{{club.short_name}}</a></li>
	      <li><a href="#">{{club.full_name}}</a></li>
	      <li><a href="#">{{club.description}}</a></li>
	      <li><a href="#">Холбоо барих</a></li>
	    </ul>
	  </div>
	  <div class="top-bar-right">
	    <ul class="menu">
	      <li><a @click="sentTeacherRequest" class="button btn-fb btn-trans">{{teacher_status}}</a></li>
	      <li><a @click="sentFollow" class="button btn-fb btn-trans">{{follow_status}}</a></li>
	      <li><a @click="sentTrainerRequest" class="button btn-fb btn-trans">{{request_status}}</a></li>
	    </ul>
	  </div>
	</div>
	<div class="parallax-container">
	  <div class="parallax-content">
	    <div class="parallax-back">
	      <!-- <div class="animated-word">
	        <h1>Үзүүлэлт</h1>
	        <p>Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар Тайлбар </p>
	      </div> -->
	      <p>Гоё уриа үг</p>
	    </div>
	  </div>
	</div>
</template>

<script>
	export default {
		props : {
			clubid : {default : ''},
		},

		created: function () {
		    this.getClubHeaderContent(this.clubid);
		},

		data : function () {
			return {
				club : [],
				follow_status : '',
				teacher_status : '',
				request_status : '',
			}
		},

		methods : {
			getClubHeaderContent : function(clubId) {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/'+ clubId +'/club-info').then((response) => {
			        this.club = response.data.club;
			        this.follow_status = response.data.follow_status;
			        this.teacher_status = response.data.teacher_status;
			        this.request_status = response.data.request_status;
			    }, (response) => {

			    });
			},

			sentFollow : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/'+ this.club.id + '/follow').then((response) => {
					debugger;
			        this.follow_status = response.data.type;
			    }, (response) => {

			    });
			},

			sentTrainerRequest : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/'+ this.club.id +'/request?type=2').then((response) => {
			        this.request_status = response.data.type;
			    }, (response) => {

			    });
			},

			sentTeacherRequest : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/'+ this.club.id + '/request?type=1').then((response) => {
			        this.teacher_status = response.data.type;
			    }, (response) => {

			    });
			}
		}
	}
</script>

<style>
	
</style>