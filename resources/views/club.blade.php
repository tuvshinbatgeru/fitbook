@extends('layouts.default-layout')
@section('content')
    
    <div class="site-body">
	    <component id = "{{$id}}" is="{{$widget_header}}">
	          
	    </component>

		@foreach ($widget_content as $widget)
			<component id = "{{$id}}" is="{{$widget}}">
		          
		    </component>
	    @endforeach
	</div>
@stop