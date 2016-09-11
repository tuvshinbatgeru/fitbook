@extends('layouts.club-layout')
@section('content')

	<custom-modal
		type = "Club"
		title = "Subscription"
		usage = "_subscription"
		:show = "showSubscription"
		context = "add-subscriptions">
	</custom-modal>

	<div class="row">
		<div class="small-12 medium-2 column">
			<img src="{{$plan->pinnedPhotos[0]->url}}"/>
			<a @click="showSubscription = true" class="button success">Subscription</a>
		</div>
		<div class="small-12 medium-5 column">
			<h4>{{$plan->name}}</h4>
		</div>
		<div class="small-12 medium-5 column">
			test
		</div>
	</div>
	<ul class="row" style="list-style-type: none;">
		@foreach ($plan->photos as $photo)
		   <li style="height:100px; width:100px; float: left;">
		   		<img src={{$photo->url}}/> 
		   </li>
		@endforeach
	</ul>
	<div class="row">
		<div class="small-12 medium-9 column">
			<p>
				{{$plan->description}}
			</p>
		</div>
		<div class="small-12 medium-3 column">
			<h3>Teachers</h3>
			<ul class="row">
				@foreach ($plan->teachers as $teacher)
				   <li>
				   		<p>{{$teacher->username}}</p>
				   		<img style="height:24px; width:24px;" src={{$teacher->avatar_ul}}/> 
				   </li>
				@endforeach
			</ul>
		</div>
	</div>
    Plan widgets coming soon...
@stop