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
		<div class="small-12 medium-2 column">
			<img src="{{$plan->pinnedPhotos[0]->url}}"/>
			<a @click="setSubscription(true)" class="button success">Subscription</a>
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
    <ul>
    	@foreach ($plan->comments as $comment)
		   <li style="font-size:12px;">
		   		<p>{{$comment->user_id}}</p>
		   		<div style="border: 1px solid #aecaec; padding: 10px;">
		   			{!! $comment->message !!}
		   		</div>
		   </li>
		@endforeach
    </ul>
    @if(Auth::check())  
    	<custom-comment :parent-id="{{$plan->id}}" parent-type="App\Plan">
	    </custom-comment>
    @endif
@stop