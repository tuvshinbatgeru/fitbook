<!doctype html>
<html>
<head>
    <meta id="_token" value="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>fitbook</title>
    @include('includes.header')
</head>
<body>
    @if (Auth::check())
      @include('includes.main-header')
    @endif
    <custom-toast v-ref:toast></custom-toast>
    <component id = "{{$id}}" 
               is="club-view" 
               menu="{{$menu}}" 
               is-manager="{{$isOwner}}"
               inline-template>
      @yield('content')      
    </component>
   <!-- FOR WIDGET ANIMATION -->
   <script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>