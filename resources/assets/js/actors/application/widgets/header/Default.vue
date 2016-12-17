<template>
	<div class="cntr-full">
		<div class="club-cover">
			<div class="cover-img">
				<img class="horizontal" src="../images/site/default_photo.jpg" />
			</div>
		</div>
	</div>
	<div class="club-page cntr-fluid">
		<div class="club-page-header">
			<div class="display-table">
				<div class="table-row">
					<div class="table-cell club-logo">
						<img height="160" width="160" src="../images/flexgym.png" />
						<h3 class="club-title">
							{{club.short_name}}
						</h3>
					</div>
					<div class="table-cell">
						<div class="info-line">
							<a class="info-number border-right">
								<span class="number">1,700</span>
								<br/>
								<span class="number-label">TRAINERS</span>
							</a>
							<a class="info-number border-right">
								<span class="number">2,300</span>
								<br/>
								<span class="number-label">FOLLOWERS</span>
							</a>
							<a class="info-number">
								<span class="number">2,300</span>
								<br/>
								<span class="number-label">RANKED</span>
							</a>
							<div class="buttons float-right"> 
								<a class="fit-hollow-btn float-right">
									+ Follow 
								</a>
							</div>
						</div>
						<div class="active-line">
							<div class="active-list border-right">
								<label>
									ACTIVE TEACHERS
								</label>
								<ul class="active-people">
									<li>
										<a>
											<img src="../images/site/cropped.jpg" width="25"  height="25" />
										</a>
									</li>
									<li>
										<a>
											<img src="../images/site/cropped.jpg" width="25"  height="25"/>
										</a>
									</li>
									<li>
										<a>
											<img src="../images/site/cropped.jpg" width="25"  height="25"/>
										</a>
									</li>
								</ul>
							</div>
							<div class="active-list">
								<label>
									ACTIVE MEMBERS
								</label>
								<ul class="active-people">
									<li>
										<a>
											<img src="../images/site/cropped.jpg" width="25"  height="25" />
										</a>
									</li>
									<li>
										<a>
											<img src="../images/site/cropped.jpg" width="25"  height="25"/>
										</a>
									</li>
									<li>
										<a>
											<img src="../images/site/cropped.jpg" width="25"  height="25"/>
										</a>
									</li>
								</ul>
							</div>
							<div class="active-list float-right border-left">
								<label>
									Contact us
								</label>
								<table>
									<tr>
										<td><i class="fa fa-phone"></i> </td>
										<td>8621-6748</td>
									</tr>
									<tr>
										<td><i class="fa fa-clock-o"></i> </td>
										<td>Hours: 9:00 - 21:00 <span class="open"> open </span></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<ul class="club-nav">
				<li>
					<a>Home</a>
				</li>
				<li class="active">
					<a>Plans</a>
				</li>
				<li>
					<a>Members</a>
				</li>
				<li>
					<a>Info</a>
				</li>
				<li>
					<a>Schedule</a>
				</li>
				<li>
					<a>Give away</a>
				</li>
				<li>
					<a>Challenge</a>
				</li>
				<li>
					<a>Forum</a>
				</li>
			</ul>
		</div>
		
	</div>
	<div class="cntr-fluid fit-panel" style="height: 600px; background-color: #fff;margin-top: 30px;">
		<div class="fit-panel-header">
			<div class="fit-panel-title">
				Members
			</div>
			<div class="fit-panel-filter">
				<a class="filter">Reception</a>
				<a class="filter">Member</a>
				<a class="filter">Active</a>
			</div>
		</div>
		<div class="fit-panel-body">

		</div>
	</div>
	    <!-- <ul class="menu">
	      <li><a @click="sentTeacherRequest" class="button btn-fb btn-trans">{{getText(teacher_status)}}</a></li>
	      <li><a @click="sentFollow" class="button btn-fb btn-trans">{{getText(follow_status)}}</a></li>
	      <li><a @click="sentTrainerRequest" class="button btn-fb btn-trans">{{getText(request_status)}}</a></li>
	    </ul> -->
</template>

<script>
	import CustomHexagon from '../../svg/CustomHexagon.vue';
	export default {
		props : {
			id : {default : ''},
		},

		created: function () {
			this.setLanguage();
		    this.getClubHeaderContent(this.id);
		},

		data : function () {
			return {
				club : [],
				follow_status : '',
				teacher_status : '',
				request_status : '',
				lang_mn : [],
				lang_eng : [],
			}
		},

		methods : {
			getClubHeaderContent : function() {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/'+ this.id +'/club-info').then((response) => {
			        this.club = response.data.club;
			        this.follow_status = response.data.follow_status;
			        this.teacher_status = response.data.teacher_status;
			        this.request_status = response.data.request_status;
			    }, (response) => {

			    });
			},

			sentFollow : function () {
				this.$http.post(this.$env.get('APP_URI') + 'api/club/'+ this.club.id + '/follow').then((response) => {
			        this.follow_status = response.data.type;
			    }, (response) => {

			    });
			},

			sentTrainerRequest : function () {
				this.$http.post(this.$env.get('APP_URI') + 'api/club/'+ this.club.id +'/request?type=2').then((response) => {
			        this.request_status = response.data.type;
			    }, (response) => {

			    });
			},

			sentTeacherRequest : function () {
				this.$http.post(this.$env.get('APP_URI') + 'api/club/'+ this.club.id + '/request?type=1').then((response) => {
			        this.teacher_status = response.data.type;
			    }, (response) => {

			    });
			},

			setLanguage : function () {
				this.lang_en = {
			    	teacher : 'Teacher request',
			    	unteacher : 'Sent',
			    	follow : 'Follow',
			    	unfollow : 'Followed',
			    	trainer : 'Request',
			    	untrainer : 'Un Request',
			    	manager : 'Manager',
			    	reception : 'Reception',
			    };

			    this.lang_mn = {
			    	teacher : 'Багш болох',
			    	unteacher : 'Багш болох хүсэлт илгээсэн',
			    	follow : 'Дагах',
			    	unfollow : 'Дагсан',
			    	trainer : 'Элсэх',
			    	untrainer : 'Элсэх хүсэлт илгээсэн',
			    	manager : 'Менежер',
			    	reception : 'Ресефшин',
			    };
			},

			getText : function (value) {
				return this.lang_mn[value];
			}
		},
		components : {
			CustomHexagon
		}
	}
</script>

<style>
	
</style>