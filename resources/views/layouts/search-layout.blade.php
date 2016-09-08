<!doctype html>
<html>
<head>
    <meta id="_token" value="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fitbook</title>
    @include('includes.header')    
</head>
<body>
    @if (isset($currentView))
       <component is="{{$currentView}}" inline-template>  
    @endif
            <div style="height:100%; ">
                @yield('content')
            </div>
    @if (isset($currentView))
        </component>
    @endif

    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>