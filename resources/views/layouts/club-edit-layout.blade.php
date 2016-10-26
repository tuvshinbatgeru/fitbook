<!doctype html>
<html>
<head>
    <meta id="_token" value="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">

    @include('includes.header')
</head>
<body class="admin-body">
    @include('includes.main-header')
    <custom-toast v-ref:toast></custom-toast>
    <div class="site-body container">
    <component clubid = "{{$club->id}}" is="club-edit-view" inline-template>
      @yield('content')      
    </component>
    </div>
   <!-- FOR WIDGET ANIMATION -->
    <script src="{{ elixir('js/app.js') }}">
      
    </script>
</body>
</html>