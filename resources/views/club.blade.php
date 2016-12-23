@extends('layouts.default-layout')
@section('content')
    
    <div class="site-body">
	    <component :id="id" 
	    		   :menu="menu" 
	    		   is="header-default"
	    		   @menu-changed="menuChanged">
	          
	    </component>

	    @if(isset($filters)) 
			<component id="{{$id}}" 
				   	   :filters="{{$filters}}"
				   	   :is-manager="isManager"
				       :is="content">

		@else
			<component id="{{$id}}" 
				       :is="content">
		@endif
	    	</component>
	</div>
@stop