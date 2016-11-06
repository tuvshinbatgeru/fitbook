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

<custom-modal 
    title ="Cover" 
    usage = "_cover-chooser" 
    :show.sync = "showCoverPhoto"
    save-callback = "chooseCover">
    <div slot="body">
      <component 
        v-ref:context 
        is="file-manager"
      ></component>
    </div>
</custom-modal>

<div class="row">  
  <div class="user-cover">

    <custom-cropper ratio="4.1785" 
                    mobile-ratio="1"
                    tablet-ratio="2"
                    :editable.sync="editCover"
                    v-ref:coverCropper
                    :image.sync="coverPhoto">
    </custom-cropper>
    <div class="gradient-cover black-gardient" v-show="!editCover">
    </div>
    
    <div class="user-info">
      <div class="user-profile-picture" v-show="!editCover">
        <svg version="1.1" style="margin: 0 auto; display: block; width: 180px;" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <pattern id="image-bg" patternUnits="userSpaceOnUse" width="100%" height="100%">
                <image preserveAspectRatio="none" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="{{$user->avatar_url}}" width="100%" height="100%"></image>
            </pattern>
            <filter id="dropshadow" height="130%">
              <feGaussianBlur in="SourceAlpha" stdDeviation="3"/> 
              <feOffset dx="0" dy="0" result="offsetblur"/>
              <feComponentTransfer>
                <feFuncA type="linear" slope="0.2"/>
              </feComponentTransfer>
              <feMerge> 
                <feMergeNode/>
                <feMergeNode in="SourceGraphic"/> 
              </feMerge>
            </filter>
            <linearGradient id="linear" x1="0%" y1="0%" x2="0%" y2="100%">
              <stop offset="0%"   stop-color="#fff"/>
              <stop offset="100%" stop-color="#afafaf"/>
            </linearGradient>
          </defs>
          <g transform="translate(10, 5)">
              <custom-hexagon
                bg-color="url('#image-bg')" 
                filter-id="url('#dropshadow')"
                border-color="url('#linear')"
                :border-width="5"
                :length="80" 
                :cord-x="0" 
                :cord-y="0">
              </custom-hexagon>
          </g>
        </svg>
        <div class="user-name">
          <span class="name">
          <span>@</span>{{$user->username}}
            </span>
        </div>
      </div>
      <div class="user-followers">
        <a @click="showFollowing = true">
          <span>@{{following_count}} </span> following
        </a>
        <a @click="showFollowing = true" style="margin-left: 20px;">
          <span>@{{following_count}} </span> followers
        </a>
      </div>
      <div class="user-follow">
        <a class="follow-button">
          <i class="fa fa-blind"></i> Follow
        </a>
      </div>
      <div class="tabs-container">
        <ul class="user-tab">
          <li class="tab col s3"><a @click="setSubMenu('user-home')" class="active">Home</a></li> 
          <li class="tab col s3"><a @click="setSubMenu('activity')">Activity</a></li>
        </ul>
      </div>
    </div>

    <div class="edit-cover">
      <div class="cover-buttons" v-show="editCover">
        <a @click="cancelCoverChange()" class="cover-button">Cancel</a>
        <a @click="saveCoverChange()" class="cover-button">Save</a>
      </div>
      <div class="cover-buttons" v-show="!editCover">   
        @if($user->editable)
          <a @click="changeCover()" class="cover-button">
            <i class="fa fa-edit"></i> Change cover
          </a>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row">
	  <div class="large-12 small-centered columns">
      <component :id="{{$user->id}}" :is="submenu">
      
      </component>
    </div>
  </div>
@stop