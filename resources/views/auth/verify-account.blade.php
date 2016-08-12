@extends('layouts.master-layout', ['currentView' => 'verify-view'])
@section('content')
  <div class="row">
    <form method="POST" action="/auth/activate">
      {{ csrf_field() }}
      <div class="row">
        <div class="large-12 columns">
          <label>
            <input name="username" id="username" type="text" value="{{$user->username}}" placeholder="Нэвтрэх нэр" />
          </label>
        </div>
        <div class="large-12 columns">
          <label>
            <input name="email" type="text" value="{{$user->email}}" placeholder="Нэвтрэх нэр" />
          </label>
        </div>
        <div class="large-12 columns">
          <label>
            <input name="birthday" type="text" value="{{$user->birthday}}" placeholder="Нэвтрэх нэр" />
          </label>
        </div>
        <div class="large-12 columns">
          <label>
            <input name="gender" type="text" value="{{$user->gender}}" placeholder="Нэвтрэх нэр" />
          </label>
        </div>
        <div class="large-12 columns">
          <label>
            <input name="socialite_id" type="text" value="{{$user->socialite_id}}" placeholder="Нэвтрэх нэр" />
          </label>
        </div>
        <div class="large-12 columns">
          <label>
            <input name="socialite_type" type="text" value="{{$user->socialite_type}}" placeholder="Нэвтрэх нэр" />
          </label>
        </div>
        <div class="large-12 columns">
          <label>
            <input name="avatar_url" type="text" value="{{$user->avatar_url}}" placeholder="Нэвтрэх нэр" />
          </label>
        </div>
        <a class="button" @click="checkUserAvailable">Шалгах</a>
        <button class="button">Бүртгүүлэх</button>
      </div>
    </form>
  </div>
@stop