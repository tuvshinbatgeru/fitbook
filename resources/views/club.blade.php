@extends('layouts.default-layout')
@section('content')
	@foreach ($widget_content as $widget)
		<component id = "{{$id}}" is="{{$widget}}">
	          
	    </component>
    @endforeach
@stop