<!doctype html>
<html>
<head>
    <meta id="_token" value="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fitbook</title>
    @include('includes.header')
</head>
<body>
    @include('includes.main-header')
	@if (isset($currentView))
        <component is="{{$currentView}}" inline-template>  
    @endif
	   @yield('content')
	@if (isset($currentView))
    	</component>
    @endif
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.steps.min.js')}}"></script>
    <script src="{{asset('js/foundation.min.js')}}"></script>
    <script src="{{asset('js/velocity.min.js')}}"></script>
    <script src="{{asset('js/buttons.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>