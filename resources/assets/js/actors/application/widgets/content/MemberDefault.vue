<template>
	<div class="cntr-fluid fit-panel">
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
			<div class="row manager">
				<div class="columns large-6">
					<div class="fit-panel-filter">
						<a class="filter"><i class="fa fa-user"></i> Manager</a>
						<a class="filter"><i class="fa fa-user-plus"></i>Reception</a>
						<a class="filter"><i class="fa fa-male"></i> Teacher</a>
					</div>
				</div>
				<div class="columns large-6" style="text-align: right;">
					<label class="search-input">
						<input type="text" placeholder="You can search people..."/>
						<label>Search</label>
					</label>
					<a class="fit-official-btn">+ Request</a>
				</div>
			</div>
			<div class="row small-up-1 medium-up-2 large-up-3 large-collapse medium-collapse small-collapse">
			  <div class="column column-block">
			    <div class="member-card">
					<a class="member-img">
						<div class="cover-img">
							<img class="horizontal" src="../images/prof.jpg" />
							<span class="online"></span>
						</div>
					</a>
					<div class="member-info">
						<div class="_info">
							<label class="_name">
								О. Мандухай
							</label>
							<a class="_follow">135 followeres</a>
							<i class="fa fa-circle"></i>
							<a class="_follow">15 following</a>
						</div>
						<div class="follow-btn">
							<a class="fit-hollow-btn">
								+ Follow
							</a>
						</div>
					</div>
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