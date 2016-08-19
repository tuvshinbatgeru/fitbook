<!doctype html>
<html>
<head>
    <meta id="_token" value="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    @include('includes.header')
</head>
<body>
    <custom-toast v-ref:toast></custom-toast>
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
   <script src="{{asset('js/vendor/jquery.ui.widget.js')}}"></script>
   <script src="{{asset('js/jquery.fileupload.js')}}"></script>
   <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>