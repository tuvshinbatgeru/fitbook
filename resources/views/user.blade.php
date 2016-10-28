@extends('layouts.master-layout', ['currentView' => 'profile-view'])
@section('content')

<div class="row" style="margin-bottom: 10px; height: 280px;position: relative;background-image: url('{{asset('images/site/cove_photo.jpg')}}'); background-position: center 50%;background-size: 100% auto">
  <div class="small-9 text-center small-centered columns">
    <div class="hexagon" style="background-image: url('{{$user->avatar_url}}')">
      <div class="hexTop"></div>
      <div class="hexBottom"></div>
    </div>
		<!-- <img src="{{$user->avatar_url}}" style="width: 130px;
    height: 130px;
    border-radius: 180px; border: 4px solid #5fcf80;" /> -->
    <h5 style="color: #fff">
        {{$user->first_name}} {{$user->last_name}}
    </h5> 
	</div>
    @if($editable)
      <a href="{{$user->username}}/edit" class="button success" style="position: absolute;bottom: 20px; right:  20px;margin-bottom: 0px;">
        Edit Profile
      </a>
    @endif
</div>

<div class="row">
      <ul class="tabs" style="width: 100%;">
        <li class="tab col s3"><a @click="setSubMenu('user-home')" class="active">Home</a></li> 
        <li class="tab col s3"><a @click="setSubMenu('activity')">Activity</a></li>
      </ul>

	  <div class="large-12 small-centered columns">
      <component :id="{{$user->id}}" :is="submenu" keep-alive>
      
      </component>
    </div>
  </div>
@stop