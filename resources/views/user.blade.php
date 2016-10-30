@extends('layouts.master-layout', ['currentView' => 'profile-view'])
@section('content')

<custom-modal
    title = "Following"
    usage = "_following"
    :show.sync = "showFollowing">
    <div slot="body">
      <user-following user-id="{{$user->id}}" @toggle="toggleFollow">
        
      </user-following>
    </div>
</custom-modal>

<div class="row" style="margin-bottom: 10px;">
  <div class="user-cover">
    <img src="{{asset('images/site/cove_photo.jpg')}}" class="cover-photo"/>
    <div class="user-profile-picture">
        <div class="hexagon" style="background-image: url('{{$user->avatar_url}}')">
          <div class="hexTop"></div>
          <div class="hexBottom"></div>
        </div>
        <div class="user-profile-name">
          <span class="name">
          {{$user->first_name}}
          </span>
          <br/>
          <span class="role">
          Flex Gym - Manager
          </span>
        </div>
    	</div>
    <div class="cover-buttons">
      <a @click="showFollowing = true" class="cover-button">
        @{{following_count}} following
      </a>
      @if($editable)
        <a class="cover-button">
          <i class="fa fa-edit"></i> Following
        </a>
        <a class="cover-button">
          <i class="fa fa-edit"></i> Change cover
        </a>
        <a href="{{$user->username}}/edit" class="cover-button">
          Edit Profile
        </a>
      @endif
    </div>
  </div>
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