@extends('layouts.default-layout')
@section('content')
	@foreach ($widget_content as $widget)
    	@include($widget)
    @endforeach
@stop