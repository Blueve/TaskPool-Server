@extends('layouts.base')

@section('content')
  <div class="col-md-4 col-md-offset-4 column">
    {{-- 找回密码 --}}
    @include('layouts.pageheader')
    <form role="form" method="post" id="setpsw_form" action="{{{ URL::action('UserController@setnewpassword') }}}">
      <div class="form-group">
         <label for="password">新密码</label><input type="password" class="form-control" id="password" name="password" />
      </div>
      <div class="form-group">
         <label for="passwordConfirm">新密码确认</label><input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" />
      </div>
      <input type="hidden" id="userId" name="userId" value="{{{ $userId }}}" />
      <input type="hidden" id="checkCode" name="checkCode" value="{{{ $checkCode }}}" />
      <div class="form-group">
        <button type="submit" class="btn btn-lg btn-primary btn-block">提交</button>
      </div>
    </form>
  </div>
@stop