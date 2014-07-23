@extends('layouts.base')

@section('content')

  <div class="container">
    <div id="create_list" class="hidden">
        <form role="form" method="post">
          <div class="form-group" width="276px">
            <label class="sr-only" for="exampleInputPassword2">列表名</label>
            <input type="text" class="form-control" id="exampleInputPassword2" placeholder="列表名">
          </div>
          <button type="submit" class="btn btn-default btn-block">创建</button>
        </form>
    </div>

    <div class="row">
      <div class="col-md-11 col-md-offset-1 column">
        @include('layouts.pageheader')
        <ul class="nav nav-tabs" role="tablist">

          <li class="active" id='create_list_pop'>
            <a data-toggle="popover" href="#" >
              <span class="glyphicon glyphicon-plus"></span>
            </a>
          </li>

        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3 col-md-offset-1 column">
        <ul class="nav nav-pills nav-stacked">

          <li class="active">
            <a href="#">
              <span class="badge pull-right">42</span>
              今日
            </a>
          </li>
          <li>
            <a href="#">
              <span class="badge pull-right">0</span>
              本周
            </a>
          </li>
          <li>
            <a href="#">
              <span class="badge pull-right">0</span>
              本月
            </a>
          </li>
          <li>
            <a href="#">
              <span class="badge pull-right">0</span>
              待定
            </a>
          </li>

        </ul>
      </div>
      <div class="col-md-8 column">

      </div>
    </div>

  </div>
@stop