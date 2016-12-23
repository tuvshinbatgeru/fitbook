<template>
	<div class="cntr-fluid fit-panel">
		<div class="fit-panel-header">
			<div class="fit-panel-title">
				Members
			</div>
			<div class="fit-panel-filter" v-show="isManager == 'Y'">
				<a @click="changeStatusType('request')" 
					:class="statusType == 'request' ? 'active' : ''" 
					class="filter">Request<span style="font-weight:bold">5</span> </a>
				<a @click="changeStatusType('active')" 
				   :class="statusType == 'active' ? 'active' : ''"
				   class="filter">Active</a>
				<a @click="changeStatusType('archive')" 
				   :class="statusType == 'archive' ? 'active' : ''"
				   class="filter">Archive</a>
			</div>
		</div>
		<div class="fit-panel-body">
			<div class="row manager">
				<div class="columns large-6">
					<div class="fit-panel-filter">
						<a :class="type == 'manager' ? 'active' : ''"
						   class="filter"
						   @click="changeType('manager')">
						   <i class="fa fa-user"></i> Manager
						</a>
						<a :class="type == 'reception' ? 'active' : ''"
						   class="filter"
						   @click="changeType('reception')">
						   <i class="fa fa-user-plus"></i>Reception
						</a>
						<a :class="type == 'teacher' ? 'active' : ''"
						   class="filter"
						   @click="changeType('teacher')">
						   <i class="fa fa-male"></i> Teacher
						</a>
					</div>
				</div>
				<div class="columns large-6" style="text-align: right;">
					<label class="search-input">
						<input type="text" placeholder="You can search people..." v-model="searchText"/>
						<label @click="searchMember()">Search</label>
					</label>
					<a class="fit-official-btn">+ Request</a>
				</div>
			</div>
			<div class="row small-up-1 medium-up-2 large-up-3 large-collapse medium-collapse small-collapse">
			  <div class="column column-block">
			  		<member-card v-for="member in members" :member="member">
			  			
			  		</member-card>
			  </div>
			</div>
		</div>
	</div>
</template>

<script>
	import FilterAble from '../../mixins/Filterable'
	import MemberCard from '../../components/MemberCard.vue'

	export default {
		mixins : [FilterAble],

		props : {
			id : { 
				required: true,
			},

			isManager : {
				required: true,
			}
		},

		data() {
			return {
				members : [],
				memberType : {},
				searchText : '',
				statusType : {},
			}
		},

		created: function () {
			this.setStatusType()
			this.setType()
			this.getMembers()
		},

		methods : {
			setType : function () {
				this.type = this.getFilterValue('type', 'manager')
			},

			setStatusType : function () {
				this.status_type = this.getFilterValue('status_type', 'request')
			},

			changeType : function (type) {
				this.type = type
				this.getMembers()
			},

			changeStatusType : function (type) {
				this.status_type = type
				this.getMembers()
			},

			searchMember : function () {

			},

			getMembers : function () {

				this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/members?status_type=' + this.status_type + '&type=' + this.type).then(res => {
				   	this.members = res.data.result
				}).catch(err => {
				  	
				});
			}
		},

		components : {
			MemberCard
		}
	}
</script>

<style>
	
</style>