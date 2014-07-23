@extends('layouts.base')

@section('content')
  
  <div class="col-md-4 col-md-offset-4 column">
    {{-- 找回密码 --}}
    @include('layouts.pageheader')
    <form role="form" method="post" id="findpsw_form" action="{{{ URL::action('UserController@findpassword') }}}">
      <div class="form-group">
         <label for="email">注册时邮箱</label><input type="text" class="form-control" id="email" name="email" />
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-lg btn-primary btn-block">找回</button>
      </div>
    </form>
  </div>
@stop