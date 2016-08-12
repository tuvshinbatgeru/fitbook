@extends('layouts.default-layout')
@section('content')
	@foreach ($widgets_content as $widget)
    	@include($widget)
    @endforeach
@stop