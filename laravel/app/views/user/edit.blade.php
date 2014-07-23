@extends('layouts.base')

@section('content')
  @include('layouts.pageheader')
  <div class="col-md-4 col-md-offset-4 column">
    {{-- 编辑个人信息 --}}
    <form role="form" method="post" id="my_edit_form" action="{{{ URL::action('UserController@edit') }}}">
      <div class="form-group">
         <label for="oldPassword">原密码</label><input type="password" class="form-control" id="oldPassword" name="oldPassword" />
      </div>
      <div class="form-group">
         <label for="password">新密码</label><input type="password" class="form-control" id="password" name="password" />
      </div>
      <div class="form-group">
         <label for="passwordConfirm">新密码</label><input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" />
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-lg btn-primary btn-block">提交更改</button>
      </div>
    </form>
  </div>
@stop