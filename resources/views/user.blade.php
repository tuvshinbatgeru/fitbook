@extends('layouts.master-layout', ['currentView' => 'profile-view'])
@section('content')

<div class="row">
	<div class="small-9 small-centered text-center large-centered columns">
		<h1 style="font-size: 40px;">
				{{$user->first_name}} {{$user->last_name}}
		</h1>	
		@if($editable)
			<a href="{{$user->username}}/edit" class="button success">Edit Profile</a>
		@endif
	</div>
</div>
<div class="row">
  	<div class="small-9 text-center small-centered columns">
  		<img src="{{$user->avatar_url}}" style="width: 180px;
	    height: 180px;
	    border-radius: 180px; border: 4px solid #5fcf80;" />
	</div>
</div>

<div class="row">
    <div class="small-9 text-center small-centered columns">
      <ul class="tabs">
        <li class="tab col s3"><a @click="setSubMenu('user-home')" class="active">Home</a></li>    
        <li class="tab col s3"><a @click="setSubMenu('trent')">Trenting</a></li>    
        <li class="tab col s3"><a @click="setSubMenu('activity')">Activity</a></li>
        <li class="tab col s3"><a @click="setSubMenu('timeline')">Timeline</a></li>
        <li class="tab col s3"><a @click="setSubMenu('followed')">Follow</a></li>
      </ul>
    </div>

	  <div class="small-9 text-center small-centered columns">
      <component :id="{{$user->id}}" :is="submenu">
      
      </component>
    </div>    

    <div class="small-9 text-center small-centered columns">
      
    </div>
  </div>
@stop