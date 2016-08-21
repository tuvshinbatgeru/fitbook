<!doctype html>
<html>
<head>
    <meta id="_token" value="{{ csrf_token() }}"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    @include('includes.header')
</head>
<body class="nav-md">
    <div class="container body">
        <div class="small-12 medium-8 columns">
            @yield('content')
    	</div>
        </div>
    </div>
   <!-- FOR WIDGET ANIMATION -->
   <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/masonry.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/imagesloaded.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/classie.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/AnimOnScroll.js')}}"></script>
    <script>
        new AnimOnScroll( 
                document.getElementById( 'scrollAbleWizard' ),
                document.getElementById( 'grid' ), {
                    minDuration : 0.4,
                    maxDuration : 0.7,
                    viewportFactor : 0.2
                } );
    </script>
</body>
</html>