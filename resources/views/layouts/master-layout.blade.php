<!doctype html>
<html>
<head>
    <meta id="_token" value="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fitbook</title>
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    @include('includes.header')
</head>
<body>
    
    @if (Auth::check())
      @include('includes.main-header')
    @endif

  	@if (isset($currentView))
        <component :user="{{$user}}" 
                   is="{{$currentView}}" 
                   inline-template>
      @endif
  	   @yield('content')
  	@if (isset($currentView))
      	</component>
    @endif

    <script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>