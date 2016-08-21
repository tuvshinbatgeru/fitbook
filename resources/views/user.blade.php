@extends('layouts.master-layout', ['currentView' => 'profile-view'])
@section('content')

<div style="height:100px; width:1000px; background-color:#aecaec;">
	what about now
</div>	
	<a href="{{$user->username}}/edit" class="button success">Edit Profile</a>

	<h1 style="font-size: 40px;">
		{{$user->first_name}} {{$user->last_name}}
	</h1>	
	<p>Flex Gym, Mongolia</p>

<img src="{{$user->avatar_url}}" style="width: 180px;
    height: 180px;
    border-radius: 180px; border: 4px solid #5fcf80;" />
@stop