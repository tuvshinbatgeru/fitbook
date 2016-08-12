<template>
	<div>
		<h3>Club Requests</h3>
		<p>
	      <label for="all">Both
	      	<input name="requestType" type="radio" value="0" id="all" v-model="requestType"/>
	      </label>
	    </p>
		<p>
	      <label for="teacher">Teacher
	      	<input name="requestType" type="radio" value="1" id="teacher" v-model="requestType"/>
	      </label>
	    </p>
	    <p>
	      <label for="trainer">Trainer
	      	<input name="requestType" type="radio" value="2" id="trainer" v-model="requestType"/>
	      </label>
	    </p>
	    <form>
	    	{{ csrf_field() }}
			<ul>
				<h3>{{requestType}}</h3>
				<li v-for="request in filteredRequests">
					{{request.username}}
					{{request.pivot.type}}
					<img src="{{request.avatar_url}}" height="20" width="20" />
					<a @click="acceptRequest(request)" class="button success">Accept</a>
					<a @click="rejectRequest(request)" class="button alert">Reject</a>
				</li>
			</ul>
		</form>
	<div>
</template>

<script>
	export default {
		props: { 
			clubid : {},
		},

		data() {
			return {
				requests : [],
				requestType : 0,
			}
		},

		created: function () {
			this.init();
		},

		methods : {
			init: function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/edit/' + this.clubid + '/request').then((response) => 
				{
					this.requests = response.data;
				}, (response) => {

				});	
			},

			acceptRequest : function ($request) {
				this.$http.put(this.$env.get('APP_URI') + 'api/club/edit/' + this.clubid + '/request/' + $request.id, {'roleType': $request.pivot.type, 'requestType': 'Accepted' }).then((response) => 
				{
					this.$dispatch('accept-request', $request);
					this.requests.$remove($request);
				}, (response) => {

				});	
			},

			rejectRequest : function ($request) {
				

				this.$http.put(this.$env.get('APP_URI') + 'api/club/edit/' + this.clubid + '/request/' + $request.id, {'roleType': $request.pivot.type, 'requestType': 'Rejected' }).then((response) => 
				{
					this.$dispatch('reject-request', $request);
					this.requests.$remove($request);
				}, (response) => {

				});	
			},			

			filterByRequestType : function (obj) {
				return this.requestType == 0 || obj.pivot.type == this.requestType;
			},
		},

		computed : {
			filteredRequests : function () {
		        return this.requests.filter(this.filterByRequestType);
		    },
 		},	
	}
</script>
	
<style>
</style>