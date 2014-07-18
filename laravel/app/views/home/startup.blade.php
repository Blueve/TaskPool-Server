@extends('layouts.base')

@section('content')
  <div class="col-md-4 col-md-offset-4 column">
    {{-- 登录表单 --}}
    <form role="form" method="post" id="signin_form" action="{{{ URL::action('UserController@signin') }}}">
      <div class="form-group">
         <label for="userId">用户名/Email</label><input type="text" class="form-control" id="userId" />
      </div>
      <div class="form-group">
         <label for="password">密码</label><input type="password" class="form-control" id="password" />
      </div>
      <div class="form-group">
        <div class="row">
          <div class='col-md-6'>
            <label><input type="checkbox" class="checkbox-normal" id="rememberMe"/> 记住我</label>
          </div>
          <div class='col-md-6'>
            <strong>
              <a href="{{{ URL::action('HomeController@startup') }}}"> 忘记密码？</a>
            </strong>
          </div>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-lg btn-primary btn-block">登录</button>
        <button type="button" class="btn btn-default btn-lg btn-block" id="signup_button">注册</button>
      </div>
    </form>
    {{-- 注册表单 --}}
    <form role="form" method="post" id="signup_form" action="{{{ URL::action('UserController@signup') }}}">
      <div class="form-group">
         <label for="email">Email</label><input type="email" class="form-control" id="email" name="email"/>
      </div>
      <div class="form-group">
         <label for="name">用户名</label><input type="text" class="form-control" id="name" name="name"/>
      </div>
      <div class="form-group">
         <label for="password">密码</label><input type="password" class="form-control" id="password" name="password"/>
      </div>
      <div class="form-group">
         <label for="passwordConfirm">密码确认</label><input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm"/>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-lg btn-primary btn-block">注册</button>
        <button type="button" class="btn btn-default btn-lg btn-block" id="signin_button">登录</button>
      </div>
    </form>
  </div>
@stop