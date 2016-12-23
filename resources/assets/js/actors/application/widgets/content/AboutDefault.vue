<template>
	<div class="cntr-fluid">
		<div class="row medium-uncollapse large-collapse" style="    margin-top: 25px;">
			<div class="fit-panel columns large-9">
				<div class="fit-panel-header">
					<div class="fit-panel-title">
						About
					</div>
				</div>
				<div class="fit-panel-body">
					<div class="about-panel">
						<div class="about-paragraph">
							<div class="paragraph-title">
								<h5><i class="fa fa-indent"></i>Overview</h5>
							</div>
							<div class="paragraph-content">
								<p>
									Амралтын өдрийг утгатай өнгөрүүлэх нэг арга бол гэр бүлээрээ цана, чаргаар гулгахаар явах. Очих газар луугаа өглөө эртхэн босоод гарвал, хүн багатай, дараалал, хүлээлт байхгүй, түгжрэл ч байхгүй байх учир таныг стресстүүлэхгүй. Хүүхдүүдтэйгээ хамт цасан хүн хийхээ битгий мартаарай. Өглөөний цэвэр агаарыг мэдрэх нь хамгийн чухал юм шүү. Мөн энэ өдрөө үүрд хадгалахын тулд бичлэг болон зураг авахуулж, зургийн цомгоо чимээрэй.
								</p>
							</div>
						</div>
						<div class="about-paragraph">
							<div class="paragraph-title">
								<h5><i class="fa fa-history"></i>History</h5>
							</div>
							<div class="paragraph-content">
								<ul class="about-timeline">
									<li>
										<span class="time">STARTED 1998</span>
										<p>
											Монголын хамгийн шилдэг фитнесээр тодорсон
										</p>
									</li>
									<li>
										<span class="time">1998-2000</span>
										<p>
											Салбар 2 нээгдсэн. Хан-Уул дүүрэг 3 хороо 75-р сургуулийн урд талд
										</p>
									</li>
								</ul>
							</div>
						</div>
						<div class="about-paragraph">
							<div class="paragraph-title">
								<h5><i class="fa fa-info-circle"></i>Холбоо барих</h5>
							</div>
							<div class="paragraph-content">
								<table class="borderless">
									<tr>
										<td><i class="fa fa-phone"></i></td>
										<td style="min-width: 200px;">
											88292713,88292712
										</td>
									</tr>
									<tr>
										<td><i class="fa fa-desktop"></i></td>
										<td>
											www.flexgym.mn
										</td>
									</tr>
									<tr>
										<td><i class="fa fa-clock-o"></i></td>
										<td>
											Hours: 9:00 - 21:00
										</td>
									</tr>
								</table>
								<table class="borderless">
									<tr>
										<td><i class="fa fa-map-marker"></i></td>
										<td style="min-width: 200px;">
											Хан-Уул дүүрэг 3 хороо 75-р сургуулийн урд талд
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="columns large-3 side-panel">
				<h4 class="side-panel-title">Бусад салбарууд</h4>
				<div class="club-branch-card">
					<div class="cover">
						<div class="cover-img">
							<img class="vertical" src="../images/site/default_photo.jpg" />
						</div>
					</div>
					<div class="branch-info">
						<h5 class="branch-name">Flexgym masters fitness</h5>
						<table class="borderless">
							<tr>
								<td><i class="fa fa-clock-o"></i></td>
								<td>Hours: 9:00 - 20:00</td>
							</tr>
							<tr>
								<td><i class="fa fa-map-marker"></i></td>
								<td>Самбуугийн гудамж, Улаанбаатар хот</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props : {
			id : { 
				required: true,
			},
		},

		created: function () {
		    this.getTeachers();
		},

		data : function () {
			return {
				teachers : [],
			}
		},

		methods : {
			
		}
	}
</script>

<style>
	
</style>