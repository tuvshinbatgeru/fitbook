@extends('layouts.main-layout')
@section('content')
	<component :club-id="{{$club->id}}" 
               is="reception-dashboard-view" 
               inline-template>

		<h1>{{$club->short_name}}</h1>

		<h3>Online members</h3>
		<div class="row" v-for="user in onlineUsers">
			<img :src="@{{user.avatar_url}}" />
			<p>@{{user.first_name}}</p>
			<p>@{{user.last_name}}</p>
			<span>@{{ user.pivot.start_time | moment "from" }}</span>
			<button @click="getOutUser(user)" class="fa fa-sign-out button success"></button>
		</div>


		<div class="row">
			<multiselect 
		    	:options="users" 
		    	:selected="user" 
		    	:multiple="false"
		    	select-label='сонгох'
		    	selected-label='сонгосон'	
		    	deselect-label='устгах'
		    	label="username"
		    	key="id" 
		    	id="user"
		    	:loading="userLoading",
		    	@search-change="userSearch",
		    	@update="setUser",
		    	placeholder="хайх ...">
		    		<span slot="noResult">Илэрц алга ...</span>
		  	</multiselect>
		</div>

		<custom-callout 
		  :loading.sync="userCalloutLoading"
		  :blank.sync="userCalloutBlank">

			<h5>@{{user.username}}</h5>
			<p>@{{user.first_name}}</p>
			<p>@{{user.last_name}}</p>

			<div class="row small-up-2 medium-up-3">
				<div class="columns" v-for="plan in plans">
					@{{plan.name}}
					@{{plan.description}}
					<label>@{{plan.pivot.begin_date}}</label>-
					<label>@{{plan.pivot.end_date}}</label>
					<button @click="getInUser(plan.pivot.id)" class="fa fa-sign-in button success"></button>	
				</div>
			</div>
		</custom-callout>

	</component>
@stop