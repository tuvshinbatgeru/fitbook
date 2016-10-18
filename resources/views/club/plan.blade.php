@extends('layouts.club-layout')
@section('content')

	<custom-modal
		:id = "1"
		type = "Club"
		title = "Subscription"
		usage = "_subscription"
		:show.sync = "showSubscription"
		save-callback = "saveSubscription"
		validateable = 'Y'>
		<div slot="body">
			<components v-ref:context :club-id="1" is="add-subscriptions">
					
			</components>
		</div>
	</custom-modal>

	<div class="row">
		<div class="small-12 column">
			<img src="{{$plan->pinnedPhotos[0]->url}}"/>
			<a @click="setSubscription(true)" class="button success">Subscription</a>
		</div>
		<div class="small-12 column">
			<h4>{{$plan->name}}</h4>
		</div>
		<div class="small-12 column">
			<a href="#7">magellon test</a>
		</div>
	</div>
	<ul class="row" style="list-style-type: none;">
		@foreach ($plan->photos as $photo)
		   <li style="height:50px; width:50px; float: left;">
		   		<img src={{$photo->url}}/> 
		   </li>
		@endforeach
	</ul>
	<br>
	<div class="row">
		<a @click="toggleHearth()">Hearth</a>
		<div @click="toggleHearth()" class="heart"></div>
		<p class="font-weight:bold;">@{{plan.hearth_count}}</p>
	</div>
	<div class="row">
		<div class="small-12 medium-9 column">
			<p>
				{!!$plan->description!!}
			</p>
		</div>
		<div class="small-12 medium-3 column">
			<h3>Teachers</h3>
			<ul class="row">
				@foreach ($plan->teachers as $teacher)
				   <li>
				   		<p>{{$teacher->username}}</p>`
				   		<img style="height:24px; width:24px;" src={{$teacher->avatar_url}}/> 
				   </li>
				@endforeach
			</ul>
		</div>
	</div>
    <div class="row text-center">
    	<a @click="showComments = true">COMMENTS - {{$plan->comments()->count()}}</a>
    </div>

    <component id="{{$plan->id}}" 
    			is="comments-list"
    			logged-user="{{Auth::check() ? Auth::user() : null}}"
    			v-if="showComments">
    </component>

    @if(Auth::check())  
    	<custom-comment :parent-id="{{$plan->id}}" 
    					parent-type="App\Plan"
    					:save-button="true">
	    </custom-comment>
    @endif
@stop