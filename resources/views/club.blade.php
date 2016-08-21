@extends('layouts.default-layout')
@section('content')
	@foreach ($widget_content as $widget)
		<component id = "{{$id}}" is="{{$widget}}">
	          
	    </component>
    @endforeach

    <Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

    Үүний 85 орчим хувийг Япон улсаас импортолсон суудлын автомашин бүрдүүлж байна. Харин мөнгөн дүнгээр авч үзвэл, Японоос Монголыг чиглэх суудлын автомашины импорт жилийн өмнөхөөс найман сая орчим ам.доллараар өссөн байна. Мөн энэ төрлийн импортын 6.8 хувийг Герман, гурван хувийг БНСУ, 2.9 хувийг АНУ-аас нийлүүлжээ.
@stop