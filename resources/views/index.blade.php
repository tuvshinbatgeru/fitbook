@extends('layouts.master-layout', ['currentView' => 'index-view', 'user' => null])
@section('content')
<section>
	<!-- Navigation Panel -->
	<nav class="main-nav dark stick-fixed js-transparent small-height">
                <div class="full-wrapper relative clearfix">
                    <!-- Logo ( * your text or image into link tag *) -->
                    <div class="nav-logo-wrap local-scroll">
                        <a href="mp-index.html" class="logo small-height">
                            <img src="{{asset('images/site/fitbook_logo.png')}}" height="55" />
                        </a>
                    </div>
                    <div id="mobile-nav" class="mobile-nav small-height"  onclick="toggleMenu()"
                    	style="height: 75px; line-height: 75px; width: 75px;">
                        <i class="fa fa-bars"></i>
                    </div>
                    
                    <!-- Main Menu -->
                    <div id="inner-nav" class="inner-nav desktop-nav">
                        <ul class="clearlist local-scroll">
                            
                            <!-- Item With Sub -->
                            <li>
                                <a href="#" class="mn-has-sub active" style="height: 75px; line-height: 75px;">Our us</a>
                            </li>
                            <!-- End Item With Sub -->
                            
                            <!-- Item With Sub -->
                            <li>
                                <a href="#" class="mn-has-sub" style="height: 75px; line-height: 75px;">Blog </a>
                            </li>
                            <!-- End Item With Sub -->
                            
                            <!-- Item With Sub -->
                            <li>
                                <a href="#" class="mn-has-sub" style="height: 75px; line-height: 75px;">Member ship </a>
                            </li>
                            <!-- End Item With Sub -->
                            
                            <!-- Item With Sub -->
                            <li>
                                <a href="#" class="mn-has-sub" style="height: 75px; line-height: 75px;">Contact </a>
                            </li>
                            <!-- End Item With Sub -->
                            
                            <!-- Divider -->
                            <li>
                            <a style="height: 75px; line-height: 75px;">&nbsp;</a></li>
                            <!-- End Divider -->
                            
                            <!-- Button -->
                            <li>
                                <a target="_blank" style="height: 75px; line-height: 75px;"><span class="btn btn-mod btn-circle btn-border-w">Login</span></a>
                            </li>
                            <!-- End Button -->
                            
                         </ul>
                    </div>
                    <!-- End Main Menu -->
                </div>
            </nav>
	<!-- Navigation Panel end -->


</section>		
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
	    <a href="/search" class="btn-floating red" style="width: 55.5px; height: 55.5px;">
	            <i style="line-height: 55.5px;" class="fa fa-cog"></i>
	    </a>
	    <ul style="padding: 0;list-style-type: none;">
            <li>
            	<a class="btn-floating red" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="fa fa-cloud"></i></a>
            </li>
            <li>
            	<a class="btn-floating yellow darken-1" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="fa fa-gift"></i></a>
            </li>
            <li>
            	<a class="btn-floating green" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="fa fa-info"></i></a>
            </li>
            <li>
            	<a class="btn-floating blue" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px) translateX(0px); opacity: 0;"><i class="fa fa-music"></i></a>
            </li>
        </ul>
  </div>
  <script>
  	var toggleMenu = function(){	
  		$('#inner-nav').toggle("slow");
  	};
  </script>
@stop