@extends('layouts.club-edit-layout', ['currentView' => 'club-edit-view'])
@section('content')

<section class="container" style="background-color:#ebeced !important;">
	<section class="sidebar" v-cloak>
		<ul class="setting-menu vertical menu" data-accordion-menu>
			<li>
				<a @click="setMenu('club-dashboard')">
					<i class="fa fa-dashboard"></i>
					<br/>
					@{{$t('dashboard')}}
				</a>
			</li>
			<li>
				<a>
					<i class="fa fa-users"></i>
					<br/>
					@{{$t('members')}}
				</a>
				<span class="success badge">@{{members_count}}</span>
				<ul class="menu vertical nested">
					<li>
						<a @click="setMenu('club-members')">
							<i class="fa fa-users"></i>
							<br/>
							@{{$t('members')}}
						</a>
					</li>
					<li>
						<a @click="setMenu('club-members')">
							<i class="fa fa-users"></i>
							<br/>
							@{{$t('members')}}
						</a>
					</li>
					<li>
						<a @click="setMenu('club-members')">
							<i class="fa fa-users"></i>
							<br/>
							@{{$t('members')}}
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a>
					<i class="fa fa-pencil-square-o"></i>
					<br/>
					@{{$t('registration')}}
				</a>
				<span class="secondary badge">@{{requests_count}}</span>
				<ul>
					<li>
						<a @click="setMenu('club-registration')">
							<i class="fa fa-pencil-square-o"></i>
							<br/>
							@{{$t('registration')}}
						</a>
					</li>
					<li>
						<a @click="setMenu('club-registration')">
							<i class="fa fa-pencil-square-o"></i>
							<br/>
							@{{$t('registration')}}
						</a>
					</li>
					<li>
						<a @click="setMenu('club-registration')">
							<i class="fa fa-pencil-square-o"></i>
							<br/>
							@{{$t('registration')}}
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a>
					<i class="fa fa-object-ungroup"></i>
					<br/>
					@{{$t('template')}}
				</a>
				<ul>
					<li>
						<a @click="setMenu('club-template')">
							<i class="fa fa-object-ungroup"></i>
							<br/>
							@{{$t('template')}}
						</a>
					</li>
					<li>
						<a @click="setMenu('club-template')">
							<i class="fa fa-object-ungroup"></i>
							<br/>
							@{{$t('template')}}
						</a>
					</li>
					<li>
						<a @click="setMenu('club-template')">
							<i class="fa fa-object-ungroup"></i>
							<br/>
							@{{$t('template')}}
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<section class="widget" style="margin-left:100px;">
			<component :clubid="clubid" 
					   :is="selectedMenu">
			</component>
		</section>
	</section>
	<section class="widget--container">
		<component 
			:id="clubid"
			:is="content">
		</component>
	</section>
</section>
@stop