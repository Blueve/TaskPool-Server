@extends('layouts.base')

@section('content')
  
  <div class="col-md-4 col-md-offset-4 column">
    {{-- 找回密码 --}}
    @include('layouts.pageheader')
    <form role="form" method="post" id="findpsw_form" action="{{{ URL::action('AccountController@findpassword') }}}">
      <div class="form-group">
         <label for="email">{{{ Lang::get('site.email') }}}</label><input type="text" class="form-control" id="email" name="email" />
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-lg btn-primary btn-block">{{{ Lang::get('site.find_password') }}}</button>
      </div>
    </form>
  </div>
@stop