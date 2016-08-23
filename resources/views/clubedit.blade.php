@extends('layouts.club-edit-layout', ['currentView' => 'club-edit-view'])
@section('content')
	<div>
		<button class="button hollow" @click="setMenu('club-dashboard')">Dashboard
		<span class="secondary badge">2</span>
		</button>
		<button class="success hollow button" @click="setMenu('club-members')">
			Members
			<span class="success badge">@{{members_count}}</span>
		</button>
		<button class="alert hollow button" @click="setMenu('club-requests')">
			Requests
			<span class="alert badge">@{{requests_count}}</span>
		</button>
		<button class="secondary hollow button" @click="setMenu('club-training')">
			Training
			<span class="secondary badge">@{{requests_count}}</span>
		</button>
		<button class="warning hollow button" @click="setMenu('club-plan')">
			Plan
			<span class="warning badge">@{{requests_count}}</span>
		</button>

		<button class="warning hollow button" @click="setMenu('club-template')">
			Template
		</button>

		<component :clubid="clubid" :is="selectedMenu">
			
		</component>
	</div>
@stop