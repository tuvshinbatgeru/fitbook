@extends('layouts.club-edit-layout', ['currentView' => 'club-edit-view'])
@section('content')
	<div>
		<button class="button hollow" @click="setMenu('club-dashboard')">@{{$t('dashboard')}}
		<span class="secondary badge">2</span>
		</button>
		<button class="success hollow button" @click="setMenu('club-members')">
			@{{$t('members')}}
			<span class="success badge">@{{members_count}}</span>
		</button>
		<button class="secondary hollow button" @click="setMenu('club-registration')">
			@{{$t('registration')}}
			<span class="secondary badge">@{{requests_count}}</span>
		</button>
		<button class="warning hollow button" @click="setMenu('club-plan')">
			Plan
			<span class="warning badge">@{{requests_count}}</span>
		</button>

		<button class="warning hollow button" @click="setMenu('club-template')">
			@{{$t('template')}}
		</button>

		<component :clubid="clubid" :is="selectedMenu">
			
		</component>
	</div>
@stop