@extends('layouts.search-layout', ['currentView' => 'search-view'])
@section('content')
	<div>
		<search-tooltip v-ref:tooltip :club="">
			
		</search-tooltip>
	</div>
	<div id="omnibox" class="vasquette-margin-enabled" style="text-align: left; position: fixed;">
		<div class="searchbox-hamburger-container">
			<button class="searchbox-hamburger"></button>
		</div>
		<div id="searchbox" class="searchbox searchbox-shadow noprint directions-button-shown searchbox-empty suggestions-shown">
			<div style="position:relative;">
				<form>
					<input id="typeahead" placeholder="Клуб, Багш газрын зургаас хайх" class="tactile-searchbox-input searchbox-input" style="background: url(&quot;data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw%3D%3D&quot;) transparent;">
				</form>
			</div>
			<div class="searchbox-searchbutton-container">
				<button @click="search" class="searchbox-searchbutton"></button>
			</div>
			<div class="searchbox-findme">
				<button data-tooltip aria-haspopup="true" class="has-tip round find-mylocation" id="drop" title="Таны байршил" @click="findMe">
			      <i style="line-height: inherit; height:24px; width:24px; color: #aeaeae;" class="fa fa-location-arrow" aria-hidden="true"></i>
			    </button>
			    <!-- <button onclick="resetSearch()" class="reset-button hide"></button>-->
			    <button class="reset-button hide"></button> 
		    </div>
		</div>
	</div>
	<div class="pane">
		<div class="pane-holder">
			<div style="pane-holder-small">
				<div class="pane-header" style="background-image: url({{ URL::asset('images/flexgym/08.jpg')}}); background-size: cover;">
					<a style="top:100px;" class="button success" href="/flexgym"></a>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
				<div class="pane-content">
					<h1>Flex gym</h1>
					<p>4.45 сэтгэгдэл</p>
				</div>
			</div>
		</div>
	</div>
	<div id="map" style="height: 100%;">
	</div>
	<h4 style="position:absolute; z-index:999; top: 100px; left: 10px;">
	radius = @{{searchOptions.userCircleDetector}}</h4>
	<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
@stop