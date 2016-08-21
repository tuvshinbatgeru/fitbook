@extends('layouts.master-layout', ['currentView' => 'verify-view'])
@section('content')
  <div class="row">
    <form method="POST" action="/auth/login" style="margin-top:100px;">
        {{ csrf_field() }}
        <label>Name
          <input type="text" name="username" placeholder="Login user name" autocomplete="off">  
        </label>
        <label>Password
          <input type="password" name="password" placeholder="Type password" autocomplete="off" />
        </label>

        <p>
              <input type="checkbox" id="filled-in-box"/>
              <label for="filled-in-box">Remember me</label>
          </p>
        <div class="login-item"><a class="button btn-fb btn-1 btn-success">Login as</a></div>
        <div class="login-item"><a class="dropdown button arrow-only btn-fb btn-2 btn-success" type="button" data-toggle="example-dropdown" data-options="align:down">
            <span class="show-for-sr">Show menu</span>
        </a></div>

        <ul id="example-dropdown" class="f-dropdown dropdown-pane dropdown-menu" data-dropdown>
          <li><a><i class="fa fa-facebook-official"></i>  Facebook</a></li>
          <li><a><i class="fa fa-google-plus"></i>  Google</a></li>
        </ul>
        <div class="login-item"><a class="button btn-fb">Forgot Password</a></div>
        <a href="/login/facebook" class="button btn-fb">login as facebook</a>
        <a href="/login/google" class="button btn-fb">login as gmail</a>
        <button class="button">Login</button>
      </form>
  </div>
@stop