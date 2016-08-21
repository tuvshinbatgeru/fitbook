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
    <div class="container body">
      <component clubid = "{{$id}}" is="{{$widget_header}}">
          
      </component>
      <div>
    		@yield('content')
    	</div>
      <div>
        
    	</div>
    </div>
   <!-- FOR WIDGET ANIMATION -->
   <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
   <script type="text/javascript" src="{{asset('js/foundation.min.js')}}"></script>
   <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>