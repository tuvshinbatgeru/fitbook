<!doctype html>
<html>
<head>
    <meta id="_token" value="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    @include('includes.header')
    <link rel="stylesheet" type="text/css" href="{{asset('css/widget/hw-default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/widget/cw-default.css')}}">
</head>
<body>

    <custom-toast v-ref:toast></custom-toast>

    <component is="plan-view" inline-template>
        @yield('content')      
    </component>  

   <!-- FOR WIDGET ANIMATION -->
   <script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>