@extends('layouts.club-edit-layout', ['currentView' => 'club-edit-view'])
@section('content')
	<div>
		<button class="button hollow" @click="setMenu('club-dashboard')">Dashboard
		<span class="secondary badge">2</span>
		</button>
		<button class="success hollow button radius" @click="setMenu('club-members')">
			Members
			<span class="success badge">@{{members_count}}</span>
		</button>
		<button class="alert hollow button radius" @click="setMenu('club-requests')">
			Requests
			<span class="alert badge">@{{requests_count}}</span>
		</button>
		<button class="secondary hollow button radius" @click="setMenu('club-training')">
			Training
			<span class="secondary badge">@{{requests_count}}</span>
		</button>
		<button class="warning hollow button radius" @click="setMenu('club-loyalty')">
			Loyalty
			<span class="warning badge">@{{requests_count}}</span>
		</button>

		<autocomplete></autocomplete>

		<component :clubid="clubid" :is="selectedMenu">
			
		</component>

		<!-- Triggers the modals -->
		<a href="#" data-open="fileManager" class="radius button">FileManager</a>
		<!-- Reveal Modals begin -->
		<div class="reveal" id="fileManager" data-reveal data-animation-in="slide-in-up" data-animation-out="slide-out-down">
		  <h1>File Management</h1>
		  
		  <button class="close-button" data-close aria-label="Close modal" type="button">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	</div>
@stop