@extends('layouts.master-layout', [
	'currentView' => 'profile-edit-view',
	'user' => Auth::user()
	])

@section('content')


<custom-modal 
	:id = "{{$user->id}}" 
	type = "User"
	title ="Photo chooser" 
	usage = "_photo-chooser" 
	:show.sync = "showFileManager"
	save-callback = "chooseAvatar"
	context = "fileManager">
</custom-modal>


<form method="POST">

	<div style="height:100px; width:1000px; background-color:#aecaec;">
		what about now
	</div>	

	<div class="row">
		<div class="small-9 small-centered text-center large-centered columns">
			<input type="text" name="firstname" v-model="user.first_name">	
			<input type="text" name="lastname" v-model="user.last_name">	
			<p>Flex Gym, Mongolia</p>
		</div>
	</div>
	
	<div class="row">
		<div class="small-9 small-centered text-center large-centered columns">

			<button @click="uploadAvatar($event)" style="position:relative; height: 168px; width: 168px; ">
			    <img v-bind:src="user.avatar_url" style="width: 168px;
			    	height: 168px;
			    	position: absolute;
			    	top: 0;
			    	z-index: 1;
			    	left: 0;
			    	border-radius: 168px; border: 4px solid #5fcf80;" />
				
				<i class="fa fa-camera" style="position: absolute; 
				color:white; 
				font-size: 24px;
				left: 42%; 
				top : 80%; 
				z-index:2;">
			    </i>
			</button>
		</div>
	</div>

	<div class="row">
		<div class="small-9 small-centered text-center large-centered columns">
			<button class="button success" type="submit">Update</button>
		</div>
	</div>
</form>

@stop