<!doctype html>
<html>
<head>
    <meta id="_token" value="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    @include('includes.header')
    <link rel="stylesheet" type="text/css" href="{{asset('css/widget/hw-default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/widget/cw-d
    efault.css')}}">
</head>
<body>
    <div class="container body">
      <div>
        <component clubid = "{{$club->id}}" is="club-edit-view" inline-template>
          @yield('content')      
        </component>
    	</div>
      <div>
    	</div>
    </div>
   <!-- FOR WIDGET ANIMATION -->
   <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
   <script type="text/javascript" src="{{asset('js/jquery.tokenize.js')}}"></script>
   <script type="text/javascript" src="{{asset('js/foundation.min.js')}}"></script>
   <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>