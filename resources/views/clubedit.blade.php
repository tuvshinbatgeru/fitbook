@extends('layouts.club-edit-layout', ['currentView' => 'club-edit-view'])
@section('content')
<section class="container">
	<section class="sidebar">
		<menu class="setting-menu">
			<li>
				<a @click="setMenu('club-dashboard')">
					<i class="fa fa-dashboard"></i>
					<br/>
					@{{$t('dashboard')}}
				</a>
				<span class="secondary badge">2</span>
			</li>
			<li>
				<a @click="setMenu('club-members')">
					<i class="fa fa-users"></i>
					<br/>
					@{{$t('members')}}
				</a>
				<span class="success badge">@{{members_count}}</span>
			</li>
			<li>
				<a @click="setMenu('club-registration')">
					<i class="fa fa-pencil-square-o"></i>
					<br/>
					@{{$t('registration')}}
				</a>
				<span class="secondary badge">@{{requests_count}}</span>
			</li>
			<li>
				<a @click="setMenu('club-template')">
					<i class="fa fa-object-ungroup"></i>
					<br/>
					@{{$t('template')}}
				</a>
			</li>
		</menu>
		<section class="widget">

		</section>
	</section>
	<section class="widget-content">
		<component :clubid="clubid" :is="selectedMenu" >
				
		</component>
	</section>
</section>
@stop