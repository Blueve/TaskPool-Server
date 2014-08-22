@extends('layouts.base')

@section('content')
  <div class="col-md-4 col-md-offset-4 column">
    @include('layouts.pageheader')
    {{-- 编辑个人信息 --}}
    <form role="form" method="post" id="setting_form" action="{{{ URL::action('UserController@setting_post') }}}">
      <div class="form-group">
         <label for="oldPassword">{{{ Lang::get('site.old_password') }}}</label><input type="password" class="form-control" id="oldPassword" name="oldPassword" />
      </div>
      <div class="form-group">
         <label for="password">{{{ Lang::get('site.new_password') }}}</label><input type="password" class="form-control" id="password" name="password" />
      </div>
      <div class="form-group">
         <label for="passwordConfirm">{{{ Lang::get('site.password_confirm') }}}</label><input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" />
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-lg btn-primary btn-block">{{{ Lang::get('site.submit_change') }}}</button>
      </div>
    </form>
  </div>
@stop