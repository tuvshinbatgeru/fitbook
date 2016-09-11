@extends('layouts.default-layout')
@section('content')
    
    <component id = "{{$id}}" is="{{$widget_header}}">
          
    </component>

	@foreach ($widget_content as $widget)
		<component id = "{{$id}}" is="{{$widget}}">
	          
	    </component>
    @endforeach
    
@stop