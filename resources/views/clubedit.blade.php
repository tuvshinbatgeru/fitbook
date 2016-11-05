@extends('layouts.club-edit-layout', ['currentView' => 'club-edit-view'])
@section('content')

<section class="row" style="background-color: #fff!important; min-height: 100%;">
	<div class="large-12 columns info-bar">
		<div class="row">
			<div class="large-12 columns">
				<a class="menu-navicon">
					<i class="fa fa-navicon"></i>
				</a>
				<span class="menu-title">
					Dashboard
				</span>
				<div class="info">
					<span class="seperator">
					</span>
					<span class="weather">
						Weather +14
					</span>
					<br/>
					<span class="date">
						October, Tuesday, 26
					</span> 

				</div>
			</div>
		</div>
	</div>
	<section class="sidebar large-1 medium-2 columns" v-cloak>
		<ul class="setting-menu vertical menu" data-accordion-menu>
			<li>
				<a @click="setMenu('club-dashboard')">
					<i class="fa fa-dashboard"></i>
					<br/>
					@{{$t('dashboard')}}
				</a>
			</li>
			<li>
				<a @click="setMenu('all-members')">
					<i class="fa fa-users"></i>
					<br/>
					@{{$t('members')}}
				</a>
				<span class="success badge">@{{members_count}}</span>
			</li>
			<li>
				<a>
					<i class="fa fa-pencil-square-o"></i>
					<br/>
					@{{$t('registration')}}
				</a>
				<span class="secondary badge">@{{requests_count}}</span>
				<ul class="menu vertical nested">
					<li>
						<a @click="setMenu('plan-panel')">
							<i class="fa fa-pencil-square-o"></i>
							<br/>
							@{{$t('plan')}}
						</a>
					</li>
					<li>
						<a @click="setMenu('training-panel')">
							<i class="fa fa-pencil-square-o"></i>
							<br/>
							@{{$t('training')}}
						</a>
					</li>
					<li>
						<a @click="setMenu('service-panel')">
							<i class="fa fa-pencil-square-o"></i>
							<br/>
							@{{$t('service')}}
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a @click="setWithSubMenu('club-template')">
					<i class="fa fa-object-ungroup"></i>
					<br/>
					@{{$t('template')}}
				</a>
			</li>
		</ul>
		{{-- <section class="widget" style="margin-left:100px;">
			<component :clubid="clubid" 
					   :is="selectedMenu">
			</component>
		</section> --}}
	</section>
	<section class="large-11 medium-10 columns">
		<div class="widget-content float-center">
			<div class="content--container float-center">
				<component v-if="content == 'all-members'"
					:id="clubid"
					:member-type.sync="subMenu"
					:is="content">
				</component>

				<component v-else
					:id="clubid"
					:is="content">
					
				</component>
			</div>
		</div>
	</section>
</section>
@stop