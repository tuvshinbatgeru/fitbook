@extends('layouts.master-layout', ['currentView' => 'index-view', 'user' => null])
@section('content')
		
<header>
	<div class="top-bar" style="background:white;">
		<div class="top-bar-left">
			<ul class="menu">
				<li><a href="#">One</a></li>
				<li><a href="#">Two</a></li>
				<li><a href="#">Three</a></li>
				<li><a href="#">Four</a></li>
			</ul>
		</div>
		<div class="top-bar-right">
			<ul class="menu">
			<li><input type="search" placeholder="Search"></li>
			<li><button type="button" class="button">Search</button></li>
			</ul>
		</div>
	</div>
	 
	<div class="title-bar" data-responsive-toggle="main-menu" data-hide-for="medium">
		<button class="menu-icon" type="button" data-toggle>
		</button>
		<div class="title-bar-title">Menu</div>
	</div>
</header>

<button class="button" type="button" data-toggle="example-dropdown2">Top Aligned</button>

<div class="dropdown-pane top" id="example-dropdown2" data-dropdown>
  Just some junk that needs to be said. Or not. Your choice.
</div>

<br>
<div class="row column">
<h4 style="margin: 0;" class="text-center">BREAKING NEWS</h4>
</div>
<hr>
<div class="row small-up-3 medium-up-4 large-up-5">
@if(Auth::check())
	@foreach (Auth::user()->photos as $photo)
		<div class="column">
			<img style="height:100%; width:100%;" src={{$photo->image}}>	
		</div>
	@endforeach
@endif
</div>
<hr>
<div class="row column">
<h4 style="margin: 0;" class="text-center">LATEST STORIES</h4>
</div>
<hr>
<div class="row">
<div class="large-8 columns" style="border-right: 1px solid #E3E5E8;">
<article>
<div class="large-6 columns">
<h5><a href="#">'Death Star' Vaporizes Its Own Planet</a></h5>
<p>
<span><i class="fi-torso"> By Thadeus &nbsp;&nbsp;</i></span>
<span><i class="fi-calendar"> 11/23/16 &nbsp;&nbsp;</i></span>
<span><i class="fi-comments"> 6 comments</i></span>
</p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae impedit beatae, ipsum delectus aperiam nesciunt magni facilis ullam.</p>
</div>
</div>
<hr>

	
	<div>
		<div class="input-field" style="margin-left: 100px; margin-top: 50px; width:300px;">
			<label>Name
				<input id="last_name" type="text" placeholder="fill the last name of you">	
			</label>
			<p class="help-text" id="last_name">Your password must have at least 10 characters, a number, and an Emoji.</p>
	    </div>

	    <p>
		...clearing away the brambles with the
		<span data-tooltip aria-haspopup="true" class="has-tip top" data-disable-hover="false" tabindex="2" title="A tool used for cutting crops.">scythe.</span>
		At the spot thus attained a second peg was driven, and about this, as a centre, a rude circle, about four feet in diameter, described. Taking now a spade himself, and giving one to Jupiter and one to me, Legrand begged us to set about one to digging as quickly as possible.
		</p>

		<h3>Та өөрийн хүссэн зүйлсээ хийх боломжтой</h3>
		About this font family
		@foreach (['danger', 'warning', 'success', 'info'] as $msg)
	      @if(Session::has('alert-' . $msg))
	        <p class="alert alert-{{ $msg }} " role = "alert">{{ Session::get('alert-' . $msg) }} 
	          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	        </p>
	      @endif
	    @endforeach
		@if(Auth::check())
			<form method="GET" action="/auth/logout">
				<h2>{{Auth::user()->username}}</h2>
				<img src="{{Auth::user()->avatar_url}}" height="100" width="100" />
				<h3>{{Auth::user()->birthday}}</h3>
				<h3>{{Auth::user()->gender}}</h3>
				<button class="button">Logout</button>

				@foreach (Auth::user()->photos as $photo)
				    <img height=100 width=100 src = {{$photo->image}}>
				@endforeach
			</form>
		@else
		<div class="header-container">
			<form method="POST" action="/auth/login">
				{{ csrf_field() }}
				<label>Name
					<input type="text" name="username" placeholder="Login user name" autocomplete="off">	
				</label>
				<label>Password
					<input type="password" name="password" placeholder="Type password" autocomplete="off" />
				</label>

				<p>
			      	<input type="checkbox" id="filled-in-box"/>
			      	<label for="filled-in-box">Remember me</label>
			    </p>
				<div class="login-item"><a class="button btn-fb btn-1 btn-success">Login as</a></div>
				<div class="login-item"><a class="dropdown button arrow-only btn-fb btn-2 btn-success" type="button" data-toggle="example-dropdown" data-options="align:down">
				    <span class="show-for-sr">Show menu</span>
				</a></div>

				<ul id="example-dropdown" class="f-dropdown dropdown-pane dropdown-menu" data-dropdown>
					<li><a><i class="fa fa-facebook-official"></i>  Facebook</a></li>
					<li><a><i class="fa fa-google-plus"></i>  Google</a></li>
				</ul>
				<div class="login-item"><a class="button btn-fb">Forgot Password</a></div>
				<a href="/login/facebook" class="button btn-fb">login as facebook</a>
				<a href="/login/google" class="button btn-fb">login as gmail</a>
				<button class="button">Login</button>
			</form>
		</div>
		@endif
	</div>

    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a href="/search" class="btn-floating red" style="width: 55.5px; height: 55.5px;">
            <i style="line-height: 55.5px;" class="fa fa-cog"></i>
    </a>
    <ul style="padding: 0;
    list-style-type: none;">
            <li><a class="btn-floating red" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="fa fa-cloud"></i></a></li>
            <li><a class="btn-floating yellow darken-1" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="fa fa-gift"></i></a></li>
            <li><a class="btn-floating green" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="fa fa-info"></i></a></li>
            <li><a class="btn-floating blue" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="fa fa-music"></i></a></li>
          </ul>
  </div>

  <p>@{{ $t("message.hello") }}</p>
  <p>@{{ $t("message.format.named") }}</p>
  
@stop